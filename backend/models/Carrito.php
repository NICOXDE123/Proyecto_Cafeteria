<?php
require_once __DIR__ . '/../config/db.php';

class Carrito {

    // Obtener productos del carrito de un usuario
    public static function obtenerCarrito($usuario_id) {
        global $conn;

        $sql = "SELECT c.id, c.cantidad, p.nombre, p.precio, p.imagen_url
                FROM carrito c
                JOIN productos p ON c.producto_id = p.id
                WHERE c.usuario_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Buscar si un producto ya está en el carrito
    public static function buscarProducto($usuario_id, $producto_id) {
        global $conn;

        $sql = "SELECT * FROM carrito WHERE usuario_id = ? AND producto_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $usuario_id, $producto_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Agregar producto al carrito
    public static function agregarProducto($usuario_id, $producto_id, $cantidad) {
        global $conn;

        $sql = "INSERT INTO carrito (usuario_id, producto_id, cantidad)
                VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $usuario_id, $producto_id, $cantidad);
        return $stmt->execute();
    }

    // Actualizar cantidad si el producto ya existe
    public static function actualizarCantidad($usuario_id, $producto_id, $cantidad) {
        global $conn;

        $sql = "UPDATE carrito SET cantidad = cantidad + ? 
                WHERE usuario_id = ? AND producto_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $cantidad, $usuario_id, $producto_id);
        return $stmt->execute();
    }

    // Eliminar un item del carrito
    public static function eliminarDelCarrito($id) {
        global $conn;

        $sql = "DELETE FROM carrito WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
