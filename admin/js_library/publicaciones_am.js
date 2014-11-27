$('combo_id_categoria').onchange = function(){
	new Ajax.Updater('updater_obj','get_tipo_publicacion.ajax.php',{
		method:"post",
		evalScripts:true,
		parameters:{
			id_categoria:$F(this)
		}
	});
}
