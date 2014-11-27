<?php
if(!(strpos($ruta ,".jpg") != false || strpos($ruta ,".JPG") != false)){
	$ruta = "../imagenes/imagen_default.jpg";
}
$fuente = @imagecreatefromjpeg ($ruta);
if(!$fuente){
	$fuente = @imagecreatefromjpeg ("../imagenes/imagen_default.jpg");
}
$imgAncho = imagesx($fuente);
$imgAlto = imagesy($fuente);
if($mantener_ratio==1){
	if(isset($alto) && isset($ancho)){
		$imagen = imagecreatetruecolor($ancho,$alto);
		if($alto < $ancho){
			//if($imgAlto > $imgAncho){
				$ancho_dst=$ancho;
				$alto_dst=($imgAlto * $ancho)/$imgAncho;
				$posicion_x_src=0;
				$posicion_y_src=($imgAlto/2)-((($alto * $imgAncho )/$ancho)/2);
			/*}
			else{
				$ancho_dst=$ancho;
				$alto_dst=($imgAlto * $ancho)/$imgAncho;
				$posicion_x_src=($imgAncho/2)-($ancho/2);
				$posicion_y_src=0;
			}*/
		}
		else{

		}
		$posicion_x_dst=0;
		$posicion_y_dst=0;
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
	imagecopyresampled($imagen,$fuente,0,0,0,0,$ancho,$alto,$imgAncho,$imgAlto);
}
if($firmar==1){
	imagettftext($imagen,9,-90,10,10,ImageColorAllocate($imagen, 255,255,255),"verdanab.ttf","www.jasatel.com");
}
Header("Content-type: image/jpeg");
imagejpeg($imagen);
?>

