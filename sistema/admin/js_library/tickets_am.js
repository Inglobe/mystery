$("combo_id_plan").observe("change", function(ev){
	//alert("change");
	$("texto_monto").setValue("cargando...");

	new Ajax.Request("tickets_am.ajax_monto.php", {
	  method: 'get',
	  parameters: {id:$F(this)},
	  onSuccess: function(transport) {
		//alert(transport.responseText);
		var monto = transport.responseText;
		
		$("texto_monto").setValue(monto);
	  }
	});
	
	new Ajax.Request("tickets_am.ajax_detalle.php", {
	  method: 'get',
	  parameters: {id:$F(this)},
	  onSuccess: function(transport) {
		alert(transport.responseText);
		var detalle = transport.responseText;
		
		$("detalle").setValue(detalle);
	  }
	});
});

