
<!DOCTYPE html>

<html>

<?php
include '../DAO/MetodosAdmin.php';



?>
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Luna pictures Merchandising</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/dashboard/">

    <!-- Bootstrap core CSS -->
<link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/4.4/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon.ico">
<meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.4/examples/dashboard/dashboard.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Luna pictures STORE</a>
  
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="Cerrar.php">Sign out</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file"></span>
              Productos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Pedidos.php">
              <span data-feather="shopping-cart"></span>
              Pedidos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="clientes.php">
              <span data-feather="users"></span>
             clientes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Cerrar.php">
              <span data-feather="bar-chart-2"></span>
              Salir
            </a>
          </li>
          
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
       
       <h3 align="center"> Listado de productos</h3>
        <table class="table">

          <tr>
            <th>codigo</th><th>Descripcion</th><th>Precio</th><th>Stock</th><th>Estado</th><th>imagen</th>
             <th>accion</th>
          </tr>
       <?php

       $metodos=new  MetodosAdmin ();
       $lista=$metodos->ListarProductos ();
       foreach ($lista as $row) {
       ?>

       <tr>
         <td><?php echo $row [0]?></td>
         <td><?php echo $row [1]?></td>
         <td><?php echo $row [2]?></td>
         <td><?php echo $row [3]?></td>
         <td><?php echo $row [4]?></td>
         <td><img src="../images/<?php echo $row [6]?>"  width="30" height="30"> </td>
         <td>
           <a href="Formulario.php?op=2&cod=<?php echo $row [0]?>" class="btn btn-success" style="color:white;">Editar</a> ||
           <a href="Mantenimiento.php?op=3&cod=<?php echo $row [0]?>" class="btn btn-danger" style="color:white;">Eliminar</a>

         </td>

       </tr>
      <?php

       }


       ?>


     </table>

      <h3 align="center">
        <a href="Formulario.php?op=1&cod=0" class="btn btn-primary">nuevos productos</a>
      </h3>


    </main>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
        <script src="dashboard.js"></script></body>


   </html>
