<?php

  $nombre = $_POST["name"];
  $email = $_POST["email"];
  

  $para = "regalos@lunapictures.com.mx";
  $asunto = "Nuevo mensaje de $nombre";
  $mensaje = " correo: ".$email." Enviar pdf  ";

  mail($para,$asunto, utf8_decode($mensaje)); 

$conn = mysqli_connect("svgs309", "lunapict_contac", "3_32sM?=@c{r","lunapict_contactos");

$sql = "INSERT INTO informacionContactos (nombre, correo, mensaje) VALUES ('$nombre', '$email', '$mensaje')";
  echo mysqli_query($conn, $sql);

 ?>