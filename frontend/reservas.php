<?php
session_start();
//require_once '../config/config.php';
// require_once '../models/Reserva.php';
// require_once '../includes/auth.php';

// $reservaModel = new Reserva();
// $error = '';
// $exito = '';

// Procesar reserva
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_reserva'])) {
    if (!isLoggedIn()) {
        $_SESSION['redirect_url'] = 'reservas.php';
        header('Location: login.php');
        exit;
    }
    
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $personas = filter_input(INPUT_POST, 'personas', FILTER_VALIDATE_INT);
    $comentarios = filter_input(INPUT_POST, 'comentarios', FILTER_SANITIZE_STRING);
    
    if ($nombre && $email && $fecha && $hora && $personas) {
        $reservaId = $reservaModel->crearReserva([
            'nombre_cliente' => $nombre,
            'correo' => $email,
            'fecha' => $fecha,
            'hora' => $hora,
            'personas' => $personas,
            'comentarios' => $comentarios,
            'usuario_id' => $_SESSION['usuario']['id']
        ]);
        
        if ($reservaId) {
            $_SESSION['notificacion'] = [
                'tipo' => 'exito',
                'mensaje' => "¡Reserva creada exitosamente! Número de reserva: #" . $reservaId
            ];
            header('Location: reservas.php');
            exit;
        } else {
            $error = 'Error al crear la reserva. Por favor intenta nuevamente.';
        }
    } else {
        $error = 'Por favor completa todos los campos requeridos.';
    }
}

// Obtener reservas del usuario si está logueado
// $misReservas = [];
// if (isLoggedIn()) {
   // $misReservas = $reservaModel->obtenerReservasUsuario($_SESSION['usuario']['id']);
// }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - Marret Café</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <?php include 'views/header.php'; ?>

    <!-- Hero Section Reservas -->
    <section class="hero-section-reservas text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50 py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Reserva tu Mesa</h1>
                    <p class="lead mb-4">Asegura tu lugar y disfruta de la mejor experiencia en Delicia Café</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i><?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card shadow border-0">
                        <div class="card-header bg-brown text-white py-3">
                            <h4 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Nueva Reserva</h4>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" id="form-reserva">
                                <input type="hidden" name="crear_reserva" value="1">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre Completo *</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" required
                                                   value="<?php echo isLoggedIn() ? htmlspecialchars($_SESSION['usuario']['nombre']) : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control" id="email" name="email" required
                                                   value="<?php echo isLoggedIn() ? htmlspecialchars($_SESSION['usuario']['email']) : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fecha" class="form-label">Fecha *</label>
                                            <input type="date" class="form-control" id="fecha" name="fecha" required 
                                                   min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hora" class="form-label">Hora *</label>
                                            <select class="form-select" id="hora" name="hora" required>
                                                <option value="">Selecciona hora</option>
                                                <option value="08:00">08:00 AM</option>
                                                <option value="09:00">09:00 AM</option>
                                                <option value="10:00">10:00 AM</option>
                                                <option value="11:00">11:00 AM</option>
                                                <option value="12:00">12:00 PM</option>
                                                <option value="13:00">01:00 PM</option>
                                                <option value="14:00">02:00 PM</option>
                                                <option value="15:00">03:00 PM</option>
                                                <option value="16:00">04:00 PM</option>
                                                <option value="17:00">05:00 PM</option>
                                                <option value="18:00">06:00 PM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="personas" class="form-label">Número de Personas *</label>
                                    <select class="form-select" id="personas" name="personas" required>
                                        <option value="">Selecciona cantidad</option>
                                        <?php for($i = 1; $i <= 8; $i++): ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?> persona<?php echo $i > 1 ? 's' : ''; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="comentarios" class="form-label">Comentarios Adicionales</label>
                                    <textarea class="form-control" id="comentarios" name="comentarios" rows="3" 
                                              placeholder="Alergias, requerimientos especiales, celebración especial, etc."></textarea>
                                </div>
                                
                                <?php if (!isLoggedIn()): ?>
                                    <div class="alert alert-warning">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Debes <a href="login.php" class="alert-link">iniciar sesión</a> para realizar una reserva.
                                    </div>
                                <?php else: ?>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-calendar-check me-2"></i>Confirmar Reserva
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mis Reservas -->
            <?php if (isLoggedIn() && !empty($misReservas)): ?>
            <div class="row mt-5">
                <div class="col-lg-10 mx-auto">
                    <div class="card shadow border-0">
                        <div class="card-header bg-brown text-white py-3">
                            <h4 class="mb-0"><i class="bi bi-clock-history me-2"></i>Mis Reservas</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th># Reserva</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Personas</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($misReservas as $reserva): ?>
                                        <tr>
                                            <td><strong>#<?php echo $reserva['id']; ?></strong></td>
                                            <td><?php echo date('d/m/Y', strtotime($reserva['fecha'])); ?></td>
                                            <td><?php echo $reserva['hora']; ?></td>
                                            <td><?php echo $reserva['personas']; ?></td>
                                            <td>
                                                <span class="badge estado-<?php echo strtolower($reserva['estado']); ?>">
                                                    <?php echo $reserva['estado']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($reserva['estado'] === 'Pendiente'): ?>
                                                    <form method="POST" action="cancelar_reserva.php" class="d-inline">
                                                        <input type="hidden" name="reserva_id" value="<?php echo $reserva['id']; ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('¿Estás seguro de cancelar esta reserva?')">
                                                            <i class="bi bi-x-circle me-1"></i>Cancelar
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'views/footer.php'; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    
    <script>
    // Validación de fecha (no permitir días pasados)
    document.getElementById('fecha').min = new Date().toISOString().split('T')[0];
    </script>
</body>
</html>