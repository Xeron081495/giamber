<?php 
//libreria de clases
include_once 'lib/lib.php'; 

//lugar
$lugar = 3;

//productos
if(isset($_GET['categoria'])){
	$productos = getProductosCategoria(d($_GET['categoria']));
}elseif(isset($_GET['busqueda'])){
	$productos = getProductosBusqueda($_GET['busqueda']);
}elseif(isset($_GET['gama'])){
	$productos = getProductosGama(d($_GET['gama']));
}else{
	$productos = getProductos();
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
<title>Tienda Online de Giamber Lubricantes | Bahía Blanca | Motul, Maguiars y Sonax</title>
<meta charset="UTF-8" />

<!-- Estilos -->
<link rel="stylesheet" href="css/global.css" />
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
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
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
}

function noHover(i){
	$('.t'+i).css({'color': '#222'});
	$('.i'+i).css({'background-size': '80% auto'});
	$('.i'+i).css({'-webkit-transition': 'all 0.3s linear'});
	$('.i'+i).css({'-moz-transition': 'all 0.3s linear'});
	$('.i'+i).css({'-o-transition': 'all 0.3s linear'});
	$('.i'+i).css({'transition': 'all 0.3s linear'});
	$('.m'+i).css({'background-size': 'auto 95%'});
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


</script>
</head>
<body>	
<?php include_once 'bloques/header.php'; ?>	
<section id="busqueda">
<div class="contenedor">
	<form action="tienda.php" method="get">
		<input name="busqueda" <?php if(isset($_GET['busqueda'])) echo 'value="'.$_GET['busqueda'].'"'; ?> type="text" placeholder="Ingrese el nombre del producto" required />
		<input id="boton" type="submit" value="Buscar" required />
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
<section id="busqueda">
<div class="contenedor">
	<section id="marcas" class="opciones-busqueda">
		<div id="titulo">Búsqueda por lubricante:</div>
		<a href="tienda.php?gama=<?php echo e('Moto'); ?>" class="marca lubri" onclick="mostrar_cat('.$categoria->getNombre().')" style="background-image: url('.$categoria->getImagen().');" >Motos</a>
		<a href="tienda.php?gama=<?php echo e('Auto'); ?>" class="marca lubri" onclick="mostrar_cat('.$categoria->getNombre().')" style="background-image: url('.$categoria->getImagen().');" >Autos</a>
		<a href="tienda.php?gama=<?php echo e('Comp'); ?>" class="marca lubri" onclick="mostrar_cat('.$categoria->getNombre().')" style="background-image: url('.$categoria->getImagen().');" >Competición</a>
	
	</section>
	
	<section id="marcas" class="formato-busqueda">
		<div id="titulo">Formato de busqueda:</div>
		<a class="marca" onclick="vista_comun()" style="background-image: url('img/vista-comun.jpg');" ></a>
		<a class="marca" onclick="vista_linea()" style="background-image: url('img/vista-linea.jpg');" ></a>
	
	</section>
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
		<h4 id="subtitulo">Hacé clic en el producto, elegí la cantidad y agregalo a tu pedido. Podrás ver el precio en la parte superior derecha.</h4>
	</div>
	<div id="cont">
		<a <?php if(isset($pedido) && count($pedido->getArticulos())>0) echo 'href="carrito.php"'; ?> id="pedido">Seleccionó <?php if(isset($pedido)) echo count($pedido->getArticulos()); else echo '0'; ?> artículo(s): $<?php if(isset($pedido)) echo number_format($pedido->getPrecioTotal(),2); else echo ' 0'; ?></a>
		<a <?php if(isset($pedido)) echo 'href="carrito.php"'; ?> id="pago"><?php if(isset($pedido)) echo 'Finalizar pedido'; ?></a>
	</div>
</div>
</section>

<section id="productos">
<div class="contenedor">
	<?php $i=0; foreach($productos as $p){
	?>
	<a onmouseover="hover(<?php echo $i; ?>)" onmouseleave="noHover(<?php echo $i; ?>)" href="prod.php?id=<?php echo e($p->getID()); ?>">
	<article class="producto">
		<div class="imagen i<?php echo $i; ?>" style="background-image: url(productos/<?php echo $p->getImagen(); ?>);"></div>
		<div class="titulo t<?php echo $i; ?>"><?php echo $p->getNombre(); ?></div>
		<div class="precio">$ <?php echo $p->getVariedades()[0]->getPrecioUnidad(); ?></div>
		<div class="marca m<?php echo $i; ?>" style="background-image: url(<?php echo $p->getCategoria()->getImagen(); ?>);"></div>
	</article>
	</a>
	<?php $i++; } ?>
</div>
</section>

<section id="vista-reducida">
<div class="contenedor">
	<article class="producto">
		<div class="titulo-vista" style="width: 10%;">Imagen</div>
		<div class="titulo-vista" style="width: 30%;">Producto</div>
		<div class="titulo-vista" style="width: 10%;">Lista</div>
		<?php if(isset($usuario)){ ?>
			<div class="titulo-vista" style="width: 10%;">Compra</div>
		<?php } ?>
		<div class="titulo-vista" style="width: 7%;">Marca</div>	
		<div class="titulo-vista" style="width: 22%;">Carrito</div>	
		<div class="titulo-vista" style="width: 7%;">Descripción</div>	
	</article>


	<?php $i=0; foreach($productos as $p){
	?>
	<article class="producto">
		<a onmouseover="hover(<?php echo $i; ?>)" onmouseleave="noHover(<?php echo $i; ?>)" href="prod.php?id=<?php echo e($p->getID()); ?>">
		<div class="imagen i<?php echo $i; ?>" style="background-image: url(productos/<?php echo $p->getImagen(); ?>);"></div>
		<div class="titulo t<?php echo $i; ?>"><?php echo $p->getNombre(); ?></div>
		<div class="precio">$ <?php echo $p->getVariedades()[0]->getPrecioUnidad(); ?></div>		
		<?php if(isset($usuario)){ ?>
		<div class="precio">$ <?php echo $p->getVariedades()[0]->getPrecioMayorista(); ?></div>
		<?php } ?>
		<div class="marca m<?php echo $i; ?>" style="background-image: url(<?php echo $p->getCategoria()->getImagen(); ?>);"></div>	
		</a>
		<form action="carrito.php" method="post" class="form-carrito" id="carrito">
			<input id="cantidad_carrito" name="cantidad" type="number" class="cantidad" step="<?php echo $p->getVariedades()[0]->getCantidadMayorista(); ?>" min="<?php echo $p->getVariedades()[0]->getCantidadMayorista(); ?>" value="<?php echo $p->getVariedades()[0]->getCantidadMayorista(); ?>" />
			<select id="variedad_carrito" name="variedad" type="text" class="cantidad">
				<?php foreach($p->getVariedades()as $v){ ?>
						<option value="<?php echo $v->getID(); ?>"><?php echo $v->getEnvase(); ?></option>
				<?php } ?>
			<input type="submit" class="boton" value="Agregar al pedido" />
		</form>
		<a class="ver-mas" onmouseover="hover(<?php echo $i; ?>)" onmouseleave="noHover(<?php echo $i; ?>)" href="prod.php?id=<?php echo e($p->getID()); ?>">Ver más</a>
	
	</article>
	<?php $i++; } ?>
</div>
</section>

<a href="#"><img class="volver" src="img/volver.jpg" /> 	</a>
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>