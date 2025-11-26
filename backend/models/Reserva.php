<?php
require_once __DIR__ . '/../config/db.php';

class Reserva {

    public function crearReserva($data) {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO reservas 
            (usuario_id, nombre, email, fecha, hora, personas)
            VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "issssi",
            $data['usuario_id'],
            $data['nombre'],
            $data['email'],
            $data['fecha'],
            $data['hora'],
            $data['personas']
        );

        return $stmt->execute();
    }

    public function obtenerPorUsuario($usuario_id) {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM reservas WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerReservasUsuario($usuario_id) {
        return $this->obtenerPorUsuario($usuario_id);
    }

    public function cancelarReserva($id) {
        global $conn;

        $stmt = $conn->prepare("UPDATE reservas SET estado = 'Cancelada' WHERE id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
