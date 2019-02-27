<footer>
	<menu><div class="contenedor">
		<ul>
			<li><a <?php if($lugar==1) echo 'id="actual"'; ?> href="./">Inicio</a></li>
			<li><a <?php if($lugar==2) echo 'id="actual"'; ?> href="nosotros.php">Nosotros</a></li>
			<li><a <?php if($lugar==3) echo 'id="actual"'; ?> href="tienda.php">Tienda online</a></li>
			<li><a <?php if($lugar==4) echo 'id="actual"'; ?> id="ultimo" href="contacto.php">Contacto</a></li>	
		</ul>
		<div id="logo"><a href="./"><img src="img/logo_blanco.png" alt="Gimaber Lubricantes" title="Gimaber Lubricantes" /></a></div>		
	</div></menu>
	<div id="firma"><div class="contenedor">©<?php echo date('Y'); ?> Todos los derechos reservados a Giamber Lubricantes. Diseñado por estudiowebxeron.com</div></div>
</footer>