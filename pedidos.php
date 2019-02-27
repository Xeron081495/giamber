<?php 
//libreria de clases
include_once 'lib/lib.php'; 

//lugar
$lugar = 0;

if(isset($_SESSION['login'])){
	try{
		$usuario = new Mayorista($_SESSION['correo']);	
	}catch(ExceptionExiste $e){
		$usuario = new Usuario($_SESSION['correo']);		
	}	
	$pedidos = $usuario->getPedidos();
	

}else{	
	echo '<meta http-equiv="refresh" content="0; url=login-mayorista.php?t='.e('No está logueado para ver y/o modificar su pedido').''.$parametros.'">';
	exit;
}
?>
<!DOCTYPE HTML> 
<html> 
<head>
<title>Pedidos | Giamber Lubricantes | Bahía Blanca | <?php echo getCategoriasLeyenda(); ?></title>
<meta charset="UTF-8" />

<!-- Estilos -->
<link rel="stylesheet" href="css/global.css" />
<link rel="stylesheet" href="css/pedidos.css" />

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
<script type="text/javascript" src="js/index_slide.js"></script>
<script type="text/javascript" src="js/index_productos.js"></script>
<script type="text/javascript" src="js/menu_celular.js"></script>
<script type="text/javascript">
var abierto = -1;
function mostrarVariedad(i){
	if(abierto==i){
		$('.v-'+abierto+'').css({'display': 'none'});
		abierto = -1;		
	}else{	
		$('.v-'+abierto+'').css({'display': 'none'});	
		$('.v-'+i+'').css({'display': 'inline-block'});
		abierto = i;
	}
}
</script>

</head>
<body>	
<?php include_once 'bloques/header.php'; ?>	
<section id="pedidos">
<div class="contenedor">
	<h2 id="titulo">Mis pedidos</h2>
	<?php
	$i = 0;
	foreach($pedidos as $p){
		if($p->estaConfirmado())
			$confirmado = 'Confirmado';
		else
			$confirmado = 'Sin confirmar';

		if($p->estaPagado())
			$pago = 'Pagado';
		else
			$pago = 'Sin pagar';

		if($p->estaEntregado())
			$entrega = 'Entregado';
		else
			$entrega = 'Sin entregar';


	?>
	<div class="pedido">
		<div class="titulo">#<?php echo $p->getID(); ?>- Fecha: <?php echo $p->getFechaHora(); ?></div>
		<div class="datos">
			<div class="item estado">· <b>Estado:</b> <?php echo $confirmado; ?></div>
			<div class="item fecha">· <b>Pago:</b> <?php echo $pago; ?></div>
			<div class="item precio">· <b>Precio:</b> $ <?php echo number_format($p->getPrecioTotal(),2,',',' '); ?></div>
			<div class="item entrega">· <b>Entrega:</b> <?php echo $entrega; ?></div>
		</div>
		<div class="detalles" onclick="mostrarVariedad(<?php echo $i; ?>);">Ver detalles</div>
		<div class="variedad v-<?php echo $i; ?>">
			<div class="item nombre">Nombre</div>
			<div class="item envase">Envase</div>
			<div class="item cantidad">Cantidad</div>
		</div>	
		<?php 
		foreach($p->getArticulos() as $a){
		?>
		<div class="variedad v-<?php echo $i; ?> fondo">
			<div class="item nombre">· <?php echo $a['variedad']->getProducto()->getNombre(); ?></div>
			<div class="item envase"><?php echo $a['variedad']->getEnvase(); ?></div>
			<div class="item cantidad"><?php echo $a['cantidad']; ?> unidades</div>
		</div>		
		<?php
		}
		?>
	</div>
	<?php
	$i++;
	}
	?>
</div>
</section>	
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>