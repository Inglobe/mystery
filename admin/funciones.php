<?php

function getEstado($id_estado,$msg = ""){
	global $link;

	if($id_estado > 0){
		$get = mysql_fetch_array(mysql_query("SELECT descripcion FROM estados_proyecto WHERE id_estado_proyecto=".$id_estado,$link));
		return $get["descripcion"];
	}else{
		return $msg;
	}
}

function getEstadoTicket($id_estado,$msg = ""){
	global $link;

	if($id_estado > 0){
		$get = mysql_fetch_array(mysql_query("SELECT descripcion FROM estados_tickets WHERE id_estado_ticket=".$id_estado,$link));
		return $get["descripcion"];
	}else{
		return $msg;
	}
}

function convertirFechaDesdeMySQL($fecha_mysql){
	$aux = explode("-",$fecha_mysql);
	$fecha = $aux[2]."/".$aux[1]."/".$aux[0];
	return $fecha;
}

function convertirFechaParaMySQL($fecha_mysql){
	$aux = explode("/",$fecha_mysql);
	$fecha = $aux[2]."-".$aux[1]."-".$aux[0];
	return $fecha;
}

function getExtension($archivo){
	$aux = explode(".",$archivo);
	foreach($aux as $tipo){
		$extencion = $tipo;
	}
	$extencion = strtolower($extencion);
	return $extencion;
}

function getUsrExterno($id_usuario){
	global $link;

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT usuario_externo FROM usuarios WHERE id_usuario = ".$id_usuario,$link));

	if($fila_tmp["usuario_externo"] == 0){
		return false;
	}
	else {
		return true;
	}
}

function getUsrOnline(){
	global $link;
	$tiempo = 5;
	$fecha = time();
	$ip = $_SERVER["REMOTE_ADDR"];
	$id_usuario = $_SESSION["id_usr"];
	$limite = $fecha - $tiempo * 60 ;
	mysql_query("DELETE FROM usuarios_online WHERE fecha < ".$limite,$link) ;
	echo mysql_error($link);
	$result = mysql_query("SELECT * FROM usuarios_online WHERE id_usuario LIKE '".$id_usuario."'",$link);
	echo mysql_error($link);
	if(mysql_num_rows($result) != 0) {
		mysql_query("UPDATE usuarios_online SET fecha = ".$fecha." WHERE id_usuario LIKE '".$id_usuario."'",$link);
		echo mysql_error($link);
	}
	else {
		mysql_query("INSERT INTO usuarios_online (fecha,ip,id_usuario) VALUES ('".$fecha."','".$ip."','".$id_usuario."')",$link) ;
		echo mysql_error($link);
	}
	$query = "SELECT id_usuario FROM usuarios_online WHERE id_usuario != 0";
	$resu = mysql_query($query,$link);
	
	while($resp = mysql_fetch_assoc($resu)){
		$datos[] = $resp["id_usuario"];
	}
	echo mysql_error($link);
	return $datos;
}

function isUserOnline($id_usuario){
	global $link;
	
	$result = mysql_query("SELECT COUNT(*) AS nro FROM usuarios_online WHERE id_usuario LIKE '".$id_usuario."'",$link);
	echo mysql_error($link);
	$fila = mysql_fetch_assoc($result);
	if($fila["nro"] == 1){
		return true;
	}
	else {
		return false;
	}
}

function getUsrNomById($id_usuario){
	global $link;

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT nombre FROM usuarios WHERE id_usuario = ".$id_usuario,$link));

	return $fila_tmp["nombre"];
}
function getUsrById($id_usuario){
	global $link;

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT user FROM usuarios WHERE id_usuario = ".$id_usuario,$link));

	return $fila_tmp["user"];
}

function enviarMailProyecto($id_proyecto, $ids_usuario){
	global $link;
	global $url_site_zas;
	$consulta = "SELECT
						p.*
						, DATE_FORMAT(fecha_inicio_estimada,'%d/%m/%Y') AS fecha_ie_f
						, DATE_FORMAT(fecha_fin_estimada,'%d/%m/%Y') AS fecha_fe_f
						, DATE_FORMAT(fecha_entrega_estimada,'%d/%m/%Y') AS fecha_ee_f
						, DATE_FORMAT(fecha_alta,'%d/%m/%Y') AS fecha_a_f
						, c.nombre AS contacto
						, c.email AS email_contacto
						, c.telefonos AS telefono_contacto
						, u.user AS usuario
						, u.nombre AS nombre_usuario
						, u2.user AS usuario_supervisor
						, u2.nombre AS nombre_usuario_supervisor
						, tp.descripcion AS tipo_proyecto
						, cl.nombre AS cliente
				FROM
						proyectos p
						, tipos_proyecto tp
						, usuarios u
						, usuarios u2
						, contactos c
						, clientes cl
				WHERE
						p.id_proyecto = '".$id_proyecto."'
						AND p.id_tipo_proyecto = tp.id_tipo_proyecto
						AND p.id_usuario_responsable = u.id_usuario
						AND p.id_usuario_supervisor = u2.id_usuario
						AND p.id_contacto_responsable = c.id_contacto
						AND p.id_cliente = cl.id_cliente
				";
	$result = mysql_query($consulta, $link);
	echo mysql_error($link);
	$fila = mysql_fetch_assoc($result);

	foreach($ids_usuario as $id_usuario){
		$fila_usuario = mysql_fetch_assoc(mysql_query("SELECT email, nombre FROM usuarios WHERE id_usuario = ".$id_usuario,$link));

		ob_start();
		//require("proyecto_am_responsable_mail_body.inc.php");
		require("mails/mail_confirmacion_shopper.php");
		$html = ob_get_contents();
		ob_end_clean();

		mail_html($fila_usuario["email"],"website@mysterysur.com.ar","Mystery Sur",$fila_parametros["email_contactenos"],$fila_usuario["nombre"].", ten�s \"".$fila["nombre"]."\" a tu cargo.",$html,strip_tags($html));
	}
}

