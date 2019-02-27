<?php
include_once '../lib/lib.php';


//variables
$correo = $_POST['correo'];
$nombre = $_POST['nombre'];
$cuit = $_POST['cuit'];
$clave = $_POST['clave'];
$clave2 = $_POST['clave2'];

//sesiones para guardar datos
$_SESSION['f_correo'] = $correo;
$_SESSION['f_nombre'] = $nombre;
$_SESSION['f_cuit'] = $cuit;


//login
try{
	
	if($clave==$clave2){		
		agregarMayorista($correo,$nombre,$cuit,$clave);		

		$usuario = new Mayorista($correo);
				
		$mensaje   = '

		<html>
		<head><title>Usuario mayorista creado en giamberlubricantes.com</title></head>
		<body><h1><img src="http://'.$_SERVER['HTTP_HOST'].'/img/logo.png" width="200px" /></h1>
		<hr>
		
		<b>Este tipo de usuarios requiere aprobación de Giamber Lubricantes, en las siguiente 48hs recibirá un correo.</b>
		<br><br>	
		<b>Numero de usuario</b>: '.$usuario->getUsuario().' 
		<br><br>
		<b>Correo</b>: '.$usuario->getCorreo().' 
		<br><br>
		<b>DNI</b>: '.$usuario->getCUIT().' 
		<br><br>
		<b>Nombre del negocio</b>: '.$usuario->getNombre().' 
		<br><br>
		<hr>

		<font size="2">
		Ingresá con tu correo/numero y tu contraseña en la sección de mayoristas una vez aprobado.
		</font>
		</body>
		</html>';
		
		//enviar numero de usuario y mensaje de aprobación
		enviarCorreo($usuario->getCorreo(),'Tu usuario mayorista fue creado | lubricantesgiamber.com',$mensaje,$de);
	
		
		
		echo '<meta http-equiv="refresh" content="0; url=../mensaje.php">';
		
	}else{
		echo '<meta http-equiv="refresh" content="0; url=../registro-mayorista.php?t='.e('Las contraseñas no coinciden').'">';		
	}
			

}catch(ExceptionBD $e){
	echo '<meta http-equiv="refresh" content="0; url=../registro-mayorista.php?t='.e($e->getMessage()).'">';
}
	









?>