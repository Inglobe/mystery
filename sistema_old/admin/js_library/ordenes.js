$("combo_id_cliente").onchange = function(){
	new Ajax.Updater($("cont_proyectos"), "ordenes_am.inc.php", {parameters: "id_cliente=" + this.value, method: "get"})
}