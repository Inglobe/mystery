<div class="recuadrito_lista">
<?
	$consulta = "SELECT * FROM news_secciones ORDER BY descripcion";
	$result_rel = mysql_query($consulta,$link);
	echo mysql_error($link);
	while($fila_rel = mysql_fetch_assoc($result_rel)){
?>
  <label><input name="ids_secciones[]" type="checkbox" value="<?=$fila_rel["id_seccion"]?>" <?
  		if($_GET["abm_accion"] == "m"){
	  		$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS nro FROM secciones_categorias WHERE id_categoria = ".$_GET["id"]." AND id_seccion = ".$fila_rel["id_seccion"],$link));
	  		echo mysql_error($link);
	  		if($fila_tmp["nro"] == 1){
	  			echo "checked";
			}
		}
  ?>> <?=$fila_rel["descripcion"]?></label>
<?
	}
?>
</div>
