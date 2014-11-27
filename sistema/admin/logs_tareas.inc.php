<?
require_once("procesos_globales.php");
?>
  <table width="615" border="0" cellpadding="0" cellspacing="0">
	<tbody>
	<?
		$consulta_log = "SELECT
						lc.*
						, DATE_FORMAT(lc.fecha,'%d/%m/%Y') AS fecha_f
						, DATE_FORMAT(lc.fecha,'%H:%i') AS hora_f
						, u.user AS usuario
					FROM 
						logs_tareas lc
						, usuarios u
					WHERE
						lc.id_tarea = ".$_GET["id_tarea"]."
					AND
						lc.id_usuario = u.id_usuario
					ORDER BY
						fecha DESC
					";
		$result_log = mysql_query($consulta_log, $link);
		echo mysql_error($link);
		while($fila_log = mysql_fetch_assoc($result_log)){
			$estilo = ($estilo=="lista_clara"?"lista_oscura":"lista_clara");
	?>
	  <tr class="<?=$estilo?>">
		<td valign="top"><span><?=xhtmlOut(ucfirst($fila_log["usuario"]))?>:</span> <?=xhtmlOut($fila_log["descripcion"])?></td>
		<td valign="top" width="90"><?=$fila_log["fecha_f"]?> <?=$fila_log["hora_f"]?></td>
		<?
		if($_SESSION["usr_tipo"]==1){
		?>
		<td valign="top" width="25"><a href="#" class="borrar_log" rel="<?=$fila_log["id_log_tarea"]?>" alt="<?=$_GET["id_tarea"]?>"><img src="imagenes/ico_delete.gif" alt="" width="10" height="11" hspace="3" vspace="4" border="0" class="ico_imprimir" /></a></td>
		<?
		}
		?>
	  </tr>
	<?
		}
		if(mysql_num_rows($result_log)==0){
		?>
	  <tr class="<?=$estilo?>">
		<td colspan="5" align="center">No hay comentarios.</td>
	  </tr>
		<?
		}
	?>
	</tbody>
  </table>