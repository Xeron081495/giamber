
var visible = 0;

function mostrarMenu(){
	if(visible==0){
		//$('menu#celular').css({'display': 'inline-block'});		
		$('menu#celular').fadeIn(200);
		visible = 1;
	}else{
		//$('menu#celular').css({'display': 'none'});	
		$('menu#celular').fadeOut(10);
		visible = 0;		
	}
}