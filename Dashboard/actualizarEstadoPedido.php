<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    $idPedido = isset($_POST['id_pedido']) ? (int)$_POST['id_pedido'] : 0;
    $emailCliente = isset($_POST['email_cliente']) ? trim($_POST['email_cliente']) : '';
    $nombreCliente = isset($_POST['nombre_cliente']) ? trim($_POST['nombre_cliente']) : 'Cliente';
    $numeroRastreo = isset($_POST['numero_rastreo']) ? trim($_POST['numero_rastreo']) : 'En proceso de asignación';

    if ($idPedido <= 0) throw new Exception('ID de pedido inválido');
    if (empty($emailCliente)) throw new Exception('Email vacío');

    if (!file_exists('../DAO/MetodosAdmin.php')) throw new Exception('No se encontró MetodosAdmin.php');
    
    include '../DAO/MetodosAdmin.php';
    $metodos = new MetodosAdmin();
    
    // ✅ Pasamos el número de rastreo al método
    $actualizado = $metodos->ActualizarEstadoPedido($idPedido, 'despachado', $numeroRastreo);

    if (!$actualizado) throw new Exception('No se pudo actualizar el estado');

    if (!empty($emailCliente)) {
        $phpmailerPath = __DIR__ . '/PHPMailer/src/';
        
        if (file_exists($phpmailerPath . 'PHPMailer.php')) {
            require_once $phpmailerPath . 'Exception.php';
            require_once $phpmailerPath . 'PHPMailer.php';
            require_once $phpmailerPath . 'SMTP.php';

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            
            try {
                $mail->isSMTP();
                $mail->Host = 'mail.lunapictures.com.mx';
                $mail->SMTPAuth = true;
                $mail->Username = 'ventas@lunapictures.com.mx';
                $mail->Password = 'Psv@pyimvj78';
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8'; 
                $mail->Encoding = 'base64'; // ✅ AGREGA ESTO (Ayuda con emojis en correos antiguos)
                $mail->setFrom('ventas@lunapictures.com.mx', 'Luna Pictures Store');
                $mail->addAddress($emailCliente);
                $mail->isHTML(true);
                
                // ✅ Formateamos el número de pedido para que se vea #0002
                $pedidoFormateado = 'Pedido #' . str_pad($idPedido, 4, '0', STR_PAD_LEFT);
                $mail->Subject = "$pedidoFormateado ya va en camino!";
                
                // ✅ Correo mejorado con el número de rastreo
               $mail->Body = "
    <html>
    <head>
        <!-- ✅ ESTA ETIQUETA ES OBLIGATORIA PARA PRODIGY Y OUTLOOK -->
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    </head>
    <body style='font-family: Arial, sans-serif; color: #333;'>
        <h2 style='color: #563d7c;'>Luna Pictures Merchandising</h2>
        <p>¡Hola <strong>" . htmlspecialchars($nombreCliente) . "</strong>!</p>
        <p>Nos complace informarte que tu <strong>$pedidoFormateado</strong> ya fue despachado.</p>
        
        <div style='background-color: #f8f9fa; padding: 15px; border-left: 4px solid #563d7c; margin: 20px 0;'>
            <p style='margin: 0;'><strong>📦 Número de Rastreo:</strong> " . htmlspecialchars($numeroRastreo) . "</p>
        </div>

        <p>Pronto lo recibirás en tu domicilio. Puedes usar este número para dar seguimiento a tu paquete.</p>
        <p>¡Gracias por tu compra! 🎬</p>
        <hr>
        <p style='font-size: 12px; color: #777;'>Luna Pictures - lunapictures.com.mx</p>
    </body>
    </html>
";
                
                $mail->AltBody = "Hola $nombreCliente! Tu $pedidoFormateado ya fue despachado. Número de rastreo: $numeroRastreo. Gracias por tu compra!";
                
                $mail->send();
                echo json_encode(['exito' => true, 'mensaje' => 'Pedido actualizado y correo enviado']);
                
            } catch (Exception $e) {
                error_log("PHPMailer Error: " . $mail->ErrorInfo);
                echo json_encode(['exito' => true, 'mensaje' => 'Pedido actualizado (Error correo: ' . $e->getMessage() . ')']);
            }
        }
    }
} catch (Exception $e) {
    echo json_encode(['exito' => false, 'mensaje' => $e->getMessage()]);
}
?>