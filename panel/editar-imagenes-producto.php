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

$p = new Producto($_GET['id']);


$columnas = array('Imagen','Cambiar Imagen','Prioridad','Eliminar');
$names = array('Imagen','Modificar','Prioridad','Eliminar');
$ancho_principal = 40;
$cant = count($columnas);
$ancho = round((100-$ancho_principal)/($cant-1),PHP_ROUND_HALF_DOWN);

//tiene como longitud cant+1. Para todo K entre 1<=k<=cant-1 los datos que se imprimen, 
//y en cant va un id si es necesario o un NULL
$datos = array();
$cont = 0;
foreach($p->getImagenes() as $i){
	array_push($datos, array('<img width="150px" src="../productos/'.$i->getNombre().'" />','<a class="boton" href="editar-imagen-producto.php?id='.$i->getID().'">Cambiar imagen</a>','<a class="boton" href="editar-prioridad-imagen-producto.php?id='.$i->getID().'">Cambiar prioridad ('.$i->getPrioridad().')</a>','<a class="boton" href="actions/eliminar-imagen.php?id='.$i->getID().'">Eliminar imagen</a>',$i->getID()));
	$cont++;
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
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type='text/javascript' src='js/funciones.js'></script> 
</head>

<body>
<?php include_once 'bloques/header.php'; ?>
<section id="cuerpo">
	<?php include_once 'bloques/menu.php'; ?>	
	<section id="contenido">
		<div id="cabeza">
			<span id="titulo">Editar imagenes de <?php echo $p->getNombre(); ?></span>
			<a href="agregar-imagen.php?id=<?php echo $p->getID(); ?>">Agregar Imagen</a>			
			<a href="productos.php">Volver</a>			
		</div>
		<article id="tabla">
			<form action="actions/editar-imagenes-productos.php?id=<?php echo $p->getID(); ?>" method="post">
						
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
						echo '<div class="col  c'.$j.'">'.$dato[$i].' </div>';						
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