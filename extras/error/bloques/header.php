<meta name="viewport" content="initial-scale=1, maximum-scale=1">



<header id="celular">
	<a id="menu-celular" onclick="mostrarMenu();" ></a>
	<a href="./"><img id="icono" src="img/logo_blanco.png" /></a>
</header>

<header id="barra_superior">	
	<a href="tel:2914780018" id="telefono">(0291) 154780018</div>	
	<?php 
		if(isset($_SESSION['login'])){		
			echo '<a id="login" href="pedidos.php">Mis pedidos</a>';					
		}else{
			echo '<a id="login" href="login-mayorista.php">Acceso mayoristas</a>';	
		}
	?>						
	</div>
</header>

<menu id="celular">
	<ul>
		<li><a <?php if($lugar==1) echo 'id="actual"'; ?> href="./">Inicio</a></li>
		<li><a <?php if($lugar==2) echo 'id="actual"'; ?> href="nosotros.php">Nosotros</a></li>
		<li><a <?php if($lugar==3) echo 'id="actual"'; ?> href="tienda.php">Tienda online</a></li>
		<li><a <?php if($lugar==4) echo 'id="actual"'; ?> id="ultimo" href="contacto.php">Contacto</a></li>
		<?php if(isset($_SESSION['login'])){
			echo '<li><a id="ultimo" href="actions/logout.php">Cerrar sesión</a></li>';
		}
		?>
	</ul>	
</menu>




<header <?php if($lugar==1) echo 'id="especial"'; ?>>
	<div id="barra_superior">
		<div class="contenedor">
		<h1 id="sponsor">Distribuidora oficial de Motul, Meguiars y Sonax en Bahía Blanca</h1>
		<div id="ubicacion">Bahía Blanca</div>			
		<div id="telefono">(0291) 154780018</div>	
		<?php 
			if(isset($_SESSION['login'])){		
				echo '<a id="login" href="actions/logout.php">Cerrar sesión</a>';
				echo '<a id="login" href="pedidos.php">Mis pedidos</a>';					
			}else{
				echo '<a id="login" href="login-mayorista.php">Acceso mayoristas</a>';		
				//echo '<a id="login" href="login.php">Acceso minoristas</a>';
			}
		?>						
		</div>
	</div>
	<div class="contenedor">
	<div id="logo"><a href="./"><img src="img/logo_blanco.png" alt="Gimaber Lubricantes" title="Gimaber Lubricantes" /></a></div>
	<menu id="principal">
		<ul>
			<li><a <?php if($lugar==1) echo 'id="actual"'; ?> href="./">Inicio</a></li>
			<li><a <?php if($lugar==2) echo 'id="actual"'; ?> href="nosotros.php">Nosotros</a></li>
			<li><a <?php if($lugar==3) echo 'id="actual"'; ?> href="tienda.php">Tienda online</a></li>
			<li><a <?php if($lugar==4) echo 'id="actual"'; ?> id="ultimo" href="contacto.php">Contacto</a></li>
		</ul>			
	</menu>
	</div>
</header>