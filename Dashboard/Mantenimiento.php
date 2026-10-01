<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../DAO/MetodosAdmin.php';

$op = $_REQUEST['op'] ?? 1;
$metodos = new MetodosAdmin();

switch ($op) {
    case 1: // === CREAR NUEVO PRODUCTO ===
        
        $img = "default.jpg";
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK && !empty($_FILES['archivo']['name'])) {
            $nombreOriginal = $_FILES['archivo']['name'];
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            $img = "prod_" . time() . "_" . rand(100, 999) . "." . $extension;
            $target_path = "../images/" . $img;
            
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (in_array($_FILES['archivo']['type'], $tiposPermitidos)) {
                move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path);
            } 
        }

        $objPro = new Producto(
            0, $_REQUEST['txtDes'], $_REQUEST['txtPre'], $_REQUEST['txtCan'], 
            $_REQUEST['selectEstado'], $_REQUEST['txtDetalle'], $img,
            $_REQUEST['txtEnvio'] ?? 'Envío estándar'
        );

        $id_categoria = $_REQUEST['txtCategoria'] ?? 1;
        $colorBase = $_REQUEST['txtColorBase'] ?? 'Estándar';

        $nuevoCod = $metodos->grabarProductoConCategoria($objPro, $id_categoria);

        if (isset($_REQUEST['tallas']) && is_array($_REQUEST['tallas'])) {
            foreach ($_REQUEST['tallas'] as $talla) {
                $sku = "SKU-" . $nuevoCod . "-" . strtoupper(substr($talla, 0, 3));
                $metodos->GuardarVariante($nuevoCod, $id_categoria, $colorBase, $talla, $sku, $_REQUEST['txtPre'], $_REQUEST['txtCan'], $img);
            }
        }

        // ✨ NUEVO: Guardar imágenes adicionales por color
        $primerImagenColorSubida = null; // <-- VARIABLE INICIALIZADA
        
        if (isset($_FILES['imagenes_colores']['name']) && is_array($_FILES['imagenes_colores']['name'])) {
            $colores = $_REQUEST['colores_imagen'] ?? [];
            
            foreach ($_FILES['imagenes_colores']['name'] as $index => $nombreArchivo) {
                if (!empty($nombreArchivo) && $_FILES['imagenes_colores']['error'][$index] === UPLOAD_ERR_OK) {
                    $colorSeleccionado = $colores[$index] ?? 'Estándar';
                    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                    $nombreImagenColor = "prod_" . $nuevoCod . "_" . strtolower(str_replace(' ', '', $colorSeleccionado)) . "_" . time() . "." . $extension;
                    
                    // ✨ ¡ESTA ERA LA LÍNEA QUE FALTABA!
                    if ($index === 0) { 
                        $primerImagenColorSubida = $nombreImagenColor; 
                    }

                    $rutaDestino = "../images/" . $nombreImagenColor;
                    
                    if (move_uploaded_file($_FILES['imagenes_colores']['tmp_name'][$index], $rutaDestino)) {
                        $metodos->GuardarImagenProducto($nuevoCod, null, $nombreImagenColor, 'color', $index, ($index === 0) ? 1 : 0);
                    }
                }
            }
        }

        // ✨ CORRECCIÓN: Actualizar la tabla productos con la primera imagen de color si no hay imagen principal
        if ($img === "default.jpg" && $primerImagenColorSubida !== null) {
            $cnx = new ConexionDB();
            $cn = $cnx->getConexion();
            $res = $cn->prepare("UPDATE productos SET imagen = :img WHERE codpro = :cod");
            $res->bindParam(':img', $primerImagenColorSubida, PDO::PARAM_STR);
            $res->bindParam(':cod', $nuevoCod, PDO::PARAM_INT);
            $res->execute();
        }

        header('Location: Productos.php?msg=creado');
        exit;
        break;

        case 2: // === EDITAR PRODUCTO ===
        $cod = $_REQUEST['txtCod'];
        $img = $_REQUEST['img_anterior'] ?? ''; 
        
        if (empty($img)) {
            $listaActual = $metodos->ListarProductosCod($cod);
            $img = $listaActual[6] ?? 'default.jpg';
        }

        // Manejo de nueva imagen principal
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK && !empty($_FILES['archivo']['name'])) {
            $nombreOriginal = $_FILES['archivo']['name'];
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            $img = "prod_" . time() . "_" . rand(100, 999) . "." . $extension;
            $target_path = "../images/" . $img;
            
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (in_array($_FILES['archivo']['type'], $tiposPermitidos)) {
                move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path);
                
                // Eliminar imagen anterior si existe y no es la default
                if (!empty($listaActual[6]) && $listaActual[6] !== 'default.jpg' && file_exists("../images/" . $listaActual[6])) {
                    unlink("../images/" . $listaActual[6]);
                }
            }
        }

        $objPro = new Producto($cod, $_REQUEST['txtDes'], $_REQUEST['txtPre'], $_REQUEST['txtCan'], $_REQUEST['selectEstado'], $_REQUEST['txtDetalle'], $img, $_REQUEST['txtEnvio'] ?? 'Envío estándar');
        $id_categoria = $_REQUEST['txtCategoria'] ?? 1;
        $colorBase = $_REQUEST['txtColorBase'] ?? 'Estándar';

        // 1. Actualizar la tabla principal de productos
        $metodos->editarProductoConCategoria($objPro, $id_categoria);

                // 2. ✨ ACTUALIZAR LAS VARIANTES (TALLAS) ✨
        $metodos->EliminarVariantesPorProducto($cod);

        if (isset($_REQUEST['tallas']) && is_array($_REQUEST['tallas']) && !empty($_REQUEST['tallas'])) {
            foreach ($_REQUEST['tallas'] as $talla) {
                $sku = "SKU-" . $cod . "-" . strtoupper(substr($talla, 0, 3));
                $metodos->GuardarVariante($cod, $id_categoria, $colorBase, $talla, $sku, $_REQUEST['txtPre'], $_REQUEST['txtCan'], $img);
            }
        } else {
            $sku = "SKU-" . $cod . "-UNI";
            $metodos->GuardarVariante($cod, $id_categoria, $colorBase, 'Única', $sku, $_REQUEST['txtPre'], $_REQUEST['txtCan'], $img);
        }

        // ✨ NUEVO: Registrar el Color Base como variante disponible (aunque no tenga imagen)
        // Esto asegura que el color principal siempre aparezca en el selector del frontend
        $skuColorBase = "SKU-" . $cod . "-BASE";
        $metodos->GuardarVariante($cod, $id_categoria, $colorBase, 'Única', $skuColorBase, $_REQUEST['txtPre'], $_REQUEST['txtCan'], $img);

                       // 3. ✨ ACTUALIZAR IMÁGENES POR COLOR AL EDITAR ✨
        if (isset($_FILES['imagenes_colores']['name']) && is_array($_FILES['imagenes_colores']['name'])) {
            $colores = $_REQUEST['colores_imagen'] ?? [];
            
            foreach ($_FILES['imagenes_colores']['name'] as $index => $nombreArchivo) {
                if (!empty($nombreArchivo) && $_FILES['imagenes_colores']['error'][$index] === UPLOAD_ERR_OK) {
                    $colorSeleccionado = $colores[$index] ?? 'Estándar';
                    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                    $nombreImagenColor = "prod_" . $cod . "_" . strtolower(str_replace(' ', '', $colorSeleccionado)) . "_" . time() . "." . $extension;
                    $rutaDestino = "../images/" . $nombreImagenColor;
                    
                    if (move_uploaded_file($_FILES['imagenes_colores']['tmp_name'][$index], $rutaDestino)) {
                        // Guardamos la imagen
                        $metodos->GuardarImagenProducto($cod, null, $nombreImagenColor, 'color', $index, 0);
                        
                        // ✨ NUEVO: Aseguramos que este color exista como variante
                        $skuColor = "SKU-" . $cod . "-" . strtoupper(substr($colorSeleccionado, 0, 3));
                        $metodos->GuardarVariante($cod, $id_categoria, $colorSeleccionado, 'Única', $skuColor, $_REQUEST['txtPre'], $_REQUEST['txtCan'], $img);
                    }
                } 
            }
        }
        header('Location: Productos.php?msg=editado');
        exit;
        break;

    case 3: // === ELIMINAR ===
        $cod = $_REQUEST['cod'];
        $lista = $metodos->ListarProductosCod($cod);
        if ($lista && !empty($lista[6])) {
            $rutaImagen = "../images/" . $lista[6];
            if (file_exists($rutaImagen)) unlink($rutaImagen);
        }
        $metodos->eliminarProducto($cod);
        header('Location: Productos.php?msg=eliminado');
        exit;
        break;

    default:
        header('Location: Productos.php');
        exit;
        break;
}
?>