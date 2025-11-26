<?php
header("Content-Type: application/json");

require_once '../controllers/CategoriaController.php';
require_once '../helpers/auth_session.php';
require_once '../helpers/roles.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        if (isset($_GET['id'])) {
            echo json_encode(CategoriaController::obtenerPorId($_GET['id']));
        } else {
            echo json_encode(CategoriaController::obtenerTodas());
        }
        break;

    case 'POST':
        require_role("admin"); 

        $nombre = $_POST['nombre'] ?? null;
        $descripcion = $_POST['descripcion'] ?? null;

        echo json_encode(CategoriaController::crear($nombre, $descripcion));
        break;

    case 'PUT':
        require_role("admin");

        parse_str(file_get_contents("php://input"), $_PUT);

        $id = $_PUT['id'] ?? null;
        $nombre = $_PUT['nombre'] ?? null;
        $descripcion = $_PUT['descripcion'] ?? null;

        echo json_encode(CategoriaController::actualizar($id, $nombre, $descripcion));
        break;

    case 'DELETE':
        require_role("admin");

        parse_str(file_get_contents("php://input"), $_DELETE);

        $id = $_DELETE['id'] ?? null;

        echo json_encode(CategoriaController::eliminar($id));
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}