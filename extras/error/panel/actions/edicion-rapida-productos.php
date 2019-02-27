<?php 
//librerias 
include_once '../../lib/lib.php';
/*
//backup
$con = new Conexion();
$backupFile = 'giamber' . date("Y-m-d-H-i-s") . '.gz';
$command = "mysqldump --opt -h ".$con->getServidor()." -u ".$con->getUsuario()." -p ".$con->getPass()." ".$con->getBD()." | gzip >     $backupFile";
$command = "mysqldump -u ".$con->getUsuario()." -p ".$con->getPass()." --all-databases > all_db_backup.sql";
$command = "mysqldump -u ".$con->getUsuario()." -p ".$con->getPass()." ".$con->getBD()." productos variedades > table_backup.sql";

$command = "mysqldump -u ".$con->getUsuario()." -p ".$con->getPass()." giamber_db > filename.sql";

//echo $command;
exec($command,$valor);
echo $valor;

$con->close();
*/

$con = new Conexion();
$backup_file = "giamber" . date("Y-m-d-H-i-s") . ".sql.gz";
$command = "mysqldump --opt -h ".$con->getServidor()." -u ".$con->getUsuario()." -p ".$con->getPass()." ".$con->getBD()." | gzip > $backup_file";
echo $command.'<br>';
system($command,$output);
echo $output;


$cant = $_GET['cant'];
try{
	$i=1;
	while($i<=$cant){
		if(isset($_POST['precio_min-'.$i]) && isset($_POST['caja-'.$i]) && isset($_POST['precio_may-'.$i]) && isset($_POST['stock-'.$i])){
			
			//editamos
			$variedad = new Variedad($i);
			$v = $variedad->getEnvase();
			$variedad->set($v,$_POST['precio_min-'.$i],$_POST['caja-'.$i],$_POST['precio_may-'.$i],$_POST['stock-'.$i]);
		}else{
			$cant++;
		}
		$i++; //incremento cursor
	}
	
	//redireccionar
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Se editaron todos los productos').'">';
	
}catch(ExceptionBD $ex){
	echo $ex->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al editar. Error: '.$ex->getMessage().'').'">';
}catch(Exception $e){
	echo $e->getMessage();
	echo '<meta http-equiv="refresh" content="0; url=../operacion.php?t='.urlencode('Error al editar. Error: '.$e->getMessage().'').'">';
}

?>