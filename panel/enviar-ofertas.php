<?php 
//libreria
include_once '../lib/lib.php';

$SESSION['login_panel'] = 'yes';

//ver si inicio sesion
if(!isset($SESSION['login_panel']))
	echo '<meta http-equiv="refresh" content="0; url=./">';


//lugar
$id_lugar = 0;
$lugar = 'Productos';

//variables
if(isset($_GET['t'])){
	$mensaje = urldecode($_GET['t']);
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
			<span id="titulo">Enviar ofertas</span>
			<span id="info">Seleccione los productos de los cuales quiere enviar una oferta</span>

			<?php 
				//convierto a array de $id de variedades
				$ofertas = unserialize(urldecode(d($_GET['oferta'])));
			?>

			<form action="actions/enviar-ofertas.php?oferta=<?php echo $_GET['oferta']; ?>" method="post">			
			
			<?php
				//recorro todos las ofertas
				foreach($ofertas as $oferta){

					//genero la variedad
					$variedad = new Variedad($oferta);

					echo '<p><label><input class="campo_checkbox" name="var_'.$variedad->getID().'" type="checkbox" checked="true">'.$variedad->getProducto()->getNombre().' de '.$variedad->getEnvase().'. <b>Oferta: '.$variedad->getOferta().'%</b></label></p>';
				}
					
			
			?>
			<p><input id="boton-confirmar" value="Enviar ofertas" type="submit" /></p>
			</form>

		</div>
	</section>
</section>
</body>
</html>