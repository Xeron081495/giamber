use giamber_bd; 

#DROP TABLE IF EXISTS contiene;
#DROP TABLE IF EXISTS direcciones;
#DROP TABLE IF EXISTS gestormp;
#DROP TABLE IF EXISTS mayoristas;
#DROP TABLE IF EXISTS mayorista;
#DROP TABLE IF EXISTS pagos;
#DROP TABLE IF EXISTS pedidos;
#DROP TABLE IF EXISTS variedades;
#DROP TABLE IF EXISTS categorias;
#DROP TABLE IF EXISTS productos;
#DROP TABLE IF EXISTS usuarios;
#DROP PROCEDURE IF EXISTS agregarMayorista;


/*
gestorMP(id_cliente*,id_secret*)
*/
CREATE TABLE gestorMP (
 id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
 id_cliente VARCHAR(50) NOT NULL, 
 id_secret VARCHAR(50) NOT NULL, 
 
 CONSTRAINT pk_gestorMP
 PRIMARY KEY (id)
 
) ENGINE=InnoDB;

INSERT INTO gestorMP (id_cliente,id_secret) VALUES ('4378170849643765','1ylsihUNy5H3cUtGQmTidpWBszcdRRec');

CREATE TABLE panel_usuarios(
	correo VARCHAR(45) NOT NULL,
	nombre TEXT NOT NULL,
	usuario VARCHAR(20) NOT NULL,
	clave TEXT,
	tipo INT(1) DEFAULT 1,
	created_at DATETIME DEFAULT now(),
	updated_at DATETIME DEFAULT now(),
		
	CONSTRAINT pk_panel_usuarios
	PRIMARY KEY (correo)	
	
)  ENGINE=InnoDB;

CREATE TABLE panel_usuarios_permisos(
	correo VARCHAR(45) NOT NULL,
	administrador INT(1), DEFAULT 0,
	pedidos_ver_todos INT(1) DEFAULT 0,
	pedidos_crear INT(1) DEFAULT 0,
	pedidos_confirmar INT(1) DEFAULT 0,
	pedidos_descargar INT(1) DEFAULT 0,
	pedidos_rechazar INT(1) DEFAULT 0,
	pedidos_cobrado INT(1) DEFAULT 0,
	pedidos_entregado INT(1) DEFAULT 0,
	productos_ver_todos INT(1) DEFAULT 0,
	pmayoristas INT(1) DEFAULT 0,

	FOREIGN KEY (correo) REFERENCES panel_usuarios (correo)
	ON DELETE CASCADE ON UPDATE CASCADE	
	
)  ENGINE=InnoDB;
/*
Usuario (correo*,nombre,dni,clave)
*//*
CREATE TABLE usuarios (
 correo VARCHAR(45) NOT NULL,
 nombre TEXT NOT NULL,
 clave TEXT,
 dni_cuit TEXT,
 fecha_reg DATETIME NOT NULL,
	
 CONSTRAINT pk_usuarios
 PRIMARY KEY (correo)	
	
) ENGINE=InnoDB;
*/
/*
Mayoristas (correo*, usuario,aprobado,)
FK correo referencia a Usuario(correo)
*//*
CREATE TABLE mayoristas(
 correo VARCHAR(45) NOT NULL,
 usuario TEXT,
 aprobacion DATETIME,
	
 CONSTRAINT pk_mayorista
 PRIMARY KEY (correo),
 
 FOREIGN KEY (correo) REFERENCES usuarios (correo)
 ON DELETE CASCADE ON UPDATE CASCADE	
	
) ENGINE=InnoDB;
*/

/*
Direcciones (correo*,telefono,calle,numero,entre,ciudad,cp,otros)
FK correo referencia a Usuario(correo)
*/
/*
CREATE TABLE direcciones (
 correo VARCHAR(45) NOT NULL,
 telefono VARCHAR(45),
 calle VARCHAR(45),
 numero INT(7),
 entre VARCHAR(80),
 piso_depto VARCHAR(80),
 ciudad VARCHAR(45),
 cp VARCHAR(10),
 otros TEXT,
	
 CONSTRAINT pk_direcciones
 PRIMARY KEY (correo),
 
 FOREIGN KEY (correo) REFERENCES usuarios (correo)
 ON DELETE RESTRICT ON UPDATE CASCADE	
	
) ENGINE=InnoDB;
*/



