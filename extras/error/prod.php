<?php 
//libreria de clases
include_once 'lib/lib.php'; 

//lugar
$lugar = 3;


try{	
	//variables
	$p = new Producto(d($_GET['id']));
	$_SESSION['variedad'] = 0;
	
	//usuario
	if(isset($_SESSION['login'])){
		try{
			$usuario = new Mayorista($_SESSION['correo']);	
		}catch(ExceptionExiste $e){
			$usuario = new Usuario($_SESSION['correo']);		
		}
		$pedido = $usuario->getPedido(); 	
	}
	
	
}catch(ExceptionExiste $e){
	//el prodcuto no existe y hay que tomar un desición
	echo 'No existe el producto';
	exit;
}

?>
<!DOCTYPE HTML> 
<html> 
<head>
<title><?php echo $p->getNombre(); ?> | Tienda Online de Giamber Lubricantes</title>
<meta charset="UTF-8" />

<!-- Estilos -->
<link rel="stylesheet" href="css/global.css" />
<link rel="stylesheet" href="css/tienda.css" />
<link rel="stylesheet" href="css/prod.css" />

<!-- Icono -->
<link rel="shortcut icon" href="img/icono.png" />

<!-- Celular -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- Fuentes -->
<link href="https://fonts.googleapis.com/css?family=Montserrat|Satisfy|Raleway:400,700|Titillium+Web" rel="stylesheet">

<!-- Descripción del sitio -->
<meta name="description" content="Distribuidora de lubricantes para Bahía Blanca y la zona." />

<!-- Cambia de imagenes slider -->
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type="text/javascript" src="js/index_slide.js" /></script>
<script type="text/javascript" src="js/index_productos.js" /></script>
<script type="text/javascript" src="js/menu_celular.js" /></script>
<script type="text/javascript">

//guardo los datos de todas las variedades
var precios = []; //precio que paga el cliente
var precios_min = []; //precio minorista
var precios_may = []; //precio mayorista
var variedad = []; // id de variedades
var stock = []; // stock del producto
var step = []; // cantidad del mayorista
var variedad_actual = 0; //predeterminada es la opcion 1

//inicicializamos los arreglos
<?php 
	for($i=0; $i<count($p->getVariedades());$i++){
		//si es mayorista agrego los precios mayorista		
		if(isset($usuario) && $usuario->getStep()){ ?> 
			precios.push(<?php echo $p->getVariedades()[$i]->getPrecioMayorista(); ?>); 
		<?php 
		}else{ 
		?>
			precios.push(<?php echo $p->getVariedades()[$i]->getPrecioUnidad(); ?>);
		<?php 
		} 
		?> 
		//agrego los demas datos
		stock.push(<?php echo $p->getVariedades()[$i]->getStock(); ?>); 
		step.push(<?php echo $p->getVariedades()[$i]->getCantidadMayorista(); ?>);
		variedad.push(<?php echo $p->getVariedades()[$i]->getID(); ?>);
		precios_may.push(<?php echo $p->getVariedades()[$i]->getPrecioMayorista(); ?>); 
		precios_min.push(<?php echo $p->getVariedades()[$i]->getPrecioUnidad(); ?>);
<?php
	}	
?>


// Va monitoreando cambios en la web
$(document).ready(function(){	
	
	//captura si modifican el valor del input que contiene la cantidad que el cliente quiere comprar
	$("#cantidad_carrito").click(function () {		
		//saco el valor accediendo a un input de tipo text y name = nombre
		var cantidad_carrito = $('input[name=cantidad]').val(); 
		var n = cantidad_carrito*precios[variedad_actual];
		$(".precio_carrito").html('Precio total: $'+n.toFixed(2));		
	});	
	
	
	//va monitoreando si hay stock o no del producto
	<?php 
		if(isset($usuario) && $usuario->getStep() && $p->getVariedades()[0]->getStock()<$p->getVariedades()[0]->getCantidadMayorista()){
			?> //$('.form-carrito').css({'display': 'none'});
			$('.stock').html('Unidades agostadas para mayorista');<?php
		}elseif($p->getVariedades()[0]->getStock()==0){
			?> $('.form-carrito').css({'display': 'none'});
			$('.stock').html('Unidades agostadas');<?php
		}
	?>
	
});

