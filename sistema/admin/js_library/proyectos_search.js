function setStatusSubmit(id_estado){
	$("id_estado").value = id_estado;
	$("projects_form").submit();
}

$("status_1").onclick = function(){
	setStatusSubmit(1);
};

$("status_2").onclick = function(){
	setStatusSubmit(2);
};

$("status_3").onclick = function(){
	setStatusSubmit(3);
};

$("status_all").onclick = function(){
	window.location = "index.php?put=proyectos_search";
};

$("deshabilitar_fechas").onclick = function(){
	if($("deshabilitar_fechas").checked){
		$("filtro_fecha_from").disabled = true;
		$("filtro_fecha_to").disabled = true;
	}else{
		$("filtro_fecha_from").disabled = false;
		$("filtro_fecha_to").disabled = false;
	}
}

$("filtro_id_cliente").onchange = function(){

	var combo = $("filtro_id_sucursal");

	vaciarCombo(combo);

	var item = document.createElement("option");
	item.value = "0";
	item.appendChild(document.createTextNode("--todos--"));
	combo.appendChild(item);

	var mysql = new MySQLDatabase();
	var sql_query = "SELECT id_sucursal, nombre FROM sucursales WHERE id_cliente = " + this.value + " ORDER BY nombre ASC";
	mysql.query(sql_query);
	while(mysql.nextRow()){
		var item = document.createElement("option");
		item.value = mysql.getField("id_sucursal");
		item.appendChild(document.createTextNode(mysql.getField("nombre")));
		combo.appendChild(item);
	}
}