<?php
// 1. Configuración inicial (ANTES de cualquier HTML)
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_start();
}

include '../DAO/MetodosDAO.php';

$error_msg = '';

// 2. Procesar el registro ANTES de enviar cualquier cosa al navegador
if (isset($_POST['btnEnviar'])) {
    $nom = trim($_POST['txtNom']);
    $cor = trim($_POST['txtCor']);
    $tel = trim($_POST['txtTel']);
    $pas = $_POST['txtPas'];
    $dir = trim($_POST['txtDir']);

    // Validación básica
    if (!empty($nom) && !empty($cor) && !empty($pas)) {
        try {
            // Usamos exactamente las mismas clases que tu código original
            $objCli = new Cliente(0, $nom, $cor, $tel, $pas, $dir);
            $metodos = new MetodosDAO();
            $resultado = $metodos->RegistrarCliente($objCli);
            
            if ($resultado == 1) {
                // Registro exitoso: Guardamos datos en sesión para que no tenga que loguearse de nuevo
                $_SESSION['acceso'] = true;
                $_SESSION['nombre'] = $nom;
                
                // Redirección limpia (funciona porque aún no hemos enviado HTML)
                header("Location: Cesta.php");
                exit; // Detenemos la ejecución aquí para evitar errores
            } else {
                $error_msg = "No se pudo completar el registro. Es posible que este correo ya esté registrado.";
            }
        } catch (Exception $e) {
            // Si algo falla en la base de datos, capturamos el error en lugar de mostrar un Error 500
            $error_msg = "Ocurrió un error al procesar tu registro. Por favor, intenta de nuevo o contacta a soporte.";
        }
    } else {
        $error_msg = "Por favor, completa todos los campos obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta | Luna Pictures Store</title>
    <meta name="description" content="Regístrate en Luna Pictures Store para comprar playeras y accesorios de cine, rastrear tus pedidos y recibir ofertas exclusivas.">
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ESTILOS DIRECTOS E INFALIBLES -->
    <style>
        body {
            background-color: #f4f6f8;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar-simple {
            background: #fff;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 40px;
        }
        .navbar-simple .brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2c3e50;
            text-decoration: none;
        }
        .navbar-simple .brand em {
            color: #e94560;
            font-style: normal;
        }

        .register-wrapper {
            max-width: 500px;
            margin: 0 auto;
            padding: 0 20px 60px 20px;
        }

        .register-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e1e4e8;
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .register-header p {
            color: #666;
            font-size: 0.95rem;
        }

        .form-group-custom {
            margin-bottom: 20px;
        }
        .form-group-custom label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .form-control-custom {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
        }
        .form-control-custom:focus {
            outline: none;
            border-color: #e94560;
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background-color: #e94560;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }
        .btn-register:hover {
            background-color: #c73650;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e1e4e8;
            font-size: 0.95rem;
            color: #666;
        }
        .login-link a {
            color: #e94560;
            text-decoration: none;
            font-weight: 700;
        }
        .login-link a:hover {
            text-decoration: underline;
        }

        .alert-custom {
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-danger-custom {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>

    <!-- Navbar Simple -->
    <nav class="navbar-simple">
        <div class="container text-center">
            <a href="Catalogo.php" class="brand">LUNA<em>PICTURES</em> STORE</a>
        </div>
    </nav>

    <div class="register-wrapper">
        <div class="register-card">
            
            <div class="register-header">
                <h2><i class="fas fa-user-plus" style="color: #e94560;"></i> Crear Cuenta</h2>
                <p>Regístrate para comprar, rastrear tus pedidos y recibir ofertas exclusivas.</p>
            </div>

            <!-- Mensaje de error (solo se muestra si algo falla) -->
            <?php if (!empty($error_msg)): ?>
                <div class="alert-custom alert-danger-custom">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($error_msg); ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" id="registroclientes">
                <div class="form-group-custom">
                    <label for="name">Nombre Completo *</label>
                    <input name="txtNom" type="text" class="form-control-custom" id="name" placeholder="Ej. Juan Pérez" required>
                </div>

                <div class="form-group-custom">
                    <label for="email">Correo Electrónico *</label>
                    <input name="txtCor" type="email" class="form-control-custom" id="email" placeholder="tucorreo@ejemplo.com" required>
                </div>

                <div class="form-group-custom">
                    <label for="tel">Teléfono</label>
                    <input name="txtTel" type="tel" class="form-control-custom" id="tel" placeholder="Ej. 33 1234 5678">
                </div>

                <div class="form-group-custom">
                    <label for="dir">Dirección de Envío</label>
                    <input name="txtDir" type="text" class="form-control-custom" id="dir" placeholder="Calle, número, colonia, CP">
                </div>

                <div class="form-group-custom">
                    <label for="password">Contraseña *</label>
                    <input name="txtPas" type="password" class="form-control-custom" id="password" placeholder="Mínimo 6 caracteres" required minlength="6">
                </div>

                <button type="submit" name="btnEnviar" id="btnRegistro" class="btn-register">
                    <i class="fas fa-check-circle"></i> Guardar Datos y Continuar
                </button>
            </form>

            <div class="login-link">
                ¿Ya tienes una cuenta? <a href="#" onclick="window.location.href='Catalogo.php'; return false;">Volver a la tienda</a>
            </div>
            
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>