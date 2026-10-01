<?php
// Validamos que se haya pasado un ID por la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_cliente = $_GET['id'];
    
    // Incluimos los métodos de la base de datos
    include '../DAO/MetodosAdmin.php';
    
    $metodos = new MetodosAdmin();
    
    // Ejecutamos la eliminación
    $resultado = $metodos->EliminarCliente($id_cliente);
    
    if ($resultado) {
        // Si se eliminó correctamente, regresamos a la lista con un mensaje de éxito
        header("Location: clientes.php?mensaje=eliminado");
        exit();
    } else {
        echo "<h3>Error al intentar eliminar el cliente. Verifica que el registro exista.</h3>";
        echo "<a href='clientes.php'>Volver al listado</a>";
    }
} else {
    echo "<h3>ID de cliente no válido.</h3>";
    echo "<a href='clientes.php'>Volver al listado</a>";
}
?>