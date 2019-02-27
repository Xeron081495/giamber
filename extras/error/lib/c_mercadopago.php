<?php


class GestorMP{
	public $id_cliente, $id_secret, $access_token;
	
	//constructor
	public function __construct(){
		$conn = new Conexion();
		$consulta = "SELECT * FROM gestorMP ORDER BY id DESC LIMIT 1";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$this->id_cliente = $dato['id_cliente'];
				$this->id_secret = $dato['id_secret'];
				$encontro = true;
			}
		$conn->close();
		if(!$encontro)
			throw new ExceptionExiste('No existe ningún gestot asociado.');
	}
	
	//metodos
	/** Retorna una pago si es que existe */ 
	/** Usa ExceptionExiste */ 
	public function getPago($id_pedido){
		try{
			return new Pago($id_pedido,$this);
		}catch(ExceptionExiste $e){
			return null;
		}
	}	
	
	/** Crea un nuevo pago con el id de mp, correo del usuario y la informacion de la operacion */
	/** Usa ExceptionCrear */
	public function crearPago($id_pedido,$correo,$informacion,$estado){
		if($this->getPago($id_pedido)==null){					
			$conn = new Conexion();
			$sql = "INSERT INTO pagos (id_pedido,correo,informacion,id_cliente,id_secret,estado) VALUES ('$id_pedido','$correo','$informacion','$this->id_cliente','$this->id_secret','$estado')";
			if(!($conn->getConexion()->query($sql))){
				throw new ExceptionCrear('Error al crear el pago.'.$conn->getConexion()->error);	
			}else{
				return new Pago($id_pedido,$this);		
			}
		}else
			throw new ExceptionExiste('Ya existe un pago con esta identificación');	
	}
	
	
	//getters
	public function getIDCliente(){
		return $this->id_cliente;
	}
	public function getIDSecret(){
		return $this->id_cliente;
	}
	public function getAccessToken(){
		return $this->access_token;
	}
}


class Pago{
	protected $id, $id_pedido, $correo, $informacion, $estado, $id_client, $id_secret;
	
	//constructor   
	/** Usa ExceptionExiste */
    public function __construct($id_pedido){ 
		$conn = new Conexion();
		$consulta = "SELECT * FROM pagos WHERE id_pedido='$id_pedido'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$this->id = $dato['id'];
				$this->id_pedido = $dato['id_pedido'];
				$this->correo = $dato['correo'];
				$this->informacion = json_decode($dato['informacion']);
				$this->estado = $dato['estado'];
				$this->id_client = $dato['id_cliente'];
				$this->id_secret = $dato['id_secret'];
				$encontro = true;
			}
		$conn->close();
		if(!$encontro)
			throw new ExceptionExiste('No existe ningún pago asociado a '.$id_pedido);
    } 
	
	//metodos	
	/** Verifica si el pago asociado a $id_pedido tiene la totalidad de su pago hecho */
	public function completoPago(){
		$mp = new MP($this->id_client, $this->id_secret);			
		$filters = array (
			"status" => "approved",
			"operation_type" => "regular_payment",
			"range" => "date_created",
			"begin_date" => "NOW-1MONTH",
			"end_date" => "NOW",
			"external_reference" => "".$this->id_pedido
		);
		$search_result = $mp->search_payment($filters);
		
		//si es mayor a 0 está pago, si es igual a 0 no está pago
		return $search_result['response']['paging']['total']>0;
	}
	
	/** actualiza la informacion del pago asociado a  $id_pedido. También modifica el estado a pago si ya se realizo todo su pago. */
	/** Usa ExceptionBD */
	public function actualizar($info){	
		$info = json_encode($info);	
		$conn = new Conexion();
		//vemos si el pago está o no completo
		if($this->completoPago())	
			$estado = 'pago';
		else
			$estado = 'pendiente';			
		// ejecutar consulta en mysql
		$sql = "UPDATE pagos SET info='$info', estado='$estado' WHERE id_operacion='$this->id_pedido'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al cambiar estado del pago.');	
		}
		$conn->close();
	}

	
	//getters
	public function getID(){
		return $this->id;
	}
	public function getIDPedido(){
		return $this->id_pedido;
	}
	public function getUsuario(){
		return new Cliente($correo);
	}
	public function getInformacion(){
		return $this->informacion;
	}
	public function getEstado(){
		return $this->estado;
	}
	public function getIDCliente(){
		return $this->id_client;
	}
	public function getIDSecret(){
		return $this->id_secret;
	}
	
}


