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

function trim(s)
{
    var l=0; var r=s.length -1;
    while(l < s.length && s[l] == ' ')
    {     l++; }
    while(r > l && s[r] == ' ')
    {     r-=1;     }
    return s.substring(l, r+1);
} 

function makeUrlFriendly(str){

	str = str.toLowerCase(); //change everything to lowercase
    str = trim(str); //trim leading and trailing spaces
    str = str.replace(/\s/g, "-"); //change all spaces and underscores to a hyphen
    str = str.replace(/_/g, "-"); //change all spaces and underscores to a hyphen
    str = str.replace(/[^a-z0-9-]+/g, ""); //remove all non-alphanumeric characters except the hyphen
    str = str.replace(/[-]+/g, "-"); //replace multiple instances of the hyphen with a single instance
    str = str.replace(/^-+|-+$/g, ""); //trim leading and trailing hyphens	str = str.strip().gsub(/s+/, '-').gsub(/[^a-zA-Z0-9-]+/, '').toLowerCase();

	return(str);
}

function validar_reescritura(param_desc_es,param_desc_en,param_id,param_tipo){
	
	var retornar = true;
	
	if(param_desc_es == ""){
		alert("La reescritura en español esta vacia.");
		retornar = false;
	}else if(param_desc_en == ""){
		alert("La reescritura en inglés esta vacia.");
		retornar = false;
	}else{
		new Ajax.Request("validar_reescritura.ajax.php",{
			method: 'post',
			asynchronous: false,
			parameters: {
				nombre_es: param_desc_es,
				nombre_en: param_desc_en,
				id_relacion: param_id,
				tipo: param_tipo
			},
			onSuccess: function(transport){
				ret = parseInt(transport.responseText);
			}
		});
		
		if(ret == 0){
			alert('El nombre de reescritura que ha ingresado ya esta siendo utilizado. Por favor elija otro nombre.');
			retornar = false;
		}
	}
	
	return(retornar);
}