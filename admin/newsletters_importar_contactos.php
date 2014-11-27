<?
	require("procesos_globales.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Control Panel - ABM</title>
<link href="skins/gris/estilos.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
	function validar(f){
		//f.enviar.disabled = true;
		if(f.archivo.value == ""){
			alert("Seleccione un archivo.");
			f.archivo.focus();
			document.getElementById("feed_ok").innerHTML="";
			return false;
		}
		if(f.id_grupo_news.value == 0){
			alert("Seleccione un grupo.");
			f.id_grupo_news.focus();
			document.getElementById("feed_ok").innerHTML="";
			return false;
		}
		document.getElementById("feed_ok").innerHTML="<img src=\"imagenes/relojito.gif\" /> subiendo datos, espere...";
	}
</script>
</head>
<body>
<table width="284" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="titulo">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><h1>Importar Contactos </h1></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td class="recuadro"><form action="newsletters_importar_contactos_procesar.php" method="post" enctype="multipart/form-data" onsubmit="return validar(this)">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left"><input name="archivo" type="file" size="30" /></td>
                </tr>
                <tr>
                  <td align="right" valign="bottom"><table border="0" align="left" cellpadding="0" cellspacing="4">
                      <tr>
                        <td align="right">Grupo:</td>
                        <td><?
		$id_combo="id_grupo_news";
		$id_db="id_grupo_news";
		$item_ninguno="--seleccionar--";//ACORDARSE DE VALIDAR FORM
		$cadena_combo="SELECT * FROM grupos_news ORDER BY descripcion ASC";
		$campo_mostrar="descripcion";
		include("includes/combo.php");
	?></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td align="left" valign="bottom"><table border="0" cellspacing="4" cellpadding="0">
                    <tr>
                      <td>Delimitador de campos: </td>
                      <td><select name="delimitador">
                        <option value="PUNTOYCOMA">; (punto y coma)</option>
                        <option value="COMA">, (coma)</option>
                        <option value="PUNTO">. (punto)</option>
                        <option value="COMILLAS">&quot; (comillas)</option>
                        <option value="ESPACIO">ESPACIO</option>
                        <option value="TAB">TAB</option>
                      </select>
                      </td>
                    </tr>
                  </table></td>
                </tr>

                <tr>
                  <td height="30" align="right" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="right" valign="bottom" id="feed_ok"><a href="#" onclick="window.close()"><img src="skins/gris/es/btn_cancelar.gif" alt="" width="92" height="19" border="0" /></a> </td>
                      <td width="96" align="right"><input type="image" name="enviar" src="skins/gris/es/btn_ok.gif" /></td>
                    </tr>
                  </table>
                  </td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
