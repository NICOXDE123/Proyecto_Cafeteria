<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if ($email && $password) {

        $apiUrl = "http://localhost/UML_Cafeteria/backend/api/auth.php";

        $data = [
            'email' => $email,
            'password' => $password
        ];

        $options = [
            "http" => [
                "header"  => "Content-Type: application/json\r\n",
                "method"  => "POST",
                "content" => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($apiUrl, false, $context);

        $result = json_decode($response, true);

        if (isset($result['success']) && $result['success'] === true) {

            $_SESSION['usuario'] = $result['usuario'];

            // Rol REAL desde la BD
            $rol = $result['usuario']['rol_id'];

            if ($rol == 3) {
                header("Location: admin/dashboard.php");
            } elseif ($rol == 2) {
                header("Location: staff/dashboard.php");
            } else {
                header("Location: index.php");
            }

            exit();

        } else {
            $error = "Credenciales incorrectas";
        }

    } else {
        $error = "Todos los campos son obligatorios";
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
                            <!-- reemplaza el formulario existente por este -->
                            <form action="login.php" method="POST">
                                 <div class="mb-3">
                                     <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label">Contraseña</label>
                                         <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                      <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                                </button>
                                    </div>
                                 </form>
                              

                            
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