class Pedido{
	protected $id, $fecha, $hora, $correo, $nevio, $confirmado, $entregado, $rechazado;

	//constrcutor
	public function __construct($id){
		$conn = new Conexion();
		$consulta = "SELECT * FROM pedidos WHERE id='$id'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$this->correo = $dato['correo'];
				$this->id = $dato['id'];
				$this->fecha = $dato['fecha'];
				$this->hora = $dato['hora'];
				$this->confirmado = $dato['confirmado'];
				$this->envio = $dato['envio'];
				$this->entregado = $dato['entregado'];
				$this->rechazado = $dato['rechazado'];
				$encontro = true;
			}
		$conn->close();
		if(!$encontro)
			throw new ExceptionExiste('No existe ningún pedido asociado a '.$id);
    } 
	
	//getters
	public function getID(){
		return $this->id;
	}
	public function getFecha(){
		return $this->fecha;
	}
	public function getHora(){
		return $this->hora;
	}
	public function getFechaHora(){
		return date_format(date_create($this->fecha),'d-m-Y').' ('.date_format(date_create($this->hora),'H:i').')';
	}
	public function getUsuario(){
		return new Usuario($this->correo);
	}
	public function estaEntregado(){
		return $this->entregado>0;
	}
	public function estaConfirmado(){
		return $this->confirmado>0;
	}
	public function estaRechazado(){
		return $this->rechazado>0;
	}
	public function getConfirmado(){
		if($this->estaRechazado()>0)
			return "Rechazado";
		elseif($this->confirmado==0)
			return 'Sin confirmar';
		elseif($this->confirmado==1)
			return 'Confirmado';
		elseif($this->confirmado==2)
			return 'Confirmado Parc.';
		elseif($this->confirmado==3)
			return 'Pedido aplazado';
		elseif($this->confirmado<0)
			return 'Rechazado';
	}
	public function estaTerminado(){
		return $this->envio>0;
	}
	public function getProductos(){
		$productos = array();
		$conn = new Conexion();
		$consulta = "SELECT * FROM contiene WHERE id_pedido='$id'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$prod = new Producto($dato['id_producto']);
				$precio_final = $prod->getPrecio()*$dato['cantidad'];
				$producto = array(
						"producto" => $prod,
						"cantidad" => $dato['cantidad'],
						"precio_final" => $precio_final
				);
				array_push($productos,$producto);
			}
		$conn->close();
		return $productos;
	}
	public function getArticulos(){
		$pedidos = array();
		$conn = new Conexion();
		$consulta = "SELECT * FROM contiene WHERE id_pedido='$this->id'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$variedad = new Variedad($dato['id_variedad']);
				$precio_final = $variedad->getPrecioUnidad()*$dato['cantidad'];
				$pedido = array(
						"variedad" => $variedad,
						"cantidad" => $dato['cantidad'],
						"precio_final" => $precio_final
				);
				array_push($pedidos,$pedido);
			}
		$conn->close();
		return $pedidos;
	}
	
	public function getCantidadVariedad($var){
		$conn = new Conexion();
		$consulta = "SELECT * FROM contiene WHERE id_pedido='$this->id' AND id_variedad='$var'";
		$cantidad = 0;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$cantidad = $dato['cantidad'];
			}
		$conn->close();
		return $cantidad;
	}
	
	
	public function actualizarStock(){
		foreach($this->getArticulos() as $art){
			//$art['variedad']->actualizarStock($art['cantidad']);
		}
	}
	
	public function verificarCantidades(){
		foreach($this->getArticulos() as $art){
			if($art['variedad']->getStock()<$art['cantidad'])
				return false;
			else
				if($this->getUsuario()->getStep() && ($art['cantidad']%$art['variedad']->getCantidadMayorista())==0){
					return false;
				}
		}
		return true;
	}
	
	public function getPrecioTotal(){
		$pedido = $this->getArticulos();
		$suma = 0;
		foreach($pedido as $p){
			$valor = $p['precio_final'];
			$suma= $suma+ $valor;
		}
		return $suma;
	}
	
	public function eliminarVariedad($variedad){
		$conn = new Conexion();
		$sql = "DELETE FROM contiene WHERE id_variedad='".$variedad."' AND id_pedido='".$this->getID()."'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionCarrito('El producto no se encuentra en el carrito.');
		}		
	}	
	public function agregarVariedad($variedad,$cantidad){
		$conn = new Conexion();
		//insertamos un pedido vacio
		$v = new Variedad($variedad);			
		
		$sql = "INSERT INTO contiene (id_pedido,id_variedad,cantidad) VALUES ('$this->id','$variedad','$cantidad')";
		if(!($conn->getConexion()->query($sql))){
			if($conn->getConexion()->errno==1062){
				$sql = "UPDATE contiene SET cantidad='$cantidad' WHERE id_pedido='$this->id' AND id_variedad='$variedad'";
				if(!($conn->getConexion()->query($sql))){
					throw new ExceptionBD('Error al modificar cantidad del producto');					
				}
			}else			
				throw new ExceptionCarrito('Error al agregar producto al carrito');
		}
	} 
	
	
	public function setEnvio($envio){
		$conn = new Conexion();
		$sql = "UPDATE pedidos SET envio='$envio' WHERE id='$this->id' AND correo='$this->correo'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al editar. Error: ('.$conn->getConexion()->error.')');	
		}
		$conn->close();
	}
	
	//0: no confirmado
	//1: confirmado
	//2: confirmado parcialmente
	//3: aplazado
	public function setConfirmado($n){
		$conn = new Conexion();
		$sql = "UPDATE pedidos SET confirmado='$n' WHERE id='$this->id' AND correo='$this->correo'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al editar. Error: ('.$conn->getConexion()->error.')');	
		}
		$conn->close();
		$this->setRechazado(0);
	}
	
	public function setRechazado($n){
		$conn = new Conexion();
		$sql = "UPDATE pedidos SET rechazado='$n' WHERE id='$this->id' AND correo='$this->correo'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al editar. Error: ('.$conn->getConexion()->error.')');	
		}
		$conn->close();
	}
	
	public function setEntregado($n){
		$conn = new Conexion();
		$sql = "UPDATE pedidos SET entregado='$n' WHERE id='$this->id' AND correo='$this->correo'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al editar. Error: ('.$conn->getConexion()->error.')');	
		}
		$conn->close();
	}
	
	
	public function getPago(){
		try{
			return new Pago($this->getID());
		}catch(ExceptionExiste $e){
			return null;
		}	
	}
	
	public function getEstado(){
		if($this->getPago()==NULL){ 
			$pago = "Sin confirmar";			
		}elseif($this->getPago()->getEstado()=="efectivo") 
			$pago = "Efectivo"; 
		else 
			$pago = "Pago pendiente";
		
		return "Mayorista"; //
	}
	
}


class PedidoMayorista extends Pedido{

	//constrcutor
	public function __construct($id){		
		parent::__construct($id);
    } 

	public function getArticulos(){
		$pedidos = array();
		$conn = new Conexion();
		$consulta = "SELECT * FROM contiene WHERE id_pedido='$this->id'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$variedad = new Variedad($dato['id_variedad']);
				$precio_final = $variedad->getPrecioMayorista()*$dato['cantidad'];
				$pedido = array(
						"variedad" => $variedad,
						"cantidad" => $dato['cantidad'],
						"precio_final" => $precio_final
				);
				array_push($pedidos,$pedido);
			}
		$conn->close();
		return $pedidos;
	}
	
	
}


?>