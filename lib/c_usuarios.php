<?php

class Direccion{
	protected $correo,$piso_depto,$telefono,$calle,$numero,$entre,$ciudad,$cp,$otros;
	
	//constrcutor
	public function __construct($correo){
		$conn = new Conexion();
		$consulta = "SELECT * FROM direcciones WHERE correo='$correo'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$this->correo = $dato['correo'];
				$this->telefono = $dato['telefono'];
				$this->calle = $dato['calle'];
				$this->numero = $dato['numero'];
				$this->piso_depto = $dato['piso_depto'];
				$this->entre = $dato['entre'];
				$this->ciudad = $dato['ciudad'];
				$this->cp = $dato['cp'];
				$this->otros = $dato['otros'];
				$encontro = true;
			}
		$conn->close();
		if(!$encontro)
			throw new ExceptionExiste('No existe ninguna dirección asociado a '.$correo);
    } 
	
	public function getCorreo(){
		return $this->correo;
	}
	public function getUsuario(){
		return new Usuario($this->correo);
	}
	public function getTelefono(){
		return $this->telefono;
	}
	public function getCalle(){
		return $this->calle;
	}
	public function getNumero(){
		return $this->numero;
	}
	public function getPisoDepto(){
		return $this->piso_depto;
	}
	public function getDomicilio(){
		return $this->calle.' '.$this->numero.' '.$this->piso_depto;
	}
	public function getEntre(){
		return $this->entre;
	}
	public function getCiudad(){
		return $this->ciudad;
	}
	public function getCP(){
		return $this->cp;
	}
	public function getOtros(){
		return $this->otros;
	}
	

	
}

class Usuario{
	protected $correo,$nombre,$clave,$dni,$fecha_reg;
	
	//constrcutor
	public function __construct($correo){
		$conn = new Conexion();
		$consulta = "SELECT * FROM usuarios WHERE correo='$correo'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$this->correo = $dato['correo'];
				$this->nombre = $dato['nombre'];
				$this->clave = $dato['clave'];
				$this->dni = $dato['dni_cuit'];
				$this->fecha_reg = $dato['fecha_reg'];
				$encontro = true;
			}
		$conn->close();
		if(!$encontro)
			throw new ExceptionExiste('No existe ningún usuario asociado a '.$correo);
    } 
	
	///getters
	public function getCorreo(){
		return $this->correo;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function getClave(){
		return $this->clave;
	}
	public function getDNI(){
		return $this->dni;
	}
	public function getFechaRegistro(){
		return $this->fecha_reg;
	}
	
	//setters
	public function setCorreo($correo){
		$conn = new Conexion();
		$sql = "UPDATE usuarios SET correo='$correo' WHERE correo='$this->correo'";
		if(!($conn->getConexion()->query($sql)))
			throw new ExceptionBD('Error al cambiar correo del usuario.');	
		$conn->close();
	}
	public function setNombre($nombre){
		$conn = new Conexion();
		$sql = "UPDATE usuarios SET nombre='$nombre' WHERE correo='$this->correo'";
		if(!($conn->getConexion()->query($sql)))
			throw new ExceptionBD('Error al cambiar nombre del usuario.');	
		$conn->close();
	}
	public function setDNI($dni){
		$conn = new Conexion();
		$sql = "UPDATE usuarios SET dni_cuit='$dni' WHERE correo='$this->correo'";
		if(!($conn->getConexion()->query($sql)))
			throw new ExceptionBD('Error al cambiar nombre del usuario.');	
		$conn->close();
	}
	public function setClave($clave){
		$conn = new Conexion();
		//$clave = crypt($clave,'motul');
		$sql = "UPDATE usuarios SET clave='$clave' WHERE correo='$this->correo'";
		if(!($conn->getConexion()->query($sql)))
			throw new ExceptionBD('Error al cambiar contraseña.');	
		$conn->close();
	}
	
	//metodos
	public function verificarClave($clave){
		return $this->clave==crypt($clave,'motul');
	}	
	public function getPedido(){
		$conn = new Conexion();
		//primero buscamos el ultimo pedido creado por el cliente
		//$consulta = "SELECT * FROM pedidos,pagos WHERE pedidos.id=pagos.id_pedido AND pedidos.correo='$this->correo' AND pagos.estado='pendiente' ORDER BY pedidos.id DESC LIMIT 1";
		$consulta = "SELECT pe.id as id_pedido, pa.id as id_pago, pe.correo, pe.fecha, pe.hora, pe.terminado, pa.informacion, pa.estado, pa.id_cliente, pa.id_secret
					FROM pedidos as pe LEFT JOIN pagos as pa 
					ON pe.id=pa.id_pedido 
					WHERE pe.correo='$this->correo' AND terminado='0'
					ORDER BY pe.id DESC LIMIT 1";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$id = $dato['id_pedido'];
				$encontro = true;
			}
		$conn->close();
		//si encontramos un pedido, verificamos que no esté pago, si esta pago, no tiene ningun pedido
		if($encontro){
			return new Pedido($id);		
		}else{			
			return $this->crearPedido();
		}
	}	
	//carrito es un array que tiene array con id del producto y cantidad pedida
	public function crearPedido(){
		$conn = new Conexion();
		//insertamos un pedido vacio
		$sql = "INSERT INTO pedidos (fecha,hora,correo) VALUES (now(),now(),'$this->correo')";
		if($conn->getConexion()->query($sql)){
			//obtenemos el id del pedido
			$sql2 = "SELECT MAX(id) AS id FROM pedidos";
			if($resultado = $conn->getConexion()->query($sql2))
				while($dato = $resultado->fetch_assoc()) {
					return new Pedido($dato['id']);
				}
		}else{
			throw ExceptionCarrito('Error al crear el carrito');
		}
		$conn->close();
	}	
	
	public function getDireccion(){
		try{
			return new Direccion($this->correo);
		}catch(ExceptionExiste $e){
			return NULL;
		}
	}
	function getStep(){
		return false;
	}
	public function setDireccion($telefono,$calle,$numero,$piso_depto,$entre,$ciudad,$cp,$otros){
		
		if($this->getDireccion()==NULL){
			$conn = new Conexion();
			$sql = "INSERT INTO direcciones (correo,telefono,calle,numero,entre,piso_depto,ciudad,cp,otros) VALUES ('$this->correo','$telefono','$calle','$numero','$entre','$piso_depto','$ciudad','$cp','$otros')";
			if(!($conn->getConexion()->query($sql)))
				throw new ExceptionBD('Error al cambiar la dirección.'.$conn->getConexion()->error);	
			$conn->close();
		}else{
			$conn = new Conexion();
			$sql = "UPDATE direcciones SET telefono='$telefono',calle='$calle',numero='$numero',piso_depto='$piso_depto',entre='$entre',ciudad='$ciudad',cp='$cp',otros='$otros' WHERE correo='$this->correo'";
			if(!($conn->getConexion()->query($sql)))
				throw new ExceptionBD('Error al cambiar la dirección.'.$conn->getConexion()->error);	
			$conn->close();
		}
	}
	
	function getPedidos($dato=NULL){
		$lista = array();	
		$conn = new Conexion();
		$consulta = "SELECT * FROM pedidos ".$dato." WHERE correo='".$this->correo."' AND terminado='1' ORDER BY fecha DESC, hora DESC";
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$id = $dato['id'];
				array_push($lista,new Pedido($id));
			}
		$conn->close();    
		return $lista;
	}
	
	
	function getNombreUsuario(){
		$may = new Mayorista($this->getCorreo());
		return $may->getUsuario();
	}

	
	
}

