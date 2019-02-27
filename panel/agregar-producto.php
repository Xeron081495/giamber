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
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type='text/javascript' src='js/funciones.js'></script> 
<script type='text/javascript'>
	cantidad_imagenes = 0;
	
	function agregarFoto(){//el anterior cambio el + por x
		
		if(cantidad_imagenes==4)
			alert('No se puede agregar más fotos.');
		else{
			//agrego el nuevo campo
			$(".ultimo-"+cantidad_imagenes).after('<label class="ultimo-'+(cantidad_imagenes+1)+'"><div class="campo_nombre">Imagen '+(cantidad_imagenes+2)+'*</div><input name="imagen-'+(cantidad_imagenes+1)+'" class="campo_input campo_imagen" type="file" required/></label>');
			cantidad_imagenes++;
		}
	}
	
	function eliminarFoto(){
		
		if(cantidad_imagenes==0)
			alert('Tiene que haber como minimo una foto.');
		else{
			$(".ultimo-"+cantidad_imagenes).remove();
			cantidad_imagenes--;
		}
	} 
</script>

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
				<input name="nombre" class="campo_input" <?php if(isset($_SESSION['error']['nombre'])) echo 'value="'.$_SESSION['error']['nombre'].'"'; ?> type="text" required />
			</label>
			<label>
				<div class="campo_nombre">Categoría *</div>
				<select name="categoria" class="campo_input" required>
					<option <?php if(isset($_SESSION['error']['categoria'])) echo 'value="'.$_SESSION['error']['categoria'].'"'; else echo 'value=""'; ?>><?php if(isset($_SESSION['error']['categoria'])) echo $_SESSION['error']['categoria']; else echo 'Seleccionar categoría';  ?></option>
					<?php
						foreach(getCategorias() as $categoria){
							echo '<option>'.$categoria->getNombre().'</option>';
						}
					?>				
					
				</select>
			</label>
			<label class>
				<div class="campo_nombre">Imagen 1*</div>
				<input name="imagen-0"  class="campo_input campo_imagen" type="file" required />	
			</label>
			<label class="ultimo-0">
				<div class="campo_input agregar_imagen" onclick="agregarFoto();">+</div>
				<div class="campo_input agregar_imagen" onclick="eliminarFoto();">-</div>
			</label>
			<label>
				<div class="campo_nombre">Aplicación</div>
				<input name="aplicacion" maxlength="30" <?php if(isset($_SESSION['error']['aplicacion'])) echo 'value="'.$_SESSION['error']['aplicacion'].'"'; ?> class="campo_input" type="text" />
			</label>
			<label>
				<div class="campo_nombre">Tipo</div>
				<input name="tipo" maxlength="30" <?php if(isset($_SESSION['error']['tipo'])) echo 'value="'.$_SESSION['error']['tipo'].'"'; ?> class="campo_input" type="text" />
			</label>
			<label>
				<div class="campo_nombre">Gama</div>
				<!--<input name="gama" maxlength="30" <?php if(isset($_SESSION['error']['gama'])) echo 'value="'.$_SESSION['error']['gama'].'"'; ?> placeholder="Por ej.: auto, moto, comeptición" class="campo_input" type="text" />-->
				<select name="gama" class="campo_input" required>
					<option <?php if(isset($_SESSION['error']['gama'])) echo 'value="'.$_SESSION['error']['gama'].'"'; else echo 'value=""'; ?>><?php if(isset($_SESSION['error']['gama'])) echo $_SESSION['error']['gama']; else echo 'Seleccionar gama';  ?></option>
					<option>Autos</option>
					<option>Motos</option>
					<option>Competición</option>
					<option>Linea pesada</option>
					<option>Transmisión</option>
					<option>Autos - Motos</option>
					<option>Autos - Motos - Pick-up</option>
					<option>Autos - Pick-up</option>
					<option>Autos - Pick-up - Linea pesada</option>
				</select>
			</label>
			<label>
				<div class="campo_nombre">Video <sub>(solo Youtube)</sub></div>
				<input name="video" <?php if(isset($_SESSION['error']['video'])) echo 'value="'.$_SESSION['error']['video'].'"'; ?> class="campo_input" type="url" />
			</label>
			<label>
				<div class="campo_nombre">Homologación</div>
				<input name="modelo" maxlength="40" <?php if(isset($_SESSION['error']['modelo'])) echo 'value="'.$_SESSION['error']['modelo'].'"'; ?> class="campo_input" type="text" />
			</label>
			<label>
				<div class="campo_nombre">PDF</div>
				<input name="ficha_pdf" class="campo_input" type="file" />
			</label>	
			<label>
				<div class="campo_nombre">Descripcion:</div>
			</label>			
			<div id="editor">
				<textarea name="descripcion" class="descripcion"><?php if(isset($_SESSION['error']['descripcion'])) echo $_SESSION['error']['descripcion']; ?></textarea>
				<script type="text/javascript">
					CKEDITOR.replace ("descripcion");
				</script> 
			</div>
			<div class="titulo">Variedad principal del producto</div>
			<label>
				<div class="campo_nombre">Envase *</div>
				<input name="envase" class="campo_input" <?php if(isset($_SESSION['error']['envase'])) echo 'value="'.$_SESSION['error']['envase'].'"'; ?> type="text" required />
			</label>
			<label>
				<div class="campo_nombre">Stock por unidades *</div>
				<select class="campo_input" name="stock" required>
					<option <?php if(isset($_SESSION['error']['stock'])) echo 'value="'.$_SESSION['error']['stock'].'"'; else echo 'value=""'; ?>>Elegir opción</option>
					<option value="0">No hay stock</option>
					<option value="1">Hay stock</option>
				</select>
				
			</label>
			<label>
				<div class="campo_nombre">Precio por unidad*</div>
				<input name="precio_unidad" <?php if(isset($_SESSION['error']['precio_unidad'])) echo 'value="'.$_SESSION['error']['precio_unidad'].'"'; ?> class="campo_input"  min="0.01" step="0.01" type="number" required />
			</label>
			<label>
				<div class="campo_nombre">Tamaño caja mayorista*</div>
				<input name="cantidad_mayorista" <?php if(isset($_SESSION['error']['cantidad_mayorista'])) echo 'value="'.$_SESSION['error']['cantidad_mayorista'].'"'; ?> class="campo_input"  min="1" step="1" type="number" required />
			</label>
			<label>
				<div class="campo_nombre">Precio caja mayorista*</div>
				<input name="precio_mayorista" class="campo_input" <?php if(isset($_SESSION['error']['precio_mayorista'])) echo 'value="'.$_SESSION['error']['precio_mayorista'].'"'; ?> min="0.01" step="0.01" type="number" required />
			</label>
			<label>
				<div class="campo_nombre">Oferta en %</div>
				<input name="oferta" class="campo_input" <?php if(isset($_SESSION['error']['oferta'])) echo 'value="'.$_SESSION['error']['oferta'].'"'; ?> value="0" min="0" step="1" max="99" type="number" required />
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