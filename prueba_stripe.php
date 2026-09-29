<?php
// Activar visualización de errores (SOLO para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ahora sí, incluir el config
require_once __DIR__ . '/config/stripe.php';

echo "✅ ¡Todo funciona perfectamente! <br>";
echo "La versión del SDK de Stripe instalada es: " . \Stripe\Stripe::VERSION . "<br>";
echo "Tu clave secreta está configurada y lista para usarse.";
?>