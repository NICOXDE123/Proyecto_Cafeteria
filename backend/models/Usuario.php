<?php
require_once __DIR__ . '/../config/db.php';

class Usuario {

    /**
     * Buscar usuario por email
     */
    public function buscarPorEmail($email) {
        global $conn;

        $sql = "SELECT u.*, r.nombre AS rol_tipo 
                FROM usuarios u
                LEFT JOIN roles r ON u.rol_id = r.id
                WHERE u.email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Verificar si un email ya existe (para registro)
     */
    public function existeEmail($email) {
        global $conn;

        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    /**
     * Registrar usuario nuevo
     */
    public function registrar($data) {
        global $conn;

        $hash = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre, email, password_hash, rol_id)
                VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssi",
            $data['nombre'],
            $data['email'],
            $hash,
            $data['rol_id']
        );

        return $stmt->execute();
    }

    /**
     * Iniciar sesión (por compatibilidad)
     */
    public function iniciarSesion($email, $password) {
        $usuario = $this->buscarPorEmail($email);

        if (!$usuario) {
            return false;
        }

        if (!password_verify($password, $usuario['password_hash'])) {
            return false;
        }

        return $usuario;
    }
}
