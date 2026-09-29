<?php
header('Content-Type: application/json; charset=utf-8');

include '../DAO/MetodosAdmin.php';

$id_categoria = $_GET['id_categoria'] ?? 0;

if (!$id_categoria) {
    echo json_encode(['tallas' => []]);
    exit;
}

try {
    $objMetodos = new MetodosAdmin();
    
    // Primero intentamos obtener tallas
    $tallas = $objMetodos->ListarAtributosCategoria($id_categoria, 'talla');
    
    // Si no hay tallas, intentamos con 'tamano' (para posters, etc.)
    if (empty($tallas)) {
        $tallas = $objMetodos->ListarAtributosCategoria($id_categoria, 'tamano');
    }
    
    echo json_encode(['tallas' => $tallas]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>