<div id="titulo">
  <h1><span>Auditorias</span><span class="separador_tit">/</span><span class="gris">Bolsa de trabajo</span></h1>
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
			  <th>Cliente</th>
              <th>Auditoria</th>
              <th width="60">Inicio</th>
              <th width="60">Fin</th>
              <th width="11">&nbsp;</th>
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
						AND p.id_usuario_responsable = -1
						AND p.plantilla = 0
						AND p.id_estado_proyecto != 3
						AND NOT EXISTS (
							SELECT 
								pos.id_usuario 
							FROM 
								postulaciones pos
							WHERE
								pos.id_usuario = '".$_SESSION["id_usr"]."' AND
								pos.id_proyecto = p.id_proyecto
						)
						
				";
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
              <td><a href="<?=$url?>"><?=$get["cliente"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["nombre"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["fecha_inicio_f"]?></a></td>
              <td><a href="<?=$url?>"><?=$get["fecha_fin_f"]?></a></td>
			  <td><a href="index.php?put=postularse&amp;id=<?=$get["id_proyecto"]?>" onclick="return confirm('¿Realmente desea postularse para esta auditoria?')"><img src="imagenes/btn_postularme.png" width="65" height="20" alt=""></a></td>
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
