<?php
function resaltar_palabra($palabra, $texto){
    //return str_ireplace($palabra, "<strong>" . $palabra . "</strong>", $texto);
    return str_highlight($texto, $palabra);
}
function str_highlight($text, $needle, $highlight = null){
    $ekezet = array("(í|Í)", "(á|Á)", "(é|É)", "(ö|Ö)", "(ü|Ü)", "(ó|Ó)", "(o|O)", "(ú|Ú)", "(u|U)");
    $rep_reg = array("[Íí]{1}", "[Áá]{1}", "[Éé]{1}", "[Öö]{1}", "[Üü]{1}", "[Óó]{1}", "[Oo]{1}", "[Úú]{1}", "[Uu]{1}");
    if ($highlight === null) {
        $highlight = '<span class="resaltado">\1</span>';
    }
    $pattern = '/(?!<.*?)(%s)(?![^<>]*?>)/i';
    $needle = (array) $needle;
    foreach ($needle as $needle_s) {
        $needle_s = preg_quote($needle_s);
        $needle_s = preg_replace($ekezet, $rep_reg, $needle_s);
        $regex = sprintf($pattern, $needle_s);
        $text = preg_replace($regex, $highlight, $text);
    }
    return $text;
}
function getExtension($archivo){
	$aux = explode(".",$archivo);
	foreach($aux as $tipo){
		$extencion = $tipo;
	}
	$extencion = strtolower($extencion);
	return $extencion;
}
?>