/*

*/
function MySQLDatabase(mode){

	var result;
	var outputText;
	var row;
	var error;
	var pointer;
	var ascyncMode

	if(mode == undefined){
		this.ascyncMode = false;
	}
	else{
		this.ascyncMode = mode;
	}

	this.onload = function(){
		alert("Onload!!");
	}

	this.query = function(sql){

		var oXML;

		this.pointer = 0;

		if(window.XMLHttpRequest){
			oXML = new XMLHttpRequest();
		}else{

			try {
				oXML = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e) {
				alert("El navegador utilizado no esta soportado");
				return(false);
			}
		}

		var cadena_query = "includes/xml_query.php?query=" + encodeURI(sql) + "&rand_" + Math.random();
		oXML.open("post",cadena_query ,this.ascyncMode);

		if(this.ascyncMode){

			oXML.padre = this;

			oXML.onreadystatechange=function() {
				if(oXML.readyState==1){
					//$("validando_datos").style.display = "";
		        }else if(oXML.readyState==4){
		        	switch(oXML.status){
		        		case 200:
		        			oXML.padre.result = oXML.responseXML;
							oXML.padre.outputText = oXML.responseText;
							if(oXML.padre.result.getElementsByTagName('error').length != 0){
								oXML.padre.error = true;
							}else{
								oXML.padre.onload();
							}
		        		break;
		        		case 404:
		        			alert("Error 404, internal file not found!")
		        		break;
		        		default:
		        			alert("Error: " + oXML.status);
		        	}
		        }
			}
			oXML.send(null);
		}
		else{
			oXML.send(null);
			if(oXML.status != "200"){
				alert("Error de conexion: " + oXML.status + " - " + statusText);
				return false;
			}

			var resultado = oXML.responseXML;

			if(resultado.getElementsByTagName('error').length != 0){
				this.error = true;
			}

			this.result = oXML.responseXML;
			this.outputText = oXML.responseText;
		}
	}

	this.showError = function(){
		if(this.error){
			alert(this.result.getElementsByTagName('error')[0].firstChild.data + "\nQuery: " + query);
		}else{
			alert("No errors!");
		}
	}

	this.showOutput = function(){
		alert(this.outputText);
	}

	this.nextRow = function(){
		if(this.pointer == this.result.getElementsByTagName('fila').length){
			return(false);
		}else{
			this.row = this.result.getElementsByTagName('fila')[this.pointer];
			this.pointer++;
			return(true);
		}
	}

	this.prevRow = function(){
		if(this.pointer == 0){
			return(false);
		}else{
			this.pointer--;
			this.row = this.result.getElementsByTagName('fila')[this.pointer];
			return(true);
		}
	}

	this.getField = function(field){

		var value = "";

		try {
			value = this.row.getElementsByTagName(field)[0].firstChild.data;
		}catch (e) {}

		return(value);
	}

	this.getNumRows = function(){
		return(this.result.getElementsByTagName('fila').length);
	}

	this.getCurrentPointer = function(){
		return(this.pointer);
	}

	this.setPointer = function(num){
		this.pointer = num;
	}

	this.resetPointer = function(){
		this.pointer = 0;
	}

	this.setEndPointer = function(){
		this.pointer = this.result.getElementsByTagName('fila').length-1;
	}
}
