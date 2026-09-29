<?php
include '../DAO/MetodosAdmin.php';
$num=$_REQUEST ['num'];
?>

<center>
	<table class="table">

          <tr>
            <th>Numero</th><th>cod Producto</th><th>Descripcion</th><th>Precio</th><th>Cantidad</th><th>color</th><th>Talla</th>
          </tr>

       <?php
       $metodos=new MetodosAdmin ();
       $lista=$metodos->ListarPedidosNum ($num);
       foreach ($lista as $row) {
       ?>

       <tr>
         <td><?php echo $row [0]?></td>
         <td><?php echo $row [1]?></td>
         <td><?php echo $row [2]?></td>
         <td><?php echo $row [3]?></td>
         <td><?php echo $row [4]?></td>
           <td><?php echo $row [5]?></td>
           <td><?php echo $row [6]?></td>
       </tr>
       
      <?php

       }
      ?>


     </table>


</center>