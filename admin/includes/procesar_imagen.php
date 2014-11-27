<?php
$ancho_resize = 640;
$alto_resize = 480;

$imagen_info = getimagesize($ruta);

if($imagen_info[0]>=$imagen_info[1]){ //pregunta si es vertical u horizontal
	//horizontal
	$ancho = $ancho_resize;
	if($imagen_info[0]>$ancho_resize){//pregunta si es mas chica que lo que hay que resizear
		$procesar_imagen = true;
	}
	else{
		$procesar_imagen = false;
	}
}
else{
	//vertical
	$alto = $alto_resize;
	if($imagen_info[1]>$alto_resize){//pregunta si es mas chica que lo que hay que resizear
		$procesar_imagen = true;
	}
	else{
		$procesar_imagen = false;
	}
}

if($procesar_imagen){
	switch($imagen_info[2]) {
	    case 1:
	        // GIF image
	        $fuente = @imagecreatefromgif($ruta);
	        break;
	    case 2:
	        // JPEG image
	        $fuente = @imagecreatefromjpeg($ruta);
	        break;
	    case 3:
	        // PNG image
	        $is_png = true;
	        $fuente = @imagecreatefrompng($ruta);
	        break;
	}

	$imgAncho = imagesx($fuente);
	$imgAlto = imagesy($fuente);

	if(!isset($ancho)){
		$ancho=($imgAncho * $alto)/$imgAlto;
	}
	if(!isset($alto)){
		$alto=($imgAlto * $ancho)/$imgAncho;
	}
	if(!isset($alto) && !isset($ancho)){
		$alto=$imgAlto;
		$ancho=$imgAncho;
	}
	$imagen = imagecreatetruecolor($ancho,$alto);
	if($is_png){
		imagealphablending($imagen, false);
		imagesavealpha($imagen, true);
	}
	imagecopyresampled($imagen,$fuente,0,0,0,0,$ancho,$alto,$imgAncho,$imgAlto);

	switch($imagen_info[2]) {
	    case 1:
	        // GIF image
	        imagegif($imagen,$ruta);
	        break;
	    case 2:
	        // JPEG image
	        imagejpeg($imagen,$ruta);
	        break;
	    case 3:
	        // PNG image
	        imagealphablending($fuente, true);
			imagesavealpha($fuente, true);
	        imagepng($imagen,$ruta);
	        break;
	    default:
			imagejpeg($imagen,$ruta);
	}
}
?>