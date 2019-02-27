<?php 
//libreria de clases
include_once 'lib/lib.php'; 

//lugar
$lugar = 3;

//usuario
if(isset($_SESSION['login'])){
	try{
		$usuario = new Mayorista($_SESSION['correo']);	
	}catch(ExceptionExiste $e){
		$usuario = new Usuario($_SESSION['correo']);		
	}
	
	$pedido = $usuario->getPedido(); 
	
	//eliminar
	if(isset($_GET['eliminar'])){
		$pedido->eliminarVariedad($_GET['eliminar']);		
	}
	

	//nos fijamos si se quiere agregar un producto
	if((isset($_POST['cantidad']) && isset($_POST['variedad'])) || (isset($_GET['cantidad']) && isset($_GET['variedad']))){
		
		if(isset($_POST['cantidad'])){
			$cantidad = $_POST['cantidad'];
			$variedad = $_POST['variedad'];			
		}else{
			$cantidad = d($_GET['cantidad']);
			$variedad = d($_GET['variedad']);
		}
		
		try{
			$pedido->agregarVariedad($variedad,$cantidad);
		}catch(ExceptionExiste $e){
			echo $e->getMessage();
		}catch(ExceptionStock $ex){
			$stock_error = "error";
		}catch(Exception $ex){
			echo $ex->getMessage();
		}		
	}else{
		//nos fijamos si tiene algun prodcuto en el carrito
		if(count($pedido->getArticulos())==0){
			echo '<meta http-equiv="refresh" content="0; url=tienda.php">';
			exit;
		}
	}
	
	//obtenemos los articulos q tiene en el carrito
	$articulos = $pedido->getArticulos();
	
}else{	
	if(isset($_POST['cantidad']) && isset($_POST['variedad'])){
		$parametros = '&cantidad='.e($_POST['cantidad']).'&variedad='.e($_POST['variedad']);
	}	
	echo '<meta http-equiv="refresh" content="0; url=login-mayorista.php?t='.e('No está logueado para ver y/o modificar su pedido').''.$parametros.'">';
	exit;
}


?>
<!DOCTYPE HTML> 
<html> 
<head>
<title>Carrito de compras | Tienda Online de Giamber Lubricantes | Bahía Blanca | Motul, Maguiars y Sonax</title>
<meta charset="UTF-8" />

<!-- Estilos -->
<link rel="stylesheet" href="css/global.css" />
<link rel="stylesheet" href="css/tienda.css" />
<link rel="stylesheet" href="css/carrito.css" />

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

<?php
	if(isset($_GET['stock']) || isset($stock_error)){
		echo 'alert("¡Verificar cantidades! Un producto tiene stock insuficiente.\n\nRecuerde que hasta no finalizar la compra, otros usuarios pueden adquirir productos y dejarte sin stock.");';
	}
?>

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
	<section id="marcas">
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
		<h1 id="titulo">Tu pedido actual </h1>
		<h4 id="subtitulo">Podés modificar las cantidad elegidas. Una vez que estes seguro, hace clic en Finalizar Compra</h4>
	</div>
	<div id="cont">
		<a href="tienda.php" id="pedido">Seguir comprando</a>
	</div>
