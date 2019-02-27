<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$id = $_GET['id'];


try{
	$p = new Producto($id);
	$nombre = $p->getNombre();
	eliminarProducto($id);
	
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se eliminó el producto '.$nombre.'').'">';
	
}catch(ExceptionBD $ex){	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al eliminar. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al eliminar. Error: '.$e->getMessage().'').'">';
}



?>