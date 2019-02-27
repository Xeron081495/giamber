<?php 
//libreria
include_once '../lib/lib.php';

$SESSION['login_panel'] = 'yes';

//ver si inicio sesion
if(!isset($SESSION['login_panel']))
	echo '<meta http-equiv="refresh" content="0; url=./">';

$p = new Producto($_GET['id']);

//lugar
$id_lugar = 2;
$lugar = 'Editar ficha pdf de '.$p->getNombre();


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
		</div>
		<form action="actions/editar-pdf-producto.php?id=<?php echo $p->getID(); ?> " method="post" enctype="multipart/form-data">
			
			<label>
				<div class="campo_nombre">PDF</div>
				<input name="ficha_pdf" class="campo_input" type="file" />
			</label>
			<label id="largo">
				<input class="campo_boton" value="cambiar imagen" type="submit" />
			</label>
			
		</form>
	</section>
</section>
</body>
</html>