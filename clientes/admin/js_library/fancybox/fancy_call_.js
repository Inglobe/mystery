$(document).ready(function() {
	$("a.fancybox").fancybox({
		'opacity'		: true,
		'transitionIn'		: 'elastic',
		'transitionOut'		: 'elastic',
		'titlePosition' 	: 'over',
		'overlayColor'		: '#000',
	});
	$("a[rel=grupo_fotos]").fancybox({
				'titlePosition' 	: 'over',
				'overlayColor'		: '#000',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Imag&eacute;n ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
		}
	});
	$(".iframe_boutique").fancybox({
				'width'				: 1000,
				'height'			: 430,
				'overlayColor'		: '#000',
				'type'				: 'iframe'
	});
	$(".iframe_accesorios").fancybox({
				'width'				: 1000,
				'height'			: 430,
				'overlayColor'		: '#000',
				'type'				: 'iframe'
	});
	$(".iframe_206").fancybox({
				'width'				: 1000,
				'height'			: 650,
				'overlayColor'		: '#000',
				'type'				: 'iframe'
	});
	$(".iframe_207").fancybox({
				'width'				: 1000,
				'height'			: 650,
				'overlayColor'		: '#000',
				'type'				: 'iframe'
	});
	$(".iframe_partner").fancybox({
				'width'				: 1000,
				'height'			: 500,
				'overlayColor'		: '#000',
				'type'				: 'iframe'
	});
});

