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
	window.location = "index.php?put=tickets_search";
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