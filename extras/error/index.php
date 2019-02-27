<?php 
//libreria de clases
include_once 'lib/lib.php'; 

//lugar
$lugar = 1;

?>
<!DOCTYPE HTML> 
<html> 
<head>
<title>Giamber Lubricantes | Bahía Blanca | Motul, Maguiars y Sonax</title>
<meta charset="UTF-8" />

<!-- Estilos -->
<link rel="stylesheet" href="css/global.css" />
<link rel="stylesheet" href="css/index.css" />

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

</head>
<body>	
	<?php include_once 'bloques/header.php'; ?>
	
	<section id="slide">
		<a class="flecha" id="siguiente" onclick="siguiente()"></a>
		<a class="flecha" id="anterior" onclick="anterior()"></a>
	
		<img class="img" id="1" src="img/index_1.jpg" />
		<img class="img" id="2" src="img/index_0.jpg" />
		<img class="img" id="3" src="img/index_2.jpg" />
		<img class="img" id="4" src="img/index_3.jpg" />
		<img class="img" id="5" src="img/index_4.jpg" />
		<img class="img" id="6" src="img/index_5.jpg" />
		<img class="img" id="7" src="img/index_6.jpg" />
		<img class="img" id="8" src="img/index_7.jpg" />
		<img class="img" id="9" src="img/index_8.jpg" />
		<img id="fondo" src="img/index_fondo.jpg" />
	</section>
	<section id="bar-carrito">
		<div class="contenedor">
		<div id="texto">Adquirí nuestros productos en nuestra Tienda Online >></div>
		<a href="tienda.php" id="boton">Empezar a comprar</a>
		<a href="login-mayorista.php" id="boton">Iniciar Sesión</a>
		</div>
	</section>
	
	<section id="info_motul">
		<div class="contenedor">
		<a href="tienda.php?gama=<?php echo e('Auto'); ?>">
		<div class="info">
			<div class="imagen">
				<img src="img/motul_3.jpg"/>
				<h2 class="titulo">Lubricantes para Autos</h2>
			</div>
			<p class="texto">Los fabricantes de automóviles desarrollan motores cada vez más complejos al mismo tiempo que promulgan intervalos entre mantenimientos cada vez más largos. Para satisfacer las exigencias de estas evoluciones tecnológicas, MOTUL ha desarrollado una gama de lubricantes hechos a la medida de cada tipo de vehículo.</p>
		</div>
		</a>
		<a href="tienda.php?gama=<?php echo e('Moto'); ?>">
		<div class="info">
			<div class="imagen">
				<img src="img/motul_1.jpg"/>
				<h2 class="titulo">Lubricantes para Motos</h2>
			</div>
			<p class="texto">Las motos modernas utilizan el mismo lubricante en el motor, la caja de cambios y el embrague. Es por este motivo que los lubricantes para moto contienen un paquete específico de aditivos que optimizan el funcionamiento del motor a altas velocidades, protegen las piezas móviles de la caja de cambios y mejoran la respuesta del embrague durante el cambio de marchas</p>
		</div>
		</a>
		<a href="tienda.php?gama=<?php echo e('Comp'); ?>">
		<div class="info">
			<div class="imagen">
				<img src="img/motul_2.jpg"/>
				<h2 class="titulo">Lubricantes para Competencia</h2>
			</div>
			<p class="texto">En la competición, el objetivo es conseguir las máximas prestaciones dependiendo del motor, del tipo de carrera y de la duración de la misma. Los 6 diferentes grados de viscosidad de la Gama 300V permiten una solución precisa para cada tipo de motor y carrera, consiguiendo unos resultados óptimos.</p>
		</div>
		</a>
		</div>
	</section>
	
	<section id="videos">
		<div class="contenedor">
			<iframe src="https://www.youtube.com/embed/EE1u8mRKr6g?rel=0&amp;showinfo=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
			<iframe src="https://www.youtube.com/embed/b--yYBsE_bs?rel=0&amp;showinfo=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>	
		</div>
	</section>
	
	
	<section id="marcas">
		<h1 id="titulo">Giamber Distribuidora Oficial</h1>
		<div class="contenedor cont_marcas">
			<a href="tienda.php?categoria=TWVndWlhcnM%3D" onclick="mostrar_prod(2)" class="marca meguiars"></a>
			<a href="tienda.php?categoria=TW90dWw%3D" onclick="mostrar_prod(1)" class="marca motul"></a></a>
			<a href="tienda.php?categoria=U29uYXg%3D" onclick="mostrar_prod(3)" class="marca sonax"></a></a>
		</div>
	</section>
	
	<section id="productos">
		<div class="contenedor">
		<div class="p1">		
			<div id="info">
			   <div id="titulo">Productos Motul</div>
			   <div id="texto">Los mejores lubricantes del mercado para autos, motos y competencia de la mano de tu distribuidora Giamber Lubricantes.</div>
			   <a class="flechas" id="anterior_prod" onclick="anterior_prod()">&lt;</a>
			   <a class="flechas" id="siguiente_prod" onclick="siguiente_prod()">&gt;</a>		   
			</div>
			<?php 
				$productos = getProductosCategoria('Motul');
				for($i=0; $i<5 && $i<count($productos); $i++){
			?>		
					<a href="prod.php?id=<?php echo e($productos[$i]->getID()); ?>" class="producto">
						<div class="imagen" style="background-image: url(productos/<?php echo $productos[$i]->getImagen(); ?>);">
							<!--<img src="productos/<?php echo $productos[$i]->getImagen(); ?>" />-->
						</div>
						<div class="titulo"><?php echo $productos[$i]->getNombre(); ?></div>
					</a>	
			<?php	
				}			
			?>
		</div>
		<div class="p2">		
			<div id="info">
				<div id="titulo">Productos Meguiars</div>
				<div id="texto">Líneas Premium para fanáticos de la estética vehicular.</div>
				<a class="flechas" id="anterior_prod" onclick="anterior_prod()">&lt;</a>
				<a class="flechas" id="siguiente_prod" onclick="siguiente_prod()">&gt;</a>	
			</div>
			<?php 
				$productos = getProductosCategoria('Meguiars');
				for($i=0; $i<5 && $i<count($productos); $i++){
			?>		
					<a href="prod.php?id=<?php echo e($productos[$i]->getID()); ?>" class="producto">
						<div class="imagen">
							<img src="productos/<?php echo $productos[$i]->getImagen(); ?>" />
						</div>
						<div class="titulo"><?php echo $productos[$i]->getNombre(); ?></div>
					</a>	
			<?php	
				}			
			?>			
		</div>
		
		<div class="p3">		
			<div id="info">
			   <div id="titulo">Productos Sonax</div>
			   <div id="texto">Los mejores productos para el cuidado del automóvil provienen de SONAX. Esto se desprende de las votaciones de los lectores.</div>
			   <a class="flechas" id="anterior_prod" onclick="anterior_prod()">&lt;</a>
			   <a class="flechas" id="siguiente_prod" onclick="siguiente_prod()">&gt;</a>			   
			</div>
			<?php 
				$productos = getProductosCategoria('Sonax');
				for($i=0; $i<5 && $i<count($productos); $i++){
			?>		
					<a href="prod.php?id=<?php echo e($productos[$i]->getID()); ?>" class="producto">
						<div class="imagen">
							<img src="productos/<?php echo $productos[$i]->getImagen(); ?>" />
						</div>
						<div class="titulo"><?php echo $productos[$i]->getNombre(); ?></div>
					</a>	
			<?php	
				}			
			?>		
		</div>
		</div>
	</section>	
	<section id="datos">
		<div id="capa">
			<div class="contenedor">
			<div class="fondo" id="envios"></div>
			<div class="fondo" id="pagos"></div>
			<div class="fondo" id="calidad"></div>
			<div class="fondo" id="asesoramiento"></div>	
			<h3 class="texto">Envios</h3>
			<h3 class="texto">Mercado Pago</h3>
			<h3 class="texto">Calidad</h3>
			<h3 class="texto">Asesoramiento</h3>		
			</div>
		</div>
	</section>
	
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>