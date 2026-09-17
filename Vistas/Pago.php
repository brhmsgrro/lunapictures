<?php 
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_start();
}

include '../DAO/MetodosDAO.php';

 ?>

<!DOCTYPE html>
<html>
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1, maximun-sacle=1, user-scalable=no">
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
  <link rel="preload" href="https://lunapictures.com.mx/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"  >
  <noscript><link rel="stylesheet" href="../css/bootstrap.min.css" media="all" ></noscript>
     

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
(function(){ ... }());
</script>
  
  <!-- FOR IE9 below -->
  <!--[if lt IE 9]>
  <script src="js/respond.min.js"></script>
  <![endif]-->



</head>
<body>


	<noscript><iframe src="data:application/octet-stream;base64,PCFET0NUWVBFIGh0bWw+CgoKPGh0bWwgbGFuZz1lbj4KPGhlYWQ+CiAgPG1ldGEgY2hhcnNldD11dGYtOD4KICA8dGl0bGU+bnM8L3RpdGxlPgo8L2hlYWQ+Cjxib2R5PgogIAoKICAKCiAgCiAgCgogIAoKICAKCiAgCgogIAoKICAKCiAgCgogIAoKICAKCiAgCgogIAoKICAKCiAgCgogIAoKICAKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgo8L2JvZHk+PC9odG1sPgo="
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
        <li><a href="../DAO/TiendaDAO.php?op=1" class="external">Catalogo</a></li>
              
              <?php
                 if (!isset($_SESSION ['acceso'])  || $_SESSION ['acceso'] <> true ){
              ?>

           
              
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

	
     <h4 align="center" style="margin-top: 80px;">
    <?php
    if (isset($_REQUEST ['total']))
        $total=$_REQUEST ['total'];

     $estado=$_REQUEST ['estado'];

     if ($estado=='pagar'){
     echo 'el monto a pagar es: '.$total;

    ?>



<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">

<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="hosted_button_id" value="39VHB3ZKJE2NE" />
<input type="hidden" name="business" value="ventas@lunapictures.com.mx" />
<input type="hidden" name="item_name" value="productos varios" />
<input type="hidden" name="quantity" value="<?php echo $total; ?>">
<input type="hidden" name="amount" value="<?php echo $total; ?>" />
<input type="hidden" name="currency_code" value="MEX"/>
<input type="hidden" name="return" value="https://lunapictures.com.mx/Vistas/Pago.php?estado=ok"/>

<input type="image" src="https://www.paypalobjects.com/es_XC/MX/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal, la forma más segura y rápida de pagar en línea." />
<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1" />
</form>

<?php
        } else if($estado=='ok') {
            
            $objMet=new MetodosDAO ();

        	if (isset ($_SESSION ['cesta'])) {
        		$codCli=$_SESSION ['codCli'];

        		$fecha= date ('Y-m-d\TH:i:s');
        		$objPed=new Pedido (0, $codCli, $fecha);
            // var_dump($codCli);


        		$objMet->RegistrarPedido ($objPed);
        		$ultimoPed=$objMet->numeroPed ();

                foreach($_SESSION['cesta'] as $key=>$value) {
                   //echo "canti". $value."<br />codigo" .$key;

                    $objDetalle=new DetallePedido ($ultimoPed[0], $key, $value->cantidad, $value->color, $value->talla);


                    $objMet-> RegistrarDetallePedido ($objDetalle);
                }


        		//foreach ($_SESSION ['cesta'] as $id =>$x) {



        		//$objDetalle=new DetallePedido ($ultimoPed[0], $id, $x);
        		//$objMet-> RegistrarDetallePedido ($objDetalle);
        		//}
                
                
        	}   unset ($_SESSION ['cesta']);

        	echo 'Tu compra fue exitosa en breve nos comunicamos contigo' ;

         echo '<script>';
         echo ' setTimeout(function(){
                 window.location.href = "Catalogo.php";
             }, 4000);';
         echo '</script>';
        }





?>




</h4>

<!-- jQuery -->
  <script  src="../js/jquery.min.js"  ></script>
  
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