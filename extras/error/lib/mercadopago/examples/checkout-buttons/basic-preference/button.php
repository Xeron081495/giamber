<?php
require_once "../../../lib/mercadopago.php";
require_once "../../../datos.php";

$mp = new MP($id_cliente,$id_secret);

$preference_data = array(
    "items" => array(
        array(
            "title" => "Prueba de porducto 2",
            "currency_id" => "ARG",
            "category_id" => "Categoria",
            "quantity" => 1,
            "unit_price" => 1.01
        )
    )
);

$mp->sandbox_mode(TRUE);

$preference = $mp->create_preference($preference_data);
?>

<!doctype html>
<html>
    <head>
        <title>MercadoPago SDK - Create Preference and Show Checkout Example</title>
    </head>
    <body>
       	<a href="<?php echo $preference["response"]["init_point"]; ?>" name="APRO" class="orange-ar-m-sq-arall">Pay</a>
        <script type="text/javascript" src="//resources.mlstatic.com/mptools/render.js"></script>
    </body>
</html>
