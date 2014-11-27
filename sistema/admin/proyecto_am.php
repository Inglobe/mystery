<?
	if(isset($_GET["id_proyecto"])){
		$consulta = "SELECT *, DATE_FORMAT(fecha_inicio_estimada,'%d/%m/%Y') AS fecha_ie_f, DATE_FORMAT(fecha_fin_estimada,'%d/%m/%Y') AS fecha_fe_f, DATE_FORMAT(fecha_entrega_estimada,'%d/%m/%Y') AS fecha_ee_f FROM proyectos WHERE id_proyecto = ".$_GET["id_proyecto"];
		$result = mysql_query($consulta, $link);
		echo mysql_error($link);
		$fila = mysql_fetch_assoc($result);
		$action = "Editar";
	}
	else {
		$fila["path_server_local"] = "Z:\\";
		$fila["url_test"] = "http://www.zephiaestudio.com.ar/";
		$fila["url_final"] = "http://";
		$action = "Agregar";
	}
?>

<div id="titulo">
  <h1><span>Auditorias</span><span class="separador_tit">/</span><span class="gris">Auditoria</span><span class="separador_tit">/</span><span class="gris_claro">
    <?=$action?>
    </span> </h1>
</div>
<div id="contenedor_btns_sup">
  <div id="btns_sup"><a href="index.php?put=proyectos_search"><img src="imagenes/btn_sup_search.jpg" alt="Buscar" border="0" /></a></div>
