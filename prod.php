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

		$conectado = true;

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
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type="text/javascript" src="js/index_slide.js" ></script>
<script type="text/javascript" src="js/index_productos.js" ></script>
<script type="text/javascript" src="js/menu_celular.js" ></script>
<script type="text/javascript">

//guardo los datos de todas las variedades
var precio_may_neto = [];
var precio_neto = [];
var precio_may_bruto = [];
var precio_bruto = [];
var step = []; // cantidad del mayorista
var variedad = []; // id de variedades
var stock = []; // stock del producto
var variedad_actual = 0; //predeterminada es la opcion 1

//inicicializamos los arreglos
<?php
	for($i=0; $i<count($p->getVariedades());$i++){ ?>
		precio_may_neto.push(<?php echo $p->getVariedades()[$i]->getPrecioMayoristaNeto(); ?>);
		precio_neto.push(<?php echo $p->getVariedades()[$i]->getPrecioNeto(); ?>);
		precio_may_bruto.push(<?php echo $p->getVariedades()[$i]->getPrecioMayoristaBruto(); ?>);
		precio_bruto.push(<?php echo $p->getVariedades()[$i]->getPrecioBruto(); ?>);
		stock.push(<?php echo $p->getVariedades()[$i]->getStock(); ?>);
		step.push(<?php echo $p->getVariedades()[$i]->getCantidadMayorista(); ?>);
		variedad.push(<?php echo $p->getVariedades()[$i]->getID(); ?>);
<?php
	}
?>


// modifica todo lo que corresponda al cambiar de tipo de envase
function cambiarVariedad(i) {
	//pongo el precio actual de la variedad
	variedad_actual = i;

	//cambiar color de los botones de envase
	cambiarColorBotonEnvase(i);

	//cambio los precios
	$(".precio").html('$'+precio_may_bruto[variedad_actual].toFixed(2));
	$('#cantidad_carrito').attr('max',stock[variedad_actual]);
	$('#variedad_carrito').val(''+variedad[variedad_actual]);
	$('#precio-mayorista-neto').html('$'+precio_may_neto[variedad_actual].toFixed(2));
	$('#precio-mayorista-bruto').html('$'+precio_may_bruto[variedad_actual].toFixed(2));

}



//MOSTRAR OCULTAR VIDEO DE YOUTUBE
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


// Mostrar/ocultar menu de busqueda
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



