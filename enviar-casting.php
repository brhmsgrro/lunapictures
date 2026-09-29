<?php

$nombre = $_POST["name"] ?? '';
$email = $_POST["email"] ?? '';
$phone = $_POST["phone"] ?? '';
$puesto = $_POST["puesto"] ?? '';
$link = $_POST["link"] ?? '';

$archivo = $_FILES["attach"];

if($archivo['error'] === 0){

    $tmpArchivo = $archivo['tmp_name'];

    // 🔥 Generar nombre limpio y corto
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombreSeguro = "cv_" . time() . "_" . rand(1000,9999) . "." . $extension;

    $rutaDestino = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $nombreSeguro;

    if(move_uploaded_file($tmpArchivo, $rutaDestino)){
        echo "Archivo subido bien<br>";
    } else {
        echo "Error al mover archivo<br>";
    }

} else {
    echo "Error en subida: " . $archivo['error'];
}

// 📁 Guardar archivo
$rutaDestino = "uploads/" . basename($nombreArchivo);
move_uploaded_file($tmpArchivo, $rutaDestino);

// 📧 Correo
$para = "casting@lunapictures.com.mx";
$asunto = "Nuevo casting de $nombre";

$mensaje = "Nombre: $nombre\n";
$mensaje .= "Correo: $email\n";
$mensaje .= "Teléfono: $phone\n";
$mensaje .= "Personaje: $puesto\n";
$mensaje .= "Reel: $link\n";
$mensaje .= "CV: https://lunapictures.com.mx/uploads/$nombreSeguro\n";

$headers = "From: $email";

mail($para, $asunto, $mensaje, $headers);

// 💾 Base de datos
$conn = mysqli_connect("localhost", "lunapict_contac", "3_32sM?=@c{r","lunapict_contactos");

$sql = "INSERT INTO informacionContactos (nombre, correo, mensaje) 
        VALUES ('$nombre', '$email', '$mensaje')";

mysqli_query($conn, $sql);

// ✅ Respuesta
echo "<script>alert('Gracias, te contactaremos pronto'); window.location.href='casting-en-gdl-talento-lunapictures.php';</script>";

?>