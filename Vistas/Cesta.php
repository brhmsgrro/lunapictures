<?php
include '../DAO/MetodosDAO.php';
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_start();
}

?>

<!DOCTYPE html>
<html>
<head>
  
<meta name="title" content="Home Page | Luna Pictures Entertainment" />
<meta name="Description" content=" ✅ Camisetas, gorras, tazas y otros articulos mas para los amantes del 7mo arte. Entra no mordemos."/>
<meta name="Distribution" content="global"/>

<link rel="shortlink" href="https://lunapictures.com.mx/Vistas/Cesta.php" />
<link rel="canonical" href="https://www.lunapictures.com.mx/Vistas/Cesta.php" />
<meta name="Generator" content="Drupal 8 (https://www.drupal.org)" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximun-scale=1, user-scalable=no">
<link rel="icon" href="../images/luna pictures audiovisual.ico" type="images/luna pictures audiovisual.icon" />
<link rel="revision" href="/home" />

	<title></title>

	<!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400, 900" rel="stylesheet"> -->
  
 <!-- Animate.css -->
  <link rel="preload" href="https://lunapictures.com.mx/css/animate.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" >
  <noscript><link rel="stylesheet" href="../css/animate.min.css" media="all"></noscript>
    
    

  <!-- Icomoon Icon Fonts 
  <link rel="preload"  href="https://lunapictures.com.mx/css/icomoon.min.css"as="font"crossorigin>-->
    <link rel="preload" href="https://lunapictures.com.mx/css/icomoon.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"  >
    <noscript><link rel="stylesheet" href="../css/icomoon.min.css" media="all" ></noscript> 
    
  
  <!-- Themify Icons-->

  
  <!-- Bootstrap-->
  <link rel="preload" href="https://lunapictures.com.mx/css/bootstrap.css" as="style" onload="this.onload=null;this.rel='stylesheet'"  >
  <noscript><link rel="stylesheet" href="../css/bootstrap.css" media="all" ></noscript>
     

  <!-- Magnific Popup -->
  <link rel="preload" href="https://lunapictures.com.mx/css/magnific-popup.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"  >
  <noscript><link rel="stylesheet" href="../css/magnific-popup.min.css" media="all"></noscript>
  <!-- Owl Carousel  -->
  
  <!-- Flexslider -->
	

	<link rel="preload" href="https://lunapictures.com.mx/css/style.css" as="style" > 
  <link rel="stylesheet" href="../css/style.css" media="all">


    
  <!-- Modernizr JS -->
  <title>Critical Path: Script Async</title>
<script>
/*! loadCSS rel=preload polyfill. [c]2017 Filament Group, Inc. MIT License */
//(function(){ ... }());
</script>
  
  <!-- FOR IE9 below -->
  <!--[if lt IE 9]>
  <script src="js/respond.min.js"></script>
  <![endif]-->

</head>
<body>

   

  <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v5.0"></script>
    
  

  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KGPD9VF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) --> 
    
  <div class="gtco-loader"></div>
  
