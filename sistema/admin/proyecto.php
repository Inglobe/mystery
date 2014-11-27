<?
	if(isset($_GET["id_eliminar"])){
		mysql_query("DELETE FROM tareas WHERE id_tarea = ".$_GET["id_eliminar"],$link);
		echo mysql_error($link);
		
		mysql_query("DELETE FROM usuarios_notificaciones WHERE id_tarea = ".$_GET["id_eliminar"],$link);
		echo mysql_error($link);
		
		$result_consulta = mysql_query("SELECT * FROM tareas WHERE id_tarea_padre = ".$_GET["id_padre"]." AND id_proyecto = ".$_GET["id_proyecto"]." ORDER BY orden",$link);
		$cont=1;
		while($fila_tmp=mysql_fetch_array($result_consulta)){
			$cadena="UPDATE tareas SET orden = ".$cont." WHERE id_tarea = ".$fila_tmp["id_tarea"];
			//echo $cadena;
			mysql_query($cadena,$link);
			$cont++;
		}
		for($i=0;$i<3;$i++)
			actualizar_tareas($_GET["id_proyecto"]);
	}
	
	if($_POST["md"] == 1){
		$consulta = "
				UPDATE 
					proyectos
				SET 
					dia_compra = STR_TO_DATE('".$_POST["dia_compra"]."','%d/%m/%Y'),
					monto_compra = '".$_POST["monto_compra"]."',
					hora_entrada = '".$_POST["hora_entrada"]."',
					hora_salida = '".$_POST["hora_salida"]."',
					nro_empleados = '".$_POST["nro_empleados"]."',
					nro_clientes = '".$_POST["nro_clientes"]."',
					vendedor = '".$_POST["vendedor"]."'
				WHERE
					id_proyecto = ".$_GET["id_proyecto"]."
		";
		mysql_query($consulta,$link);
		echo mysql_error($link);
	}

	$consulta_proyectos = "SELECT 		
								p.*,
								DATE_FORMAT(p.fecha_inicio_estimada,'%d/%m/%y') AS fecha_ie_f,
								DATE_FORMAT(p.fecha_inicio_real,'%d/%m/%y') AS fecha_ir_f,
								DATE_FORMAT(p.fecha_fin_estimada,'%d/%m/%y') AS fecha_fp_f,
								DATE_FORMAT(p.fecha_fin_real,'%d/%m/%y') AS fecha_fr_f,
								DATE_FORMAT(p.fecha_entrega_estimada,'%d/%m/%y') AS fecha_ee_f,
								DATE_FORMAT(p.fecha_entrega_real,'%d/%m/%y') AS fecha_er_f,
								DATE_FORMAT(p.dia_compra,'%d/%m/%Y') AS dia_compra_f,
								s.direccion AS domicilio_sucursal
							FROM 		
								proyectos p
								JOIN sucursales s ON p.id_sucursal = s.id_sucursal
							WHERE 		
								p.id_proyecto = ".$_GET["id_proyecto"];
	$fila_proyecto=mysql_fetch_assoc(mysql_query($consulta_proyectos,$link));
	echo mysql_error($link);
	$fila_cliente=mysql_fetch_assoc(mysql_query("SELECT * FROM clientes WHERE id_cliente = ".$fila_proyecto["id_cliente"],$link));
	$fila_contacto=mysql_fetch_assoc(mysql_query("SELECT * FROM contactos WHERE id_contacto = ".$fila_proyecto["id_contacto_responsable"],$link));
	echo mysql_error($link);
?>
<link href="css_library/tareas.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js_library/proyecto.js"></script>
<script type="text/javascript">
<!--
	function recargar(){
		window.location.href="index.php?put=proyecto&id_proyecto=<?=$_GET["id_proyecto"]?>&id_cliente=<?=$_GET["id_cliente"]?>";
	}
