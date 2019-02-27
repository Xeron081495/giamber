<?php
session_start();

//$de = 'giamberlubricantes@gmail.com'; // correo oficial
$de = 'xeron08@hotmail.com';

//clases
include_once 'c_conexion.php';
include_once 'c_excepciones.php';
include_once 'c_mercadopago.php';
include_once 'c_usuarios.php';
include_once 'mercadopago/lib/mercadopago.php';
include_once 'c_prod.php';

$mp = new GestorMP();

/*
Usuarios
*/

function agregarUsuario($correo,$nombre,$dni,$clave){	
	
	$conn = new Conexion();
	$sql = "INSERT INTO usuarios(correo,nombre,clave,dni_cuit,fecha_reg) VALUES ('$correo','$nombre','$clave','$dni',now())";

	if(!($conn->getConexion()->query($sql))){
		throw new ExceptionBD('El correo ya está registrado.');
	}
}

function agregarMayorista($correo,$nombre,$cuit,$clave){	
		
	if(count(getMayoristas())==0){
		$numero = 101;
	}else{
		$numero =  getUltimoUsuario()->getUsuario()+1;
	}
		
	$conn = new Conexion();
	$sql = "CALL agregarMayorista('$correo','$nombre','$cuit','$numero','$clave')";
	
	if($resultado = $conn->getConexion()->query($sql))
		while($dato = $resultado->fetch_assoc()) {
			if(isset($dato['Resultado']) && $dato['Resultado']=='Error')
				throw new ExceptionBD ($dato['Motivo']);
			elseif(isset($dato['Resultado']) && $dato['Resultado']=='SQLEXCEPTION!, Transaccion abortada'){
				throw new ExceptionBD ('Error al cargar, intente nuevamente. (('.$dato['codigo_MySQL'].')'.$dato['mensaje_error'].')');				
			}
		}
	else{		
		echo $conn->getConexion()->error;
	}
	$conn->close();  
}

function getUltimoUsuario(){
	$conn = new Conexion();
	$sql = "SELECT * FROM usuarios NATURAL JOIN mayoristas HAVING max(usuario)";
	if($resultado = $conn->getConexion()->query($sql))
		while($dato = $resultado->fetch_assoc()) {
			return new Mayorista($dato['correo']);
		}
	$conn->close(); 
	return NULL;
}


function getUsuarios(){
	$conn = new Conexion();
	$sql = "SELECT * FROM usuarios WHERE correo NOT IN (SELECT correo FROM mayoristas)";
	$lista = array();
	if($resultado = $conn->getConexion()->query($sql))
		while($dato = $resultado->fetch_assoc()) {
			array_push($lista,new Usuario($dato['correo']));
		}
	$conn->close();  
	return $lista;
}

function getMayoristas(){
	$conn = new Conexion();
	$sql = "SELECT * FROM usuarios NATURAL JOIN mayoristas";
	$lista = array();
	if($resultado = $conn->getConexion()->query($sql))
		while($dato = $resultado->fetch_assoc()) {
			array_push($lista,new Mayorista($dato['correo']));
		}
	$conn->close();  
	return $lista;
}



/*
	CREAR PRODUCTOS
*/
function agregarProducto($nombre,$imagen,$categoria,$aplicacion,$tipo,$gama,$video,$modelo,$pdf,$descripcion){	
	$nombre_imagen = subirImagen($imagen);
	
	$nombre_pdf = NULL;
	
	if($pdf!=NULL)
		$nombre_pdf = subirPDF($pdf);
	
	$id = date('U');
	
	$conn = new Conexion();
	$sql = "INSERT INTO productos(id,nombre,imagen,aplicacion,tipo,gama,video,ficha_pdf,modelo,descripcion,fecha,categoria)
	VALUES ('$id','$nombre','$nombre_imagen','$aplicacion','$tipo','$gama','$video','$nombre_pdf','$modelo','$descripcion',now(),'$categoria')";

	if(!($conn->getConexion()->query($sql))){
		throw new ExceptionBD($conn->getConexion()->error);
	}
	return $id;
}

function eliminarProducto($id){
	$p = new Producto($id);
	$variedades = $p->getVariedades();
	foreach($variedades as $v){
		$conn = new Conexion();
		$sql = "UPDATE variedades SET visible=0 WHERE id='".$v->getID()."'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD($conn->getConexion()->error);
		}
		$conn->close();
	}

	$conn = new Conexion();
	$sql = "UPDATE productos SET visible=0 WHERE id='$id'";
	if(!($conn->getConexion()->query($sql))){
		throw new ExceptionBD($conn->getConexion()->error);
	}
	$conn->close();
}


