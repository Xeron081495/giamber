<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$id = $_GET['id'];
$pedido = new Pedido($_GET['id']);

try{

	if($_FILES['factura']['error']==0) {
		enviarCorreo($pedido->getUsuario()->getCorreo(), 'Factura correspondiente al pedido #' . $pedido->getID(), 'Se adjunta factura del pedido #' . $pedido->getID() . '.', $de, 'Giamber Lubricantes', $_FILES['factura']);
		$pedido->setFactura($_FILES['factura']);
	}else{
		echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al enviar factura. Error: el archivo no se pudo cargar').'">';
		exit;
	}

	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se envió la factura').'">';
	
}catch(ExceptionBD $ex){	
	echo $ex->getMessage();
}catch(Exception $e){
	echo $e->getMessage();	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al enviar factura. Error: '.$e->getMessage().'').'">';
}



?>