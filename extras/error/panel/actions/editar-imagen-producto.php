<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$id = $_GET['id'];
$imagen = $_FILES['imagen'];

try{
	$producto = new Producto($id);
	$nombre = $producto->getNombre();
	$producto->setImagen($imagen);
		
	
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se cambió la imagen del producto '.$nombre.'').'">';
	
}catch(ExceptionBD $ex){	
	echo $ex->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al cambiar imagen. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo $e->getMessage();	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al cambiar imagen. Error: '.$e->getMessage().'').'">';
}



?>