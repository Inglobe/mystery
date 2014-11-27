$("cmb_id_cliente").onchange = function(){
	var combo = $("cmb_id_contacto_responsable")

	vaciarCombo(combo);

	var item = document.createElement("option");
	item.value = "0";
	item.appendChild(document.createTextNode("--seleccione--"));
	combo.appendChild(item);

	var mysql = new MySQLDatabase();
	var sql_query = "SELECT id_contacto, nombre FROM contactos WHERE id_cliente = " + this.value + " ORDER BY nombre ASC";
	mysql.query(sql_query);
	while(mysql.nextRow()){
		var item = document.createElement("option");
		item.value = mysql.getField("id_contacto");
		item.appendChild(document.createTextNode(mysql.getField("nombre")));
		combo.appendChild(item);
	}
	
	var combo2 = $("cmb_id_sucursal")

	vaciarCombo(combo2);

	var item = document.createElement("option");
	item.value = "0";
	item.appendChild(document.createTextNode("--seleccione--"));
	combo2.appendChild(item);

	var mysql = new MySQLDatabase();
	var sql_query = "SELECT id_sucursal, nombre FROM sucursales WHERE id_cliente = " + this.value + " ORDER BY nombre ASC";
	mysql.query(sql_query);
	while(mysql.nextRow()){
		var item = document.createElement("option");
		item.value = mysql.getField("id_sucursal");
		item.appendChild(document.createTextNode(mysql.getField("nombre")));
		combo2.appendChild(item);
	}
}

$("proyecto_procesar").onsubmit = function(){
	if($("cmb_id_cliente").value == 0){
		alert("Campo requerido.");
        $("cmb_id_cliente").style.background = "#E9D7D6";
      	$("cmb_id_cliente").focus();
       	return false;
	}
	if($("cmb_id_sucursal").value == 0){
		alert("Campo requerido.");
        $("cmb_id_sucursal").style.background = "#E9D7D6";
      	$("cmb_id_sucursal").focus();
       	return false;
	}
	if($("cmb_id_contacto_responsable").value == 0){
		alert("Campo requerido.");
        $("cmb_id_contacto_responsable").style.background = "#E9D7D6";
      	$("cmb_id_contacto_responsable").focus();
       	return false;
	}
	if($("cmb_id_tipo_proyecto").value == 0){
		alert("Campo requerido.");
        $("cmb_id_tipo_proyecto").style.background = "#E9D7D6";
      	$("cmb_id_tipo_proyecto").focus();
       	return false;
	}
	if($("nombre").value == ""){
		alert("Campo requerido.");
        $("nombre").style.background = "#E9D7D6";
      	$("nombre").focus();
       	return false;
	}
	if($("cmb_id_usuario_responsable").value == 0){
		alert("Campo requerido.");
        $("cmb_id_usuario_responsable").style.background = "#E9D7D6";
      	$("cmb_id_usuario_responsable").focus();
       	return false;
	}
	if($("cmb_id_usuario_supervisor").value == 0){
		alert("Campo requerido.");
        $("cmb_id_usuario_supervisor").style.background = "#E9D7D6";
      	$("cmb_id_usuario_supervisor").focus();
       	return false;
	}

	return true;
}