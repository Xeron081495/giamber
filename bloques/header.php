<meta name="viewport" content="initial-scale=1, maximum-scale=1">

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
	(function(){ var widget_id = 'nKjMuHAZko';var d=document;var w=window;function l(){
		var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->

<header id="celular">
	<a id="menu-celular" onclick="mostrarMenu();" ></a>
	<a href="./"><img id="icono" src="img/logo_blanco.png" /></a>
</header>

<header id="barra_superior">	
	<a href="tel:2914780018" id="telefono">Proximamente</a>
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
		<li><a <?php if($lugar==3) echo 'id="actual"'; ?> href="tienda.php">Catálogo</a></li>
		<?php if(count(getProductosOferta())>0){ ?>
			<li><a <?php if($lugar==10) echo 'id="actual"'; ?> href="tienda.php?ofertas=si">Ofertas</a></li>
		<?php } ?>
		<li><a <?php if($lugar==4) echo 'id="actual"'; ?> href="asesor.php">Asesor</a></li>
		<li><a <?php if($lugar==5) echo 'id="actual"'; ?> id="ultimo" href="contacto.php">Contacto</a></li>
		<?php if(isset($_SESSION['login'])){
			echo '<li><a id="ultimo" href="actions/logout.php">Cerrar sesión</a></li>';
		}
		?>
	</ul>	
</menu>




<header <?php if($lugar==1) echo 'id="especial"'; ?>>
	<div id="barra_superior">
		<div class="contenedor">
		<h1 id="sponsor">Distribuidora oficial para Bahía Blanca y la zona. <?php echo getCategoriasLeyenda(); ?></h1>
		<div id="ubicacion">Bahía Blanca</div>			
		<div id="telefono">(0291) Próximamente</div>
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
			<li><a <?php if($lugar==3) echo 'id="actual"'; ?> href="tienda.php">Catálogo</a></li>
			<?php if(count(getProductosOferta())>0){ ?>
				<li><a <?php if($lugar==10) echo 'id="actual"'; ?> href="tienda.php?ofertas=si">Ofertas</a></li>
			<?php } ?>
			<li><a <?php if($lugar==4) echo 'id="actual"'; ?> href="asesor.php">Asesor</a></li>
			<li><a <?php if($lugar==5) echo 'id="actual"'; ?> id="ultimo" href="contacto.php">Contacto</a></li>
		</ul>			
	</menu>
	</div>
</header>