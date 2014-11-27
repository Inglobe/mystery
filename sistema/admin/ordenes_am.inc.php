<?
	include("procesos_globales.php");
	
	if($_GET["abm_accion"] == "m"){
		$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT id_proyecto, id_cliente FROM ordenes WHERE id_orden = ".$_GET["id"],$link));
		$_GET["id_cliente"] = (!isset($_GET["id_cliente"])?$fila_tmp["id_cliente"]:$_GET["id_cliente"]);
	}
?>
<select id="combo_id_proyecto" name="combo_id_proyecto">
    <option value="0">--seleccionar--</option>
    <?
	if(isset($_GET["id_cliente"])){
		$consulta_proy = "SELECT nombre, id_proyecto FROM proyectos WHERE id_cliente = ".$_GET["id_cliente"];
		$result_proy = mysql_query($consulta_proy, $link);
		echo mysql_error($link);
		while($fila_proy = mysql_fetch_assoc($result_proy)){
	?>
	<option value="<?=$fila_proy["id_proyecto"]?>" <?=($fila_proy["id_proyecto"] == $fila_tmp["id_proyecto"]?"selected=\"selected\"":"")?>><?=xhtmlOut($fila_proy["nombre"])?></option>
	<?
		}
	}
	?>
</select>