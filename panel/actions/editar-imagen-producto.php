<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$id = $_GET['id'];
$imagen = $_FILES['imagen'];
if(isset($_POST['prioridad']))
	$prioridad = $_POST['prioridad'];

try{
	
	
	if(!isset($prioridad)){
	$i = new Imagen($id);
		$producto = $i->getProducto();
		$nombre = $producto->getNombre();
		$i->setImagen($imagen);
	}else{
		$p = new Producto($id);
		$p->setImagen($imagen,$prioridad);
		$nombre = $p->getNombre();		
	}	
		
	
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