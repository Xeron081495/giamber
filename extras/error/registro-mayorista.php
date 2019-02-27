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
	<div id="titulo">Registrar mayorista</div>
	<form action="actions/registro-mayorista.php" method="post">
	
		<?php if(isset($_GET['t'])) echo '<div id="mensaje">'.d($_GET['t']).'</div>'; ?>
	
		<div class="tipo_campo">Nombre del negocio</div>
		<input class="campo" name="nombre" <?php if(isset($_SESSION['f_nombre'])) echo 'value="'.$_SESSION['f_nombre'].'"'; ?> placeholder="Ingrese nombre del negocio" type="text" required />  
	
		<div class="tipo_campo">Correo electrónico</div>
		<input class="campo" <?php if(isset($_SESSION['f_correo'])) echo 'value="'.$_SESSION['f_correo'].'"'; ?> placeholder="correo@mail.com" name="correo" type="email" required />  
	
		<div class="tipo_campo">CUIT</div>
		<input class="campo" name="cuit" <?php if(isset($_SESSION['f_cuit'])) echo 'value="'.$_SESSION['f_cuit'].'"'; ?>  placeholder="Ingrese CUIT" type="number" required />  
			
		<div class="tipo_campo">Clave</div>		
		<input class="campo" name="clave" placeholder="######" minlength="8" type="password" required />  
		
		<div class="tipo_campo">Repetir Clave</div>
		<input class="campo" name="clave2" placeholder="######" minlength="8" type="password" required />  
			
		<input class="campo boton espacio" class="boton" value="Registrar" name="boton" type="submit" required /> 
		<!--<a class="campo boton" href="registro.php">No soy mayorista</a> --> 		
		<a class="campo boton" href="login-mayorista.php">Ya tengo usuario</a>
		<!--<a class="grande" href="login-mayorista.php">Ya tengo usuario</a>-->
	</form>
</div>
</section>		
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>