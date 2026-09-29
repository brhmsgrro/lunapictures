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

	// Reemplaza tu función grabarProducto por esta:
public function grabarProductoConCategoria(Producto $pro, $id_categoria) {
    $cnx = new ConexionDB();
    $cn = $cnx->getConexion();
    
    // Usamos bindParam para evitar SQL Injection (¡toque Pro!)
    $res = $cn->prepare("INSERT INTO productos (descripcion, precio, stock, estado, detalle, imagen, id_categoria) 
                         VALUES (:des, :pre, :stock, :estado, :detalle, :img, :cat)");
    $res->bindParam(':des', $pro->des, PDO::PARAM_STR);
    $res->bindParam(':pre', $pro->pre, PDO::PARAM_STR);
    $res->bindParam(':stock', $pro->stock, PDO::PARAM_INT);
    $res->bindParam(':estado', $pro->estado, PDO::PARAM_STR);
    $res->bindParam(':detalle', $pro->detalle, PDO::PARAM_STR);
    $res->bindParam(':img', $pro->imagen, PDO::PARAM_STR);
    $res->bindParam(':cat', $id_categoria, PDO::PARAM_INT);
    
    $res->execute();
    
    // Obtenemos el ID del producto recién creado para poder guardar sus variantes
    $nuevoCod = $cn->lastInsertId();
    $cn = null;
    
    return $nuevoCod;
}

// Reemplaza tu función editarProducto por esta:
public function editarProductoConCategoria(Producto $pro, $id_categoria) {
    $cnx = new ConexionDB();
    $cn = $cnx->getConexion();
    
    $res = $cn->prepare("UPDATE productos SET 
                         descripcion=:des, precio=:pre, stock=:stock, 
                         estado=:estado, detalle=:detalle, imagen=:img, 
                         id_categoria=:cat 
                         WHERE codpro=:cod");
                         
    $res->bindParam(':des', $pro->des, PDO::PARAM_STR);
    $res->bindParam(':pre', $pro->pre, PDO::PARAM_STR);
    $res->bindParam(':stock', $pro->stock, PDO::PARAM_INT);
    $res->bindParam(':estado', $pro->estado, PDO::PARAM_STR);
    $res->bindParam(':detalle', $pro->detalle, PDO::PARAM_STR);
    $res->bindParam(':img', $pro->imagen, PDO::PARAM_STR);
    $res->bindParam(':cat', $id_categoria, PDO::PARAM_INT);
    $res->bindParam(':cod', $pro->cod, PDO::PARAM_INT);
    
    $res->execute();
    $cn = null;
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

	// =====================================================
	//  NUEVOS MÉTODOS PARA CATEGORÍAS Y VARIANTES
	// =====================================================

	public function ListarCategorias() {
		$cnx = new ConexionDB();
		$cn = $cnx->getConexion();
		$res = $cn->prepare("SELECT id_categoria, nombre, descripcion, icono FROM categorias WHERE activo = 1 ORDER BY nombre ASC");
		$res->execute();
		$cn = null;
		$lista = array();
		foreach ($res as $row) {
			$lista[] = $row;
		}
		return $lista;
	}

	public function ListarAtributosCategoria($id_categoria, $tipo = 'talla') {
		$cnx = new ConexionDB();
		$cn = $cnx->getConexion();
		$res = $cn->prepare("SELECT valor FROM atributos_categoria WHERE id_categoria = :id_cat AND tipo_atributo = :tipo ORDER BY orden ASC");
		$res->bindParam(':id_cat', $id_categoria, PDO::PARAM_INT);
		$res->bindParam(':tipo', $tipo, PDO::PARAM_STR);
		$res->execute();
		$cn = null;
		$lista = array();
		foreach ($res as $row) {
			$lista[] = $row['valor'];
		}
		return $lista;
	}

	public function GuardarVariante($codpro, $id_categoria, $color, $talla, $sku, $precio, $stock, $imagen) {
		$cnx = new ConexionDB();
		$cn = $cnx->getConexion();
		$res = $cn->prepare("INSERT INTO variantes_producto (codpro, id_categoria, color, talla, sku, precio, stock, imagen_principal) VALUES (:cod, :cat, :color, :talla, :sku, :precio, :stock, :img)");
		$res->bindParam(':cod', $codpro, PDO::PARAM_INT);
		$res->bindParam(':cat', $id_categoria, PDO::PARAM_INT);
		$res->bindParam(':color', $color, PDO::PARAM_STR);
		$res->bindParam(':talla', $talla, PDO::PARAM_STR);
		$res->bindParam(':sku', $sku, PDO::PARAM_STR);
		$res->bindParam(':precio', $precio, PDO::PARAM_STR);
		$res->bindParam(':stock', $stock, PDO::PARAM_INT);
		$res->bindParam(':img', $imagen, PDO::PARAM_STR);
		$resultado = $res->execute();
		$cn = null;
		return $resultado;
	}

	public function ListarVariantesProducto($codpro) {
		$cnx = new ConexionDB();
		$cn = $cnx->getConexion();
		$res = $cn->prepare("SELECT v.*, c.nombre as categoria_nombre FROM variantes_producto v LEFT JOIN categorias c ON v.id_categoria = c.id_categoria WHERE v.codpro = :cod AND v.activo = 1 ORDER BY v.color ASC, v.talla ASC");
		$res->bindParam(':cod', $codpro, PDO::PARAM_INT);
		$res->execute();
		$cn = null;
		$lista = array();
		foreach ($res as $row) {
			$lista[] = $row;
		}
		return $lista;
	}

	public function EliminarVariante($id_variante) {
		$cnx = new ConexionDB();
		$cn = $cnx->getConexion();
		$res = $cn->prepare("UPDATE variantes_producto SET activo = 0 WHERE id_variante = :id");
		$res->bindParam(':id', $id_variante, PDO::PARAM_INT);
		$resultado = $res->execute();
		$cn = null;
		return $resultado;
	}

	public function GuardarImagenProducto($codpro, $id_variante, $ruta, $tipo, $orden, $es_principal) {
		$cnx = new ConexionDB();
		$cn = $cnx->getConexion();
		$res = $cn->prepare("INSERT INTO producto_imagenes (codpro, id_variante, ruta_imagen, tipo_imagen, orden, es_principal) VALUES (:cod, :var, :ruta, :tipo, :orden, :principal)");
		$res->bindParam(':cod', $codpro, PDO::PARAM_INT);
		$res->bindParam(':var', $id_variante, PDO::PARAM_INT);
		$res->bindParam(':ruta', $ruta, PDO::PARAM_STR);
		$res->bindParam(':tipo', $tipo, PDO::PARAM_STR);
		$res->bindParam(':orden', $orden, PDO::PARAM_INT);
		$res->bindParam(':principal', $es_principal, PDO::PARAM_INT);
		$resultado = $res->execute();
		$cn = null;
		return $resultado;
	}

	public function ListarImagenesProducto($codpro) {
		$cnx = new ConexionDB();
		$cn = $cnx->getConexion();
		$res = $cn->prepare("SELECT * FROM producto_imagenes WHERE codpro = :cod ORDER BY orden ASC");
		$res->bindParam(':cod', $codpro, PDO::PARAM_INT);
		$res->execute();
		$cn = null;
		$lista = array();
		foreach ($res as $row) {
			$lista[] = $row;
		}
		return $lista;
	}
public function ListarTallasPorProducto($codpro) {
    $cnx = new ConexionDB();
    $cn = $cnx->getConexion();
    // Buscamos SOLO las tallas que existen en la tabla variantes para este producto
    $res = $cn->prepare("SELECT DISTINCT talla FROM variantes_producto WHERE codpro = :cod AND activo = 1 ORDER BY talla ASC");
    $res->bindParam(':cod', $codpro, PDO::PARAM_INT);
    $res->execute();
    $cn = null;
    $lista = array();
    foreach ($res as $row) {
        $lista[] = $row['talla'];
    }
    return $lista;
}

public function ListarImagenPrincipalProducto($codpro) {
    $cnx = new ConexionDB();
    $cn = $cnx->getConexion();
    // Buscamos la imagen marcada como principal para este producto
    $res = $cn->prepare("SELECT ruta_imagen FROM producto_imagenes WHERE codpro = :cod AND es_principal = 1 LIMIT 1");
    $res->bindParam(':cod', $codpro, PDO::PARAM_INT);
    $res->execute();
    $cn = null;
    $row = $res->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['ruta_imagen'] : null;
}

}