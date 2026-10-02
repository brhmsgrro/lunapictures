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
    $can = $_REQUEST['txtCan'];
    $color = $_REQUEST['color'];
    $talla = $_REQUEST['talla'];

    // ✅ CREAR LLAVE ÚNICA COMBINANDO ID + TALLA + COLOR
    $claveUnica = $id . '-' . strtoupper(trim($talla)) . '-' . strtoupper(trim($color));

    if (isset($_SESSION['cesta'][$claveUnica])) {
        // Si YA existe ESTA MISMA variante, solo sumamos cantidad
        $_SESSION['cesta'][$claveUnica]->cantidad += $can;
    } else {
        // Si es una variante NUEVA, la creamos con todos sus datos
        $objectCesta = new stdClass();
        $objectCesta->id = $id;          // ✅ Guardamos el ID limpio dentro del objeto
        $objectCesta->cantidad = $can;
        $objectCesta->color = $color;
        $objectCesta->talla = $talla;
        
        $_SESSION['cesta'][$claveUnica] = $objectCesta;
    }
    break;
            case 'eliminar':
    // ✅ RECIBIMOS LA CLAVE COMPUESTA QUE VIENE DEL LINK
    $claveParaBorrar = $_REQUEST['clave'] ?? null;
    
    // ✅ VERIFICAMOS EXISTENCIA USANDO LA NUEVA CLAVE
    if (!empty($claveParaBorrar) && isset($_SESSION['cesta'][$claveParaBorrar])) {
        
        // Restamos 1 a la cantidad
        $_SESSION['cesta'][$claveParaBorrar]->cantidad -= 1;
        
        // Si llega a 0 o menos, eliminamos la variante completa
        if ($_SESSION['cesta'][$claveParaBorrar]->cantidad <= 0) {
            unset($_SESSION['cesta'][$claveParaBorrar]);
        }
        
    } 
    // Ya no necesitamos el else con echo porque redirigimos inmediatamente
    break;

	    	case 'vacio':
	    			unset($_SESSION ['cesta']);
	    				
	    				break;
	    	 }


	    header("Location: https://lunapictures.com.mx/Vistas/Cesta.php");
			break;
}



?>