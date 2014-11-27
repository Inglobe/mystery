function redireccionar(url) {
	location.href=url;
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function vaciarCombo(obj){
	while(obj.hasChildNodes()){
		obj.removeChild(obj.firstChild);
	}
}
function addLoadEvent(func){
    var oldonload = window.onload;
    if (typeof window.onload != 'function'){
        window.onload = func;
    }else{
        window.onload = function(){
            if (oldonload){
                oldonload();
            }
            func();
        }
    }
}
function checkPermiso(id_usuario,abr){
	var mysql = new MySQLDatabase();
	var sql_query = "SELECT COUNT(*) AS NRO FROM USUARIOS_PERMISOS UP, PERMISOS P WHERE P.ID_PERMISO = UP.ID_PERMISO AND UP.ID_USUARIO = " + id_usuario + " AND P.ABR LIKE '" + abr + "'";
	mysql.query(sql_query);
	mysql.nextRow();

	if(mysql.getField("NRO") == 1){
		return true;
	}
	else{
		return false;
	}
}

function comprobar_extension(campo){

	var extensiones_permitidas = new Array(".jpg",".png",".gif");

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