<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // =========================
    // DATOS DEL FORMULARIO
    // =========================

    $nombre     = trim($_POST['nombre'] ?? '');
    $edad       = trim($_POST['edad'] ?? '');
    $whatsapp   = trim($_POST['whatsapp'] ?? '');
    $instagram  = trim($_POST['instagram'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $mensaje    = trim($_POST['mensaje'] ?? '');

    // Honeypot anti spam
    $website = trim($_POST['website'] ?? '');

    // =========================
    // VALIDACIÓN ANTISPAM
    // =========================

    if($website != ''){
        exit;
    }

    // =========================
    // SANITIZAR
    // =========================

    $nombre     = htmlspecialchars($nombre);
    $edad       = htmlspecialchars($edad);
    $whatsapp   = htmlspecialchars($whatsapp);
    $instagram  = htmlspecialchars($instagram);
    $email      = htmlspecialchars($email);
    $mensaje    = htmlspecialchars($mensaje);

    // =========================
    // DESTINO
    // =========================

    $para = "acting@lunapictures.com.mx";

    // =========================
    // ASUNTO
    // =========================

    $asunto = "Nuevo lead seminario actuacion";

    // =========================
    // MENSAJE
    // =========================

    $mensaje_correo = "

Nuevo registro desde la landing del seminario.


==================================

Nombre:
$nombre

Edad:
$edad

WhatsApp:
$whatsapp

Instagram:
$instagram

Correo:
$email

==================================

Mensaje:

$mensaje

==================================

Fecha:
" . date('d/m/Y H:i:s') . "

IP:
" . $_SERVER['REMOTE_ADDR'] . "

";

    // =========================
    // HEADERS
    // =========================

    $headers = "From: Luna Pictures <acting@lunapictures.com.mx>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // =========================
    // ENVÍO
    // =========================

    if(mail($para, $asunto, $mensaje_correo, $headers)){

        // =========================
        // BASE DE DATOS
        // =========================

        $conn = mysqli_connect(
            "localhost",
            "lunapict_contac",
            "3_32sM?=@c{r",
            "lunapict_contactos"
        );

        if($conn){

            mysqli_set_charset($conn, "utf8");

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO informacionContactos
                (nombre, correo, mensaje)

                VALUES

                (?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "sss",
                $nombre,
                $email,
                $mensaje
            );

            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);

            mysqli_close($conn);
        }

        echo 1;

    } else {

        echo 0;

    }

    exit;
}
?>