<?php
include_once '../lib/lib.php';


//variables
$correo = $_POST['correo'];
$clave = $_POST['clave'];
$clave2 = $_POST['clave2'];
$nombre = $_POST['nombre'];
$dni = $_POST['dni'];


//sesiones para guardar datos
$_SESSION['f_correo'] = $correo;
$_SESSION['f_nombre'] = $nombre;
$_SESSION['f_dni'] = $dni;


//login
try{
	
	if($clave==$clave2){		
		agregarUsuario($correo,$nombre,$dni,$clave);	

		$_SESSION['login'] = 'yes';
		$_SESSION['correo'] = $correo;

		$usuario = new Usuario($correo);
		
		
		$mensaje   = '

		<html>
		<head><title>Usuario minorista creado en giamberlubricantes.com</title></head>
		<body><h1><img src="http://'.$_SERVER['HTTP_HOST'].'/img/logo.png" width="200px" /></h1>
		<hr>
		
		<b>Correo</b>: '.$usuario->getCorreo().' 
		<br><br>
		<b>DNI</b>: '.$usuario->getDNI().' 
		<br><br>
		<b>Nombre y Apellido</b>: '.$usuario->getNombre().' 
		<br><br>
		<hr>

		<font size="2">
		Ingresá con tu correo y tu contraseña en la sección de mayoristas.
		</font>
		</body>
		</html>';
		
		//enviar numero de usuario y mensaje de aprobación
		enviarCorreo($usuario->getCorreo(),'Tu usuario minorista fue creado | lubricantesgiamber.com',$mensaje,$de);
	
		
		
		

		echo '<meta http-equiv="refresh" content="0; url=../tienda.php">';
		
	}else{
		echo '<meta http-equiv="refresh" content="0; url=../registro.php?t='.e('Las contraseñas no coinciden').'">';		
	}
}catch(ExceptionBD $e){
	echo '<meta http-equiv="refresh" content="0; url=../registro.php?t='.e($e->getMessage()).'">';
}
	









?>