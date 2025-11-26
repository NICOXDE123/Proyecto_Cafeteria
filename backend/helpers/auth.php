<?php
// Iniciar sesión si aún no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica si hay un usuario autenticado en la sesión.
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['usuario']) && !empty($_SESSION['usuario']);
}

/**
 * Devuelve el usuario actual autenticado o null si no hay sesión.
 */
function getCurrentUser(): ?array
{
    return $_SESSION['usuario'] ?? null;
}