class Mayorista extends Usuario{
	protected $usuario, $aprobacion;
	
	//constructor
	public function __construct($correo){
		
		$conn = new Conexion();
		$consulta = "SELECT * FROM mayoristas WHERE correo='$correo' OR usuario='$correo'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()){				
				$this->correo = $dato['correo'];
				$this->usuario = $dato['usuario'];
				$this->aprobacion = $dato['aprobacion'];
				$encontro = true;
			}
		$conn->close();
		if(!$encontro)
			throw new ExceptionExiste('No existe ningún mayorista asociado a '.$correo);		
	
		try{
			parent::__construct($this->correo);
		}catch(ExceptionExiste $e){
			throw new ExceptionExiste($e);
		}
	
	
	} 
	
	//getters
	public function getCUIT(){
		return $this->dni;
	}
	public function getUsuario(){
		return $this->usuario;
	}
	public function getAprobacion(){
		return $this->aprobacion;
	}
	public function estaAprobado(){
		if($this->getAprobacion()==NULL)
			return false;
		else
			return true;
	}
	public function setCUIT($cuit){
		$this->setDNI($cuit);		
	}
	
	public function aprobar(){
		$conn = new Conexion();
		$sql = "UPDATE mayoristas SET aprobacion=now() WHERE correo='$this->correo'";
		if(!($conn->getConexion()->query($sql)))
			throw new ExceptionBD('Error al aprobar mayorista.');	
		$conn->close();
	}
	public function bloquear(){
		$conn = new Conexion();
		$sql = "UPDATE mayoristas SET aprobacion=NULL WHERE correo='$this->correo'";
		if(!($conn->getConexion()->query($sql)))
			throw new ExceptionBD('Error al bloquear mayorista.');	
		$conn->close();
	}
	
	function getPedido(){
		$pedido = parent::getPedido();
		return new PedidoMayorista($pedido->getID());		
	}	
	
	function getStep(){
		return $this->estaAprobado();
	}
	
}




?>