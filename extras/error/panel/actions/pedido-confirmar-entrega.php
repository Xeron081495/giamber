<?php 
//librerias 
include_once '../../lib/lib.php';


try{	
	//variables
	$pedido = new Pedido($_GET['id']);
	
	//nos fijamos si esta confirmado
	if($pedido->estaEntregado()){
		echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Este pedido ya fue entregado').'">';
	}else{
		$pedido->setEntregado(1);
		enviarCorreo($pedido->getUsuario()->getCorreo(),'Tu pedido fue entregado #'.$pedido->getID().' | lubricantesgiamber.com',armarMensaje($pedido),$de);		

	}
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se agregó el pedido como entregado'.$nombre.'').'">';
	
}catch(ExceptionBD $ex){	
	echo $ex->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al modificar. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo $e->getMessage();	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al modificar. Error: '.$e->getMessage().'').'">';
}

function armarMensaje($pedido){
	
	$mensaje   = '
	<html>
	<head><title>Se registró como entregado tu pedido #'.$pedido->getID().'</title></head>
	<body><h1><img src="http://'.$_SERVER['HTTP_HOST'].'/img/logo.png" width="200px" /></h1>
	<hr>';
	
	
	$mensaje.='<b>Productos confirmados (entrega inmediata)</b><br />';
		
	foreach($pedido->getArticulos() as $p){
		$mensaje.= '> '.$p['cantidad'].' unidades de '.$p['variedad']->getProducto()->getNombre().' de '.$p['variedad']->getEnvase().'<br />';
	}
	
	$mensaje .= '
	<hr>
	<font size="2">
	Ante cualquier duda, contartarse telefónicamente.
	</font>
	</body>
	</html>';
	
	return $mensaje;	
	
}

?>