//modifica todo lo que corresponda al cambiar de tipo de envase
function cambiarVariedad(i){
	
	//pongo el precio actual de la variedad
	variedad_actual = i;
	
	//modifico el precio que está abajo de titulo
	$(".precio").html('$'+precios_min[variedad_actual].toFixed(2));
	$('#cantidad_carrito').attr('max',stock[variedad_actual]);
	$('#variedad_carrito').val(''+variedad[variedad_actual]);
	$('#precio-mayorista').html('$'+precios_may[variedad_actual].toFixed(2));
	$('#precio-minorista').html('$'+precios_min[variedad_actual].toFixed(2));
	
	<?php
	if(isset($usuario) && $usuario->getStep()){
	?>
		$('#cantidad_carrito').attr('min',step[variedad_actual]);
		$('#cantidad_carrito').attr('step',step[variedad_actual]);
		$('#cantidad_carrito').val(''+step[variedad_actual]);
		if(stock[variedad_actual]<step[variedad_actual]){
			$('.stock').html('Unidades agostadas para mayoristas');
		}else{
			$('.form-carrito').css({'display': 'block'});
			$('.stock').html('');
		}
	<?php
	}else{
		?>
		if(stock[variedad_actual]==0){
			$('.stock').html('Unidades agostadas');
		}else{
			$('.form-carrito').css({'display': 'block'});
			$('.stock').html('');
		}
		<?php		
	}	
	?>
	
	//modifico el precio del carrito
	var cantidad_carrito = $('input[name=cantidad]').val(); 
	var n = cantidad_carrito*precios[variedad_actual];
	$(".precio_carrito").html('Precio total: $'+n.toFixed(2));
		
	//pongo en color la opcion elegida
	$('#e'+i).css({'background-color': '#FFBDBD'});
	$('#e'+i).css({'border': 'solid #ba0000 0.05em'});
	$('#e'+i).css({'color': '#ba0000'});
	
	//saco el color de elegido a los demás
	for(var j=0; j<100; j++){
		if(i!=j){
			$('#e'+j).css({'background-color': '#C4E2FF'});
			$('#e'+j).css({'border': 'solid #57ABFF 0.05em'});
			$('#e'+j).css({'color': '#00376E'});
		}
	}	
}


//VIDEO DE YOUTUBE
function mostrar(){
	$('#fondo').css({'display': 'block'});
	$('#youtube_video').css({'display': 'block'});
	
	//empezar video
	$("iframe#frame")[0].src = "https://www.youtube.com/embed/<?php echo $p->getVideo(); ?>?rel=0&autoplay=1";	
}
function noMostrar(){
	$('#fondo').css({'display': 'none'});
	$('#youtube_video').css({'display': 'none'});
	
	//pausar video
	$("iframe#frame")[0].src = "";
}
var visi = 0;
function mostrarAvanzadas(){
	if(visi==0){
		$('.opciones-busqueda').css({'display': 'inline-block'});
		$('#menu-avanzado').html('Ocultar menú de búsqueda');
		visi = 1;
	}else{
		$('.opciones-busqueda').css({'display': 'none'});
		$('#menu-avanzado').html('Mostrar menú de búsqueda');
		visi = 0;
	}
}

</script>
</head>
<body>	
<?php include_once 'bloques/header.php'; ?>	
<section id="busqueda">
<div class="contenedor">
	<form>
		<input name="text" type="text" placeholder="Ingrese el nombre del producto" required />
		<input id="boton" name="submit" type="text" value="Buscar" required />
	</form>
	<div onClick="mostrarAvanzadas()" id="menu-avanzado">Mostrar menú de búsqueda</div>
	<section id="marcas" class="opciones-busqueda">
		<div id="titulo">Búsqueda por marcas:</div>
		<?php 
			foreach(getCategorias() as $categoria){
				echo '<a href="tienda.php?categoria='.e($categoria->getNombre()).'" class="marca '.$categoria->getNombre().'" onclick="mostrar_cat('.$categoria->getNombre().')" style="background-image: url('.$categoria->getImagen().');" ></a>';
			}
		?>
	
	</section>
</div>
</section>
<section id="carrito">
<div class="contenedor">
	<div id="texto">
		<h1 id="titulo">Tienda Giamber Lubricantes</h1>
		<h4 id="subtitulo">Hacé clic en el producto, elegí la cantidad y agregalo a tu pedido. Podrás ver el precio en la parte superior derecha.</h4>
	</div>
	<div id="cont">
		<a <?php if(isset($pedido) && count($pedido->getArticulos())>0) echo 'href="carrito.php"'; ?> id="pedido">Seleccionó <?php if(isset($pedido)) echo count($pedido->getArticulos()); else echo '0'; ?> artículo(s): $<?php if(isset($pedido)) echo number_format($pedido->getPrecioTotal(),2); else echo ' 0'; ?></a>
		<?php  if(isset($pedido) && count($pedido->getArticulos())>0) echo '<a href="carrito.php" id="pago">Finalizar pedido y pagar</a>'; ?>
	</div>
