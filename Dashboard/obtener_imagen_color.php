<?php
header('Content-Type: application/json');
include '../DAO/MetodosDAO.php';

$cod = $_GET['cod'] ?? 0;
$color = $_GET['color'] ?? 'estandar';

$objMetodos = new MetodosDAO();

// Buscamos en la tabla producto_imagenes una ruta que contenga el color
// Ejemplo: si color es "negro", buscará "%negro%" en la ruta
$cnx = new ConexionDB();
$cn = $cnx->getConexion();
$res = $cn->prepare("SELECT ruta_imagen FROM producto_imagenes WHERE codpro = :cod AND ruta_imagen LIKE :color LIMIT 1");
$res->bindParam(':cod', $cod, PDO::PARAM_INT);
$res->bindValue(':color', '%' . $color . '%', PDO::PARAM_STR);
$res->execute();
$row = $res->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode(['ruta' => $row['ruta_imagen']]);
} else {
    // Si no encuentra la del color, devolvemos la principal
    $imgPrincipal = $objMetodos->ListarImagenPrincipalProducto($cod);
    echo json_encode(['ruta' => $imgPrincipal]);
}
?>