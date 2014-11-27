function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function redireccionar(url) {
	location.href=url;
}
function mostrarOcultar(id){
	obj = getElement(id);
	if(obj.style.display=="none"){
		obj.style.display="";
	}
	else{
		obj.style.display="none";
	}
}
function comprobar_email(emailStr) {

	var emailPat=/^(.+)@(.+)$/

	var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"

	var validChars="\[^\\s" + specialChars + "\]"

	var quotedUser="(\"[^\"]*\")"

	var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/

	var atom=validChars + '+'

	var word="(" + atom + "|" + quotedUser + ")"

	var userPat=new RegExp("^" + word + "(\\." + word + ")*$")

	var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")

	var matchArray=emailStr.match(emailPat)
	if (matchArray==null) {
		alert("E-mail Error")
		return false
	}
	var user=matchArray[1]
	var domain=matchArray[2]

	if (user.match(userPat)==null) {
	    alert("E-mail Error")
	    return false
	}

	var IPArray=domain.match(ipDomainPat)
	if (IPArray!=null) {
		  for (var i=1;i<=4;i++) {
		    if (IPArray[i]>255) {
		        alert("Direccion IP no valida!")
			return false
		    }
	    }
	    return true
	}

	var domainArray=domain.match(domainPat)
	if (domainArray==null) {
		alert("E-mail Error.")
	    return false
	}

	var atomPat=new RegExp(atom,"g")
	var domArr=domain.match(atomPat)
	var len=domArr.length
	if (domArr[domArr.length-1].length<2 ||
	    domArr[domArr.length-1].length>3) {
	   alert("E-mail Error.")
	   return false
	}

	if (len<2) {
	   var errStr="Esta direccion es desconocida como IP!"
	   alert(errStr)
	   return false
	}
	return true;
}

function aleatorio(inferior,superior){
    numPosibilidades = superior - inferior
    aleat = Math.random() * numPosibilidades
    aleat = Math.round(aleat)
    return parseInt(inferior) + aleat
}
addEvent = function ( obj, type, fn ) {
	if (obj.addEventListener)
		obj.addEventListener( type, fn, false );
	else if (obj.attachEvent) {
		obj["e"+type+fn] = fn;
		obj[type+fn] = function() { obj["e"+type+fn]( window.event ); };
		obj.attachEvent( "on"+type, obj[type+fn] );
	}
}
newElement = function (tag) {
   return document.createElement(tag);
}
getElement = function (id) {
   return document.getElementById(id);
}

getByName = function(name){
	return document.getElementsByName(name);
}

getByTag = function(tag){
	return document.getElementsByTagName(tag);
}

function selectComboItem(obj,id_combo){
	for (i = 0; i < obj.length; i++){
		if(obj[i].value==id_combo){
			obj.selectedIndex=i;
		}
	}
}

function checkForm(id) {
	var textoError = "Llene los siguientes campos correctamente:\n\n";
	var f = document.getElementById(id);

	for(i=0;i<f.elements.length;i++){
		var campo = f.elements[i];

		if(campo.className.split(" ")[0] == "required"){
			switch(campo.className.split(" ")[1]){
				case "email":
					if((campo.value.indexOf(".") == -1) || (campo.value.indexOf("@") == -1)) {
						alert("Campo requerido. (e-mail)\n");
			            campo.style.background = "#E9D7D6";
			        	campo.focus();
			        	return false;
			        }
				break;
				case "numeric":
					var error = false;
					var strChars = "0123456789.- ";
				    for(j = 0; j < campo.value.length; j++) {
				        strChar = campo.value.charAt(j);
				        if (strChars.indexOf(strChar) == -1) {
							error = true;
				        }
				    }
				    if(error || campo.value.length == 0){
					    alert("Campo requerido. (numérico)\n");
			        	campo.style.background = "#E9D7D6";
			        	campo.focus();
		        		return false;
		        	}
				break;
				default:
					if(campo.value == "") {
						alert("Campo requerido.\n");
			            campo.style.background = "#E9D7D6";
			            campo.focus();
			            return false;
			        }
			    break;
			}
		}
	}

    return true;
}