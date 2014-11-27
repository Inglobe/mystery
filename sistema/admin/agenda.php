<?php
 	if(getUsrExterno($_SESSION["id_usr"])){
		$usuario_externo = true;
	}
	else{
		$usuario_externo = false;
	} 
?>
<script type="text/javascript">
<!--
	function recargar(){
		location.reload();
	}
//-->
</script>
<div id="titulo">
  <h1><span>Auditorias</span><span class="separador_tit">/</span><span class="gris">Agenda</span><span class="separador_tit">/</span><span class="gris_claro">Buscar</span></h1>
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
        <form action="index.php" method="get" id="agenda_form" name="agenda_form">
          <input type="hidden" name="put" id="put" value="agenda" />
          <fieldset>
          <legend>Filtros</legend>
          <?
				$filtro = "";
				$from = "";

				/*if(!isset($_GET["filtro_fecha_from"]) || !isset($_GET["filtro_fecha_to"])){
					$fecha_inicio = date("Y-m-d",time());
					$fecha_fin = date("Y-m-d",time());

					$filtro .= "AND '".$fecha_inicio."' BETWEEN t.fecha_inicio_estimada AND t.fecha_fin_estimada ";
				}
				else {
					$fecha_tmp = explode("/",$_GET["filtro_fecha_from"]);
					$fecha_inicio = $fecha_tmp["2"]."-".$fecha_tmp["1"]."-".$fecha_tmp["0"];

					$fecha_tmp = explode("/",$_GET["filtro_fecha_to"]);
					$fecha_fin = $fecha_tmp["2"]."-".$fecha_tmp["1"]."-".$fecha_tmp["0"];

					$filtro .= "AND '".$fecha_inicio."' BETWEEN t.fecha_inicio_estimada AND t.fecha_fin_estimada ";
				}*/
		  ?>
          <!-- <div class="campo">
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
				  FSfncWriteFieldHTML("agenda_form","filtro_fecha_from","<?=$fecha_from?>","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
				// ]]>
			</script>
          </div>
          <div class="campo">
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
				  FSfncWriteFieldHTML("agenda_form","filtro_fecha_to","<?=$fecha_to?>","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
				// ]]>
			  	</script>
          </div> -->
          <?
			if($_SESSION["usr_tipo"]==1){
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
            <select name="filtro_id_cliente" id="filtro_id_cliente" style="width:225px;">
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
          } 
          ?>
          <?
		  if($_SESSION["usr_tipo"]==1){
		  		if(!isset($_GET["filtro_id_usuario_responsable"])){
		  			$_GET["filtro_id_usuario_responsable"] = $_SESSION["id_usr"];
		  		}

				if(
					isset($_GET["filtro_id_usuario_responsable"]) &&
					($_GET["filtro_id_usuario_responsable"] != "") &&
					($_GET["filtro_id_usuario_responsable"] > 0)
				){
					$filtro .= " AND p.id_usuario_responsable = ".$_GET["filtro_id_usuario_responsable"];
				}
			  ?>
          <div class="campo">
            <label for="filtro_id_cliente">Shopper:</label>
            <select name="filtro_id_usuario_responsable" id="filtro_id_usuario_responsable" style="width:225px;">
              <option value="">--todos--</option>
              <?
					$sql = "SELECT id_usuario, nombre FROM usuarios ORDER BY nombre ASC";

					$result = mysql_query($sql,$link);

					while($get = mysql_fetch_array($result)){
						echo '<option value="'.$get["id_usuario"].'"'.(($get["id_usuario"] == $_GET["filtro_id_usuario_responsable"] || (!isset($_GET["filtro_id_usuario_responsable"]) && $get["id_usuario"] == $_SESSION["id_usr"])) ? ' selected="selected"' : '').'>'.$get["nombre"].'</option>';
					}
				  ?>
            </select>
          </div>
          <?
          }
          else{
          	$filtro .= " AND p.id_usuario_responsable = ".$_SESSION["id_usr"];
          }
          ?>
          <?
		  if($_SESSION["usr_tipo"]==1){
				if(
					isset($_GET["filtro_id_usuario_supervisor"]) &&
					($_GET["filtro_id_usuario_supervisor"] != "") &&
					($_GET["filtro_id_usuario_supervisor"] > 0)
				){
					$filtro .= " AND p.id_usuario_supervisor = ".$_GET["filtro_id_usuario_supervisor"];
				}
			  ?>
          <div class="campo">
            <label for="filtro_id_usuario_supervisor">Supervisor:</label>
            <select name="filtro_id_usuario_supervisor" id="filtro_id_usuario_supervisor" style="width:225px;">
              <option value="">--todos--</option>
              <?
					$sql = "SELECT id_usuario, nombre FROM usuarios ORDER BY nombre ASC";

					$result = mysql_query($sql,$link);

					while($get = mysql_fetch_array($result)){
						echo '<option value="'.$get["id_usuario"].'"'.(($get["id_usuario"] == $_GET["filtro_id_usuario_supervisor"]) ? ' selected="selected"' : '').'>'.$get["nombre"].'</option>';
					}
			  ?>
            </select>
          </div>
		  <?
		  }
		  else{
          	//$filtro .= " AND p.id_usuario_supervisor = ".$_SESSION["id_usr"];
          }
		  ?>
          </fieldset>
          <div id="btns_ok_cancel"><a href="index.php?put=agenda"><img src="imagenes/btn_clear.jpg" alt="" name="btn_clear" width="39" height="20" hspace="4" border="0" id="btn_clear" /></a>
            <input type="image" name="btn_search" src="imagenes/btn_search.jpg" id="btn_search" />
          </div>
        </form>
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
              <th width="11">&nbsp;</th>
              <th>Auditoria</th>
              <th>Cliente</th>
              <th>Shopper</th>
              <th width="60">Inicio</th>
              <th width="60">Fin</th>
              <th>&nbsp;</th>
              <th width="11">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?
            	$tiene_fuego = false;

				$paginacion=500;
				$ls=(isset($_GET["ls"])?$_GET["ls"]:0);

				$consulta = "
					SELECT
						p.*
						, DATE_FORMAT(p.fecha_inicio_estimada, '%d/%m/%Y') AS fecha_ief
						, DATE_FORMAT(p.fecha_fin_estimada, '%d/%m/%Y') AS fecha_fef
						, c.nombre AS cliente
						, c.id_cliente
					FROM
						proyectos p
						, clientes c
					WHERE
						p.id_estado_proyecto != 3
					AND
						c.id_cliente = p.id_cliente
				";

				$consulta .= $filtro;

				$consulta .= "
					GROUP BY
						p.id_proyecto
					ORDER BY
						p.fecha_fin_estimada DESC
				";

				//echo "<hr>".$consulta."<hr>";

				$result = mysql_query($consulta." LIMIT ".$ls.",".$paginacion,$link);

				echo mysql_error($link);

				$i = 0;

				$row_styles[0] = "lista_clara";
				$row_styles[1] = "lista_oscura";

				while($get = mysql_fetch_array($result)){

						//$url = "javascript:showPopWin('tarea.pop.php?id_proyecto=".$get["id_proyecto"]."&id_cliente=".$get["nro_cliente"]."&am=m&id_tarea=".$get["id_tarea"]."&id_padre=".$get["id_cliente"]."',700,520,null)";;
						$url = "index.php?put=proyecto&amp;id_proyecto=".$get["id_proyecto"]."&amp;id_cliente=".$get["id_cliente"];

						$aux = explode("/",$get["fecha_fef"]);
						$aux = $aux[2].$aux[1].$aux[0];
						if($aux < date("Ymd",time())){
							$pasada = true;
						}
						else{
							$pasada = false;
							if($aux > date("Ymd",time())){
								$futura = true;
							}
							else{
								$futura = false;
							}
						}

			?>
            <tr class="<?=$row_styles[$i].($pasada?"_pasada":($futura?"_futura":""))?>">
              <td width="11"><a href="<?=$url?>"><img src="imagenes/ico_tarea.gif" alt="" /></a></td>
              <td><a href="<?=$url?>" <?=($get["id_prioridad_tarea"]==5?'class="texto_fuego"':"")?>>
                <?=$get["nombre"]?>
                <?=$get["fecha_prueba"]?>
                </a></td>
              <td><a href="<?=$url?>" <?=($get["id_prioridad_tarea"]==5?'class="texto_fuego"':"")?>>
                <?=$get["cliente"]?>
                </a></td>
              <td><a href="<?=$url?>" <?=($get["id_prioridad_tarea"]==5?'class="texto_fuego"':"")?>>
                <?=getUsrNomById($get["id_usuario_responsable"])?>
                </a></td>
              <td><a href="<?=$url?>" <?=($get["id_prioridad_tarea"]==5?'class="texto_fuego"':"")?>>
                <?=$get["fecha_ief"]?>
                </a></td>
              <td><a href="<?=$url?>" <?=($get["id_prioridad_tarea"]==5?'class="texto_fuego"':"")?>>
                <?=$get["fecha_fef"]?>
                </a></td>
              <td><?
				if($get["obs_fin"]!=""){
				?>
                <img src="imagenes/ampliar_3.gif" alt="" />
                <?
				}
				if($get["obs_proceso"]!="" ){
				?>
                <img src="imagenes/ampliar_2.gif" alt="" />
                <?
				}
				if($get["obs"]!="" ){
				?>
                <img src="imagenes/ampliar_1.gif" alt="" />
                <?
				}
				?></td>
              
              <td><img src="imagenes/estado_<?=$get["id_estado_proyecto"]?>.gif" alt="" /></td>
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
