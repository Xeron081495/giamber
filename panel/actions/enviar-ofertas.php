<?php 
//librerias 
include_once '../../lib/lib.php';


try{ 
	
	//creo array 
	$array_lista = array();

	//convierto a array de $id de variedades
	$ofertas = unserialize(urldecode(d($_GET['oferta'])));

	foreach($ofertas as $o){

		echo 'var_'.$o;
		echo '<br>';

		if(isset($_POST['var_'.$o])){
			array_push($array_lista,$o);
		}
	}
	
	//envio las ofertas
	if(count($array_lista)>0){ 
		$conn = new Conexion();
		$sql = "INSERT INTO ofertas (variedades) VALUES ('".json_encode($array_lista)."')";

		if(!($conn->getConexion()->query($sql)))
			throw new ExceptionBD($conn->getConexion()->error);

			
		//redireccionar
		echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se enviaron las ofertas').'">';
	}else{

		//redireccionar
		echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('No se seleccionaron productos para enviar ofertas').'">';
	

	}


	


}catch(ExceptionBD $ex){
	echo $ex->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al editar. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo $e->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al editar. Error: '.$e->getMessage().'').'">';
}

?>