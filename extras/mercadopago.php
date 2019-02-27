<?php

include_once 'conexion.php';
require_once 'mercadopago/lib/mercadopago.php';

class GestorMP{
	public $id_cliente, $id_secret, $access_token;
	
	//constructor
	public function __construct(){
		$this->id_cliente = "4378170849643765";
		$this->id_secret = "1ylsihUNy5H3cUtGQmTidpWBszcdRRec";
		$this->access_token = "TEST-4378170849643765-061411-082e407769eb33b2fa5f6a1277bb1db4__LB_LA__-146597293";
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
	public function crearPago($id_pedido,$correo,$informacion){
		if($this->getPago($id_pedido)==null){					
			$conn = new Conexion();
			$sql = "INSERT INTO pagos (id_operacion,correo,informacion) VALUES ('$id_pedido','$correo','$informacion')";
			if(!($conn->getConexion()->query($sql))){
				throw new ExceptionCrear('Error al crear el pago.');	
			}else
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
	protected $id, $id_pedido, $correo, $informacion, $estado, $gestor_mp;
	
	//constructor   
	/** Usa ExceptionExiste */
    public function __construct($id_pedido,$gestor_mp){ 
		$conn = new Conexion();
		$consulta = "SELECT * FROM pagos WHERE id_operacion='$id_pedido'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$this->id = $dato['id'];
				$this->id_pedido = $dato['id_pedido'];
				$this->correo = $dato['correo'];
				$this->informacion = json_decode($dato['informacion']);
				$this->estado = $dato['estado'];
				$this->gestor_mp = $gestor_mp;
				$encontro = true;
			}
		$conn->close();
		if(!$encontre)
			throw new ExceptionExiste('No existe ningún pago asociado a '.$id_pedido);
    } 
	
	//metodos	
	/** Verifica si el pago asociado a $id_pedido tiene la totalidad de su pago hecho */
	public function completoPago(){
		$mp = new MP($this->getGestorMP()->getIDCliente(), $this->getGestorMP()->getIDSecret());			
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
		$conn->close());
	}

	
	//getters
	public function getID(){
		return $this->id;
	}
	public function getIDPedido(){
		return $this->id_pedido;
	}
	public function getCorreo(){
		return $this->correo;
	}
	public function getInformacion(){
		return $this->informacion;
	}
	public function getEstado(){
		return $this->estado;
	}
	private function getGestorMP(){
		return $this->gestor_mp;
	}
	
	
}


/** Excepción al crear/insertar en base de datos */ 
class ExceptionCrear extends Exception{
	public function __construct($message){
		 parent::__construct($message);
	}
}

/** Excepción al buscar un dato que no existe en base de datos */
class ExceptionExiste extends Exception{
	public function __construct($message){
		 parent::__construct($message);
	}
}

/** Error en la base de datos */
class ExceptionBD extends Exception{
	public function __construct($message){
		 parent::__construct($message);
	}
}



?>