<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$id = $_GET['id'];

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

$descripcion = $_POST['descripcion'];
if(!isset($descripcion)) $descripcion = NULL;


try{
	$prod = new Producto($id);
	
	//editar producto
	$prod->set($nombre,$categoria,$aplicacion,$tipo,$gama,$video,$modelo,$descripcion);
	
	//editar variedades
	foreach($prod->getVariedades() as $v){
		$v->set($_POST['envase'.$v->getID()],$_POST['precio_unidad'.$v->getID()],$_POST['cantidad_mayorista'.$v->getID()],$_POST['precio_mayorista'.$v->getID()],$_POST['stock'.$v->getID()],$_POST['oferta'.$v->getID()]);
	}	
	
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se editó el producto '.$nombre.'').'">';
	
}catch(ExceptionBD $ex){	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al editar. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al editar. Error: '.$e->getMessage().'').'">';
}



?>