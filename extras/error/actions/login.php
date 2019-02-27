<?php
include_once '../lib/lib.php';


//variables
$correo = $_POST['correo'];
$clave = $_POST['clave'];



//login
try{
	$usuario = new Usuario($correo);
	
	if($usuario->getClave()==$clave){
		//crear variables
		$_SESSION['login'] = 'yes';
		$_SESSION['correo'] = $usuario->getCorreo();		
		
		echo '<meta http-equiv="refresh" content="0; url=../tienda.php">';
	}else{
		echo '<meta http-equiv="refresh" content="0; url=../login.php?t='.e('Clave incorrecta').'">';
	}
}catch(ExceptionExiste $e){
	echo '<meta http-equiv="refresh" content="0; url=../login.php?t='.e('Correo no registrado').'">';
}
	









?>