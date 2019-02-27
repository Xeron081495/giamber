<?php

//libreria de clases
include_once 'lib/lib.php';

$productos = getProductos();

//libreria pdf
require_once 'lib/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;


$pdf='
<!DOCTYPE HTML> 
<html> 
<head>
<style>
	*{
		font-family: Arial;
		font-size: 10.5pt;
		text-transform: capitalize;
	}
	.link{
		text-decoration: none;
		text-transform: uppercase;
		color: #ba4545;
	}
	td{
		padding: 0.05em 0.2em;
	}
</style>
</head>
<body>
	<table width="100%" border="1" cellspacing="0" cellpadding="0.1">

';

$cantidad = 34;
$i = -1;
//agregar lista de productos
		foreach(array_merge($productos) as $p){
			foreach($p->getVariedades() as $v){
				$i++;

				if($i%$cantidad==0){
					$pdf.=' <tr>
								<td colspan="7" bgcolor="skyblue"><center>LISTA DE PRECIOS - GIAMBER - Página '.(($i/$cantidad)+1).'</center></td>
							</tr>
							<tr bgcolor="#f5f5dc">
								<td><strong>Nombre</strong></td>
								<td><strong>Categoria</strong></td>
								<td><strong>Envase</strong></td>
								<td><strong>Precio Lista</strong></td>
								<td><strong>Precio Mayorista</strong></td>
								<td><strong>Oferta</strong></td>
								<td><strong>Más info.</strong></td>
							</tr>';
				}

				$pdf .= '
					<tr>
						<td>'.$p->getNombre().'</td>
						<td>'.$p->getCategoria()->getNombre().'</td>
						<td>'.$v->getEnvase().'</td>
						<td>'.$v->getPrecioNeto().'</td>
						<td>'.$v->getPrecioMayoristaNeto().'</td>
						<td>'.$v->getOferta().'%</td>
						<td><a class="link" href="http://www.lubricantesgiamber.com/prod.php?id='.e($p->getID()).'" target="_blank">ir a web</a></td>
					</tr>
				';
			}
		}

$pdf .='
	</table>
</body>
</html>
';

//echo $pdf;
//exit;

//pasar a pdf
$dompdf = new Dompdf();
$dompdf->loadHtml($pdf);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$archivo = $dompdf->output();
$dompdf->stream('Lista de Precios - Lubricantes Giamber.pdf');

?>