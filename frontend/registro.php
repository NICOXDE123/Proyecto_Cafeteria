<?php
session_start();
require_once '../backend/config/db.php';
require_once '../backend/models/Usuario.php';
require_once '../backend/models/Rol.php';

$error = '';
$exito = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitizar datos (compatible con PHP 8)
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);
    $confirmar_password = trim($_POST['confirmar_password']);

    // Validar campos vacíos
    if (!$nombre || !$email || !$password || !$confirmar_password) {
        $error = "Todos los campos son obligatorios.";
    } elseif ($password !== $confirmar_password) {
        $error = "Las contraseñas no coinciden.";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } else {

        // Instanciar el modelo
        $usuarioModel = new Usuario();

        // Verificar si email existe
        if ($usuarioModel->existeEmail($email)) {
            $error = "Este correo ya está registrado.";
        } else {
            // Registrar usuario
            $data = [
                'nombre' => $nombre,
                'email' => $email,
                'password' => $password,
                'rol_id' => 1  // cliente
            ];

            if ($usuarioModel->registrar($data)) {
                $exito = true;
            } else {
                $error = "Error al registrar usuario. Intenta más tarde.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Marret Café</title>
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
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow border-0">
                        <div class="card-header bg-brown text-white text-center py-4">
                            <h3 class="mb-0"><i class="bi bi-person-plus me-2"></i>Crear Cuenta</h3>
                        </div>
                        <div class="card-body p-4">
                            <?php if ($error): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <?php echo strip_tags($error, '<a>'); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($exito): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-2"></i><?php echo $exito; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" id="form-registro">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre Completo *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-person"></i>
                                                </span>
                                                <input type="text" class="form-control" id="nombre" name="nombre" required 
                                                       value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>"
                                                       placeholder="Tu nombre completo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-envelope"></i>
                                                </span>
                                                <input type="email" class="form-control" id="email" name="email" required
                                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                                       placeholder="tu@email.com">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Contraseña *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-lock"></i>
                                                </span>
                                                <input type="password" class="form-control" id="password" name="password" required
                                                       placeholder="Mínimo 6 caracteres">
                                            </div>
                                            <div class="form-text">La contraseña debe tener al menos 6 caracteres.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="confirmar_password" class="form-label">Confirmar Contraseña *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-lock-fill"></i>
                                                </span>
                                                <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required
                                                       placeholder="Repite tu contraseña">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terminos" required>
                                        <label class="form-check-label" for="terminos">
                                            Acepto los <a href="#" class="text-brown">términos y condiciones</a> y la <a href="#" class="text-brown">política de privacidad</a>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-person-plus me-2"></i>Crear Cuenta
                                    </button>
                                </div>
                                
                                <div class="text-center">
                                    <p class="mb-0">¿Ya tienes cuenta? 
                                        <a href="login.php" class="text-brown fw-bold">Inicia sesión aquí</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'views/footer.php'; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Validación de contraseñas
    document.getElementById('form-registro').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmar = document.getElementById('confirmar_password').value;
        
        if (password !== confirmar) {
            e.preventDefault();
            alert('Las contraseñas no coinciden. Por favor verifica.');
            return false;
        }
        
        if (password.length < 6) {
            e.preventDefault();
            alert('La contraseña debe tener al menos 6 caracteres.');
            return false;
        }
    });
    </script>
</body>
</html>