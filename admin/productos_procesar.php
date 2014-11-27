<?
	//PARAMETROS
	$nombre_abm="productos";
	$tabla_nombre="productos";
	$id_nombre="id_producto";
	//FIN PARAMETROS

	$datos = makeDatosByPost($_POST,$_FILES);

	if($destacado==1){
		mysql_query("UPDATE ".$tabla_nombre." SET home = 0",$link);
		echo mysql_error($link);
	}
	
	//print_r($_POST);

	function actualizar_productos_caracteristicas($id,$mat_ids){
		global $link;

		mysql_query("DELETE FROM productos_caracteristicas WHERE id_producto = ".$id,$link);
		echo mysql_error($link);

		if(is_array($mat_ids)){
			foreach($mat_ids as $id_rel){
				$consulta = "INSERT INTO productos_caracteristicas VALUES('".$id."','".$id_rel."')";
				mysql_query($consulta,$link);
				echo mysql_error($link);
			}
		}
	}

 	switch($abm_accion){
 		case "a":
			foreach($datos as $campos){
				$nombres_insert[] = $campos["nombre_campo"];
				switch($campos["tipo_campo"]){
					case "foto":
						$path=$_POST["path_foto_".$campos["nombre_campo"]];
						$nom_archivo=$campos["nombre_campo"];
						include("includes/agregar_foto.php");

						$valores_insert[] = ${"nombre_".$campos["nombre_campo"]};
					break;
					case "data":
						$path=$_POST["path_data_".$campos["nombre_campo"]];
						$nom_archivo=$campos["nombre_campo"];
						include("includes/agregar_archivo.php");

						$valores_insert[] = ${"nombre_".$campos["nombre_campo"]};
					break;
					default:
						$valores_insert[] = $campos["valor_campo"];
					break;
				}
			}
			$stringq="INSERT INTO ".$tabla_nombre;
			$stringq.="(".$id_nombre.",".implode(",",$nombres_insert).") ";
			$stringq.=" VALUES('','".implode("','",$valores_insert)."') ";;
			mysql_query($stringq,$link);
			//echo "<hr>".$stringq."<hr>";
			echo mysql_error($link);
			$id_nuevo = mysql_insert_id($link);

			actualizar_productos_caracteristicas($id_nuevo,$_POST["ids_caracteristicas"]);

			include("gallery_add_procesar.inc.php");

			$redireccionar=$nombre_abm."_am";
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
						if($_POST["borrar_foto_".$campos["nombre_campo"]] != 1){
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
						$path=$_POST["path_data_".$campos["nombre_campo"]];
						$nom_archivo=$campos["nombre_campo"];
						include("includes/agregar_archivo.php");
						if($_POST["borrar_data_".$campos["nombre_campo"]] != 1){
							if(${"nombre_".$campos["nombre_campo"]} != ""){
								$stringq.= $campos["nombre_campo"]." = '".${"nombre_".$campos["nombre_campo"]}."'";
							}
							else{
								$stringq.= $campos["nombre_campo"]." = ".$campos["nombre_campo"];
							}
						}
						else{
							$stringq.=$campos["nombre_campo"]." = '' ";
						}
					break;
					default:
						$stringq.= $campos["nombre_campo"]." = '".$campos["valor_campo"]."'";
					break;
				}
				$cont_campos_update++;
			}

			$stringq.= " WHERE ".$id_nombre." = '".$id."'";
			mysql_query($stringq,$link);
			//echo "<hr>".$stringq."<hr>";
			echo mysql_error($link);

			actualizar_productos_caracteristicas($id,$_POST["ids_caracteristicas"]);

			$redireccionar=$nombre_abm."_search";
		break;

		case "d":
			/*$path="../imagenes/proyectos/fotos/";
			$nom_campo="foto_lista";
			include("includes/check_foto.php");

			$path="../imagenes/proyectos/fotos/";
			$nom_campo="foto_contenido";
			include("includes/check_foto.php");

			$path="../imagenes/proyectos/logos/";
			$nom_campo="logo";
			include("includes/check_foto.php");*/

			$stringq="DELETE FROM ".$tabla_nombre." WHERE ".$id_nombre." = ".$id;
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
	  setTimeout('redireccionar("index.php?put=<?=$redireccionar?>&feed=<?=$abm_accion?>&abm_accion=<?=$abm_accion?>")', 1500);
	//-->
	</script>