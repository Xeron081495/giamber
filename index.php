<?php 
//libreria de clases
include_once 'lib/lib.php'; 

//lugar
$lugar = 1;

?>
<!DOCTYPE HTML> 
<html> 
<head>
<title>Giamber Lubricantes | Bahía Blanca | <?php echo getCategoriasLeyenda(); ?></title>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="js/index_slide.js" ></script>
<script type="text/javascript" src="js/index_productos.js" ></script>
<script type="text/javascript" src="js/menu_celular.js" ></script>
<script type="text/javascript">
	function mostrarInfo(i){
		$(".hover-action-"+i).delay(0).fadeIn(400);
	}
	function sacarInfo(i){
		$(".hover-action-"+i).delay(0).fadeOut(300);
	}
	function mostrarInfoMarca(i){
		$(".hover-marca-"+i).delay(0).fadeIn(400);
	}
	function sacarInfoMarca(i){
		$(".hover-marca-"+i).delay(0).fadeOut(300);
	}
</script>



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
		<div class="info" onmouseenter="mostrarInfo(1);" onmouseleave="sacarInfo(1);">
			<div class="imagen">
				<img src="img/motul_3.jpg"/>
				<h2 class="titulo">Lubricantes para Autos</h2>
				<div class="hover-action hover-action-1" >
					<h2 class="texto">Lista de precios</h2>
				</div>
			</div>
			<p class="texto">Los fabricantes de automóviles desarrollan motores cada vez más complejos al mismo tiempo que promulgan intervalos entre mantenimientos cada vez más largos. Para satisfacer las exigencias de estas evoluciones tecnológicas, MOTUL ha desarrollado una gama de lubricantes hechos a la medida de cada tipo de vehículo.</p>
		</div>
		</a>
		<a href="tienda.php?gama=<?php echo e('Moto'); ?>">
		<div class="info" onmouseenter="mostrarInfo(2);" onmouseleave="sacarInfo(2);">
			<div class="imagen">
				<img src="img/motul_1.jpg"/>
				<h2 class="titulo">Lubricantes para Motos</h2>
				<div class="hover-action hover-action-2">
					<h2 class="texto">Lista de precios</h2>
				</div>
			</div>
			<p class="texto">Las motos modernas utilizan el mismo lubricante en el motor, la caja de cambios y el embrague. Es por este motivo que los lubricantes para moto contienen un paquete específico de aditivos que optimizan el funcionamiento del motor a altas velocidades, protegen las piezas móviles de la caja de cambios y mejoran la respuesta del embrague durante el cambio de marchas</p>
		</div>
		</a>
		<!-- <a href="tienda.php?gama=<?php echo e('Comp'); ?>">
		<div class="info"  onmouseenter="mostrarInfo(3);" onmouseleave="sacarInfo(3);">
			<div class="imagen" >
				<img src="img/motul_2.jpg"/>
				<h2 class="titulo">Lubricantes para Competencia</h2>
				<div class="hover-action hover-action-3">
					<h2 class="texto">Lista de precios</h2>
				</div>
			</div>
			<p class="texto">En la competición, el objetivo es conseguir las máximas prestaciones dependiendo del motor, del tipo de carrera y de la duración de la misma. Los 6 diferentes grados de viscosidad de la Gama 300V permiten una solución precisa para cada tipo de motor y carrera, consiguiendo unos resultados óptimos.</p>
		</div>
		</a> -->
		<a href="tienda.php?categoria=SXBvbmU%3D">
		<div class="info"  onmouseenter="mostrarInfo(3);" onmouseleave="sacarInfo(3);">
			<div class="imagen" >
				<img src="img/ipone_inicio.png"/>
				<h2 class="titulo">Ipone 100% motos</h2>
				<div class="hover-action hover-action-3">
					<h2 class="texto">Lista de precios</h2>
				</div>
			</div>
			<p class="texto">IPONE nació para satisfacer las necesidades de todos, desde el uso diario hasta el ocio y la competencia para vehículos de 2 ruedas y recreativos. Los productos IPONE disfrutan de una imagen de alta calidad gracias a su calidad que los ha hecho famosos en el mercado francés e internacional.</p>
		</div>
		</a>
		</div>
	</section>
	
	<section id="info_motul">
		<div class="contenedor">
		<a href="tienda.php?gama=<?php echo e('transmisión'); ?>">
		<div class="info" onmouseenter="mostrarInfo(4);" onmouseleave="sacarInfo(4);">
			<div class="imagen">
				<img src="img/motul_4.jpg"/>
				<h2 class="titulo">Lubricantes para Transmisión</h2>
				<div class="hover-action hover-action-4" >
					<h2 class="texto">Lista de precios</h2>
				</div>
			</div>
			<p class="texto">Lubricantes de altas prestaciones diseñado para las cajas de velocidades automáticas y transmisiones automatizadas de doble embrague, del tipo DCT. Tambien para las cajas de velocidades de variación continua CVT... La transmisión es una parte fundamental en tu vehículo, obtené el mejor cuidado para que mantenga sus prestaciones. Ponele lo mejor, ponele Motul.</p>
		</div>
		</a>
		<a href="tienda.php?gama=<?php echo e('pesada'); ?>">
		<div class="info" onmouseenter="mostrarInfo(5);" onmouseleave="sacarInfo(5);">
			<div class="imagen">
				<img src="img/motul_5.jpg"/>
				<h2 class="titulo">Lubricantes para linea pesada<h2>
				<div class="hover-action hover-action-5">
					<h2 class="texto">Lista de precios</h2>
				</div>
			</div>
			<p class="texto">En comparación con los vehículos de pasajeros, los intervalos de mantenimiento en los camiones son muy elevados, la capacidad de remolque es clave, los motores son mucho más grandes, giran a velocidades inferiores y el tratamiento de los gases de escape es distinto. Por lo tanto, los camiones necesitan lubricantes de motor muy específicos.</p>
		</div>
		</a>
		<div class="info" onmouseenter="mostrarInfo(6);" onmouseleave="sacarInfo(6);">
			<iframe src="https://www.youtube.com/embed/b--yYBsE_bs?rel=0&amp;showinfo=0" width="100%" height="200em" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
			<iframe src="https://www.youtube.com/embed/EE1u8mRKr6g?rel=0&amp;showinfo=0" width="100%" height="200em" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
		</div>
	</section>
	
	<section id="marcas">
		<h1 id="titulo">GIAMBER Distribuidora Oficial</h1>
		<div class="contenedor">			
		<?php
		$categorias = getCategorias();
		$cantidad = count($categorias);
		for($j=1; $j<=$cantidad; $j++){?>

				<a href="tienda.php?categoria=<?php echo e($categorias[$j-1]->getNombre()); ?>" class="marca" style="background-image: url(<?php echo $categorias[$j-1]->getImagen(); ?>);" onmouseenter="mostrarInfoMarca(<?php echo $j; ?>);" onmouseleave="sacarInfoMarca(<?php echo $j; ?>);">
					<div class="hover-marca hover-marca-<?php echo $j; ?>">
						<h2 class="texto">Lista de precios</h2>
					</div>
				</a>
				
		<?php } ?>		
			
		</div>
	</section>

	<!--
	<section id="videos">
		<div class="contenedor">
			<iframe src="https://www.youtube.com/embed/EE1u8mRKr6g?rel=0&amp;showinfo=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
			<iframe src="https://www.youtube.com/embed/b--yYBsE_bs?rel=0&amp;showinfo=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
		</div>
	</section>
	-->

	<section id="productos">
	<div class="contenedor">
		<?php 
			$categorias = getCategorias();
			$cantidad = count($categorias);
			for($j=1; $j<=$cantidad; $j++){
		?>		
				<div class="p<?php echo $j; ?>">		
					<div id="info">
						<h1 id="titulo">Mayorista <?php echo $categorias[$j-1]->getNombre(); ?></h1>
						<div id="texto"><?php echo $categorias[$j-1]->getDescripcion(); ?></div>
						<?php if($cantidad>0){ ?>
								<a class="flechas" id="anterior_prod" onclick="anterior_prod()">&lt;</a>
								<a class="flechas" id="siguiente_prod" onclick="siguiente_prod()">&gt;</a>		   
						<?php } ?>
					</div>
					<?php 
					$productos = getProductosCategoria($categorias[$j-1]->getNombre());
					for($i=0; $i<5 && $i<count($productos); $i++){
					?>		
						<a href="prod.php?id=<?php echo e($productos[$i]->getID()); ?>" class="producto">
							<div class="imagen" style="background-image: url(productos/<?php echo $productos[$i]->getImagen(); ?>);"></div>
							<div class="titulo"><?php echo $productos[$i]->getNombre(); ?></div>
						</a>	
					<?php	
					}			
					?>
				</div>			
		<?php		
			}
		?>	
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