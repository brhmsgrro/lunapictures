<?php
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_start();
}
include '../DAO/MetodosDAO.php';

// Configuración SEO Dinámica
$page_title = "Tienda de Merchandising de Cine | Playeras y Gorras Exclusivas - Luna Pictures Store";
$page_description = "Compra playeras, gorras y accesorios exclusivos para cinéfilos y emprendedores. Serigrafía de alta calidad, envíos a todo México en 24-48 hrs y pago seguro. ¡Viste tu pasión por el cine!";
$canonical_url = "https://lunapictures.com.mx/Vistas/Catalogo.php";
$image_url = "https://lunapictures.com.mx/images/tienda/camisetas-para-cinefilos-emprendedores.png"; // URL absoluta de la imagen generada anteriormente
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- SEO Básico -->
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $page_description; ?>">
    <link rel="canonical" href="<?php echo $canonical_url; ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $canonical_url; ?>">
    <meta property="og:title" content="<?php echo $page_title; ?>">
    <meta property="og:description" content="<?php echo $page_description; ?>">
    <meta property="og:image" content="<?php echo $image_url; ?>">
    <meta property="og:locale" content="es_MX">
    <meta property="og:site_name" content="Luna Pictures Store">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $page_title; ?>">
    <meta name="twitter:description" content="<?php echo $page_description; ?>">
    <meta name="twitter:image" content="<?php echo $image_url; ?>">
    
 <!-- Favicon -->
    <link rel="icon" href="/images/luna pictures audiovisual.ico" type="image/x-icon">
    

    <!-- Schema.org Structured Data (E-commerce) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Store",
      "name": "Luna Pictures Store",
      "description": "<?php echo $page_description; ?>",
      "url": "<?php echo $canonical_url; ?>",
      "logo": "https://lunapictures.com.mx/images/logo.png",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+52-33-3323-8636",
        "contactType": "sales",
        "areaServed": "MX",
        "availableLanguage": "Spanish"
      },
      "sameAs": [
        "https://www.facebook.com/lunapictures",
        "https://www.instagram.com/lunapictures"
      ]
    }
    </script>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/tienda-styles.css?v=6.0">
</head>
<body>

   <nav class="store-navbar">
    <div class="container">
        <a href="#" class="store-logo">LUNA<em>PICTURES</em>STORE</a>
        
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </label>

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

    <!-- Hero Section con H1 Principal -->
    <header class="store-hero">
        <div class="container">
            <h1>Viste tu Pasión por el Cine</h1>
            <p class="lead">Playeras, gorras y accesorios exclusivos para cinéfilos y emprendedores</p>
        </div>
    </header>

    <!-- Benefits Bar (Microdatos implícitos) -->
    <section class="benefits-bar" aria-label="Beneficios de compra">
        <div class="container">
            <div class="benefit-item">
                <i class="fas fa-truck" aria-hidden="true"></i>
                <span>Envíos a todo México en 24-48 hrs</span>
            </div>
            <div class="benefit-item">
                <i class="fas fa-shield-alt" aria-hidden="true"></i>
                <span>Pago 100% Seguro</span>
            </div>
            <div class="benefit-item">
                <i class="fas fa-star" aria-hidden="true"></i>
                <span>Serigrafía de Alta Calidad</span>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <main class="products-section">
        <div class="container">
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
                        
                        // Texto alt descriptivo para SEO de imágenes
                        $alt_text = "Playera o accesorio de cine: " . $nombre;
                ?>
                <article class="product-card" itemscope itemtype="https://schema.org/Product">
                    <meta itemprop="brand" content="Luna Pictures Store">
                    <img src="../images/<?php echo $imagen; ?>" 
                         alt="<?php echo $alt_text; ?>" 
                         class="product-image" 
                         loading="lazy"
                         width="300" 
                         height="300"
                         itemprop="image">
                    <div class="product-info">
                        <h3 class="product-title" itemprop="name"><?php echo $nombre; ?></h3>
                        <div class="product-price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                            <meta itemprop="priceCurrency" content="MXN">
                            <span itemprop="price">$<?php echo $precio; ?></span> MXN
                            <meta itemprop="availability" content="https://schema.org/InStock">
                        </div>
                        <button class="btn-view" 
                                data-bs-toggle="modal" 
                                data-bs-target="#productModal" 
                                onclick="cargarProducto(<?php echo $id; ?>)"
                                aria-label="Ver detalles de <?php echo $nombre; ?>">
                            <i class="fas fa-eye"></i> Ver Detalles
                        </button>
                    </div>
                </article>
                <?php
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>No hay productos disponibles en este momento.</p></div>';
                }
                ?>
            </div>
        </div>
    </main>

    <!-- Contact Section -->
    <section class="contact-section" aria-labelledby="contact-heading">
        <div class="container">
            <h2 id="contact-heading">¿Tienes dudas sobre nuestros productos?</h2>
            <form class="contact-form" id="contactForm" novalidate>
                <div class="form-group">
                    <label for="name">Nombre completo</label>
                    <input type="text" id="name" name="name" required autocomplete="name">
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" required autocomplete="email">
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
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Luna Pictures Store. Todos los derechos reservados.</p>
            <p>¿Dudas? Escríbenos: <a href="https://wa.me/523331970604" rel="noopener noreferrer" aria-label="Contactar por WhatsApp"><i class="fab fa-whatsapp"></i> 3331970604</a></p>
            <ul class="social-links" aria-label="Redes sociales">
                <li><a href="#" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook"></i></a></li>
                <li><a href="#" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#" rel="noopener noreferrer" aria-label="Twitter"><i class="fab fa-twitter"></i></a></li>
            </ul>
        </div>
    </footer>

    <!-- Modals (sin cambios mayores, solo accesibilidad) -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Detalle del Producto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
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

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="email" id="loginEmail" class="form-control mb-3" placeholder="Correo" aria-label="Correo electrónico">
                    <input type="password" id="loginPass" class="form-control mb-3" placeholder="Contraseña" aria-label="Contraseña">
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
        
        $.get('Valida.php?txtUsu=' + encodeURIComponent(email) + '&txtPas=' + encodeURIComponent(pass), function(response) {
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
            alert(r == 1 ? 'Mensaje enviado correctamente' : 'Error al enviar el mensaje');
        });
    });
    </script>
    
    <!-- Script global para cambio de imágenes por color -->
<script>
// Función global que estará disponible para todos los modales
window.cambiarImagenPorColor = function(codProducto, colorSeleccionado) {
    const imgElement = document.querySelector('#modalProducto img.product-detail-image');
    const colorLimpio = colorSeleccionado.toLowerCase().replace(/\s+/g, '');
    
    console.log("Buscando imagen para producto:", codProducto, "y color:", colorLimpio);
    
    if (imgElement) {
        imgElement.style.opacity = '0.5';
        
        fetch(`obtener_imagen_color.php?cod=${codProducto}&color=${colorLimpio}`)
            .then(response => response.json())
            .then(data => {
                console.log("Respuesta:", data);
                if (data.ruta) {
                    imgElement.src = '../images/' + data.ruta;
                }
                imgElement.style.opacity = '1';
            })
            .catch(error => {
                console.error("Error:", error);
                imgElement.style.opacity = '1';
            });
    }
};
</script>


</body>
</html>