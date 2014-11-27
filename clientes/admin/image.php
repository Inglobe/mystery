<?php
ini_set("display_errors","0");
if($imagen_info = getimagesize($_GET["ruta"])){
	switch($imagen_info[2]) {
	    case 1:
	        // GIF image
	        $fuente = @imagecreatefromgif($_GET["ruta"]);
	        break;
	    case 2:
	        // JPEG image
	        $fuente = @imagecreatefromjpeg($_GET["ruta"]);
	        break;
	    case 3:
	        // PNG image
	        $is_png = true;
	        $fuente = @imagecreatefrompng($_GET["ruta"]);
	        break;
	}
}
else{
	$fuente = @imagecreatefromjpeg("images/imagen_default.jpg");
}

$alto = $_GET["alto"];
$ancho = $_GET["ancho"];
$imgAncho = imagesx($fuente);
$imgAlto = imagesy($fuente);
if($_GET["mantener_ratio"]){
	if(isset($alto) && isset($ancho)){
		$imagen = imagecreatetruecolor($ancho,$alto);

		if($alto < $ancho){//si el lienzo es horizontal
			if($imgAlto < $imgAncho){//si la imagen es horizontal
				if($_GET["franjas"]){
					//codigo de las franjas
					if(($alto/$ancho) < ($imgAlto/$imgAncho)){
						$alto_dst = $alto;
						$ancho_dst = ($imgAncho / $imgAlto) * $alto;
					}
					else {
						$ancho_dst = $ancho;
						$alto_dst = ($imgAlto / $imgAncho) * $ancho;
					}
				}
				else{
					if(($alto/$ancho) < ($imgAlto/$imgAncho)){
						$ancho_dst=$ancho;
						$alto_dst=($imgAlto * $ancho)/$imgAncho;
					}
					else{
						$ancho_dst=($imgAncho * $alto)/$imgAlto;
						$alto_dst=$alto;
					}
				}
			}
			else{ //si la imagen es vertical
				if($_GET["franjas"]){
					//codigo de las franjas
					if(($alto/$ancho) < ($imgAlto/$imgAncho)){
						$alto_dst = $alto;
						$ancho_dst = ($imgAncho / $imgAlto) * $alto;
					}
					else {
						$ancho_dst = $ancho;
						$alto_dst = ($imgAlto / $imgAncho) * $ancho;
					}
				}
				else {
					if(($alto/$ancho) < ($imgAlto/$imgAncho)){
						$ancho_dst=$ancho;
						$alto_dst=($imgAlto * $ancho)/$imgAncho;
					}
					else{
						$ancho_dst=($imgAncho * $alto)/$imgAlto;
						$alto_dst=$alto;
					}
				}
			}
		}
		else{//si el lienzo es vertical
			//aca deberia ir la otra parte de la cropeada horizontal
			if($imgAlto < $imgAncho){//si la imagen es horizontal
				if($_GET["franjas"]){
					//codigo de las franjas
					if(($alto/$ancho) < ($imgAlto/$imgAncho)){
						$alto_dst = $alto;
						$ancho_dst = ($imgAncho / $imgAlto) * $alto;
					}
					else {
						$ancho_dst = $ancho;
						$alto_dst = ($imgAlto / $imgAncho) * $ancho;
					}
				}
				else{
					if(($alto/$ancho) < ($imgAlto/$imgAncho)){
						$ancho_dst=$ancho;
						$alto_dst=($imgAlto * $ancho)/$imgAncho;
					}
					else{
						$ancho_dst=($imgAncho * $alto)/$imgAlto;
						$alto_dst=$alto;
					}
				}
			}
			else{ //si la imagen es vertical
				if($_GET["franjas"]){
					//codigo de las franjas
					if(($alto/$ancho) < ($imgAlto/$imgAncho)){
						$alto_dst = $alto;
						$ancho_dst = ($imgAncho / $imgAlto) * $alto;
					}
					else {
						$ancho_dst = $ancho;
						$alto_dst = ($imgAlto / $imgAncho) * $ancho;
					}
				}
				else {
					if(($alto/$ancho) < ($imgAlto/$imgAncho)){
						$ancho_dst=$ancho;
						$alto_dst=($imgAlto * $ancho)/$imgAncho;
					}
					else{
						$ancho_dst=($imgAncho * $alto)/$imgAlto;
						$alto_dst=$alto;
					}
				}
			}
		}
		$posicion_x_src=0;
		$posicion_y_src=0;
		$posicion_x_dst=round(($ancho - $ancho_dst)/2);
		$posicion_y_dst=round(($alto - $alto_dst)/2);

		//$posicion_y_dst=($alto/2) - ((($alto * $imgAncho )/$ancho)/2);

		imagefilledrectangle($imagen,0,0,$ancho,$alto,imagecolorallocate($imagen,255,255,255));
		imagecopyresampled($imagen,$fuente,$posicion_x_dst,$posicion_y_dst,$posicion_x_src,$posicion_y_src,$ancho_dst,$alto_dst,$imgAncho,$imgAlto);
	}
}
else{
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
}
if($firmar){
	$texto = "www.develgroup.com";
	$tamanio = 16;
	$angulo = 0;
	$pos_x = $ancho - 180;
	$pos_y = $alto - 15;
	$grosor_border = 1;
	$tipografia = "fujin.ttf";

	imagettftext($imagen,$tamanio,$angulo,$pos_x+$grosor_border,$pos_y,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x-$grosor_border,$pos_y,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x,$pos_y+$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x,$pos_y-$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x+$grosor_border,$pos_y+$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x-$grosor_border,$pos_y-$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x+$grosor_border,$pos_y-$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x-$grosor_border,$pos_y+$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);

	imagettftext($imagen,$tamanio,$angulo,$pos_x,$pos_y,ImageColorAllocate($imagen, 255, 255, 255),$tipografia,$texto);
}
if($vendido){
	$texto = "Vendido";
	$tamanio = 24;
	$angulo = 30;
	$pos_x = ($ancho / 2) - 25;
	$pos_y = ($alto / 2) + 30;
	$grosor_border = 2;
	$tipografia = "fujin.ttf";

	imagettftext($imagen,$tamanio,$angulo,$pos_x+$grosor_border,$pos_y,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x-$grosor_border,$pos_y,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x,$pos_y+$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x,$pos_y-$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x+$grosor_border,$pos_y+$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x-$grosor_border,$pos_y-$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x+$grosor_border,$pos_y-$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);
	imagettftext($imagen,$tamanio,$angulo,$pos_x-$grosor_border,$pos_y+$grosor_border,ImageColorAllocate($imagen, 0x33, 0x33, 0x33),$tipografia,$texto);

	imagettftext($imagen,$tamanio,$angulo,$pos_x,$pos_y,ImageColorAllocate($imagen, 255, 255, 255),$tipografia,$texto);
}
header("Content-type: image/jpeg");
switch($imagen_info[2]) {
    case 1:
        // GIF image
        imagegif($imagen);
        break;
    case 2:
        // JPEG image
        imagejpeg($imagen,null,95);
        break;
    case 3:
        // PNG image
        imagealphablending($fuente, true);
		imagesavealpha($fuente, true);
        imagepng($imagen);
        break;
    default:
		imagejpeg($imagen,null,95);
}
?>