<?php

include '../Utils/ConexionDB.php';
include '../BEANS/Producto.php';


class MetodosAdmin {
	
	public function ValidarUsuario ($correo, $pas) {
		 $cnx=new ConexionDB ();
		 $cn=$cnx->getConexion ();
     $res=$cn->prepare ("select * from usuarios where correo='$correo' and pasUsu='$pas'");
		 $res->execute ();

     $cn=null; 
		 foreach ($res as $row) {
		 $lista=$row;
		 }
		 return $lista;
	}
	
public function ListarProductos () {
		 $cnx=new ConexionDB ();
		 $cn=$cnx->getConexion ();

		 $res=$cn->prepare ("select * from productos");
		 $res->execute ();


		 foreach ($res as $row) 
     {
		      $lista []=$row;
		 }
		 return $lista;
	}


public function grabarProducto (Producto $pro) {
       $cnx=new ConexionDB ();
	     $cn=$cnx->getConexion ();
       
       $res=$cn->prepare ("insert into productos values (null,'$pro->des','$pro->pre','$pro->stock','$pro->estado','$pro->detalle','$pro->imagen')");
       $res->execute ();

         $cn=null;
}

public function editarProducto (Producto $pro) {
       $cnx=new ConexionDB ();
	     $cn=$cnx->getConexion ();
       
       $res=$cn->prepare ("update productos set descripcion='$pro->des', precio='$pro->pre', stock='$pro->stock', estado='$pro->estado', detalle='$pro->detalle', imagen='$pro->imagen' where codpro='$pro->cod' ");
       $res->execute ();
       $cn=null;

       }

public function eliminarProducto ($cod) {
       $cnx=new ConexionDB ();
	     $cn=$cnx->getConexion ();
       $res=$cn->prepare ("delete from productos where codpro=$cod");
       $res->execute ();
       $cn=null;

       }

public function ListarProductosCod ($cod) {
       $cnx=new ConexionDB ();
	     $cn=$cnx->getConexion ();
       $res=$cn->prepare ("select * from productos where codpro=$cod");
       $res->execute ();
       $cn=null;

       foreach ($res as $row)
        {
       	   $lista =$row;
       }

       return $lista;
   }
   
public function ListarPedidos () {
       $cnx=new ConexionDB ();
       $cn=$cnx->getConexion ();
       $res= $cn->prepare("select p.numpedido,p.codCli,c.nombre,p.fecha from pedido p inner join clientes c on p.codcli=c.codcli");
       $res->execute ();
       $cn=null;
       foreach ($res as $row)
        {
           $lista []=$row;
       }

       return $lista;
   }

public function ListarPedidosNum ($num) {
       $cnx=new ConexionDB ();
       $cn=$cnx->getConexion ();
       $res=$cn->prepare ("select d.numpedido, d.codpro, p.descripcion, p.precio, d.can,d.color,d.talla from detallepedido d inner join productos p on d.codpro=p.codpro where numpedido=$num");
       $res->execute ();
       $cn=null;
       foreach ($res as $row)
        {
           $lista []=$row;
       }
       return $lista;
   }

public function ListarClientes () {
       $cnx=new ConexionDB ();
       $cn=$cnx->getConexion ();
       $res=$cn->prepare ("select * from clientes");
       $res->execute ();
       $cn=null;
       foreach ($res as $row)
        {
           $lista []=$row;
       }

       return $lista;
   }

}
