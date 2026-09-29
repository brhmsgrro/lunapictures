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

    // ==========================================================
    // 2. LÓGICA DE ENVÍO (IDÉNTICA A LA DE Cesta.php)
    // ==========================================================
    $costo_envio = 150; // Por defecto
    $tiene_producto_envio_gratis = false;

    // Regla 1: ¿Algún producto en el carrito tiene envío gratis individual?
    foreach ($_SESSION['cesta'] as $id => $item) {
        $prod = $objMetodos->ListarProductosCod($id);
        // El índice 8 es la columna 'envio' en tu tabla productos
        if ($prod && isset($prod[8]) && (int)$prod[8] === 0) {
            $tiene_producto_envio_gratis = true;
            break; // Con encontrar uno es suficiente
        }
    }

    // Regla 2: ¿El subtotal supera el umbral de $500?
    $umbral_envio_gratis = 500;
    
    if ($tiene_producto_envio_gratis || $subtotal_productos >= $umbral_envio_gratis) {
        $costo_envio = 0; // ¡Envío gratis!
    } else {
        $costo_envio = 150; // Tarifa estándar
    }

    // ==========================================================
// 3. VALIDAR MONTO MÍNIMO DE STRIPE ($10.00 MXN)
// ==========================================================
$total_a_pagar = $subtotal_productos + $costo_envio;

if ($total_a_pagar < 10) {
    throw new Exception("El total de tu compra es de $" . number_format($total_a_pagar, 2) . " MXN. 
    Stripe requiere un mínimo de $10.00 MXN para procesar pagos. 
    Agrega más productos al carrito o usa otro método de pago.");
}

// ==========================================================
// 4. AGREGAR EL ENVÍO COMO UN ÍTEM EN STRIPE
// ==========================================================
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
}
// Si el envío es gratis, NO lo agregamos (Stripe no permite items en $0)

// ==========================================================
// DEBUG: Verificar que todo esté correcto antes de Stripe
// ==========================================================
error_log("🔍 DEBUG ANTES DE STRIPE:");
error_log("Clave Stripe configurada: " . (\Stripe\Stripe::getApiKey() ? 'SÍ' : 'NO'));
error_log("Número de line_items: " . count($line_items));
error_log("Contenido de line_items: " . print_r($line_items, true));

if (empty($line_items)) {
    throw new Exception('ERROR CRÍTICO: line_items está vacío. Revisa que ListarProductosCod devuelva los datos correctos.');
}

// Verificar que cada item tenga precio válido
foreach ($line_items as $index => $item) {
    if (!isset($item['price_data']['unit_amount']) || $item['price_data']['unit_amount'] <= 0) {
        throw new Exception("El item #$index tiene precio inválido o cero: " . print_r($item, true));
    }
}


    // 4. CREAR LA SESIÓN DE STRIPE
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'https://lunapictures.com.mx/Vistas/Pago.php?estado=ok',
        'cancel_url' => 'https://lunapictures.com.mx/Vistas/Cesta.php?cancelado=1',
        'locale' => 'es',
        
        // Stripe le pedirá la dirección al cliente
        'shipping_address_collection' => [
            'allowed_countries' => ['MX'], 
        ],
        
        // Vincula este pago con tu usuario en la base de datos
        'client_reference_id' => isset($_SESSION['codCli']) ? (string)$_SESSION['codCli'] : 'invitado',
    ]);

    header('HTTP/1.1 303 See Other');
    header('Location: ' . $checkout_session->url);
    exit;

} catch (Exception $e) {
    // Activar reporte de errores temporalmente
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Obtener toda la información del error
    $error_message = $e->getMessage();
    $error_code = $e->getCode();
    $error_file = $e->getFile();
    $error_line = $e->getLine();
    
    // Guardar en log
    error_log("ERROR STRIPE COMPLETO:");
    error_log("Mensaje: " . $error_message);
    error_log("Código: " . $error_code);
    error_log("Archivo: " . $error_file);
    error_log("Línea: " . $error_line);
    
    // Construir mensaje detallado
    $detalle_error = "Mensaje: $error_message | Código: $error_code | Línea: $error_line";
    
    // Redirigir con TODA la información
    header('Location: ../Vistas/Pago.php?error=stripe&detalle=' . urlencode($detalle_error));
    exit;
}
?>