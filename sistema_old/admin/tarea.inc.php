<?
	$href_tarea="javascript:showPopWin('tarea.pop.php?id_proyecto=".$fila["id_proyecto"]."&id_cliente=".$_GET["id_cliente"]."&am=m&id_tarea=".$fila["id_tarea"]."&id_padre=".$id_padre."',700,520,null)";
	$estilo_tarea_permiso = "";
	if($fila["id_prioridad_tarea"] == 5){
		$estilo_tarea_permiso = "texto_fuego";
	}
?>
<div class="icono"><a <?=($tiene_hijos?"href=\"javascript:ocultar_tarea('".$fila["id_tarea"]."')\"":"")?>><img src="imagenes/<?=($tiene_hijos?"folder_open.gif":"ico_tarea.gif")?>" /></a></div>
<div class="prioridad"><img src="imagenes/prioridad_<?=$fila["id_prioridad_tarea"]?>.gif" /></div>
<div class="descripcion<?=($tiene_hijos?"_titulo":"")?>"><a href="<?=$href_tarea?>" class="<?=$estilo_tarea_permiso?>" title="Responsable: <?=$fila["usuario_responsable"]?> - Autor: <?=$fila["usuario_owner"]?>"><?=$fila["descripcion"]?></a></div>

<?
	if(!$tiene_hijos){
?>
<div class="eliminar_tarea"><a href="index.php?put=proyecto&id_proyecto=<?=$_GET["id_proyecto"]?>&id_cliente=<?=$_GET["id_cliente"]?>&id_eliminar=<?=$fila["id_tarea"]?>&id_padre=0" onclick="return confirm('Desea borrar la tarea?');"><img src="imagenes/eliminar.gif" /></a></div>
<?
	}
	else{
?>
<div class="eliminar_tarea"><img src="imagenes/eliminar_des.gif" /></div>
<?
	}
	if($nivel < 3){
?>
<div class="agregar_sub_tarea"><a href="javascript:showPopWin('tarea.pop.php?id_proyecto=<?=$id_proyecto?>&id_padre=<?=$fila["id_tarea"]?>',700,490,null)"><img src="imagenes/sub_tarea.gif" /></a></div>
<?
	}
	else {
?>
<div class="agregar_sub_tarea"><img src="imagenes/sub_tarea_des.gif" /></div>
<?
	}
?>
<div class="agregar_sub_tarea"><a href="javascript:showPopWin('tarea.pop.php?id_proyecto=<?=$id_proyecto?>&id_padre=<?=$fila["id_tarea_padre"]?>&orden=<?=$orden?>',700,490,null)"><img src="imagenes/agregar.gif" /></a></div>
<div class="estado"><img src="imagenes/estado_<?=$fila["id_estado_tarea"]?>.gif" /></div>
<div class="fechas"><?=$fila["fecha_f"]." - ".$fila["fecha_f_f"]?></div>
<?
if($fila["obs_fin"]!=""){
?>
<div class="obs_fin"><img src="imagenes/ampliar_3.gif" /></div>
<?
}
if($fila["obs_proceso"]!="" ){
?>
<div class="obs_proceso"><img src="imagenes/ampliar_2.gif" /></div>
<?
}
if($fila["obs"]!="" ){
?>
<div class="obs"><img src="imagenes/ampliar_1.gif" /></div>
<?
}
if(tiene_archivos($fila["id_tarea"])){
?>
<div class="archivos"><img src="imagenes/paperclip.gif" /></div>
<?
}
?>
<span id="prueba"></span>

