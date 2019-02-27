<?php 
class Producto{
	private $id, $nombre,$precio, $imagen, $aplicacion, $tipo, $envase, $gama;
	private $video, $ficha_pdf, $stock, $fecha, $categoria, $modelo, $descripcion, $visible;	
	
	//constructor
	public function __construct($id){
		$conn = new Conexion();
		$consulta = "SELECT * FROM productos WHERE id='$id'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$this->id = $dato['id'];
				$this->nombre = $dato['nombre'];
				$this->imagen = $dato['imagen'];
				$this->aplicacion = $dato['aplicacion'];
				$this->tipo = $dato['tipo'];
				$this->gama = $dato['gama'];
				$this->video = $dato['video'];
				$this->ficha_pdf = $dato['ficha_pdf'];
				$this->fecha = $dato['fecha'];
				$this->categoria = $dato['categoria'];
				$this->descripcion = $dato['descripcion'];
				$this->modelo = $dato['modelo'];
				$this->visible = $dato['visible'];
				$encontro = true;
			}
		$conn->close();
		if(!$encontro)
			throw new ExceptionExiste('No existe ningún producto asociado a '.$id);
    } 
	
	//setters
	public function set($nombre,$categoria,$aplicacion,$tipo,$gama,$video,$modelo,$descripcion){
		$conn = new Conexion();
		$sql = "UPDATE productos SET nombre='$nombre',categoria='$categoria',aplicacion='$aplicacion',tipo='$tipo',gama='$gama',video='$video',modelo='$modelo',descripcion='$descripcion' WHERE id='$this->id'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al editar. Error: ('.$conn->getConexion()->error.')');	
		}
		$conn->close();
	}
	
	function eliminarVariedad($id){	
		$conn = new Conexion();
		$sql = "UPDATE variedades SET visible=0 WHERE id='$id'";

		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD($conn->getConexion()->error);
		}
	}
	
	
	//getters
	public function getFecha(){
		$date = date_create($this->fecha);
		return date_format($date, 'd-m-Y H:i:s');
	}
	public function getCategoria(){
		return new Categoria($this->categoria);
	}
	public function getVideo(){
		if(empty($this->video)) 
			return NULL;
		elseif($this->getYouTubeIdFromURL($this->video)) 
			return $this->getYouTubeIdFromURL($this->video);
		else
			return NULL;
	}
	
	
	private function getYouTubeIdFromURL($url){
		
	  $url_string = parse_url($url, PHP_URL_QUERY);
	  parse_str($url_string, $args);
	  return isset($args['v']) ? $args['v'] : false;
	}
	
	public function getFichaPDF(){
		if(empty($this->ficha_pdf)) return NULL;
		else return $this->ficha_pdf;
	}
	public function getGama(){
		if(empty($this->gama)) return NULL;
		else return $this->gama;
	}
	public function getID(){
		return $this->id;
	}
	public function getNombre(){
		if(empty($this->nombre)) return NULL;
		else return $this->nombre;
	}
	public function getImagen(){
		return $this->imagen;
	}
	public function getAplicacion(){
		if(empty($this->aplicacion)) return NULL;
		else return $this->aplicacion;
	}
	public function getTipo(){
		if(empty($this->tipo)) return NULL;
		else return $this->tipo;
	}	
	public function getModelo(){
		if(empty($this->modelo)) return NULL;
		else return $this->modelo;
	}			
	public function getDescripcion(){
		if(empty($this->descripcion)) return NULL;
		else return $this->descripcion;
	}				
	public function getVisible(){
		if($this->visible==0) return false;
		else return true;
	}	
	public function getVariedades(){
		$conn = new Conexion();
		$lista = array();
		$consulta = "SELECT * FROM variedades WHERE id_producto='$this->id' AND visible>0";
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				array_push($lista,new Variedad($dato['id']));
			}
		return $lista;
	}	
	public function getVariedadesTodas(){
		$conn = new Conexion();
		$lista = array();
		$consulta = "SELECT * FROM variedades WHERE id_producto='$this->id'";
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				array_push($lista,new Variedad($dato['id']));
			}
		return $lista;
	}
	function agregarVariedad($envase,$precio_unidad,$cantidad_mayorista,$precio_mayorista,$stock){
	
		$conn = new Conexion();
		$sql = "INSERT INTO variedades (id,id_producto,envase,precio_unidad,cantidad_mayorista,precio_mayorista,stock) 
				VALUES (NULL,$this->id,'$envase','$precio_unidad','$cantidad_mayorista','$precio_mayorista','$stock');";

		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD($conn->getConexion()->error);
		}
	}
	
	function setImagen($imagen){
		
		$nombre_imagen = subirImagen($imagen);
		
		$conn = new Conexion();
		$sql = "UPDATE productos SET imagen='$nombre_imagen' WHERE id='$this->id'";

		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD($conn->getConexion()->error);
		}		
	}
	
	function setPDF($imagen){
		
		$nombre_pdf = subirPDF($imagen);
		
		$conn = new Conexion();
		$sql = "UPDATE productos SET ficha_pdf='$nombre_pdf' WHERE id='$this->id'";

		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD($conn->getConexion()->error);
		}		
	}

	
	
}


