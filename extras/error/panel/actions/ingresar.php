<?php
//libreria
include_once '../../lib/lib.php';

//variables
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];


//verificar usuario
if(strtolower($usuario)=='admin'){
	if($clave=='1234'){
		$_SESSION['login_panel'] = 'yes';
		echo '<meta http-equiv="refresh" content="0; url=../pedidos.php">';
	}else{
		echo '<meta http-equiv="refresh" content="0; url=../?error=Contraseña incorrecta">';
	}
}else{
	echo '<meta http-equiv="refresh" content="0; url=../?error=Usuario incorrecto">';	
}


?>