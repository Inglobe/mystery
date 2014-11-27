<?php
	require("procesos_globales.php");

	switch($_POST["delimitador"]){
		case "PUNTOYCOMA";
			$delimitador_car=";";
		break;
		case "COMA";
			$delimitador_car=",";
		break;
		case "PUNTO";
			$delimitador_car=".";
		break;
		case "COMILLAS";
			$delimitador_car="\"";
		break;
		case "TAB";
			$delimitador_car="\t";
		break;
		case "ESPACIO";
			$delimitador_car=" ";
		break;
	}

	$ruta="tmp/".rand(0,99999)."_".$_FILES["archivo"]["name"];
	move_uploaded_file($_FILES["archivo"]["tmp_name"],$ruta);

	$fp_dump = fopen($ruta,"r");

	$cont_procesados = 0;
	$cont_duplicados = 0;
	$cont_erroneos = 0;
	$cont_insertados = 0;

	while(!feof($fp_dump)){
		$cont_procesados++;

		$matriz_tmp = fgetcsv($fp_dump,512,$delimitador_car);

		$email = strtolower(trim($matriz_tmp[0]));
		$nombre = str_replace("'","",$matriz_tmp[1]);

		if(comprobar_email($email)){
			if(!comprobar_email_duplicado($email,$_POST["id_grupo_news"])){
				$cont_insertados++;

				$cadena="INSERT INTO 	usuarios_news
										(fecha, nombre, email, id_grupo_news, activo)
							VALUES		(NOW(),'".$nombre."','".$email."','".$_POST["id_grupo_news"]."','1')";
				mysql_query($cadena,$link);
				echo mysql_error($link);

				//echo "<hr>".$email." | ".$nombre."<br>";
			}
			else{
				$cont_duplicados++;
			}
		}
		else{
			$cont_erroneos++;
		}
	}
	//sabian B8 pro 16''

	fclose($fp_dump);
	unlink($ruta);
?>
	<div id="contenido">
      <table width="100%" border="0" cellspacing="50" cellpadding="0">
        <tr>
          <td align="center"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/please_wait.gif" alt="please wait" /></td>
        </tr>
      </table>
    </div>
    <script language="JavaScript">
	<!--
    function redireccionar(url) {
		location.href=url;
	}
	setTimeout('redireccionar("newsletters_importar_contactos_feed.php?proc=<?=$cont_procesados?>&dup=<?=$cont_duplicados?>&err=<?=$cont_erroneos?>&ins=<?=$cont_insertados?>")', 1500);
	//-->
	</script>