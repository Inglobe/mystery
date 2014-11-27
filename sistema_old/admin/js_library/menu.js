var xPos = -146;
document.getElementById("btn_show_hide").onclick = function(){
	expandir();
}

function contraer(){
	xPos -= 8;
	if(xPos > -152){
		document.getElementById("botonera").style.left = xPos + "px";
		setTimeout('contraer()',10);
	}
	else{
		document.getElementById("botonera").style.left = "-150px";
		document.getElementById("btn_show_hide").src="imagenes/btn_expandir_botonera.gif";
		document.getElementById("btn_show_hide").onclick = function(){
			expandir();
		}
	}
}
function expandir(){
	xPos += 8;
	if(xPos <= 0){
		document.getElementById("botonera").style.left = xPos + "px";
		setTimeout('expandir()',10);
	}
	else{
		document.getElementById("btn_show_hide").src="imagenes/btn_contraer_botonera.gif";
		document.getElementById("btn_show_hide").onclick = function(){
			contraer();
		}
	}
}