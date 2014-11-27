<div class="recuadrito_lista">
<?
	$consulta = "SELECT * FROM galerias ORDER BY nombre ASC";
	$result_rel = mysql_query($consulta,$link);
	echo mysql_error($link);
	while($fila_rel = mysql_fetch_assoc($result_rel)){

?>
  <label><input name="ids_galerias[]" type="checkbox" value="<?=$fila_rel["id_galeria"]?>" <?
  		if($_GET["abm_accion"] == "m"){
	  		$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS nro FROM galerias_news WHERE id_new = ".$_GET["id"]." AND id_galeria = ".$fila_rel["id_galeria"],$link));
	  		echo mysql_error($link);
	  		if($fila_tmp["nro"] == 1){
	  			echo "checked";
			}
		}
  ?>/><?=$fila_rel["nombre"]?></label>
<?
	}
?>
</div>