<?php
	function xmlcharacters($string, $trans='') {
		$trans=(is_array($trans))? $trans:get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
		foreach ($trans as $k=>$v)
			$trans[$k]= "&#".ord($k).";";
		return strtr($string, $trans);
	}

	header("Content-Type: text/xml; charset=iso-8859-1");

	include("../includes/conexion.inc.php");
	$result=mysql_query($_GET["query"].$_POST["query"],$link);
	echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\n";
	echo "<raiz>\n";
	while($fila=mysql_fetch_array($result)){
		echo "\t<fila>\n";
		$claves=array_keys($fila);
		foreach($claves as $clave){
			if(!is_integer($clave)){
				echo "\t\t<".$clave.">";
				echo xmlcharacters($fila[$clave]);
				echo "</".$clave.">\n";
			}
		}
		echo "\t</fila>\n";
	}
	echo "</raiz>";
?>