/*
categorias (nombre*,imagen,descripcion)
*/
/*
CREATE TABLE categorias (
 nombre VARCHAR(15) NOT NULL,
 imagen TEXT NOT NULL,
 descripcion TEXT,
	
 CONSTRAINT pk_categorias
 PRIMARY KEY (nombre)	
	
) ENGINE=InnoDB;
 */
/*insertamos 3 marcas*/
/*
INSERT INTO categorias VALUES ('Motul','img/motul.png','No hay descripción');
INSERT INTO categorias VALUES ('Meguiars','img/meguiars.png','No hay descripción');
INSERT INTO categorias VALUES ('Sonax','img/sonax.png','No hay descripción');
*/
 
 
/*
Producto (id*,correo,precio,nombre,imagen,aplicacion,tipo,envase,gama,video,ficha_pdf,stock,fecha,categoria)
FK nombre_marca referencia a categorias(nombre)
*/ 
/*
CREATE TABLE productos (
 id INT(11) UNSIGNED NOT NULL,
 nombre TEXT NOT NULL,
 imagen TEXT NOT NULL,
 aplicacion varchar(30),
 tipo varchar(30),
 gama varchar(30),
 video TEXT,
 ficha_pdf TEXT,
 modelo VARCHAR(45),
 descripcion TEXT,
 fecha DATETIME NOT NULL,
 categoria VARCHAR(15) NOT NULL,
 visible INT(1) DEFAULT 1,
	
 CONSTRAINT pk_productos
 PRIMARY KEY (id),	
 
 FOREIGN KEY (categoria) REFERENCES categorias(nombre)
 ON DELETE RESTRICT ON UPDATE CASCADE
	
) ENGINE=InnoDB;
*/
/*
variedades(id*,id_producto,envase,precio_lista,cantidad_mayorista,precio_mayorista,stock)
FK id_producto referencia a productos(id)
*/ 
/*
CREATE TABLE variedades (
 id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
 id_producto INT(11) UNSIGNED NOT NULL,
 envase varchar(30),
 precio_unidad float,
 cantidad_mayorista int(11),
 precio_mayorista float,
 stock INT(5) NOT NULL, 
 visible INT(1) DEFAULT 1,
	
 CONSTRAINT pk_tipo
 PRIMARY KEY (id),	
 
 FOREIGN KEY (id_producto) REFERENCES productos(id)
 ON DELETE CASCADE ON UPDATE CASCADE
	
) ENGINE=InnoDB;
 
INSERT INTO productos (id, nombre, imagen,aplicacion,tipo,gama,video,ficha_pdf,modelo,descripcion,fecha,categoria) VALUES (1, 'Shampoo Deep Crystal Champoo', 'Nombre', 'VW505.01 - Motores', '100% sintetito', 'Auto', 'https://www.youtube.com/watch?v=ZOF5xLr-cbA', 'http://www.lubricantesrs.com.ar/tecnica/M007.pdf', '54654', 'No hay descripcion\r\n', '2017-10-30 11:18:51', 'Meguiars');
INSERT INTO variedades (id,id_producto,envase,precio_unidad,cantidad_mayorista,precio_mayorista,stock) VALUES (NULL,1,'1 litro',45.20,6,250,100);
INSERT INTO variedades (id,id_producto,envase,precio_unidad,cantidad_mayorista,precio_mayorista,stock) VALUES (NULL,1,'2 litros',85.20,4,450,52);
 
INSERT INTO productos (id, nombre, imagen,aplicacion,tipo,gama,video,ficha_pdf,modelo,descripcion,fecha,categoria) VALUES (2, 'Shampoo Deep Crystal Champoo', 'Nombre', 'VW505.01 - Motores', '100% sintetito', 'Auto', 'https://www.youtube.com/watch?v=ZOF5xLr-cbA', 'http://www.lubricantesrs.com.ar/tecnica/M007.pdf', '54654', 'No hay descripcion\r\n', '2017-10-30 11:18:51', 'Meguiars');
INSERT INTO variedades (id,id_producto,envase,precio_unidad,cantidad_mayorista,precio_mayorista,stock) VALUES (NULL,2,'1 litro',45.20,6,250,100);
INSERT INTO variedades (id,id_producto,envase,precio_unidad,cantidad_mayorista,precio_mayorista,stock) VALUES (NULL,2,'2 litros',85.20,4,450,52);
 */

  
