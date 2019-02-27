<?php
include_once '../lib/lib.php';


//variables
$correo = $_POST['correo'];
$nombre = $_POST['nombre'];
$cuit = $_POST['cuit'];
$telefono = $_POST['telefono'];
$calle = $_POST['calle'];
$numero = $_POST['numero'];
$piso_depto = $_POST['piso'];
$entre = $_POST['entre'];
$ciudad = $_POST['ciudad'];
$cp = $_POST['cp'];
$clave = $_POST['clave'];
$clave2 = $_POST['clave2'];

//sesiones para guardar datos
$_SESSION['f_correo'] = $correo;
$_SESSION['f_nombre'] = $nombre;
$_SESSION['f_cuit'] = $cuit;
$_SESSION['f_telefono'] = $telefono;
$_SESSION['f_calle'] = $calle;
$_SESSION['f_numero'] = $numero;
$_SESSION['f_piso'] = $piso_depto;
$_SESSION['f_entre'] = $entre;
$_SESSION['f_ciudad'] = $ciudad;
$_SESSION['f_cp'] = $cp;


//login
try{
	
	if($clave==$clave2){		
		agregarMayorista($correo,$nombre,$cuit,$clave);		

		$usuario = new Mayorista($correo);		
		$usuario->setDireccion($telefono,$calle,$numero,$piso_depto,$entre,$ciudad,$cp,"");	

		echo '<meta http-equiv="refresh" content="0; url=../mensaje.php">';
		
	}else{
		echo '<meta http-equiv="refresh" content="0; url=../registro-mayorista.php?t='.e('Las contraseñas no coinciden').'">';		
	}
			

}catch(ExceptionBD $e){
	echo '<meta http-equiv="refresh" content="0; url=../registro-mayorista.php?t='.e($e->getMessage()).'">';
}
	









?>