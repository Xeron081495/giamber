<?php 
//libreria
include_once '../lib/lib.php';

$SESSION['login_panel'] = 'yes';

//ver si inicio sesion
if(!isset($SESSION['login_panel']))
	echo '<meta http-equiv="refresh" content="0; url=./">';


$id_lugar = 1;
$lugar = 'Pedidos';

$columnas = array('Producto','Envase','Cantidad pedida','Precio total');
$ancho_principal = 30;
$cant = count($columnas);
$ancho = round((100-$ancho_principal)/($cant-1),PHP_ROUND_HALF_DOWN);

//tiene como longitud cant+1. Para todo K entre 1<=k<=cant-1 los datos que se imprimen, 
//y en cant va un id si es necesario o un NULL
$datos = array();

if(isset($_GET['temporal']) && isset($_SESSION['pedido'])){
	foreach($_SESSION['pedido']['variedades'] as $art){
		$variedad = new Variedad($art['variedad']);
		$nombre = $variedad->getProducto()->getNombre();
		array_push($datos, array($nombre,$variedad->getEnvase(),$art['cantidad'].' unidades','Precio no disponible en pedido temporal',NULL));
	}
}else{
	$pedido = new Pedido($_GET['id']);
	foreach($pedido->getArticulos() as $art){
		$nombre = $art['variedad']->getProducto()->getNombre();
		array_push($datos, array($nombre,$art['variedad']->getEnvase(),$art['cantidad'].' unidades','$'.$art['precio_final'],NULL));
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
			<span id="titulo">Pedido de 
				<?php 	if(isset($_GET['temporal']) && isset($_SESSION['pedido'])){ 
							echo $_SESSION['pedido']['nombre'].' (pedido temporal)'; 
						}else 
							echo $pedido->getUsuario()->getNombre().'. Fecha: '.$pedido->getFecha(); 
				?>
				</span>
			<?php if(isset($_GET['temporal'])){
						echo '<a href="agregar-pedido.php">Volver</a>';
			      }else{
						echo '<a href="pedidos.php">Volver</a>';
				  }
			?>
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
				echo '<div id="filas" onmouseover="mostrar('.$j.')" onmouseleave="ocultar('.$j.')">';				
				for($i=0; $i<count($dato)-1; $i++){				
					if($i==0){
						echo '<div class="col primero" style="width: '.$ancho_principal.'%;">'.$dato[$i].'</div>';
					}else{
						echo '<div class="col" style="width: '.$ancho.'%;">'.$dato[$i].'</div>';						
					}
				}		
				echo '</div>';
				$j++;
			}			
			?>
		</article>	
		<article id="tabla-celular">
			<?php
			$j = 0;
			foreach($datos as $dato){
				echo '<div id="filas" onmouseover="mostrar('.$j.')" onmouseleave="ocultar('.$j.')">';				
				for($i=0; $i<count($dato)-1; $i++){				
					if($i==0){
						echo '<div  onclick="mostrarFila('.$j.')" class="col primero" >'.$dato[$i].'</div>';
					}else{
						echo '<div class="col c'.$j.'" >'.$dato[$i].'</div>';						
					}
				}		
				echo '</div>';
				$j++;
			}			
			?>
		</article>	
	</section>
</section>
</body>
</html>