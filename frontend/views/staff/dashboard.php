<?php
session_start();
require_once '../../backend/helpers/auth.php';
require_once '../../backend/helpers/role.php';
requireRole("staff");
?>

<?php require_once '../header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Panel del Staff</h1>

    <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action">📅 Reservas del día</a>
        <a href="#" class="list-group-item list-group-item-action">📦 Ver Productos</a>
    </div>
</div>

<?php require_once '../footer.php'; ?>
