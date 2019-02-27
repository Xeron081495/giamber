<?php
include_once '../lib/lib.php';


//variables
$usuario = $_POST['usuario'];

//login
try{
	$usuario = new Mayorista($usuario);
	
	$mensaje   = '

		<html>
		<head><title>Recuperar contraseña</title></head>
		<body><h1><img src="http://'.$_SERVER['HTTP_HOST'].'/img/logo.png" width="200px" /></h1>
		<hr>
		
		<b>Ingresá al siguiente link y recuperá tu contraseña</b>
		<br><br>	
		<b>Ingrese aquí</b>: <a href="http://'.$_SERVER['HTTP_HOST'].'/clave.php?u='.e(''.$usuario->getCorreo()).'&f='.e(''.date('d')).'">http://'.$_SERVER['HTTP_HOST'].'/clave.php?u='.e(''.$usuario->getCorreo()).'&f='.e(''.date('d')).'</a> 
		<br><br>
		<hr>

		<font size="2">
		Ante cualquier duda, contactarse telefónicamente o meidante el formualrio de contacto en giamberlubricantes.com
		</font>
		</body>
		</html>';
		
		//enviar numero de usuario y mensaje de aprobación
		enviarCorreo($usuario->getCorreo(),'Reestablecer contraseña | lubricantesgiamber.com',$mensaje,$de);
	
	
	
		echo '<meta http-equiv="refresh" content="0; url=../mensaje.php?t='.e('Dirijase a su correo electrónico para reestablecer la contraseña. Recuerde revisar la casilla de spam si no visualiza nuestro email').'">';
		
}catch(ExceptionExiste $e){
	echo '<meta http-equiv="refresh" content="0; url=../olvide-clave.php?t='.e('El correo no registrado').'">';
}
	









?>