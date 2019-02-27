<?php 


class Conexion{
	//atributos
	private $conexion, $servidor, $usuario, $clave, $db;
	
	//constructor
	public function __construct(){
		//crear variables
		$this->servidor = 'localhost';
		$this->usuario = 'giamber_user';
		$this->clave = 'lubricantes1520';
		$this->db = 'giamber_bd';
		
		// Create connection
		$this->conexion = new mysqli($this->servidor,$this->usuario,$this->clave,$this->db);
		
		// Check connection
		if ($this->conexion->connect_error){
			$this->conectado = false;
			$this->error = "Connection failed: ".$this->conexion->connect_error;				
		}else{
			$this->conectado = true;	
		}
	}
	
	
	//metodos
	
	/** Destructor */
	public function close(){
		$this->conexion->close();
	}	
	
	/** True si esta conectadom, false si no está conectado */
	public function estaConectado(){
		return !$this->conexion->connect_error;
	}
	
	//getters
	public function getServidor(){
		return $this->servidor;
	}
	public function getUsuario(){
		return $this->usuario;
	}
	public function getBD(){
		return $this->db;
	}
	public function getPass(){
		return $this->clave;
	}
	public function getConexion(){
		if(!$this->conexion->connect_error)
			return $this->conexion;
		else
			throw new ExceptionDB('Error al conectar a la Base de datos');	
	}	
	
}

?>