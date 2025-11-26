<?php
session_start();

// Verifica si hay sesión activa
function isLoggedIn() {
    return isset($_SESSION['usuario']);
}

// Obtiene rol
function getRole() {
    return $_SESSION['usuario']['rol_id'] ?? null;
}

// Solo admin
function requireAdmin() {
    if (!isLoggedIn() || getRole() != 3) {
        header("Location: ../login.php");
        exit();
    }
}

// Solo staff
function requireStaff() {
    if (!isLoggedIn() || getRole() != 2) {
        header("Location: ../login.php");
        exit();
    }
}