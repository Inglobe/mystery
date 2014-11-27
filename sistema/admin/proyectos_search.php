<?
if(isset($_GET["id_eliminar"])){
	mysql_query("DELETE FROM tareas WHERE id_proyecto = ".$_GET["id_eliminar"]);
	echo mysql_query($link);
	
	mysql_query("DELETE FROM proyectos WHERE id_proyecto = ".$_GET["id_eliminar"]);
	echo mysql_query($link);
}
?>
<div id="titulo">
  <h1><span>Auditorias</span><span class="separador_tit">/</span><span class="gris">Administrar auditorias</span><span class="separador_tit">/</span><span class="gris_claro">Search</span></h1>
</div>
<?
	if($_SESSION["usr_tipo"]==1){
?>
<div id="btns_sup"><a href="index.php?put=proyecto_am"><img src="imagenes/btn_sup_add.jpg" alt="Agregar" border="0" /></a></div>
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
        <div id="btns_status">
			<img src="imagenes/btn_status_pendiente.jpg" alt="" border="0" id="status_1" />
			<img src="imagenes/btn_status_proceso.jpg" alt="" border="0" id="status_2" />
			<img src="imagenes/btn_status_finalizado.jpg" alt="" border="0" id="status_3" />
			<img src="imagenes/btn_status_all.jpg" alt="" border="0" id="status_all" />
		</div>
        <div id="status">Filtro de estado:
			<?
				if(($_POST["id_estado"] == -1) || empty($_POST["id_estado"])){
					$id = "all";
				}else{
					$id = $_POST["id_estado"];
				}
			?>
			<img src="imagenes/estado_<?=$id?>.gif" alt="" width="10" height="10" hspace="5" />
			<strong><?=getEstado($_POST["id_estado"],"Todos")?></strong>
		</div>
        <fieldset>
        <legend>Filtros</legend>
        <form action="index.php" method="get" id="projects_form" name="projects_form">
		  <input type="hidden" name="put" id="put" value="proyectos_search" />
		  <input type="hidden" name="id_estado" id="id_estado" value="<?=$_GET["id_estado"]?>" />
		  <?
		  	$filtro = "";
			$from = "";

			if(
				isset($_GET["id_estado"]) &&
				($_GET["id_estado"] != "") &&
				($_GET["id_estado"] > 0)
			){
				$filtro .= " AND p.id_estado_proyecto=".$_GET["id_estado"];
			}
		  ?>
		  <?
		    if(
				isset($_GET["filtro_id_cliente"]) &&
				($_GET["filtro_id_cliente"] != "") &&
				($_GET["filtro_id_cliente"] > 0)
			){
				$filtro .= " AND p.id_cliente=".$_GET["filtro_id_cliente"];
			}
		  ?>
          <div class="campo">
            <label for="filtro_id_cliente">Cliente:</label>
            <select name="filtro_id_cliente" id="filtro_id_cliente" style="width:200px;">
			  <option value="">--todos--</option>
			  <?
			  	$sql = "SELECT id_cliente, nombre FROM clientes ORDER BY nombre ASC";

				$result = mysql_query($sql,$link);

				while($get = mysql_fetch_array($result)){
					echo '<option value="'.$get["id_cliente"].'"'.(($get["id_cliente"] == $_GET["filtro_id_cliente"]) ? ' selected="selected"' : '').'>'.$get["nombre"].'</option>';
				}
			  ?>
            </select>
          </div>

          <?
			if(
				isset($_GET["filtro_id_sucursal"]) &&
				($_GET["filtro_id_sucursal"] != "0")
			){
				$filtro .= " AND p.id_sucursal=".$_GET["filtro_id_sucursal"];
			}
		  ?>
          <div class="campo">
            <label for="filtro_id_sucursal">Sucursal:</label>
            <select name="filtro_id_sucursal" id="filtro_id_sucursal" style="width:200px;">
            	<option value="0">--todos--</option>
			  <?
				if(isset($_GET["filtro_id_cliente"])){
					$sql = "SELECT id_sucursal, nombre FROM sucursales WHERE id_cliente = ".$_GET["filtro_id_cliente"]." ORDER BY nombre ASC";

					$result = mysql_query($sql,$link);

					while($get = mysql_fetch_array($result)){
						echo '<option value="'.$get["id_sucursal"].'"'.(($get["id_sucursal"] == $_GET["filtro_id_sucursal"]) ? ' selected="selected"' : '').'>'.$get["nombre"].'</option>';
					}
				}
			  ?>
            </select>
          </div>
		  
		  <?
		    if(
				isset($_GET["filtro_id_responsable"]) &&
				($_GET["filtro_id_responsable"] != "") &&
				($_GET["filtro_id_responsable"] > 0)
			){
				$filtro .= " AND p.id_usuario_responsable=".$_GET["filtro_id_responsable"];
			}
		  ?>
          <div class="campo">
            <label for="filtro_id_responsable">Shopper:</label>
            <select name="filtro_id_responsable" id="filtro_id_responsable" style="width:200px;">
			  <option value="">--todos--</option>
			  <?
			  	$sql = "SELECT id_usuario, nombre FROM usuarios ORDER BY nombre ASC";

				$result = mysql_query($sql,$link);

				while($get = mysql_fetch_array($result)){
					echo '<option value="'.$get["id_usuario"].'"'.(($get["id_usuario"] == $_GET["filtro_id_responsable"]) ? ' selected="selected"' : '').'>'.$get["nombre"].'</option>';
				}
			  ?>
            </select>
          </div>
		  
		  <?
			if(
				isset($_GET["filtro_archivo"]) &&
				($_GET["filtro_archivo"] != "")
			){
				$filtro .= " AND p.archivo_nro LIKE '".$_GET["filtro_archivo"]."'";
			}
		  ?>
          <div class="campo">
            <label for="filtro_archivo">Archivo:</label>
            <input type="text" name="filtro_archivo" id="filtro_archivo" value="<?=$_GET["filtro_archivo"]?>" style="width:88px;" />
          </div>

          <?
		    if(
				isset($_GET["filtro_id_tipo_proyecto"]) &&
				($_GET["filtro_id_tipo_proyecto"] != "") &&
				($_GET["filtro_id_tipo_proyecto"] > 0)
			){
				$filtro .= " AND p.id_tipo_proyecto=".$_GET["filtro_id_tipo_proyecto"];
			}
		  ?>
          <div class="campo">
            <label for="filtro_id_tipo_proyecto">Tipo:</label>
            <select name="filtro_id_tipo_proyecto" id="filtro_id_tipo_proyecto" style="width:100px;">
			  <option value="">--todos--</option>
			  <?
			  	$sql = "SELECT id_tipo_proyecto, descripcion FROM tipos_proyecto ORDER BY descripcion ASC";

				$result = mysql_query($sql,$link);

				while($get = mysql_fetch_array($result)){
					echo '<option value="'.$get["id_tipo_proyecto"].'"'.(($get["id_tipo_proyecto"] == $_GET["filtro_id_tipo_proyecto"]) ? ' selected="selected"' : '').'>'.$get["descripcion"].'</option>';
				}
			  ?>
            </select>
          </div>

          <div class="campos_unidos" style="width:314px;">
          	  <?
				if(
					isset($_GET["filtro_fecha_from"]) &&
					($_GET["filtro_fecha_from"] != "") &&
					isset($_GET["deshabilitar_fechas"])
				){
				  	$fecha = explode("/",$_GET["filtro_fecha_from"]);
					$filtro .= " AND p.fecha_inicio_estimada >= '".$fecha[2]."-".$fecha[1]."-".$fecha[0]."'";
				}

				if(
					isset($_GET["filtro_fecha_to"]) &&
					($_GET["filtro_fecha_to"] != "") &&
					isset($_GET["deshabilitar_fechas"])
				){
				  	$fecha = explode("/",$_GET["filtro_fecha_to"]);
					$filtro .= " AND p.fecha_fin_estimada <= '".$fecha[2]."-".$fecha[1]."-".$fecha[0]."'";
				}
		  	  ?>
			  <input name="deshabilitar_fechas" id="deshabilitar_fechas" type="checkbox" value="1" style="float:left" <?= (isset($_GET["deshabilitar_fechas"]) ? "checked=\"checked\"" : "")?>   />
			  <div class="campo_unido" style="width:153px;">
	            <label for="filtro_fecha_from" style="float:left; margin-top:4px; margin-right:4px;">Desde:</label>
	            <script type="text/javascript">
				// <![CDATA[
				<?
					if(empty($_GET["filtro_fecha_from"])){
						$fecha = getdate();
						$fecha_from = $fecha["mday"]."/".$fecha["mon"]."/".$fecha["year"];
					}else{
						$fecha_from = $_GET["filtro_fecha_from"];
					}
				?>
				  FSfncWriteFieldHTML("projects_form","filtro_fecha_from","<?=$fecha_from?>","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
				// ]]>
			  	</script>
	          </div>
	          <div class="campo_unido" style="width:140px;">
	            <label for="filtro_fecha_to" style="float:left; margin-top:4px; margin-right:4px;">Hasta:</label>
	            <script type="text/javascript">
				// <![CDATA[
				<?
					if(empty($_GET["filtro_fecha_to"])){
						$fecha = getdate();
						$fecha_to = $fecha["mday"]."/".$fecha["mon"]."/".$fecha["year"];
					}else{
						$fecha_to = $_GET["filtro_fecha_to"];
					}
				?>
				  FSfncWriteFieldHTML("projects_form","filtro_fecha_to","<?=$fecha_to?>","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
				// ]]>
			  	</script>
	          </div>
		  </div>
		  <?
		    if($_GET["filtro_plantilla"] == 1){
				$filtro .= " AND p.plantilla=1";
			}
			else{
				$filtro .= " AND p.plantilla=0";
			}
		  ?>
          <div class="campo">
            <label for="filtro_plantilla">Mostrar:</label>
            <select name="filtro_plantilla" id="filtro_plantilla" style="width:70px;">
			  <option value="0" <?=($_GET["filtro_plantilla"]==0?'selected="selected"':'')?>>Auditorias</option>
			  <option value="1" <?=($_GET["filtro_plantilla"]==1?'selected="selected"':'')?>>Plantilas</option>
            </select>
          </div>
          <div id="btns_ok_cancel"><a href="index.php?put=orders"><img src="imagenes/btn_clear.jpg" alt="" name="btn_clear" width="39" height="20" hspace="4" border="0" id="btn_clear" /></a>
            <input type="image" name="btn_search" src="imagenes/btn_search.jpg" id="btn_search" />
          </div>
        </form>
        </fieldset>
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
	}
?>
<form name="batch_commands" id="batch_commands" action="batch_commands_process.php" method="post">
<div id="lista">
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
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>ID </th>
			  <th>Cliente (ID)</th>
              <th>Nombre</th>
			  <?
				if($_SESSION["usr_tipo"]==1){
				?>
              <th>Contacto</th>
			  <?
			    }
			    ?>
              <th>Supervisor</th>
              <th>Shopper</th>
              <th>Inicio</th>
              <th>Fin</th>
              <th>Entrega</th>
              <th width="45">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
		  	<?php
				$paginacion=25;
				$ls=(isset($_GET["ls"])?$_GET["ls"]:0);

				$consulta = "
					SELECT
						p.id_proyecto,
						p.id_estado_proyecto,
						p.nombre,
						cl.id_cliente,
						DATE_FORMAT(p.fecha_inicio_estimada,'%d/%m/%Y') AS fecha_inicio_f,
						DATE_FORMAT(p.fecha_fin_estimada,'%d/%m/%Y') AS fecha_fin_f,
						DATE_FORMAT(p.fecha_entrega_estimada,'%d/%m/%Y') AS fecha_entrega_f,
						cl.nombre AS cliente,
						us.nombre AS supervisor,
						ur.nombre AS responsable,
						co.nombre AS contacto
					FROM
						proyectos AS p,
						clientes cl,
						usuarios us,
						usuarios ur,
						contactos co
					WHERE
						p.id_cliente = cl.id_cliente
						AND p.id_usuario_supervisor = us.id_usuario
						AND p.id_usuario_responsable = ur.id_usuario
						AND p.id_contacto_responsable = co.id_contacto
						
				";

				$consulta .= $filtro;

				if($_SESSION["usr_tipo"]==2){
					$consulta .= " AND p.id_usuario_responsable = ".$_SESSION["id_usr"];
					$consulta .= " AND p.plantilla = 0";
				}

				$consulta .= "
					ORDER BY
						p.fecha_inicio_estimada DESC
				";

				$result = mysql_query($consulta." LIMIT ".$ls.",".$paginacion,$link);

				echo mysql_error($link);

				$i = 0;

				$row_styles[0] = "lista_clara";
				$row_styles[1] = "lista_oscura";



				while($get = mysql_fetch_array($result)){
					$url = "index.php?put=proyecto&amp;id_proyecto=".$get["id_proyecto"]."&amp;id_cliente=".$get["id_cliente"];
			?>
            <tr class="<?=$row_styles[$i]?>">
              <td><a href="<?=$url?>"><?=$get["id_proyecto"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["cliente"]?> (<?=$get["id_cliente"]?>)</a></td>
              <td><a href="<?=$url?>"><?=$get["nombre"]?></a></td>
			  <?
				if($_SESSION["usr_tipo"]==1){
				?>
              <td><a href="<?=$url?>"><?=$get["contacto"]?></a></td>
			  <?
				}
			    ?>
              <td><a href="<?=$url?>"><?=$get["supervisor"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["responsable"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["fecha_inicio_f"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["fecha_fin_f"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["fecha_entrega_f"]?></a></td>
              <td><img src="imagenes/estado_<?=$get["id_estado_proyecto"]?>.gif" alt="" width="10" height="10" hspace="3" vspace="1"  />
			  	<?
				if($_SESSION["usr_tipo"]==1){
				?>
			  	<a href="index.php?put=proyecto_am&amp;id_proyecto=<?=$get["id_proyecto"]?>"><img src="imagenes/btn_edit.gif" alt="Editar" width="13" height="13" border="0" /></a>
			  	<a href="index.php?put=proyectos_search&amp;id_eliminar=<?=$get["id_proyecto"]?>"><img src="imagenes/btn_delete_on.gif" alt="Eliminar" width="11" height="11" border="0" onclick="return confirm('Esta seguro de borrar la auditoria?');" /></a>
				<?
				}
				?></td>
            </tr>
			<?
					$i = ($i+1)%2;
				}

				if(mysql_num_rows($result) == 0){
			?>
			<tr class="lista_clara">
				<td align="center" colspan="10">No se encontraron registros.</td>
			</tr>
			<?
				}
			?>
          </tbody>
        </table>
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
<div class="bloque_sin_degrade">
  <div class="cbza_bloque_sin_degrade">
    <div class="cont_fondo_bloque_sup_izq">
      <div class="fondo_bloque_sup_izq_sin_degrade"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_sup_der">
      <div class="fondo_bloque_sup_der_sin_degrade"><span></span></div>
    </div>
  </div>
  <div class="borde_bloque_izq">
    <div class="borde_bloque_der">
      <div class="cuerpo_bloque_sin_degrade">
        <?
			include("paginador.inc.php");
		?>
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

</form>
<script type="text/javascript" src="js_library/proyectos_search.js"></script>