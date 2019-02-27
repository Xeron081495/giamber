<?php
include_once '../lib/lib.php';


//login
try{
	$conn = new Conexion();
	$sql = "SELECT * FROM ofertas ORDER BY id DESC";
	$lista = array();
	if($resultado = $conn->getConexion()->query($sql))
		while($dato = $resultado->fetch_assoc()) {
			//convierto lista a a array
			$lista = json_decode($dato['variedades']);

			EnviarOfertas($lista);
		}
	$conn->close(); 

	//vaciamos la tabla
	$conn = new Conexion();
	$sql = "TRUNCATE TABLE ofertas";
	if(!($conn->getConexion()->query($sql))){
		throw new ExceptionBD($conn->getConexion()->error);
	}
	$conn->close();


}catch(ExceptionExiste $e){
	echo '<meta http-equiv="refresh" content="0; url=../">';
}
	









?>