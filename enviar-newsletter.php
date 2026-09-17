<?php

  $nombre = $_POST["name"];
  $email = $_POST["email"];
  

  $para = "newsletter@lunapictures.com.mx";
  $asunto = "Nuevo mensaje de $nombre";
  $mensaje = " correo: ".$email." se ha suscrito al newsletter  ";

  mail($para,$asunto, utf8_decode($mensaje)); 

$conn = mysqli_connect("svgs309", "lunapict_contac", "3_32sM?=@c{r","lunapict_contactos");

$sql = "INSERT INTO informacionContactos (nombre, correo, mensaje) VALUES ('$nombre', '$email', '$mensaje')";
  echo mysqli_query($conn, $sql);

 ?>