<?php
	if(!isset($_SESSION['login_panel'])){
		echo '<meta http-equiv="refresh" content="0; url=./">';
		exit;
	}
?>

<meta name="viewport" content="initial-scale=1, maximum-scale=1">

<div id="header-celular">
	<a id="menu-celular" onclick="mostrarMenu();" ></a>
	<a href="pedidos.php"><img id="icono" src="../img/icono.png" width="20" height="20" /></a>
</div>

<header>
  <img id="icono" src="../img/icono.png" width="20" height="20" />
  <a href="pedidos.php"><img id="casa" src="img/casa.png" width="16"></a>
  <div id="nombre">Giamber Lubricantes</div>
  <img id="casa" src="img/mas.png" width="16">
  <a href="agregar-producto.php" id="nuevo">Nuevo Producto</a>
  <img id="perfil" src="img/perfil.jpg" width="16">
  <div id="nombre_usuario">Hola <?php echo $_SESSION['nombre']; ?></div>
</header>
