<?php ?><!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Abraham Luna | Portfolio</title>
<meta name="description" content="Portfolio de Abraham Luna Villares">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<!-- Favicon -->

<link rel="icon" href="images/luna pictures audiovisual.ico" type="image/x-icon">

<style>
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:Inter,sans-serif;background:#fafafa;color:#111}
header{position:fixed;top:0;width:100%;background:rgba(255,255,255,.9);backdrop-filter:blur(10px);display:flex;justify-content:space-between;padding:18px 8%;z-index:9}
header a{text-decoration:none;color:#111;margin-left:20px}
.hero{height:100vh;background:url('https://lunapictures.com.mx/images/cv/herencia2.webp') center/cover;display:flex;align-items:center}
.overlay{background:rgba(0,0,0,.55);width:100%;height:100%;display:flex;align-items:center;padding:0 8%}
.hero h1{font:700 70px "Playfair Display",serif;color:#fff}
.hero p{color:#ddd;font-size:22px;max-width:650px;margin:20px 0}
.btn{display:inline-block;background:#fff;color:#111;padding:14px 24px;border-radius:40px;text-decoration:none}
section{padding:110px 8%}
h2{font:700 44px "Playfair Display",serif;margin-bottom:20px}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:30px}
.card{background:#fff;border-radius:18px;overflow:hidden;box-shadow:0 8px 30px rgba(0,0,0,.08);transition:.3s}
.card:hover{transform:translateY(-8px)}
.card img{width:100%;height:220px;object-fit:cover}
.card .c{padding:22px}
.tags span{display:inline-block;background:#eee;padding:5px 10px;border-radius:20px;font-size:12px;margin:4px}
.skills{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:15px}
.skill{background:#111;color:#fff;padding:18px;border-radius:12px;text-align:center}
footer{text-align:center;padding:60px;background:#111;color:#fff}

.viewer{

display:none;

position:fixed;
z-index:9999;

inset:0;

background:rgba(0,0,0,.94);

backdrop-filter:blur(10px);

}


.viewer-box{

height:100%;

display:flex;

align-items:center;

justify-content:center;

flex-direction:column;

}



.image-container{

position:relative;

width:80%;

max-width:1000px;

}



.image-container img{

width:100%;

max-height:70vh;

object-fit:contain;

}



.close{

position:absolute;

top:30px;
right:40px;

font-size:50px;

background:none;
border:none;

color:white;

cursor:pointer;

}


.arrow{

position:absolute;

top:50%;

transform:translateY(-50%);

font-size:60px;

border:none;

background:none;

color:white;

cursor:pointer;

}


.left{

left:-70px;

}


.right{

right:-70px;

}



.project-info{

color:white;

text-align:center;

max-width:700px;

margin-top:30px;

}

@media (max-width:768px){

header{

padding:15px 20px;
flex-direction:column;
gap:10px;

}

header nav{

display:flex;
flex-wrap:wrap;
justify-content:center;

}

.hero{

height:70vh;

}

.hero h1{

font-size:38px;
line-height:1.1;

}

.hero p{

font-size:18px;

}

section{

padding:70px 20px;

}

.grid{

grid-template-columns:1fr;

}

.viewer-box{

padding:20px;

}

.image-container{

width:100%;

}

.arrow{

font-size:40px;

}

.left{

left:10px;

}

.right{

right:10px;

}

}

</style>
</head>


<body>

<header>
	<strong>ABRAHAM LUNA</strong>
	<nav><a href="#about">Sobre mí</a><a href="#work">Proyectos</a><a href="#skills">Skills</a><a href="#contact">Contacto</a></nav></header>
<section class="hero">
	<div class="overlay"><div>
		<h1>Marketing Estrategico

<br>Frontend Developer · Branding · Creative Designer</h1><p>Creo identidades visuales, experiencias digitales y contenido que conecta con las personas.</p>
<a class="btn" href="#work">Ver proyectos</a>
</div> 
</div>
</section>

<section id="about">
	<h2>Sobre mí</h2>
	<p>Soy Abraham Luna Villares. Busco aportar ideas, resolver problemas y crear trabajo del que un equipo pueda sentirse orgulloso. Si necesitas a alguien que combine estrategia, diseño, marketing y tecnología para generar resultados, conversemo</p>
</section>

<section id="work">
	<h2>Proyectos destacados</h2>
	<div class="grid">

<div class="card" onclick="openProject(0)">
	<img
src="images/brhms/escala-de-grises-los-acusticos-albumes.webp"
loading="lazy"
decoding="async"
alt="BRHMS GRRO">
	
	<div class="c">
		<h3>BRHMS GRRO</h3>
		<p>Branding, dirección de arte, portadas y sitio web.</p>

		<div class="tags">
			<span>Branding</span>
			<span>Motion</span>
		</div>

	</div>
</div>

<div class="card" onclick="openProject(1)">
	<img
src="images/luna/cocoweb.webp"
loading="lazy"
decoding="async"
alt="LUNA PICTURES"> 
	<div class="c">
		<h3>Luna Pictures</h3>
		<p>Identidad visual y presencia digital.</p>

		<div class="tags">
			<span>UX/UI</span>
			<span>SEO</span>
		</div>

	</div>
</div>

<div class="card" onclick="openProject(2)">
	<img
src="images/coshushu/portada.webp"
loading="lazy"
decoding="async"
alt="COSHUSHU RAMEN">
	<div class="c">
		<h3>Coshushu ramen</h3>
		<p>Identidad visual y presencia digital.</p>

		<div class="tags">
			<span>branding</span>
			<span>SEO</span>
		</div>

	</div>
</div>

<div class="card" onclick="openProject(3)">
	<img
src="images/cochys/foto-facebook.webp"
loading="lazy"
decoding="async"
alt="COCHYS SERIGRAFIA">
	<div class="c">
		<h3>cochys serigrafia</h3>
		<p>Identidad visual y presencia digital.</p>

		<div class="tags">
			<span>html</span>
			<span>SEO</span>
		</div>

	</div>
</div>

<div class="card" onclick="openProject(4)">
	<img
src="images/apetito/loogo.webp"
loading="lazy"
decoding="async"
alt="APETITO CROSS">
	<div class="c">
		<h3>Apetito Cros</h3>
		<p>Identidad visual y presencia digital.</p>

		<div class="tags">
			<span>diseño grafico</span>
			<span>SEO</span>
		</div>

	</div>
</div>


<div class="card" onclick="openProject(5)">
	<img
src="images/mamba/la-mamba-logo-foto-perfil.webp"
loading="lazy"
decoding="async"
alt="LA MAMBA">
	<div class="c">
		<h3>LA MAMBA </h3>
		<p> contenido gastronomico </p>

		<div class="tags">
			<span>social media</span>
			<span>html</span>
		</div>

	</div>
</div>


<div class="card" onclick="openProject(6)">
	<img
src="images/arte/POSTMODERNISMO.webp"
loading="lazy"
decoding="async"
alt="ILUSTRACIONES ARTISTICAS">

	<div class="c">
		<h3>Arte Digital</h3>
		<p>Ilustraciones propias en acuarelas posteriomente digitalizadas</p>

		<div class="tags">
			<span>acuarelas</span>
			<span>ilustracion digital</span>
		</div>

	</div>
</div>


<div class="card" onclick="openProject(7)">
	<img
src="images/rute/chucho-responsive-rute.webp"
loading="lazy"
decoding="async"
alt="RUTE">

	<div class="c">
		<h3>Rute </h3>
		<p> diseño front edn y animacion vectorial para videos animados</p>

		<div class="tags">
			<span>UX/UI</span>
			<span>SEO</span>
		</div>

	</div>
</div>



 </div>

</section>

<section id="skills"><h2>Herramientas</h2><div class="skills">
<div class="skill">Photoshop</div><div class="skill">Illustrator</div><div class="skill">After Effects</div><div class="skill">Premiere</div><div class="skill">Figma</div><div class="skill">HTML/CSS</div><div class="skill">JavaScript</div><div class="skill">SEO</div>
</div></section>

<footer id="contact"><h2>Trabajemos juntos</h2><p>alv586@prodigy.net.mx</p><p>Guadalajara · México</p></footer>

<div id="projectViewer" class="viewer">

<button class="close" onclick="closeProject()">×</button>


<div class="viewer-box">


<div class="image-container">

<button class="arrow left" onclick="prevImage()">‹</button>


<img id="mainImage">


<button class="arrow right" onclick="nextImage()">›</button>


</div>



<div class="project-info">

<h1 id="projectTitle"></h1>

<p id="projectDescription"></p>


</div>



</div>

</div>




<script>

const projects=[


{
title:"BRHMS GRRO",

description:
"Branding, dirección de arte, portadas, identidad visual y desarrollo web.",

images:[

"images/brhms/escala-de-grises-los-acusticos.webp",
"images/brhms/mi-ser-brahms-brhms-grro-escala-de-grises-rock-pop-alternativo-cassete.webp",
"images/brhms/maravilloso-brhms-grro-escala-de-grises.webp",
"images/brhms/cristal-carton-acustico - copia.webp",


]

},



{
title:"Luna Pictures",

description:
"Identidad visual, arquitectura digital, producción audiovisual y estrategia de presencia online.",

images:[

"images/luna/banner2.webp",
"images/luna/imagotipo-vectorizado.webp",
"images/luna/logo.webp",
"images/luna/fotografia-de-producto-gdl.webp"

]

},



{
title:"Coshushu RAMEN",

description:
"Branding gastronómico, fotografía, contenido y comunicación visual.",

images:[

"images/coshushu/01.webp",
"images/coshushu/02.webp",
"images/coshushu/03.webp",
"images/coshushu/04.webp"

]

},



{
title:"Cochys Serigrafía",

description:
"Diseño gráfico, identidad visual y producción textil.",

images:[

"images/cochys/movil-facebook-publicacion2.webp",
"images/cochys/banner-facebook4.webp",
"images/cochys/cochys-background.webp",
"images/cochys/movil-facebook.webp"
]

},



{
title:"Apetito Cross",

description:
"Food branding, fotografía gastronómica y contenido digital.",

images:[

"images/apetito/diseño-exteriores.webp",
"images/apetito/borrador-vikingo.webp",
"images/apetito/foodtruck.webp",
"images/apetito/loogo.webp"

]

},



{
title:"La Mamba",

description:
"Contenido gastronómico, identidad visual y comunicación digital.",

images:[

"images/mamba/la-mamba-logo-foto-perfil.webp",
"images/mamba/menu.webp",
"images/mamba/hoja-1.webp",
"images/mamba/hoja2.webp"

]

},



{
title:"Arte Digital",

description:
"Ilustraciones tradicionales en acuarela convertidas en piezas digitales.",

images:[

"images/arte/POSTMODERNISMO.webp",
"images/arte/camino-de-piedra---el-caminante-nft.webp",
"images/arte/acuarela.webp",
"images/arte/la-mujer-en-el-rio.webp",
"images/arte/kotler.webp",
"images/arte/punk.webp",
"images/arte/mi-vecino-del-toro.webp"

]

},



{
title:"RUTE",

description:
"Diseño de interfaces, experiencia de usuario y animación vectorial.",

images:[

"images/rute/RUTE-LOGOTIPO.webp",
"images/rute/itienda-hecansoft-rute.webp",
"images/rute/i-tienda-hecansoft-rute-banner-3.webp",
"images/rute/i-tienda-rute-hecansoft-banner-2.webp",
"images/rute/i-pagos.webp",
"images/rute/i-cobros.webp",
"images/rute/i-tienda.webp"

]

}


];


let currentProject=0;
let currentImage=0;



function openProject(id){

currentProject=id;
currentImage=0;

document
.getElementById("projectViewer")
.style.display="block";

loadProject();

}



function loadProject(){

let p=projects[currentProject];


document.getElementById("mainImage").src =
p.images[currentImage];


document.getElementById("projectTitle").innerHTML =
p.title;


document.getElementById("projectDescription").innerHTML =
p.description;

}



function nextImage(){

let p=projects[currentProject];

currentImage++;

if(currentImage >= p.images.length){

currentImage=0;

}

loadProject();

}



function prevImage(){

let p=projects[currentProject];

currentImage--;

if(currentImage < 0){

currentImage=p.images.length-1;

}

loadProject();

}



function closeProject(){

document
.getElementById("projectViewer")
.style.display="none";

}

</script>


</body>



</html>