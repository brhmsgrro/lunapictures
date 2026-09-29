<?php
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_start();
}
require_once __DIR__ . '/../config/stripe.php';
include __DIR__ . '/../DAO/MetodosDAO.php';

if (empty($_SESSION['cesta'])) {
    header('Location: ../Vistas/Cesta.php');
    exit;
}

try {
    $objMetodos = new MetodosDAO();
    $line_items = [];
    $subtotal_productos = 0;

    // 1. SUMAR LOS PRODUCTOS
    foreach ($_SESSION['cesta'] as $idProducto => $item) {
        $producto = $objMetodos->ListarProductosCod($idProducto);
        
        if (!$producto) {
            error_log("⚠️ Producto ID $idProducto no encontrado en BD");
            continue;
        }
        
        $nombre = $producto[1] ?? 'Producto Luna Pictures';
        $precio = (float)($producto[2] ?? 0);
        $cantidad = (int)($item->cantidad ?? 1);
        
        if ($precio <= 0) {
            error_log("⚠️ Precio inválido para producto ID $idProducto: $precio");
            continue;
        }

        $line_items[] = [
            'price_data' => [
                'currency' => 'mxn',
                'product_data' => [
                    'name' => $nombre,
                ],
                'unit_amount' => (int)($precio * 100), // Stripe usa centavos
            ],
            'quantity' => $cantidad,
        ];
        
        $subtotal_productos += ($precio * $cantidad);
    }

    if (empty($line_items)) {
        throw new Exception('No hay productos válidos en el carrito');
    }

    // 2. AGREGAR EL ENVÍO COMO UN ÍTEM ADICIONAL (SOLO UNA VEZ)
    // Usamos el valor guardado en Cesta.php, o 150 por defecto si no existe
    $costo_envio = isset($_SESSION['resumen_pedido']['envio']) ? $_SESSION['resumen_pedido']['envio'] : 150;
    
        // ... (tu código anterior que suma los productos en el foreach) ...
    
    // Al final del foreach, ya tienes la variable $subtotal_productos calculada.
    
    // 🎯 RECÁLCULO SEGURO EN EL BACKEND
    $umbral_envio_gratis = 500;
    $costo_envio_estandar = 150;
    
    if ($subtotal_productos >= $umbral_envio_gratis) {
        $costo_envio = 0;
    } else {
        $costo_envio = $costo_envio_estandar;
    }

    // 2. AGREGAR EL ENVÍO COMO UN ÍTEM ADICIONAL (SOLO SI NO ES GRATIS)
    if ($costo_envio > 0) {
        $line_items[] = [
            'price_data' => [
                'currency' => 'mxn',
                'product_data' => [
                    'name' => 'Envío a domicilio (Tarifa única)',
                    'description' => 'Costo de envío estándar a todo México',
                ],
                'unit_amount' => (int)($costo_envio * 100),
            ],
            'quantity' => 1,
        ];
    } else {
        // Opcional: Puedes agregar un ítem de $0 para que el cliente vea "Envío: GRATIS" en Stripe
        $line_items[] = [
            'price_data' => [
                'currency' => 'mxn',
                'product_data' => [
                    'name' => 'Envío a domicilio',
                    'description' => '¡Promoción de Envío GRATIS aplicada!',
                ],
                'unit_amount' => 0, // Cero pesos
            ],
            'quantity' => 1,
        ];
    }

    // ... (tu código de \Stripe\Checkout\Session::create sigue igual) ...

    // 3. CREAR LA SESIÓN DE STRIPE
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'https://lunapictures.com.mx/Vistas/Pago.php?estado=ok',
        'cancel_url' => 'https://lunapictures.com.mx/Vistas/Cesta.php?cancelado=1',
        'locale' => 'es',
        
        // ✅ SOLUCIÓN DEFINITIVA: Stripe le pedirá la dirección al cliente
        'shipping_address_collection' => [
            'allowed_countries' => ['MX'], // Solo permite direcciones de México
        ],
        
        // ✅ Vincula este pago con tu usuario en la base de datos (para el Webhook)
        'client_reference_id' => isset($_SESSION['codCli']) ? (string)$_SESSION['codCli'] : 'invitado',
    ]);

    header('HTTP/1.1 303 See Other');
    header('Location: ' . $checkout_session->url);
    exit;

} catch (Exception $e) {
    error_log('❌ Error Stripe: ' . $e->getMessage());
    header('Location: ../Vistas/Pago.php?error=stripe');
    exit;
}
?>