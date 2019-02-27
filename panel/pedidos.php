<?php 
//libreria
include_once '../lib/lib.php';

$SESSION['login_panel'] = 'yes';

//ver si inicio sesion
if(!isset($SESSION['login_panel']))
	echo '<meta http-equiv="refresh" content="0; url=./">';


//cargar lista de producto
if(isset($_GET['lista'])){
	if($_GET['lista']=='sin_conf'){
		$pedidos = getPedidos('WHERE confirmado=0');
	}elseif($_GET['lista']=='conf'){
		$pedidos = getPedidos('WHERE confirmado>0');
	}elseif($_GET['lista']=='aplazados'){
		$pedidos = getPedidos('WHERE aplazado is NOT NULL AND confirmado=0');
	}elseif($_GET['lista']=='sin_ent'){
		$pedidos = getPedidos('WHERE entregado=0 AND rechazado=0');
	}elseif($_GET['lista']=='sin_pag'){
		$pedidos = getPedidos('WHERE pagado=0');
	}elseif($_GET['lista']=='rechazado'){
		$pedidos = getPedidos('WHERE rechazado>0');
	}elseif($_GET['lista']=='factura'){
		$pedidos = getPedidos('WHERE factura=0');
	}
}else{
	$pedidos = getPedidos();
}


$id_lugar = 1;
$lugar = 'Pedidos';

$columnas = array('Nombre cliente','Fecha','Precio total ($)','Estado','Pago','Entrega');
$ancho_principal = 30;
$cant = count($columnas);
$ancho = round((100-$ancho_principal)/($cant-1),PHP_ROUND_HALF_DOWN);

//tiene como longitud cant+1. Para todo K entre 1<=k<=cant-1 los datos que se imprimen, 
//y en cant va un id si es necesario o un NULL
$datos = array();