/*Pedido (id*,fecha,hora,correo)
FK correo referencia a Usuario(correo)
*/
CREATE TABLE pedidos (
 id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL, 
 fecha DATE NOT NULL,
 hora TIME NOT NULL,
 envio BOOLEAN,
 correo VARCHAR(45) NOT NULL, 
 entregado INT(1) UNSIGNED DEFAULT 0,
 
 CONSTRAINT pk_pedidos
 PRIMARY KEY (id),
 
 FOREIGN KEY (correo) REFERENCES usuarios (correo)
 ON DELETE RESTRICT ON UPDATE CASCADE
 
) ENGINE=InnoDB; 
 
/*
pagos (id*,informacion,estado,id_cliente,id_secret,id_pedido,correo)
FK id_cliente,id_secret referencian a GestorMP(id_cliente,id_secret)
FK correo referencia a Usuario(correo)
FK id_pedido referencia a Pedido(id)
*/
CREATE TABLE pagos (
 id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL, 
 id_pedido INT(25) UNSIGNED NOT NULL, 
 correo VARCHAR(45) NOT NULL, 
 informacion TEXT NOT NULL, 
 estado VARCHAR(10) DEFAULT 'pendiente', 
 id_cliente VARCHAR(50) NOT NULL, 
 id_secret VARCHAR(50) NOT NULL, 
 
 CONSTRAINT pk_pagos
 PRIMARY KEY (id),
 
 FOREIGN KEY (correo) REFERENCES usuarios (correo)
 ON DELETE RESTRICT ON UPDATE CASCADE,

 /*FOREIGN KEY (cliente,secret) REFERENCES gestorMP(id_cliente,id_secret)
 /*ON DELETE RESTRICT ON UPDATE CASCADE,*/  
 
 FOREIGN KEY (id_pedido) REFERENCES pedidos (id)
 ON DELETE RESTRICT ON UPDATE CASCADE
 
 
) ENGINE=InnoDB;

/*
Contiene (id_producto*,id_pedido*,cantidad)
FK id_producto referencia a Producto(id)
FK id_pedido referencia a Pedido(id)
*/  
CREATE TABLE contiene (
 id_pedido INT(11) UNSIGNED NOT NULL,
 id_variedad INT(11) UNSIGNED NOT NULL,
 cantidad INT(8) NOT NULL,
	
 CONSTRAINT pk_contiene
 PRIMARY KEY (id_pedido,id_variedad),	
	
 FOREIGN KEY (id_pedido) REFERENCES pedidos (id)
 ON DELETE RESTRICT ON UPDATE CASCADE,
 
 FOREIGN KEY (id_variedad) REFERENCES variedades (id)
 ON DELETE RESTRICT ON UPDATE CASCADE
	
) ENGINE=InnoDB;

/*
productos_imagenes (id*, id_producto, nombre, prioridad)
FK id referencia a Producto(id)
*/  
CREATE TABLE productos_imagenes (
 id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
 id_producto INT(11) UNSIGNED NOT NULL,
 nombre TEXT NOT NULL,
 prioridad INT(8) UNSIGNED DEFAULT 100,
	
 CONSTRAINT pk_productos_imagenes
 PRIMARY KEY (id),	
	
 FOREIGN KEY (id_producto) REFERENCES productos(id)
 ON DELETE RESTRICT ON UPDATE CASCADE
	
) ENGINE=InnoDB;


INSERT productos_imagenes SELECT id,imagen FROM productos;
ALTER TABLE `productos` DROP `imagen`;




#Creacion de stored procedures
delimiter !
CREATE PROCEDURE agregarMayorista(IN correo VARCHAR(45), IN nombre TEXT, IN cuit TEXT, IN usuario TEXT, IN clave TEXT)
BEGIN

