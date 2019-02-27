
//guardo los datos de todas las variedades
var precios = []; //precio que paga el cliente
var precios_min = []; //precio minorista
var precios_may = []; //precio mayorista
var variedad = []; // id de variedades
var stock = []; // stock del producto
var step = []; // cantidad del mayorista
var variedad_actual = 0; //predeterminada es la opcion 1

//inicicializamos los arreglos
<?php 
	for($i=0; $i<count($p->getVariedades());$i++){
		//si es mayorista agrego los precios mayorista		
		if(isset($usuario) && $usuario->getStep()){ ?> 
			precios.push(<?php echo $p->getVariedades()[$i]->getPrecioMayorista(); ?>); 
		<?php 
		}else{ 
		?>
			precios.push(<?php echo $p->getVariedades()[$i]->getPrecioUnidad(); ?>);
		<?php 
		} 
		?> 
		//agrego los demas datos
		stock.push(<?php echo $p->getVariedades()[$i]->getStock(); ?>); 
		step.push(<?php echo $p->getVariedades()[$i]->getCantidadMayorista(); ?>);
		variedad.push(<?php echo $p->getVariedades()[$i]->getID(); ?>);
		precios_may.push(<?php echo $p->getVariedades()[$i]->getPrecioMayorista(); ?>); 
		precios_min.push(<?php echo $p->getVariedades()[$i]->getPrecioUnidad(); ?>);
<?php
	}	
?>


// Va monitoreando cambios en la web
$(document).ready(function(){	
	
	//captura si modifican el valor del input que contiene la cantidad que el cliente quiere comprar
	$("#cantidad_carrito").click(function () {		
		//saco el valor accediendo a un input de tipo text y name = nombre
		var cantidad_carrito = $('input[name=cantidad]').val(); 
		var n = cantidad_carrito*precios[variedad_actual];
		$(".precio_carrito").html('Precio total: $'+n.toFixed(2));		
	});	
	
	
	//va monitoreando si hay stock o no del producto
	<?php 
		if(isset($usuario) && $usuario->getStep() && $p->getVariedades()[0]->getStock()<$p->getVariedades()[0]->getCantidadMayorista()){
			?> $('.form-carrito').css({'display': 'none'});
			$('.stock').html('Unidades agostadas para mayorista');<?php
		}elseif($p->getVariedades()[0]->getStock()==0){
			?> $('.form-carrito').css({'display': 'none'});
			$('.stock').html('Unidades agostadas');<?php
		}
	?>
	
});

//modifica todo lo que corresponda al cambiar de tipo de envase
function cambiarVariedad(i){
	
	//pongo el precio actual de la variedad
	variedad_actual = i;
	
	//modifico el precio que está abajo de titulo
	$(".precio").html('$'+precios_min[variedad_actual].toFixed(2));
	$('#cantidad_carrito').attr('max',stock[variedad_actual]);
	$('#variedad_carrito').val(''+variedad[variedad_actual]);
	$('#precio-mayorista').html('$'+precios_may[variedad_actual].toFixed(2));
	$('#precio-minorista').html('$'+precios_min[variedad_actual].toFixed(2));
	
	<?php
	if(isset($usuario) && $usuario->getStep()){
	?>
		$('#cantidad_carrito').attr('min',step[variedad_actual]);
		$('#cantidad_carrito').attr('step',step[variedad_actual]);
		$('#cantidad_carrito').val(''+step[variedad_actual]);
		if(stock[variedad_actual]<step[variedad_actual]){
			$('.form-carrito').css({'display': 'none'});
			$('.stock').html('Unidades agostadas para mayoristas');
		}else{
			$('.form-carrito').css({'display': 'block'});
			$('.stock').html('');
		}
	<?php
	}else{
		?>
		if(stock[variedad_actual]==0){
			$('.form-carrito').css({'display': 'none'});
			$('.stock').html('Unidades agostadas');
		}else{
			$('.form-carrito').css({'display': 'block'});
			$('.stock').html('');
		}
		<?php		
	}	
	?>
	
	//modifico el precio del carrito
	var cantidad_carrito = $('input[name=cantidad]').val(); 
	var n = cantidad_carrito*precios[variedad_actual];
	$(".precio_carrito").html('Precio total: $'+n.toFixed(2));
		
	//pongo en color la opcion elegida
	$('#e'+i).css({'background-color': '#FFBDBD'});
	$('#e'+i).css({'border': 'solid #ba0000 0.05em'});
	$('#e'+i).css({'color': '#ba0000'});
	
	//saco el color de elegido a los demás
	for(var j=0; j<100; j++){
		if(i!=j){
			$('#e'+j).css({'background-color': '#C4E2FF'});
			$('#e'+j).css({'border': 'solid #57ABFF 0.05em'});
			$('#e'+j).css({'color': '#00376E'});
		}
	}	
}


//VIDEO DE YOUTUBE
function mostrar(){
	$('#fondo').css({'display': 'block'});
	$('#youtube_video').css({'display': 'block'});
	
	//empezar video
	$("iframe#frame")[0].src = "https://www.youtube.com/embed/<?php echo $p->getVideo(); ?>?rel=0&autoplay=1";	
}
function noMostrar(){
	$('#fondo').css({'display': 'none'});
	$('#youtube_video').css({'display': 'none'});
	
	//pausar video
	$("iframe#frame")[0].src = "";
}

