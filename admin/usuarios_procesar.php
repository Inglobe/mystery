<?
	//PARAMETROS
	$nombre_abm="usuarios";
	$tabla_nombre="usuarios";
	$id_nombre="id_usuario";

	//FIN PARAMETROS

	$datos = makeDatosByPost($_POST,$_FILES);

 	switch($_GET["abm_accion"]){
 		case "a":
			foreach($datos as $campos){
				$nombres_insert[] = $campos["nombre_campo"];
				switch($campos["tipo_campo"]){
					case "foto":
						$path=$_POST["path_foto_".$campos["nombre_campo"]];
						$nom_archivo=$campos["nombre_campo"];
						include("includes/agregar_foto.php");

						$valores_insert[] = "'".${"nombre_".$campos["nombre_campo"]}."'";
					break;
					case "data":
						$valores_insert[] = "'".$campos["valor_campo"]."'";
					break;
					case "pass":
						$valores_insert[] = "MD5('".$campos["valor_campo"]."')";
					break;
					default:
						$valores_insert[] = "'".$campos["valor_campo"]."'";
					break;
				}
			}
			$stringq="INSERT INTO ".$tabla_nombre;
			$stringq.="(".$id_nombre.",".implode(",",$nombres_insert).") ";
			$stringq.=" VALUES('',".implode(",",$valores_insert).") ";
			mysql_query($stringq,$link);
			//echo "<hr>".$stringq."<hr>";
			echo mysql_error($link);

			$redireccionar=$nombre_abm."_am";
			
			include("usuarios_sincronizar_newsletter.php");
		break;

		case "m":
			$stringq = "UPDATE ".$tabla_nombre." SET ";
			$cont_campos_update=0;
			$total_campos_update = count($datos);

			foreach($datos as $campos){
				$stringq.= (($cont_campos_update==$total_campos_update || $cont_campos_update==0)?"":", ");

				switch($campos["tipo_campo"]){
					case "foto":

						$path=$_POST["path_foto_".$campos["nombre_campo"]];
						$nom_archivo=$campos["nombre_campo"];
						include("includes/agregar_foto.php");

						$nom_archivo=$campos["nombre_campo"];
						$nom_campo=$campos["nombre_campo"];
						include("includes/check_archivo.php");
						if($_POST["borrar_".$campos["nombre_campo"]] != 1){
							if($_FILES["foto_".$campos["nombre_campo"]]["name"] != ""){
								$stringq.=$campos["nombre_campo"]." = '".${"nombre_".$campos["nombre_campo"]}."' ";
							}
							else{
								$stringq.=$campos["nombre_campo"]." = ".$campos["nombre_campo"]." ";
							}
						}
						else{
							$stringq.=$campos["nombre_campo"]." = '' ";
						}
					break;
					case "data":
						$stringq.= $campos["nombre_campo"]." = '".$campos["valor_campo"]."'";
					break;
					case "pass":
						if($campos["valor_campo"] != ""){
							$stringq.= $campos["nombre_campo"]." = MD5('".$campos["valor_campo"]."')";
						}
						else{
							$stringq.=$campos["nombre_campo"]." = ".$campos["nombre_campo"]." ";
						}
					break;
					default:
						$stringq.= $campos["nombre_campo"]." = '".$campos["valor_campo"]."'";
					break;
				}
				$cont_campos_update++;
			}

			$stringq.= " WHERE ".$id_nombre." = '".$_GET["id"]."'";
			mysql_query($stringq,$link);
			//echo "<hr>".$stringq."<hr>";
			echo mysql_error($link);

			$redireccionar=$nombre_abm."_search";
			
			include("usuarios_sincronizar_newsletter.php");
		break;

		case "d":
			$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT CONCAT(nombre,' ',apellido) AS nombre FROM usuarios WHERE id_usuario = ".$_GET["id"],$link));
			
			$stringq="DELETE FROM usuarios_news WHERE nombre LIKE '".$fila_tmp["nombre"]."'";
			mysql_query($stringq,$link);
		
			$stringq="DELETE FROM ".$tabla_nombre." WHERE ".$id_nombre." = ".$_GET["id"];
			mysql_query($stringq,$link);

			//echo $stringq;
			echo mysql_error($link);
			$redireccionar=$nombre_abm."_search";
		break;
	}
?>
    <div id="contenido">
      <table width="100%" border="0" cellspacing="100" cellpadding="0">
        <tr>
          <td align="center"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/please_wait.gif" alt="please wait" /></td>
        </tr>
      </table>
    </div>
    <script language="JavaScript">
	<!--
	  setTimeout('redireccionar("index.php?put=<?=$redireccionar?>&feed=<?=$_GET["abm_accion"]?>&abm_accion=<?=$_GET["abm_accion"]?>")', 1500);
	//-->
	</script>