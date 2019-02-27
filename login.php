<?php 
//libreria de clases
include_once 'lib/lib.php'; 

echo '<meta http-equiv="refresh" content="0; url=login-mayorista.php">';

//lugar
$lugar = 3;

?>
<!DOCTYPE HTML> 
<html> 
<head>
<title>Iniciar sesión | Giamber Lubricantes | Bahía Blanca | <?php echo getCategoriasLeyenda(); ?></title>
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
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type="text/javascript" src="js/index_slide.js" /></script>
<script type="text/javascript" src="js/index_productos.js" /></script>
</head>
<body>	
<?php include_once 'bloques/header.php'; ?>	
<section id="login">
<div class="contenedor contenedor-corto">
	<div id="titulo">Iniciar sesión</div>
	<form action="actions/login.php" method="post">
		<?php if(isset($_GET['t'])) echo '<div id="mensaje">'.d($_GET['t']).'</div>'; ?>
		<div class="tipo_campo">Correo electrónico</div>
		<input class="campo" placeholder="correo@mail.com" name="correo" type="email" required />  
		<div class="tipo_campo">Clave</div>
		<input class="campo" name="clave" placeholder="######" type="password" required />  
		<input class="campo boton espacio" class="boton" value="Ingresar" name="boton" type="submit" required /> 
		<a class="campo boton" href="registro.php">No tengo usuario</a>  
		<a class="grande" href="login-mayorista.php">Soy Mayorista</a>
		<a href="olvide-clave.php">Olvidé mi clave</a>
	</form>
</div>
</section>		
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>