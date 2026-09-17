<?php

if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_start();
}

include '../DAO/MetodosDAO.php';
//$lista = $_SESSION['lista'];
?>

<!DOCTYPE html>
<html prefix="og: https://lunapictures.com.mx/ns#">

 <head>
	<meta property="og:title" content="Es un apasionado del cine? entonces este es el regalo perfecto!!!" />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="https://lunapictures.com.mx/images/tienda-facebook-debugger2.png" />
  <meta property="og:url" content="https://lunapictures.com.mx/Vistas/Catalogo.php" />
  <meta property="og:description" content="La camiseta de win rocky win!; la de newyork film academy, una gorra de director! una silla de director" />
  <meta property="og:locale" content="es_mex" />
    <meta property="og:site_name" content="luna-pictures" />
    <meta property="og:audio" content="" />
    <meta property="og:video" content="https://www.youtube.com/embed/rydYmjxapkA" />
    <meta name="author" content="[by luna villares]">

   <meta property="og:image" content="https://lunapictures.com.mx/images/camara-trabajando.png" />
    <meta property="og:image" content="https://lunapictures.com.mx/images/camiseta-win-rocky-win.png" />
    <meta property="og:image" content="https://lunapictures.com.mx/images/camisa-avelina-lesper.png" />
    <meta property="og:image" content="https://lunapictures.com.mx/images/newyork-film-academy-camiseta.png" />
    <meta property="og:image" content="https://lunapictures.com.mx/images/superman-camisa.png" />
    <meta property="og:image" content="https://lunapictures.com.mx/images/pollos-hermanos-camisa.png" />
    <meta property="og:locale:alternate" content="fr_FR" />
    <meta property="og:locale:alternate" content="en_EN" />


  <meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">
    
    <meta name="msvalidate.01" content="01A6CF40B8F324405EEDE52DB6C0BA5F" />
    <meta name="robots" content="all">
    <meta name=”msvalidate.01” content=”CODE”/> 


<meta charset="UTF-8">

<meta http-equiv="Content-Language" content="es-ES" />


<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KGPD9VF');</script>
<!-- End Google Tag Manager -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PWC5G96K8B"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PWC5G96K8B');
</script>

   <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121073096-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-120933941-1');
</script>

<!-- Global site tag (gtag.js) - AdWords: 1016465057 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-1016465057"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-1016465057');
</script>

<script>
  gtag('event', 'page_view', {
    'send_to': 'AW-1016465057',
    'user_id': 'replace with value'
  });
</script>

<!-- Adsense -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-7727586768254179",
          enable_page_level_ads: true
     });
</script>



<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '2310533659183574');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=2310533659183574&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
  
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@PelisConMensaje">
<meta name="twitter:creator" content="luna villares">
<meta name="twitter:title" content="El regalo perfecto para un cinefilo!">
<meta name="twitter:description" content="Playeras con estampados de cine, por el cine y para el cine. Muestra con orgullo la serie y o pelicula que te ha marcado.">
<meta name="twitter:image:src" content="http://lunapictures.com.mx/images/tienda-facebook-debugger2.png" /> 

<meta name="title" content="Home Page | Luna Pictures Entertainment" />
<meta name="Description" content="Camisetas new york film academy, gorra de director, camiseta win rocky win, camiseta 1st ad, silla para director,  "/>
<meta name="Distribution" content="global"/>

<link rel="shortlink" href="" />
<link rel="canonical" href="https://lunapictures.com.mx/Vistas/Catalogo.php"/>
<meta name="Generator" content="Drupal 8 (https://www.drupal.org)" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximun-scale=1, user-scalable=no">
<link rel="icon" href="../images/luna pictures audiovisual.ico" type="images/luna pictures audiovisual.icon" />
<link rel="revision" href="/home" />

<title> ▷ regalos para cinefilos | para los amantes del cine; camisetas estampadas, GDL </title>

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
(function(){ ... }());
</script>
  
  <!-- FOR IE9 below -->
  <!--[if lt IE 9]>
  <script src="js/respond.min.js"></script>
  <![endif]-->

 </head>