</div>
<div id="filtros">
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
      <form id="proyecto_procesar" name="proyecto_procesar" method="post" action="index.php?put=proyecto_procesar">
	  	<?
			if(isset($_GET["id_proyecto"])){
		?>
		<input type="hidden" name="id_proyecto" value="<?=$_GET["id_proyecto"]?>" />
		<?
			}
		?>
        <div class="control" id="label_id_cliente">
          <label for="cmb_id_client">
          <div class="label_add">Cliente:</div>
          </label>
          <div class="dato_add">
            <select name="id_cliente" id="cmb_id_cliente">
              <option value="0">--seleccione--</option>
              <?
					$consulta_cliente = "SELECT * FROM clientes ORDER BY nombre ASC";
					$result_cliente = mysql_query($consulta_cliente,$link);
					while($fila_cliente = mysql_fetch_array($result_cliente)){
			  ?>
              <option value="<?=$fila_cliente["id_cliente"]?>" <?=($fila_cliente["id_cliente"] == $fila["id_cliente"] ? 'selected="selected"' : '')?>>
              <?=$fila_cliente["nombre"]?>
              </option>
              <?
					}
				?>
            </select>
          </div>
        </div>
		<div class="control" id="label_id_sucursal">
          <label for="cmb_id_sucursal">
          <div class="label_add">Sucursal:</div>
          </label>
          <div class="dato_add">
            <select name="id_sucursal" id="cmb_id_sucursal">
              <option value="0">--seleccione--</option>
              <?
				$consulta_suc = "SELECT * FROM sucursales WHERE 1 ORDER BY nombre ASC";
				$result_suc = mysql_query($consulta_suc,$link);
				while($fila_suc = mysql_fetch_array($result_suc)){
			  ?>
              <option value="<?=$fila_suc["id_sucursal"]?>" <?=($fila_suc["id_sucursal"] == $fila["id_sucursal"] ? 'selected="selected"' : '')?>>
              <?=$fila_suc["nombre"]?>
              </option>
              <?
				}
				?>
            </select>
          </div>
        </div>
		<div class="control" id="label_id_contacto_responsable">
          <label for="cmb_id_contacto_responsable">
          <div class="label_add">Contacto responsable:</div>
          </label>
          <div class="dato_add">
            <select name="id_contacto_responsable" id="cmb_id_contacto_responsable">
              <option value="0">--seleccione--</option>
              <?
				$consulta_con_resp = "SELECT * FROM contactos WHERE 1 ORDER BY nombre ASC";
				$result_con_resp = mysql_query($consulta_con_resp,$link);
				while($fila_con_resp = mysql_fetch_array($result_con_resp)){
			  ?>
              <option value="<?=$fila_con_resp["id_contacto"]?>" <?=($fila_con_resp["id_contacto"] == $fila["id_contacto_responsable"] ? 'selected="selected"' : '')?>>
              <?=$fila_con_resp["nombre"]?>
              </option>
              <?
				}
				?>
            </select>
          </div>
        </div>
        <div class="control" id="label_id_tipo_proyecto">
          <label for="cmb_id_tipo_proyecto">
          <div class="label_add">Tipo Auditoria:</div>
          </label>
          <div class="dato_add">
            <select name="id_tipo_proyecto" id="cmb_id_tipo_proyecto">
              <option value="0">--seleccione--</option>
              <?
					$consulta_tipo = "SELECT * FROM tipos_proyecto ORDER BY descripcion ASC";
					$result_tipo = mysql_query($consulta_tipo,$link);
					while($fila_tipo = mysql_fetch_array($result_tipo)){
			  ?>
              <option value="<?=$fila_tipo["id_tipo_proyecto"]?>" <?=($fila_tipo["id_tipo_proyecto"] == $fila["id_tipo_proyecto"] ? 'selected="selected"' : '')?>>
              <?=$fila_tipo["descripcion"]?>
              </option>
              <?
					}
				?>
            </select>
          </div>
        </div>
        <div class="control">
          <label for="nombre">
          <div class="label_add">Nombre:</div>
          </label>
          <div class="dato_add">
            <input type="text" size="50" name="nombre" id="nombre" value="<?=$fila["nombre"]?>" />
          </div>
        </div>
        <div class="control" id="label_id_usuario_responsable">
          <label for="cmb_id_usuario_responsable">
          <div class="label_add">Shopper:</div>
          </label>
          <div class="dato_add">
            <select name="id_usuario_responsable" id="cmb_id_usuario_responsable">
              <option value="0">--seleccione--</option>
              <?
					$consulta_usr_resp = "SELECT * FROM usuarios WHERE id_tipo_usuario = 2 ORDER BY nombre ASC";
					$result_usr_resp = mysql_query($consulta_usr_resp,$link);
					while($fila_usr_resp = mysql_fetch_array($result_usr_resp)){
			  ?>
              <option value="<?=$fila_usr_resp["id_usuario"]?>" <?=($fila_usr_resp["id_usuario"] == $fila["id_usuario_responsable"] ? 'selected="selected"' : '')?>>
              <?=$fila_usr_resp["nombre"]?>
              </option>
              <?
					}
				?>
            </select>
          </div>
        </div>
        <div class="control" id="label_id_usuario_supervisor">
          <label for="cmb_id_usuario_supervisor">
          <div class="label_add">Usuario supervisor:</div>
          </label>
          <div class="dato_add">
            <select name="id_usuario_supervisor" id="cmb_id_usuario_supervisor">
              <option value="0">--seleccione--</option>
              <?
					$consulta_usr_sup = "SELECT * FROM usuarios WHERE id_tipo_usuario = 1 ORDER BY nombre ASC";
					$result_usr_sup = mysql_query($consulta_usr_sup,$link);
					while($fila_usr_sup = mysql_fetch_array($result_usr_sup)){
			  ?>
              <option value="<?=$fila_usr_sup["id_usuario"]?>" <?=($fila_usr_sup["id_usuario"] == $fila["id_usuario_supervisor"] ? 'selected="selected"' : '')?>>
              <?=$fila_usr_sup["nombre"]?>
              </option>
              <?
					}
				?>
            </select>
          </div>
        </div>
        <div class="control" id="label_fecha_inicio_estimada">
          <label for="fecha_inicio_estimada">
          <div class="label_add">Fecha de inicio estimada:</div>
          </label>
          <div class="dato_add">
            <script type="text/javascript">
				// <![CDATA[
				<?
					if(empty($fila["fecha_ie_f"])){
						$fecha = getdate();
						$fecha_from = $fecha["mday"]."/".$fecha["mon"]."/".$fecha["year"];
					}else{
						$fecha_from = $fila["fecha_ie_f"];
					}
				?>
				  FSfncWriteFieldHTML("proyecto_procesar","fecha_inicio_estimada","<?=$fecha_from?>","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
				// ]]>
			 </script>
          </div>
        </div>
        <div class="control" id="label_fin_estimada">
          <label for="fecha_fin_estimada">
          <div class="label_add">Fecha de finalizaci&oacute;n estimada:</div>
          </label>
          <div class="dato_add">
            <script type="text/javascript">
				// <![CDATA[
				<?
					if(empty($fila["fecha_fe_f"])){
						$fecha = getdate();
						$fecha_from = $fecha["mday"]."/".$fecha["mon"]."/".$fecha["year"];
					}else{
						$fecha_from = $fila["fecha_fe_f"];
					}
				?>
				  FSfncWriteFieldHTML("proyecto_procesar","fecha_fin_estimada","<?=$fecha_from?>","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
				// ]]>
			 </script>
          </div>
        </div>
        <div class="control" id="label_entrega_estimada">
          <label for="fecha_entrega_estimada">
          <div class="label_add">Fecha de entrega estimada:</div>
          </label>
          <div class="dato_add">
            <script type="text/javascript">
				// <![CDATA[
				<?
					if(empty($fila["fecha_ee_f"])){
						$fecha = getdate();
						$fecha_from = $fecha["mday"]."/".$fecha["mon"]."/".$fecha["year"];
					}else{
						$fecha_from = $fila["fecha_ee_f"];
					}
				?>
				  FSfncWriteFieldHTML("proyecto_procesar","fecha_entrega_estimada","<?=$fecha_from?>","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
				// ]]>
			 </script>
          </div>
        </div>
        <div class="control">
          <label for="obs">
          <div class="label_add">Observaciones:</div>
          </label>
          <div class="dato_add">
            <textarea name="obs" id="obs" cols="80" rows="4"><?=$fila["obs"]?></textarea>
          </div>
        </div>
        <div class="control">
          <label for="nro_archivo">
          <div class="label_add">N&uacute;mero de archivo:</div>
          </label>
          <div class="dato_add">
            <input type="text" name="archivo_nro" id="archivo_nro" value="<?=$fila["archivo_nro"]?>" />
          </div>
        </div>
		<?
		if(empty($_GET["id_proyecto"])){
		?>
        <div class="control" id="label_id_usuario_supervisor">
          <label for="cmb_id_usuario_supervisor">
          <div class="label_add">Usar plantilla:</div>
          </label>
          <div class="dato_add">
            <select name="id_plantilla" id="cmb_id_plantilla">
              <option value="0">--seleccione--</option>
              <?
				$consulta_plantilla = "SELECT * FROM proyectos WHERE plantilla = 1 ORDER BY nombre ASC";
				$result_plantilla = mysql_query($consulta_plantilla,$link);
				while($fila_plantilla = mysql_fetch_array($result_plantilla)){
			  ?>
              <option value="<?=$fila_plantilla["id_proyecto"]?>"><?=$fila_plantilla["nombre"]?></option>
              <?
				}
			  ?>
            </select>
          </div>
        </div>
		<div class="control">
          <label for="check_plantilla">
          <div class="label_add">Crear como plantilla:</div>
          </label>
          <div class="dato_add">
            <input type="checkbox" name="check_plantilla" id="check_plantilla" value="1" />
          </div>
        </div>
		<?
		}
		?>
        <div id="btns_ok_cancel">
			<a href="index.php?put=proyectos_search"><img src="imagenes/btn_cancel.jpg" alt="" border="0" /></a><input type="image" src="imagenes/btn_ok.jpg" alt="" hspace="5" border="0" />
		</div>
        <div id="contenedor_validando_datos">
          <div id="validando_datos" style="display:none;"><img src="imagenes/loadingAnimation_small.gif" alt="" width="16" height="16" />Validating data, please wait...</div>
        </div>
      </form>
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
<script type="text/javascript" src="js_library/proyecto_am.js"></script>