# Declaro variables locales para recuperar los errores 
DECLARE codigo_SQL  CHAR(5) DEFAULT '00000';	 
DECLARE codigo_MYSQL INT DEFAULT 0;
DECLARE mensaje_error TEXT;

DECLARE EXIT HANDLER FOR SQLEXCEPTION 	 	 
BEGIN #En caso de una excepción SQLEXCEPTION retrocede la transacción y devuelve el código de error especifico de MYSQL (MYSQL_ERRNO), el código de error SQL  (SQLSTATE) y el mensaje de error  
	GET DIAGNOSTICS CONDITION 1 codigo_MYSQL= MYSQL_ERRNO, codigo_SQL= RETURNED_SQLSTATE, mensaje_error= MESSAGE_TEXT;
	SELECT 'SQLEXCEPTION!, Transaccion abortada' AS resultado, codigo_MySQL, codigo_SQL,  mensaje_error;		
	ROLLBACK;
END;

Start TRANSACTION;
	#Verificar que exita el parquimetro o la tarjeta
	IF EXISTS (SELECT correo FROM mayoristas as m WHERE correo=m.correo) THEN
		BEGIN		
			SELECT 'Error' as Resultado, 'El correo ya existe' as Motivo;
		END;
	ELSE
		BEGIN		
			INSERT INTO usuarios(correo,nombre,dni_cuit,clave,fecha_reg) VALUES (correo,nombre,cuit,clave,now());
			INSERT INTO mayoristas(correo,usuario) VALUES (correo,usuario);		
			
			IF NOT EXISTS (SELECT correo FROM mayoristas as m WHERE correo=m.correo) THEN	
				BEGIN
					SELECT 'Error' as Resultado, 'Error en la base de datos al crear' as Motivo;					
				END;
			ELSE
				BEGIN					
					SELECT 'Correcto' as Resultado, 'Sin errores' as Resultado;
				END;
			END IF;		
		END;
	END IF;
COMMIT;
END;


#Creacion de stored procedures
delimiter !
CREATE PROCEDURE confirmarPedido(IN id_pedido INT, IN correo VARCHAR(45))
BEGIN

# Declaro variables locales para recuperar los errores 
DECLARE codigo_SQL  CHAR(5) DEFAULT '00000';	 
DECLARE codigo_MYSQL INT DEFAULT 0;
DECLARE mensaje_error TEXT;

DECLARE EXIT HANDLER FOR SQLEXCEPTION 	 	 
BEGIN #En caso de una excepción SQLEXCEPTION retrocede la transacción y devuelve el código de error especifico de MYSQL (MYSQL_ERRNO), el código de error SQL  (SQLSTATE) y el mensaje de error  
	GET DIAGNOSTICS CONDITION 1 codigo_MYSQL= MYSQL_ERRNO, codigo_SQL= RETURNED_SQLSTATE, mensaje_error= MESSAGE_TEXT;
	SELECT 'SQLEXCEPTION!, Transaccion abortada' AS resultado, codigo_MySQL, codigo_SQL,  mensaje_error;		
	ROLLBACK;
END;

Start TRANSACTION;
	#Verificar que exita el parquimetro o la tarjeta
	IF EXISTS (SELECT correo FROM mayoristas as m WHERE correo=m.correo) THEN
		BEGIN		
			SELECT 'Error' as Resultado, 'El correo ya existe' as Motivo;
		END;
	ELSE
		BEGIN		
			INSERT INTO usuarios(correo,nombre,dni_cuit,clave,fecha_reg) VALUES (correo,nombre,cuit,clave,now());
			INSERT INTO mayoristas(correo,usuario) VALUES (correo,usuario);		
			
			IF NOT EXISTS (SELECT correo FROM mayoristas as m WHERE correo=m.correo) THEN	
				BEGIN
					SELECT 'Error' as Resultado, 'Error en la base de datos al crear' as Motivo;					
				END;
			ELSE
				BEGIN					
					SELECT 'Correcto' as Resultado, 'Sin errores' as Resultado;
				END;
			END IF;		
		END;
	END IF;
COMMIT;
END;


