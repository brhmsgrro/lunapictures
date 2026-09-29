<?php

// Evitar errores visibles (pero se pueden loggear)
error_reporting(0);

// Validar existencia de datos
if(!isset($_POST['name'], $_POST['email'], $_POST['message'])){
    echo "error";
    exit;
}

// Limpiar datos
$nombre = trim($_POST['name']);
$email = trim($_POST['email']);
$mensaje_usuario = trim($_POST['message']);

// Validaciones básicas
if($nombre === "" || $email === "" || $mensaje_usuario === ""){
    echo "error";
    exit;
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "email_invalido";
    exit;
}

// Conexión DB
$conn = mysqli_connect("localhost", "lunapict_contac", "3_32sM?=@c{r","lunapict_contactos");

if(!$conn){
    echo "error_db";
    exit;
}

// Preparar query segura
$stmt = mysqli_prepare($conn, "INSERT INTO informacionContactos (nombre, correo, mensaje) VALUES (?, ?, ?)");

mysqli_stmt_bind_param($stmt, "sss", $nombre, $email, $mensaje_usuario);

$db_ok = mysqli_stmt_execute($stmt);

// Correo
$para = "contacto@lunapictures.com.mx";
$asunto = "Nuevo mensaje de $nombre";

$mensaje_email = "Nombre: $nombre\nCorreo: $email\nMensaje:\n$mensaje_usuario";

$headers = "From: contacto@lunapictures.com.mx\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$mail_ok = mail($para, $asunto, $mensaje_email, $headers);

// Respuesta final
if($db_ok){
    echo "1";
}else{
    echo "error";
}

?>
