<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$id = $_GET['id'];
$prioridad = $_POST['prioridad'];

try{
	$imagen= new Imagen($id);
	$producto = $imagen->getProducto();
	$nombre = $producto->getNombre();
	$imagen->setPrioridad($prioridad);
		
	
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se cambió la prioridad de la imagen del producto '.$nombre.'').'">';
	
}catch(ExceptionBD $ex){	
	echo $ex->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al cambiar la prioridad de la imagen. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo $e->getMessage();	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al cambiar la prioridad de la imagen. Error: '.$e->getMessage().'').'">';
}



?>