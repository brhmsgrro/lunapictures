<?php
require_once __DIR__ . '/../config/stripe.php';
require_once __DIR__ . '/../config/database.php';

$payload = @file_get_contents('php://input');
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload,
        $_SERVER['HTTP_STRIPE_SIGNATURE'],
        STRIPE_WEBHOOK_SECRET
    );
} catch (\UnexpectedValueException $e) {
    http_response_code(400);
    exit('Invalid payload');
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    exit('Invalid signature');
}

// Manejar el evento de checkout completado
if ($event->type === 'checkout.session.completed') {
    $session = $event->data->object;
    
    // Obtener orden_id de los metadata
    $orden_id = $session->metadata->orden_id;
    
    // Actualizar orden a "pagada"
    $stmt = $pdo->prepare("
        UPDATE ordenes 
        SET estado = 'pagada', 
            fecha_pago = CURRENT_TIMESTAMP 
        WHERE id = :orden_id AND estado = 'pendiente'
    ");
    $stmt->execute([':orden_id' => $orden_id]);
    
    // Aquí puedes:
    // - Enviar email de confirmación al cliente
    // - Actualizar inventario
    // - Generar factura/CFDI
}

http_response_code(200);
?>