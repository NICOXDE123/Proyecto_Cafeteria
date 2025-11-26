<?php
require_once __DIR__ . '/../config/db.php';

class Categoria {

    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Obtener todas las categorías
    public function obtenerTodas() {
        $sql = "SELECT * FROM categorias ORDER BY nombre ASC";
        $result = $this->conn->query($sql);

        $categorias = [];
        if ($result) {
            while ($fila = $result->fetch_assoc()) {
                $categorias[] = $fila;
            }
        }
        return $categorias;
    }

    // Obtener una categoría por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM categorias WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    // Obtener por nombre
    public function obtenerPorNombre($nombre) {
        $sql = "SELECT * FROM categorias WHERE nombre = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
}