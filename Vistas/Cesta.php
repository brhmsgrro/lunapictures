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

// 🎯 LÓGICA DE ENVÍO GRATIS CON DOS REGLAS
$tiene_producto_envio_gratis = false;

// Regla 1: ¿Algún producto tiene envío gratis individual?
foreach ($_SESSION['cesta'] as $id => $item) {
    $prod = (new MetodosDAO())->ListarProductosCod($id);
    if ($prod && isset($prod[8]) && $prod[8] == 0) {
        $tiene_producto_envio_gratis = true;
        break; // Con encontrar uno es suficiente
    }
}

// Aplicar reglas de envío
if ($tiene_producto_envio_gratis || $subtotal_productos >= $umbral_envio_gratis) {
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
        
        // 🎯 LÓGICA PARA OBTENER LA IMAGEN CORRECTA SEGÚN EL COLOR
        $imagenMostrar = $prod[6]; // Imagen por defecto (respaldo)
        
        // Si el producto tiene un color asignado y no es "Estándar"
        if (isset($item->color) && !empty($item->color) && strtolower($item->color) !== 'estándar') {
            $dao = new MetodosDAO();
            // Buscamos la imagen que coincida con el color
            $imagenesColor = $dao->ListarImagenesPorColorYProducto($id, $item->color);
            
            if (!empty($imagenesColor) && isset($imagenesColor[0]['ruta_imagen'])) {
                $imagenMostrar = $imagenesColor[0]['ruta_imagen'];
            }
        }
?>
        <!-- DENTRO DEL FOREACH DE PRODUCTOS EN CESTA.PHP -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body d-flex align-items-center p-3">
        <!-- Imagen del producto -->
        <img src="../images/<?php echo htmlspecialchars($imagenMostrar); ?>" 
             class="rounded" 
             style="width: 90px; height: 90px; object-fit: cover; background: #f8f9fa;" 
             alt="<?php echo htmlspecialchars($prod[1]); ?>">
             
        <div class="ms-3 flex-grow-1">
            <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($prod[1]); ?></h6>
            
            <!-- ✅ ETIQUETAS VISUALES PARA TALLA Y COLOR -->
            <div class="d-flex gap-2 mb-2">
                <span class="badge bg-light text-dark border">
                    <i class="fas fa-ruler-horizontal me-1"></i> Talla: <?php echo htmlspecialchars($item->talla ?? 'N/A'); ?>
                </span>
                <span class="badge bg-light text-dark border">
                    <i class="fas fa-palette me-1"></i> Color: <?php echo htmlspecialchars($item->color ?? 'Estándar'); ?>
                </span>
            </div>
            
            <p class="mb-0 small text-muted">
                Cant: <?php echo (int)$item->cantidad; ?> x $<?php echo number_format($prod[2], 2); ?>
            </p>
        </div>
        
        <div class="text-end ms-2">
            <h6 class="text-primary fw-bold mb-2">$<?php echo number_format($subtotal_linea, 2); ?></h6>
           

<!-- En Cesta.php, dentro del foreach -->
<a href="../DAO/TiendaDAO.php?clave=<?php echo urlencode($id); ?>&accion=eliminar&op=2" 
   class="text-danger small text-decoration-none" 
   onclick="return confirm('¿Eliminar esta variante específica?')">
    <i class="fas fa-trash-alt"></i> Quitar
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

                            <!-- ANTES DEL BOTÓN DE PAGO EN EL RESUMEN -->
<div class="alert alert-light border mb-4 p-3">
    <h6 class="fw-bold mb-2"><i class="fas fa-clipboard-check text-success"></i> Verifica tus variantes:</h6>
    <ul class="list-unstyled mb-0 small">
        <?php foreach ($_SESSION['cesta'] as $item): ?>
            <li class="mb-1">
                • <?php echo htmlspecialchars($item->cantidad); ?>x 
                  <strong><?php echo htmlspecialchars($item->color ?? 'Estándar'); ?></strong> 
                  (Talla: <?php echo htmlspecialchars($item->talla ?? 'N/A'); ?>)
            </li>
        <?php endforeach; ?>
    </ul>
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
    const cesta = <?php echo json_encode($_SESSION['cesta']); ?>;
    
    // ✅ VALIDAR QUE TODOS LOS ITEMS TENGAN TALLA Y COLOR
    let faltanDatos = false;
    for (const key in cesta) {
        if (!cesta[key].talla || !cesta[key].color) {
            faltanDatos = true;
            break;
        }
    }
    
    if (faltanDatos) {
        alert("⚠️ Hay productos en tu carrito sin talla o color definidos. Por favor regresa al catálogo y selecciona las variantes correctamente.");
        return;
    }
    
    // Si todo está bien, proceder
    sessionStorage.setItem('cesta_checkout', JSON.stringify(cesta));
    window.location.href = 'Pago.php?estado=pagar';
}
    </script>

<!-- Pega esto al final de Cesta.php, antes del </body> -->
<script>
console.log("Sesión en el carrito:", <?php echo json_encode($_SESSION); ?>);
</script>

</body>
</html>