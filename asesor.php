<?php
//libreria de clases
include_once 'lib/lib.php'; 

//lugar
$lugar = 4;

?>
<!DOCTYPE HTML> 
<html> 
<head>
<title>Asesor | Giamber Lubricantes | Bahía Blanca | <?php echo getCategoriasLeyenda(); ?></title>
<meta charset="UTF-8" />

<!-- Estilos -->
<link rel="stylesheet" href="css/global.css" />
<link rel="stylesheet" href="css/asesor.css" />
<link rel="stylesheet" href="css/contacto.css" />

<!-- Icono -->
<link rel="shortcut icon" href="img/icono.png" />

<!-- Celular -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- Fuentes -->
<link href="https://fonts.googleapis.com/css?family=Montserrat|Satisfy|Raleway:400,700" rel="stylesheet">

<!-- Descripción del sitio -->
<meta name="description" content="Distribuidora de lubricantes para Bahía Blanca y la zona." />

<!-- Cambia de imagenes slider -->
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type="text/javascript" src="js/index_slide.js" ></script>
<script type="text/javascript" src="js/index_productos.js" ></script>
<script type="text/javascript" src="js/menu_celular.js" ></script>

</head>
<body>	
<?php include_once 'bloques/header.php'; ?>	
<section id="contacto">
<div class="contenedor">
	<a id="pdf" href="Guia.pdf" download="">Descargá guía de aplicación</a>
	<a id="pdf" href="Equivalencias.pdf" download="">Descargá guía de equivalencias</a>

	<iframe src="https://motul.lubricantadvisor.com/Default.aspx?data=1&amp;lang=SPA" style="float: right;width: 100%; height: 600px; border: none; padding-top: 20px"></iframe>
</div>
</section>		
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>