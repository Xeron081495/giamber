<?php
session_start();
date_default_timezone_set('america/argentina/buenos_aires');


$de = $correo_oficial = 'giamberlubricantes@gmail.com'; // correo oficial
$correos_oferta = ['delmes@lubricantesgiamber.com','ofer@lubricantesgiamber.com','no-responder@lubricantesgiamber.com'];
//$de = $correo_oficial = 'xeron08@hotmail.com'; // correo pruebas



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

	if (count(getMayoristas()) == 0) {
		$numero = 101;
	} else {
		$numero = getUltimoUsuario()->getUsuario() + 1;
	}

	$conn = new Conexion();
	$sql = "CALL agregarMayorista('$correo','$nombre','$cuit','$numero','$clave')";

	if ($resultado = $conn->getConexion()->query($sql)){
		while ($dato = $resultado->fetch_assoc()) {
			if (isset($dato['Resultado']) && $dato['Resultado'] == 'Error')
				throw new ExceptionBD ($dato['Motivo']);
			elseif (isset($dato['Resultado']) && $dato['Resultado'] == 'SQLEXCEPTION!, Transaccion abortada') {
				throw new ExceptionBD ('Error al cargar, intente nuevamente. ((' . $dato['codigo_MySQL'] . ')' . $dato['mensaje_error'] . ')');
			}
		}

	EnviarCorreoRegistro($correo);
	enviarCorreo($GLOBALS['correo_oficial'], 'Un usuario se registró en la plataforma', 'El usuario: ' . $nombre . ' se registro en la plataforma y necesita tu aprovación para operar En la sección mayorista del panel de control elegir la opción aprobar o rechazar para el usuario.', $correo, 'Nuevo Usuario', NULL);

}else{
		echo $conn->getConexion()->error;
	}
	$conn->close();  
}

function EnviarCorreccion(){
	foreach(getMayoristas() as $m){
		$mensaje   = '

		<html>
		<head><title>IMPORTANTE. Cambios en tu usuario de giamberlubricantes.com</title></head>
		<body><h1><img src="http://'.$_SERVER['HTTP_HOST'].'/img/logo.png" width="200px" /></h1>
		<hr>

		<b>Debido a un problema en nuestra base de datos hemos reasignado algunos nombres de usuario. Tu datos son:</b>
		<br><br>
		<b>Numero de usuario</b>: '.$m->getUsuario().'
		<br><br>
		<b>Correo</b>: '.$m->getCorreo().'
		<br><br>
		<b>Nombre del negocio</b>: '.$m->getNombre().'
		<br><br>
		<hr>

		<font size="2">
		Cualquier duda contactarse con xeron08@hotmail
		</font>
		</body>
		</html>';

	//enviar numero de usuario y mensaje de aprobación
	enviarCorreo($m->getCorreo(),'Nombres de usuarios | lubricantesgiamber.com',$mensaje,$GLOBALS['correo_oficial'],"Giamber Lubricantes");
	}
}


function EnviarCorreoRegistro($correo){

	$usuario = new Mayorista($correo);

	$mensaje   = '

		<html>
		<head><title>Usuario mayorista creado en giamberlubricantes.com</title></head>
		<body><h1><img src="http://'.$_SERVER['HTTP_HOST'].'/img/logo.png" width="200px" /></h1>
		<hr>

		<b>Este tipo de usuarios requiere aprobación de Giamber Lubricantes, en las siguiente 48hs recibirá un correo.</b>
		<br><br>
		<b>Numero de usuario</b>: '.$usuario->getUsuario().'
		<br><br>
		<b>Correo</b>: '.$usuario->getCorreo().'
		<br><br>
		<b>DNI</b>: '.$usuario->getCUIT().'
		<br><br>
		<b>Nombre del negocio</b>: '.$usuario->getNombre().'
		<br><br>
		<hr>

		<font size="2">
		Ingresá con tu correo/numero y tu contraseña en la sección de mayoristas una vez aprobado.
		</font>
		</body>
		</html>';

	//enviar numero de usuario y mensaje de aprobación
	enviarCorreo($usuario->getCorreo(),'Tu usuario mayorista fue creado | lubricantesgiamber.com',$mensaje,$GLOBALS['correo_oficial']);
}


