<?
	require("procesos_globales.php");
	
	function to_utf8($in){
		if (is_array($in)) {
			foreach ($in as $key => $value) {
				$out[to_utf8($key)] = to_utf8($value);
			}
		} elseif(is_string($in)) {
			if(mb_detect_encoding($in) != "UTF-8")
				return utf8_encode($in);
			else
				return $in;
		} else {
			return $in;
		}
		return $out;
	} 
	
	$sql = "
		SELECT 
			l.*
		FROM
			localidades l
			JOIN departamentos d ON l.departamento_id = d.id
		WHERE
			d.provincia_id = ".(int)$_GET["pid"]."
	";
	
	//echo $sql;
	
	$result = mysql_query($sql,$link);
	echo mysql_error($link);

	$data = array();

	print_r($result);

	while($fila = mysql_fetch_assoc($result)){
		$data[] = to_utf8($fila);
	}
	
	header('Content-Type: application/json');
	
	echo json_encode($data);
?>