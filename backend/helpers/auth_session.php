<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario NO está logueado
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al login
    header("Location: ../frontend/login.php");
    exit();
}
?>
<?php
require_once '../helpers/auth_session.php';

if ($_SESSION['rol'] != 1) {  // 1 = Admin
    echo "Acceso denegado";
    exit();
}
?>
<?php
require_once '../helpers/auth_session.php';

if ($_SESSION['rol'] != 2) { // 2 = Staff
    echo "Acceso denegado";
    exit();
}
?>