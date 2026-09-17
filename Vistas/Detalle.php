
<?php 
include '../DAO/MetodosDAO.php';

$cod=$_REQUEST ['cod'];

$objMetodos=new MetodosDAO ();
$lista=$objMetodos->ListarProductosCod ($cod);

//var_dump($lista);

$nombre=$lista [1];
$precio=$lista [2];
$detalle=$lista [5];
$imagen = $lista [6];
$envio = $lista  [7];
 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<meta http-equiv="Content-Language" content="es-ES">


	<title></title>
</head>
<body>

<div class="container"> 
<div class="row">
  <div class="col-md-6">
	<form action="../DAO/TiendaDAO.php">
      
 	   <div class="col-sm-4 col-md-12">
      <?php echo $nombre; ?>
      <img src="../images/<?php echo $imagen;?>">
 	    <?php echo $detalle; ?>
      <br>
      $ <?php echo $precio; ?>
      
     </div>


<div class="row">
	<div class="col-sm-4 col-md-12">Ingrese cantidad:<input style="text-align: center;" type="number" min="1" max="100" value="1" name="txtCan"></div>
  <label>Seleccione talla:</label>
                XS<input type='radio' name='talla' checked value='XS'>
                S<input type='radio' name='talla' value='S'>
                M<input type='radio' name='talla' value='M'>
                L<input type='radio' name='talla' value='L'>
                XL<input type='radio' name='talla' value='XL'><br>

   <label>Seleccione color:</label>
                <select name="color" id='color'>
                    <option selected value="Blanca">Blanca</option>
                    <option value="Negra">Negra</option>
                    <option value="Gris" >Gris</option>
                    <option value="Rosa Pastel">Rosa Pastel</option>
                    <option value="Azul Royal">Azul Royal</option>
                    <option value="Azul Turquesa">Azul Turquesa</option>
                    <option value="Azul Marino">Azul Marino</option>
                    <option value="Rojo">Rojo</option>
                    <option value="Coral">Coral</option>
                </select><br>             
</div>
   <div class="row">
    	<div class="col-sm-4 col-md-6">
    		
    		<button type="button" class="btn-success focus" onclick="submit()">agregar al carrito</button>

      </div>
   </div>


        <input type="hidden" name="id" value="<?php echo $cod; ?>">
        <input type="hidden" name="accion" value="agregar">
        <input type="hidden" name="op" value="2">


	</form>

</div>
</div>
</body>
</html>