<?php
header("Content-Type: application/json");

require_once '../controllers/UsuarioController.php';
require_once '../helpers/auth_session.php';
require_once '../helpers/roles.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // 🔵 Obtener usuarios
    case 'GET':
        // Admin puede ver todos, usuarios solo el suyo
        if ($_SESSION['rol'] == 1) {
            echo json_encode(UsuarioController::obtenerTodos());
        } else {
            $id = $_SESSION['usuario_id'];
            echo json_encode(UsuarioController::obtenerPorId($id));
        }
        break;

    // 🟢 Crear usuario (solo admin)
    case 'POST':
        require_role("admin");

        $nombre = $_POST['nombre'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $id_rol = $_POST['id_rol'] ?? 3;

        echo json_encode(UsuarioController::crear($nombre, $email, $password, $id_rol));
        break;

    // 🟡 Actualizar usuario
    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);

        $id = $_PUT['id'] ?? null;
        $nombre = $_PUT['nombre'] ?? null;
        $email = $_PUT['email'] ?? null;
        $password = $_PUT['password'] ?? null;
        $id_rol = $_PUT['id_rol'] ?? null;

        // Un usuario normal solo puede editar su propio perfil
        if ($_SESSION['rol'] != 1 && $_SESSION['usuario_id'] != $id) {
            echo json_encode(["error" => "No autorizado"]);
            exit;
        }

        echo json_encode(UsuarioController::actualizar($id, $nombre, $email, $password, $id_rol));
        break;

    // 🔴 Eliminar usuario (solo admin)
    case 'DELETE':
        require_role("admin");

        parse_str(file_get_contents("php://input"), $_DELETE);

        $id = $_DELETE['id'] ?? null;

        echo json_encode(UsuarioController::eliminar($id));
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}