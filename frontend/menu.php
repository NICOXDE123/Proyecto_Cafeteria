<?php
session_start();
require_once '../backend/config/db.php';
require_once '../backend/models/Producto.php';
require_once '../backend/models/Categoria.php';
require_once '../backend/helpers/auth.php'; 

$productoModel = new Producto();
$categoriaModel = new Categoria();

$categorias = $categoriaModel->obtenerTodas();
$productosPorCategoria = [];

foreach ($categorias as $categoria) {
    $productosPorCategoria[$categoria['id']] = $productoModel->obtenerPorCategoria($categoria['id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Marret Café</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <?php include 'views/header.php'; ?>

    <!-- Hero Section Menú -->
    <section class="hero-section-menu bg-brown text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50 py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Nuestro Menú</h1>
                    <p class="lead mb-4">Descubre nuestra selección de cafés premium, deliciosas pastelerías y mucho más</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Navegación entre categorías -->
    <section class="py-4 bg-light sticky-top" style="top: 76px; z-index: 1020;">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <?php foreach($categorias as $categoria): ?>
                <a href="#categoria-<?php echo $categoria['id']; ?>" class="btn btn-outline-brown btn-sm">
                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Menú por categorías -->
    <section class="py-5">
        <div class="container">
            <?php foreach($categorias as $categoria): ?>
            <div class="categoria-section mb-5" id="categoria-<?php echo $categoria['id']; ?>">
                <div class="row mb-4">
                    <div class="col">
                        <h2 class="display-6 fw-bold text-brown border-bottom pb-2">
                            <i class="bi bi-<?php echo getCategoriaIcon($categoria['nombre']); ?> me-2"></i>
                            <?php echo htmlspecialchars($categoria['nombre']); ?>
                        </h2>
                        <?php if ($categoria['descripcion']): ?>
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($categoria['descripcion']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="row g-4">
                    <?php 
                    $productos = $productosPorCategoria[$categoria['id']] ?? [];
                    foreach($productos as $producto): 
                    ?>
                    <div class="col-lg-6">
                        <div class="card menu-item-card border-0 shadow-sm h-100">
                            <div class="row g-0 h-100">
                                <div class="col-md-4">
                                    <?php if ($producto['imagen_url']): ?>
                                        <img src="<?php echo $producto['imagen_url']; ?>" class="img-fluid rounded-start h-100 w-100" style="object-fit: cover;" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                    <?php else: ?>
                                        <div class="h-100 d-flex align-items-center justify-content-center bg-light">
                                            <i class="bi bi-<?php echo getCategoriaIcon($categoria['nombre']); ?> text-brown" style="font-size: 3rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body d-flex flex-column h-100">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title text-brown fw-bold"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                            <span class="h5 text-primary fw-bold">$<?php echo number_format($producto['precio'], 2); ?></span>
                                        </div>
                                        <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                                        
                                        <!-- INSERTAR AQUI: formulario para agregar al carrito -->
                                        <form method="POST" action="carrito.php" class="mt-2 w-100">
                                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm w-100">Agregar al carrito</button>
                                        </form>
                                        
                                        <?php if ($producto['stock'] > 0): ?>
                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <small class="text-success">
                                                    <i class="bi bi-check-circle me-1"></i>Disponible
                                                </small>
                                                <!-- ...existing add-to-cart logic (puedes quitarla si usas el nuevo formulario) -->
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-auto">
                                                <small class="text-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Agotado
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($productos)): ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-cup-straw display-1 text-muted mb-3"></i>
                            <h4 class="text-muted">Próximamente más productos</h4>
                            <p class="text-muted">Estamos trabajando en nuevas delicias para ti</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Llamado a la acción -->
    <section class="py-5 bg-dark text-white text-center">
        <div class="container">
            <h2 class="display-6 fw-bold mb-4">¿Te gusta lo que ves?</h2>
            <p class="lead mb-4">Ven y disfruta de estas delicias en nuestro acogedor local</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="reservas.php" class="btn btn-primary btn-lg px-4">
                    <i class="bi bi-calendar-check me-2"></i>Reservar Mesa
                </a>
                <a href="contacto.php" class="btn btn-outline-light btn-lg px-4">
                    <i class="bi bi-telephone me-2"></i>Consultar
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

<?php
function getCategoriaIcon($categoriaNombre) {
    $icons = [
        'Café' => 'cup-hot',
        'Pastelería' => 'cake2',
        'Sandwiches' => 'egg-fried',
        'Bebidas' => 'cup-straw'
    ];
    return $icons[$categoriaNombre] ?? 'cup-hot';
}
?>