<nav class="gtco-nav2" role="navigation">
    <div class="container">
      <div class="row">
        <div class="col-sm-2 col-xs-12">
          <div id="gtco-logo"><a href="https://www.lunapictures.com.mx/index.php">LUNA<em>PICTURES</em></a></div>
        </div>
        <div class="col-xs-10 text-right menu-1 main-nav">
          <ul>
            <li class="active"><a href="" class="external" data-nav-section="home"></a></li>
        <li  class="active"><a href="Cesta.php"  rel=”nofollow class="external"><svg version="1.1" xmlns="http://www.w3.org/2000/svg"
  width="32" height="32" viewBox="0 -10 32 32">
  <path fill="#000" fill-rule="nonzero" d="M12 7V6c0-1 2-3 3-2h4c1 0 2 1 2 2v1h7v19H5V7h7zm14 1H6v17h20V8zM13 6v1h6V6c0-.8-.5-1-1-1h-4c-.5 0-1 .5-1 1z"></path></svg></a></li>
              

              <?php
                 if (!isset($_SESSION ['acceso'])  || $_SESSION ['acceso'] <> true ){
              ?>

            <li><a href="Registro.php" rel=”nofollow class="external">Registrase</a></li> 
              
            <li ><a href="" data-toggle="modal" data-target="#LoginModal" class="external">Iniciar sesion</a>
            </li>
              
               <?php
               } else{
               ?>

              <li>
              <a class="external">Hola <?php echo $_SESSION ['nombre'];?></a>
              </li> 
              <li><a href="CerrarSesionTienda.php" class="external">cerrar sesion</a></li>
            
            <?php
             }
            ?>
             
          </ul>
        </div>
      </div>
    </div>
  </nav>
	



  <div class="container">
  <h2 align="center" style="margin-top: 80px;">Cesta de productos</h2>
    <div class="row">
      <div class="col-md-12 col-xs-12">
	
   
      
      
      
  <form>


            <div class="col-md-3 col-xs-3" style="text-align: center;">Producto</div>
            <div class="col-md-2 col-xs-2" style="text-align: center;">Precio</div>
            <div class="col-md-2 col-xs-5" style="text-align: center;">cant</div>
            <div class="col-md-2 col-xs-4" style="text-align: center;">envio</div>
            <div class="col-md-2 col-xs-6" style="text-align: center;">costo</div>
            
	<?php
   if (isset ($_SESSION['cesta'])) {
         $total=0;
         foreach ($_SESSION['cesta'] as $id=>$x) {
         	   $objMetodos=new MetodosDAO ();
         	   $lista=$objMetodos->ListarProductosCod ($id);

         	   $nombre=$lista[1];
             //var_dump($envio);
         	   $precio=$lista[2];
             $envio=$lista[7];
         	   $costo=$x->cantidad*$precio+$envio;
         	   $total=$total+$costo;
             /*echo json_encode($lista[0]);$nombre = $lista[0]["descripcion"];
             $precio = $lista[0]["precio"];
             $costo = $x * $precio;
            $total = $total + $costo;*/
         ?>



             <div class="col-md-3 col-xs-2" style="word-break: break-all;"><?php echo $nombre?> /<?php echo $x->color?>/<?php echo $x->talla?></div>
            <div class="col-md-2 col-xs-2" style="text-align: center;">$<?php echo $precio; ?></div>
            <div class="col-md-2 col-xs-5" style="text-align: center; word-break: break-all;"><?php echo $x->cantidad; ?><a href="../DAO/TiendaDAO.php?id=<?php echo $id;?>&accion=eliminar&op=2" class="btn-info badge">eliminar</a></div>
             <div class="col-md-2 col-xs-4" style="text-align: center;">$<?php echo $envio; ?></div>

            <div class="col-md-2 col-xs-7" style="text-align: center;">$ <?php echo $costo; ?></div>
         

                <?php
               
               }
             
             ?>
            
         <div class="row">

         	 <div class="col-md-6 col-xs-12">Total: </div>
          <div class="col-md-6 col-md-push-4 col-xs-12 ">$ <?php echo $total; ?></div>
         </div> 
        <br>
    
       <?php
       }
	?>


      <?php

    //  $object = new stdClass();
    //  $object->name = "My name";
     // $myArray[] = $object;

  //  foreach($_SESSION['cesta'] as $key=>$value) {

       // echo "canti". $value->color."<br />codigo" .$key;
    //}

      //$_SESSION ['pedro']=$object;
   //  print_r($_SESSION['cesta']);

    //print_r(  isset($_SESSION ['cesta'] [50]))

    //  print_r($object->name);

     // print_r($_SESSION['pedro']);

      ?>


   
</form>

