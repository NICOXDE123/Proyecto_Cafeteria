<?php
require_once '../backend/helpers/auth.php'; 
require_once '../backend/config/db.php';
require_once '../backend/models/Producto.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = 'index.php';
$usuario = getCurrentUser();

$productoModel = new Producto();
$productosDestacados = $productoModel->obtenerDestacados();

$cafesSemana = array_slice($productosDestacados, 0, 2);

// Incluir header (tu header ya tiene <html>, <head>, <body>, navbar, etc.)
include __DIR__ . '/views/header.php';
?>

<!-- ===================================================== -->
<!--                     HERO SECTION                       -->
<!-- ===================================================== -->
<section class="hero-section bg-dark text-white">
    <div class="container">
        <div class="row align-items-center min-vh-80">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold mb-4">Marret Café</h1>
                <p class="lead mb-4">Café de especialidad y pastelería artesanal en el corazón de la ciudad</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="reservas.php" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-calendar-check me-2"></i>Reservar Mesa
                    </a>
                    <a href="menu.php" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-cup-hot me-2"></i>Ver Menú
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-image">
                    <i class="bi bi-cup-hot-fill text-warning" style="font-size: 15rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================================================== -->
<!--                PRODUCTOS DESTACADOS (ORIGINAL)         -->
<!-- ===================================================== -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-brown">Cafés de la Semana</h2>
            <p class="lead text-muted">Nuestra selección exclusiva recomendada por los baristas</p>
        </div>

        <div class="row g-4">
            <?php foreach ($cafesSemana as $producto): ?>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <?php if ($producto['imagen_url']): ?>
                        <img src="<?php echo $producto['imagen_url']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 100px;">
                            <i class="bi bi-cup-hot text-brown" style="font-size: 5rem;"></i>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <h4 class="card-title text-brown"><?php echo htmlspecialchars($producto['nombre']); ?></h4>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h4 text-primary">$<?php echo number_format($producto['precio'], 0); ?></span>
                            <a href="menu.php#producto-<?php echo $producto['id']; ?>" class="btn btn-outline-primary">
                                Ver Detalles
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===================================================== -->
<!--                SECCIONES PRINCIPALES                   -->
<!-- ===================================================== -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <i class="bi bi-cup-hot-fill text-brown display-4 mb-3"></i>
                        <h3 class="card-title h4 text-brown">Nuestro Menú</h3>
                        <p class="card-text text-muted">Descubre nuestra selección de cafés premium y bebidas especiales</p>
                        <a href="menu.php" class="btn btn-primary">Explorar Menú</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <i class="bi bi-cake2-fill text-brown display-4 mb-3"></i>
                        <h3 class="card-title h4 text-brown">Pastelería</h3>
                        <p class="card-text text-muted">Repostería artesanal elaborada diariamente con ingredientes frescos</p>
                        <a href="pasteleria.php" class="btn btn-primary">Ver Pastelería</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <i class="bi bi-calendar-check-fill text-brown display-4 mb-3"></i>
                        <h3 class="card-title h4 text-brown">Reservas</h3>
                        <p class="card-text text-muted">Reserva tu mesa y disfruta de la mejor experiencia en Delicia Café</p>
                        <a href="reservas.php" class="btn btn-primary">Hacer Reserva</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ===================================================== -->
<!--                        FOOTER                          -->
<!-- ===================================================== -->
<?php include __DIR__ . '/views/footer.php'; ?>
</body>
</html>
