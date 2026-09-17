<?php

include '../DAO/MetodosAdmin.php';

$op=$_REQUEST ['op'];

switch ($op) {
	case 1:

	$target_path = "../images/";
	$target_path = $target_path . basename($_FILES ['archivo'] ['name']); move_uploaded_file($_FILES ['archivo'] ['tmp_name'] , $target_path); $img=basename($_FILES ['archivo'] ['name']);


	$objPro=new Producto (0, $_REQUEST ['txtDes'], $_REQUEST ['txtPre'],  $_REQUEST ['txtCan'], $_REQUEST ['selectEstado'], $_REQUEST ['txtDetalle'], $img);

	$metodos=new MetodosAdmin ();
    $metodos->grabarProducto ($objPro);

    header('Location: Productos.php');


    break;

    case 2:
          $target_path = "../images/";
	      $target_path = $target_path . basename($_FILES ['archivo'] ['name']); move_uploaded_file($_FILES ['archivo'] ['tmp_name'], $target_path); $img=basename($_FILES ['archivo'] ['name']);

          $objPro=new Producto ($_REQUEST ['txtCod'], $_REQUEST ['txtDes'], $_REQUEST ['txtPre'], $_REQUEST ['txtCan'], $_REQUEST ['selectEstado'], $_REQUEST ['txtDetalle'], $img);


          $metodos=new MetodosAdmin ();
          $metodos->editarProducto ($objPro);

          header ('Location: Productos.php'); 

    case 3:
          $metodos=new MetodosAdmin();
          $metodos->eliminarProducto ($_REQUEST ['cod']);

          header ('Location: Productos.php'); 

          break;

          default:

          break;


	}