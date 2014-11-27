<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tienes una nueva notificaci&oacute;n en el sistema</title>
</head>
<body>
<table width="643" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="<?=$url_site_zas?>/imagenes/feeds/cbza.jpg" alt="" width="643" height="127" border="0" /></td>
  </tr>
  <tr>
    <td background="<?=$url_site_zas?>/imagenes/feeds/fondo.jpg"><table width="92%" border="0" align="center" cellpadding="0" cellspacing="14">
        <tr>
          <td style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color: #666666"><p>Hola <strong>
              <?=$fila_usuario["nombre"]?>
              </strong>.</p>
            <p>El d&iacute;a <strong>
              <?=$fila["fecha_a_f"]?>
              </strong> se te notific&oacute; la tarea:</p>
              <p><strong><?=getTareasPadres($id_tarea)?> &gt; <?=$fila["descripcion"]?></strong></p>
			  <p>en el sistema, del proyecto<strong>
              <?=$fila["proyecto"]?>
              </strong> para el cliente <strong>
              <?=$fila["cliente"]?>
              </strong></p>
            <p>El tipo de tarea es <strong>
              <?=$fila["tipo_tarea"]?>
              </strong>, se espera que se empiece el <strong>
              <?=$fila["fecha_ie_f"]?>
              </strong> y que se termine el <strong>
              <?=$fila["fecha_fe_f"]?>
              </strong>.</p>
            <p>El supervisor de la tarea es<strong>
              <?=$fila["usuario_supervisor"]?>
              </strong> y el responsable es <strong>
              <?=$fila["usuario_responsable"]?>
              </strong> </p>
            <p>
              <?=$fila["obs"]?>
            </p>
			<p>Saludos, Zephia Administration System.</p></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><img src="<?=$url_site_zas?>/imagenes/feeds/pie.jpg" alt="" width="643" height="57" border="0" /></td>
  </tr>
</table>
</body>
</html>
