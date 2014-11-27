<?php

require("procesos_globales.php");
ob_start();

$usuario_externo = getUsrExterno($_SESSION["id_usr"]);

$consulta = "SELECT
				t.id_tarea,
				t.id_tarea_padre,
				t.descripcion,
				t.id_proyecto,
				p.id_cliente,
				t.id_prioridad_tarea,
				p.nombre AS proyecto,
				u.nombre AS usuario,
				u.foto AS usuario_foto
			FROM
				usuarios_notificaciones un,
				tareas t,
				proyectos p,
				usuarios u
			WHERE
				un.id_tarea = t.id_tarea AND
				t.id_proyecto = p.id_proyecto AND
				un.id_usuario_owner = u.id_usuario AND
				un.id_usuario = ".$_SESSION["id_usr"]."
			ORDER BY
				t.id_prioridad_tarea DESC
			";
$result = mysql_query($consulta,$link);
echo mysql_error($link);
?>
  <div id="dialog_notificaciones">
    <div class="flecha_dialog"><img src="imagenes/flecha_dialog.png" width="21" height="30" alt="" /></div>
    <div class="cbza_bloque_lista">
      <div class="cont_fondo_bloque_sup_izq">
        <div class="fondo_bloque_sup_izq_lista"><span></span></div>
      </div>
      <div class="cont_fondo_bloque_sup_der">
        <div class="fondo_bloque_sup_der_lista"><span></span></div>
      </div>
    </div>
    <div class="borde_bloque_izq">
      <div class="borde_bloque_der" style="position:relative;">
        <div class="cuerpo_bloque_lista" style="background-color:#F4F4F4;">
		  <div style="padding:5px; position:absolute; right:5px;"><a href="#" onclick="$('dialog_notificaciones').hide();return false"><img src="imagenes/btn_cerrar_modal.gif" alt="" border="0" /></a></div>
          <h4 style="padding-bottom:5px;">Notificaciones</h4>
		  <ul id="lista_notificaciones">
			<?
			while($fila = mysql_fetch_assoc($result)){
				?>
		    <li><img src="imagen.php?ruta=../imagenes/usuarios/fotos/<?=$fila["usuario_foto"]?>&amp;ancho=28&amp;alto=27&amp;mantener_ratio=1" width="28" height="27" alt="<?=$fila["usuario"]?>" align="left" hspace="5" /> <img src="imagenes/prioridad_<?=$fila["id_prioridad_tarea"]?>.gif" alt="" /> <?
		    	if(!$usuario_externo){
		    ?><a href="index.php?put=proyecto&amp;id_proyecto=<?=$fila["id_proyecto"]?>&amp;id_cliente=<?=$fila["id_cliente"]?>&amp;id_tarea=<?=$fila["id_tarea"]?>&amp;id_padre=<?=$fila["id_tarea_padre"]?>" <?=($fila["id_prioridad_tarea"]==5?'class="texto_fuego"':"")?>><?
		    	}
		    ?><?=$fila["descripcion"]?><?
		    	if(!$usuario_externo){
		    ?></a><?
		    	}
		    ?> (<?=$fila["proyecto"]?>) </li>
				<?
			}
			?>
		  </ul>
	   </div>
      </div>
    </div>
    <div class="pie_bloque_lista">
      <div class="cont_fondo_bloque_inf_izq">
        <div class="fondo_bloque_inf_izq_lista"><span></span></div>
      </div>
      <div class="cont_fondo_bloque_inf_der">
        <div class="fondo_bloque_inf_der_lista"><span></span></div>
      </div>
    </div>
  </div>
<?
$html = ob_get_clean();
ob_end_flush();
echo utf8_encode($html);
?>