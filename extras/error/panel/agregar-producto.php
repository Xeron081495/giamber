<?php 
//libreria
include_once '../lib/lib.php';

$SESSION['login_panel'] = 'yes';

//ver si inicio sesion
if(!isset($SESSION['login_panel']))
	echo '<meta http-equiv="refresh" content="0; url=./">';

//lugar
$id_lugar = 2;
$lugar = 'Agregar producto';


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
			<a href="productos.php">Volver</a>	
			<span id="info"><b>IMPORTANTE</b>. Los campos con asterisco (*) son obligatorios. Los campos que están en "datos generales" son los datos que aparecen sin importar si el envase es de 2 litros o de un litro. Los campos que aparecen después de variedad principal del producto es la principal variedad que tiene el producto, por ejemplo, envase de 1 litro, 45 unidades en stock, $45 por unidad para consumidor final, 6 unidades de tamaño por caja (intervalo) para el mayorista y $200 por caja para el mayorista. Las demás variedades de este producto se crean después de crear este mismo.</span>
		</div>
		<form action="actions/agregar-producto.php" method="post" enctype="multipart/form-data">
			<div class="titulo">Datos generales</div>
		
			<label>
				<div class="campo_nombre">Nombre del producto *</div>
				<input name="nombre" class="campo_input" type="text" required />
			</label>
			<label>
				<div class="campo_nombre">Imagen *</div>
				<input name="imagen" class="campo_input" type="file" required />
			</label>
			<label>
				<div class="campo_nombre">Categoría *</div>
				<select name="categoria" class="campo_input" required>
					<option value="">Seleccionar categoría</option>
					<?php
						foreach(getCategorias() as $categoria){
							echo '<option>'.$categoria->getNombre().'</option>';
						}
					?>				
					
				</select>
			</label>
			<label>
				<div class="campo_nombre">Aplicación</div>
				<input name="aplicacion" class="campo_input" type="text" />
			</label>
			<label>
				<div class="campo_nombre">Tipo</div>
				<input name="tipo" class="campo_input" type="text" />
			</label>
			<label>
				<div class="campo_nombre">Gama</div>
				<input name="gama" class="campo_input" type="text" />
			</label>
			<label>
				<div class="campo_nombre">Video <sub>(solo Youtube)</sub></div>
				<input name="video" class="campo_input" type="text" />
			</label>
			<label>
				<div class="campo_nombre">Modelo</div>
				<input name="modelo" class="campo_input" min="0" type="number" />
			</label>
			<label>
				<div class="campo_nombre">PDF</div>
				<input name="ficha_pdf" class="campo_input" type="file" />
			</label>	
			<label>
				<div class="campo_nombre"><br><br></div>
			</label>	
			<label>
				<div class="campo_nombre">Descripcion:</div>
			</label>			
			<div id="editor">
				<textarea name="descripcion" class="descripcion"></textarea>
				<script type="text/javascript">
					CKEDITOR.replace ("descripcion");
				</script> 
			</div>
			<div class="titulo">Variedad principal del producto</div>
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
			<label id="largo">
				<input class="campo_boton" value="Reiniciar campos" type="reset" />
				<input class="campo_boton" value="Crear producto" type="submit" />
			</label>
			
		</form>
	</section>
</section>
</body>
</html>