<?php 
include '../DAO/MetodosDAO.php';

$cod = $_REQUEST['cod'] ?? 0;

if (!$cod) {
    echo '<div class="text-center text-danger py-5">
            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
            <h4>Producto no encontrado</h4>
          </div>';
    exit;
}

$objMetodos = new MetodosDAO();
$lista = $objMetodos->ListarProductosCod($cod);

if (!$lista) {
    echo '<div class="text-center text-danger py-5">
            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
            <h4>Producto no disponible</h4>
          </div>';
    exit;
}

$nombre = htmlspecialchars($lista[1]);
$precio = htmlspecialchars($lista[2]);
$detalle = htmlspecialchars($lista[5] ?? 'Producto de alta calidad');
$imagen = htmlspecialchars($lista[6]);
$envio = htmlspecialchars($lista[7] ?? 'Envío estándar');
?>

<!-- ESTILOS PARA EL MODAL (Inline para que funcionen siempre) -->
<style>
.product-detail-modal {
    padding: 10px;
}

.product-image-wrapper {
    background: #f8f9fa;
    border-radius: 16px;
    padding: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
    margin-bottom: 20px;
}

.product-detail-image {
    max-width: 100%;
    max-height: 450px;
    height: auto;
    object-fit: contain;
    border-radius: 8px;
}

.product-detail-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: #2c3e50;
    margin-bottom: 15px;
    line-height: 1.3;
}

.product-detail-price {
    font-size: 2.2rem;
    font-weight: 800;
    color: #e94560;
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 12px;
    text-align: center;
}

.product-detail-description {
    margin-bottom: 25px;
    padding: 20px;
    background: #fff;
    border-left: 4px solid #e94560;
    border-radius: 8px;
}

.product-detail-description p {
    margin-bottom: 10px;
    color: #6c757d;
    line-height: 1.6;
}

.shipping-info {
    font-size: 0.9rem;
    color: #2c3e50;
    font-weight: 600;
    margin-top: 15px;
}

.shipping-info i {
    color: #e94560;
    margin-right: 8px;
}

.form-group-custom {
    margin-bottom: 20px;
}

.form-label-custom {
    display: block;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-control-custom {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s;
    background: #fff;
}

.form-control-custom:focus {
    outline: none;
    border-color: #e94560;
    box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
}

.size-selector {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.size-option {
    flex: 1;
    min-width: 60px;
    cursor: pointer;
}

.size-option input[type="radio"] {
    display: none;
}

.size-option span {
    display: block;
    padding: 12px;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    text-align: center;
    font-weight: 700;
    transition: all 0.3s;
    background: #fff;
}

.size-option:hover span {
    border-color: #e94560;
    background: rgba(233, 69, 96, 0.05);
}

.size-option input[type="radio"]:checked + span {
    background: #e94560;
    color: #fff;
    border-color: #e94560;
}

.btn-add-to-cart {
    width: 100%;
    padding: 16px;
    background: #e94560;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 10px;
    box-shadow: 0 4px 12px rgba(233, 69, 96, 0.3);
}

.btn-add-to-cart:hover {
    background: #c73650;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(233, 69, 96, 0.4);
}

.btn-add-to-cart i {
    margin-right: 10px;
}

@media (max-width: 768px) {
    .product-detail-image {
        max-height: 300px;
    }
    
    .product-detail-title {
        font-size: 1.4rem;
    }
    
    .product-detail-price {
        font-size: 1.8rem;
    }
    
    .size-option {
        min-width: 50px;
    }
    
    .size-option span {
        padding: 10px;
        font-size: 0.9rem;
    }
}
</style>

<!-- Detalle del Producto para Modal -->
<div class="product-detail-modal">
    <div class="row g-4">
        <!-- Columna de Imagen -->
        <div class="col-md-6">
            <div class="product-image-wrapper">
                <img src="../images/<?php echo $imagen; ?>" 
                     alt="<?php echo $nombre; ?>" 
                     class="product-detail-image">
            </div>
        </div>
        
        <!-- Columna de Información -->
        <div class="col-md-6">
            <h3 class="product-detail-title"><?php echo $nombre; ?></h3>
            
            <div class="product-detail-price">
                $<?php echo $precio; ?> MXN
            </div>
            
            <div class="product-detail-description">
                <p><?php echo $detalle; ?></p>
                <p class="shipping-info">
                    <i class="fas fa-truck"></i> <?php echo $envio; ?>
                </p>
            </div>
            
            <form action="../DAO/TiendaDAO.php" method="GET" id="formAgregarCarrito" class="product-form">
                <!-- Cantidad -->
                <div class="form-group-custom">
                    <label class="form-label-custom">Cantidad:</label>
                    <input type="number" 
                           min="1" 
                           max="100" 
                           value="1" 
                           name="txtCan" 
                           class="form-control-custom" 
                           id="cantidadProducto">
                </div>
                
                <!-- Talla -->
                <div class="form-group-custom">
                    <label class="form-label-custom">Talla:</label>
                    <div class="size-selector">
                        <label class="size-option">
                            <input type="radio" name="talla" value="XS" checked>
                            <span>XS</span>
                        </label>
                        <label class="size-option">
                            <input type="radio" name="talla" value="S">
                            <span>S</span>
                        </label>
                        <label class="size-option">
                            <input type="radio" name="talla" value="M">
                            <span>M</span>
                        </label>
                        <label class="size-option">
                            <input type="radio" name="talla" value="L">
                            <span>L</span>
                        </label>
                        <label class="size-option">
                            <input type="radio" name="talla" value="XL">
                            <span>XL</span>
                        </label>
                    </div>
                </div>
                
                <!-- Color -->
                <div class="form-group-custom">
                    <label class="form-label-custom">Color:</label>
                    <select name="color" id="color" class="form-control-custom">
                        <option value="Blanca">Blanca</option>
                        <option value="Negra">Negra</option>
                        <option value="Gris">Gris</option>
                        <option value="Rosa Pastel">Rosa Pastel</option>
                        <option value="Azul Royal">Azul Royal</option>
                        <option value="Azul Turquesa">Azul Turquesa</option>
                        <option value="Azul Marino">Azul Marino</option>
                        <option value="Rojo">Rojo</option>
                        <option value="Coral">Coral</option>
                    </select>
                </div>
                
                <!-- Botón Agregar al Carrito -->
                <button type="button" 
                        class="btn-add-to-cart" 
                        onclick="agregarAlCarritoModal()">
                    <i class="fas fa-shopping-cart"></i> Agregar al Carrito
                </button>
                
                <!-- Campos ocultos -->
                <input type="hidden" name="id" value="<?php echo $cod; ?>">
                <input type="hidden" name="accion" value="agregar">
                <input type="hidden" name="op" value="2">
            </form>
        </div>
    </div>
</div>

<script>
function agregarAlCarritoModal() {
    var form = document.getElementById('formAgregarCarrito');
    
    // Validar talla seleccionada
    var tallaSeleccionada = false;
    var tallas = form.querySelectorAll('input[name="talla"]');
    tallas.forEach(function(talla) {
        if (talla.checked) tallaSeleccionada = true;
    });
    
    if (!tallaSeleccionada) {
        alert('Por favor selecciona una talla');
        return;
    }
    
    // Enviar formulario
    form.submit();
}
</script>