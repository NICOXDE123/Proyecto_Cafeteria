<?php
 session_start();
 $current_page = basename($_SERVER['PHP_SELF']);
 $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marret Café</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-brown fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-cup-hot me-2"></i>Marret Café
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">
                            <i class="bi bi-house me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'menu.php') ? 'active' : ''; ?>" href="menu.php">
                            <i class="bi bi-cup-hot me-1"></i>Menú
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'pasteleria.php') ? 'active' : ''; ?>" href="pasteleria.php">
                            <i class="bi bi-cake2 me-1"></i>Pastelería
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'reservas.php') ? 'active' : ''; ?>" href="reservas.php">
                            <i class="bi bi-calendar-check me-1"></i>Reservas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'contacto.php') ? 'active' : ''; ?>" href="contacto.php">
                            <i class="bi bi-envelope me-1"></i>Contacto
                        </a>
                    </li>
                </ul>
                
                <div class="navbar-nav">
                    <?php if ($usuario): ?>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i><?php echo htmlspecialchars($usuario['nombre']); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-item-text small text-muted">Rol: <?php echo $usuario['rol_tipo']; ?></span></li>
                                <li><hr class="dropdown-divider"></li>
                                <?php if ($usuario['rol_tipo'] === 'Admin' || $usuario['rol_tipo'] === 'Staff'): ?>
                                    <li><a class="dropdown-item" href="../backend/"><i class="bi bi-speedometer2 me-2"></i>Panel Admin</a></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="reservas.php"><i class="bi bi-calendar-check me-2"></i>Mis Reservas</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="?logout=true"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="nav-link me-3" href="login.php">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión
                        </a>
                        <a class="btn btn-outline-light btn-sm" href="registro.php">
                            Registrarse
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Espacio para el navbar fixed -->
    <div style="height: 76px;"></div>