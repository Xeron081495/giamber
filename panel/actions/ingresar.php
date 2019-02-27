<?php
//libreria
include_once '../../lib/lib.php';

//variables
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];


//verificar usuario
if(strtolower($usuario)=='admin' || strtolower($usuario)=='angel'){
	if(esAdmin($usuario,$clave) || esAngel($usuario,$clave)){
		$_SESSION['login_panel'] = 'yes';
		echo '<meta http-equiv="refresh" content="0; url=../pedidos.php">';
	}else{
		echo '<meta http-equiv="refresh" content="0; url=../?error=Contraseña incorrecta">';
	}
}else{
	echo '<meta http-equiv="refresh" content="0; url=../?error=Usuario incorrecto">';	
}


function esAdmin($usuario, $clave){
	$_SESSION['nombre'] = 'Andrés';
	return (strtolower($usuario)=='admin' && $clave=='1234');
		
}

function esAngel($usuario, $clave){
	$_SESSION['nombre'] = 'Angel';
	return (strtolower($usuario)=='angel' && $clave=='amp1544');
}


?>