//auxiliares
function cambiarColorBotonEnvase(i){
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



<?php 
	for($i=0;$i<count($p->getImagenes()); $i++){ ?>
		function cambiarImagen<?php echo $i; ?>(){
			$("#imagen").css({'background-image': 'url(productos/<?php echo $p->getImagenes()[$i]->getNombre(); ?>)'});
		}<?php
	}
?>



</script>

</head>
<body>	
<?php include_once 'bloques/header.php'; ?>	

<!-- CAJA DE BUSQUEDA Y POR MARCAS -->

<section id="busqueda">
<div class="contenedor">
	<form action="tienda.php" method="get">
		<input name="busqueda" <?php if(isset($_GET['busqueda'])) echo 'value="'.$_GET['busqueda'].'"'; ?> type="text" title="Ingrese palabras separadas por espacio y no por simbolos. Por ejemplo: motul 5w40 auto" placeholder="Ingrese palabras separadas por espacio y no por simbolos" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.-_'0123456789]{2,48}" required />
		<input id="boton" type="submit" value="Buscar" required />
	</form>
	<div onClick="mostrarAvanzadas()" id="menu-avanzado">Mostrar menú de búsqueda</div>


	<div class="lubricantes opciones-busqueda visible" >
		<a class="tipo descarga" <?php if(isset($_SESSION['login'])){ echo 'href="pdf.php" download=""'; }else { echo 'href="login-mayorista.php?t='.e('No está logueado para descargar la lista de precios').'"'; } ?> >Descargar lista de productos</a>
	</div>
	
	
	<!--<section id="marcas" class="opciones-busqueda">
		<div id="titulo">Marcas:</div>
		<?php 
			foreach(getCategorias() as $categoria){
				echo '<a href="tienda.php?categoria='.e($categoria->getNombre()).'" class="marca '.$categoria->getNombre().'" onclick="mostrar_cat('.$categoria->getNombre().')" style="background-image: url('.$categoria->getImagen().');" ></a>';
			}
		?>
	
	</section>-->
	
</div>
</section>
<section id="carrito">
<div class="contenedor">
	<div id="texto">
		<h1 id="titulo">Tienda Giamber Lubricantes</h1>
		<?php if(!isset($usuario)){ ?>
			<h4 id="subtitulo">En la sección 'Acceso mayorista', que se encuentra en la parte superior sobre el lado derecho, podrá registrarse o iniciar sesión para armar pedidos y ver los precios. ¡Te esperamos!</h4>
		<?php }else{ ?>
			<h4 id="subtitulo">Elegí el tipo de envase, la cantidad y agregalo a tu pedido. Podrás ver el precio parcial de tu pedido en la parte superior derecha.</h4>
		<?php } ?>
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
		<div id="miniaturas">
			<?php 
			for($i=0;$i<count($p->getImagenes()); $i++){
				echo '<div onclick="cambiarImagen'.$i.'();" id="img'.($i+1).'" class="imagen" style="background-image:url(productos/'.$p->getImagenes()[$i]->getNombre().'"></div>';
				
			}
			?>
		</div>		
	</div>
	<div id="info">
		<!-- MARCA -->
		<div id="marca">Marca:</div><img id="imagen_marca" src="<?php echo $p->getCategoria()->getImagen(); ?>" />

		<!-- TITULO -->
		<h1 id="titulo"><?php echo $p->getNombre(); ?></h1>

		<!-- PRECIO SUGERIDO NETO (CON DESCUENTO) -->
		<?php if(isset($usuario)){?>
			<div class="precio">$ <?php echo formatoPrecio($p->getVariedades()[0]->getPrecioMayoristaNeto()); ?></div>
		<?php } ?>

		<!-- STOCK -->
		<?php if(isset($usuario)){?>
			<div class="stock">precio mayorista</div>
		<?php } ?>

		<!-- ENVASES -->
		<div class="dato">
			<div class="titulo">Elegir envase:</div>
			<div class="texto">
				<?php
					$i = 0;
					foreach($p->getVariedades() as $variedad){
						?>
						<a target="_blanck" id="e<?php echo $i; ?>" onclick="cambiarVariedad(<?php echo $i; ?>)" class="texto ficha">
							<div class="texto"><?php echo $variedad->getEnvase(); ?></div>
							<?php
								if($variedad->tieneOferta()){
									echo '<div class="oferta">'.$variedad->getOferta().'% off</div>';
								}
							?>
						</a>
						<?php
						$i++;
					}
				?>
			</div>
		</div>


		<!-- PRECIO MAYORISTA BRUTO -->
		<?php /*
		if(isset($usuario)){
			echo '<div class="dato">
					<div class="titulo">Precio mayorista:</div>
					<div class="texto" id="precio-mayorista-bruto">$'.$p->getVariedades()[0]->getPrecioMayoristaBruto().'</div>
				</div>';
		}*/
		?>

		<!-- PRECIO MAYORISTA BRUTO SIN OFERTA -->
		<?php
			if(isset($conectado) && $p->getVariedades()[0]->tieneOferta()){
				echo '<div class="dato">
					<div class="titulo">Sin descuento:</div>
					<div class="texto" id="precio-mayorista-neto">$'.$p->getVariedades()[0]->getPrecioMayoristaBruto().'</div>
				</div>';
			}
		?>



		<!-- APLICACION -->
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
						<div class="titulo">Homologación:</div>
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
						<div class="texto">'.$p->getVariedades()[0]->estadoStock().'</div>
					</div>';
		?>
		<div class="dato">
			<div class="titulo">Agregar al carrito:</div>
			<div class="texto"></div>
		</div>
		<form action="carrito.php" method="post" class="form-carrito" id="carrito">
			<div id="cantidad">Elegí la cantidad: </div>
			<input id="cantidad_carrito" name="cantidad" type="number" hmax="<?php echo $p->getVariedades()[0]->getStock(); ?>" class="cantidad" <?php if(isset($usuario) && $usuario->getStep()) echo 'step="'.$p->getVariedades()[0]->getCantidadMayorista().'" min="'.$p->getVariedades()[0]->getCantidadMayorista().'" value="'.$p->getVariedades()[0]->getCantidadMayorista().'"'; else echo 'value="1" min="1"'; ?>/>
			<input id="variedad_carrito" name="variedad" type="hidden" value="<?php echo $p->getVariedades()[0]->getID(); ?>" />
			<input type="submit" class="boton" <?php if(isset($usuario)) echo 'value="Agregar al pedido"' ; else echo 'value="Iniciar Sesión para hacer pedidos"'; ?>/>
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


<section id="productos">
	<div class="contenedor">
		<div id="titulo">Otros productos</div>

		<?php $i=0; foreach(getProductosRelacionados(10) as $p){
			?>
			<a onmouseover="hover(<?php echo $i; ?>)" onmouseleave="noHover(<?php echo $i; ?>)" href="prod.php?id=<?php echo e($p->getID()); ?>">
				<article class="producto">
					<div class="imagen i<?php echo $i; ?>" style="background-image: url(productos/<?php echo $p->getImagen(); ?>);">
						<?php if( $p->tieneOferta()){?>
							<div class="oferta"><?php echo $p->getMayorOferta(); ?>% Off</div>
						<?php } ?>
					</div>
					<div class="titulo t<?php echo $i; ?>"><?php echo $p->getNombre(); ?></div>
					<?php if(isset($usuario)){ ?>
						<div class="precio">$ <?php echo $p->getVariedades()[0]->getPrecioMayoristaNeto(); ?></div>
					<?php }else{ ?>
						<div class="precio">Consultar</div>
					<?php }?>
					<div class="marca m<?php echo $i; ?>" style="background-image: url(<?php echo $p->getCategoria()->getImagen(); ?>);"></div>
				</article>
			</a>
			<?php $i++; } ?>
	</div>
</section>


			
	
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>