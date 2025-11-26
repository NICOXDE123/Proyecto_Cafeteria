<?php
session_start();
require_once '../backend/config/db.php';
require_once '../backend/helpers/auth.php';

$exito = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitización moderna
    $nombre  = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email   = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $asunto  = htmlspecialchars(trim($_POST['asunto'] ?? ''), ENT_QUOTES, 'UTF-8');
    $mensaje = htmlspecialchars(trim($_POST['mensaje'] ?? ''), ENT_QUOTES, 'UTF-8');

    if ($nombre && $email && $asunto && $mensaje) {
        // Simular envío de email
        $exito = "¡Tu mensaje ha sido enviado exitosamente! Nos pondremos en contacto pronto.";
    } else {
        $error = "Por favor completa todos los campos correctamente.";
    }

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Marret Café</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <?php include 'views/header.php'; ?>

    <!-- Hero Section Contacto -->
    <section class="hero-section-contacto text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50 py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Contáctanos</h1>
                    <p class="lead mb-4">Estamos aquí para responder todas tus preguntas y escuchar tus sugerencias</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Información de Contacto -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="card-title text-brown mb-4">Información de Contacto</h3>
                            
                            <div class="contact-info-item mb-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-geo-alt-fill text-brown fs-4 me-3 mt-1"></i>
                                    <div>
                                        <h5 class="fw-bold">Dirección</h5>
                                        <p class="mb-0">Av. Principal 123<br>Santiago, Chile</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-info-item mb-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-telephone-fill text-brown fs-4 me-3 mt-1"></i>
                                    <div>
                                        <h5 class="fw-bold">Teléfono</h5>
                                        <p class="mb-0">+56 9 1234 5678</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-info-item mb-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-envelope-fill text-brown fs-4 me-3 mt-1"></i>
                                    <div>
                                        <h5 class="fw-bold">Email</h5>
                                        <p class="mb-0">contacto@deliciacafe.cl</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-info-item">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-clock-fill text-brown fs-4 me-3 mt-1"></i>
                                    <div>
                                        <h5 class="fw-bold">Horario de Atención</h5>
                                        <p class="mb-0">
                                            Lunes a Viernes: 7:00 - 20:00<br>
                                            Sábados: 8:00 - 18:00<br>
                                            Domingos: 9:00 - 16:00
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="social-links">
                                <h6 class="fw-bold mb-3">Síguenos en:</h6>
                                <div class="d-flex gap-3">
                                    <a href="#" class="text-brown fs-4">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    <a href="#" class="text-brown fs-4">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                    <a href="#" class="text-brown fs-4">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Formulario de Contacto -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="card-title text-brown mb-4">Envíanos un Mensaje</h3>
                            
                            <?php if ($exito): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-2"></i><?php echo $exito; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($error): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i><?php echo $error; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre Completo *</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" required
                                                   value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control" id="email" name="email" required
                                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="asunto" class="form-label">Asunto *</label>
                                    <input type="text" class="form-control" id="asunto" name="asunto" required
                                           value="<?php echo isset($_POST['asunto']) ? htmlspecialchars($_POST['asunto']) : ''; ?>">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="mensaje" class="form-label">Mensaje *</label>
                                    <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required
                                              placeholder="Escribe tu mensaje aquí..."><?php echo isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : ''; ?></textarea>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-send me-2"></i>Enviar Mensaje
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
    </section>

    <?php include 'views/footer.php'; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
</body>
</html>