class Variedad{
	private $id,$id_producto,$envase,$precio_unidad,$cantidad_mayorista,$precio_mayorista,$stock,$visible;
	
	//constructor
	public function __construct($id){
		$conn = new Conexion();
		$consulta = "SELECT * FROM variedades WHERE id='$id'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$this->id = $dato['id'];
				$this->id_producto = $dato['id_producto'];
				$this->envase = $dato['envase'];
				$this->precio_unidad = $dato['precio_unidad'];
				$this->cantidad_mayorista = $dato['cantidad_mayorista'];
				$this->precio_mayorista = $dato['precio_mayorista'];
				$this->stock = $dato['stock'];
				$this->visible = $dato['visible'];
				$encontro = true;
			}
		$conn->close();
		if(!$encontro)
			throw new ExceptionExiste('No existe ninguna variedad asociado a '.$id);
    } 
	
				
	public function getID(){
		return $this->id;
	}				
	public function getEnvase(){
		return $this->envase;
	}			
	public function getProducto(){
		return new Producto($this->id_producto);
	}			
	public function getPrecioUnidad(){
		return number_format($this->precio_unidad,2,'.','');
	}			
	public function getCantidadMayorista(){
		return $this->cantidad_mayorista;
	}			
	public function getPrecioMayorista(){
		return number_format($this->precio_mayorista,2,'.','');
	}			
	public function getStock(){
		return $this->stock;
	}			
	public function getVisible(){
		if($this->visible==0) return false;
		else return true;
	}		
	public function set($envase,$precio_unidad,$cantidad_mayorista,$precio_mayorista,$stock){
		$conn = new Conexion();
		$sql = "UPDATE variedades SET envase='$envase',precio_unidad='$precio_unidad',cantidad_mayorista='$cantidad_mayorista',precio_mayorista='$precio_mayorista',stock='$stock' WHERE id='$this->id'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al editar. Error: ('.$conn->getConexion()->error.')');	
		}
		$conn->close();
	}	
	public function actualizarStock($n){
		$conn = new Conexion();
		$stock=$this->getStock()-$n;
		if($stock<0) $stock = 0;		
		$sql = "UPDATE variedades SET stock='$stock' WHERE id='$this->id'";
		if(!($conn->getConexion()->query($sql))){
			throw new ExceptionBD('Error al editar stock. Error: ('.$conn->getConexion()->error.')');	
		}
		$conn->close();
	}
	
	
	
	
	
	
	
}


class Categoria{
	private $nombre, $imagen, $descripcion;
	
	//constructor
	public function __construct($nombre){
		$conn = new Conexion();
		$consulta = "SELECT * FROM categorias WHERE nombre='$nombre'";
		$encontro = false;
		if($resultado = $conn->getConexion()->query($consulta))
			while($dato = $resultado->fetch_assoc()) {
				$this->nombre = $dato['nombre'];
				$this->imagen = $dato['imagen'];
				$this->descripcion = $dato['descripcion'];
				$encontro = true;
			}
		$conn->close();
		if(!$encontro)
			throw new ExceptionExiste('No existe ninguna categoria asociado a '.$nombre);
    } 
	
	
	public function getNombre(){
		return $this->nombre;
	}
	public function getImagen(){
		return $this->imagen;
	}
	public function getDescripcion(){
		return $this->descripcion;
	}
}


?>