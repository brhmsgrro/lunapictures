<?php
// 1. Iniciar la sesión para poder manipularla
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_start();
}

// 2. Desactivar todas las variables de sesión (limpiar el carrito, nombre, acceso, etc.)
$_SESSION = array();

// 3. Si se usan cookies de sesión, es buena práctica borrar también la cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Destruir la sesión por completo
session_destroy();

// 5. Redirigir al catálogo (la tienda)
// Ajusta esta ruta si tu archivo principal está en otro lugar
header("Location: Catalogo.php");
exit; // Detener la ejecución inmediatamente
?>