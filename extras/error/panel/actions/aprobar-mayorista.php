<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$correo = $_GET['id'];

try{
	
	$mayorista = new Mayorista($correo);
	$nombre = $mayorista->getNombre();
	$mayorista->aprobar();
	
	$mensaje   = '

	<html>
	<head><title>Usuario mayorista habilitado en giamberlubricantes.com</title></head>
	<body><h1><img src="http://'.$_SERVER['HTTP_HOST'].'/img/logo.png" width="200px" /></h1>
	<hr>
	
	<b>Numero de usuario</b>: '.$mayorista->getUsuario().' 
	<br><br>
	<b>Correo</b>: '.$mayorista->getCorreo().' 
	<br><br>
	<b>CUIT</b>: '.$mayorista->getCUIT().' 
	<br><br>
	<b>Nombre del negocio</b>: '.$mayorista->getNombre().' 
	<br><br>
	<hr>

	<font size="1">
	Ingresá con tu número de usuario o correo, y tu contraseña en la sección de mayoristas.
	</font>
	</body>
	</html>';
	
	//enviar numero de usuario y mensaje de aprobación
	enviarCorreo($mayorista->getCorreo(),'Tu usuario mayorista fue aprobado | lubricantesgiamber.com',$mensaje,$de);
	
	
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se aprobó al mayorista '.$nombre.'').'">';
	
}catch(ExceptionBD $ex){	
	echo $ex->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al aprobar usuario'.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo $e->getMessage();	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al aprobar usuario'.$e->getMessage().'').'">';
}



?>