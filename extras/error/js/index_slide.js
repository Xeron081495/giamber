
var actual = 0;
var max = 9;
var repeticion;
var tiempo = 6200;
var tiempoTrans = 1400;


//la funcion da inicio, muesta el primer elemento y empieza el bucle
$(document).ready(function slide(){
	//la que aparece primero
	$('#1').fadeIn(1);
	
	avanzar();
	repeticion = window.setInterval(avanzar,tiempo);

});

//cambia la imagen por la siguiente
function avanzar(){
	
	$('#'+actual).fadeOut(tiempoTrans);
	
	//vemos que imagen sigue
	actual++;
	if(actual==max+1)
		actual = 1;	
		
	//ponemos visible la que importa
	$('#' +actual).fadeIn(tiempoTrans*2);
}

//cambia la imagen por la siguiente antes de tiempo, reinicia el tiempo d espera
function siguiente() {		
	avanzar();		
	bucle();
}

//reinicia el tiempo de espera y genera el nuevo bucle
function bucle(){
	window.clearInterval(repeticion);	
	repeticion = window.setInterval(avanzar,tiempo);
}

//cambia la imagen por la anterior antes de que cambie y reinicia el tiempo de espera
function anterior() {
	$('#' +actual).fadeOut(tiempoTrans);
		
	//vemos que imagen sigue
	actual--;
	if(actual==0)
		actual = max;
	
	//ponemos visible la que importa
	$('#' +actual).fadeIn(tiempoTrans*2);
	
	
	bucle();

}