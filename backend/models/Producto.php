<?php
require_once __DIR__ . '/../config/db.php';

class Producto {

    public function obtenerDestacados() {
        global $conn;

        $sql = "SELECT * FROM productos ORDER BY id DESC LIMIT 8";
        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPorCategoria($categoria_id) {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM productos WHERE id_categoria = ?");
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerTodos() {
        global $conn;

        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
