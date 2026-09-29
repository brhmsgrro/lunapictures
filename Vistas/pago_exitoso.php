<?php
session_start();
require_once __DIR__ . '/../config/stripe.php';
require_once __DIR__ . '/../config/database.php';

$session_id = $_GET['session_id'] ?? '';

if (!$session_id) {
    header('Location: ' . SITE_URL . '/Vistas/Cesta.php');
    exit;
}

try {
    $session = \Stripe\Checkout\Session::retrieve($session_id);
    
    if ($session->payment_status === 'paid') {
        // Limpiar carrito
        unset($_SESSION['carrito']);
        
        // Obtener detalles de la orden
        $stmt = $pdo->prepare("SELECT * FROM ordenes WHERE stripe_session_id = :session_id");
        $stmt->execute([':session_id' => $session_id]);
        $orden = $stmt->fetch(PDO::FETCH_ASSOC);
        
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Pago Exitoso - Luna Pictures</title>
        </head>
        <body>
            <div style="max-width: 600px; margin: 50px auto; text-align: center;">
                <h1 style="color: #28a745;">✅ ¡Pago exitoso!</h1>
                <p>Gracias por tu compra, <?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'cliente'); ?></p>
                <p><strong>Orden #<?php echo $orden['id']; ?></strong></p>
                <p>Total pagado: $<?php echo number_format($orden['total'], 2); ?> MXN</p>
                <p>Recibirás un correo de confirmación con los detalles de tu pedido.</p>
                <a href="<?php echo SITE_URL; ?>/Vistas/mis_ordenes.php" style="color: #635bff;">
                    Ver mis órdenes
                </a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<h1>Pago no completado</h1>";
    }
} catch (Exception $e) {
    echo "<h1>Error al verificar el pago</h1>";
    error_log('Error en pago_exitoso: ' . $e->getMessage());
}
?>