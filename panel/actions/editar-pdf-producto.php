<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$id = $_GET['id'];
$ficha_pdf = $_FILES['ficha_pdf'];

try{
	$producto = new Producto($id);
	$nombre = $producto->getNombre();
	$producto->setPDF($ficha_pdf);
		
	
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se cambió la ficha pdf del producto '.$nombre.'').'">';
	
}catch(ExceptionBD $ex){	
	echo $ex->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al cambiar ficha pdf. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo $e->getMessage();	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al cambiar ficha pdf. Error: '.$e->getMessage().'').'">';
}



?>