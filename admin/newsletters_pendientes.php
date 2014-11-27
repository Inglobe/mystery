    <?
		if(isset($_GET["id_eliminar"])){
			mysql_query("DELETE FROM newsletters WHERE id_newsletter = ".$_GET["id_eliminar"],$link);
		}
	?>
<div id="titulo">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><h1>Bandeja de salida</h1></td>
      <td class="separador_tit">/</td>
      <td><h1 class="gris">Pendientes</h1></td>
    </tr>
  </table>
</div>
<div id="solapas">
  <div id="solapa_add"><a href="#"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/solapa_pendientes_on.gif" alt="Pendientes" border="0" /></a></div>
  <div id="solapa_search"><a href="index.php?put=newsletters_enviados"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/solapa_enviados_off.gif" alt="Enviados" border="0" /></a></div>
</div>
<div id="contenido">
  <form id="form1" name="form1" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="recuadro_sin_sup">
            <tr>
              <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0">
	                   <tr>
                          <td width="1%" class="lista_cbza">&nbsp;</td>
                          <td width="45" class="lista_cbza">Fecha</td>
                          <td class="lista_cbza">Asunto</td>
                          <td width="1%" class="lista_cbza">&nbsp;</td>
                          <td width="1%" class="lista_cbza">&nbsp;</td>
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
				$consulta="SELECT *, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_f FROM newsletters WHERE enviado != 1";
			    $result = mysql_query($consulta." ORDER BY id_newsletter DESC LIMIT ".$ls.", ".$paginacion,$link);
			    while($fila=mysql_fetch_array($result)){
					$link_eliminar="index.php?put=".$_GET["put"]."&id_eliminar=".$fila["id_newsletter"]."";
                ?>
                        <tr>
                          <td class="lista_clara"><img src="imagenes/ico_mail.gif" alt="" width="13" height="10"/></td>
                          <td class="lista_clara"><a href="newsletters_ver.php?id=<?=$fila["id_newsletter"]?>" target="_blank"><?=$fila["fecha_f"]?></a></td>
                          <td class="lista_clara"><a href="newsletters_ver.php?id=<?=$fila["id_newsletter"]?>" target="_blank"><?=$fila["asunto"]?></a></td>
                          <td class="lista_clara"><a href="newsletters_save.php?id=<?=$fila["id_newsletter"]?>" target="_blank"><img src="imagenes/ico_save.gif" alt="Descargar HTML" border="0"/></a></td>
                          <td class="lista_clara"><a href="index.php?put=newsletters_enviar&id=<?=$fila["id_newsletter"]?>"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_enviar_small.gif" alt="Enviar" border="0"/></a></td>
                          <td class="lista_clara"><a href="<?=$link_eliminar?>" onclick="return confirm('Delete newsletter ?')"><img src="imagenes/ico_delete.gif" alt="Borrar" border="0"/></a></td>
                        </tr>
				<?
		        }
		        	if(mysql_num_rows($result)==0){
		        ?>
		        		<tr>
		        			<td align="center" colspan="6">No hay newsletters pendientes</td>
						</tr>
				<?
					}
				?>
                      </table></td>
                  </tr>

	             <tr>
                    <td class="pie_pagina"><? include("includes/paginador.php");?></td>
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
