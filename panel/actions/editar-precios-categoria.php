<?php 
//librerias 
include_once '../../lib/lib.php';

//variables obligatorias
$categoria = unserialize(d($_POST['categoria']))['marca'];
$gama = unserialize(d($_POST['categoria']))['gama'];
$porcentaje = $_POST['porcentaje'];

try{	
	$c = new Categoria($categoria);
	$c->setAumento($porcentaje,$gama);
	
	
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se aplico el aumento del '.$porcentaje.'% sobre '.$categoria.'('.$gama.')').'">';
	
}catch(ExceptionBD $ex){	
	echo $ex->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('No se aplico el aumento. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo $e->getMessage();	
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('No se aplico el aumento. Error: '.$e->getMessage().'').'">';
}

?>