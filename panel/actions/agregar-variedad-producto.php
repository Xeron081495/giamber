<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$id = $_GET['id'];
$precio_unidad = $_POST['precio_unidad'];
$precio_mayorista = $_POST['precio_mayorista'];
$cantidad_mayorista = $_POST['cantidad_mayorista'];
$stock = $_POST['stock'];
$envase = $_POST['envase'];
$oferta= $_POST['oferta'];

try{
	//agregar a la web
	$producto = new Producto($id);
	$nombre = $producto->getNombre();
	$producto->agregarVariedad($envase,$precio_unidad,$cantidad_mayorista,$precio_mayorista,$stock,$oferta);
	
	
	
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se agregó la variedad a '.$nombre.'').'">';
	
}catch(ExceptionBD $ex){	
	echo $ex->getMessage();
	//echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al crear. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al crear. Error: '.$e->getMessage().'').'">';
}



?>