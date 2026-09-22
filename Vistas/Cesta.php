<?php
include '../DAO/MetodosDAO.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$total = 0;
$hayProductos = isset($_SESSION['cesta']) && !empty($_SESSION['cesta']);

if ($hayProductos) {
    foreach ($_SESSION['cesta'] as $id => $item) {
        $prod = (new MetodosDAO())->ListarProductosCod($id);
        if ($prod) {
            $total += ($item->cantidad * $prod[2]) + ($prod[7] ?? 0);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Carrito | Luna Pictures Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/tienda-styles.css">
</head>
<body>

    <nav class="store-navbar">
        <div class="container">
            <a href="Catalogo.php" class="store-logo">LUNA<em>PICTURES</em> STORE</a>
            <ul class="store-nav-links">
                <li><a href="Catalogo.php">Seguir Comprando</a></li>
            </ul>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="text-center mb-5">Tu Carrito de Compras</h1>
        
        <?php if (!$hayProductos): ?>
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                <h3>Tu carrito está vacío</h3>
                <a href="Catalogo.php" class="btn btn-primary mt-3">Ver Productos</a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <?php
                    foreach ($_SESSION['cesta'] as $id => $item) {
                        $prod = (new MetodosDAO())->ListarProductosCod($id);
                        if ($prod) {
                            $subtotal = ($item->cantidad * $prod[2]) + ($prod[7] ?? 0);
                    ?>
                    <div class="card mb-3">
                        <div class="card-body d-flex align-items-center">
                            <img src="../images/<?php echo $prod[6]; ?>" class="img-fluid" style="width: 100px; height: 100px; object-fit: contain;">
                            <div class="ms-3 flex-grow-1">
                                <h5><?php echo $prod[1]; ?></h5>
                                <p class="mb-1">Talla: <?php echo $item->talla; ?> | Color: <?php echo $item->color; ?></p>
                                <p class="mb-0">Cantidad: <?php echo $item->cantidad; ?></p>
                            </div>
                            <div class="text-end">
                                <h5 class="text-primary">$<?php echo number_format($subtotal, 2); ?></h5>
                                <a href="../DAO/TiendaDAO.php?id=<?php echo $id; ?>&accion=eliminar&op=2" class="text-danger" onclick="return confirm('¿Eliminar?')"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Resumen del Pedido</h4>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Total:</span>
                                <strong class="text-primary fs-4">$<?php echo number_format($total, 2); ?> MXN</strong>
                            </div>
                            <button class="btn btn-primary w-100 mb-2" onclick="procederPago()">
                                <i class="fas fa-credit-card"></i> Proceder al Pago
                            </button>
                            <a href="../DAO/TiendaDAO.php?accion=vacio&op=2" class="btn btn-outline-danger w-100" onclick="return confirm('¿Vaciar carrito?')">
                                <i class="fas fa-trash"></i> Vaciar Carrito
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function procederPago() {
        window.location.href = 'Pago.php?total=<?php echo $total; ?>&estado=pagar';
    }
    </script>
</body>
</html>