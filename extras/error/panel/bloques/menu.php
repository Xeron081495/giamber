
<menu id="pc">
	<ul>
		  <li <?php if($id_lugar==1) echo 'id="activo"'; ?> ><a id="pedido" href="pedidos.php">Pedidos</a></li>
		  <li <?php if($id_lugar==2) echo 'id="activo"'; ?> ><a id="producto" href="productos.php">Productos</a></li>
		  <li <?php if($id_lugar==3) echo 'id="activo"'; ?> ><a id="usuario" href="mayorista.php">Mayoristas</a></li>
		  <li <?php if($id_lugar==4) echo 'id="activo"'; ?> ><a id="usuario" href="usuarios.php">Minoristas</a></li>
		  <li><a id="cerrar" href="actions/logout.php">Cerrar sesión</a></li>
	</ul>
</menu>
