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
            <td><p><font face="Arial, Helvetica, sans-serif" size="3">Hola,<strong> <?=$_POST["nombre"]?></strong></font></p>
              <p><font face="Arial, Helvetica, sans-serif" size="2">Gracias por utilizar nuestros servicios.</font></p>
              <p><font face="Arial, Helvetica, sans-serif" size="2">Utilice el usuario: <strong><?=$_POST["user"]?></strong> y la contrase&ntilde;a <strong><?=$_POST["pass"]?></strong> para poder ingresar a nuestro sistema.</font></p>
              <p><font face="Arial, Helvetica, sans-serif" size="2" color="#990033">Este mensaje de correo electr&oacute;nico contiene informaci&oacute;n importante sobre c&oacute;mo usar la cuenta y sobre lo que tiene que hacer en caso olvidar su contrase&ntilde;a.<br />
                Guarde o imprima una copia de este mensaje para poder utilizarlo como referencia en el futuro.</font></p>
              <p><font face="Arial, Helvetica, sans-serif" size="2"><strong>PARA INICIAR SESI&Oacute;N</strong><br />
                <br />
                Ingrese a <a href="http://www.mysterysur.com.ar" target="_blank">www.mysterysur.com.ar</a>, luego dir&iacute;jase a &quot;<strong>Acceso Cliente</strong>&quot; , a continuaci&oacute;n, escriba su usuario y contrase&ntilde;a en el cuadro de inicio de sesi&oacute;n.</font></p>
              <p><font face="Arial, Helvetica, sans-serif" size="2"><strong>PARA CERRAR SESI&Oacute;N</strong><br />
                <br />
                Haga clic en el v&iacute;nculo Logout situado arriba a la derecha de su pantalla.<br />
                <br />
                <strong>Saludos</strong></font></p></td>
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
