<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ficha de alta de Auditoria</title>
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
            </strong> se agreg&oacute; al auditoria<strong>
            <?=$fila["nombre"]?>
            </strong> en el sistema para el cliente <strong>
            <?=$fila["cliente"]?>
          </strong></p>
          <p>El tipo de auditoria es <strong>
            <?=$fila["tipo_proyecto"]?>
            </strong>, se espera que se empiece el <strong>
            <?=$fila["fecha_ie_f"]?>
            </strong> y que se termine el <strong>
            <?=$fila["fecha_fe_f"]?>
            </strong> en un lapso de <strong>
            <?=$fila["horas_estimadas"]?>
            </strong> horas para poder ser entregado el <strong>
            <?=$fila["fecha_ee_f"]?>
          </strong>.</p>
          <p>Para contactarse con el cliente <strong>
            <?=$fila["cliente"]?>
            </strong> comun&iacute;quese con <strong>
            <?=$fila["contacto"]?>
            </strong> (<strong>
            <?=$fila["email_contacto"]?>
            </strong> - <strong>
            <?=$fila["telefono_contacto"]?>
          </strong>).</p>
          <p>El material para esta auditoria se encuentra en <strong>
            <?=$fila["path_server_local"]?>
          </strong></p>
          <p>El supervisor de la auditoria es <strong>
            <?=$fila["usuario_supervisor"]?>
            </strong> y el shopper es <strong>
            <?=$fila["usuario"]?>
            </strong>
          </p>
          <p>Auditoria:
            <?=$fila["nombre"]?>
          </p>
		  <p><?=$fila["obs"]?></p>
          <table cellpadding="0" cellspacing="5" border="0" width="80%">
            <tr>
              <th align="right">Cliente:</th>
              <td align="left"><?=$fila["cliente"]?></td>
            </tr>
            <tr>
              <th align="right">Contacto responsable:</th>
              <td align="left"><?=$fila["contacto"]?>
                (
                <a href="mailto:<?=$fila["email_contacto"]?>" target="_blank"><?=$fila["email_contacto"]?></a>
                -
                <?=$fila["telefono_contacto"]?>
                )</td>
            </tr>
            <tr>
              <th align="right">Usuario responsable:</th>
              <td align="left"><?=$fila["nombre_usuario"]?></td>
            </tr>
            <tr>
              <th align="right">Usuario supervisor:</th>
              <td align="left"><?=$fila["nombre_usuario_supervisor"]?></td>
            </tr>
            <tr>
              <th align="right">Fecha alta:</th>
              <td align="left"><?=$fila["fecha_a_f"]?></td>
            </tr>
            <tr>
              <th align="right">Fecha inicio estimada:</th>
              <td align="left"><?=$fila["fecha_ie_f"]?></td>
            </tr>
            <tr>
              <th align="right">Fecha fin estimada:</th>
              <td align="left"><?=$fila["fecha_fe_f"]?></td>
            </tr>
            <tr>
              <th align="right">Fecha entrega estimada:</th>
              <td align="left"><?=$fila["fecha_ee_f"]?></td>
            </tr>
            <tr>
              <th align="right">Direcci&oacute;n server local:</th>
              <td align="left"><a href="file://<?=$fila["path_server_local"]?>" target="_blank"><?=$fila["path_server_local"]?></a></td>
            </tr>
            <tr>
              <th align="right">Direcci&oacute;n de prueba:</th>
              <td align="left"><a href="<?=$fila["url_test"]?>" target="_blank"><?=$fila["url_test"]?></a></td>
            </tr>
            <tr>
              <th align="right">Direcci&oacute;n final:</th>
              <td align="left"><a href="<?=$fila["url_final"]?>" target="_blank"><?=$fila["url_final"]?></a></td>
            </tr>
          </table></table></td>
      </tr>
      <tr>
        <td><img src="<?=$url_site_zas?>/imagenes/feeds/pie.jpg" alt="" width="643" height="57" border="0" /></td>
      </tr>
    </table>
</body>
</html>
