<?
		//Titulacion ABM
		$titulo_abm="Newsletters";
		$sub_titulo_abm="Crear";
		$titulo_opcion="Guardados";
		if(isset($_GET["id_eliminar"])){
			mysql_query("DELETE FROM newsletters_temp_datos WHERE id_newsletters_temp = ".$_GET["id_eliminar"],$link);
			mysql_query("DELETE FROM newsletters_temp WHERE id_newsletters_temp = ".$_GET["id_eliminar"],$link);
		}
		include("includes/titulos.php");
?>
<div id="solapas">
  <div id="solapa_search"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/solapa_guardados_on.gif" alt="Pendientes" border="0" /></div>
</div>
<div id="contenido">
  <form id="form1" name="form1" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="recuadro_sin_sup">
            <tr><td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0">
                        <tr>
                          <td width="1%" class="lista_cbza">&nbsp;</td>
                          <td width="45" class="lista_cbza">Fecha</td>
                          <td class="lista_cbza">Asunto</td>
                          <td width="1%" class="lista_cbza">&nbsp;</td>
                        </tr>
						<?
						$paginacion = $fila_parametros["paginacion"];
						if(isset($_GET["ls"])){
							$ls = $_GET["ls"];
						}
						else {
							$ls = 0;
						}
						$consulta="SELECT *, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_f FROM newsletters_temp";
					    $result = mysql_query($consulta." ORDER BY id_newsletters_temp DESC LIMIT ".$ls.", ".$paginacion,$link);
					    while($fila=mysql_fetch_array($result)){
							$link_eliminar="index.php?put=".$_GET["put"]."&id_eliminar=".$fila["id_newsletters_temp"]."";
                        ?>
                        <tr>
                          <td class="lista_clara"><img src="imagenes/ico_mail.gif" alt="" width="13" height="10" /></td>
                          <td class="lista_clara"><a href="index.php?put=newsletters_crear&amp;id=<?=$fila["id_newsletters_temp"]?>"><?=$fila["fecha_f"]?></a></td>
                          <td class="lista_clara"><a href="index.php?put=newsletters_crear&amp;id=<?=$fila["id_newsletters_temp"]?>"><?=$fila["asunto"]?></a></td>
						  <td class="lista_clara"><a href="<?=$link_eliminar?>" onclick="return confirm('Desea eliminar el newsletter?')"><img src="imagenes/ico_delete.gif" alt="Borrar" border="0" /></a></td>
                        </tr>
						<?
                        }
				        if(mysql_num_rows($result)==0){
				        ?>
			        		<tr>
			        			<td align="center" colspan="8">No hay newsletters guardados</td>
							</tr>
						<?
						}
						?>
                      </table></td>
                  </tr>
                  <tr>
                    <td class="pie_pagina"><? include("includes/paginador.php"); ?></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
</div>
