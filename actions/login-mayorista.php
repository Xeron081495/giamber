<?php
include_once '../lib/lib.php';


//variables
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];



//login
try{
	$usuario = new Mayorista($usuario);
	
	if($usuario->getClave()==$clave || $usuario->getClave()==crypt($clave,'motul')){
		
		if($usuario->estaAprobado()){
		
			//crear variables
			$_SESSION['login'] = 'yes';
			$_SESSION['correo'] = $usuario->getCorreo();

			//verifico si estaba en algun lado
			if(isset($_GET['t'])){
				echo '<meta http-equiv="refresh" content="0; url='.d($_GET['t']).'">';
			}else
				echo '<meta http-equiv="refresh" content="0; url=../tienda.php?ingreso=si">';


		}else{
			echo '<meta http-equiv="refresh" content="0; url=../login-mayorista.php?t='.e('Tu usuario no está aprobado o fue bloqueado.').'">';	
		}
	}else{
		echo '<meta http-equiv="refresh" content="0; url=../login-mayorista.php?t='.e('Clave incorrecta').'">';
	}
}catch(ExceptionExiste $e){
	echo '<meta http-equiv="refresh" content="0; url=../login-mayorista.php?t='.e('Usuario no registrado').'">';
}
	









?>