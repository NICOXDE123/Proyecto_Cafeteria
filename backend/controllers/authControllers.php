<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    public static function login($email, $password)
    {
        session_start();

        $usuario = Usuario::obtenerPorEmail($email);

        if (!$usuario) {
            return ["error" => "Credenciales incorrectas"];
        }

        if (!password_verify($password, $usuario['password'])) {
            return ["error" => "Credenciales incorrectas"];
        }

        // Guardar sesión
        $_SESSION['usuario_id'] = $usuario['id_usuario'];
        $_SESSION['rol'] = $usuario['id_rol'];
        $_SESSION['nombre'] = $usuario['nombre'];

        return ["success" => true, "rol" => $usuario['id_rol']];
    }

    public static function logout()
    {
        session_start();
        session_destroy();
        header("Location: ../frontend/login.php");
        exit();
    }
}
