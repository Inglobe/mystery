<?
//Titulacion ABM
$titulo_abm="Newsletters";
$sub_titulo_abm="Crear";
$titulo_opcion="Nuevo";
require("../includes/fckeditor/fckeditor.php");
?>
<script language="JavaScript" type="text/JavaScript">
<!--
function validar(f){
	if(f.asunto.value==""){
		alert("Asunto requerido.");
		return false;
	}
	if(f.email_reply.value==""){
		alert("E-mail de respuesta requerido.");
		return false;
	}
	return true;
}
//-->
</script>
<script language="javascript" src="includes/date_picker/scripts/fsdateselect.js"></script>
<link rel="stylesheet" href="includes/date_picker/styles/FSdateSelect.css" type="text/css">
<? include("includes/titulos.php");?>
<div id="contenido">
  <form action="index.php?put=newsletters_crear_procesar" method="post" name="form_newsletter" id="form_newsletter" enctype="multipart/form-data" onsubmit="return validar(this)">
    <input type="hidden" name="tipo_accion" value="editar" id="tipo_accion">
    <input type="hidden" name="template" value="modelo_general">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30"><strong>Datos</strong></td>
      </tr>
      <tr>
        <td class="recuadro"><table width="100%" border="0" cellspacing="10" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>Fecha de env&iacute;o:</td>
                  </tr>
                  <tr>
                    <td><?
						$nombre_abm="newsletter";
			            $nombre_datebox="fecha";
						include("includes/date_picker.php");
					?></td>
                  </tr>
                  <tr>
                    <td>Asunto:</td>
                  </tr>
                  <tr>
                    <td><?
                    	$nombre_campo="asunto";
                    	$tamanio_texto=100;
                    	$tamanio_texto_maximo=100;
                    	$tipo="normal";
                    	include("includes/campo_texto.php");
                    ?></td>
                  </tr>
                  <tr>
                    <td>E-mail From</td>
                  </tr>
                  <tr>
                    <td><input name="email_from" type="text" size="45" value="<?=$fila_parametros["email_newsletter"]; ?>" /></td>
                  </tr>
                  <tr>
                    <td>Nombre From</td>
                  </tr>
                  <tr>
                    <td><input name="nombre_from" type="text" size="30" value="<?=$fila_parametros["nombre_email_newsletter"]; ?>" /></td>
                  </tr>
                  <tr>
                    <td>E-mail de respuesta</td>
                  </tr>
                  <tr>
                    <td><input name="email_reply" type="text" size="45" value="<?=$fila_parametros["email_reply_newsletter"]; ?>" /></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20"><div id="contenedor_solapas_news">
            <div id="solapa_import"><a href="#" onclick="document.getElementById('importar_news').style.display='';document.getElementById('editar_news').style.display='none'"><img src="skins/gris/es/solapa_importar_on.gif" alt="" width="127" height="20" border="0" /></a></div>
            <div id="solapa_edit"><a href="#" onclick="document.getElementById('importar_news').style.display='none';document.getElementById('editar_news').style.display=''"><img src="skins/gris/es/solapa_editar_on.gif" alt="" width="117" height="20" border="0" /></a></div>
          </div></td>
      </tr>
      <tr>
        <td><div id="editar_news">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="recuadro"><table width="95%" border="0" align="right" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="30"><strong>Encabezados</strong></td>
                    </tr>
                    <tr>
                      <td><!--inicio tabla-->
                        <table width="100%" border="0" cellspacing="5" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <?
	if($gestor = opendir('../newsletters/encabezados')){
		$i=0;
		while (false !== ($archivo = readdir($gestor))){
			if($archivo!="." && $archivo!=".."){
				$tmp=explode(".",$archivo);
				foreach($tmp as $valor){
					$extension=$valor;
				}
				if($extension=="JPG" || $extension=="jpg"){
					$i++;
    ?>
                                <tr>
                                  <td><input name="encabezado" type="radio" value="<?=$archivo?>" <?
            		if($i==1)
            			echo "checked";
	?>/>
                                  </td>
                                  <td><table border="0" cellspacing="5" cellpadding="0">
                                      <tr>
                                        <td><!--cabezal-->
                                          <img src="imagen.php?ruta=../newsletters/encabezados/<?=$archivo?>&amp;ancho=512"/> </td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <?
		  	  	}
			}
		}
		closedir($gestor);
	}
