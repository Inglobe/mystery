function desplegar_menu(id_menu,id_grafico,skin){
	menu = document.getElementById(id_menu);
	grafico = document.getElementById(id_grafico);
	if(menu.style.display==""){
		menu.style.display="none";
		grafico.src="skins/" + skin + "/imagenes/flecha_cerrada_boton.gif";
	}
	else{
		menu.style.display="";
		grafico.src="skins/" + skin + "/imagenes/flecha_abierta_boton.gif";
	}
}

function fbkLoading(){
	this.show = function (){
		document.getElementById("msgCargando").style.display="";
	}
	this.hide = function (){
		document.getElementById("msgCargando").style.display="none";
	}
}

function comprobar_extension(campo){

	var extensiones_permitidas = new Array(".jpg",".JPG");

	var archivo = campo.value;

	var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();

	var permitida = false;

	for (var i = 0; i < extensiones_permitidas.length; i++) {
		if (extensiones_permitidas[i] == extension) {
			permitida = true;
			break;
		}
	}

	if(!permitida){
		alert("Sólo se pueden subir archivos: " + extensiones_permitidas.join());
	}
}