<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Newsletters</title>
</head>

<body bgcolor="#7F7F7F" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
<table width="100%" border="0" cellspacing="20" cellpadding="0">
  <tr>
    <td bgcolor="#7F7F7F"><table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><font face="Arial, Helvetica, sans-serif" size="1" color="#FFFFFF"><a href="[URL_VER]" style="color:#FFF;">&iquest;Problemas visualizando este email? Ver Online</a></font></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><a href="<?=$url_site?>" target="_blank"><img src="<?=$url_site?>/newsletters/encabezados/<?=$_POST["encabezado"]?>" alt="" width="640" border="0" /></a></td>
        </tr>
        <tr>
          <td bgcolor="#A3A3A3"><table width="94%" border="0" align="center" cellpadding="10" cellspacing="0">
              <tr>
                <td><font face="Arial, Helvetica, sans-serif" size="2" color="#333333">
                  <?=$_POST["descripcion"]?>
                  </font></td>
              </tr>
              <? if(is_array($_POST["noticias"])){ ?>
              <tr>
                <td align="left"><font face="Arial, Helvetica, sans-serif" size="4" color="#5F0C66">Novedades</font></td>
              </tr>
              <tr>
                <td><?
				foreach($_POST["noticias"] as $id_noticia){
					$consulta_not = "SELECT n.*, nc.descripcion AS categoria, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_f FROM news n, categorias nc WHERE nc.id_categoria = n.id_categoria AND n.id_new = ".$id_noticia;
					$result_not = mysql_query($consulta_not,$link);
					echo mysql_error($link);
					$fila_noticia = mysql_fetch_assoc($result_not);
					$link_href=$url_site."/index.php?put=novedad-amp&id_novedad=".$fila_noticia["id_new"];
				?>
                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="109" align="left" valign="top"><table width="96%" border="0" align="left" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="130" align="center" valign="top"><a href="<?=$url_site?>/index.php?put=novedad-amp&amp;id=<?=$fila_noticia["id_new"]?>" target="_blank"><img src="<?=$url_site?>/newsletters/imagen.php?ruta=../imagenes/news/fotos/<?=$fila_noticia["foto"]?>&amp;ancho=104&amp;alto=88&amp;mantener_ratio=1" alt="" width="104" height="88" vspace="10" border="0" /></a></td>
                            <td valign="top"><table width="96%" border="0" align="center" cellpadding="6" cellspacing="0">
                                <tr>
                                  <td align="left"><font face="Arial, Helvetica, sans-serif" size="2"><strong><a href="<?=$url_site?>/index.php?put=novedad-amp&amp;id=<?=$fila_noticia["id_new"]?>" target="_blank" style="color:#000;">
                                    <?=xhtmlOut($fila_noticia["titulo"])?>
                                    </a></strong></font></td>
                                </tr>
                                <tr>
                                  <td align="left"><font face="Arial, Helvetica, sans-serif" size="2" color="#333">
                                    <?=xhtmlOut(recortar_texto($fila_noticia["bajada"],150))?>
                                    </font></td>
                                </tr>
                              </table></td>
                            <td width="120" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                                <tr>
                                  <td height="70" align="right" valign="top"><font face="Arial, Helvetica, sans-serif" size="2" color="#333"><strong>
                                    <?=xhtmlOut($fila_noticia["fecha_f"])?>
                                    </strong></font></td>
                                </tr>
                                <tr>
                                  <td align="right"><font face="Arial, Helvetica, sans-serif" size="2"><a href="<?=$url_site?>/index.php?put=novedad-amp&amp;id=<?=$fila_noticia["id_new"]?>" target="blank" style="color:#5F0C66;">[+] M&aacute;s info</a></font></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td bgcolor="#7F7F7F"><img src="<?=$url_site?>/newsletters/modelo_general/imagenes/spacer.gif" width="1" height="1" alt="" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                  <?
				}
				?>
                  <?
				}
				?></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><img src="<?=$url_site?>/newsletters/modelo_general/imagenes/pie.png" alt="" width="640" border="0" usemap="#Map2" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><font face="Arial, Helvetica, sans-serif" size="1" color="#FFFFFF">Este   e-mail no puede ni debe ser considerado SPAM siempre y cuando usted tenga la   posibilidad de ser dado de baja de nuestra lista.<br />
            Para no recibir nuestras publicaciones haga <a href="[URL_REMOVER]" style="color: #FFF;" target="_blank">click aqu&iacute;.</a></font></td>
        </tr>
      </table></td>
  </tr>
</table>
<font color="#7F7F7F">[TRACK]</font>
<map name="Map2" id="Map2">
  <area shape="rect" coords="196,52,342,69" href="mailto:danielconca@hotmail.com" />
</map>
</body>
</html>