function enviarMailNotificacion($id_tarea, $id_usuario){
	global $link;
	global $url_site_zas;
	$consulta = "SELECT
						t.*
						, DATE_FORMAT(t.fecha_inicio_estimada,'%d/%m/%Y') AS fecha_ie_f
						, DATE_FORMAT(t.fecha_fin_estimada,'%d/%m/%Y') AS fecha_fe_f
						, DATE_FORMAT(NOW(),'%d/%m/%Y') AS fecha_a_f
						, p.nombre AS proyecto
						, c.nombre AS cliente
						, u.nombre AS usuario_responsable
						, u2.nombre AS usuario_supervisor
						, tt.descripcion AS tipo_tarea
				FROM
						tareas t
						, proyectos p
						, clientes c
						, usuarios u
						, usuarios u2
						, tipos_tarea tt
				WHERE
						t.id_tarea = '".$id_tarea."'
						AND t.id_proyecto = p.id_proyecto
						AND p.id_cliente = c.id_cliente
						AND t.id_usuario_responsable = u.id_usuario
						AND t.id_usuario_owner = u2.id_usuario
						AND t.id_tipo_tarea = tt.id_tipo_tarea
				";
	$result = mysql_query($consulta, $link);
	echo mysql_error($link);
	$fila = mysql_fetch_assoc($result);

	$fila_usuario = mysql_fetch_assoc(mysql_query("SELECT email, nombre FROM usuarios WHERE id_usuario = ".$id_usuario,$link));

	ob_start();
	require("notificacion_mail_body.inc.php");
	$html = ob_get_contents();
	ob_end_clean();
	
	//echo "Enviando mail a ".$fila_usuario["nombre"]." (".$fila_usuario["email"].")...";

	mail_html($fila_usuario["email"],"website@mysterysur.com.ar","Mystery Sur",$fila_parametros["email_contactenos"],$fila_usuario["nombre"].", ten�s nuevas notificaciones en el sistema.",$html,strip_tags($html));
}

function enviarMailTicket($id_ticket){
	global $link;
	global $url_site;

	$html = generarTicket($id_ticket);
	
	$consulta = "SELECT
					th.dominio
					, c.nombre AS cliente
					, c.email AS email_cliente
				FROM
					tickets_hosting th
					JOIN clientes c ON th.id_cliente = c.id_cliente
				WHERE 
					th.id_ticket_hosting = ".$id_ticket."
				";
	//echo $consulta; 	 
	$result = mysql_query($consulta, $link);
	echo mysql_error($link);
	$fila = mysql_fetch_assoc($result);

	mail_html($fila["email_cliente"],"website@mysterysur.com.ar","Zephia Hosting Solutions","administracion@zephia.com.ar","Vencimiento servicio de hosting para ".$fila["dominio"],$html,strip_tags($html));
	
	mysql_query("UPDATE tickets_hosting SET fecha_envio = NOW(), enviado = 1 WHERE id_ticket_hosting = ".$id_ticket,$link);
	echo mysql_error($link);
}

function generarTicket($id_ticket){
	global $link;
	global $url_site;
	
	$consulta = "SELECT
					th.*
					, DATE_FORMAT(th.fecha_vencimiento,'%d/%m/%Y') AS vencimiento
					, DATE_FORMAT(th.fecha,'%d/%m/%Y') AS emision
					, c.nombre AS cliente
					, c.email AS email_cliente
					, p.descripcion AS plan
				FROM
					tickets_hosting th
					JOIN clientes c ON th.id_cliente = c.id_cliente
					JOIN hosting_planes p ON th.id_plan = p.id_plan
				WHERE 
					th.id_ticket_hosting = ".$id_ticket."
				";
	//echo $consulta; 	 
	$result = mysql_query($consulta, $link);
	echo mysql_error($link);
	$fila = mysql_fetch_assoc($result);

	ob_start();
	require("ticket_mail.inc.php");
	$html = ob_get_contents();
	ob_end_clean();
	
	return $html;
}

?>