<?php

	require_once("../includes/config.php");
	require_once("../includes/paths.php");
	
	require_once(PATH_DATABASE);

	function escape($str){
		$str = str_replace("'","\'",$str);
		$str = str_replace('"','\"',$str);
		return($str);
	}
	
	$nom_archivo = 'backup_'.date("d-m-Y");
	$salida = '';
	$output = '';
	
	$db = new database;
	
	$tables = $db->tables();
	
	foreach ($tables as $table){
		
		$output .= $db->table_structure($table)."\n\n";
		
		$db->query('SELECT * FROM '.$table);
		
		while($db->fetch()){
			
			$values = $db->getValues();
			
			$values = array_map('escape',$values);
			
			$output .= "INSERT INTO ".$table." VALUES ('".implode("','",$values)."');\n";
		}
		
		$output .= "\n";
	}
	
	/*
	while($row = mysql_fetch_row($res)) {
		
		$table = $row[0]; // Cada una de las tablas
		$res2 = mysql_query("SHOW CREATE TABLE ".$table);
		
		while($lin = mysql_fetch_row($res2)) { // Para cada tabla
			$salida .= $lin[1].";";
			// salto de linha
			$salida .= "\n";
			$res3 = mysql_query("SELECT * FROM ".$table);
			while($r = mysql_fetch_row($res3)) { // Dump de todas las tablas
				# Sacar comillas simple!!
				$r = str_replace("'","\'",$r);
				$r = str_replace('"','\"',$r);
	
				$sql = "INSERT INTO ".$table." VALUES ('";
				$sql .= implode("','",$r);
				$sql .= "');";
				$salida .= $sql;
	
				$salida .= "\n";
			}
			$salida .= "\n";
		}
	}*/
	
	echo $output;
	exit();
	
	$zipfile = new zipfile();
	$zipfile -> addFile($output, $nom_archivo.".sql");
	$salida = $zipfile -> file();
	
	header('Content-Type: application/octet-stream');
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Content-Disposition: inline; filename="' . $nom_archivo.".zip" . '"');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	
	print $salida;
?>