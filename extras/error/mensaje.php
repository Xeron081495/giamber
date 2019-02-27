<?php 
//libreria de clases
include_once 'lib/lib.php'; 

//lugar
$lugar = 3;

?>
<!DOCTYPE HTML> 
<html> 
<head>
<title>Registro mayorista | Giamber Lubricantes | Bahía Blanca | Motul, Maguiars y Sonax</title>
<meta charset="UTF-8" />

<!-- Estilos -->
<link rel="stylesheet" href="css/global.css" />
<link rel="stylesheet" href="css/login.css" />

<!-- Icono -->
<link rel="shortcut icon" href="img/icono.png" />

<!-- Celular -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- Fuentes -->
<link href="https://fonts.googleapis.com/css?family=Montserrat|Satisfy|Raleway:400,700" rel="stylesheet">

<!-- Descripción del sitio -->
<meta name="description" content="Distribuidora de lubricantes para Bahía Blanca y la zona." />

<!-- Cambia de imagenes slider -->
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type="text/javascript" src="js/index_slide.js" /></script>
<script type="text/javascript" src="js/index_productos.js" /></script>
</head>
<body>	
<?php include_once 'bloques/header.php'; ?>	
<section id="login">
<div class="contenedor contenedor-corto">
	<div id="titulo">Acceso Mayoristas</div>
	<form action="actions/login-mayorista.php" method="post">
		<?php if(isset($_GET['t']))
					echo '<div id="mensaje">'.d($_GET['t']).'</div>'; 
			else{
			?>
				<div id="mensaje">Los mayorista necesitan hablitación para operar. En las siguiente 48hs te llegará un correo con tu usuario y contraseña.</div>
	
			<?php }?>
	</form>
</div>
</section>		
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>