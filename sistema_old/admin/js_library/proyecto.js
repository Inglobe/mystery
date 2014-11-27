function ocultar_tarea(id_tarea){
	tarea = document.getElementById("tarea_" + id_tarea);
	if(tarea.style.overflow=="hidden"){
		tarea.style.height="100%";
		tarea.style.overflow="visible";
		new Ajax.Request("tareas_ocultas.php",{method:"get",parameters:"id_tarea="+id_tarea+"&accion=o"});
	}
	else{
		tarea.style.height="23px";
		tarea.style.overflow="hidden";
		new Ajax.Request("tareas_ocultas.php",{method:"get",parameters:"id_tarea="+id_tarea+"&accion=a"});
	}
}
