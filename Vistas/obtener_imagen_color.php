<?php
header('Content-Type: application/json');
// Ajusta esta ruta si tu archivo del frontend está en una carpeta diferente
include '../DAO/MetodosDAO.php'; 

$cod = $_GET['cod'] ?? 0;
$color = $_GET['color'] ?? 'estandar';

try {
    $cnx = new ConexionDB();
    $cn = $cnx->getConexion();
    
    // Buscamos una imagen que contenga el nombre del color en su archivo
    $res = $cn->prepare("SELECT ruta_imagen FROM producto_imagenes WHERE codpro = :cod AND ruta_imagen LIKE :color LIMIT 1");
    $res->bindParam(':cod', $cod, PDO::PARAM_INT);
    $res->bindValue(':color', '%' . $color . '%', PDO::PARAM_STR);
    $res->execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo json_encode(['ruta' => $row['ruta_imagen']]);
    } else {
        // Si no encuentra el color, devolvemos la imagen principal para que no se rompa
        $objMetodos = new MetodosDAO();
        $imgPrincipal = $objMetodos->ListarImagenPrincipalProducto($cod);
        echo json_encode(['ruta' => $imgPrincipal ?: 'default.jpg']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>