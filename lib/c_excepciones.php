<?php

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

/** No hay stock */
class ExceptionStock extends Exception{
	public function __construct($message){
		 parent::__construct($message);
	}
}

/** No hay stock */
class ExceptionCarrito extends Exception{
	public function __construct($message){
		 parent::__construct($message);
	}
}
 
 
?>