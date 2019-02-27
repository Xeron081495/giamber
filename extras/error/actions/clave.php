<?php
include_once '../lib/lib.php';


//variables
$usuario = $_POST['usuario'];
$c1 = $_POST['c1'];
$c2 = $_POST['c2'];

echo $usuario;

//login
try{
	$u = new Mayorista($usuario);
	
	if($c1==$c2){
		$u->setClave($c1);		
		echo '<meta http-equiv="refresh" content="0; url=../mensaje.php?t='.e('Su contraseña fue modificada').'">';		
	}else{
		echo '<meta http-equiv="refresh" content="0; url=../clave.php?u='.e(''.$usuario).'&t='.e('Las contraseñas no coinciden.').'">';
	}

}catch(ExceptionExiste $e){
	echo '<meta http-equiv="refresh" content="0; url=../olvide-clave.php?t='.e('El correo no registrado').'">';
}
	









?>