<body>

    <div id="page">

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v5.0"></script>

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KGPD9VF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) --> 
    
 
  
    
 <nav class="gtco-nav" role="navigation">
    <div class="container">
      <div class="row">
        <div class="col-sm-2 col-xs-12">
          <div id="gtco-logo"><a href="https://www.lunapictures.com.mx/index.php">LUNA<em>PICTURES</em></a></div>
        </div>
        <div class="col-xs-10 text-right menu-1 main-nav">
          <ul>
            <li class="active"><a href="" class="external" data-nav-section="home"></a></li>
            <li  class="active"><a href="Cesta.php" rel=”nofollow class="external"><svg version="1.1" xmlns="http://www.w3.org/2000/svg"
             width="32" height="32" viewBox="0 -10 32 32">
             <path fill="#000" fill-rule="nonzero" d="M12 7V6c0-1 2-3 3-2h4c1 0 2 1 2 2v1h7v19H5V7h7zm14 1H6v17h20V8zM13 6v1h6V6c0-.8-.5-1-1-1h-4c-.5 0-1 .5-1 1z"></path></svg></a></li> 

              <?php
                 if (!isset($_SESSION ['acceso'])  || $_SESSION ['acceso'] <> true ){
              ?>

            <li><a href="Registro.php" rel=”nofollow class="external">Registrarse</a></li>
            <li><a href="" data-toggle="modal" data-target="#LoginModal" class="external">Iniciar sesion</a></li>
              
               <?php
               } else{
               ?>

            <li class="nav-item"><a class="nav-link">Hola <?php echo $_SESSION ['nombre'];?></a></li> 
            <li><a href="CerrarSesionTienda.php" class="external">cerrar sesion</a></li>

            <?php
             }
            ?>
             
          </ul>
        </div>
      </div>
    </div>
  </nav>


  <section id="gtco-hero" class="gtco-cover" style="background-image: url(../images/regalos-para-cinfeilos-hitchcok.png);"  data-section="home"  data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-md-offset-0 text-center">
          <div class="display-t">
            <div class="display-tc">
              <h1 class="animate-box" data-animate-effect="fadeIn">Regalos para cinefilos</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<section id="gtco-about" data-section="about">
    <div class="container">
      <div class="row row-pb-md">
        <div class="col-md-8 col-md-offset-2 heading animate-box" data-animate-effect="fadeIn">
          <h1>Playeras para los amantes del cine</h1>
          <p class="sub"><i>camisetas estampadas en serigrafia con los personajes y las frases favoritas del septimo arte. envios a toda la republica, en 24 hrs.</i></p>
        </div>
      </div>
    </div>

</section>  


  <div class="container">
  <div class="row">
  <div class="col-md-12  animate-box">

    <h1 style="text-align:center;">Catalogo de productos</h1>
    <br>
    
  <form>





      <?php


             $objMetodos = new MetodosDAO ();
             $lista = $objMetodos->ListarProductos();
      
      ?>




  <?php
     $num=0;
     foreach ($lista as $reg) {
      if ($num==3){
        echo "<tr>";
        $num=1;
      }
      else {
        $num++;
      } 
     
       ?>
            <div class="col-md-9 animate-box">
            <h2 style="text-align: center; word-break: break-all;"><strong><?php echo $reg[1]; ?></strong></h2>
            <img src="../images/<?php echo $reg[6];?>">
            <h4><mark> $ <?php echo $reg[2]; ?></mark></h4>
            <button type="button" class="btn-success" data-toggle="modal" data-target="#exampleModal"  onclick="enviar(<?php echo $reg[0];?>)">Ver</button>
            </div>
       <?php
     }
     ?>
    
  </form>







</div>
</div>

</div> 
 
 
   

<section id="gtco-contact" data-section="contact">
    <div class="container">
      <div class="row row-pb-md">
        <div class="col-md-8 col-md-offset-2 heading animate-box" data-animate-effect="fadeIn">
          <h1>Envios a toda la republica!!</h1>
          <p class="sub">Si necesitas mas informacion sobre el proceso de compra o metodos de pago escribenos! </p>
          <p class="subtle-text animate-box" data-animate-effect="fadeIn">HAZ CONTÁCTO</p>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-6 col-md-push-6 animate-box">
          
            <form action="" method="POST" id="contactoss" enctype="multipart/form-data" >
            <div class="form-group">
              <label for="name" class="sr-only">Name</label>
              <input name="name" type="text" class="form-control" placeholder="Nombre" id="name"   required  >
            </div>
            <div class="form-group">
              <label for="email" class="sr-only">Email</label>
              <input name="email" type="text" class="form-control" placeholder="correo" id="email"  required >
            </div>
            <div class="form-group">
              <label for="message" class="sr-only">Message</label>
              <textarea name="message" id="message" class="form-control" cols="30" rows="7" placeholder="Mensaje" type="text"  required ></textarea >
            </div>
            <div class="form-group">
              
              <button type="submit"  value="enviar" class="btn btn-primary" id="btn-contacto">enviar</button>


            </div>
          </form>
        </div>

