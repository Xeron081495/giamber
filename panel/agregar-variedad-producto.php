<?php 
//libreria
include_once '../lib/lib.php';

$SESSION['login_panel'] = 'yes';

//ver si inicio sesion
if(!isset($SESSION['login_panel']))
	echo '<meta http-equiv="refresh" content="0; url=./">';

//lugar
$id_lugar = 2;
$lugar = 'Agregar variedad a producto';


//prodcuto
$p = new Producto($_GET['id']);

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
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

<!-- JS -->
<script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
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
			<a href="productos.php">Volver</a>	
			<span id="info"><b>IMPORTANTE</b>. Los campos con asterisco (*) son obligatorios. Va a agregar una variedad al producto <?php echo $p->getNombre(); ?></span>
		</div>
		<form action="actions/agregar-variedad-producto.php?id=<?php echo $p->getID(); ?>" method="post" enctype="multipart/form-data">
	
			<label>
				<div class="campo_nombre">Envase *</div>
				<input name="envase" class="campo_input" type="text" required />
			</label>
			<label>
				<div class="campo_nombre">Stock por unidades *</div>
				<input name="stock" class="campo_input" min="0" type="number" required>
			</label>
			<label>
				<div class="campo_nombre">Precio por unidad*</div>
				<input name="precio_unidad" class="campo_input"  min="0.01" step="0.01" type="number" required />
			</label>
			<label>
				<div class="campo_nombre">Tamaño caja mayorista*</div>
				<input name="cantidad_mayorista" class="campo_input"  min="1" step="1" type="number" required />
			</label>
			<label>
				<div class="campo_nombre">Precio caja mayorista*</div>
				<input name="precio_mayorista" class="campo_input"  min="0.01" step="0.01" type="number" required />
			</label>
			<label>
				<div class="campo_nombre">Oferta en %</div>
				<input name="oferta" class="campo_input"  value="0" min="0" step="1" max="99" type="number" required />
			</label>
			<label id="largo">
				<input class="campo_boton" value="Agregar variedad" type="submit" />
			</label>
			
		</form>
	</section>
</section>
</body>
</html>