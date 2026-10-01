<?php
include '../DAO/MetodosAdmin.php';

$op = $_REQUEST['op'] ?? 1;

$objMetodos = new MetodosAdmin();
$categorias = $objMetodos->ListarCategorias();

// Inicializar variables
$cod = "";
$des = "";
$pre = "";
$stock = "";
$estado = "";
$detalle = "";
$id_categoria = "";
$imagen_actual = "";
$color_base = "Estándar";
$envio = "150";

switch ($op) {
    case 1:
        break;

        case 2:
        $codplpk = $_REQUEST['cod'] ?? 0;
        $lista = $objMetodos->ListarProductosCod($codplpk);
        
        if ($lista) {
            $cod = $lista[0];
            $des = $lista[1];
            $pre = $lista[2];
            $stock = $lista[3];
            $estado = $lista[4];
            $detalle = $lista[5];
            $imagen_actual = $lista[6] ?? '';
            $id_categoria = $lista[7] ?? '';
            $envio = $lista[8] ?? '150';
            
            // ✅ CORRECCIÓN SEGURA: Obtener el color real directamente de la BD con protección anti-errores
            try {
                $cnx_temp = new ConexionDB();
                $cn_temp = $cnx_temp->getConexion();
                $sql_temp = "SELECT color FROM variantes_producto WHERE codpro = :cod LIMIT 1";
                $res_temp = $cn_temp->prepare($sql_temp);
                $res_temp->bindParam(':cod', $cod, PDO::PARAM_INT);
                $res_temp->execute();
                $row_temp = $res_temp->fetch(PDO::FETCH_ASSOC);
                
                if ($row_temp && !empty($row_temp['color'])) {
                    $color_base = $row_temp['color']; // ¡Aquí atrapamos "Blanco", "Negro", etc.!
                }
                $cn_temp = null;
            } catch (Exception $e) {
                // Si algo falla, no rompemos la página, solo usamos el valor por defecto
                $color_base = "Estándar";
            }
        }
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Producto | Luna Pictures Merchandising</title>
    <link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/4.4/examples/dashboard/dashboard.css" rel="stylesheet">
    
    <style>
        .form-label-pro { font-weight: 600; color: #495057; margin-bottom: 0.5rem; }
        .preview-imagen { max-width: 200px; max-height: 200px; border-radius: 8px; margin-top: 10px; border: 2px solid #dee2e6; }
        .talla-chip { display: inline-block; padding: 8px 16px; margin: 4px; border: 2px solid #dee2e6; border-radius: 20px; cursor: pointer; transition: all 0.2s; background: #fff; font-weight: 600; }
        .talla-chip:hover { border-color: #007bff; background: #e7f1ff; }
        .talla-chip.active { background: #007bff; color: #fff; border-color: #007bff; }
        .talla-chip input[type="checkbox"] { display: none; }
        .card-form { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .imagen-color-item { border-left: 4px solid #e94560; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Luna Pictures STORE</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="Cerrar.php">Cerrar Sesión</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="Productos.php"><span data-feather="home"></span> Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link active" href="#"><span data-feather="file"></span> Productos</a></li>
                        <li class="nav-item"><a class="nav-link" href="Pedidos.php"><span data-feather="shopping-cart"></span> Pedidos</a></li>
                        <li class="nav-item"><a class="nav-link" href="clientes.php"><span data-feather="users"></span> Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="Cerrar.php"><span data-feather="log-out"></span> Salir</a></li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $op == 1 ? 'Nuevo Producto' : 'Editar Producto' ?></h1>
                    <a href="Productos.php" class="btn btn-secondary btn-sm"><span data-feather="arrow-left"></span> Volver</a>
                </div>

                <div class="card card-form">
                    <div class="card-body">
                        <form enctype="multipart/form-data" action="Mantenimiento.php" method="POST" id="formProducto">
                            
                            <!-- Código y Categoría -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label-pro">Código</label>
                                        <input type="text" name="txtCod" value="<?= htmlspecialchars($cod) ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="form-label-pro">Categoría <span class="text-danger">*</span></label>
                                        <select name="txtCategoria" id="selectCategoria" class="form-control" required>
                                            <option value="">-- Selecciona una categoría --</option>
                                            <?php foreach ($categorias as $cat): ?>
                                                <option value="<?= $cat['id_categoria'] ?>" <?= $id_categoria == $cat['id_categoria'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($cat['nombre']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="form-group">
                                <label class="form-label-pro">Descripción <span class="text-danger">*</span></label>
                                <input type="text" name="txtDes" value="<?= htmlspecialchars($des) ?>" class="form-control" required>
                            </div>

                            <!-- Precio, Stock y Envío -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label-pro">Precio (MXN) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="txtPre" value="<?= htmlspecialchars($pre) ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label-pro">Stock <span class="text-danger">*</span></label>
                                        <input type="number" name="txtCan" value="<?= htmlspecialchars($stock) ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label-pro">Envío (MXN)</label>
                                        <select name="txtEnvio" class="form-control">
                                            <option value="0" <?= $envio == '0' ? 'selected' : '' ?>>Gratuito</option>
                                            <option value="150" <?= $envio == '150' ? 'selected' : '' ?>>Estándar ($150)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado y Color Base -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label-pro">Estado</label>
                                        <select name="selectEstado" class="form-control">
                                            <option value="nuevo" <?= $estado == 'nuevo' ? 'selected' : '' ?>>Nuevo</option>
                                            <option value="oferta" <?= $estado == 'oferta' ? 'selected' : '' ?>>Oferta</option>
                                            <option value="agotado" <?= $estado == 'agotado' ? 'selected' : '' ?>>Agotado</option>
                                            <option value="Activo" <?= $estado == 'Activo' ? 'selected' : '' ?>>Activo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label-pro">Color Base</label>
                                        <input type="text" name="txtColorBase" value="<?= htmlspecialchars($color_base) ?>" class="form-control" placeholder="Ej: Rojo, Negro, Único">
                                    </div>
                                </div>
                            </div>

                            <!-- Detalle -->
                            <div class="form-group">
                                <label class="form-label-pro">Detalle / Descripción larga</label>
                                <textarea name="txtDetalle" rows="3" class="form-control"><?= htmlspecialchars($detalle) ?></textarea>
                            </div>

                            <!-- Tallas dinámicas -->
                            <div class="form-group" id="grupoTallas" style="display: <?= !empty($id_categoria) ? 'block' : 'none' ?>;">
                                <label class="form-label-pro">Tallas disponibles</label>
                                <div id="contenedorTallas" class="mb-2">
                                    <?php
                                    if (!empty($id_categoria)) {
                                        $tallasExistentes = $objMetodos->ListarAtributosCategoria($id_categoria, 'talla');
                                        if (empty($tallasExistentes)) {
                                            $tallasExistentes = $objMetodos->ListarAtributosCategoria($id_categoria, 'tamano');
                                        }
                                        foreach ($tallasExistentes as $talla) {
                                            echo '<label class="talla-chip">';
                                            echo '<input type="checkbox" name="tallas[]" value="' . htmlspecialchars($talla) . '">';
                                            echo '<span>' . htmlspecialchars($talla) . '</span>';
                                            echo '</label>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Imagen Principal -->
                            <div class="form-group">
                                <label class="form-label-pro">Imagen Principal del Producto</label>
                                <input type="file" name="archivo" id="inputImagen" class="form-control-file" accept="image/*">
                                <?php if (!empty($imagen_actual)): ?>
                                    <div class="mt-2">
                                        <small class="text-muted">Imagen actual:</small><br>
                                        <img src="../images/<?= htmlspecialchars($imagen_actual) ?>" class="preview-imagen" alt="Imagen actual">
                                    </div>
                                <?php endif; ?>
                                <div id="previewNueva" class="mt-2"></div>
                            </div>

                                                    
                                                        <!-- Imágenes por Color -->
                            <div class="form-group">
                                <label class="form-label-pro">Imágenes Adicionales por Color</label>
                                <small class="text-muted d-block mb-2">Sube o verifica la imagen para cada color disponible</small>
                                
                                <div id="contenedorImagenesColores">
                                    <?php 
                                    // Si estamos editando (op=2) y tenemos un código de producto
                                    if ($op == 2 && !empty($cod)) {
                                        // Usamos $objMetodos (la variable correcta definida al inicio del archivo)
                                        $imagenesColores = $objMetodos->ListarImagenesProducto($cod);
                                        
                                        if (!empty($imagenesColores)) {
                                            foreach ($imagenesColores as $idx => $imgColor) {
                                                $colorAsociado = !empty($imgColor['color_asociado']) ? $imgColor['color_asociado'] : 'Estándar';
                                                $rutaImagen = $imgColor['ruta_imagen'];
                                                
                                                echo '<div class="card mb-2 imagen-color-item">';
                                                echo '<div class="card-body p-2">';
                                                echo '<div class="row align-items-center">';
                                                
                                                // 1. Selector de Color
                                                echo '<div class="col-4">';
                                                echo '<select name="colores_imagen[]" class="form-control form-control-sm" required>';
                                                $coloresOpts = ['Estándar', 'Negro', 'Blanco', 'Rojo', 'Azul', 'Gris', 'Rosa', 'Verde'];
                                                foreach ($coloresOpts as $cOpt) {
                                                    $selected = ($colorAsociado === $cOpt) ? 'selected' : '';
                                                    echo "<option value=\"$cOpt\" $selected>$cOpt</option>";
                                                }
                                                echo '</select>';
                                                echo '</div>';
                                                
                                                // 2. Input de Archivo
                                                echo '<div class="col-6">';
                                                echo '<input type="file" name="imagenes_colores[]" class="form-control-file form-control-sm" accept="image/*" onchange="previewImagen(this, ' . $idx . ')">';
                                                echo '</div>';
                                                
                                                // 3. Botón Eliminar
                                                echo '<div class="col-2">';
                                                echo '<button type="button" class="btn btn-danger btn-sm" onclick="this.closest(\'.imagen-color-item\').remove()">🗑️</button>';
                                                echo '</div>';
                                                
                                                echo '</div>'; // Fin row
                                                
                                                // 4. Preview de la imagen existente
                                                echo '<div class="mt-2">';
                                                echo '<small class="text-muted">Imagen actual guardada:</small><br>';
                                                echo '<img src="../images/' . htmlspecialchars($rutaImagen) . '" class="img-thumbnail" style="height: 60px; object-fit: cover;">';
                                                echo '</div>';
                                                
                                                echo '</div>'; // Fin card-body
                                                echo '</div>'; // Fin card
                                            }
                                        } else {
                                            echo '<div class="alert alert-info py-2"><small>No hay imágenes de colores guardadas aún para este producto.</small></div>';
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="agregarInputImagen()">
                                    + Agregar imagen para otro color
                                </button>
                                
                                <div id="previewImagenes" class="row mt-3"></div>
                            </div>
                                
                                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="agregarInputImagen()">
                                    + Agregar imagen para otro color
                                </button>
                                
                                <div id="previewImagenes" class="row mt-3"></div>
                            </div>
                                
                                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="agregarInputImagen()">
                                    + Agregar imagen para otro color
                                </button>
                                
                                <div id="previewImagenes" class="row mt-3"></div>
                            </div>

                            <input type="hidden" name="img_anterior" value="<?= htmlspecialchars($imagen_actual) ?>">
                            <input type="hidden" name="op" value="<?= $op ?>"/>

                            <div class="form-group mt-4">
                                <button type="submit" name="btnGuardar" class="btn btn-primary btn-lg">
                                    <span data-feather="save"></span> Guardar Producto
                                </button>
                                <a href="Productos.php" class="btn btn-secondary btn-lg ml-2">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.4/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    
    <script>
        feather.replace();

        // Agregar input de imagen por color
        function agregarInputImagen() {
            const contenedor = document.getElementById('contenedorImagenesColores');
            const index = contenedor.children.length;
            
            const html = `
                <div class="card mb-2 imagen-color-item">
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <select name="colores_imagen[]" class="form-control form-control-sm" required>
                                    <option value="">Color...</option>
                                    <option value="Negro">Negro</option>
                                    <option value="Blanco">Blanco</option>
                                    <option value="Rojo">Rojo</option>
                                    <option value="Azul">Azul</option>
                                    <option value="Gris">Gris</option>
                                    <option value="Rosa">Rosa</option>
                                    <option value="Verde">Verde</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="file" name="imagenes_colores[]" class="form-control-file form-control-sm" accept="image/*" onchange="previewImagen(this, ${index})">
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.imagen-color-item').remove()">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            contenedor.insertAdjacentHTML('beforeend', html);
        }

        // Preview de imágenes por color
        function previewImagen(input, index) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('previewImagenes');
                    preview.innerHTML += `
                        <div class="col-3 mb-2">
                            <img src="${e.target.result}" class="img-thumbnail" style="height: 80px;">
                        </div>
                    `;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Preview de imagen principal
        document.getElementById('inputImagen').addEventListener('change', function(e) {
            const preview = document.getElementById('previewNueva');
            preview.innerHTML = '';
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML = `
                        <small class="text-muted">Nueva imagen principal:</small><br>
                        <img src="${event.target.result}" class="preview-imagen" alt="Preview">
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        // Cargar tallas al cambiar categoría
        document.getElementById('selectCategoria').addEventListener('change', function() {
            const idCategoria = this.value;
            const grupoTallas = document.getElementById('grupoTallas');
            const contenedorTallas = document.getElementById('contenedorTallas');

            if (!idCategoria) {
                grupoTallas.style.display = 'none';
                contenedorTallas.innerHTML = '';
                return;
            }

            grupoTallas.style.display = 'block';
            contenedorTallas.innerHTML = '<span class="text-muted">Cargando tallas...</span>';

            fetch('obtener_tallas.php?id_categoria=' + idCategoria)
                .then(response => response.json())
                .then(data => {
                    contenedorTallas.innerHTML = '';
                    if (data.tallas && data.tallas.length > 0) {
                        data.tallas.forEach(talla => {
                            const label = document.createElement('label');
                            label.className = 'talla-chip';
                            label.innerHTML = `
                                <input type="checkbox" name="tallas[]" value="${talla}">
                                <span>${talla}</span>
                            `;
                            contenedorTallas.appendChild(label);
                        });
                    } else {
                        contenedorTallas.innerHTML = '<span class="text-muted">No hay tallas configuradas.</span>';
                    }
                })
                .catch(error => {
                    console.error('Error cargando tallas:', error);
                    contenedorTallas.innerHTML = '<span class="text-danger">Error al cargar tallas</span>';
                });
        });

        // Efecto visual en chips de tallas
        document.getElementById('contenedorTallas').addEventListener('change', function(e) {
            if (e.target.tagName === 'INPUT' && e.target.type === 'checkbox') {
                e.target.closest('.talla-chip').classList.toggle('active', e.target.checked);
            }
        });

        // Activar chips existentes al cargar
        document.querySelectorAll('.talla-chip input[type="checkbox"]:checked').forEach(cb => {
            cb.closest('.talla-chip').classList.add('active');
        });

        // Agregar un input por defecto al cargar
        document.addEventListener('DOMContentLoaded', function() {
            agregarInputImagen();
        });
    </script>
</body>
</html>