</div>
</section>
<section id="producto">
<div class="contenedor">
	<div id="imagen" style="background-image: url(productos/<?php echo $p->getImagen(); ?>);">
	</div>	
	<div id="info">
		<div id="marca">Marca:</div><img id="imagen_marca" src="<?php echo $p->getCategoria()->getImagen(); ?>" />
		<h1 id="titulo"><?php echo $p->getNombre(); ?></h1>
		<div class="precio">$ <?php echo formatoPrecio($p->getVariedades()[0]->getPrecioUnidad()); ?></div>	
		<div class="stock"></div>
		<?php
			if(count($p->getVariedades())>1){
		?>
		<div class="dato">
			<div class="titulo">Elegir envase:</div>
			<div class="texto">
				<?php
					$i = 0;
					foreach($p->getVariedades() as $variedad){
						echo '<a target="_blanck" id="e'.$i.'" onclick="cambiarVariedad('.$i.')" class="texto ficha">'.$variedad->getEnvase().'</a>';
						$i++;
					}
				?>
			</div>
		</div>
			<?php }else{ ?>
				<div class="dato">
			<div class="titulo">Envase:</div>
			<div class="texto"><?php echo $p->getVariedades()[0]->getEnvase(); ?></div>
		</div>
			
			<?php } ?>
			
			
			
		<?php 
			if(isset($usuario) && $usuario->getStep()){
				echo '<div class="dato">
						<div class="titulo">Precio mayorista:</div>
						<div class="texto" id="precio-mayorista">$'.$p->getVariedades()[0]->getPrecioMayorista().'</div>
					</div>';
			}
		?>
		<?php 
			if($p->getAplicacion()!=NULL)
				echo '<div class="dato">
						<div class="titulo">Aplicación:</div>
						<div class="texto">'.$p->getAplicacion().'</div>
					</div>';
		?>
		<?php 
			if($p->getTipo()!=NULL)
				echo '<div class="dato">
						<div class="titulo">Tipo:</div>
						<div class="texto">'.$p->getTipo().'</div>
					</div>';
		?>
		<?php 
			if($p->getGama()!=NULL)
				echo '<div class="dato">
						<div class="titulo">Gama:</div>
						<div class="texto">'.$p->getGama().'</div>
					</div>';
		?>
		<?php 
			if($p->getModelo()!=NULL)
				echo '<div class="dato">
						<div class="titulo">Modelo:</div>
						<div class="texto">'.$p->getModelo().'</div>
					</div>';
		?>
		<?php 
			if($p->getFichaPDF()!=NULL)
				echo '<div class="dato">
						<div class="titulo">Ficha técnica:</div>
						<a target="_blanck" href="productos/'.$p->getFichaPDF().'" class="texto ficha">Ver ficha</a>
					</div>';
		?>			
		<?php 
			if($p->getVideo()!=NULL)
				echo '<div class="dato">
						<div class="titulo">Video:</div>
						<a onclick="mostrar()" target="_blanck" class="texto ficha">Ver video</a>
					</div>';
		?>	
		<?php 
			if(isset($usuario) && $usuario->getStep())
				echo '<div class="dato">
						<div class="titulo">Stock:</div>
						<div class="texto">'.$p->getVariedades()[0]->getStock().' unidades</div>
					</div>';
		?>	
		<form action="carrito.php" method="post" class="form-carrito" id="carrito">
			<div id="cantidad">Elegí la cantidad: </div>
			<input id="cantidad_carrito" name="cantidad" type="number" hmax="<?php echo $p->getVariedades()[0]->getStock(); ?>" class="cantidad" <?php if(isset($usuario) && $usuario->getStep()) echo 'step="'.$p->getVariedades()[0]->getCantidadMayorista().'" min="'.$p->getVariedades()[0]->getCantidadMayorista().'" value="'.$p->getVariedades()[0]->getCantidadMayorista().'"'; else echo 'value="1" min="1"'; ?>/>
			<input id="variedad_carrito" name="variedad" type="hidden" value="<?php echo $p->getVariedades()[0]->getID(); ?>" />
			<div id="cantidad" class="precio_carrito">Precio total: $<?php if(isset($usuario)) echo $p->getVariedades()[0]->getPrecioMayorista(); else echo $p->getVariedades()[0]->getPrecioUnidad();?></div>
			<input type="submit" class="boton" <?php if(isset($usuario)) echo 'value="Agregar al pedido"' ; else echo 'value="Iniciar Sesión"'; ?>/>
		</form> 

		<span id="texto"><b>Podés pagar en cuotas con:</b></span>
		<img id="mp" src="https://imgmp.mlstatic.com/org-img/banners/ar/medios/785X40.jpg" title="MercadoPago - Medios de pago" alt="MercadoPago - Medios de pago" width="785" height="40"/>		
	
	</div>
	
	
	<?php
		if($p->getDescripcion()!=NULL){
	?>
	
	<div id="descripcion">
		<div id="titulo">Descripción</div>
		<div id="texto"><?php echo $p->getDescripcion(); ?></div>
	</div>
	
	<?php } ?>
	
	
	
	
	
	
	
</div>
</section>
	
	
<div id="fondo"></div>
<div id="youtube_video">
	<!-- el video se agrega en el JS -->
	<iframe id="frame" width="560" height="315" src="" allowfullscreen="" style="width: 560px; height: 315px; border: 0;"></iframe>
	<div onclick="noMostrar()" id="cerrar"></div>
</div>

			
	
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>