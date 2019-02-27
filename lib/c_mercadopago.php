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
		return new Cliente($this->correo);
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
	protected $id, $fecha, $hora, $usuario, $terminado, $enviado, $confirmado, $pagado, $entregado, $rechazado, $aplazado, $factura;

	//constructor
	public function __construct($id){
		$conn = new Conexion();
		$consulta = "SELECT * FROM pedidos WHERE id='$id'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$this->id = $dato['id'];
				$this->fecha = $dato['fecha'];
				$this->hora = $dato['hora'];
				$this->usuario = new Usuario($dato['correo']);
				$this->confirmado = ($dato['confirmado']>0);
				$this->entregado = ($dato['entregado']>0);
				$this->rechazado = ($dato['rechazado']>0);
				$this->pagado = ($dato['pagado']>0);
				$this->terminado = ($dato['terminado']>0);
				$this->factura = ($dato['factura']>0);

				if($dato['aplazado']!=NULL) {
					$this->aplazado = new Pedido($dato['aplazado']);
				}else {
					$this->aplazado = NULL;
				}
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
		return $this->usuario;
	}
	public function estaConfirmado(){
		return $this->confirmado;
	}
	public function estaEntregado(){
		return $this->entregado;
	}
	public function estaRechazado(){
		return $this->rechazado;
	}
	public function estaTerminado(){
		return $this->terminado;
	}
	public function estaFactura(){
		return $this->factura;
	}
	public function estaPagado(){
		return $this->pagado;
	}
	public function getPedidoAplazado(){
		return $this->aplazado;
	}
	public function getEstado(){
		if($this->estaRechazado())
			return "Rechazado";
		elseif($this->estaConfirmado())
			return 'Confirmado';
		elseif(!$this->estaConfirmado())
			return 'A confirmar';
		elseif($this->getPedidoAplazado()!=NULL)
			return 'A conf. (Aplazado)';
	}
	public function getPago(){
		try{
			return new Pago($this->getID());
		}catch(ExceptionExiste $e){
			return null;
		}
	}

	//setters
	public function setConfirmado(){
		$conn = new Conexion();
		$sql = "UPDATE pedidos SET confirmado='1' WHERE id='$this->id' AND correo='".$this->getUsuario()->getCorreo()."'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al confirmar pedido. Error: ('.$conn->getConexion()->error.')');
		}
		$conn->close();
	}
	public function setEntregado(){
		$conn = new Conexion();
		$sql = "UPDATE pedidos SET entregado='1' WHERE id='$this->id' AND correo='".$this->getUsuario()->getCorreo()."'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al poner entregado. Error: ('.$conn->getConexion()->error.')');
		}
		$conn->close();
	}
	public function setRechazado(){
		$conn = new Conexion();
		$sql = "UPDATE pedidos SET rechazado='1' WHERE id='$this->id' AND correo='".$this->getUsuario()->getCorreo()."'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al poner rechazado. Error: ('.$conn->getConexion()->error.')');
		}
		$conn->close();
	}
	public function setTerminado(){
		$conn = new Conexion();
		$sql = "UPDATE pedidos SET terminado='1' WHERE id='$this->id' AND correo='".$this->getUsuario()->getCorreo()."'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al tildar como terminado. Error: ('.$conn->getConexion()->error.')');
		}
		$conn->close();
	}
	public function setPagado(){
		$conn = new Conexion();
		$sql = "UPDATE pedidos SET pagado='1' WHERE id='$this->id' AND correo='".$this->getUsuario()->getCorreo()."'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al tildar como pagado. Error: ('.$conn->getConexion()->error.')');
		}
		$conn->close();
	}
	public function setFactura($factura){

		//subir archivo
		$this->subirFactura($factura);

		//dejar constancia en mysql
		$conn = new Conexion();
		$sql = "UPDATE pedidos SET factura='1' WHERE id='$this->id' AND correo='".$this->getUsuario()->getCorreo()."'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al tildar enviada la factura. Error: ('.$conn->getConexion()->error.')');
		}
		$conn->close();
	}

	private function subirFactura($pdf){
		if($pdf["error"]>0)
			return NULL;
		else{
			$ruta = '../../facturas/'.$this->getID().'.pdf';
			$resultado = move_uploaded_file($pdf['tmp_name'], $ruta);
			if($resultado){
				return $this->getID().'.pdf';
			}else
				throw new Exception('¡Error al subir la factura!');
		}
		return "Nombre";
	}


	public function setPedidoAplazado($id_pedido){
		$conn = new Conexion();
		$sql = "UPDATE pedidos SET aplazado='".$id_pedido."' WHERE id='$this->id' AND correo='".$this->getUsuario()->getCorreo()."'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al tildar como terminado. Error: ('.$conn->getConexion()->error.')');
		}
		$conn->close();
	}

	/* Retorna un arreglo de articulos del pedidos de la forma [variedad,cantidad,precio_final] */
	public function getArticulos(){
		$pedidos = array();
		$conn = new Conexion();
		$consulta = "SELECT * FROM contiene WHERE id_pedido='$this->id'";
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$variedad = new Variedad($dato['id_variedad']);
				$pedido = array(
					"variedad" => $variedad,
					"cantidad" => $dato['cantidad'],
					"precio_final" => $dato['precio']*$dato['cantidad']
				);
				array_push($pedidos,$pedido);
			}
		$conn->close();
		return $pedidos;
	}

	/*Retorna cuantos items tiene una variedad en el pedido*/
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

	/* Actualiza el stock de todas las variedades del pedido */
	public function actualizarStock(){
		foreach($this->getArticulos() as $art){
			//$art['variedad']->actualizarStock($art['cantidad']);
		}
	}

	/* Reestablece el stock si ya fue actualizado */
	public function reestablecerStock(){
		foreach($this->getArticulos() as $art){
			//$art['variedad']->actualizarStock(-$art['cantidad']);
		}
	}

	/* Verificar si hay stock de todos los productos*/
	public function verificarCantidades(){
		/*foreach($this->getArticulos() as $art){
			if($art['variedad']->getStock()<$art['cantidad'])
				return false;
			else
				if($this->getUsuario()->getStep() && ($art['cantidad']%$art['variedad']->getCantidadMayorista())==0){
					return false;
				}
		}*/
		return true;
	}
	/* Retorna el precio total del pedido*/
	public function getPrecioTotal(){
		$pedido = $this->getArticulos();
		$suma = 0;
		foreach($pedido as $p){
			$valor = $p['precio_final'];
			$suma= $suma+ $valor;
		}
		return $suma;
	}

	/* Elimina una variedad del pedido */
	public function eliminarVariedad($variedad){
		$conn = new Conexion();
		$sql = "DELETE FROM contiene WHERE id_variedad='".$variedad."' AND id_pedido='".$this->getID()."'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionCarrito('El producto no se encuentra en el carrito.');
		}
	}

	/* Agregar variedad al carrito*/
	public function agregarVariedad($variedad,$cantidad){
		$conn = new Conexion();
		//insertamos un pedido vacio
		$v = new Variedad($variedad);

		//si hay al menos un item de la variedad, se actualzia la cantidad, sino, se agrega al pedido
		if($this->getCantidadVariedad($v->getID())>0){
			$sql = "UPDATE contiene SET cantidad='$cantidad', precio='".$v->getPrecioMayoristaNeto()."' WHERE id_pedido='$this->id' AND id_variedad='$variedad'";
			if(!($conn->getConexion()->query($sql))){
				throw new ExceptionBD('Error al modificar cantidad del producto ('.$conn->getConexion()->error.')');
			}
		}else{
			$sql = "INSERT INTO contiene (id_pedido,id_variedad,cantidad,precio) VALUES ('$this->id','".$v->getID()."','$cantidad','".$v->getPrecioMayoristaNeto()."')";
			if(!($conn->getConexion()->query($sql))){
				throw new ExceptionCarrito('Error al agregar producto al carrito  ('.$conn->getConexion()->error.')');
			}
		}
	}

	/*Actualiza los precios del pedido*/
	public function actualizarPrecios()	{
		$conn = new Conexion();
		foreach ($this->getArticulos() as $variedad) {
			$v = $variedad['variedad'];
			$sql = "UPDATE contiene SET precio='" . $v->getPrecioMayoristaNeto() . "' WHERE id_pedido='$this->id' AND id_variedad='".$v->getID()."'";
			if (!($conn->getConexion()->query($sql))) {
				throw new ExceptionBD('Error al modificar cantidad del producto ' . $conn->getConexion()->error);
			}
		}
	}




}


class PedidoMayorista extends Pedido{

	//constrcutor
	public function __construct($id){		
		parent::__construct($id);
    }/*

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
					"precio_final" => $dato['precio']*$dato['cantidad']
				);
				array_push($pedidos,$pedido);
			}
		$conn->close();
		return $pedidos;
	}

	public function agregarVariedad($variedad,$cantidad){
		$conn = new Conexion();
		//insertamos un pedido vacio
		$v = new Variedad($variedad);

		$sql = "INSERT INTO contiene (id_pedido,id_variedad,cantidad,precio) VALUES ('$this->id','$variedad','$cantidad','".$v->getPrecioMayoristaNeto()."')";
		if(!($conn->getConexion()->query($sql))){
			if($conn->getConexion()->errno==1062){
				$sql = "UPDATE contiene SET cantidad='$cantidad' WHERE id_pedido='$this->id' AND id_variedad='$variedad'";
				if(!($conn->getConexion()->query($sql))){
					throw new ExceptionBD('Error al modificar cantidad del producto');
				}
			}else
				throw new ExceptionCarrito('Error al agregar producto al carrito');
		}
	}*/

}


?>