<div class="col-md-4 col-md-pull-6 animate-box">
          <div class="gtco-contact-info">
            <ul>
              <li class="address">Av.Guadalupe Victoria 264, segunda planta, 45186 Zapopan, Jal.</li>
              <li class="phone"><a href="tel://3330323450"> 3330323450</a></li>
              <li class="email"><a href="mailto:tienda@lunapictures.com.mx">tienda@lunapictures.com.mx</a></li>
              <li class="url"><a href="index.php">https://lunapictures.com.mx</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

	

<footer id="gtco-footer" role="contentinfo">
    <div class="container">
      
      <div class="row copyright">
        <div class="col-md-12">
          <p class="pull-left">
            <small class="block">&copy; Tienes dudas con el proceso de compra y opciones de pago?? llamananos 3323863611!</small> 
            
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

 
<amp-auto-ads type="adsense"
              data-ad-client="ca-pub-7727586768254179">
</amp-auto-ads>

<!-- Modal cesta -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 style="text-align: center;" class="modal-title" id="exampleModalLabel">REGALO PARA CINEFILO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="mostrar">
       
        ...
       
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>


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
              <label for="usuario" class="sr-only">Usuario</label>
              <input name="txtUsu" type="text" class="form-control" placeholder="Correo" id="usua" required>
            </div>
            <div class="form-group">
              <label for="password" class="sr-only">Password</label>
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

                    window.location.href = "https://lunapictures.com.mx/Vistas/Catalogo.php";
                    
                }

           
            }

        });

    }



    //alert("Ss");


</script>




<!-- Modal registro -->



  
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

     <!-- 
       
     -->
     
<script type="text/javascript">
  $(document).ready(function(){
    $('#btn-contacto').click(function(){
      if($('#name').val()==""){
        alertify.alert("Debes agregar el nombre");
        return false;
      }else if($('#email').val()==""){
        alertify.alert("Debes agregar tu correo");
        return false;
      }else if($('#message').val()==""){
        alertify.alert("Debes agregar un mensaje");
        return false;
      }

      var datos=$('#contactoss') .serialize();
      $.ajax({
        type:"POST",
        url:"../enviar-tienda.php",
        data:datos,
        success:function(r){
          if(r==1){
            alert("Gracias en breve nos comunicamos contigo");
            document.getElementById('contactoss').reset(); 
          }else{
            alert("error");
          }
                 }
      });
      return false;
    });
  });
</script>

    <script > 
var resultado=document.getElementById("mostrar");

    	function enviar(c) {
         
         var xmlhttp;
         if (window.XMLHttpRequest) {
         	xmlhttp=new XMLHttpRequest ();

         } else {
         	xmlhttp=new ActiveXObject ("Microsoft.XMLHTTP");
         }

         xmlhttp.onreadystatechange=function() {
          if (xmlhttp.readyState==4 && xmlhttp.status==200){
          	   resultado.innerHTML=xmlhttp.responseText; 
              }
           }

           xmlhttp.open ("GET", "Detalle.php?cod="+c,true);
           xmlhttp.send();




        }
    </script>




    

     <!-- 
       
     -->
 

 

<script type="text/javascript">
_linkedin_partner_id = "477242";
window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
window._linkedin_data_partner_ids.push(_linkedin_partner_id);
</script><script type="text/javascript">
(function(){var s = document.getElementsByTagName("script")[0];
var b = document.createElement("script");
b.type = "text/javascript";b.async = true;
b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
s.parentNode.insertBefore(b, s);})();
</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://dc.ads.linkedin.com/collect/?pid=477242&fmt=gif" />
</noscript>
  






 

  </body>
</html>