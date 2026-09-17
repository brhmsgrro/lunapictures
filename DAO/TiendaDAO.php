<?php
ini_set('session.save_path', '/tmp');
session_start();
include './MetodosDAO.php';

$op=$_REQUEST ['op'];



 
//var_dump($_REQUEST);
switch ($op) {
	case 1:
		unset($_SESSION ['lista']);
		$objMetodo=new MetodosDAO ();
		$lista=$objMetodo->ListarProductos ();
		$_SESSION ['lista']=$lista;
		header("Location: ../Vistas/Catalogo.php");
		break;


	case 2:

		if (isset ($_REQUEST['id'])) { 
			$id=$_REQUEST['id']; 
		} else {
			$id=1;
		}
		
		if (isset ($_REQUEST['accion'])) { 
			$accion=$_REQUEST ['accion']; 
		} else {
			$accion='vacio';
        }


switch ($accion) {
	    	case 'agregar':
	    		$can=$_REQUEST ['txtCan'];
				$color=$_REQUEST ['color'];
				$talla=$_REQUEST ['talla'];



				$objectCesta = new stdClass();
				$objectCesta->cantidad = $can;
				$objectCesta->color = $color;
				$objectCesta->talla = $talla;




	    		if (isset($_SESSION ['cesta'] [$id])) {
					//	$_SESSION ['cesta'] [$id]+=$can;



					$_SESSION ['cesta'] [$id]->cantidad = $_SESSION ['cesta'] [$id]->cantidad+$can;

				}
	    		else {
					$_SESSION ['cesta'] [$id] = $objectCesta;


					$_SESSION ['cesta'] [$id]->cantidad = $can;
				}


	    		break;
            case 'eliminar':
	    			if (isset($_SESSION ['cesta'] [$id])) {
	    			   // $_SESSION ['cesta'] [$id]--;

						$_SESSION ['cesta'] [$id]->cantidad=$_SESSION ['cesta'] [$id]->cantidad-1;
	    			     if ($_SESSION ['cesta'] [$id]->cantidad==0) {
							 unset ($_SESSION ['cesta'] [$id]);
						 }
	    			}
	    			break;

	    	case 'vacio':
	    			unset($_SESSION ['cesta']);
	    				
	    				break;
	    	 }


	    header("Location: https://lunapictures.com.mx/Vistas/Cesta.php");
			break;
}



?>