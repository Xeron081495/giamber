<?php 
include_once '../lib/lib.php';


//variables
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$localidad = $_POST['localidad'];
$consulta = $_POST['mensaje'];



$mensaje   = '
	<html>
	<head><title>Consulta enviada desde la web</title></head>
	<body><h1><img src="http://'.$_SERVER['HTTP_HOST'].'/img/logo.png" width="200px" /></h1>
	<hr>
	
	<p><b>Nombre</b>: '.$nombre.'</p>
	<p><b>Telefono</b>: '.$telefono.'</p>
	<p><b>Correo</b>: '.$correo.'</p>
	<p><b>Dirección</b>: '.$direccion.'</p>
	<p><b>Localidad</b>: '.$localidad.'</p>
	
	<br>
	<p><b>Mensaje</b>: '.$consulta.'</p>
	
	<hr>
	<font size="2">
	Consulta enviada por la web.
	</font>
	</body>
	</html>';

try{	
	enviarCorreo($de,'Consulta enviada desde la web',$mensaje,$correo,$nombre);
	echo '<meta http-equiv="refresh" content="0; url=../mensaje.php?t='.e('Se envió el mensaje').'">';
}catch(Exception $e){
	echo '<meta http-equiv="refresh" content="0; url=../mensaje.php?t='.e($e->getMessage().'').'">';
}

?>