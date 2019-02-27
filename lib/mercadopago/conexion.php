<?php
//definir huso horario
date_default_timezone_set('America/Argentina/Buenos_Aires');

//conectar a mysql
$conexion = mysql_connect('localhost','estudiow_mp','mercado1520');

//mostrar si n ose pudo
if(!$conexion)
	die ("No se pudo conectar por: ").mysql_error(); 

//conectar a la base de datos
mysql_select_db("estudiow_mercadopago",$conexion);

?>
