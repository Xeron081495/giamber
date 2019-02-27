<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$id = $_GET['id'];


try{
	
	
	$i = new Imagen($id);
	$producto = $i->getProducto();
	$nombre = $producto->getNombre();
	
	
	if(count($producto->getImagenes())>1){
		$producto->eliminarImagen($id);
		//redireccionar
		echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se eliminó la imagen del producto '.$nombre.'').'">';
	}else
		echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('El producto tiene que tener como minimo una imagen').'">';

	
	
}catch(ExceptionBD $ex){	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al eliminar la imagen. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al eliminar la imagen. Error: '.$e->getMessage().'').'">';
}



?>