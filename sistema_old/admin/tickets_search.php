<div id="titulo">
  <h1><span>Hosting</span><span class="separador_tit">/</span><span class="gris">Tickets</span><span class="separador_tit">/</span><span class="gris_claro">Search</span></h1>
</div>
<div id="btns_sup"><a href="index.php?put=tickets_am&amp;abm_accion=a"><img src="imagenes/btn_sup_add.jpg" alt="Agregar" border="0" /></a></div>
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
			<img src="imagenes/btn_status_pendiente_ticket.jpg" alt="" border="0" id="status_1" />
			<img src="imagenes/btn_status_proceso_ticket.jpg" alt="" border="0" id="status_2" />
			<img src="imagenes/btn_status_finalizado_ticket.jpg" alt="" border="0" id="status_3" />
			<img src="imagenes/btn_status_all.jpg" alt="" border="0" id="status_all" />
		</div>
        <div id="status">Filtro de estado:
			<?
				if(($_GET["id_estado"] == -1) || empty($_GET["id_estado"])){
					$id = "all";
				}else{
					$id = $_GET["id_estado"];
				}
			?>
			<img src="imagenes/estado_<?=$id?>.gif" alt="" width="10" height="10" hspace="5" />
			<strong><?=getEstadoTicket($_GET["id_estado"],"Todos")?></strong>
		</div>
        <fieldset>
        <legend>Filtros</legend>
        <form action="index.php" method="get" id="projects_form" name="projects_form">
		  <input type="hidden" name="put" id="put" value="tickets_search" />
		  <input type="hidden" name="id_estado" id="id_estado" value="<?=$_GET["id_estado"]?>" />
		  <?
		  	$filtro = "";
			$from = "";

			if(
				isset($_GET["id_estado"]) &&
				($_GET["id_estado"] != "") &&
				($_GET["id_estado"] > 0)
			){
				$filtro .= " AND th.id_estado_ticket=".$_GET["id_estado"];
			}
		  ?>
		  <?
		    if(
				isset($_GET["filtro_id_cliente"]) &&
				($_GET["filtro_id_cliente"] != "") &&
				($_GET["filtro_id_cliente"] > 0)
			){
				$filtro .= " AND th.id_cliente=".$_GET["filtro_id_cliente"];
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
		    if(!empty($_GET["filtro_dominio"])){
				$filtro .= " AND th.dominio LIKE '%".$_GET["filtro_dominio"]."%'";
			}
		  ?>
		  <div class="campo">
            <label for="filtro_dominio">Dominio:</label>
            <input type="text" name="filtro_dominio" id="filtro_dominio" style="width:200px;" value="<?=xhtmlOut($_GET["dominio"])?>" />
          </div>
          <div class="campos_unidos" style="width:314px;">
          	  <?
				if(!empty($_GET["filtro_fecha_from"]) && !empty($_GET["filtro_fecha_to"])){
				  	$fecha_from = explode("/",$_GET["filtro_fecha_from"]);
				  	$fecha_to = explode("/",$_GET["filtro_fecha_to"]);
					$filtro .= " AND (th.fecha_vencimiento BETWEEN '".$fecha_from[2]."-".$fecha_from[1]."-".$fecha_from[0]."' AND '".$fecha_to[2]."-".$fecha_to[1]."-".$fecha_to[0]."')";
				}
		  	  ?>
			  
			  <div class="campo_unido" style="width:153px; padding-left:20px;">
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
		    if(
				isset($_GET["filtro_id_plan"]) &&
				($_GET["filtro_id_plan"] != "") &&
				($_GET["filtro_id_plan"] > 0)
			){
				$filtro .= " AND th.id_plan=".$_GET["filtro_id_plan"];
			}
		  ?>
          <div class="campo">
            <label for="filtro_id_plan">plan:</label>
            <select name="filtro_id_plan" id="filtro_id_plan" style="width:200px;">
			  <option value="">--todos--</option>
			  <?
			  	$sql = "SELECT id_plan, descripcion FROM hosting_planes ORDER BY descripcion ASC";

				$result = mysql_query($sql,$link);

				while($get = mysql_fetch_array($result)){
					echo '<option value="'.$get["id_plan"].'"'.(($get["id_plan"] == $_GET["filtro_id_plan"]) ? ' selected="selected"' : '').'>'.$get["descripcion"].'</option>';
				}
			  ?>
            </select>
          </div>
          <div id="btns_ok_cancel"><a href="index.php?put=tickets_search"><img src="imagenes/btn_clear.jpg" alt="" name="btn_clear" width="39" height="20" hspace="4" border="0" id="btn_clear" /></a>
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
              <th>Dominio</th>
			  <th>Cliente</th>
              <th>Emisi&oacute;n</th>
              <th>Vencimiento</th>
              <th>Fecha alta</th>
              <th>Fecha Env&iacute;o</th>
              <th>Monto</th>
              <th>Plan</th>
              <th width="45">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
		  	<?php
				$paginacion=50;
				$ls=(isset($_GET["ls"])?$_GET["ls"]:0);

				$consulta = "
					SELECT
						th.*,
						DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_f,
						DATE_FORMAT(fecha_vencimiento,'%d/%m/%Y') AS fecha_vencimiento_f,
						DATE_FORMAT(fecha_vencimiento,'%Y%m%d') AS fecha_vencimiento_f2,
						DATE_FORMAT(fecha_alta,'%d/%m/%Y') AS fecha_alta_f,
						DATE_FORMAT(fecha_envio,'%d/%m/%Y') AS fecha_envio_f,
						c.nombre AS cliente,
						p.descripcion AS plan
					FROM
						tickets_hosting th
							LEFT JOIN clientes c ON th.id_cliente = c.id_cliente
							INNER JOIN hosting_planes p ON th.id_plan = p.id_plan
					WHERE 
						1 = 1
				";

				$consulta .= $filtro;

				$consulta .= "
					ORDER BY
						th.fecha_vencimiento ASC
				";
				
				//echo $consulta;
				
				$result = mysql_query($consulta." LIMIT ".$ls.",".$paginacion,$link);

				echo mysql_error($link);

				$i = 0;

				while($get = mysql_fetch_array($result)){
					if($get["fecha_vencimiento_f2"]<date("Ymd",time()) && $get["id_estado_ticket"] == 1){
						$row_styles[0] = "lista_clara_pasada";
						$row_styles[1] = "lista_oscura_pasada";
					}
					else{
						$row_styles[0] = "lista_clara";
						$row_styles[1] = "lista_oscura";
					}
					
					$url = "index.php?put=tickets_am&amp;abm_accion=m&amp;id=".$get["id_ticket_hosting"];
			?>
            <tr class="<?=$row_styles[$i]?>">
              <td><a href="<?=$url?>"><?=$get["id_ticket_hosting"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["dominio"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["cliente"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["fecha_f"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["fecha_vencimiento_f"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["fecha_alta_f"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["fecha_envio_f"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["monto"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["plan"]?></a></td>
              <td><img src="imagenes/estado_<?=$get["id_estado_ticket"]?>.gif" alt="" width="10" height="10" hspace="3" vspace="4" /><?
			  if($get["id_metodo_pago"] < 3){
			  ?>
				<a href="javascript:MM_openBrWindow('tickets_enviar_ticket.pop.php?id=<?=$get["id_ticket_hosting"]?>','','scrollbars=yes,width=300,height=200')" title="Enviar ticket por e-mail" onclick="return confirm('¿Desea enviar el ticket por e-mail al cliente?')"><img src="imagenes/btn_mail_<?=$get["enviado"]?>.gif" alt="" hspace="8" vspace="2" border="0" alt="Enviar ticket por e-mail" /></a>
			  <?
			  }
			  else{
			  ?>
				<a href="#" title="Este m&eacute;todo de pago no acepta envio de por E-mail" onclick="alert('Este método de pago no acepta envio de por E-mail');return false;"><img src="imagenes/btn_mail_0.gif" alt="" hspace="8" vspace="2" border="0" alt="Este m&eacute;todo de pago no acepta envio de por E-mail" /></a>
			  <?
			  }
			  ?>
			  <a href="javascript:MM_openBrWindow('ticket_print.pop.php?id=<?=$get["id_ticket_hosting"]?>','','scrollbars=yes,width=720,height=500')" title="Imprimir ticket"><img src="imagenes/btn_print.gif" alt="" hspace="8" vspace="2" border="0" alt="Imprimir ticket" /></a>
			  </td>
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
<script type="text/javascript" src="js_library/tickets_search.js"></script>