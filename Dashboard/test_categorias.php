<?php
include '../DAO/MetodosAdmin.php';

// Primero agrega estos métodos a MetodosAdmin.php (te los paso abajo)
$metodos = new MetodosAdmin();

echo "<h2>1. Categorías disponibles:</h2><pre>";
print_r($metodos->ListarCategorias());
echo "</pre>";

echo "<h2>2. Tallas de Playeras (id=1):</h2><pre>";
print_r($metodos->ListarAtributosCategoria(1, 'talla'));
echo "</pre>";

echo "<h2>3. Tamaños de Posters (id=5):</h2><pre>";
print_r($metodos->ListarAtributosCategoria(5, 'tamano'));
echo "</pre>";
?>