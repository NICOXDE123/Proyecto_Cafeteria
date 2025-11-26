<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../config/db.php';

class ProductoController
{
    public static function obtenerTodos()
    {
        return Producto::obtenerProductos();
    }

    public static function obtenerPorId($id)
    {
        return Producto::obtenerProducto($id);
    }

    public static function crear($nombre, $descripcion, $precio, $stock, $id_categoria, $imagen)
    {
        return Producto::crearProducto($nombre, $descripcion, $precio, $stock, $id_categoria, $imagen);
    }

    public static function actualizar($id, $nombre, $descripcion, $precio, $stock, $id_categoria, $imagen)
    {
        return Producto::actualizarProducto($id, $nombre, $descripcion, $precio, $stock, $id_categoria, $imagen);
    }

    public static function eliminar($id)
    {
        return Producto::eliminarProducto($id);
    }
}