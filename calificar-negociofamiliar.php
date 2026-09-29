<?php 
	$conn = mysqli_connect("hv30svg121", "lunapict_rating", "2DHlbnpbUfkk","lunapict_RatingSystem");


    $rating = $_POST["rating"];

    $para = "contacto@lunapictures.com.mx";
  $asunto = "Han calificado NEGOCIO FAMILIAR PROS Y CONTRAS con:";
  $mensaje = " puntuacion: ".$rating." ";

  mail($para,$asunto, utf8_decode($mensaje));
	

	 $sql = "INSERT INTO stars (numstrellas) VALUES ('$rating')";
	echo mysqli_query($conn, $sql);
 ?>