foreach($pedidos as $p){
	if($p->estaTerminado()){
		if($p->estaEntregado()) $entregado = "Entregado"; else $entregado = "Entrega pend.";
		if($p->estaPagado()) $pagado = "Pagado"; else $pagado = "Pago pend.";
		if($p->getPedidoAplazado()!=NULL){
			$nombre = '#'.$p->getID().' - '.$p->getUsuario()->getNombre().' (de #'.$p->getPedidoAplazado()->getID().')';
		}else {
			$nombre = '#' . $p->getID() . ' - ' . $p->getUsuario()->getNombre();
		}
		array_push($datos, array($nombre,$p->getFechaHora(),'$ '.number_format ($p->getPrecioTotal(),2,',',' '),$p->getEstado(),$pagado,$entregado,$p->getID()));

	}
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $lugar; ?> | Panel de Control | Giamber Lubricantes  </title>
<link rel="shortcut icon" href="../img/icono.png" /> 
<!-- Hoja de estilos -->
<link rel="stylesheet" media="screen" href="css/global.css" />
<link rel="stylesheet" media="screen" href="css/tablas.css" />
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

<!-- JS -->
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type='text/javascript' src='js/funciones.js'></script> 
</head>

<body>
<?php include_once 'bloques/header.php'; ?>
<section id="cuerpo">
	<?php include_once 'bloques/menu.php'; ?>
	<section id="contenido">
		<div id="cabeza">
			<span id="titulo"><?php echo $lugar; ?></span>
			<a href="agregar-pedido.php">Agregar Pedido</a>
			<a href="pedidos.php?lista=sin_conf">Sin confirmar</a>
			<a href="pedidos.php?lista=aplazados">Aplazados</a>
			<a href="pedidos.php?lista=sin_ent">Sin entregar</a>
			<a href="pedidos.php?lista=sin_pag">No cobrados</a>
			<a href="pedidos.php?lista=rechazado">Rechazados</a>
			<a href="pedidos.php?lista=conf">Confirmados</a>
			<a href="pedidos.php?lista=factura">Sin factura</a>
			<a href="pedidos.php">Todos</a>
		</div>
		<article id="tabla">	
			<div id="titulos">
				<?php 
				for($i=0; $i<$cant; $i++){
					if($i==0){
						echo '<div class="col primero" style="width: '.$ancho_principal.'%;">'.$columnas[$i].'</div>';
					}else{
						echo '<div class="col" style="width: '.$ancho.'%;">'.$columnas[$i].'</div>';						
					}
				}
				?>
			</div>
			<?php
			$j = 0;
			foreach($datos as $dato){
				$pedido = new Pedido($dato[count($dato)-1]);
				echo '<div id="filas" onmouseover="mostrar('.$j.')" onmouseleave="ocultar('.$j.')">';				
				for($i=0; $i<count($dato)-1; $i++){				
					if($i==0){
						echo '<div class="col primero" style="width: '.$ancho_principal.'%;">'.$dato[$i].'</div>';
					}else{
						echo '<div class="col" style="width: '.$ancho.'%;">'.$dato[$i].'</div>';						
					}
				}
				echo '<div id="o'.$j.'" class="opciones">
				<a href="pedido-ver.php?id='.$dato[count($dato)-1].'">Ver pedido</a>';
				if($pedido->getUsuario()->getDireccion()!=NULL)
					echo '<a href="pedido-datos.php?id='.$dato[count($dato)-1].'">Ver datos cliente</a>';
				if(!$pedido->estaConfirmado() && !$pedido->estaRechazado())
					echo '<a href="pedido-confirmar.php?id='.$dato[count($dato)-1].'">Confirmar pedido</a>';
				echo '<a href="actions/pdf-pedido.php?id='.$dato[count($dato)-1].'" download="">Descargar Pedido</a>';
				if($pedido->estaConfirmado() && !$pedido->estaEntregado())
					echo '<a href="actions/pedido-confirmar-entrega.php?id='.$dato[count($dato)-1].'">Poner como entregado</a>';
				if($pedido->estaConfirmado() && !$pedido->estaPagado())
					echo '<a href="actions/pedido-confirmar-pago.php?id='.$dato[count($dato)-1].'">Pedido cobrado</a>';
				if(!$pedido->estaConfirmado() && !$pedido->estaRechazado())
					echo '<a class="ultimo" href="actions/pedido-rechazar.php?id='.$dato[count($dato)-1].'">Rechazar pedido</a>';
				if($pedido->estaConfirmado() && !$pedido->estaRechazado() && !$pedido->estaFactura())
					echo '<a class="ultimo" href="pedido-factura.php?id='.$dato[count($dato)-1].'">Enviar factura</a>';
				echo '</div>';				
				echo '</div>';
				$j++;
			}			
			?>
		</article>	
		<article id="tabla-celular">
			<?php
			$j = 0;
			foreach($datos as $dato){
				$pedido = new Pedido($dato[count($dato)-1]);
				echo '<div id="filas" onmouseover="mostrar('.$j.')" onmouseleave="ocultar('.$j.')">';				
				for($i=0; $i<count($dato)-1; $i++){				
					if($i==0){
						echo '<div onclick="mostrarFila('.$j.')" class="col primero">'.$dato[$i].'</div>';
					}else{
						echo '<div class="col c'.$j.'">'.$dato[$i].'</div>';						
					}
				}
				echo '<div id="o'.$j.'" class="opciones c'.$j.'">
				<a href="pedido-ver.php?id='.$dato[count($dato)-1].'">Ver pedido</a>';
				if($pedido->getUsuario()->getDireccion()!=NULL)
					echo '<a href="pedido-datos.php?id='.$dato[count($dato)-1].'">Ver datos cliente</a>';
				if(!$pedido->estaConfirmado() && !$pedido->estaRechazado())
					echo '<a href="pedido-confirmar.php?id='.$dato[count($dato)-1].'">Confirmar pedido</a>';
				if($pedido->estaConfirmado() && !$pedido->estaEntregado())
					echo '<a href="actions/pedido-confirmar-entrega.php?id='.$dato[count($dato)-1].'">Poner como entregado</a>';
				if($pedido->estaConfirmado() && !$pedido->estaPagado())
					echo '<a href="actions/pedido-confirmar-pago.php?id='.$dato[count($dato)-1].'">Pedido cobrado</a>';
				if(!$pedido->estaConfirmado() && !$pedido->estaRechazado())
					echo '<a class="ultimo" href="actions/pedido-rechazar.php?id='.$dato[count($dato)-1].'">Rechazar pedido</a>';
				if($pedido->estaConfirmado() && !$pedido->estaRechazado())
					echo '<a class="ultimo" href="pedido-factura.php?id='.$dato[count($dato)-1].'">Enviar factura</a>';
				echo '</div>';
				echo '</div>';
				$j++;
			}			
			?>
		</article>	
		
		
	</section>
</section>
</body>
</html>