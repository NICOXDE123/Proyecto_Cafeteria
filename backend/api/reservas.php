<?php
header("Content-Type: application/json");

require_once '../controllers/ReservaController.php';
require_once '../helpers/auth_session.php';
require_once '../helpers/roles.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // 🔵 Obtener reservas
    case 'GET':
        if (isset($_SESSION['rol']) && ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)) {
            // Admin o Staff → Todas las reservas
            echo json_encode(ReservaController::obtenerTodas());
        } else {
            // Cliente → Solo sus reservas
            $id_usuario = $_SESSION['usuario_id'];
            echo json_encode(ReservaController::obtenerPorUsuario($id_usuario));
        }
        break;

    // 🟢 Crear reserva
    case 'POST':
        $id_usuario = $_SESSION['usuario_id'];
        $fecha = $_POST['fecha'] ?? null;
        $hora = $_POST['hora'] ?? null;
        $cantidad_personas = $_POST['cantidad_personas'] ?? null;
        $comentario = $_POST['comentario'] ?? "";

        echo json_encode(ReservaController::crear(
            $id_usuario,
            $fecha,
            $hora,
            $cantidad_personas,
            $comentario
        ));

        break;

    // 🔴 Eliminar reserva
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);

        $id = $_DELETE['id'] ?? null;

        // Solo el dueño de la reserva o admin/staff
        if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
            echo json_encode(ReservaController::eliminar($id));
        } else {
            echo json_encode(["error" => "No puedes eliminar reservas ajenas"]);
        }
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}