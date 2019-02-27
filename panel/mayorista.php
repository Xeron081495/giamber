<?php 
//libreria
include_once '../lib/lib.php';

$SESSION['login_panel'] = 'yes';

//ver si inicio sesion
if(!isset($SESSION['login_panel']))
	echo '<meta http-equiv="refresh" content="0; url=./">';

//lugar
$id_lugar = 3;
$lugar = 'Usuarios Mayoristas';




$columnas = array('Nombre','correo','CUIT','Clave','Estado');
$ancho_principal = 25;
$ancho_secundario = 30;
$cant = count($columnas);
$ancho = round((100-$ancho_principal-$ancho_secundario)/($cant-2)-1,PHP_ROUND_HALF_DOWN);

//tiene como longitud cant+1. Para todo K entre 1<=k<=cant-1 los datos que se imprimen, 
//y en cant va un id si es necesario o un NULL
$datos = array();
foreach(getMayoristas() as $usuario){
	if($usuario->estaAprobado())
		$estado = 'Aprobado';
	else
		$estado = 'No Aprobado';
	array_push($datos, array($usuario->getNombre().' ('.$usuario->getUsuario().')',$usuario->getCorreo(),$usuario->getCUIT(),$usuario->getClave(),$estado,$usuario->getCorreo()));
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
			<span id="titulo"><?php echo $lugar; ?></span>
			<a href="usuarios.php">Ver usuarios minoristas</a>	
			<a href="actions/pdf-usuarios.php" download>Listado PDF de clientes</a>		
		</div>
		<article id="tabla">	
			<div id="titulos">
				<?php 
				for($i=0; $i<$cant; $i++){
					if($i==0){
						echo '<div class="col primero" style="width: '.$ancho_principal.'%;">'.$columnas[$i].'</div>';
					}elseif($i==1){
						echo '<div class="col" style="width: '.$ancho_secundario.'%;">'.$columnas[$i].'</div>';
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
				for($i=0; $i<count($dato)-1; $i++){				
					if($i==0){
						echo '<div class="col primero" style="width: '.$ancho_principal.'%;">'.$dato[$i].'</div>';
					}else if($i==1){
						echo '<div class="col" style="width: '.$ancho_secundario.'%;">'.$dato[$i].'</div>';
					}else{
						echo '<div class="col" style="width: '.$ancho.'%;">'.$dato[$i].'</div>';						
					}
				}
				echo '<div id="o'.$j.'" class="opciones">';
					$usuario = new Mayorista($dato[count($dato)-1]);
					if($usuario->getDireccion()!=NULL)
						echo '<a href="usuario-datos.php?id='.$dato[count($dato)-1].'">Ver datos cliente</a>';

				echo 	'<a href="actions/aprobar-mayorista.php?id='.$dato[count($dato)-1].'">Aprobar</a>
						<a class="ultimo" href="actions/bloquear-mayorista.php?id='.$dato[count($dato)-1].'">Bloquear</a>								
				</div>';				
				echo '</div>';
				$j++;
			}			
			?>
		</article>


		<article id="tabla-celular">
			<?php
			$j = 0;
			foreach($datos as $dato){
				$usuario = new Usuario($dato[count($dato)-1]);
				echo '<div id="filas" onmouseover="mostrar('.$j.')" onmouseleave="ocultar('.$j.')">';
				for($i=0; $i<count($dato)-1; $i++){
					if($i==0){
						echo '<div onclick="mostrarFila('.$j.')" class="col primero">'.$dato[$i].'</div>';
					}else{
						echo '<div class="col c'.$j.'">'.$columnas[$i].': '.$dato[$i].'</div>';
					}
				}
				echo '<div id="o'.$j.'" class="opciones c'.$j.'">
					<!--<a href="editar-mayorista.php?id='.$dato[count($dato)-1].'">Editar</a>-->
					<a href="actions/aprobar-mayorista.php?id='.$dato[count($dato)-1].'">Aprobar</a>
					<a class="ultimo" href="actions/bloquear-mayorista.php?id='.$dato[count($dato)-1].'">Bloquear</a>';
				echo '</div>';
				echo '</div>';
				$j++;
			}
			?>
		</article>



	</section>
</section>
</body>
</html>