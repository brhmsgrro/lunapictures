<?php
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_start();
}
include '../DAO/MetodosDAO.php';
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Playeras de Cine | Luna Pictures Store</title>
    <meta name="description" content="Playeras, gorras y accesorios para amantes del cine y emprendedores. Envíos a todo México.">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Estilos de la tienda -->
    <link rel="stylesheet" href="../css/tienda-styles.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="store-navbar">
        <div class="container">
            <a href="#" class="store-logo">LUNA<em>PICTURES</em> STORE</a>
            <ul class="store-nav-links">
                <li><a href="Cesta.php"><i class="fas fa-shopping-cart cart-icon"></i></a></li>
                <?php if (!isset($_SESSION['acceso']) || $_SESSION['acceso'] !== true): ?>
                    <li><a href="Registro.php">Registrarse</a></li>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</a></li>
                <?php else: ?>
                    <li><span>Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span></li>
                    <li><a href="CerrarSesionTienda.php">Salir</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="store-hero">
        <h1>Viste tu Pasión por el Cine</h1>
        <p>Playeras, gorras y accesorios exclusivos para cinéfilos y emprendedores</p>
    </section>

    <!-- Benefits Bar -->
    <div class="benefits-bar">
        <div class="container">
            <div class="benefit-item">
                <i class="fas fa-truck"></i>
                <span>Envíos a todo México en 24-48 hrs</span>
            </div>
            <div class="benefit-item">
                <i class="fas fa-shield-alt"></i>
                <span>Pago 100% Seguro</span>
            </div>
            <div class="benefit-item">
                <i class="fas fa-star"></i>
                <span>Serigrafía de Alta Calidad</span>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <section class="products-section">
        <div class="section-header">
            <h2>Catálogo de Productos</h2>
            <p>Camisetas estampadas con los personajes y frases favoritas del séptimo arte</p>
        </div>

        <div class="products-grid">
            <?php
            $objMetodos = new MetodosDAO();
            $lista = $objMetodos->ListarProductos();
            
            if ($lista && count($lista) > 0) {
                foreach ($lista as $reg) {
                    $id = htmlspecialchars($reg[0]);
                    $nombre = htmlspecialchars($reg[1]);
                    $precio = htmlspecialchars($reg[2]);
                    $imagen = htmlspecialchars($reg[6]);
            ?>
            <div class="product-card">
                <img src="../images/<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>" class="product-image">
                <div class="product-info">
                    <h3 class="product-title"><?php echo $nombre; ?></h3>
                    <div class="product-price">$<?php echo $precio; ?> MXN</div>
                    <button class="btn-view" data-bs-toggle="modal" data-bs-target="#productModal" onclick="cargarProducto(<?php echo $id; ?>)">
                        <i class="fas fa-eye"></i> Ver Detalles
                    </button>
                </div>
            </div>
            <?php
                }
            } else {
                echo '<div class="col-12 text-center"><p>No hay productos disponibles</p></div>';
            }
            ?>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <h2>¿Tienes dudas?</h2>
            <form class="contact-form" id="contactForm">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Mensaje</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Enviar Mensaje</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="store-footer">
        <p>&copy; <?php echo date('Y'); ?> Luna Pictures Store. Todos los derechos reservados.</p>
        <p>¿Dudas? Escríbenos: <a href="https://wa.me/52333323863611"><i class="fab fa-whatsapp"></i> 33 3323 8636</a></p>
        <ul class="social-links">
            <li><a href="#"><i class="fab fa-facebook"></i></a></li>
            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
        </ul>
    </footer>

    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle del Producto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="productDetail">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Iniciar Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="email" id="loginEmail" class="form-control mb-3" placeholder="Correo">
                    <input type="password" id="loginPass" class="form-control mb-3" placeholder="Contraseña">
                    <button class="btn btn-primary w-100" onclick="login()">Entrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
    function cargarProducto(id) {
        $('#productDetail').load('Detalle.php?cod=' + id);
    }

    function login() {
        var email = $('#loginEmail').val();
        var pass = $('#loginPass').val();
        
        $.get('Valida.php?txtUsu=' + email + '&txtPas=' + pass, function(response) {
            if(response === "Usuario Incorrecto") {
                alert('Credenciales incorrectas');
            } else {
                location.reload();
            }
        });
    }

    $('#contactForm').submit(function(e) {
        e.preventDefault();
        $.post('../enviar-tienda.php', $(this).serialize(), function(r) {
            alert(r == 1 ? 'Mensaje enviado' : 'Error al enviar');
        });
    });
    </script>
</body>
</html>