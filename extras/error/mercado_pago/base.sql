/*
gestorMP(id_cliente*,id_secret*)

pagos (id*,informacion,estado,id_cliente,id_secret,id_pedido,correo)
FK id_cliente,id_secret referencian a GestorMP(id_cliente,id_secret)
FK correo referencia a Usuario(correo)
FK id_pedido referencia a Pedido(id)

Pedido (id*,fecha,hora,correo)
FK correo referencia a Usuario(correo)

Usuario (correo*,nombre,dni,clave)

Cliente (correo*, descuento)
FK correo referencia a Usuario(correo)

Producto (id*,precio,nombre,imagen,descripcion,stock,fecha,categoria)
FK nombre_marca referencia a categorias(nombre)

categorias (nombre*,imagen,descripcion)

Contiene (id_producto*,id_pedido*,cantidad)
FK id_producto referencia a Producto(id)
FK id_pedido referencia a Pedido(id)


*/

CREATE TABLE gestorMP (
 id_cliente TEXT NOT NULL, 
 id_secret TEXT NOT NULL, 
 
 CONSTRAINT pk_GestorMP
 PRIMARY KEY (id_cliente,id_secret)
 
) ENGINE=InnoDB;



CREATE TABLE pagos (
 id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL, 
 id_pedido INT(25) UNSIGNED NOT NULL, 
 correo VARCHAR(45) NOT NULL, 
 informacion TEXT NOT NULL, 
 estado VARCHAR(10), 
 id_cliente TEXT NOT NULL, 
 id_secret TEXT NOT NULL, 
 
 CONSTRAINT pk_pagos
 PRIMARY KEY (id),
 
 FOREIGN KEY (correo) REFERENCES usuarios (correo)
 ON DELETE RESTRICT ON UPDATE CASCADE,
 
 FOREIGN KEY (id_pedido) REFERENCES pedidos (id)
 ON DELETE RESTRICT ON UPDATE CASCADE,

 FOREIGN KEY (id_cliente,id_secret) REFERENCES gestorMP (id_cliente,id_secret)
 ON DELETE RESTRICT ON UPDATE CASCADE   
 
) ENGINE=InnoDB;
 
 
CREATE TABLE pedidos (
 id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL, 
 fecha DATE NOT NULL,
 hora TIME NOT NULL,
 correo VARCHAR(45) NOT NULL, 
 
 CONSTRAINT pk_pedidos
 PRIMARY KEY (id),
 
 FOREIGN KEY (correo) REFERENCES usuarios (correo)
 ON DELETE RESTRICT ON UPDATE CASCADE
 
) ENGINE=InnoDB;
 

CREATE TABLE usuarios (
 correo VARCHAR(45) NOT NULL,
 nombre TEXT NOT NULL,
 clave TEXT NOT NULL,
 dni INT(10) NOT NULL,
	
 CONSTRAINT pk_usuarios
 PRIMARY KEY (correo),	
	
) ENGINE=InnoDB;
 
 
CREATE TABLE productos (
 id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
 nombre TEXT NOT NULL,
 precio INT(8) NOT NULL,
	
 CONSTRAINT pk_productos
 PRIMARY KEY (id),	
	
) ENGINE=InnoDB;
 
 
CREATE TABLE contiene (
 id_pedido INT(11) UNSIGNED NOT NULL,
 id_producto INT(11) UNSIGNED NOT NULL,
 cantidad INT(8) NOT NULL,
	
 CONSTRAINT pk_contiene
 PRIMARY KEY (id_pedido,id_producto),	
	
 FOREIGN KEY (id_pedido) REFERENCES pedidos (id)
 ON DELETE RESTRICT ON UPDATE CASCADE,
 
 FOREIGN KEY (id_producto) REFERENCES productos (id)
 ON DELETE RESTRICT ON UPDATE CASCADE
	
) ENGINE=InnoDB;
 