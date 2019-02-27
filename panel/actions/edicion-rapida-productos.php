<?php 
//librerias 
include_once '../../lib/lib.php';


$cant = $_GET['cant'];
try{

	//contiene variedades de variedades que esta en oferta
	$lista_ofertas = array();

	$i=1;
	while($i<=$cant){
		if(isset($_POST['precio_min-'.$i]) && isset($_POST['caja-'.$i]) && isset($_POST['precio_may-'.$i]) && isset($_POST['stock-'.$i])){
			
			//editamos
			$variedad = new Variedad($i);
			$v = $variedad->getEnvase();

			//guardo las ofertas
			$oferta_vieja = $variedad->getOferta();
			$oferta_nueva = $_POST['oferta-'.$i];

			//seteo la nueva configuracion
			$variedad->set($v,$_POST['precio_min-'.$i],$_POST['caja-'.$i],$_POST['precio_may-'.$i],$_POST['stock-'.$i],$_POST['oferta-'.$i]);
		
			//verifico si hay q agregarla a lista de posibles ofertas a mandar por correo
			if($oferta_nueva>5){ // si es mayor a 5, puede que quiera mandar oferta
				if($oferta_vieja<$oferta_nueva){ //la oferta nueva tiene q ser mejor que la vieja
					array_push($lista_ofertas,$variedad->getID());
				}
			}
			
		}else{
			$cant++;
		}
		$i++; //incremento cursor
	}
	
	//redireccionar
	if(count($lista_ofertas)>0)
		echo '<meta http-equiv="refresh" content="0; url=../enviar-ofertas.php?t='.urlencode('Se editaron todos los productos').'&oferta='.e(urlencode(serialize($lista_ofertas))).'">';
	else
		echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se editaron todos los productos').'">';
	


}catch(ExceptionBD $ex){
	echo $ex->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al editar. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo $e->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al editar. Error: '.$e->getMessage().'').'">';
}

?>