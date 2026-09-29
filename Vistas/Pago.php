<?php 
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_start();
}
include '../DAO/MetodosDAO.php';

$total = $_REQUEST['total'] ?? 0;
$estado = $_REQUEST['estado'] ?? '';

// Verificar si el usuario está logueado de forma segura
$is_logged_in = isset($_SESSION['acceso']) && $_SESSION['acceso'] === true;
$user_name = $_SESSION['nombre'] ?? 'Cliente';
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra | Luna Pictures Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="/images/luna pictures audiovisual.ico" type="image/x-icon">
    <style>
        body { background-color: #f4f6f8; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; color: #333; margin: 0; padding: 0; }
        .navbar-simple { background: #fff; padding: 15px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 40px; }
        .navbar-simple .brand { font-size: 1.5rem; font-weight: 800; color: #2c3e50; text-decoration: none; }
        .navbar-simple .brand em { color: #e94560; font-style: normal; }
        .checkout-wrapper { max-width: 800px; margin: 0 auto; padding: 0 20px 60px 20px; }
        
        .total-banner { background: #2c3e50; color: #fff; text-align: center; padding: 30px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(44, 62, 80, 0.2); }
        .total-banner h2 { margin: 0; font-size: 1.2rem; font-weight: 500; opacity: 0.9; }
        .total-banner .amount { font-size: 3rem; font-weight: 800; margin: 10px 0 0 0; color: #fff; }

        .options-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .option-card { background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e1e4e8; display: flex; flex-direction: column; }
        .option-card h3 { font-size: 1.25rem; font-weight: 700; margin-top: 0; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; }
        .option-card p { font-size: 0.95rem; color: #666; line-height: 1.5; margin-bottom: 25px; flex-grow: 1; }

        .form-control-custom { width: 100%; padding: 12px 15px; border: 1px solid #ced4da; border-radius: 8px; font-size: 1rem; margin-bottom: 15px; transition: all 0.2s; box-sizing: border-box; }
        .form-control-custom:focus { outline: none; border-color: #635bff; box-shadow: 0 0 0 3px rgba(99, 91, 255, 0.1); }

        .btn-paypal { width: 100%; padding: 14px; background-color: #0070ba; color: #fff; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-paypal:hover { background-color: #005ea6; color: #fff; }
        
        .btn-stripe { width: 100%; padding: 14px; background-color: #635bff; color: #fff; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 10px; }
        .btn-stripe:hover { background-color: #4f46e5; color: #fff; }

        /* Nuevo botón de login con color de Stripe para asociación visual */
        .btn-stripe-login { width: 100%; padding: 14px; background-color: #635bff; color: #fff; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-stripe-login:hover { background-color: #4f46e5; color: #fff; }

        .register-link { text-align: center; margin-top: 15px; font-size: 0.9rem; }
        .register-link a { color: #e94560; text-decoration: none; font-weight: 600; }

        .success-box { background: #fff; border-radius: 12px; padding: 50px 30px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08); max-width: 600px; margin: 0 auto; }
        .success-icon { font-size: 4rem; color: #28a745; margin-bottom: 20px; }

        .logged-in-badge { background: #d1fae5; color: #065f46; padding: 10px 15px; border-radius: 8px; text-align: center; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px; }

        @media (max-width: 768px) {
            .options-grid { grid-template-columns: 1fr; }
            .total-banner .amount { font-size: 2.5rem; }
        }
    </style>
</head>
<body>

    <nav class="navbar-simple">
        <div class="container text-center">
            <a href="Catalogo.php" class="brand">LUNA<em>PICTURES</em> STORE</a>
        </div>
    </nav>

    <div class="checkout-wrapper">
        
        <?php if ($estado == 'pagar' && $total > 0): ?>
            
            <div class="total-banner">
                <h2>Total a Pagar</h2>
                <div class="amount">$<?php echo number_format($total, 2); ?> MXN</div>
            </div>

            <?php if ($is_logged_in): ?>
                <!-- ✅ VISTA PARA USUARIOS YA LOGUEADOS (Tienen ambas opciones) -->
                <div class="option-card" style="border-top: 4px solid #28a745; max-width: 600px; margin: 0 auto;">
                    <div class="logged-in-badge">
                        <i class="fas fa-check-circle"></i> Hola, <?php echo htmlspecialchars($user_name); ?>. Sesión iniciada.
                    </div>
                    <h3><i class="fas fa-shield-alt" style="color: #28a745;"></i> Proceder al Pago</h3>
                    <p>Tus datos de envío ya están en nuestro sistema. Elige tu método de pago preferido para completar tu compra de forma segura.</p>
                    
                    <div class="d-grid gap-3">
                        <!-- Botón PayPal -->
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_xclick" />
                            <input type="hidden" name="business" value="ventas@lunapictures.com.mx" />
                            <input type="hidden" name="item_name" value="Pedido Luna Pictures Store" />
                            <input type="hidden" name="amount" value="<?php echo number_format($total, 2, '.', ''); ?>" />
                            <input type="hidden" name="currency_code" value="MXN" />
                            <input type="hidden" name="quantity" value="1" />
                            <input type="hidden" name="return" value="https://lunapictures.com.mx/Vistas/pago.php?estado=ok" />
                            <input type="hidden" name="cancel_return" value="https://lunapictures.com.mx/Vistas/Cesta.php" />
                            
                            <button type="submit" class="btn-paypal">
                                <i class="fab fa-paypal"></i> Pagar con PayPal
                            </button>
                        </form>

                        <!-- Botón Stripe -->
                        <form action="../api/crear_pago_stripe.php" method="POST">
                            <input type="hidden" name="total" value="<?php echo $total; ?>">
                            <button type="submit" class="btn-stripe">
                                <i class="fab fa-stripe"></i> Pagar con Tarjeta (Stripe)
                            </button>
                        </form>
                    </div>
                </div>

            <?php else: ?>
                <!-- ✅ VISTA PARA INVITADOS (Solo PayPal + Prompt de Login para Stripe) -->
                <div class="options-grid">
                    
                    <!-- OPCIÓN 1: Pago con PayPal (Permitido para invitados) -->
                    <div class="option-card" style="border-top: 4px solid #0070ba;">
                        <h3><i class="fab fa-paypal" style="color: #0070ba;"></i> Pago con PayPal</h3>
                        <p>Paga de forma segura sin crear una cuenta en nuestro sitio. PayPal capturará tus datos de nombre y envío automáticamente.</p>
                        
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_xclick" />
                            <input type="hidden" name="business" value="ventas@lunapictures.com.mx" />
                            <input type="hidden" name="item_name" value="Pedido Luna Pictures Store" />
                            <input type="hidden" name="amount" value="<?php echo number_format($total, 2, '.', ''); ?>" />
                            <input type="hidden" name="currency_code" value="MXN" />
                            <input type="hidden" name="quantity" value="1" />
                            <input type="hidden" name="return" value="https://lunapictures.com.mx/Vistas/pago.php?estado=ok" />
                            <input type="hidden" name="cancel_return" value="https://lunapictures.com.mx/Vistas/Cesta.php" />
                            
                            <button type="submit" class="btn-paypal">
                                <i class="fab fa-paypal"></i> Pagar con PayPal
                            </button>
                        </form>
                    </div>

                    <!-- OPCIÓN 2: Iniciar Sesión para desbloquear Stripe -->
                    <div class="option-card" style="border-top: 4px solid #635bff;">
                        <h3><i class="fas fa-user-lock" style="color: #635bff;"></i> Pagar con Tarjeta (Stripe)</h3>
                        <p>Para pagar con tarjeta y garantizar que tengamos tus datos de envío correctos, <strong>es necesario iniciar sesión o registrarte</strong>.</p>
                        
                        <form id="checkoutLoginForm">
                            <input type="email" id="loginEmail" class="form-control-custom" placeholder="Tu correo electrónico" required>
                            <input type="password" id="loginPass" class="form-control-custom" placeholder="Tu contraseña" required>
                            
                            <button type="button" class="btn-stripe-login" onclick="loginAndPay()">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión para Pagar
                            </button>
                        </form>
                        
                        <div class="register-link">
                            ¿No tienes cuenta? <a href="Registro.php">Regístrate aquí</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php elseif ($estado == 'ok'): ?>
            <!-- VISTA DE ÉXITO (TU LÓGICA ORIGINAL INTACTA) -->
            <?php
            if (isset($_SESSION['cesta']) && !empty($_SESSION['cesta'])) {
                $codCli = $_SESSION['codCli'] ?? 1; 
                $fecha = date('Y-m-d H:i:s');
                
                $objPed = new Pedido(0, $codCli, $fecha);
                $objMet = new MetodosDAO();
                $objMet->RegistrarPedido($objPed);
                
                $ultimoPed = $objMet->numeroPed();
                $idPedido = $ultimoPed[0];

                foreach($_SESSION['cesta'] as $key => $value) {
                    $objDetalle = new DetallePedido($idPedido, $key, $value->cantidad, $value->color ?? '', $value->talla ?? '');
                    $objMet->RegistrarDetallePedido($objDetalle);
                }
                unset($_SESSION['cesta']);
            }
            ?>
            <div class="success-box">
                <i class="fas fa-check-circle success-icon"></i>
                <h2 style="color: #28a745; font-weight: 800; margin-bottom: 15px;">¡Pago Exitoso!</h2>
                <p style="color: #666; font-size: 1.1rem; margin-bottom: 30px;">Gracias por tu compra. Hemos recibido tu pago correctamente.</p>
                <a href="Catalogo.php" style="display: inline-block; background: #2c3e50; color: #fff; padding: 15px 40px; border-radius: 8px; text-decoration: none; font-weight: 700;">Seguir Comprando</a>
            </div>

        <?php else: ?>
            <div class="success-box">
                <i class="fas fa-exclamation-circle" style="font-size: 4rem; color: #dc3545; margin-bottom: 20px;"></i>
                <h2 style="font-weight: 800; margin-bottom: 15px;">Acceso No Válido</h2>
                <p style="color: #666; margin-bottom: 30px;">No pudimos procesar tu solicitud. Por favor, verifica tu carrito.</p>
                <a href="Cesta.php" style="display: inline-block; background: #2c3e50; color: #fff; padding: 15px 40px; border-radius: 8px; text-decoration: none; font-weight: 700;">Volver al Carrito</a>
            </div>
        <?php endif; ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function loginAndPay() {
        var email = $('#loginEmail').val();
        var pass = $('#loginPass').val();
        var btn = $('.btn-stripe-login');
        
        if(email === "" || pass === "") {
            alert("Por favor completa tus datos de acceso.");
            return;
        }

        btn.html('<i class="fas fa-spinner fa-spin"></i> Verificando...').prop('disabled', true);

        $.get('Valida.php', { txtUsu: email, txtPas: pass }, function(response) {
            console.log("Respuesta del servidor:", response);
            
            // Ajusta esta condición según lo que devuelva exactamente tu Valida.php
            if (response.toLowerCase().includes("usuario incorrecto") || response.toLowerCase().includes("error")) {
                alert("Correo o contraseña incorrectos. Intenta de nuevo o usa la opción de PayPal.");
                btn.html('<i class="fas fa-sign-in-alt"></i> Iniciar Sesión para Pagar').prop('disabled', false);
            } else {
                // Recarga la página para que PHP detecte la nueva sesión y muestre los botones de pago
                window.location.reload();
            }
        }).fail(function(xhr, status, error) {
            console.error("Error en la petición:", error);
            alert("Error de conexión al validar usuario. Revisa tu conexión o usa el pago con PayPal.");
            btn.html('<i class="fas fa-sign-in-alt"></i> Iniciar Sesión para Pagar').prop('disabled', false);
        });
    }
    </script>
</body>
</html>