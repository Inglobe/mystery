<?
$uploads_dir = "imagenes/participantes";

$error = false;
$error_txt = "";

if(count($_FILES["Filedata"]["error"]) < 2) {
	$tmp_name = $_FILES["Filedata"]["tmp_name"];
	$name = rand(1,99999)."_".$_FILES["Filedata"]["name"];
	$ext = substr(strrchr($name, '.'), 1);
	switch(strtolower($ext)) {
		case 'jpg':	
		case 'jpeg':
		case 'png':
			move_uploaded_file($tmp_name, $uploads_dir."/".$name);
			
			/*$sql = "INSERT INTO 
						participantes (
							nombre,
							apellido,
							dni,
							provincia,
							localidad,
							email,
							telefono,
							trabaja,
							donde_trabaja,
							foto,
							activo
						)
						VALUES (
							'".mysql_real_escape_string(utf8_decode($_POST["nombre"]))."',
							'".mysql_real_escape_string(utf8_decode($_POST["apellido"]))."',
							'".mysql_real_escape_string(utf8_decode($_POST["dni"]))."',
							'".mysql_real_escape_string(utf8_decode($_POST["provincia"]))."',
							'".mysql_real_escape_string(utf8_decode($_POST["localidad"]))."',
							'".mysql_real_escape_string(utf8_decode($_POST["email"]))."',
							'".mysql_real_escape_string(utf8_decode($_POST["telefono"]))."',
							'".mysql_real_escape_string($_POST["trabaja"])."',
							'".mysql_real_escape_string(utf8_decode($_POST["donde_trabaja"]))."',
							'".mysql_real_escape_string($name)."',
							1
						)
					";
					
			mysql_query($sql, $link);
			
			$id_new = mysql_insert_id($link);*/
		break;
		default:
			$error = true;
			$error_txt = "Solo se aceptan archivos jpg y png.";
		break;
	}
}
else{
	$error = true;
	$error_txt = "No se pudo subir el archivo.";
}
?>