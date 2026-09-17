
<?php

  $nombre = $_POST["name"];
  $email = $_POST["email"];
  $mensaje = $_POST["message"];

  $para = "grabacion_audio@lunapictures.com.mx";
  $asunto = "Nuevo mensaje de $nombre";

  $mensaje = "
    Nombre del remitente: ".$nombre."
    correo: ".$email."
    mensaje: ".$mensaje."
  ";

  mail($para,$asunto,utf8_decode($mensaje)); 

   header ("location: enviado.html"); 



 ?>