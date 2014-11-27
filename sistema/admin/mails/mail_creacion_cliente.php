<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mysterysur</title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="20">
  <tr>
    <td bgcolor="#7F7F7F"><table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left"><img src="<?= $url_site ?>/imagenes/cbza_mail_notificacion.png" width="640" height="82" alt="" /></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="20">
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><p><font face="Arial, Helvetica, sans-serif" size="3">Estimado <?=$_POST["nombre"]?>,</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">Usted ya pertenece al Staff de Mystery Sur. Para ingresar al sistema, deber&aacute; ir a <a href="http://www.mysterysur.com.ar" target="_blank">www.mysterysur.com.ar</a>, luego dirigirse a &quot;<strong>Acceso Shopper</strong>&quot; y deber&aacute; ingresar <br />
                          <strong>Usuario:</strong> <?=$_POST["user"]?> y <br />
                          <strong>Contrase&ntilde;a:</strong> <?=$_POST["pass"]?>.<br />
                          <br />
                        Ante cualquier problema de acceso al sistema, comun&iacute;quese a la brevedad.</font></p>
                      <p><font face="Arial, Helvetica, sans-serif" size="2"><strong>Saludos</strong></font></p></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td align="left"><img src="<?= $url_site ?>/imagenes/pie_mail_notificacion.png" width="640" height="57" alt="" /></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