</div>
</section>
<section id="productos">
<div class="contenedor">
	<!-------------------------------------------------------
	-------------------PASO CARRITO--------------------------
	-------------------------------------------------------->

	<?php if(!isset($_GET['p'])){
	?>
	
	
	<div id="titulo">Mi pedido</div>	
	<?php $suma= 0; 
		foreach($articulos as $art){ 
			$p = $art['variedad']->getProducto();
			$v = $art['variedad'];
			$suma+= $art['precio_final'];
	
	?>
			<div class="variedad">
				<div class="imagen" style="background-image: url(productos/<?php echo $p->getImagen(); ?>);"></div>
				<div class="info">
					<div class="nombre"><?php echo $p->getNombre(); ?> de <?php echo $v->getEnvase(); ?></div>
					<div class="dato"><b>Aplicación:</b> <?php echo $p->getAplicacion(); ?></div>
					<div class="dato"><b>Tipo:</b> <?php echo $p->getTipo(); ?></div>
					<div class="dato"><b>Gama:</b> <?php echo $p->getGama(); ?></div>	
					<div class="dato"><b>Marca:</b> <?php echo $p->getCategoria()->getNombre(); ?></div>	
					<a href="carrito.php?eliminar=<?php echo $v->getID(); ?>" class="dato eliminar">Eliminar producto del pedido</a>		
				</div>
				<div class="total">
					<form id="actualizar" action="carrito.php" method="post">
						<input id="variedad_carrito" name="variedad" type="hidden" value="<?php echo $v->getID(); ?>" />
						<input class="boton" value="Actualizar cantidad" type="submit" />
						<span>de <?php echo $v->getStock(); ?> disp.</span>
						<input class="cantidad" name="cantidad" value="<?php echo $art['cantidad']; ?>" <?php if($usuario->getStep()) echo 'min="'.$v->getCantidadMayorista().'" step="'.$v->getCantidadMayorista().'"'; else echo 'min="1"'; ?> type="number" required /> 
						
					</form>
					<div class="precio">$ <?php echo number_format($art['precio_final'],2,',','.'); ?></div>
				</div>
				
			</div>
	<?php } ?>
	
	<a class="continuar" href="carrito.php?p=<?php echo e(2); ?>" >Finalizar compra</a> 
	
	<div id="total">
		<span>Total a pagar </span>
		<div id="precio">$ <?php echo number_format($pedido->getPrecioTotal(),2,',','.'); ?></div>
	</div>
	
	<!-------------------------------------------------------
	-------------------PASO DATOS--------------------------
	-------------------------------------------------------->
	
	<?php }elseif(isset($_GET['p']) && d($_GET['p'])==2) {
				if(!$pedido->verificarCantidades()){
					//echo '<meta http-equiv="refresh" content="0; url=carrito.php?stock=error">';
					echo '<script type="text/javascript">alert("Un producto no tiene stock suficiente, se entregará la cantidad disponible");</script>';					
				}
				$d = $usuario->getDireccion();
	?>
	
	<div id="titulo">Mi datos</div>	

	<form method="post" action="carrito.php?p=<?php echo e(3); ?>" >
	<div class="opcion">
		<div class="texto">Teléfono:</div>
		<input <?php if($d!=NULL) echo 'value="'.$d->getTelefono().'"'; ?> name="telefono" type="tel" placeholder="Ingresar un número de contacto" class="grande" required />
	</div>
	<div class="opcion">
		<div class="texto">Dirección:</div>
		<input <?php if($d!=NULL) echo 'value="'.$d->getCalle().'"'; ?> name="calle" type="text" placeholder="Su calle" class="grande dire1" required />
		<input <?php if($d!=NULL) echo 'value="'.$d->getNumero().'"'; ?> name="numero" type="text" placeholder="Por ej.: 1500" class="grande dire2" required />
	</div>
	<div class="opcion">
		<div class="texto">Piso / Depto.: </div>
		<input <?php if($d!=NULL) echo 'value="'.$d->getPisoDepto().'"'; ?> name="piso" type="text" placeholder="Opcional" class="grande" />
	</div>
	<div class="opcion">
		<div class="texto">Entre calles: </div>
		<input <?php if($d!=NULL) echo 'value="'.$d->getEntre().'"'; ?> name="entre" type="text" placeholder="Entre que calles está su domicilio" class="grande" />
	</div>
	<div class="opcion">
		<div class="texto">Ciudad: </div>
		<input <?php if($d!=NULL) echo 'value="'.$d->getCiudad().'"'; ?> name="ciudad" type="text" placeholder="Ingrese su ciudad" class="grande" required />
	</div>
	<div class="opcion">
		<div class="texto">Código postal (CP): </div>
		<input <?php if($d!=NULL) echo 'value="'.$d->getCP().'"'; ?> name="cp" type="text" placeholder="Ingrese su código postal" class="grande" required />
	</div>
	<div class="opcion">
		<div class="texto">Aclaraciones: </div>
		<textarea name="otros" rows="5" type="text" placeholder="Ingrese otros datos relevantes como forma de envio." class="grande"><?php if($d!=NULL) echo $d->getOtros(); ?></textarea>
	</div>
	<div class="opcion">
		<?php if(!$usuario->getStep()){
		?>	
		<div class="texto">Envios: </div>
		<select name="envio" class="grande" required>
			<option value="">Elegir una opción</option>
			<option value="0">Retirar por el negocio</option>
			<option value="1">Envio a domicilio (costo adicional)</option>
		</select>	
		<div class="texto">Modo de pago: </div>
		<select name="pago" class="grande" required>
			<option value="">Elegir una opción</option>
			<option value="0">Efectivo en persona</option>
			<option value="1">Pago online (MercadoPago)</option>
		</select>
		<?php
		}
		?>
	</div>
	
	
	<input type="submit" class="continuar" href="carrito.php?p=<?php echo e(3); ?>" value="Confirmar pedido" /> 
	
	
	<div id="total">
		<span>Total a pagar </span>
		<div id="precio">$ <?php echo number_format($pedido->getPrecioTotal(),2,',','.'); ?></div>
	</div>
	
	</form>
	
	<!-------------------------------------------------------
	-------------------PASO DATOS--------------------------
	-------------------------------------------------------->
	
	<?php }elseif(isset($_GET['p']) && d($_GET['p'])==3) {
			if(!$pedido->verificarCantidades()){
					//echo '<meta http-equiv="refresh" content="0; url=carrito.php?stock=error">';
					echo '<script type="text/javascript">alert("Un producto no tiene stock suficiente, se entregará la cantidad disponible");</script>';					
				}	
		
			$telefono = $_POST['telefono'];
			$calle = $_POST['calle'];
			$numero = $_POST['numero'];
			$piso_depto = $_POST['piso'];
			$entre = $_POST['entre'];
			$ciudad = $_POST['ciudad'];
			$cp = $_POST['cp'];
			$otros = $_POST['otros'];
			//envio
			if(isset($_POST['envio']))
				$envio = $_POST['envio'];
			else
				$envio = 3; //mayorista
			
			if(isset($_POST['pago']))
				$pago = $_POST['pago'];
			else
				$pago = "0"; //mayorista
			
			$usuario->setDireccion($telefono,$calle,$numero,$piso_depto,$entre,$ciudad,$cp,$otros);	
		
			$gestor = new GestorMP();
			$gestor->crearPago($pedido->getID(),$usuario->getCorreo(),NULL,'pendiente');
			$pedido->setEnvio($envio);
			enviarCorreo($de,'Nuevo pedido de '.$pedido->getUsuario()->getNombre(),'Se recibió un pedido nuevo',$de);
						
			
			echo '<div id="mensaje">Tu pedido (#'.$pedido->getID().') fue enviado</div>
			<div id="aclaraciones">Tu pedido se está procesando. En las próximas 48 horas, recibirás la confirmación via correo electrónico. También podes ver el estado en la sección "Mis pedidos".</div>';	
			
	}
	?>
	
</div>
</section>
	
	
<?php include_once 'bloques/footer.php'; ?>	
</body>
</html>