function getUltimoUsuario(){
	$conn = new Conexion();
	$sql = "SELECT correo,usuario FROM usuarios NATURAL JOIN mayoristas ORDER BY mayoristas.usuario DESC LIMIT 1";
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
	$sql = "SELECT * FROM usuarios NATURAL JOIN mayoristas ORDER BY mayoristas.usuario DESC";
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
function agregarProducto($nombre,$imagenes,$categoria,$aplicacion,$tipo,$gama,$video,$modelo,$pdf,$descripcion){	
	
	//subir imagenes
	$imagenes_nombre = array();	
	foreach($imagenes as $imagen){
		array_push($imagenes_nombre,subirImagen($imagen));	
		sleep(1);
	}
	
	$nombre_pdf = NULL;
	
	if($pdf!=NULL)
		$nombre_pdf = subirPDF($pdf);
	
	$id = date('U');
	
	//subir producto
	$conn = new Conexion();
	$sql = "INSERT INTO productos(id,nombre,aplicacion,tipo,gama,video,ficha_pdf,modelo,descripcion,fecha,categoria)
	VALUES ('$id','$nombre','$aplicacion','$tipo','$gama','$video','$nombre_pdf','$modelo','$descripcion',now(),'$categoria')";

	if(!($conn->getConexion()->query($sql)))
		throw new ExceptionBD($conn->getConexion()->error);
	
	$prioridad = 100;
	//subir imagenes a sql
	foreach($imagenes_nombre as $n){
		$sql = "INSERT INTO productos_imagenes(id_producto,nombre,prioridad) VALUES ('$id','$n','$prioridad')";

		if(!($conn->getConexion()->query($sql)))
			throw new ExceptionBD($conn->getConexion()->error);	
		elseif($prioridad>9)
			$prioridad-=10;
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
				throw Exception('Formato desconocido');
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
	$consulta = "SELECT id FROM productos WHERE visible>0 ORDER BY id DESC";
	if($resultado = $conn->getConexion()->query($consulta))
		while($dato = $resultado->fetch_assoc()) {
			array_push($lista,new Producto($dato['id']));
		}
	$conn->close();
	return $lista;
}
function getVariedades(){
	$lista = array();
	$conn = new Conexion();
	$consulta = "SELECT id FROM variedades WHERE visible>0 ORDER BY id DESC";
	if($resultado = $conn->getConexion()->query($consulta))
		while($dato = $resultado->fetch_assoc()) {
			array_push($lista,new Variedad($dato['id']));
		}
	$conn->close();
	return $lista;
}

function getProductosAvanzada($oracionBusqueda){
	//sacar caracteres especiales
	$oracionBusqueda = str_replace('.','',$oracionBusqueda);
	$oracionBusqueda = str_replace(',','',$oracionBusqueda);
	$oracionBusqueda = str_replace('-','',$oracionBusqueda);
	$oracionBusqueda = str_replace('_','',$oracionBusqueda);
	
	//separo la oracion en un arreglo.
	$palabras = explode(' ',$oracionBusqueda);
	
	//guardamos listas con los productos que contienen la palabra
	$lista = array();
	foreach($palabras as $palabra){
		array_push($lista,getProductosAvanzadaAux($palabra));
	}
	
	$arreglo = $lista[0];
	for($i=1; $i<count($lista); $i++){
		$arreglo = interseccion($arreglo,$lista[$i]);
	}
	
	return $arreglo;	
}

function interseccion($a1,$b2){
	$retorno = array();
	foreach($a1 as $a){
		foreach($b2 as $b){
			if($a->getID()==$b->getID())
				array_push($retorno,$a);
		}
	}
	return $retorno;
}

function getProductosAvanzadaAux($busqueda){
	$lista = array();	
	$conn = new Conexion();
	$consulta = "SELECT id FROM productos WHERE (nombre LIKE '%$busqueda%' OR categoria LIKE '%$busqueda%' OR aplicacion LIKE '%$busqueda%' OR tipo LIKE '%$busqueda%' OR gama LIKE '%$busqueda%' OR modelo LIKE '%$busqueda%') AND visible>0 ORDER BY fecha DESC";
	if($resultado = $conn->getConexion()->query($consulta))
		while($dato = $resultado->fetch_assoc()) {
			array_push($lista,new Producto($dato['id']));
		}
	$conn->close();    
	return $lista;
}

function getProductosRelacionados($n){
	$lista = array();
	$conn = new Conexion();
	$consulta = "SELECT id FROM productos WHERE visible>0 ORDER BY RAND() LIMIT 0,$n";
	if($resultado = $conn->getConexion()->query($consulta))
		while($dato = $resultado->fetch_assoc()) {
			array_push($lista,new Producto($dato['id']));
		}
	$conn->close();
	return $lista;
}

function getProductosOferta(){
	$lista = array();
	$conn = new Conexion();
	$consulta = "SELECT DISTINCT p.id FROM productos as p JOIN variedades as v ON p.id=v.id_producto WHERE p.visible>0 AND v.oferta>0 ORDER BY fecha DESC";
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
	$consulta = "SELECT id FROM productos WHERE (gama LIKE '%$busqueda%') AND visible>0 AND categoria='Motul' ORDER BY fecha DESC";
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
	$consulta = "SELECT nombre FROM categorias ORDER BY prioridad DESC";
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

/*
function enviarCorreo($to,$asunto,$mensaje,$from,$from_name=NULL,$archivo=NULL){
	//incluir galerias
	include_once 'PHPMailer/PHPMailer.php';
	include_once 'PHPMailer/Exception.php';
	include_once 'PHPMailer/OAuth.php';
	include_once 'PHPMailer/POP3.php';
	include_once 'PHPMailer/SMTP.php';
	//crear instancia
	$mail = new PHPMailer\PHPMailer\PHPMailer();
	//tipo de envio
	$mail->isSMTP();
	//tipo de smtp
	$mail->SMTPDebug = false;
	//host mail de neolo
	$mail->Host = 'rap.webserverns.com';
	// puerto para ssl/tls
	$mail->Port = 465;
	//seguridad
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	//usuario y pass
	$mail->Username = '_mainaccount@lubricantesgiamber.com';
	$mail->Password = 'lubricantes1520';
	//quien envia
	if($from_name!=NULL){
		$mail->setFrom($from, $from_name);
		$mail->addReplyTo($from,$from_name);
	}else{
		$mail->setFrom($from);
		$mail->addReplyTo($from);		
	}
	//a quien manda
	$mail->addAddress($to);
	$mail->addAddress('xeron08@hotmail.com', 'Correo de Prueba');

	//asunto y mensaje
	$mail->Subject = $asunto;
	$mail->isHTML(true);
	$mail->Body = $mensaje;
	$mail->CharSet = 'UTF-8';

	//agreagr archivo
	if($archivo!=NULL)
		$mail->addAttachment($archivo['tmp_name'],$archivo['name']);
	
	//enviar correo
	if(!$mail->send()){
		throw new Exception($mail->ErrorInfo);
	}


}*/

function enviarCorreo($to,$asunto,$mensaje,$from,$from_name=NULL,$archivo=NULL){
	//incluir galerias
	include_once 'PHPMailer/PHPMailer.php';
	include_once 'PHPMailer/Exception.php';
	include_once 'PHPMailer/OAuth.php';
	include_once 'PHPMailer/POP3.php';
	include_once 'PHPMailer/SMTP.php';
	//crear instancia
	$mail = new PHPMailer\PHPMailer\PHPMailer();
	//tipo de envio
	$mail->isSMTP();
	//tipo de smtp
	$mail->SMTPDebug = false;
	//host mail de neolo
	$mail->Host = 'rap.webserverns.com';
	// puerto para ssl/tls
	$mail->Port = 465;
	//seguridad
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	//usuario y pass
	$mail->Username = 'send@lubricantesgiamber.com';
	$mail->Password = 'lubricantes1520';
	//quien envia
	if($from_name!=NULL){
		$mail->setFrom($from, $from_name);
		$mail->addReplyTo($from,$from_name);
	}else{
		$mail->setFrom($from);
		$mail->addReplyTo($from);		
	}
	//a quien manda
	$mail->addAddress($to);
	//$mail->addAddress('xeron08@hotmail.com', 'Correo de Prueba');

	//asunto y mensaje
	$mail->Subject = $asunto;
	$mail->isHTML(true);
	$mail->Body = $mensaje;
	$mail->CharSet = 'UTF-8';

	//agreagr archivo
	if($archivo!=NULL)
		$mail->addAttachment($archivo['tmp_name'],$archivo['name']);
	
	//enviar correo
	if(!$mail->send()){
		throw new Exception($mail->ErrorInfo);
	}


}

function getCategoriasLeyenda(){
	$categorias = getCategorias();
	$cant = count($categorias);
	$texto = '';
	for($i=0; $i<$cant; $i++){
		$texto.= $categorias[$i]->getNombre().'';
		if($cant==($i+1))
			$texto.= '.';
		elseif($cant==($i+2))
			$texto.= ', ';
		else
			$texto.= ', '; 
	}
	return $texto;
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



function EnviarOfertas($lista_variedades){

	$mensaje   = '
	<table width="100%" cellspacing=0 cellpadding="5px" style="min-width: 600px; font-family: Arial; background-color: #222; color: #EDEDED">
		<tr>
			<th width="10%"></th>
			<th width="20%"><img id="icono" style="width: 100%;" src="http://lubricantesgiamber.com/img/logo_blanco.png" /></th>
			<th width="35%" style="font-family: Arial;">BENEFICIO EXCLUSIVO <br> PARA TIENDA ONLINE</th>
		</tr>
	</table>
	<table width="100%" cellspacing=0 cellpadding="15px" style="font-size: 15px; font-family: Arial; background-color: #333; color: white">
		<tr>
			<th> <a style="color: #EEE; text-decoration: none"  href="http://lubricantesgiamber.com/tienda.php?gama=QXV0bw%3D%3D">Motul autos</a></th>
			<th> <a style="color: #EEE; text-decoration: none"  href="http://lubricantesgiamber.com/tienda.php?gama=TW90bw%3D%3D">Motul motos</a></th>
			<th> <a style="color: #EEE; text-decoration: none"  href="http://lubricantesgiamber.com/tienda.php?categoria=SGF2b2xpbmUgVGV4YWNv">Havoline Texaco</a></th> 
			<th> <a style="color: #EEE; text-decoration: none"  href="http://lubricantesgiamber.com/tienda.php">Catálogo completo</a></th> 
		</tr>
	</table>
	<table width="100%" cellspacing=0 cellpadding="25px" style="font-family: Arial; background-color: #FAFAFA; color: #111">
	
		';
		
		foreach($lista_variedades as $id){
			$v = new Variedad($id);

			$mensaje .='
			<tr>
			<th width="15%" >
				<a href="http://www.lubricantesgiamber.com/prod.php?id='.e($v->getProducto()->getID()).'">
					<img style="width: 100%" src="http://www.lubricantesgiamber.com/productos/'.$v->getProducto()->getImagen().'" />
				</a>
			</th>
			<th width="30%" >
				<a style="color: #111; text-decoration: none" href="http://www.lubricantesgiamber.com/prod.php?id='.e($v->getProducto()->getID()).'">
					'.$v->getProducto()->getNombre().' de '.$v->getEnvase().'
				</a>
			</th>
			<th width="17%" >
				<a style="color: #111; text-decoration: none" href="http://www.lubricantesgiamber.com/prod.php?id='.e($v->getProducto()->getID()).'">
					<span style="padding: 0px; border-radius: 5px; color: #222">$ '.$v->getPrecioMayoristaNeto().'</span>
				</a>    
			</th> 
			<th width="10%" >
				<a style="color: #111; text-decoration: none" href="http://www.lubricantesgiamber.com/prod.php?id='.e($v->getProducto()->getID()).'">
					<span style="background-color: #ba4545; padding: 10px; border-radius: 5px; color: #EEE">'.$v->getOferta().'%</span>
				</a>    
			</th> 
			<th width="17%" >
				<a style="color: #111; text-decoration: none" href="http://www.lubricantesgiamber.com/prod.php?id='.e($v->getProducto()->getID()).'">
					<span style="padding: 0px; border-radius: 5px; color: #222">Ver oferta</span>
				</a>    
			</th> 
			</tr>
			
			';

		}
		
		
			
		$mensaje.= '
	</table>
	<table width="100%" cellspacing=0 cellpadding="25px" style="text-align: left; font-family: Arial; color: #999; font-size: 11px">
		<tr>
			<th>
				OFERTAS VALIDAS ÚNICAMENTE POR LOS SIGUIENTES 30 DíAS PARA COMPRAS UNICAMENTE A TRAVES DE LUBRICANTESGIAMBER.COM. LAS FOTOS DE LOS PRODUCTOS SON SOLO A LOS EFECTOS ILUSTRATIVOS. PROMOCIONES NO ACUMULABLES CON OTRAS PROMOCIONES VIGENTES. 
			</th>
		</tr>
	</table>';

	// calculo la posicion del array del mail que elijo
	$pos = array_rand($GLOBALS['correos_oferta'],1);
	$c = $GLOBALS['correos_oferta'][$pos];

	foreach(getMayoristas() as $m){
		//enviar numero de usuario y mensaje de aprobación
		if($m->getCorreo()!="giamberlubricantes@gmail.com") 
			enviarCorreo($m->getCorreo(),'Ofertas del mes',$mensaje,$c,"Giamber Lubricantes");
	}
}




?>