//-->
</script>
<link href="css_library/estilos.css" rel="stylesheet" type="text/css" />
<div id="column_der_proyecto">
  <div class="cbza_bloque">
    <div class="cont_fondo_bloque_sup_izq">
      <div class="fondo_bloque_sup_izq"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_sup_der">
      <div class="fondo_bloque_sup_der"><span></span></div>
    </div>
  </div>
  <div class="borde_bloque_izq">
    <div class="borde_bloque_der">
      <div style="height:300px; float:left; width:1px;"><span></span></div>
      <div class="cuerpo_bloque">
        <div id="logo_proyectos"><img src="imagen.php?ruta=../imagenes/clientes/logos/<?=$fila_cliente["logo"]?>&amp;ancho=140" alt="<?=$fila_cliente["nombre"]?>" border="0" /></div>
        <?
  	$consulta = "SELECT 		id_proyecto, nombre
					FROM 		proyectos
					WHERE		id_cliente = ".$_GET["id_cliente"]."
					AND 		id_proyecto != ".$_GET["id_proyecto"]."
					AND 		plantilla = 0
				";
	if($_SESSION["usr_tipo"]!=1){
		$consulta .= " AND id_usuario_responsable = ".$_SESSION["id_usr"];
	}
	$consulta .= " ORDER BY 	id_proyecto DESC
				";
	$result = mysql_query($consulta,$link);
	echo mysql_error($link);
	if(mysql_num_rows($result)>0){
  ?>
        <div id="tit_buscar_proyecto"><img src="imagenes/ico_lupa.jpg" alt="" hspace="5" align="left" />
          <div><strong>Otras auditorias:</strong></div>
        </div>
        <ul>
          <?
	  while($fila=mysql_fetch_assoc($result)){
      ?>
          <li><a href="index.php?put=proyecto&amp;id_proyecto=<?=$fila["id_proyecto"]?>&amp;id_cliente=<?=$_GET["id_cliente"]?>">
            <?=$fila["nombre"]?>
            </a></li>
          <?
      }
      ?>
        </ul>
        <?
  	}
  ?>
      </div>
    </div>
  </div>
  <div class="pie_bloque">
    <div class="cont_fondo_bloque_inf_izq">
      <div class="fondo_bloque_inf_izq"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_inf_der">
      <div id="btn_volver_proyecto"><a href="index.php?put=proyectos_search"><img src="imagenes/btn_volver.jpg" alt="" width="56" height="20" border="0" /></a></div>
      <div class="fondo_bloque_inf_der"><span></span></div>
    </div>
  </div>
