<?php
header("Content-Type: application/json");

require_once '../controllers/ProductoController.php';
require_once '../helpers/auth_session.php';
require_once '../helpers/roles.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        if (isset($_GET['id'])) {
            echo json_encode(ProductoController::obtenerPorId($_GET['id']));
        } else {
            echo json_encode(ProductoController::obtenerTodos());
        }
        break;

    case 'POST':
        require_role("admin"); 

        $nombre = $_POST['nombre'] ?? null;
        $descripcion = $_POST['descripcion'] ?? null;
        $precio = $_POST['precio'] ?? null;
        $stock = $_POST['stock'] ?? null;
        $id_categoria = $_POST['id_categoria'] ?? null;
        $imagen = $_POST['imagen'] ?? null;

        echo json_encode(ProductoController::crear($nombre, $descripcion, $precio, $stock, $id_categoria, $imagen));
        break;

    case 'PUT':
        require_role("admin");

        parse_str(file_get_contents("php://input"), $_PUT);

        $id = $_PUT['id'] ?? null;
        $nombre = $_PUT['nombre'] ?? null;
        $descripcion = $_PUT['descripcion'] ?? null;
        $precio = $_PUT['precio'] ?? null;
        $stock = $_PUT['stock'] ?? null;
        $id_categoria = $_PUT['id_categoria'] ?? null;
        $imagen = $_PUT['imagen'] ?? null;

        echo json_encode(ProductoController::actualizar($id, $nombre, $descripcion, $precio, $stock, $id_categoria, $imagen));
        break;

    case 'DELETE':
        require_role("admin");

        parse_str(file_get_contents("php://input"), $_DELETE);

        $id = $_DELETE['id'] ?? null;

        echo json_encode(ProductoController::eliminar($id));
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}