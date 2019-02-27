<?php 
//librerias 
include_once '../../lib/lib.php';


try{	
	//variables
	$cantidad = $_GET['cant'];
	$pedido = new Pedido($_GET['id']);
	$pedido->setConfirmado();

	//nos fijamos si esta confirmado y que no sea un aplazo
	if($pedido->estaConfirmado()){
		echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Este pedido ya fue confirmado').'">';
	}else{
		
		//separamos el pedido en tres clasificaciones
		$confirmado = array(); // [variedad,cant_entregada]
		$aplazado = array(); // [variedad,cant_entregada,cant_aplazada]
		$anulado = array(); // [variedad,cant_entregada, cant_cancelada]
		
		//paso la info a un arreglo array(Obj variedad, int cantidad, int entrega, bool anula)
		foreach($pedido->getArticulos() as $art){
			//ver estado del producto en el pedido
			$variedad = $art['variedad'];
			$cant_pedida = $art['cantidad'];
			$cant_entregada = $_POST['entrega-'.$art['variedad']->getID()];
			if(isset($_POST['anular-'.$art['variedad']->getID()])) $anula = true; else $anula = 0;
			
			if($cant_entregada==$cant_pedida){ //se entrega la totalidad del producto
				array_push($confirmado,array("variedad"=>$variedad,"cantidad"=>$cant_entregada));
			}elseif($cant_entregada!=$cant_pedida){
				//cantidad q no se entrega ahora
				$resto = $cant_pedida-$cant_entregada;
				
				//cambiamos la cantidad que se va a entregar
				if($cant_entregada>0){
					$pedido->agregarVariedad($variedad->getID(),$cant_entregada);
					array_push($confirmado,array("variedad"=>$variedad,"cantidad"=>$cant_entregada)); 
				}elseif($cant_entregada==0){
					//no se va a entregar ninguna undiad del prodcuto
					$pedido->eliminarVariedad($variedad->getID());
					echo 'la sacamos a la variedad del pedido';
				}
				
				//anula es 0 si se reprograma, 1 si se cancela
				if($anula>0){ //se cancela el resto					
					array_push($anulado,array("variedad"=>$variedad,"cantidad"=>$resto)); 
				}elseif($anula==0){	
					array_push($aplazado,array("variedad"=>$variedad,"cantidad"=>$resto));
					//creamos el pedido de aplazos si no lo hicimos
					if(!isset($pedido_aplazado))
						$pedido_aplazado = $pedido->getUsuario()->CrearPedido();
					$pedido_aplazado->setPedidoAplazado($pedido->getID());
					$pedido_aplazado->agregarVariedad($variedad->getID(),$resto);
				}								
			}
		}

		if(count($aplazado)>0 && isset($pedido_aplazado)){
			$pedido_aplazado->setTerminado();
		}

		//actualziamos el stock de la mercaderia
		$pedido->actualizarStock();
		
		//enviamos mensaje el usuario
		$mensaje = armarMensaje($confirmado,$aplazado,$anulado,$pedido,$pedido_aplazado);		
		enviarCorreo($pedido->getUsuario()->getCorreo(),'Confirmación de pedido #'.$pedido->getID().' | lubricantesgiamber.com',$mensaje,$de);
	}
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se confirmo el pedido #'.$pedido->getID().'').'">';



	
}catch(ExceptionBD $ex){	
	echo $ex->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al crear. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo $e->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al crear. Error: '.$e->getMessage().'').'">';
}



function armarMensaje($confirmado,$aplazado,$anulado,$pedido,$pedido_aplazado=NULL){
	
	$mensaje   = '
	<html>
	<head><title>Se confirmó tu pedido #'.$pedido->getID().'</title></head>
	<body><h1><img src="http://'.$_SERVER['HTTP_HOST'].'/img/logo.png" width="200px" /></h1>
	<hr>';
	
	
	if(count($confirmado)>0){
		
		$mensaje.='<b>Productos confirmados (entrega inmediata)</b><br />';
		
		foreach($confirmado as $p){
			$mensaje.= '> '.$p['cantidad'].' unidades de '.$p['variedad']->getProducto()->getNombre().' de '.$p['variedad']->getEnvase().'<br />';
		}
	}
		
	if($pedido_aplazado!=NULL){	
		$mensaje.= '<br><br><b>Productos postergados. Se creo pedido nuevo #'.$pedido_aplazado->getID().'</b><br />';
		
		foreach($aplazado as $p){
			$mensaje.= '>'.$p['cantidad'].' unidades de '.$p['variedad']->getProducto()->getNombre().' de '.$p['variedad']->getEnvase().'<br />';
		}
	}
		
	if(count($anulado)>0){
		
		$mensaje.= '<br><br><b>Productos cancelados.</b><br />';
		
		foreach($anulado as $p){
			$mensaje.= '>'.$p['cantidad'].' unidades de '.$p['variedad']->getProducto()->getNombre().' de '.$p['variedad']->getEnvase().'<br />';
		}
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