<?php
session_start();
$_SESSION['id_usuario'] = '1';

include_once '../../../datos.php';
require_once "../../../lib/mercadopago.php";


 
$mp = new MP($id_cliente, $id_secret);

$preference_data = array(
	"items" => array(
		array(
			"id" => "0216656",
			"title" => "Prueba de producto de germán 13",
			"currency_id" => "ARG",
			"picture_url" =>"https://www.mercadopago.com/org-img/MP3/home/logomp3.gif",
			"description" => "Description",
			"category_id" => "Category",
			"quantity" => 1,
			"unit_price" => 1.00
		)
	),
	"payer" => array(
		"name" => "NombreP",
		"surname" => "ApellidoP",
		"email" => "germang08@hotmail.com",
		"date_created" => "", //"2014-07-28T09:50:37.521-04:00",
		"phone" => array(
			"area_code" => "291",
			"number" => "154722876"
		),
		"identification" => array(
			"type" => "DNI",
			"number" => "38919277"
		),
		"address" => array(
			"street_name" => "9 de julio",
			"street_number" => 1350,
			"zip_code" => "8000"
		)
	),
	"back_urls" => array(
		"success" => "http://www.estudiowebxeron.com.ar/mp/termino.php",
		"failure" => "http://www.estudiowebxeron.com.ar/mp/faulire.php",
		"pending" => "http://www.estudiowebxeron.com.ar?tipo=pending"
	),
	"auto_return" => "approved",
	"payment_methods" => array(
		"installments" => 24,
		"default_payment_method_id" => null,
		"default_installments" => null,
	),
	"notification_url" => "http://www.estudiowebxeron.com.ar/mp/receptor.php",
	"external_reference" => "123456789",
	"expires" => false,
	"expiration_date_from" => null,
	"expiration_date_to" => null
);
//$mp->sandbox_mode(TRUE);

$preference = $mp->create_preference($preference_data);
?>

<!doctype html>
<html>
	<head>
		<title>MercadoPago SDK - Create Preference and Show Checkout Example</title>
	</head>
	<body>
		<a href="<?php echo $preference["response"]["init_point"]; ?>" name="MP-Checkout" class="orange-ar-m-sq-arall">Pay</a>
		<script type="text/javascript" src="//resources.mlstatic.com/mptools/render.js"></script>
	</body>
</html>
