<?php 
//libreria
include_once '../lib/lib.php';

//ver si inicio sesion
if(isset($_SESSION['login_panel']))
	echo '<meta http-equiv="refresh" content="0; url=pedidos.php">';

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Panel de Control | Giamber Lubricantes  </title>
<link rel="shortcut icon" href="../img/icono.png" /> 
<!-- Hoja de estilos -->
<link rel="stylesheet" media="screen" href="css/index.css" />
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
</head>

<body>
<div id="contenedor">
  <div id="cabeza">Panel de Control</div>
  <?php 
  	if(isset($_GET['error'])){
		echo '<div id="error">'.$_GET['error'].'</div>';	
	} 
  
  ?>
  <div id="login">
  	<form action="actions/ingresar.php" method="post">
    	<label>Nombre de usuario</label>
    	<input class="usuario" name="usuario" type="text">
    	<label>Contraseña</label>
    	<input class="pass" name="clave" type="password">
        <input class="boton" name="" value="Acceder" type="submit">
    </form>
  </div>
</div>
</body>
</html>