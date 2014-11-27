<?
	$href_tarea="javascript:showPopWin('tarea.pop.php?id_proyecto=".$fila["id_proyecto"]."&id_cliente=".$_GET["id_cliente"]."&am=m&id_tarea=".$fila["id_tarea"]."&id_padre=".$id_padre."',700,490,null)";
	$estilo_tarea_permiso = "";
?>
<div class="icono"><a <?=($tiene_hijos?"href=\"javascript:ocultar_tarea('".$fila["id_tarea"]."')\"":"")?>><img src="imagenes/<?=($tiene_hijos?"folder_open.gif":"ico_tarea.gif")?>" /></a></div>
<div class="prioridad"><img src="imagenes/prioridad_<?=$fila["id_prioridad_tarea"]?>.gif" /></div>
<div class="descripcion<?=($tiene_hijos?"_titulo":"")?>"><a href="<?=$href_tarea?>" class="<?=$estilo_tarea_permiso?>" title="Responsable: <?=getUsrNomById($fila["id_usuario_responsable"])?> - Autor: <?=getUsrNomById($fila["id_usuario_owner"])?>"><?=$fila["descripcion"]?></a></div>
<div class="estado"><img src="imagenes/estado_<?=$fila["id_estado_tarea"]?>.gif" /></div>
<div class="fechas"><?=$fila["fecha_f"]." - ".$fila["fecha_f_f"]?></div>
<div class="tiempo"><?=$fila["tiempo"]?> mins</div>

