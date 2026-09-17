<?php
include '../DAO/MetodosAdmin.php';


$usu=$_REQUEST ['txtMail'];
$pas=$_REQUEST ['txtPas'];

$objMetodos=new MetodosAdmin ();
$lista=$objMetodos->ValidarUsuario ($usu, $pas);

if (sizeof($lista)>0) { 
	session_start();
     $_SESSION ['accesoAdmin']=true;
    
     header("Location: Productos.php");	
} else {
	header("Location: Login.php?error=Usuario Incorrecto");
}




?>