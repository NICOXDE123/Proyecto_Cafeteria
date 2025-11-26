<?php
require_once __DIR__ . '/../config/db.php';

class Rol {

    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Obtener todos los roles
    public function obtenerTodos() {
        $sql = "SELECT * FROM roles ORDER BY id ASC";
        $result = $this->conn->query($sql);

        $roles = [];
        if ($result) {
            while ($fila = $result->fetch_assoc()) {
                $roles[] = $fila;
            }
        }
        return $roles;
    }

    // Obtener un rol por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM roles WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    // Obtener un rol por nombre
    public function obtenerPorNombre($nombre) {
        $sql = "SELECT * FROM roles WHERE nombre = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
}
