<?php
$to = 'Alv586@prodigy.net.mx'; // Tu email de prueba
$subject = 'Test de correo Luna Pictures';
$message = 'Si recibes esto, el mail() funciona';
$headers = 'From: ventas@lunapictures.com.mx' . "\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo 'Correo enviado exitosamente';
} else {
    echo 'Error al enviar correo';
}
?>