<div class="row">
  <div class="col-md-6 col-md-offset-2 col-xs-12 " style="text-align: center;" >
  <h3>
	<button class="btn-success"><a href="Catalogo.php" class="btn-success">Agregar otro </a></button>

	<a href="../DAO/TiendaDAO.php?accion=vacio&op=2" class="btn-primary focus">Cancelar pedido</a><br>
	 <button class="btn-success focus" onclick="validar()" data-toggle="modal" data-target="#LoginModal">Pago X paypal</button>
  </h3>
  </div>
</div>


  </div>
  </div>
 </div>
 


<footer id="gtco-footer" role="contentinfo">
    <div class="container">
      
      <div class="row copyright">
        <div class="col-md-12">
          <p class="pull-left">
            <small class="block">&copy;el pago en linea es por paypal los datos del envio los tomaremos de ahi. Cualquier duda o aclaracion comunicate al  (33) 3323863611 </small> 
            
          </p>


 

          <p class="pull-right">
            <ul class="gtco-social-icons pull-right">
              <li><a href="https://twitter.com/PelisConMensaje"><i class="icon-twitter"></i></a></li>
              <li><a href="https://www.facebook.com/PeliculasConMensaje/"><i class="icon-facebook"></i></a></li>
              <li><a href="linkedin.com/in/luna-villares-abraham-b54a6422"><i class="icon-linkedin"></i></a></li>
              <li><a href="https://www.instagram.com/peliculasconmensaje/"> <i class="icon-instagram" ></i></a></li>
            </ul>
          </p>
            </ul>
          </p>
        </div>

        
      </div>

    </div>
  </footer>


<script >
  function validar(){
    <?php
     if ($_SESSION ['acceso']==true) {

    ?>

    location.href='Pago.php?total=<?php echo $total; ?>&estado=pagar';

    <?php
    }

    ?>

  }
  
</script>





<!-- Modal login -->


<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Hola</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="mostrar">
        <div class="form-group">
              <label for="txtUsu" class="sr-only">Usuario</label>
              <input name="txtUsu" type="text" class="form-control" placeholder="Correo" id="usua" required>
            </div>
            <div class="form-group">
              <label for="txtPas" class="sr-only">Password</label>
              <input name="txtPas" type="password" class="form-control" placeholder="password" id="pass" required>
            </div>
      
    </div>
      <div class="modal-footer">  
      <button  class="btn-primary" onclick="SendLogin()">Iniciar sesion</button>
       </div>
        <h6 align="center"><a href="Registro.php">Registrarse</a></h6>


      
    </div>
  </div>
</div>


  <script>




      function SendLogin(){


          var User=$("#usua").val();
          var Pass=$("#pass").val();

          $.ajax({

              data:"",
              url: 'Valida.php?txtUsu='+User+"&txtPas="+Pass,
              type: 'GET',
              success: function (response) {

                  if(response=="Usuario Incorrecto"){

                      alert(response);
                  }else{

                      window.location.href = 'Pago.php?total=<?php echo $total; ?>&estado=pagar';

                  }


              }

          });

      }



      //alert("Ss");


  </script>



<!-- jQuery -->
  <script  src="../js/jquery.min.js"></script>
  
  <!-- jQuery Easing -->
  <script  src="../js/jquery.easing.1.3.js" defer ></script>

  <!-- Bootstrap -->
  <script src="../js/bootstrap.min.js" defer  ></script>
  
  <!-- Waypoints -->
  <script  src="../js/jquery.waypoints.min.js" defer></script>
  
  <!-- Stellar -->
  <script  src="../js/jquery.stellar.min.js" defer ></script>

  <!-- Magnific Popup -->
  <script src="../js/jquery.magnific-popup.min.js" async></script>
  <script src="../js/magnific-popup-options.js" async></script>
 <!-- Main -->
  <script src="../js/main.js" async ></script>
  

    <script src="../js/modernizr-2.6.2.min.js" async></script >

     
</body>
</html>

                                                      