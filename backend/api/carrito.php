<?php
header("Content-Type: application/json");

require_once '../backend/controllers/CarritoController.php';
require_once '../backend/helpers/auth_session.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        // Ver carrito del usuario logueado
        $id_usuario = $_SESSION['usuario_id'];
        echo json_encode(CarritoController::obtenerPorUsuario($id_usuario));
        break;

    case 'POST':
        // Agregar producto al carrito
        $id_usuario = $_SESSION['usuario_id'];
        $id_producto = $_POST['id_producto'] ?? null;
        $cantidad = $_POST['cantidad'] ?? 1;

        echo json_encode(CarritoController::agregar($id_usuario, $id_producto, $cantidad));
        break;

    case 'DELETE':
        // Eliminar un ítem del carrito
        parse_str(file_get_contents("php://input"), $_DELETE);

        $id = $_DELETE['id'] ?? null;

        echo json_encode(CarritoController::eliminar($id));
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}