function subirImagen($imagen){
	
	if ($imagen["error"]>0){
		throw new Exception('Error al cargar la imagen.');
	}else{
		$permitidos = array("image/jpg", "image/jpeg", "image/png"); 
		$limite_kb = 10000*10000;
		$nombre = date('U');
		if (in_array($imagen['type'], $permitidos) && $imagen['size'] <= $limite_kb * 1024){
			$formato = recuperar_formato($imagen['type']);
			$ruta = '../../productos/'.$nombre.'.'.$formato.'';
			$resultado = move_uploaded_file($imagen['tmp_name'], $ruta);
			if($resultado){
				return $nombre.'.'.$formato;
			}else{
				throw new Exception('¡Error al subir la imagen!');
			}
		}else{
			throw new Exception('¡Error! Los formatos permitidos son PNG, JPG Y JPEG.');
		}
	}
	
	return "Nombre";
}

function recuperar_formato($formato){
	if($formato=='image/jpg')
		return 'jpg';
	else
		if($formato == 'image/jpeg')
			return 'jpg';	
		else
			if($formato=='image/png')
				return 'png';
			else
				if($formato=='image/gif')
					return 'gif';
				else
					return 'error';
}


function subirPDF($pdf){
	if($pdf["error"]>0)
		return NULL;
	else{
		$nombre = date('U');
		$ruta = '../../productos/'.$nombre.'.pdf';
		$resultado = move_uploaded_file($pdf['tmp_name'], $ruta);
		if($resultado){
			return $nombre.'.pdf';
		}else
			throw new Exception('¡Error al subir la imagen!');
	}	
	return "Nombre";
}


/*
	GET PRODUCTOS
*/
function getProductos(){
	$lista = array();	
	$conn = new Conexion();
	$consulta = "SELECT id FROM productos WHERE visible>0 ORDER BY fecha DESC";
	if($resultado = $conn->getConexion()->query($consulta))
		while($dato = $resultado->fetch_assoc()) {
			array_push($lista,new Producto($dato['id']));
		}
	$conn->close();    
	return $lista;
}

function getProductosCategoria($categoria){
	$lista = array();	
	$conn = new Conexion();
	$consulta = "SELECT id FROM productos WHERE categoria='$categoria' AND visible>0 ORDER BY fecha DESC";
	if($resultado = $conn->getConexion()->query($consulta))
		while($dato = $resultado->fetch_assoc()) {
			array_push($lista,new Producto($dato['id']));
		}
	$conn->close();    
	return $lista;
}

function getProductosBusqueda($busqueda){
	$lista = array();	
	$conn = new Conexion();
	//OR categoria LIKE '$busqueda' OR descripcion LIKE '$busqueda' 
	$consulta = "SELECT id FROM productos WHERE nombre LIKE '%$busqueda%' AND visible>0 ORDER BY fecha DESC";
	if($resultado = $conn->getConexion()->query($consulta))
		while($dato = $resultado->fetch_assoc()) {
			array_push($lista,new Producto($dato['id']));
		}
	$conn->close();    
	return $lista;
}

function getProductosGama($busqueda){
	$lista = array();	
	$conn = new Conexion();
	//OR categoria LIKE '$busqueda' OR descripcion LIKE '$busqueda' 
	$consulta = "SELECT id FROM productos WHERE (gama LIKE '%$busqueda%' OR aplicacion LIKE '%$busqueda%') AND visible>0 ORDER BY fecha DESC";
	if($resultado = $conn->getConexion()->query($consulta))
		while($dato = $resultado->fetch_assoc()) {
			array_push($lista,new Producto($dato['id']));
		}
	$conn->close();    
	return $lista;
}

/* 
	GET CATEGORIAS
*/
function getCategorias(){
	$lista = array();	
	$conn = new Conexion();
	$consulta = "SELECT nombre FROM categorias";
	if($resultado = $conn->getConexion()->query($consulta))
		while($dato = $resultado->fetch_assoc()) {
			$nombre = $dato['nombre'];
			array_push($lista,new Categoria($nombre));
		}
	$conn->close();    
	return $lista;	
}


/* 
	GET PEDIDOS	
*/
function getPedidos($dato=NULL){
	$lista = array();	
	$conn = new Conexion();
	$consulta = "SELECT * FROM pedidos ".$dato." ORDER BY fecha DESC, hora DESC";
	if($resultado = $conn->getConexion()->query($consulta))
		while($dato = $resultado->fetch_assoc()) {
			$id = $dato['id'];
			array_push($lista,new Pedido($id));
		}
	$conn->close();    
	return $lista;
}



//crear mail verificado
function enviarCorreo($para,$asunto,$mensaje,$de){

	//Crear cuerpo email
	$asunto    = $asunto;
	$mensaje   = $mensaje;
		
		
	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$cabeceras .= 'From: '.$de.' ' . "\r\n";

	//Mandar email
	$envia = mail($para,$asunto,$mensaje,$cabeceras);
}

function formatoPrecio($precio){ 
	return number_format($precio,2,',','.');
}		
#algoritmos de incriptacion
function e($string) {
	return urlencode(base64_encode($string));
}
function d($string) {
	return urldecode(base64_decode($string));
}	


?>