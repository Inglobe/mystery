$(document).ready(function() {
	$("a.fancybox").fancybox({
		'opacity'		: true,
		'transitionIn'		: 'elastic',
		'transitionOut'		: 'elastic',
		'titlePosition' 	: 'over',
		'overlayColor'		: '#000'
	});
	$("a[rel=grupo_fotos]").fancybox({
				'titlePosition' 	: 'over',
				'overlayColor'		: '#000',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Imagen ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
		}
	});
	$(".iframe_agenda").fancybox({
				'width'				: "50%",
				'height'			: "90%",
				'overlayColor'		: '#000',
				'type'				: 'iframe'
	});
});

