<?php

//tomar datos de la cuenta de MP
$gestor_mp = new GestorMP();
$id_cliente = $gestor_mp->getIDCliente();
$id_secret = $gestor_mp->getIDSecret();

//creamos el controlador de mercadopago
$mp = new MP($id_cliente, $id_secret);

if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
    http_response_code(400);
    return;
}

$topic = $_GET["topic"];
$merchant_order_info = null;

switch ($topic) {
    case 'payment':
        $payment_info = $mp->get("/collections/notifications/".$_GET["id"]);
        $merchant_order_info = $mp->get("/merchant_orders/".$payment_info["response"]["collection"]["merchant_order_id"]);				
		$pago = $gestor_mp->getPago($payment_info["response"]["items"][0]["id"]);
		$pago->actualizar(json_encode($payment_info));

		if($pago->completoPago()){
			$this->pagoCompleto();
		}
				
		break;
    case 'merchant_order':
        $merchant_order_info = $mp->get("/merchant_orders/".$_GET["id"]);		
		$pago = $gestor_mp->getPago($merchant_order_info["response"]["items"][0]["id"]);
		$pago->actualizar(json_encode($merchant_order_info));

		if($pago->completoPago()){
			$this->pagoCompleto();
		}
		
        break;
    default:
        $merchant_order_info = null;
}

if($merchant_order_info == null) {
    echo "Error obtaining the merchant_order";
    die();
}

if ($merchant_order_info["status"] == 200) {	
    print_r($merchant_order_info["response"]["shipments"]);
}


/** tareas a realizar para los pagos completos */
function pagoCompleto(){
	
}




function imprimir2($imprimir,$num){
	$nombre_archivo = "prueba.txt";  
    if(file_exists($nombre_archivo)){
        unlink("prueba.txt");
    }else{
        $mensaje = "El Archivo $nombre_archivo se ha creado";
    }
 
    if($archivo = fopen($nombre_archivo, "a")){			
        if(fwrite($archivo, $num.' '.$imprimir. "\n"))        {
            echo "Se ha ejecutado correctamente";
        }else{
            echo "Ha habido un problema al crear el archivo";
        } 
        fclose($archivo);
    } 
} 


?>