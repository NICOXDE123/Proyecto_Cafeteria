<?php
 session_start();
require_once '../backend/config/db.php';
require_once '../backend/models/Producto.php';
require_once '../backend/models/Categoria.php';
require_once '../backend/helpers/auth.php';

$productoModel = new Producto();
$categoriaModel = new Categoria();

// Obtener categoría de pastelería
$categoriaPasteleria = $categoriaModel->obtenerPorNombre('Pastelería');
$productosPasteleria = $productoModel->obtenerPorCategoria($categoriaPasteleria['id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastelería - Marret Café</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <?php include 'views/header.php'; ?>

    <!-- Hero Section Pastelería -->
    <section class="hero-section-pasteleria text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50 py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Pastelería Artesanal</h1>
                    <p class="lead mb-4">Elaborada diariamente con los mejores ingredientes y mucho amor</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Información sobre pastelería -->
    <section class="py-5 bg-cream">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="display-6 fw-bold text-brown mb-4">Nuestra Pastelería</h2>
                    <p class="lead mb-4">En Delicia Café nos enorgullecemos de nuestra repostería artesanal. Cada producto es elaborado con ingredientes frescos y de la más alta calidad.</p>
                    
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Ingredientes 100% naturales</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Elaboración artesanal diaria</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Opciones sin gluten</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Recetas tradicionales</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="#productos-pasteleria" class="btn btn-primary btn-lg">
                            <i class="bi bi-arrow-down me-2"></i>Ver Nuestras Delicias
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="pasteleria-feature-image">
                        <i class="bi bi-cake2-fill text-brown" style="font-size: 15rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos de Pastelería -->
    <section id="productos-pasteleria" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-brown">Nuestras Delicias de Pastelería</h2>
                <p class="lead text-muted">Selecciona tu favorita y disfruta del sabor artesanal</p>
            </div>
            
            <div class="row g-4">
                <?php foreach($productosPasteleria as $producto): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card pasteleria-card border-0 shadow-sm h-100">
                        <?php if ($producto['imagen_url']): ?>
                            <img src="<?php echo $producto['imagen_url']; ?>" class="card-img-top pasteleria-img" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <?php else: ?>
                            <div class="card-img-top pasteleria-img d-flex align-items-center justify-content-center bg-pastel">
                                <i class="bi bi-cake2 text-brown" style="font-size: 4rem;"></i>
                            </div>
                        <?php endif; ?>
                        
                            <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title text-brown fw-bold"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                <span class="badge bg-warning text-dark">Popular</span>
                            </div>
                            <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="h4 text-primary fw-bold mb-0">$<?php echo number_format($producto['precio'], 2); ?></span>
                                
                                <?php if ($producto['stock'] > 0): ?>
                                    <?php if (isLoggedIn()): ?>
                                        <!-- REEMPLAZAR por el nuevo formulario -->
                                        <form action="carrito.php" method="POST" class="w-100">
                                            <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-brown w-100 mt-2">
                                                <i class="bi bi-cart-plus me-1"></i>Agregar al Carrito
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-primary" onclick="requiereLogin()">
                                            <i class="bi bi-cart-plus me-1"></i>Agregar
                                        </button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge bg-danger">Agotado</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Información adicional -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="info-box p-4">
                        <i class="bi bi-clock-history display-4 text-brown mb-3"></i>
                        <h4>Frescura Garantizada</h4>
                        <p class="mb-0">Elaboramos todos nuestros productos el mismo día para garantizar máxima frescura.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="info-box p-4">
                        <i class="bi bi-heart display-4 text-brown mb-3"></i>
                        <h4>Hecho con Amor</h4>
                        <p class="mb-0">Cada receta es preparada con dedicación y pasión por la repostería.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="info-box p-4">
                        <i class="bi bi-star display-4 text-brown mb-3"></i>
                        <h4>Calidad Premium</h4>
                        <p class="mb-0">Utilizamos solo ingredientes de la más alta calidad en todas nuestras preparaciones.</p>
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