<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$nombre = $_POST['nombre'];
$precio_unidad = $_POST['precio_unidad'];
$precio_mayorista = $_POST['precio_mayorista'];
$cantidad_mayorista = $_POST['cantidad_mayorista'];
$imagen = $_FILES['imagen'];
$categoria = $_POST['categoria'];
$stock = $_POST['stock'];
$envase = $_POST['envase'];

//variables opcionales
$aplicacion = $_POST['aplicacion'];
if(!isset($aplicacion)) $aplicacion = NULL;

$tipo = $_POST['tipo'];
if(!isset($tipo)) $tipo = NULL;

$gama = $_POST['gama'];
if(!isset($gama)) $gama = NULL;

$video = $_POST['video'];
if(!isset($video)) $video = NULL;

$modelo = $_POST['modelo'];
if(!isset($modelo)) $modelo = 0;

$ficha_pdf = $_FILES['ficha_pdf'];
if(!isset($_FILES['ficha_pdf'])) $ficha_pdf = NULL;

$descripcion = $_POST['descripcion'];
if(!isset($descripcion)) $descripcion = NULL;

try{
	//agregar a la web
	$id = agregarProducto($nombre,$imagen,$categoria,$aplicacion,$tipo,$gama,$video,$modelo,$ficha_pdf,$descripcion);
	$producto = new Producto($id);
	$producto->agregarVariedad($envase,$precio_unidad,$cantidad_mayorista,$precio_mayorista,$stock);
	
	
	
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se agregó el producto '.$nombre.'').'">';
	
}catch(ExceptionBD $ex){	
	echo $ex->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al crear. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo $e->getMessage();	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al crear. Error: '.$e->getMessage().'').'">';
}



?>