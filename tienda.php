<?php 
//libreria de clases
include_once 'lib/lib.php'; 

//lugar

$lugar = 3;

$mostrar = true;

//productos
if(isset($_GET['ofertas'])){
	$productos = getProductosOferta();
	$lugar = 10;
}elseif(isset($_GET['busqueda'])){
	$productos = getProductosAvanzada($_GET['busqueda']);
}elseif(isset($_GET['gama'])){
	$productos = getProductosGama(d($_GET['gama']));
}elseif(isset($_GET['categoria'])){
	$productos = getProductosCategoria(d($_GET['categoria']));
}else{
	$mostrar = false;
}

//usuario
if(isset($_SESSION['login'])){
	$usuario = new Usuario($_SESSION['correo']);
	$pedido = $usuario->getPedido(); 	
}

if(isset($_GET['vista'])){
	$_SESSION['vista'] = $_GET['vista'];	
}




?>
<!DOCTYPE HTML> 
<html> 
<head>
<title>Tienda Online de Giamber Lubricantes | Bahía Blanca | <?php echo getCategoriasLeyenda(); ?></title>
<meta charset="UTF-8" />

<!-- Estilos -->
<link rel="stylesheet" href="css/global.css" />
<link rel="stylesheet" href="css/nosotros.css" />
<link rel="stylesheet" href="css/tienda.css" />

<!-- Icono -->
<link rel="shortcut icon" href="img/icono.png" />

<!-- Celular -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- Fuentes -->
<link href="https://fonts.googleapis.com/css?family=Montserrat|Satisfy|Raleway:400,700" rel="stylesheet">

<!-- Descripción del sitio -->
<meta name="description" content="Distribuidora de lubricantes para Bahía Blanca y la zona." />

<!-- Cambia de imagenes slider -->
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type="text/javascript" src="js/index_slide.js" /></script>
<script type="text/javascript" src="js/index_productos.js" /></script>
<script type="text/javascript" src="js/menu_celular.js" /></script>
<script type="text/javascript">

function hover(i){
	$('.t'+i).css({'color': 'red'});
	$('.i'+i).css({'background-size': '95% auto'});
	$('.i'+i).css({'-webkit-transition': 'all 0.3s linear'});
	$('.i'+i).css({'-moz-transition': 'all 0.3s linear'});
	$('.i'+i).css({'-o-transition': 'all 0.3s linear'});
	$('.i'+i).css({'transition': 'all 0.3s linear'});
	$('.m'+i).css({'background-size': 'auto 100%'});
	$('.form-carrito-'+i).css({'display':'inline-block'});
}

function noHover(i){
	$('.t'+i).css({'color': '#222'});
	$('.i'+i).css({'background-size': '80% auto'});
	$('.i'+i).css({'-webkit-transition': 'all 0.3s linear'});
	$('.i'+i).css({'-moz-transition': 'all 0.3s linear'});
	$('.i'+i).css({'-o-transition': 'all 0.3s linear'});
	$('.i'+i).css({'transition': 'all 0.3s linear'});
	$('.m'+i).css({'background-size': 'auto 95%'});
	$('.form-carrito-'+i).css({'display':'none'});
}

