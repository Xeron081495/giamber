<?php 
//libreria
include_once '../lib/lib.php';

$SESSION['login_panel'] = 'yes';

//ver si inicio sesion
if(!isset($SESSION['login_panel']))
	echo '<meta http-equiv="refresh" content="0; url=./">';

//lugar
$id_lugar = 2;
$lugar = 'Productos';


$columnas = array('Nombre Producto','Precio Min.','Precio May.','Caja','Stock');
$names = array('nombre','precio_min','precio_may','caja','stock');
$ancho_principal = 30;
$cant = count($columnas);
$ancho = round((100-$ancho_principal)/($cant-1),PHP_ROUND_HALF_DOWN);

//tiene como longitud cant+1. Para todo K entre 1<=k<=cant-1 los datos que se imprimen, 
//y en cant va un id si es necesario o un NULL
$datos = array();
foreach(getProductos() as $prod){
	foreach($prod->getVariedades() as $v){
		array_push($datos, array($prod->getNombre().' de '.$v->getEnvase(),$v->getPrecioUnidad(),$v->getPrecioMayorista(),$v->getCantidadMayorista(),$v->getStock(),$v->getID()));
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
<link rel="stylesheet" media="screen" href="css/forms.css" />
<link rel="stylesheet" media="screen" href="css/tablas.css" />
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
			<span id="titulo"><?php echo $lugar; ?></span>
			<a href="agregar-producto.php">Agregar Producto</a>	
			<a href="productos.php">Volver</a>			
		</div>
		<article id="tabla">
			<form action="actions/edicion-rapida-productos.php?cant=<?php echo count($datos); ?>" method="post">
			<input id="boton-confirmar" value="Subir modificaciones" type="submit" />	
			
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
						echo '<div class="col" style="width: '.$ancho.'%;"><input step="0.01" name="'.$names[$i%count($names)].'-'.$dato[count($dato)-1].'" type="number" value="'.$dato[$i].'" required></div>';						
					}
				}
				echo '</div>';
				$j++;
			}			
			?>
			</form>
		</article>
		<article id="tabla-celular">
			<form action="actions/edicion-rapida-productos.php?cant=<?php echo count($datos); ?>" method="post">
			<input id="boton-confirmar" value="Subir modificaciones" type="submit" />	
			
			<?php
			$j = 0;
			foreach($datos as $dato){
				echo '<div id="filas" onmouseover="mostrar('.$j.')" onmouseleave="ocultar('.$j.')">';				
				for($i=0; $i<count($dato)-1; $i++){				
					if($i==0){
						echo '<div onclick="mostrarFila('.$j.')" class="col primero">'.$dato[$i].'</div>';
					}else{
						echo '<div class="col  c'.$j.'">'.$names[$i%count($names)].': <input step="0.01" name="'.$names[$i%count($names)].'-'.$dato[count($dato)-1].'" type="number" value="'.$dato[$i].'" required></div>';						
					}
				}
				echo '</div>';
				$j++;
			}			
			?>
			</form>
		</article>	
	</section>
</section>
</body>
</html>