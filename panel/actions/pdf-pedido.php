<?php 
//libreria de clases
include_once '../../lib/lib.php';

$pedido = new Pedido($_GET['id']);

//libreria pdf
require_once '../../lib/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;

$cantidad = 0;
$total = 0;

foreach($pedido->getArticulos() as $p){
	$total+=$p['precio_final']*$p['cantidad'];
	$cantidad+=$p['cantidad'];
}


$pdf ='
<!DOCTYPE HTML> 
<html> 
<head>
<style>
	*{
		font-family: Arial;
		font-size: 10.5pt;
		text-transform: capitalize;
		font-size: 1em;
	}
	.link{
		text-decoration: none;
		text-transform: uppercase;
		color: #ba4545;
	}
	td{
		padding: 0.05em 0.2em;
	}
	#titulo{
		padding: 1.2em 0;
		font-size: 1.1em;
		background-color: #CCC;
	}
	#cliente{
		padding: 0.4em 1.2em;
		font-size: 1em;
		text-transform: uppercase;
	}
	
	.titulo{
		font-width: bold;
	}
	.totales{
		padding: 0.4em 1.2em;
		font-size: 1em;
		text-transform: uppercase;
	}
	td{
		padding: 0.4em 1.2em;
	}
	
</style>
</head>
<body>
	<table width="100%" border="1" cellspacing="0" cellpadding="0.1">
		<tr>
			<td id="titulo"><center>Pedido #'.$pedido->getID().'</center></td>
		</tr>
		<tr>
			<td colspan="1" id="cliente">N* usuario: '.$pedido->getUsuario()->getNombreUsuario().' - '.$pedido->getUsuario()->getNombre().'</td>
		</tr>
	</table>
		
	<br>
	<table width="100%" border="1" cellspacing="0" cellpadding="0.1">
		<tr>
			<td class="totales"><center><strong>Unidades</strong></center></td>
			<td class="totales"><center><strong>Importe total</strong></center></td>
		</tr>
		<tr> 
			<td class="totales"><center>'.$cantidad.'</center></td>
			<td class="totales"><center>$'.number_format($total,2,',','.').'</center></td>
		</tr>
	</table>	
	<br>
	<table width="100%" border="1" cellspacing="0" cellpadding="0.1">
		
		<tr bgcolor="#f5f5dc">
			<td class="cantidad totales"><strong>Cantidad</strong></td>
			<td class="nombre totales"><strong>Nombre</strong></td>
			<td class="precio totales"><strong>Precio unitario</strong></td>
			<td class="importe totales"><strong>Importe</strong></td>
		</tr>';
		
		foreach($pedido->getArticulos() as $p){
			$pdf.= '
				<tr>
					<td width="15%" class="cantidad">'.$p['cantidad'].'</td>
					<td width="50%" class="nombre">'.$p['variedad']->getProducto()->getNombre().' de '.$p['variedad']->getEnvase().'</td>
					<td width="17.5%" class="precio">$ '.number_format($p['precio_final'],2,',','.').'</td>
					<td width="17.5%" class="importe">$ '.number_format(($p['precio_final']*$p['cantidad']),2,',','.').'</td>
				</tr>
			
			
			';
		}
$pdf.= '		
	</table>
</body>
</html>';

//pasar a pdf
$dompdf = new Dompdf();
$dompdf->loadHtml($pdf);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$archivo = $dompdf->output();
$dompdf->stream('#'.$pedido->getID().' - '.$pedido->getUsuario()->getNombre().'.pdf');
