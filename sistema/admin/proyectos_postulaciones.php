<div id="titulo">
  <h1><span>Auditorias</span><span class="separador_tit">/</span><span class="gris">Postulaciones</span></h1>
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
        <fieldset>
          <legend>Filtros</legend>
          <form name="projects_form" id="projects_form" method="get" action="index.php">
            <input type="hidden" value="proyectos_postulaciones" id="put" name="put">
            <input type="hidden" value="" id="id_estado" name="id_estado">
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
            <div id="btns_ok_cancel"><a href="index.php?put=proyectos_postulaciones"><img width="39" border="0" hspace="4" height="20" id="btn_clear" name="btn_clear" alt="" src="imagenes/btn_clear.jpg"></a>
              <input type="image" id="btn_search" src="imagenes/btn_search.jpg" name="btn_search">
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
        <table cellspacing="0" cellpadding="0" border="0" width="100%">
          <thead>
            <tr>
              <th>Shopper</th>
              <th>Auditoria</th>
              <th>Cliente</th>
              <th width="11">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
             <?php
				$paginacion=25;
				$ls=(isset($_GET["ls"])?$_GET["ls"]:0);

				$consulta = "
					SELECT
						pos.id_proyecto,
						pos.id_usuario,
						p.nombre AS proyecto,
						cl.nombre AS cliente,
						ur.nombre AS responsable
					FROM
						postulaciones pos,
						proyectos p,
						clientes cl,
						usuarios ur
					WHERE
						pos.id_proyecto = p.id_proyecto AND
						p.id_cliente = cl.id_cliente AND
						pos.id_usuario = ur.id_usuario AND
						p.plantilla = 0
				";
				
				$consulta .= $filtro;

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
              <td><a href="<?=$url?>"><?=$get["responsable"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["proyecto"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["cliente"]?></a></td>
			  <td><a href="index.php?put=asignar_postulado&amp;id_usuario=<?=$get["id_usuario"]?>&amp;id_proyecto=<?=$get["id_proyecto"]?>" onclick="return confirm('¿Esta seguro de asignar este postulado a la auditoria?')"><img src="imagenes/btn_aceptar.png" width="51" height="20" alt="" /></a></td>
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
