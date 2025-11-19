<?php
 //session_start();
// require_once '../config/config.php';
//require_once '../models/Producto.php';

//$productoModel = new Producto();
// $productosDestacados = $productoModel->obtenerDestacados();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marret Café - Inicio</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <?php include 'views/header.php'; ?>

    <!-- Hero Section con Fondo de Cafetería -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold text-white mb-4 animate-slide-up">Marret Café</h1>
                    <p class="lead text-white mb-4 animate-slide-up delay-1">Donde cada taza cuenta una historia y cada bocado es una experiencia</p>
                    <div class="d-flex gap-3 flex-wrap animate-slide-up delay-2">
                        <a href="reservas.php" class="btn btn-primary btn-lg px-4 py-3 shadow">
                            <i class="bi bi-calendar-check me-2"></i>Reservar Mesa
                        </a>
                        <a href="menu.php" class="btn btn-outline-light btn-lg px-4 py-3 shadow">
                            <i class="bi bi-cup-hot me-2"></i>Ver Menú
                        </a>
                    </div>
                    
                    <!-- Información rápida -->
                    <div class="row mt-5 text-white animate-fade-in delay-3">
                        <div class="col-sm-4 text-center">
                            <div class="info-item">
                                <i class="bi bi-clock display-6 text-warning mb-2"></i>
                                <p class="mb-0 fw-bold">Abierto hoy</p>
                                <small>7:00 - 20:00 hrs</small>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <div class="info-item">
                                <i class="bi bi-geo-alt display-6 text-warning mb-2"></i>
                                <p class="mb-0 fw-bold">Ubicación</p>
                                <small>Av. Principal 123</small>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <div class="info-item">
                                <i class="bi bi-star display-6 text-warning mb-2"></i>
                                <p class="mb-0 fw-bold">Calificación</p>
                                <small>⭐ 4.8/5</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 text-center animate-slide-left">
                    <!-- Tarjeta flotante con especialidad del día -->
                    <div class="floating-card">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body p-4">
                                <h5 class="card-title text-brown">
                                    <i class="bi bi-award-fill me-2"></i>Especialidad del Día
                                </h5>
                                <p class="card-text">Cappuccino Italiano con croissant recién horneado</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h4 text-primary mb-0">$4.500</span>
                                    <span class="badge bg-warning text-dark">¡Oferta!</span>
                                </div>
                                <small class="text-muted">Válido solo hoy</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="scroll-indicator">
            <a href="#productos-destacados" class="text-white">
                <i class="bi bi-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Productos Destacados -->
    <section id="productos-destacados" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-brown">Nuestras Delicias</h2>
                <p class="lead text-muted">Los favoritos de nuestros clientes</p>
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-8">
                        <div class="d-flex justify-content-center flex-wrap gap-3">
                            <span class="badge bg-brown text-white p-2"><i class="bi bi-cup-hot me-1"></i>Cafés Especiales</span>
                            <span class="badge bg-brown text-white p-2"><i class="bi bi-cake2 me-1"></i>Pastelería Artesanal</span>
                            <span class="badge bg-brown text-white p-2"><i class="bi bi-basket me-1"></i>Productos Frescos</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                <?php foreach($productosDestacados as $producto): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 product-card shadow-sm border-0">
                        <div class="card-img-container">
                            <?php if ($producto['imagen_url']): ?>
                                <img src="<?php echo $producto['imagen_url']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cup-hot text-brown" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-overlay">
                                <a href="menu.php#producto-<?php echo $producto['id']; ?>" class="btn btn-primary btn-sm">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-brown"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                            <p class="card-text text-muted flex-grow-1 small"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="h5 text-primary mb-0">$<?php echo number_format($producto['precio'], 2); ?></span>
                                <?php if (isLoggedIn()): ?>
                                    <form method="POST" action="agregar_carrito.php" class="d-inline">
                                        <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-outline-primary btn-sm" onclick="requiereLogin()">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-5">
                <a href="menu.php" class="btn btn-outline-brown btn-lg">
                    <i class="bi bi-menu-button-wide me-2"></i>Ver Menú Completo
                </a>
            </div>
        </div>
    </section>

    <!-- Por qué elegirnos -->
    <section class="py-5 bg-brown text-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">¿Por Qué Elegir Marret Café?</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-cup-hot display-4 text-warning"></i>
                    </div>
                    <h4>Café de Especialidad</h4>
                    <p class="mb-0">Granos seleccionados de las mejores regiones del mundo, tostados artesanalmente.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-cake2 display-4 text-warning"></i>
                    </div>
                    <h4>Pastelería Fresca</h4>
                    <p class="mb-0">Elaboramos diariamente nuestra repostería con ingredientes 100% naturales.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-heart display-4 text-warning"></i>
                    </div>
                    <h4>Ambiente Acogedor</h4>
                    <p class="mb-0">Un espacio diseñado para que disfrutes momentos especiales con los tuyos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="py-5 bg-cream">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-brown">Lo Que Dicen Nuestros Clientes</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card testimonial-card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="testimonial-rating mb-3">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <p class="card-text fst-italic">"El mejor café de la ciudad! El ambiente es acogedor y la atención excelente."</p>
                            <div class="testimonial-author">
                                <strong>- María González</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card testimonial-card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="testimonial-rating mb-3">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-half text-warning"></i>
                            </div>
                            <p class="card-text fst-italic">"Sus croissants son increíbles. Siempre frescos y deliciosos. ¡Mi lugar favorito!"</p>
                            <div class="testimonial-author">
                                <strong>- Carlos López</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card testimonial-card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="testimonial-rating mb-3">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <p class="card-text fst-italic">"Perfecto para trabajar o reunirse con amigos. WiFi rápido y café excepcional."</p>
                            <div class="testimonial-author">
                                <strong>- Ana Martínez</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Llamado a la acción -->
    <section class="py-5 bg-dark text-white text-center">
        <div class="container">
            <h2 class="display-6 fw-bold mb-4">¿Listo para vivir la experiencia Marret Café?</h2>
            <p class="lead mb-4">Visítanos hoy y descubre por qué somos el café favorito del vecindario</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="reservas.php" class="btn btn-primary btn-lg px-4">
                    <i class="bi bi-calendar-check me-2"></i>Reservar Mesa
                </a>
                <a href="contacto.php" class="btn btn-outline-light btn-lg px-4">
                    <i class="bi bi-telephone me-2"></i>Contactarnos
                </a>
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