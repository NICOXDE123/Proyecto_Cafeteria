<?php
require_once '../models/Carrito.php';

class CarritoController {

    public static function obtener($usuario_id) {
        return Carrito::obtenerCarrito($usuario_id);
    }

    public static function agregar($usuario_id, $producto_id, $cantidad) {
        return Carrito::agregarProducto($usuario_id, $producto_id, $cantidad);
    }

    public static function eliminar($id) {
        return Carrito::eliminarDelCarrito($id);
    }
}
