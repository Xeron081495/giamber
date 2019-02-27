<?php 
//libreria de clases
include_once 'lib/lib.php'; 

//lugar
$lugar = 2;

?>
<!DOCTYPE HTML> 
<html> 
<head>
<title>Nosotros | Giamber Lubricantes | Bahía Blanca | <?php echo getCategoriasLeyenda(); ?></title>
<meta charset="UTF-8" />

<!-- Estilos -->
<link rel="stylesheet" href="css/global.css" />
<link rel="stylesheet" href="css/nosotros.css" />

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
<script type="text/javascript" src="js/index_slide.js"></script>
<script type="text/javascript" src="js/index_productos.js"></script>
    <script type="text/javascript" src="js/menu_celular.js"></script>
    <script type="text/javascript">
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
<section id="intro">
<div class="contenedor">
    <h1 id="titulo">La empresa</h1>

    <p>Lubricantes GIAMBER junto con su principal aliado comercial MOTUL, acerca a nuestros clientes productos que incorporan tecnologías probadas y validadas en las condiciones más extremas, impuestas por los fabricantes de motores y las industrias más exigentes.
    </br></br>
    Nuestra misión es ser un referente en la distribución de lubricantes, por ese motivo trabajamos día a día para  mejorar nuestro servicio y que nuestros clientes encuentren en GIAMBER un socio aliado.</p>

    <h1 id="titulo">Primeras lineas a nivel mundial</h1>

    <div class="contenedor cont_marcas">
        
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

</div>
</section>
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>