</div>
<div id="contenedor_dos_bloques">
  <div id="bloque_proyecto">
    <div class="cbza_bloque">
      <div class="cont_fondo_bloque_sup_izq">
        <div class="fondo_bloque_sup_izq"><span></span></div>
      </div>
      <div class="cont_fondo_bloque_sup_der">
        <div class="fondo_bloque_sup_der"><span></span></div>
      </div>
    </div>
    <div class="borde_bloque_izq">
      <div class="borde_bloque_der">
        <div class="cuerpo_bloque">
          <div id="tit_proyecto_top">
            <div class="fujiyama_proyecto"><strong>
              <?=$fila_proyecto["nombre"]?>
              </strong></div>
            <div class="urls">
              <div class="label_proyecto">Supervisor:</div>
              <div class="dato_label_proyecto"><strong>
                <?=getUsrNomById($fila_proyecto["id_usuario_supervisor"])?>
                </strong></div>
              <div class="label_proyecto">Shopper:</div>
              <div class="dato_label_proyecto"><strong>
                <?=getUsrNomById($fila_proyecto["id_usuario_responsable"])?>
                </strong></div>
              <?
			    if($_SESSION["usr_tipo"]==1){
					if($fila_contacto["nombre"] != ""){
				?>
              <div class="label_proyecto">Contacto:</div>
              <div class="dato_label_proyecto"><strong>
                <?=$fila_contacto["nombre"]?>
                &nbsp;(
                <?=$fila_contacto["telefonos"]?>
                )</strong></div>
              <?
					}
				}
				?>
			  <div class="label_proyecto">Domicilio:</div>
              <div class="dato_label_proyecto"><strong>
                <?=xhtmlOut($fila_proyecto["domicilio_sucursal"])?>
                </strong></div>
            </div>
          </div>
          <div id="datos_proyecto"> <img src="imagenes/ico_torta_grande.jpg" alt="" id="ico_torta_proyecto" />
            <div id="estado_proyecto"><strong>Estado:</strong> En proceso (<span class="texto_azul"><strong>
              <?=avance_ponderado($fila_proyecto["id_proyecto"])?>
              %</strong></span>)</div>
            <div id="fechas_proyectos"><img src="imagenes/ico_fecha_grande.jpg" alt="" name="ico_fecha_proyecto" id="ico_fecha_proyecto" />
              <div class="label_proyecto">Inicio:</div>
              <div class="dato_label_proyecto"> <span class="texto_azul"><strong>previsto</strong></span> <strong>
                <?=$fila_proyecto["fecha_ie_f"]?>
                </strong>&nbsp;&nbsp;|&nbsp;&nbsp;<span class="texto_azul"><strong>real</strong></span> <strong>
                <?=($fila_proyecto["fecha_ir_f"]=="00/00/00"?"No iniciado":$fila_proyecto["fecha_ir_f"])?>
                </strong></div>
              <div class="label_proyecto">Fin:</div>
              <div class="dato_label_proyecto"> <span class="texto_azul"><strong>previsto</strong></span> <strong>
                <?=$fila_proyecto["fecha_ie_f"]?>
                </strong>&nbsp;&nbsp;|&nbsp;&nbsp;<span class="texto_azul"><strong>real</strong></span> <strong>
                <?=($fila_proyecto["fecha_fr_f"]=="00/00/00"?"No finalizado":$fila_proyecto["fecha_fr_f"])?>
                </strong></div>
              <div class="label_proyecto">Entrega:</div>
              <div class="dato_label_proyecto"> <span class="texto_azul"><strong>previsto</strong></span> <strong>
                <?=$fila_proyecto["fecha_ee_f"]?>
                </strong>&nbsp;&nbsp;|&nbsp;&nbsp;<span class="texto_azul"><strong>real</strong></span> <strong>
                <?=($fila_proyecto["fecha_er_f"]=="00/00/00"?"No finalizado":$fila_proyecto["fecha_er_f"])?>
                </strong></div>
            </div>
          </div>
            <?
				include("proyecto_usuarios.inc.php");
			?>
          <div style="clear:both;"><span></span></div>
		  <div style="padding-top:15px; border-top-style:solid; border-top-width:1px; border-top-color:#CCC;">
		<?
		if($_SESSION["usr_tipo"] == 1 || $fila_proyecto["id_usuario_responsable"] != -1){
		?>
            <form action="index.php?put=proyecto&amp;id_proyecto=<?=$_GET["id_proyecto"]?>&amp;id_cliente=<?=$_GET["id_cliente"]?>" method="post">
			  <input type="hidden" name="md" value="1" />
              <div class="campo">
                <label for="dia_compra">D&iacute;a de compra:</label>
                <input type="text" style="width:60px;" value="<?=xhtmlOut($fila_proyecto["dia_compra_f"])?>" id="dia_compra" name="dia_compra">
              </div>
              <div class="campo">
                <label for="monto_compra">Monto:</label>
                <input type="text" style="width:40px;" value="<?=xhtmlOut($fila_proyecto["monto_compra"])?>" id="monto_compra" name="monto_compra">
              </div>
              <div class="campo">
                <label for="hora_entrada">H de entrada:</label>
                <input type="text" style="width:50px;" value="<?=xhtmlOut($fila_proyecto["hora_entrada"])?>" id="hora_entrada" name="hora_entrada">
              </div>
              <div class="campo">
                <label for="hora_salida">H de salida:</label>
                <input type="text" style="width:50px;" value="<?=xhtmlOut($fila_proyecto["hora_salida"])?>" id="hora_salida" name="hora_salida">
              </div>
              <div class="campo">
                <label for="nro_empleados">N&ordm; empleados:</label>
                <input type="text" style="width:30px;" value="<?=xhtmlOut($fila_proyecto["nro_empleados"])?>" id="nro_empleados" name="nro_empleados">
              </div>
              <div class="campo">
                <label for="nro_clientes">N&ordm; clientes:</label>
                <input type="text" style="width:30px;" value="<?=xhtmlOut($fila_proyecto["nro_clientes"])?>" id="nro_clientes" name="nro_clientes">
              </div>
			  <div class="campo">
                <label for="vendedor">Vendedor:</label>
                <input type="text" style="width:100px;" value="<?=xhtmlOut($fila_proyecto["vendedor"])?>" id="vendedor" name="vendedor">
              </div>
			  <?
			  if($_SESSION["usr_tipo"]==2 && $fila_proyecto["id_estado_proyecto"] == 3){
				
			  }
			  else{
			  ?>
			  <input type="image" src="imagenes/btn_save.jpg" width="72" height="20" alt="" />
			  <?
			  }
			  ?>
            </form>
          
		<?
		}
		?>
		    <div style="clear:both;"><span></span></div>
		    <h4 style="float:left; padding-right:5px;"><a href="#" onclick="Effect.toggle('box_observaciones', 'blind', { duration: 0.3 }); $('expander').toggleClassName('active'); return false;">Observaciones: click para expandir [+]</a></h4>
			<div id="box_observaciones" style="display:none; clear:both; padding-top:10px;"><?=xhtmlOut($fila_proyecto["obs"])?></div>
		  </div>
          <div style="clear:both;"><span></span></div>
          <div style="text-align:right; padding-right:6px; position:absolute; top:5px; right:5px;">
        <?
        if($_SESSION["usr_tipo"]==1){
        ?>
			<a href="../../clientes/admin/preview.php?put=auditorias_informe&amp;id=<?=$_GET["id_proyecto"]?>" target="_blank"><img src="imagenes/btn_vista_cliente.jpg" alt="" border="0"/></a>
            <?
			if(!getUsrExterno($_SESSION["id_usr"])){
		?>
            <a href="index.php?put=proyecto_am&id_proyecto=<?=$_GET["id_proyecto"]?>"><img src="imagenes/btn_sup_edit.jpg" alt="" width="57" height="20" border="0"/></a>
            <?
			}
		?>
            <!--<a href="reporte_horas_proyecto.php?id_proyecto=<?=$_GET["id_proyecto"]?>&descargar=1"><img src="imagenes/btn_decargar_exel.jpg" alt="" width="77" height="20" border="0"/></a>
		<a href="proyecto.print.php?id_proyecto=<?=$_GET["id_proyecto"]?>&amp;id_cliente=<?=$_GET["id_cliente"]?>" target="_blank"><img src="imagenes/btn_imprimir.jpg" alt="" border="0"/></a>--> 
            <a href="index.php?put=proyecto_procesar&amp;id_proyecto=<?=$_GET["id_proyecto"]?>&amp;finalizar=1&amp;id_cliente=<?=$_GET["id_cliente"]?>" target="_blank"><img src="imagenes/btn_finalizar_proyecto.png" alt="" border="0"/></a>
            <?
		}
		?>
          </div>
        </div>
      </div>
    </div>
    <div class="pie_bloque">
      <div class="cont_fondo_bloque_inf_izq">
        <div class="fondo_bloque_inf_izq"><span></span></div>
      </div>
      <div class="cont_fondo_bloque_inf_der">
        <div class="fondo_bloque_inf_der"><span></span></div>
      </div>
    </div>
  </div>
