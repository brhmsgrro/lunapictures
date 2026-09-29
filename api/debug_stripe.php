<?php
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_start();
}

echo "<h2>Debug de Sesión - Carrito</h2>";

if (empty($_SESSION['cesta'])) {
    echo "<p style='color:red'>⚠️ El carrito está VACÍO</p>";
} else {
    echo "<p style='color:green'>✅ El carrito tiene " . count($_SESSION['cesta']) . " productos</p>";
    echo "<pre>";
    foreach ($_SESSION['cesta'] as $key => $item) {
        echo "\n=== Producto KEY: $key ===\n";
        echo "Tipo: " . (is_object($item) ? 'OBJETO' : 'ARRAY') . "\n";
        
        if (is_object($item)) {
            echo "Propiedades:\n";
            print_r($item);
        } else {
            echo "Keys del array: " . implode(', ', array_keys($item)) . "\n";
            print_r($item);
        }
    }
    echo "</pre>";
}
?>