<?php

//libreria de clases
include_once '../../lib/lib.php';

$usuarios = getMayoristas();

//libreria pdf
require_once '../../lib/dompdf/vendor/autoload.php';
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

$cantidad = 1000;
$i = -1;
//agregar lista de productos
		foreach($usuarios as $u){
			$i++;

			if($i%$cantidad==0){
				$pdf.=' <tr>
							<td colspan="7" bgcolor="skyblue"><center>LISTA DE USUARIOS</center></td>
						</tr>
						<tr bgcolor="#f5f5dc">
							<td><strong>Nombre</strong></td>
							<td><strong>Correo</strong></td>
							<td><strong>CUIT</strong></td>
							<td><strong>Domicilio</strong></td>
							<td><strong>Entre calles</strong></td>
							<td><strong>Ciudad</strong></td>
							<td><strong>Teléfono</strong></td>
						</tr>';
			}

			$pdf .= '
				<tr>
					<td>'.$u->getNombre().'</td>
					<td>'.$u->getCorreo().'</td>
					<td>'.$u->getCUIT().'</td>';
			if(!is_null($u->getDireccion())) {
				$pdf .= '<td>'.$u->getDireccion()->getDomicilio().'</td>
							<td>'.$u->getDireccion()->getEntre().'</td>
							<td>'.$u->getDireccion()->getCiudad().' ('.$u->getDireccion()->getCP().')</td>
							<td>'.$u->getDireccion()->getTelefono().'</td>';
			}else{
				$pdf.='<td>-</td>	<td>-</td>	<td>-</td>	<td>-</td>';
			}	
				
				$pdf.= '</tr>';
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
$dompdf->stream('Lista de Usuarios - Lubricantes Giamber.pdf');

?>