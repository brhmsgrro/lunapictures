<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$nombre  = trim($_POST["name"] ?? '');
$email   = trim($_POST["email"] ?? '');
$mensaje = trim($_POST["message"] ?? '');

/* validar */
if(!$nombre || !$email || !$mensaje){
echo 0;
exit;
}

/* sanitizar */
$nombre  = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
$email   = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$mensaje = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');

/* correo */
$para = "servicios@lunapictures.com.mx";
$asunto = "Nuevo mensaje de $nombre";

$contenido = "Nombre: $nombre\n";
$contenido .= "Correo: $email\n";
$contenido .= "Mensaje:\n$mensaje";

/* headers UTF8 */
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
$headers .= "From: $email" . "\r\n";

@mail($para, $asunto, $contenido, $headers);

/* base de datos */
$conn = mysqli_connect(
"localhost",
"lunapict_contac",
"3_32sM?=@c{r",
"lunapict_contactos"
);

if(!$conn){
echo 0;
exit;
}

/* prepared statement (seguro) */
$stmt = mysqli_prepare($conn,
"INSERT INTO informacionContactos (nombre, correo, mensaje) VALUES (?, ?, ?)"
);

mysqli_stmt_bind_param($stmt, "sss", $nombre, $email, $mensaje);

if(mysqli_stmt_execute($stmt)){
echo 1;
}else{
echo 0;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

}
?>
