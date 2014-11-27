<?php
function resaltar_palabra($palabra, $texto){
    //return str_ireplace($palabra, "<strong>" . $palabra . "</strong>", $texto);
    return str_highlight($texto, $palabra);
}
function str_highlight($text, $needle, $highlight = null){
    $ekezet = array("(�|�)", "(�|�)", "(�|�)", "(�|�)", "(�|�)", "(�|�)", "(o|O)", "(�|�)", "(u|U)");
    $rep_reg = array("[��]{1}", "[��]{1}", "[��]{1}", "[��]{1}", "[��]{1}", "[��]{1}", "[Oo]{1}", "[��]{1}", "[Uu]{1}");
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