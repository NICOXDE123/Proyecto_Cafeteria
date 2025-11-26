<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/db.php';

class UsuarioController
{
    public static function obtenerTodos()
    {
        return Usuario::obtenerUsuarios();
    }

    public static function obtenerPorId($id)
    {
        return Usuario::obtenerUsuario($id);
    }

    public static function crear($nombre, $email, $password, $id_rol)
    {
        // Encriptar contraseña si el modelo no lo hace
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        return Usuario::crearUsuario($nombre, $email, $passwordHash, $id_rol);
    }

    public static function actualizar($id, $nombre, $email, $password, $id_rol)
    {
        $passwordHash = $password ? password_hash($password, PASSWORD_BCRYPT) : null;

        return Usuario::actualizarUsuario($id, $nombre, $email, $passwordHash, $id_rol);
    }

    public static function eliminar($id)
    {
        return Usuario::eliminarUsuario($id);
    }
}
