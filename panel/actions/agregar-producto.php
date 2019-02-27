<?php 
//librerias 
include_once '../../lib/lib.php';

$_SESSION['error'] = array();

//variables obligatorias
$nombre = $_SESSION['error']['nombre'] = $_POST['nombre'] ;
$precio_unidad = $_SESSION['error']['precio_unidad'] = $_POST['precio_unidad'];
$precio_mayorista = $_SESSION['error']['precio_mayorista'] = $_POST['precio_mayorista'];
$cantidad_mayorista = $_SESSION['error']['cantidad_mayorista'] = $_POST['cantidad_mayorista'];

$categoria  = $_SESSION['error']['categoria'] = $_POST['categoria'];
$stock = $_SESSION['error']['stock'] = $_POST['stock'];
$envase = $_SESSION['error']['envase'] = $_POST['envase'];
$oferta = $_SESSION['error']['oferta'] = $_POST['oferta'];

$imagen = array();
for($i=0; isset($_FILES['imagen-'.$i]); $i++){
	array_push($imagen,$_FILES['imagen-'.$i]);
}


//variables opcionales
$aplicacion = $_SESSION['error']['aplicacion'] = $_POST['aplicacion'];
if(!isset($aplicacion)) $aplicacion = NULL;

$tipo = $_SESSION['error']['tipo'] = $_POST['tipo'];
if(!isset($tipo)) $tipo = NULL;

$gama  = $_SESSION['error']['gama'] = $_POST['gama'];
if(!isset($gama)) $gama = NULL;

$video = $_SESSION['error']['video'] = $_POST['video'];
if(!isset($video)) $video = NULL;

$modelo = $_SESSION['error']['modelo'] = $_POST['modelo'];
if(!isset($modelo)) $modelo = 0;

$ficha_pdf = $_FILES['ficha_pdf'];
if(!isset($_FILES['ficha_pdf'])) $ficha_pdf = NULL;

$descripcion = $_SESSION['error']['descripcion'] = $_POST['descripcion'];
if(!isset($descripcion)) $descripcion = NULL;

try{
	//agregar a la web
	$id = agregarProducto($nombre,$imagen,$categoria,$aplicacion,$tipo,$gama,$video,$modelo,$ficha_pdf,$descripcion);
	$producto = new Producto($id);
	$producto->agregarVariedad($envase,$precio_unidad,$cantidad_mayorista,$precio_mayorista,$stock,$oferta);
	
	unset($_SESSION['error']);

	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se agregó el producto '.$nombre.'').'">';
	
}catch(ExceptionBD $ex){	
	//echo $ex->getMessage();
	//echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al crear. Error: '.$ex->getMessage().'').'&redireccion='.urlencode('agregar-producto.php').'">';
}catch(Exception $e){
	echo $e->getMessage();	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al crear. Error: '.$e->getMessage().'').'&redireccion='.urlencode('agregar-producto.php').'">';
}



?>