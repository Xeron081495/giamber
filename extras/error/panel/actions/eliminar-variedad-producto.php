<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$id = $_GET['id'];
$variedad= $_GET['variedad'];


try{
	$p = new Producto($id);
	$nombre = $p->getNombre();
	$p->eliminarVariedad($variedad);
	
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se eliminó la variedad de '.$nombre.'').'">';
	
}catch(ExceptionBD $ex){	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al eliminar. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al eliminar. Error: '.$e->getMessage().'').'">';
}



?>