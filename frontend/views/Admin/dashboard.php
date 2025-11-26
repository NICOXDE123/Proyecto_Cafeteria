<?php
session_start();
require_once '../../backend/helpers/roles.php';
requireAdmin(); // <--- Protección del rol Admin
?>

<?php require_once '../views/header.php'; ?>

<style>
    .admin-card {
        border-radius: 12px;
        transition: 0.2s;
    }
    .admin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .admin-icon {
        font-size: 45px;
        color: #8B4513;
    }
</style>

<div class="container py-5">

    <h1 class="mb-4 text-center">
        Panel de Administración
    </h1>

    <p class="text-center mb-5">
        Bienvenido <strong><?php echo $_SESSION['usuario']['nombre']; ?></strong>.
        Aquí puedes gestionar todo el sistema del café.
    </p>

    <div class="row g-4">

        <!-- Productos -->
        <div class="col-md-3">
            <a href="productos.php" class="text-decoration-none text-dark">
                <div class="card admin-card p-4 text-center">
                    <i class="bi bi-cup-hot admin-icon"></i>
                    <h5 class="mt-3">Productos</h5>
                    <p class="text-muted">Administrar productos del menú</p>
                </div>
            </a>
        </div>

        <!-- Categorías -->
        <div class="col-md-3">
            <a href="categorias.php" class="text-decoration-none text-dark">
                <div class="card admin-card p-4 text-center">
                    <i class="bi bi-tags admin-icon"></i>
                    <h5 class="mt-3">Categorías</h5>
                    <p class="text-muted">Gestionar categorías del café</p>
                </div>
            </a>
        </div>

        <!-- Usuarios -->
        <div class="col-md-3">
            <a href="usuarios.php" class="text-decoration-none text-dark">
                <div class="card admin-card p-4 text-center">
                    <i class="bi bi-people admin-icon"></i>
                    <h5 class="mt-3">Usuarios</h5>
                    <p class="text-muted">Administrar clientes, staff y admin</p>
                </div>
            </a>
        </div>

        <!-- Reservas -->
        <div class="col-md-3">
            <a href="reservas_admin.php" class="text-decoration-none text-dark">
                <div class="card admin-card p-4 text-center">
                    <i class="bi bi-calendar-check admin-icon"></i>
                    <h5 class="mt-3">Reservas</h5>
                    <p class="text-muted">Ver y gestionar reservas</p>
                </div>
            </a>
        </div>

    </div>

</div>

<?php require_once '../views/footer.php'; ?>