<?
if($_SESSION["usr_tipo"] == 1 || $fila_proyecto["id_usuario_responsable"] != -1){
?>
  <div id="tareas">
    <div class="cbza_bloque_lista">
      <div class="cont_fondo_bloque_sup_izq">
        <div class="fondo_bloque_sup_izq_lista"><span></span></div>
      </div>
      <div class="cont_fondo_bloque_sup_der">
        <div class="fondo_bloque_sup_der_lista"><span></span></div>
      </div>
    </div>
    <div class="borde_bloque_izq">
      <div class="borde_bloque_der">
        <div class="cuerpo_bloque_lista">
        <?
		function mostrar_tarea($id_padre, $id_proyecto, $nivel, $fila_proyecto){
			global $link;
			global $_SESSION;

			$cadena="SELECT
							t.*,
							DATE_FORMAT(fecha_inicio_estimada,'%d/%m/%y') AS fecha_f,
							DATE_FORMAT(fecha_fin_estimada,'%d/%m/%y') AS fecha_f_f,
							ur.nombre AS usuario_responsable,
							uo.nombre AS usuario_owner
						FROM
							tareas t, usuarios ur, usuarios uo
						WHERE
									t.id_usuario_responsable = ur.id_usuario
						AND			t.id_usuario_owner = uo.id_usuario
						AND			t.id_tarea_padre = ".$id_padre."
						AND 		t.id_proyecto = ".$id_proyecto."
						ORDER BY	t.orden
					";
			$result = mysql_query($cadena,$link);
			echo mysql_error($link);

			$orden = 0;
			while ($fila = mysql_fetch_array($result)) {
				$tiene_hijos = tiene_hijos($fila["id_tarea"]);
		?>
          <div class="tarea_<?=$nivel?>" id="tarea_<?=$fila["id_tarea"]?>" <?=(getTareasOcultas($fila["id_tarea"],$_SESSION["id_usr"])?"style=\"overflow: hidden;height:23px\"":"")?>>
            <?
				require("tarea.inc.php");
				mostrar_tarea($fila["id_tarea"], $id_proyecto, $nivel+1, $fila_proyecto);
		?>
          </div>
          <?
				$orden++;
			}
		}

		$fila_tarea = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS nro FROM tareas WHERE id_proyecto = ".$_GET["id_proyecto"]." AND id_tarea_padre = 0 ORDER BY orden ASC", $link));
		echo mysql_error($link);

		if($fila_tarea["nro"]>0){
			mostrar_tarea(0, $_GET["id_proyecto"], 0, $fila_proyecto);
		}
	?>
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
}
?>
</div>
<?
if(isset($_GET["id_tarea"])){
?>
<script type="text/javascript">
<!--
function abrir_tarea(){
	initPopUp();
	showPopWin('tarea.pop.php?id_proyecto=<?=$_GET["id_proyecto"]?>&id_cliente=<?=$_GET["id_cliente"]?>&am=m&id_tarea=<?=$_GET["id_tarea"]?>&id_padre=<?=$_GET["id_padre"]?>',700,520,null);
}
addLoadEvent(abrir_tarea);
//-->
</script>
<?
}
?>
