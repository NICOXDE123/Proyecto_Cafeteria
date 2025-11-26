<?php
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../config/db.php';

class CategoriaController
{
    public static function obtenerTodas()
    {
        return Categoria::obtenerCategorias();
    }

    public static function obtenerPorId($id)
    {
        return Categoria::obtenerCategoria($id);
    }

    public static function crear($nombre, $descripcion)
    {
        return Categoria::crearCategoria($nombre, $descripcion);
    }

    public static function actualizar($id, $nombre, $descripcion)
    {
        return Categoria::actualizarCategoria($id, $nombre, $descripcion);
    }

    public static function eliminar($id)
    {
        return Categoria::eliminarCategoria($id);
    }
}