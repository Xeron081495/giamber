<?php 
//libreria de clases
include_once 'lib/lib.php'; 

$usuario = d($_GET['u']);
if(isset($_GET['f']))
	$dia = d($_GET['f']);


if(isset($dia) && $dia!=date('d')){
	echo '<meta http-equiv="refresh" content="0; url=../mensaje.php?t='.e('Link inválido para cambiar contraseña, recuerde que solo duran el mismo dia en que se solicitó el cambio.').'">';
}

//lugar
$lugar = 3;

?>
<!DOCTYPE HTML> 
<html> 
<head>
<title>Recuperar contraseña | Giamber Lubricantes | Bahía Blanca | Motul, Maguiars y Sonax</title>
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
	<div id="titulo">Recuperar contraseña</div>
	<form action="actions/clave.php" method="post">
		<?php if(isset($_GET['t'])) echo '<div id="mensaje">'.d($_GET['t']).'</div>'; ?>  
		<div class="tipo_campo">Correo electrónico</div>
		<input class="campo" value="<?php echo $usuario; ?>" name="usuario" type="text" readonly />  
		<div class="tipo_campo">Ingresar la nueva clave</div>
		<input class="campo" name="c1" type="password" required />  
		<div class="tipo_campo">Repetir la clave</div>
		<input class="campo" name="c2" type="password" required />  
		<input class="campo boton espacio" class="boton" value="Cambiar contraseña" type="submit" required /> 
		<a class="campo boton" href="registro-mayorista.php">No tengo usuario</a>  
		<!--<a class="grande" href="login.php">No soy mayorista</a>-->
	</form>
</div>
</section>		
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>