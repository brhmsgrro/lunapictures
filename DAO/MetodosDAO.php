<?php
include '../Utils/ConexionDB.php';
require '../BEANS/Cliente.php';
include '../BEANS/Pedido.php';
include '../BEANS/DetallePedido.php';

class MetodosDAO {

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


public function ListarProductosCod ($cod) {
		 $cnx=new ConexionDB ();
		 $cn=$cnx->getConexion ();

		 $res=$cn->prepare ("select * from productos where codpro='$cod'");
		 $res->execute ();


		 foreach ($res as $row) {
		 	$lista=$row;
		 }
		 return $lista;
	}
 
public function ValidarUsuario ($correo, $pas) {
		 $cnx=new ConexionDB ();
		 $cn=$cnx->getConexion ();
         $res = $cn->prepare ("select * from clientes where correo='$correo' and pas='$pas'");
		 $res->execute ();

         $cn=null; 
		 foreach ($res as $row) 
		 {
		 	$lista []=$row;
		 }
		 return $lista;
	}
  
  public function RegistrarCliente (Cliente $cli) {
		 $cnx=new ConexionDB ();
		 $cn=$cnx->getConexion ();
         $res = $cn->prepare ("insert into clientes values (0, '$cli->nomCli ', '$cli->correo ', '$cli->telefono ', '$cli->Dir ','$cli->pas ')" );
		 $i=$res->execute ();
		 $cn=null;
		 return $i; 
    }


	 public function RegistrarPedido(Pedido $ped) {
		 $cnx=new ConexionDB ();
		 $cn=$cnx->getConexion ();
         $res = $cn->prepare ("insert into pedido values (0,'$ped->codcli','$ped->fecha')");
		 $i=$res->execute ();
		 $cn=null; 
		 return $i;
	}


	public function numeroPed () {
		 $cnx=new ConexionDB ();
		 $cn=$cnx->getConexion ();
         $res=$cn->prepare ("select max(numPedido) from pedido");
		 $res->execute ();



		foreach ($res as $row) {
			$lista=$row;
		}
		return $lista;

     }


      public function RegistrarDetallePedido(DetallePedido $det) {
		 $cnx=new ConexionDB ();
		 $cn=$cnx->getConexion ();
         $res=$cn->prepare ("insert into detallepedido values (0,$det->num,$det->codpro,$det->can,'$det->color','$det->talla')");
		 $i=$res->execute (); 
		 return $i;


	}

}

