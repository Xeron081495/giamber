$(document).ready(function(){
	var cant = '<?php echo count($datos); ?>';
	for(var i = 0; i<cant; i++){
		$('#o'+i+'').css({'visibility': 'hidden'});
	}

	for(var i; i<1000; i++){		
		$('.c'+abierto+'').css({'display': 'inline-block'});
		
	}
	
});

function mostrar(i){	
	$('#o'+i+'').css({'visibility': 'visible'});
}

function ocultar(i){	
	$('#o'+i+'').css({'visibility': 'hidden'});
}


var abierto = -1;
function mostrarFila(i){
	if(abierto==i){
		$('.c'+abierto+'').css({'display': 'none'});
		abierto = -1;		
	}else{	
		$('.c'+abierto+'').css({'display': 'none'});	
		$('.c'+i+'').css({'display': 'inline-block'});
		abierto = i;
	}
}
var visible = 0;

function mostrarMenu(){
	if(visible==0){
		$('menu#pc').css({'display': 'inline-block'});
		visible = 1;
	}else{
		$('menu#pc').css({'display': 'none'});
		visible = 0;		
	}
}