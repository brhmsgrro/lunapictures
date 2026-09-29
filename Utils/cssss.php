<?php

class conexionDB {
	 public function getConexion () {
	 
	 	$cnx=new PDO ('mysql:host=hv30svg121; dbname=lunapict_tienda', 'lunapict_tendero' , 'VHb$h4YC7wfi' );


	 	return $cnx;
    } 

} 

?>