<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../DAO/MetodosDAO.php';

$cod = $_REQUEST['cod'] ?? 0;

if (!$cod) {
    echo '<div class="text-center text-danger py-5"><h4>Producto no encontrado</h4></div>';
    exit;
}

try {
    $objMetodos = new MetodosDAO();
    $lista = $objMetodos->ListarProductosCod($cod);

    if (!$lista) {
        echo '<div class="text-center text-danger py-5"><h4>Producto no disponible</h4></div>';
        exit;
    }

    $nombre = htmlspecialchars($lista[1] ?? 'Producto');
    $precio = htmlspecialchars($lista[2] ?? '0');
    $detalle = htmlspecialchars($lista[5] ?? 'Producto de alta calidad');
    $estado = htmlspecialchars($lista[4] ?? 'Activo');
    $id_categoria = isset($lista[7]) ? (int)$lista[7] : 1;
    $envioNumero = isset($lista[8]) ? (int)$lista[8] : 150;

    switch($envioNumero) {
        case 0: $envio = "Envío Gratuito"; break;
        case 150: $envio = "Envío Estándar ($150 MXN)"; break;
        default: $envio = "Envío: $" . $envioNumero . " MXN";
    }

    $imagen = $lista[6] ?? 'default.jpg';
    if (method_exists($objMetodos, 'ListarImagenPrincipalProducto')) {
        $imgPrincipal = $objMetodos->ListarImagenPrincipalProducto($cod);
        if ($imgPrincipal) {
            $imagen = $imgPrincipal;
        }
    }

} catch (Exception $e) {
    die("<h3 style='color:red;'>Error al cargar el producto:</h3><pre>" . $e->getMessage() . "</pre>");
}
?>

