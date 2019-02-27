<?php 
//libreria de clases
include_once 'lib/lib.php'; 

//lugar
$lugar = 4;

?>
<!DOCTYPE HTML> 
<html> 
<head>
<title>Contacto | Giamber Lubricantes | Bahía Blanca | Motul, Maguiars y Sonax</title>
<meta charset="UTF-8" />

<!-- Estilos -->
<link rel="stylesheet" href="css/global.css" />
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
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type="text/javascript" src="js/index_slide.js" /></script>
<script type="text/javascript" src="js/index_productos.js" /></script>

</head>
<body>	
<?php include_once 'bloques/header.php'; ?>	
<section id="contacto">
<div class="contenedor">
	<div id="col1">
		<div class="titulo">Información de contacto</div>
		<div class="dato"><b>Dirección:</b> Pasaje calvento 1533, Bahía Blanca</div>
		<div class="dato"><b>Teléfono:</b> (0291) 1547878547</div>
		<div class="dato"><b>Correo Electrónico: </b> info@lubricantesgr.com</div>
		
		
		<div class="titulo horario">Atención telefónica</div>
		<div class="dato"><b>Lunes:</b> 8hs a 12hs - 16hs a 20hs</div>
		<div class="dato"><b>Martes:</b> 8hs a 12hs - 16hs a 20hs</div>
		<div class="dato"><b>Miercoles:</b> 8hs a 12hs - 16hs a 20hs</div>
		<div class="dato"><b>Jueves:</b> 8hs a 12hs - 16hs a 20hs</div>
		<div class="dato"><b>Viernes:</b> 8hs a 12hs - 16hs a 20hs</div>
		<div class="dato"><b>Sábado:</b> sin atención</div>
		<div class="dato"><b>Domingo:</b> sin atención</div>
		
	</div>
	<div id="col2">
		<div class="titulo">Formulario de contacto</div>
		<form>
			<input name="nombre" type="text" placeholder="Nombre y apellido / Nombre negocio" required />
			<input name="telefono" type="tel" placeholder="Teléfono" required />
			<input name="correo" type="email" placeholder="Correo eléctronico" required />
			<input name="direccion" type="text" placeholder="Direccion" />
			<input name="localidad" type="text" placeholder="Localidad" required />
			<textarea rows="5" name="mensaje" placeholder="Ingrese su consulta" required></textarea>
			<input id="submit_btn" type="submit" value="&nbsp;&nbsp;Enviar&nbsp;&nbsp;">
		</form>
	</div>
</div>
</section>		
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>