?>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="30"><strong>Cuerpo</strong></td>
                    </tr>
                    <tr>
                      <td><table width="100%" border="0" cellspacing="10" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td>Descripci&oacute;n:</td>
                                </tr>
                                <tr>
                                  <td><?
						$nombre_campo="descripcion";
                    	$alto_richtext=400;
                    	$tipo="richtext";
                    	include("includes/campo_texto.php");
                    ?></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <!--Inicio Lista-->
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
<? /*
    	//INICIO NEWS
		$result = mysql_query("SELECT COUNT(*) AS nro FROM news WHERE newsletters = 1",$link);
		echo mysql_error($link);
		$row_news = mysql_fetch_array($result);
		if($row_news["nro"] > 0){
?>
                    <tr>
                      <td height="30"><strong>Novedades</strong></td>
                    </tr>
<?
			$sql = "SELECT *, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_f FROM news WHERE newsletters = 1 ORDER BY fecha DESC";
			$result = mysql_query($sql,$link);
			echo mysql_error($link);
?>
                    <tr>
                      <td><table width="95%"  border="0" cellpadding="0" cellspacing="1">
                          <tr>
                            <td width="1%" align="center">&nbsp;</td>
                            <td width="10%" align="left">&nbsp;</td>
                            <td width="20%" align="left"><strong>Fecha</strong></td>
                            <td width="49%" align="left"><strong>T&iacute;tulo</strong></td>
                          </tr>
<?
                	while($row_news = mysql_fetch_array($result)){
?>
                          <tr class="lista_oscura">
                            <td width="1%" align="center"><input name="noticias[]" type="checkbox" value="<?=$row_news["id_new"]?>" checked="checked"/></td>
                            <td width="10%" align="left">&nbsp;</td>
                            <td width="20%" align="left"><?=$row_news["fecha_f"]?></td>
                            <td width="49%" align="left"><?=$row_news["titulo"]?></td>
                          </tr>
                          <?
                    }
                  ?>
                        </table></td>
                    </tr>
                    <?

		}
	*/ ?>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
              <!--Fin Lista-->
              <tr>
                <td class="linea"><img src="imagenes/spacer.gif" alt="" width="1" height="1" class="linea" /></td>
              </tr>
              <tr>
                <td height="30" valign="bottom"><table border="0" align="right" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="106" align="left"><a href="#" onclick="document.getElementById('tipo_accion').value='editar';document.form_newsletter.action='newsletters_preview.php';document.form_newsletter.target='_blank';document.form_newsletter.submit(); return false;"> <img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_vista_preliminar.gif" alt="Vista Preliminar" width="102" height="19" border="0" /></a></td>
                      <td align="left"><a href="#" id="btn_crear"> <img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_crear.gif" alt="Crear" width="92" height="19" border="0" /></a></td>
                      <script>
					  	// [CDATA[
							document.getElementById('btn_crear').onclick = function() {
								var val = validar(document.getElementById('form_newsletter'));
								if(val){
									document.getElementById('tipo_accion').value='editar';
									document.form_newsletter.action='index.php?put=newsletters_crear_procesar';
									document.form_newsletter.target='_self';
									document.form_newsletter.submit();
								}
								return false;
							}
						// ]]
					  </script>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </div>
          <div id="importar_news" style="display:none">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table width="100%" border="0" cellpadding="0" cellspacing="10" class="recuadro">
                    <tr>
                      <td>Seleccione el archivo a importar: </td>
                    </tr>
                    <tr>
                      <td><input type="file" name="archivo_html" /></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td height="30" align="right" valign="bottom"><a href="#" onclick="document.getElementById('tipo_accion').value='importar';document.form_newsletter.action='index.php';document.form_newsletter.target='_self';document.form_newsletter.submit(); return false;"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_crear.gif" alt="Crear" width="92" height="19" border="0" /></a></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
          </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
</div>
