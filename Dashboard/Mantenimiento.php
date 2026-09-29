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
        $img = $_REQUEST['img_anterior'] ?? ''; 
        if (empty($img) && isset($_REQUEST['txtCod'])) {
            $listaActual = $metodos->ListarProductosCod($_REQUEST['txtCod']);
            $img = $listaActual[6] ?? 'default.jpg';
        }

        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK && !empty($_FILES['archivo']['name'])) {
            $nombreOriginal = $_FILES['archivo']['name'];
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            $img = "prod_" . time() . "_" . rand(100, 999) . "." . $extension;
            $target_path = "../images/" . $img;
            
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (in_array($_FILES['archivo']['type'], $tiposPermitidos)) {
                move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path);
                if (!empty($listaActual[6]) && file_exists("../images/" . $listaActual[6])) {
                    unlink("../images/" . $listaActual[6]);
                }
            }
        }

        $objPro = new Producto($_REQUEST['txtCod'], $_REQUEST['txtDes'], $_REQUEST['txtPre'], $_REQUEST['txtCan'], $_REQUEST['selectEstado'], $_REQUEST['txtDetalle'], $img, $_REQUEST['txtEnvio'] ?? 'Envío estándar');
        $id_categoria = $_REQUEST['txtCategoria'] ?? 1;

        $metodos->editarProductoConCategoria($objPro, $id_categoria);
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