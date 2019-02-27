<?php 
//libreria
include_once '../lib/lib.php';

$SESSION['login_panel'] = 'yes';

//ver si inicio sesion
if(!isset($SESSION['login_panel']))
	echo '<meta http-equiv="refresh" content="0; url=./">';

//lugar
$id_lugar = 1;
$lugar = 'Pedidos';
$pedido = new Pedido($_GET['id']);


$columnas = array('Nombre Producto','Cantidad','Entrega','Anular');
$names = array('nombre','cantidad','entrega','anular');
$ancho_principal = 30;
$cant = count($columnas);
$ancho = round((100-$ancho_principal)/($cant-1),PHP_ROUND_HALF_DOWN);

//tiene como longitud cant+1. Para todo K entre 1<=k<=cant-1 los datos que se imprimen, 
//y en cant va un id si es necesario o un NULL
$datos = array();
foreach($pedido->getArticulos() as $art){
	array_push($datos, array($art['variedad']->getProducto()->getNombre().' de '.$art['variedad']->getEnvase(),$art['cantidad'],$art['cantidad'],NULL,$art['variedad']->getID()));
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
<link rel="stylesheet" media="screen" href="css/forms.css" />
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

<!-- JS -->
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type='text/javascript' src='js/funciones.js'></script> 
</head>

<body>
<?php include_once 'bloques/header.php'; ?>
<section id="cuerpo">
	<?php include_once 'bloques/menu.php'; ?>
	<section id="contenido">
		<div id="cabeza">
			<span id="titulo"><?php echo $lugar; ?> de <?php echo $pedido->getUsuario()->getNombre(); ?></span>
			<a href="pedidos.php">Volver</a>				
			<span id="info"><b>IMPORTANTE</b>. Si tenes stock de todo, pulsar Confirmar. Si no tenés stock de alguno, poner las unidades que vas a entregar. En caso de de no entregar en un futuro las unidades que no tenes en stock, poner anular.</span>
		</div>
		<article id="tabla">
			<form action="actions/pedido-confirmar.php?id=<?php echo $pedido->getID();?>&cant=<?php echo count($pedido->getArticulos()); ?>" method="post">	
			<input id="boton-confirmar" value="Confirmar" type="submit" />
			
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
				echo '<div id="filas" onmouseover="mostrar('.$j.')" onmouseleave="ocultar('.$j.')">';				
				for($i=0; $i<count($dato)-1; $i++){				
					if($i==0){
						echo '<div class="col primero" style="width: '.$ancho_principal.'%;">'.$dato[$i].'</div>';
					}elseif($i==1){						
						echo '<div class="col" style="width: '.$ancho.'%;">'.$dato[$i].'</div>';						
					}elseif($i==3){						
						echo '<input type="checkbox" name="'.$names[$i%count($names)].'-'.$dato[count($dato)-1].'" value="Bike">';
					}else{
						echo '<div class="col" style="width: '.$ancho.'%;"><input name="'.$names[$i%count($names)].'-'.$dato[count($dato)-1].'" type="number" value="'.$dato[$i].'" min="0" max="'.$dato[$i].'" step="1" required></div>';						
					}
				}
				echo '</div>';
				$j++;
			}			
			?>
		</article>	
		<article id="tabla-celular">
			<form action="actions/pedido-confirmar.php?id=<?php echo $pedido->getID();?>&cant=<?php echo count($pedido->getArticulos()); ?>" method="post">	
			<input id="boton-confirmar" value="Confirmar pedido" type="submit" />
			
		
			<?php
			$j = 0;
			foreach($datos as $dato){
				echo '<div id="filas" onmouseover="mostrar('.$j.')" onmouseleave="ocultar('.$j.')">';				
				for($i=0; $i<count($dato)-1; $i++){				
					if($i==0){
						echo '<div onclick="mostrarFila('.$j.')" class="col primero" >'.$dato[$i].'</div>';
					}elseif($i==1){						
						echo '<div class="col c'.$j.'" >Cantidad pedida: '.$dato[$i].'</div>';						
					}elseif($i==3){						
						echo '<div class="col c'.$j.'" >¿Desea anular el resto? <input class="anular" type="checkbox" name="'.$names[$i%count($names)].'-'.$dato[count($dato)-1].'" value="Bike"></div>';
					}else{
						echo '<div class="col c'.$j.'" >Cantidad entrega: <input name="'.$names[$i%count($names)].'-'.$dato[count($dato)-1].'" type="number" value="'.$dato[$i].'" min="0" max="'.$dato[$i].'" step="1" required></div>';						
					}
				}
				echo '</div>';
				$j++;
			}			
			?>
		</article>	
	</section>
	</form>
</section>
</body>
</html>