document.observe('dom:loaded', function() {
	var changeEffect;
	Sortable.create('scroll', { tag: 'div', overlap:'horizontal',constraint:false, scroll: false,
		onUpdate: function() {
			new Ajax.Request("gallery_orden.php", {
				method: "post",
				onLoading: function(){$('activityIndicator').show()},
				onLoaded: function(){$('activityIndicator').hide()},
				parameters: { data: Sortable.serialize("scroll") }
			});
		}
	});
});