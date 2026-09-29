<?php
include '../DAO/MetodosDAO.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$hayProductos = isset($_SESSION['cesta']) && !empty($_SESSION['cesta']);
$subtotal_productos = 0;

// 🎯 CONFIGURACIÓN DE ENVÍO
$umbral_envio_gratis = 500;      // Meta para envío gratis
$costo_envio_estandar = 150;     // Costo normal de envío

if ($hayProductos) {
    foreach ($_SESSION['cesta'] as $id => $item) {
        $prod = (new MetodosDAO())->ListarProductosCod($id);
        if ($prod) {
            // ✅ Solo sumamos (Cantidad * Precio). Sin envíos duplicados.
            $subtotal_productos += ($item->cantidad * $prod[2]);
        }
    }
}

// 🎯 LÓGICA DE ENVÍO GRATIS (Se evalúa DESPUÉS de tener el subtotal real)
if ($subtotal_productos >= $umbral_envio_gratis) {
    $costo_envio = 0; // ¡Envío gratis!
} else {
    $costo_envio = $costo_envio_estandar; // Se cobra la tarifa estándar
}

// ✅ Calculamos el total real
$total_final = $subtotal_productos + $costo_envio;

// ✅ Guardamos el desglose en sesión para validarlo en Pago.php y en Stripe
$_SESSION['resumen_pedido'] = [
    'subtotal' => $subtotal_productos,
    'envio' => $costo_envio,
    'total' => $total_final
];
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
                <!-- Lista de Productos -->
                <div class="col-lg-8">
                    <?php
                    foreach ($_SESSION['cesta'] as $id => $item) {
                        $prod = (new MetodosDAO())->ListarProductosCod($id);
                        if ($prod) {
                            $subtotal_linea = $item->cantidad * $prod[2];
                    ?>
                    <div class="card mb-3">
                        <div class="card-body d-flex align-items-center">
                            <img src="../images/<?php echo $prod[6]; ?>" class="img-fluid" style="width: 100px; height: 100px; object-fit: contain;" alt="<?php echo $prod[1]; ?>">
                            <div class="ms-3 flex-grow-1">
                                <h5 class="mb-1"><?php echo $prod[1]; ?></h5>
                                <p class="mb-1 text-muted small">Talla: <?php echo $item->talla; ?> | Color: <?php echo $item->color; ?></p>
                                <p class="mb-0">Cantidad: <?php echo $item->cantidad; ?> x $<?php echo number_format($prod[2], 2); ?></p>
                            </div>
                            <div class="text-end">
                                <h5 class="text-primary mb-2">$<?php echo number_format($subtotal_linea, 2); ?></h5>
                                <a href="../DAO/TiendaDAO.php?id=<?php echo $id; ?>&accion=eliminar&op=2" class="text-danger text-decoration-none" onclick="return confirm('¿Eliminar este producto?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                
                <!-- Resumen del Pedido (AQUÍ ESTÁ EL MENSAJE MÁGICO) -->
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-4">Resumen del Pedido</h4>
                            
                            <!-- 🎯 MENSAJE DINÁMICO DE ENVÍO GRATIS -->
                            <?php if ($costo_envio == 0): ?>
                                <div class="alert alert-success small text-center mb-3">
                                    <i class="fas fa-truck"></i> <strong>¡Felicidades!</strong> Tienes Envío GRATIS.
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning small text-center mb-3">
                                    <i class="fas fa-info-circle"></i> Te faltan <strong>$<?php echo number_format($umbral_envio_gratis - $subtotal_productos, 2); ?></strong> para tener <strong>Envío GRATIS</strong>.
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal productos:</span>
                                <span>$<?php echo number_format($subtotal_productos, 2); ?></span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-3 <?php echo ($costo_envio == 0) ? 'text-success fw-bold' : ''; ?>">
                                <span><i class="fas fa-truck"></i> Envío:</span>
                                <span>
                                    <?php if ($costo_envio == 0): ?>
                                        GRATIS
                                    <?php else: ?>
                                        $<?php echo number_format($costo_envio, 2); ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fs-5 fw-bold">Total a Pagar:</span>
                                <strong class="text-primary fs-3">$<?php echo number_format($total_final, 2); ?> MXN</strong>
                            </div>
                            
                            <button class="btn btn-primary w-100 mb-3 py-2 fw-bold" onclick="procederPago()">
                                <i class="fas fa-lock"></i> Proceder al Pago Seguro
                            </button>
                            
                            <a href="../DAO/TiendaDAO.php?accion=vacio&op=2" class="btn btn-outline-danger w-100 py-2" onclick="return confirm('¿Estás seguro de que deseas vaciar todo el carrito?')">
                                <i class="fas fa-trash"></i> Vaciar Carrito
                            </a>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-3 small text-center">
                        <i class="fas fa-info-circle"></i> ¡Envío rápido y seguro a todo México!
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function procederPago() {
        window.location.href = 'Pago.php?total=<?php echo $total_final; ?>&estado=pagar';
    }
    </script>
</body>
</html>