<style>
.product-detail-modal { padding: 10px; }
.product-image-wrapper { background: #f8f9fa; border-radius: 16px; padding: 30px; display: flex; align-items: center; justify-content: center; min-height: 400px; margin-bottom: 20px; }
.product-detail-image { max-width: 100%; max-height: 450px; height: auto; object-fit: contain; border-radius: 8px; transition: opacity 0.3s ease-in-out; }
.product-detail-title { font-size: 1.8rem; font-weight: 800; color: #2c3e50; margin-bottom: 15px; line-height: 1.3; }
.product-detail-price { font-size: 2.2rem; font-weight: 800; color: #e94560; margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 12px; text-align: center; }
.product-detail-description { margin-bottom: 25px; padding: 20px; background: #fff; border-left: 4px solid #e94560; border-radius: 8px; }
.product-detail-description p { margin-bottom: 10px; color: #6c757d; line-height: 1.6; }
.shipping-info { font-size: 0.9rem; color: #2c3e50; font-weight: 600; margin-top: 15px; }
.shipping-info i { color: #e94560; margin-right: 8px; }
.form-group-custom { margin-bottom: 20px; }
.form-label-custom { display: block; font-weight: 700; color: #2c3e50; margin-bottom: 10px; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; }
.form-control-custom { width: 100%; padding: 12px 15px; border: 2px solid #dee2e6; border-radius: 8px; font-size: 1rem; transition: all 0.3s; background: #fff; }
.form-control-custom:focus { outline: none; border-color: #e94560; box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1); }
.size-selector { display: flex; gap: 10px; flex-wrap: wrap; }
.size-option { flex: 1; min-width: 60px; cursor: pointer; }
.size-option input[type="radio"] { display: none; }
.size-option span { display: block; padding: 12px; border: 2px solid #dee2e6; border-radius: 8px; text-align: center; font-weight: 700; transition: all 0.3s; background: #fff; }
.size-option:hover span { border-color: #e94560; background: rgba(233, 69, 96, 0.05); }
.size-option input[type="radio"]:checked + span { background: #e94560; color: #fff; border-color: #e94560; }
.btn-add-to-cart { width: 100%; padding: 16px; background: #e94560; color: #fff; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: all 0.3s; margin-top: 10px; box-shadow: 0 4px 12px rgba(233, 69, 96, 0.3); }
.btn-add-to-cart:hover { background: #c73650; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(233, 69, 96, 0.4); }
.btn-add-to-cart i { margin-right: 10px; }
</style>

<div class="product-detail-modal">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="product-image-wrapper">
                <img id="imagenPrincipalProducto" src="../images/<?php echo htmlspecialchars($imagen); ?>" alt="<?php echo $nombre; ?>" class="product-detail-image">
            </div>
        </div>
        
        <div class="col-md-6">
            <h3 class="product-detail-title"><?php echo $nombre; ?></h3>
            <div class="product-detail-price">$<?php echo number_format($precio, 2); ?> MXN</div>
            
            <div class="product-detail-description">
                <p><?php echo $detalle; ?></p>
                <p class="shipping-info"><i class="fas fa-truck"></i> <?php echo $envio; ?></p>
            </div>
            
            <form action="../DAO/TiendaDAO.php" method="GET" id="formAgregarCarrito" class="product-form">
                <div class="form-group-custom">
                    <label class="form-label-custom">Cantidad:</label>
                    <input type="number" min="1" max="100" value="1" name="txtCan" class="form-control-custom">
                </div>
                
                <div class="form-group-custom">
                    <label class="form-label-custom">Talla / Tamaño:</label>
                    <div class="size-selector">
                        <?php
                        $tallasDisponibles = ['Única']; 
                        if (method_exists($objMetodos, 'ListarTallasPorProducto')) {
                            $tallasEncontradas = $objMetodos->ListarTallasPorProducto($cod);
                            if (!empty($tallasEncontradas)) {
                                $tallasDisponibles = $tallasEncontradas;
                            }
                        }

                        foreach ($tallasDisponibles as $index => $talla) {
                            $checked = ($index === 0) ? 'checked' : ''; 
                            echo '<label class="size-option">';
                            echo '<input type="radio" name="talla" value="' . htmlspecialchars($talla) . '" ' . $checked . '>';
                            echo '<span>' . htmlspecialchars($talla) . '</span>';
                            echo '</label>';
                        }
                        ?>
                    </div>
                </div>
                
                <?php if (in_array($id_categoria, [1, 2])): ?>
<div class="form-group-custom">
    <label class="form-label-custom">Color:</label>
    <select name="color" id="colorSelector" class="form-control-custom" 
            onchange="cambiarImagenPorColor(<?php echo $cod; ?>, this.value)">
        <option value="Estándar">Estándar</option>
        <option value="Negro">Negro</option>
        <option value="Blanco">Blanco</option>
        <option value="Rojo">Rojo</option>
        <option value="Azul">Azul</option>
        <option value="Gris">Gris</option>
        <option value="Rosa">Rosa</option>
        <option value="Verde">Verde</option>
    </select>
</div>
<?php else: ?>
<input type="hidden" name="color" value="Estándar">
<?php endif; ?>
                
                <button type="button" class="btn-add-to-cart" onclick="document.getElementById('formAgregarCarrito').submit()">
                    <i class="fas fa-shopping-cart"></i> Agregar al Carrito
                </button>
                
                <input type="hidden" name="id" value="<?php echo $cod; ?>">
                <input type="hidden" name="accion" value="agregar">
                <input type="hidden" name="op" value="2">
            </form>
        </div>
    </div>
</div>

<script>
function cambiarImagenPorColor(codProducto, colorSeleccionado) {
    console.log("🎨 Color seleccionado:", colorSeleccionado);
    
    if (!colorSeleccionado) return;
    
    const imgElement = document.getElementById('imagenPrincipalProducto');
    if (!imgElement) return;
    
    // Limpiamos el color: minúsculas y sin espacios
    const colorLimpio = colorSeleccionado.toLowerCase().replace(/\s+/g, '');
    console.log("🔍 Buscando en la BD la palabra:", colorLimpio);
    
    imgElement.style.opacity = '0.5';
    
    fetch('obtener_imagen_color.php?cod=' + codProducto + '&color=' + colorLimpio)
        .then(response => response.json())
        .then(data => {
            console.log("📦 Respuesta de la BD:", data);
            
            if (data.ruta && data.ruta !== 'default.jpg') {
                console.log("✅ ¡Encontrada! Aplicando:", data.ruta);
                // Usamos ruta absoluta para evitar errores de carpetas
                imgElement.src = '/images/' + data.ruta; 
            } else {
                console.warn("⚠️ No se encontró una imagen específica para '" + colorLimpio + "'.");
                console.warn("💡 PISTA: Revisa en phpMyAdmin que el nombre del archivo contenga la palabra '" + colorLimpio + "'");
            }
            imgElement.style.opacity = '1';
        })
        .catch(error => {
            console.error("❌ Error de conexión:", error);
            imgElement.style.opacity = '1';
        });
}
</script>