function vista_comun(){
	$('section#productos').css({'display': 'inline-block'});
	$('section#vista-reducida').css({'display': 'none'});	
}
function vista_linea(){
	$('section#productos').css({'display': 'none'});
	$('section#vista-reducida').css({'display': 'inline-block'});	
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

function mostrarInfoMarca(i){
	$(".hover-marca-"+i).delay(0).fadeIn(400);
}
function sacarInfoMarca(i){
	$(".hover-marca-"+i).delay(0).fadeOut(300);
}

function mostrarInfo(i){
	$(".hover-action-"+i).delay(0).fadeIn(400);
}
function sacarInfo(i){
	$(".hover-action-"+i).delay(0).fadeOut(300);
}

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
		<?php
			if(isset($_GET['gama'])){
				echo '<h1 id="titulo">Productos para '.d($_GET['gama']).'</h1>';
			}elseif(isset($_GET['categoria'])){
				echo'<h1 id="titulo">Productos de '.d($_GET['categoria']).'</h1>';			
			}else{
				echo'<h1 id="titulo">Tienda Giamber Lubricantes</h1>';
			}
		
		
		?>
		<?php if(!isset($usuario)){ ?>
			<h4 id="subtitulo">En la sección 'Acceso mayorista', que se encuentra en la parte superior sobre el lado derecho, podrá registrarse o iniciar sesión para armar pedidos y ver los precios. ¡Te esperamos!</h4>
		<?php }else{ ?>
			<h4 id="subtitulo">Hacé clic en el producto, elegí la cantidad y agregalo a tu pedido. Podrás ver el precio en la parte superior derecha.</h4>
		<?php } ?>
	</div>
	<div id="cont">
		<a <?php if(isset($pedido) && count($pedido->getArticulos())>0) echo 'title="Ver pedido"'; ?> <?php if(isset($pedido) && count($pedido->getArticulos())>0) echo 'href="carrito.php"'; ?> id="pedido">Seleccionó <?php if(isset($pedido)) echo count($pedido->getArticulos()); else echo '0'; ?> artículo(s): $<?php if(isset($pedido)) echo number_format($pedido->getPrecioTotal(),2); else echo ' 0'; ?></a>
		<a <?php if(isset($pedido)) echo 'href="carrito.php"'; ?> id="pago"><?php if(isset($pedido)) echo 'Ver/Finalizar pedido'; ?></a>
	</div>
</div>
</section>

<?php
if(!$mostrar){
	$categorias = getCategorias();
	$cantidad = count($categorias);
?>	
	<section id="intro">
<?php for($j=1; $j<=$cantidad; $j++){?>

			<a href="tienda.php?categoria=<?php echo e($categorias[$j-1]->getNombre()); ?>" class="marca" style="background-image: url(<?php echo $categorias[$j-1]->getImagen(); ?>);" onmouseenter="mostrarInfoMarca(<?php echo $j; ?>);" onmouseleave="sacarInfoMarca(<?php echo $j; ?>);">
				<div class="hover-marca hover-marca-<?php echo $j; ?>">
					<h2 class="texto">Lista de precios</h2>
				</div>
			</a>
			
	<?php } ?>		
			
	</section>

	<?php
}else{
	?>
	<!--- HAY productos elegidos apra mostrar --->
	<section id="productos">
		<div class="contenedor">
			<?php 
				//no hay productos
				if(count($productos)==0){
					echo '<div class="no-hay-prod">Categoría en construcción. Próximamente encontrarás todo nuestro catálogo de '.d($_GET['categoria']).'.</div>';
				}
			
			?>
			
			
			
			<?php $i=0; foreach($productos as $p){				
				foreach($p->getVariedades() as $v){
				if($i%4==0) echo '<div class="fila">';

				?>
					<article class="producto"  onmouseover="hover(<?php echo $i; ?>)" onmouseleave="noHover(<?php echo $i; ?>)" >
						<a href="prod.php?id=<?php echo e($p->getID()); ?>">
						<div class="imagen i<?php echo $i; ?>" style="background-image: url(productos/<?php echo $p->getImagen(); ?>);" onmouseenter="mostrarInfo(<?php echo $i; ?>);" onmouseleave="sacarInfo(<?php echo $i; ?>);">
							<?php if( $p->tieneOferta()){?>
								<div class="oferta"><?php echo $p->getMayorOferta(); ?>% Off</div>
							<?php } ?>								
							<div class="hover-action hover-action-<?php echo $i; ?>">
								<h2 class="texto">Abrir producto</h2>
							</div>
						</div>
						</a>
						
						<div class="titulo t<?php echo $i; ?>"><?php echo $p->getNombre(); ?></div>
											
						<?php if($p->getAplicacion()!=NULL){ ?>
						<div class="dato">
							<b>- Aplicación: </b>
							<span><?php echo $p->getAplicacion(); ?></span>
						</div>
						<?php } ?>
						
						<?php if($p->getGama()!=NULL){ ?>
						<div class="dato">
							<b>- Gama: </b>
							<span><?php echo $p->getGama(); ?></span>
						</div>
						<?php } ?>
						
						<?php if($p->getTipo()!=NULL){ ?>
						<div class="dato">
							<b>- Tipo: </b>
							<span><?php echo $p->getTipo(); ?></span>
						</div>
						<?php } ?>
						
						<?php if($v->getEnvase()!=NULL){ ?>
						<div class="dato">
							<b>- Envase: </b>
							<span><?php echo $v->getEnvase(); ?></span>
						</div>
						<?php } ?>
										
						
						<?php if(isset($usuario)){ ?>
							<div class="precio">$ <?php echo $p->getVariedades()[0]->getPrecioMayoristaNeto(); ?></div>
						<?php }else{ ?>
							<div class="precio">Consultar</div>
						<?php }?>						
						
						<div class="marca m<?php echo $i; ?>" style="background-image: url(<?php echo $p->getCategoria()->getImagen(); ?>);"></div>
												
						<form action="carrito.php" method="post" class="form-carrito-<?php echo $i; ?>" id="carrito">
							<input id="cantidad_carrito" name="cantidad" type="number" class="cantidad" step="<?php echo $v->getCantidadMayorista(); ?>" min="<?php echo $v->getCantidadMayorista(); ?>" value="<?php echo $v->getCantidadMayorista(); ?>" />
							<input id="variedad_carrito" name="variedad" type="hidden" value="<?php echo $v->getID(); ?>" class="cantidad">
							<input type="submit" class="boton" value="Agregar al pedido" />
						</form>		
					</article>
				<?php
				$i++;
				if($i%4==0) echo '</div>';
			} }?>
		</div>
	</section>

	<section id="vista-reducida">
		<div class="contenedor">
			<article class="producto">
				<div class="titulo-vista" style="width: 10%;">Imagen</div>
				<div class="titulo-vista" style="width: 32%;">Producto</div>
				<?php /* if(isset($usuario)){ ?>
					<div class="titulo-vista" style="width: 10%;">Lista</div>
				<?php } */ ?>
				<?php if(isset($usuario)){ ?>
					<div class="titulo-vista" style="width: 10%;">Compra</div>
				<?php } ?>
				<div class="titulo-vista" style="width: 7%;">Marca</div>
				<div class="titulo-vista" style="width: 20%;">Carrito</div>
				<div class="titulo-vista" style="width: 7%;">Descripción</div>
			</article>

			<?php $i=0; foreach($productos as $p){
				foreach($p->getVariedades() as $v){

					?>
					<article class="producto">
						<a onmouseover="hover(<?php echo $i; ?>)" onmouseleave="noHover(<?php echo $i; ?>)" href="prod.php?id=<?php echo e($p->getID()); ?>">
							<div class="imagen i<?php echo $i; ?>" style="background-image: url(productos/<?php echo $p->getImagen(); ?>);"></div>
							<div class="titulo t<?php echo $i; ?>">
								<div class="texto"><?php echo $p->getNombre(); ?> de <?php echo $v->getEnvase(); ?></div>
								<?php if( $v->tieneOferta()){?>
									<div class="oferta"><?php echo $v->getOferta(); ?>% Off</div>
								<?php } ?>
							</div>
							<?php /*if(isset($usuario)){ ?>
								<div class="precio">$ <?php echo $v->getPrecioNeto(); ?></div>
							<?php } */?>
							<?php if(isset($usuario)){ ?>
								<div class="precio">$ <?php echo $v->getPrecioMayoristaNeto(); ?></div>
							<?php } ?>
							<div class="marca m<?php echo $i; ?>" style="background-image: url(<?php echo $p->getCategoria()->getImagen(); ?>);"></div>
						</a>
						<form action="carrito.php" method="post" class="form-carrito" id="carrito">
							<input id="cantidad_carrito" name="cantidad" type="number" class="cantidad" step="<?php echo $v->getCantidadMayorista(); ?>" min="<?php echo $v->getCantidadMayorista(); ?>" value="<?php echo $v->getCantidadMayorista(); ?>" />
							<input id="variedad_carrito" name="variedad" type="hidden" value="<?php echo $v->getID(); ?>" class="cantidad">
							<input type="submit" class="boton" value="Agregar al pedido" />
						</form>
						<a class="ver-mas" onmouseover="hover(<?php echo $i; ?>)" onmouseleave="noHover(<?php echo $i; ?>)" href="prod.php?id=<?php echo e($p->getID()); ?>">Ver info.</a>

					</article>
					<?php $i++; } }?>
		</div>
	</section>
	<?php
}
?>



<a href="#"><img class="volver" src="img/volver.jpg" /> 	</a>
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>