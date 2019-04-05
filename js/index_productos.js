
var actual_p = 1;
var max_p = 6;


$(document).ready(function productos(){
	
	for(var i=1; i<=max_p; i++){
		if(i==actual_p)			
			$('.p'+i).css({'display': 'block'});	
		else
			$('.p'+i).css({'display': 'none'});		
	}

});

function siguiente_prod(){
	//vemos que imagen sigue
	actual_p++;
	if(actual_p==max_p+1)
		actual_p = 1;
	
	//ponemos todas en no visibles
	for(var i=1; i<=max_p; i++){
		if(i==actual_p)			
			$('.p'+i).css({'display': 'block'});	
		else
			$('.p'+i).css({'display': 'none'});	
	}
	
}

function anterior_prod() {
		
	//vemos que imagen sigue
	actual_p--;
	if(actual_p==0)
		actual_p = max_p;
	
	//ponemos todas en no visibles
	for(var i=1; i<=max_p; i++){
		if(i==actual_p)			
			$('.p'+i).css({'display': 'block'});	
		else
			$('.p'+i).css({'display': 'none'});	
	}

}


function mostrar_prod(i){
	
	if(i>0 && i<=max_p)
		actual_p = i;
	
	//ponemos todas en no visibles
	for(var i=1; i<=max_p; i++){
		if(i==actual_p)			
			$('.p'+i).css({'display': 'block'});	
		else
			$('.p'+i).css({'display': 'none'});	
	}
}