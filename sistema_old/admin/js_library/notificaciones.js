function checkNotificaciones(id_usuario){
	var mysql = new MySQLDatabase();
	var sql_query = "SELECT COUNT(*) AS nro FROM usuarios_notificaciones WHERE id_usuario = " + id_usuario;
	mysql.query(sql_query);
	mysql.nextRow();
	if(mysql.getField("nro") > 0){
		var flashvars = {};
		var params = {menu: "false", wmode: "transparent" };
		var attributes = {};
		swfobject.embedSWF("nueva_tarea.swf", "ruidito", "1", "1", "8.0.0","", flashvars, params, attributes);

		$("notificaciones").show();
		cargar_notificaciones();

		var mysql = new MySQLDatabase();
		var sql_query = "SELECT COUNT(*) AS nro FROM usuarios_notificaciones un, tareas t WHERE un.id_tarea = t.id_tarea AND t.id_prioridad_tarea = 5 AND un.id_usuario = " + id_usuario;
		mysql.query(sql_query);
		mysql.nextRow();
		if(mysql.getField("nro") > 0){
			var flashvars = {};
			var params = {menu: "false", wmode: "transparent" };
			var attributes = {};
			swfobject.embedSWF("alerta_fuego.swf", "fuego_alerta", "1", "1", "8.0.0","", flashvars, params, attributes);

			if(mysql.getField("nro") > 1){
				var flashvars = {};
				var params = {menu: "false", wmode: "transparent" };
				var attributes = {};
				swfobject.embedSWF("toasty.swf", "toasty", "97", "94", "8.0.0","", flashvars, params, attributes);
			}
		}

		return true;
	}
	else {
		$("notificaciones").hide();
		return false;
	}


}

function cargar_notificaciones(id_session){
	//window.open("notificaciones.pop.php","Notificaciones","width=550,height=300,scrollbars=no");
	new Ajax.Updater("notificaciones", "notificaciones.inc.php");
}