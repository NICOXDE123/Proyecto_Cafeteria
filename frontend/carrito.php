<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/models/Carrito.php';
require_once __DIR__ . '/views/header.php';

// Verificar login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// ----- AGREGAR PRODUCTO -----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id']) && !isset($_POST['eliminar_id'])) {

    $producto_id = intval($_POST['producto_id']);
    $usuario_id  = $_SESSION['usuario']['id'];
    // cantidad por defecto 1 si no se envía o es inválida
    $cantidad    = max(1, intval($_POST['cantidad'] ?? 1));

    // Si el producto ya está en el carrito, solo sumamos cantidad
    $existe = Carrito::buscarProducto($usuario_id, $producto_id);

    if ($existe) {
        Carrito::actualizarCantidad($usuario_id, $producto_id, $cantidad);
    } else {
        Carrito::agregarProducto($usuario_id, $producto_id, $cantidad);
    }

    header("Location: carrito.php");
    exit();
}

// ----- ELIMINAR PRODUCTO -----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {

    $id = intval($_POST['eliminar_id']);

    Carrito::eliminarDelCarrito($id);

    header("Location: carrito.php");
    exit();
}

// Obtener carrito del usuario
$items = Carrito::obtenerCarrito($_SESSION['usuario']['id']);
?>

<div class="container py-5">
    <h2 class="mb-4">Tu Carrito</h2>

    <?php if ($items->num_rows === 0): ?>
        <p>No tienes productos en tu carrito.</p>

    <?php else: ?>
        <div class="list-group">
            <?php
            $total = 0;
            while ($item = $items->fetch_assoc()):
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
            ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= htmlspecialchars($item['nombre']) ?></strong><br>
                        Cantidad: <?= (int)$item['cantidad'] ?><br>
                        Precio: $<?= number_format($item['precio'], 0, ',', '.') ?>
                    </div>
                    <div>
                        Subtotal: $<?= number_format($subtotal, 0, ',', '.') ?>
                    </div>

                    <form method="POST" class="ms-3">
                        <input type="hidden" name="eliminar_id" value="<?= (int)$item['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>

        <h3 class="mt-4">Total: $<?= number_format($total, 0, ',', '.') ?></h3>
    <?php endif; ?>

</div>

<?php require_once './views/footer.php'; ?>
