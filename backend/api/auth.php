<?php
require_once '../models/Usuario.php';

header('Content-Type: application/json');

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "mensaje" => "Método no permitido"]);
    exit;
}

// Obtener JSON desde el frontend
$input = json_decode(file_get_contents("php://input"), true);

$email = $input['email'] ?? null;
$password = $input['password'] ?? null;

if (!$email || !$password) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Email y contraseña son requeridos"
    ]);
    exit;
}

$usuarioModel = new Usuario();
$usuario = $usuarioModel->buscarPorEmail($email);

if (!$usuario) {
    echo json_encode([
        "success" => false,
        "mensaje" => "El correo no está registrado"
    ]);
    exit;
}

// Verificar contraseña
if (!password_verify($password, $usuario['password_hash'])) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Contraseña incorrecta"
    ]);
    exit;
}

// Login correcto → devolver usuario
session_start();
$_SESSION['usuario'] = $usuario;

echo json_encode([
    "success" => true,
    "usuario" => $usuario,
    "mensaje" => "Login correcto"
]);

exit;
