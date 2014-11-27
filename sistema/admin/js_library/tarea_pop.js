getFechaInicioPadre = function(){
	alert ("hola");
	var mysql = new MySQLDatabase();
	var sql_query = "SELECT DATE_FORMAT(fecha_inicio_prevista,'%Y%m%d') AS fecha_ip, DATE_FORMAT(fecha_fin_prevista,'%Y%m%d') AS fecha_ip FROM tareas WHERE id_tarea = 1";
	mysql.query(sql_query);
	while(mysql.nextRow()){
		alert(mysql.getField("fecha_ip"));
	}
}

$("btn_cancel").onclick = function(){
	parent.hidePopWin();
}

$("form_agregar_tarea").onsubmit = function(){

	var campo_validar = $("cmb_id_usuario_responsable");
	if(campo_validar.value == 0){
		alert("Campo requerido.");
        campo_validar.style.background = "#E9D7D6";
      	campo_validar.focus();
       	return false;
	}

	/*var campo_validar = $("cmb_id_tipo_tarea");
	if(campo_validar.value == 0){
		alert("Campo requerido.");
        campo_validar.style.background = "#E9D7D6";
      	campo_validar.focus();
       	return false;
	}*/

	var campo_validar = $("cmb_id_prioridad_tarea");
	if(campo_validar.value == 0){
		alert("Campo requerido.");
        campo_validar.style.background = "#E9D7D6";
      	campo_validar.focus();
       	return false;
	}

	var campo_validar = $("descripcion");
	if(campo_validar.value == ""){
		alert("Campo requerido.");
        campo_validar.style.background = "#E9D7D6";
      	campo_validar.focus();
       	return false;
	}

	try{
		var campo_validar = $("tiempo");
		if(campo_validar.value == "" && $("id_estado_tarea_1").checked == false){
			alert("Puntaje requerido.");
			campo_validar.style.background = "#E9D7D6";
			campo_validar.focus();
			return false;
		}
	}
	catch(e){}

	var campo_validar = $("tiempo_estimado");
	if(campo_validar.value == ""){
		alert("Puntaje permitido requerido.");
		campo_validar.style.background = "#E9D7D6";
		campo_validar.focus();
		return false;
	}


	return true;
}
bc_load('multifile', 'file_list');

actualizarBotones = function(){
	$("agregar_log").onclick = function(){
		new Ajax.Updater($("tabla"),"logs_tareas_am.inc.php",{method: "get",parameters: "id_tarea=" + this.rel,onComplete: function(){actualizarBotonesAdd();}});
		return false;
	}
	var btns_eliminar = $$(".borrar_log");
	btns_eliminar.each(
		function(s,index){
			s.onclick = function(){
				if(confirm("Desea borrar este registro?.")){
					new Ajax.Updater($("tabla"),"logs_tareas_procesar.pop.php",{method: "get",parameters: "accion=d&id_eliminar=" + this.rel,onComplete: function(){cargarSearch();}});
				}
				return false;
			}
		}
	);
}

actualizarBotonesAdd = function(){
	$("cancel_log").onclick = function(){
		new Ajax.Updater($("tabla"),"logs_tareas.inc.php",{method: "get",parameters: "id_tarea=" + this.rel,onComplete: function(){actualizarBotones();}});
		return false;
	}
	$("ok_log").onclick = function(){
		if($("descripcion_tarea").value != ""){
			new Ajax.Updater($("tabla"),"logs_tareas_procesar.pop.php",{method: "post",parameters: "accion=a&id_tarea=" + this.rel + "&descripcion=" + escape($("descripcion_tarea").value) + "&id_usr=" + $("id_usuario_tarea").value, encoding: "ISO-8859-1" ,onComplete: function(){cargarSearch();}});
		}
		else {
			alert("Descripción es requerida.");
		}
		return false;
	}
}

cargarSearch = function(){
	new Ajax.Updater($("tabla"),"logs_tareas.inc.php",{method: "get",parameters: "id_tarea=" + $("id_tarea").value,onComplete: function(){actualizarBotones();}});
}
actualizarBotones();