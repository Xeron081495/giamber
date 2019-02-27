<?php 
//libreria
include_once '../lib/lib.php';

$SESSION['login_panel'] = 'yes';

//ver si inicio sesion
if(!isset($SESSION['login_panel']))
	echo '<meta http-equiv="refresh" content="0; url=./">';

if(!isset($_SESSION['pedido'])){
	//creo la variablke de sesion
	$_SESSION['pedido'] = array("correo"=>NULL,"nombre"=>NULL,"variedades"=>array());	
}else{
	//me llega un usuario
	if(isset($_POST['nombre_crear']) && isset($_POST['correo_crear'])){
		$_SESSION['pedido']['correo'] = $_POST['correo_crear'];
		$_SESSION['pedido']['nombre'] = $_POST['nombre_crear'];	
		
		try{
			agregarMayorista($_SESSION['pedido']['correo'],$_SESSION['pedido']['nombre'],$_POST['cuit_crear'],'0');		
			$mayorista = new Mayorista($_SESSION['pedido']['correo']);
			$nombre = $mayorista->getNombre();
			$mayorista->aprobar();

			$mensaje   = '

				<html>
				<head><title>Usuario mayorista habilitado en giamberlubricantes.com</title></head>
				<body><h1><img src="http://'.$_SERVER['HTTP_HOST'].'/img/logo.png" width="200px" /></h1>
				<hr>

				<b>Numero de usuario</b>: '.$mayorista->getUsuario().'
				<br><br>
				<b>Correo</b>: '.$mayorista->getCorreo().'
				<br><br>
				<b>CUIT</b>: '.$mayorista->getCUIT().'
				<br><br>
				<b>Nombre del negocio</b>: '.$mayorista->getNombre().'
				<br><br>
				<hr>

				<font size="1">
				Ingres� con tu n�mero de usuario o correo, y tu contrase�a en la secci�n de mayoristas.
				</font>
				</body>
				</html>';

			//enviar numero de usuario y mensaje de aprobaci�n
			enviarCorreo($mayorista->getCorreo(),'Tu usuario mayorista fue aprobado | lubricantesgiamber.com',$mensaje,$de);



		}catch(ExceptionBD $e){
			echo $e->getMessage();
		}
	}elseif(isset($_POST['correo_elegir'])){
		$_SESSION['pedido']['correo'] = $_POST['correo_elegir'];
		$mayorista = new Mayorista($_POST['correo_elegir']);
		$_SESSION['pedido']['nombre'] = $mayorista->getNombre();			
	}
	
	//veo si hay que borrar
	if(isset($_GET['borrar']) && $_GET['borrar']=='si'){
		unset($_SESSION['pedido']);
		echo '<meta http-equiv="refresh" content="0; url=agregar-pedido.php">';			
	}	
	
	//confirmar pedido
	if(isset($_GET['confirmar']) && $_GET['confirmar']=='si'){
		$usuario = new Mayorista($_SESSION['pedido']['correo']);
		$pedido = $usuario->crearPedido();
		foreach($_SESSION['pedido']['variedades'] as $p){
			$pedido->agregarVariedad($p['variedad'],$p['cantidad']);
		}
		$pedido->setTerminado();

		unset($_SESSION['pedido']);
		//echo '<meta http-equiv="refresh" content="0; url=operacion.php?t='.urlencode('Se creo el pedido por el administrador').'">';
	}	
	
	//agregar producto
	if(isset($_GET['agregar']) && $_GET['agregar']=='si' && isset($_GET['id']) && isset($_POST['cantidad'])){
		//tomamos el pedido y la cantidad
		$variedad = new Variedad($_GET['id']);
		$cantidad = $_POST['cantidad'];	
		
		//verificamos que no este puesto ya
		$encontro = false; $i;
		for($i=0; ($i<count($_SESSION['pedido']['variedades'])) && !$encontro; $i++){
			if($variedad->getID()==$_SESSION['pedido']['variedades'][$i]['variedad']){
				$encontro = true;
			}
		}
		
		
		//agrego al pedido la variedad si no estaba
		if(!$encontro)
			array_push($_SESSION['pedido']['variedades'],array("variedad"=>$variedad->getID(),"cantidad"=>$cantidad));		
		else
			$_SESSION['pedido']['variedades'][$i-1]['cantidad'] = $cantidad;
	}	
}


//lugar
$id_lugar = 1;
$lugar = 'Pedidos';


$columnas = array('Nombre Producto','Precio Lista','Stock','Cantidad','Agregar');
$names = array('nombre','precio','stock','cantidad','agregar');
$ancho_principal = 30;
$cant = count($columnas);
$ancho = round((100-$ancho_principal)/($cant-1),PHP_ROUND_HALF_DOWN);

//tiene como longitud cant+1. Para todo K entre 1<=k<=cant-1 los datos que se imprimen, 
//y en cant va un id si es necesario o un NULL
$datos = array();
foreach(getProductos() as $prod){
	foreach($prod->getVariedades() as $v){
		array_push($datos, array($prod->getNombre().' de '.$v->getEnvase(),'$'.$v->getPrecioUnidad(),$v->getStock(),$v->getCantidadMayorista(),NULL,$v->getID()));
	}
}

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
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

<!-- JS -->
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js'></script> 
<script type='text/javascript' src='js/funciones.js'></script> 
</head>

