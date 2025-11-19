<?php
// session_start();
// require_once '../config/config.php';
// require_once '../models/Usuario.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    
    $usuarioModel = new Usuario();
    
    if ($email && $password) {
        $usuario = $usuarioModel->iniciarSesion($email, $password);
        
        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            
            $_SESSION['notificacion'] = [
                'tipo' => 'exito',
                'mensaje' => '¡Inicio de sesión exitoso! Bienvenido a Delicia Café.'
            ];
            
            // Redirigir según el rol
            if ($usuario['rol_tipo'] === 'Admin' || $usuario['rol_tipo'] === 'Staff') {
                $redirect = '../backend/index.php';
            } else {
                $redirect = $_SESSION['redirect_url'] ?? 'index.php';
                unset($_SESSION['redirect_url']);
            }
            
            header('Location: ' . $redirect);
            exit;
        } else {
            $error = 'Email o contraseña incorrectos';
        }
    } else {
        $error = 'Por favor completa todos los campos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Marret Café</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <?php include 'views/header.php'; ?>

    <section class="py-5 bg-light min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow border-0">
                        <div class="card-header bg-brown text-white text-center py-4">
                            <h3 class="mb-0"><i class="bi bi-cup-hot me-2"></i>Iniciar Sesión</h3>
                        </div>
                        <div class="card-body p-4">
                            <?php if ($error): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i><?php echo $error; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" id="email" name="email" required 
                                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                               placeholder="tu@email.com">
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password" name="password" required
                                               placeholder="Ingresa tu contraseña">
                                    </div>
                                </div>
                                
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                                    </button>
                                </div>
                                
                                <div class="text-center">
                                    <p class="mb-0">¿No tienes cuenta? 
                                        <a href="registro.php" class="text-brown fw-bold">Regístrate aquí</a>
                                    </p>
                                </div>
                            </form>
                            
                            <hr class="my-4">
                            
                            <div class="text-center">
                                <small class="text-muted">
                                    <strong>Credenciales de prueba:</strong><br>
                                    Cliente: cliente@deliciacafe.cl / password<br>
                                    Staff: staff@deliciacafe.cl / password<br>
                                    Admin: admin@deliciacafe.cl / password
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'views/footer.php'; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>