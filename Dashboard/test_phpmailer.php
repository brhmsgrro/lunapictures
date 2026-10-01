<?php
echo "<h2>Test PHPMailer</h2>";

// Verificar rutas
$paths = [
    'vendor/autoload.php' => __DIR__ . '/vendor/autoload.php',
    'PHPMailer/src/PHPMailer.php' => __DIR__ . '/PHPMailer/src/PHPMailer.php',
    '../vendor/autoload.php' => __DIR__ . '/../vendor/autoload.php',
];

foreach ($paths as $name => $path) {
    echo "<p><strong>$name:</strong> " . (file_exists($path) ? '✅ ENCONTRADO' : '❌ NO EXISTE') . "</p>";
    echo "<p style='font-size:11px;color:#666;'>Ruta: $path</p>";
}

// Listar archivos en Dashboard
echo "<hr><h3>Archivos en Dashboard:</h3>";
$files = scandir(__DIR__);
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        echo "- $file<br>";
    }
}
?>