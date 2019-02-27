<?php 
//libreria
include_once '../lib/lib.php';

$SESSION['login_panel'] = 'yes';

//lugar
$id_lugar = 2;
$lugar = 'Productos';

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
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type='text/javascript' src='js/funciones.js'></script> 
</head>

<body>
<?php include_once 'bloques/header.php'; ?>
<section id="cuerpo">
	<?php include_once 'bloques/menu.php'; ?>	
	<section id="contenido">
		<div id="cabeza">
			<span id="titulo">Modificar precios de todos los productos de una marca</span>
			<a href="productos.php">Volver</a>			
			
		</div>
			<article id="tabla-form">
				<form action="actions/editar-precios-categoria.php" method="post" enctype="multipart/form-data">
				<label>
					<div class="campo_nombre">Porcentaje de aumento (0% a 100%)</div>
					<input name="porcentaje" class="campo_input" max="100" step="0.1" type="number" required>		
				</label>
				<label>				
					<div class="campo_nombre">Categoria</div>
					<select name="categoria" class="campo_input" type="text" required>		
						<option value="">Seleccionar marca</option>
						<?php 
							foreach(getCategorias() as $c){
								$gamas = $c->getGamas();
								$array = ["marca"=>$c->getNombre(),"gama"=>""];
								echo '<option value="'.e(serialize($array)).'">'.$c->getNombre().' (Todos)</option>';	
								foreach($gamas as $g){
									$array = ["marca"=>$c->getNombre(),"gama"=>$g];
									echo '<option value="'.e(serialize($array)).'">'.$c->getNombre().' ('.$g.')</option>';									
								}											
							}
						?>
					</select>	
				</label>						
				<label>
					<input class="campo_boton2" value="aplicar aumento" type="submit" />
				</label>
			</form>	
		</article>	
	</section>
</section>
</body>
</html>