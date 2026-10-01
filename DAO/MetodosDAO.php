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


public function ListarProductosCod($cod) {
    $cnx = new ConexionDB();
    $cn = $cnx->getConexion();

    // ✅ Usar prepared statement para evitar inyección SQL
    $res = $cn->prepare("SELECT * FROM productos WHERE codpro = ?");
    $res->execute([$cod]);

    $lista = null;
    foreach ($res as $row) {
        $lista = $row;
    }
    
    $cn = null;
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

	public function ListarTallasPorProducto($codpro) {
    $cnx = new ConexionDB();
    $cn = $cnx->getConexion();
    
    // Buscamos SOLO las tallas que existen en la tabla variantes para este producto específico
    $sql = "SELECT DISTINCT talla FROM variantes_producto WHERE codpro = :cod AND activo = 1 ORDER BY FIELD(talla, 'S', 'M', 'L', 'XL', 'XXL'), talla ASC";
    
    $res = $cn->prepare($sql);
    $res->bindParam(':cod', $codpro, PDO::PARAM_INT);
    $res->execute();
    
    $lista = array();
    foreach ($res as $row) {
        $lista[] = $row['talla'];
    }
    
    $cn = null;
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

	

public function ListarImagenesPorColorYProducto($codpro, $color) {
    $cnx = new ConexionDB();
    $cn = $cnx->getConexion();
    
    // Busca primero por la columna color_asociado, y si no, por el nombre del archivo
    $res = $cn->prepare("SELECT ruta_imagen FROM producto_imagenes 
                         WHERE codpro = :cod 
                         AND (color_asociado = :color OR ruta_imagen LIKE :colorBuscado)
                         LIMIT 1");
    $res->bindParam(':cod', $codpro, PDO::PARAM_INT);
    $res->bindParam(':color', $color, PDO::PARAM_STR);
    $res->bindValue(':colorBuscado', '%' . strtolower($color) . '%', PDO::PARAM_STR);
    $res->execute();
    
    $cn = null;
    $lista = array();
    foreach ($res as $row) {
        $lista[] = $row;
    }
    return $lista;
}

               public function ListarColoresDisponibles($codpro) {
        $cnx = new ConexionDB();
        $cn = $cnx->getConexion();
        
        // 1. Buscar colores en variantes_producto
        $sql1 = "SELECT DISTINCT color FROM variantes_producto 
                 WHERE codpro = :cod AND activo = 1 AND color IS NOT NULL AND color != ''";
        $res1 = $cn->prepare($sql1);
        $res1->bindParam(':cod', $codpro, PDO::PARAM_INT);
        $res1->execute();
        
        // 2. Buscar colores en producto_imagenes
        $sql2 = "SELECT DISTINCT color_asociado as color FROM producto_imagenes 
                 WHERE codpro = :cod AND color_asociado IS NOT NULL AND color_asociado != ''";
        $res2 = $cn->prepare($sql2);
        $res2->bindParam(':cod', $codpro, PDO::PARAM_INT);
        $res2->execute();
        
        // 3. Unir resultados de ambas consultas
        $colores = array();
        foreach ($res1 as $row) {
            $color = trim($row['color']);
            if (!in_array(strtolower($color), ['estándar', 'unico', 'único'])) {
                $colores[] = $color;
            }
        }
        foreach ($res2 as $row) {
            $color = trim($row['color']);
            if (!in_array(strtolower($color), ['estándar', 'unico', 'único'])) {
                $colores[] = $color;
            }
        }
        
        // 4. Eliminar duplicados y ordenar
        $colores = array_unique($colores);
        sort($colores);
        
        $cn = null;
        return $colores;
    }

} // <--- ¡ESTA LLAVE DEBE SER LA ÚLTIMA LÍNEA DEL ARCHIVO!