<body>
<?php include_once 'bloques/header.php'; ?>
<section id="cuerpo">
	<?php include_once 'bloques/menu.php'; ?>	
	<section id="contenido">
		<div id="cabeza">
			<span id="titulo"><?php echo $lugar; ?> creados por administrador</span>
			<a href="pedidos.php">Volver</a>			
			<?php if(isset($_SESSION['pedido']) && $_SESSION['pedido']['nombre']!=NULL)			
					echo '<a href="agregar-pedido.php?borrar=si">Borrar pedido</a>';
			?>
			<?php if(isset($_SESSION['pedido']) && count($_SESSION['pedido']['variedades'])>0)			
					echo '<a href="pedido-ver.php?temporal=si">Ver Pedido</a>';
			?>
			<?php if(isset($_SESSION['pedido']) && count($_SESSION['pedido']['variedades'])>0)			
					echo '<a href="agregar-pedido.php?confirmar=si">Confirmar pedido</a>';
			?>
				
						
			<?php if(isset($_SESSION['pedido']) && $_SESSION['pedido']['nombre']!=NULL)
					echo '<span id="info">Estas creando un pedido para '.$_SESSION['pedido']['nombre'].'</span>';
			?>
		</div>
			
			<?php //no eligio a quien hacer el pedido
			if($_SESSION['pedido']['correo']==NULL){
			?>
			<article id="tabla-form">
				<form action="" method="post" enctype="multipart/form-data">
				<div class="titulo">Elegir usuario</div>			
				<label>
					<div class="campo_nombre">Nombre del usuario</div>
					<select name="correo_elegir" class="campo_input" type="text" required>		
						<option value="">Seleccionar cliente</option>
					<?php foreach(getMayoristas() as $m){
						echo '<option value="'.$m->getCorreo().'">'.$m->getNombre().' ('.$m->getCorreo().')</option>';					}
					?>
					</select>
				</label>				
				<label>
					<input class="campo_boton2" value="Elegir usuario y armar pedido" type="submit" />
				</label>
			</form>	
				
				<form action="" method="post" enctype="multipart/form-data">
				<div class="titulo">Crear usuario</div>			
				<label>
					<div class="campo_nombre">Nombre del negocio *</div>
					<input name="nombre_crear" class="campo_input" type="text" required />
				</label>	
				<label>
					<div class="campo_nombre">Correo del negocio *</div>
					<input name="correo_crear" class="campo_input" type="email" required />
				</label>	
				<label>
					<div class="campo_nombre">CUIT *</div>
					<input name="cuit_crear" class="campo_input" type="number" required />
				</label>			
				<label>
					<input class="campo_boton2" value="Crear usuario y armar pedido" type="submit" />
				</label>
				
				
			</form>	
		</article>	
			
			<?php
			}elseif(isset($_SESSION['pedido']) && $_SESSION['pedido']['correo']!=NULL){

			?>			
		<article id="tabla">	
			<div id="titulos">
				<?php 
				for($i=0; $i<$cant; $i++){
					if($i==0){
						echo '<div class="col primero" style="width: '.$ancho_principal.'%;">'.$columnas[$i].'</div>';
					}else{
						echo '<div class="col" style="width: '.$ancho.'%;">'.$columnas[$i].'</div>';						
					}
				}
				?>
			</div>
			<?php
			$j = 0;
			foreach($datos as $dato){
				echo '<div id="filas" onmouseover="mostrar('.$j.')" onmouseleave="ocultar('.$j.')">';	
				echo '<form action="agregar-pedido.php?agregar=si&id='.$dato[count($dato)-1].'" method="post">';				
				for($i=0; $i<count($dato)-1; $i++){				
					if($i==0){
						echo '<div class="col primero" style="width: '.$ancho_principal.'%;">'.$dato[$i].'</div>';
					}elseif($i==3){
						echo '<div class="col" style="width: '.$ancho.'%;"><input step="1" name="'.$names[$i%count($names)].'" type="number" value="'.$dato[$i].'" min="1" required></div>';						
					}elseif($i==4){
						echo '<input id="boton-confirmar" value="Agregar a carrito" type="submit" />';
					}else{
						echo '<div class="col" style="width: '.$ancho.'%;">'.$dato[$i].'</div>';						
					}
				}
				echo '	</form>';
				echo '</div>';
				$j++;
			}			
			?>
		</article>		
		<article id="tabla-celular">	
			<?php
			$j = 0;
			foreach($datos as $dato){
				echo '<div  id="filas" onmouseover="mostrar('.$j.')" onmouseleave="ocultar('.$j.')">';	
				echo '<form action="agregar-pedido.php?agregar=si&id='.$dato[count($dato)-1].'" method="post">';				
				for($i=0; $i<count($dato)-1; $i++){				
					if($i==0){
						echo '<div onclick="mostrarFila('.$j.')" class="col primero">'.$dato[$i].'</div>';
					}elseif($i==3){
						echo '<div class="col c'.$j.'" ><input step="1" name="'.$names[$i%count($names)].'" type="number" value="'.$dato[$i].'" min="1" required></div>';						
					}elseif($i==4){
						echo '<div class="col c'.$j.'" ><input class="agregar c'.$j.'" id="boton-confirmar" value="Agregar a carrito" type="submit" /></div>';
					}else{
						echo '<div class="col c'.$j.'" >'.$dato[$i].'</div>';						
					}
				}
				echo '	</form>';
				echo '</div>';
				$j++;
			}			
			?>
		</article>
			
			<?php } ?>
			
	</section>

</section>
</body>
</html>