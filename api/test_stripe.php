<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

echo "<h2>Diagnóstico del Sistema</h2>";

// 1. Verificar sesión
echo "<h3>1. Sesión:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// 2. Verificar si existe cesta
if (isset($_SESSION['cesta']) && !empty($_SESSION['cesta'])) {
    echo "✅ Carrito existe con " . count($_SESSION['cesta']) . " productos<br>";
} else {
    echo "❌ Carrito vacío o no existe<br>";
}

// 3. Verificar conexión a Stripe
try {
    require_once __DIR__ . '/../config/stripe.php';
    echo "✅ Stripe configurado correctamente<br>";
    echo "Clave: " . (defined('STRIPE_SECRET_KEY') ? 'Presente' : 'Ausente') . "<br>";
} catch (Exception $e) {
    echo "❌ Error con Stripe: " . $e->getMessage() . "<br>";
}

// 4. Verificar método DAO
try {
    include __DIR__ . '/../DAO/MetodosDAO.php';
    $dao = new MetodosDAO();
    echo "✅ MetodosDAO cargado correctamente<br>";
} catch (Exception $e) {
    echo "❌ Error con DAO: " . $e->getMessage() . "<br>";
}
?>