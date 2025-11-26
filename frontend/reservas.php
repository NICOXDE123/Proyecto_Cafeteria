<?php
session_start();
require_once '../backend/config/db.php';
require_once '../backend/models/Reserva.php';
require_once '../backend/helpers/auth.php';

$error = '';
$exito = '';

$reservaModel = new Reserva();

// Verificar login
if (!isLoggedIn()) {
    $_SESSION['redirect_url'] = 'reservas.php';
    header('Location: login.php');
    exit;
}

/* =======================================================
   CANCELAR RESERVA (ANTES DEL HTML)
   ======================================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelar_id'])) {

    $id = intval($_POST['cancelar_id']);

    if ($reservaModel->cancelarReserva($id)) {
        header("Location: reservas.php?cancelada=1");
        exit;
    } else {
        $error = "Error al cancelar la reserva.";
    }
}

/* =======================================================
   CREAR RESERVA (ANTES DEL HTML)
   ======================================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_reserva'])) {

    // Datos del formulario
    $nombre    = trim($_POST['nombre'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $fecha     = $_POST['fecha'] ?? '';
    $hora      = $_POST['hora'] ?? '';
    $personas  = intval($_POST['personas'] ?? 1);

    // Validación
    if ($nombre === '' || $email === '' || $fecha === '' || $hora === '') {
        $error = 'Por favor completa todos los campos requeridos.';
    } else {

        $data = [
            'nombre'      => $nombre,
            'email'       => $email,
            'fecha'       => $fecha,
            'hora'        => $hora,
            'personas'    => $personas,
            'usuario_id'  => $_SESSION['usuario']['id']
        ];

        if ($reservaModel->crearReserva($data)) {
            header("Location: reservas.php?ok=1");
            exit;
        } else {
            $error = 'Error al crear la reserva. Intenta nuevamente.';
        }
    }
}

// Obtener reservas del usuario
$misReservas = $reservaModel->obtenerReservasUsuario($_SESSION['usuario']['id']);

// Incluir header
require_once './views/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - Marret Café</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="assets/css/custom.css" rel="stylesheet">
</head>

<body>
<?php include 'views/header.php'; ?>

<!-- Hero -->
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

    <!-- MENSAJES -->
    <?php if (isset($_GET['ok'])): ?>
        <div class="alert alert-success">¡Reserva creada exitosamente!</div>
    <?php endif; ?>

    <?php if (isset($_GET['cancelada'])): ?>
        <div class="alert alert-warning">Reserva cancelada correctamente.</div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>


    <!-- FORMULARIO -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow border-0">
                <div class="card-header bg-brown text-white py-3">
                    <h4 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Nueva Reserva</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST">
                        <input type="hidden" name="crear_reserva" value="1">

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Nombre *</label>
                                <input type="text" class="form-control" name="nombre" required 
                                       value="<?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required 
                                       value="<?= htmlspecialchars($_SESSION['usuario']['email']) ?>">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Fecha *</label>
                                <input type="date" class="form-control" name="fecha" required 
                                       min="<?= date('Y-m-d') ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Hora *</label>
                                <select class="form-select" name="hora" required>
                                    <option value="">Selecciona hora</option>
                                    <?php 
                                    $horas = ["08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00"];
                                    foreach ($horas as $h): ?>
                                        <option value="<?= $h ?>"><?= $h ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Personas *</label>
                            <select class="form-select" name="personas" required>
                                <option value="">Selecciona</option>
                                <?php for ($i=1;$i<=8;$i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?> persona<?= $i>1?'s':'' ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-calendar-check me-2"></i>Confirmar Reserva
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- MIS RESERVAS -->
    <?php if (!empty($misReservas)): ?>
    <div class="row mt-5">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow border-0">
                <div class="card-header bg-brown text-white">
                    <h4><i class="bi bi-clock-history me-2"></i>Mis Reservas</h4>
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

                            <?php foreach ($misReservas as $reserva): ?>
                                <tr>
                                    <td><strong>#<?= $reserva['id']; ?></strong></td>
                                    <td><?= date('d/m/Y', strtotime($reserva['fecha'])); ?></td>
                                    <td><?= $reserva['hora']; ?></td>
                                    <td><?= $reserva['personas']; ?></td>
                                    <td>
                                        <span class="badge estado-<?= strtolower($reserva['estado']); ?>">
                                            <?= $reserva['estado']; ?>
                                        </span>
                                    </td>
                                    <td>

                                        <?php if ($reserva['estado'] === 'Pendiente'): ?>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="cancelar_id" value="<?= $reserva['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Cancelar esta reserva?');">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('fecha').min = new Date().toISOString().split('T')[0];
</script>
</body>
</html>
