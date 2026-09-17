<?php
include '../DAO/MetodosDAO.php';
session_start();

$usu=$_REQUEST ['txtUsu'];
$pas=$_REQUEST ['txtPas'];
$_SESSION ['nombress']=10;

$objMetodos=new MetodosDAO ();
$lista=$objMetodos->ValidarUsuario ($usu, $pas);


if (sizeof($lista)>0) { 
	session_start();

    foreach ($lista as $reg) {
        $_SESSION ['acceso'] = true;
        $_SESSION ['codCli'] = $reg [0];
        $_SESSION ['nombre'] = $reg [1];

    }
    echo "ok";
//header("Location: Catalogo.php?".$lista[1]);
} else {

    echo "Usuario Incorrecto";
	//header("Location: Catalogo.php?error=Usuario Incorrecto");

//    echo '<script language="javascript">';
   // echo 'alert("usuarioInco")';
  //  echo '</script>';
}
?>