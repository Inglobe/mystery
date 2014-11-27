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
                      <td><p><font face="Arial, Helvetica, sans-serif" size="3">Hola  <?=getUsrNomById($_POST["id_usuario_responsable"])?>,</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">Has sido asignado a la siguiente auditoria:</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2"><?=$_POST["nombre"]?></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">Por favor ten el recaudo de dirigirte a los lugares / horas / fechas establecidas.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2" color="#990033">Imprime una copia de esta notificaci&oacute;n para futuras referencias.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2"><strong>A continuaci&oacute;n se presentan:</strong></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2"><strong>1-</strong> Todas las instrucciones de esta visita (por favor, lee detenidamente toda la informaci&oacute;n tan pronto como te sea posible)</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2"><strong>2- </strong>Instrucciones del informe.</font></p></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td bgcolor="#CCCCCC"><img src="<?= $url_site ?>/imagenes/spacer.gif" width="1" height="1" alt="" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><font face="Arial, Helvetica, sans-serif" size="3"><strong>1- Instrucciones sobre tu tarea:</strong></font>
                        <p><font face="Arial, Helvetica, sans-serif" size="2"><?=$fila["obs"]?></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">- En caso de un hecho fortuito que no te permita realizar la visita en tiempo y forma, o si necesitas extender el rango de fechas establecido,  por favor cont&aacute;ctate con tu supervisor lo antes posible.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2"><?=getUsrNomById($_POST["id_usuario_supervisor"])?></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2"><strong>- Antes de realizar la visita:</strong></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">Revisa detalladamente el cuestionario en el sistema, aseg&uacute;rate de conocer todos los puntos a observar, y as&iacute; saber qu&eacute; hacer, cuando hacerlo y qu&eacute; buscar.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2"><strong>- Una vez en el local:</strong></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">Permanece en el anonimato y en secreto. Si lo deseas, toma notas en un lugar privado, pero nunca dejes que te vean haci&eacute;ndolo.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">Si realizas una compra, Siempre pide un recibo / ticket / factura (No se reembolsara la compra, ni pagara la auditoria sin presentarlo) Es  preferible un factura detallada, sin embargo, si no consigues una, un recibo de tarjeta de cr&eacute;dito servir&aacute;.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">- Informe Final: El informe debe ser cargado personalmente por el shopper en el sistema, una vez completado y revisado este ser&aacute; aprobado, tu supervisor te informara si existen problemas o errores en el informe que deber&aacute;s solucionar dentro del plazo establecido.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2" color="#990033"><strong>IMPORTANTE</strong></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">Si el informe no es completado en el sistema dentro de las 24hs de realizada la  auditoria, el costo de la misma ser&aacute; deducido de la cuenta corriente del shopper. Por lo tanto es sumamente importante que siempre est&eacute;s en contacto con tu supervisor, el cual te asistir&aacute; ante cualquier inconveniente que se te presente.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2" color="#990033"><strong>IMPORTANTE</strong></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">Mysterysur s&oacute;lo ser&aacute; financieramente responsable de los informes realizados, siempre y cuando estos se encuentren dentro de las especificaciones establecidas (sucursal correcta / horas / fechas / etc.).</font></p></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td bgcolor="#CCCCCC"><img src="<?= $url_site ?>/imagenes/spacer.gif" width="1" height="1" alt="" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><font face="Arial, Helvetica, sans-serif" size="3"><strong>2- Informe Final:</strong></font>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">- Completa minuciosa y conscientemente el informe, es importante recordar los detalles de la visita, anota todas las observaciones que creas pertinentes y cuida la ortograf&iacute;a.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">- Todos los comentarios deben concordar con las preguntas de ese tema en el cuestionario, y es importante tambi&eacute;n incluir explicaciones completas sobre las respuestas &quot;NO&quot;.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">- Luego de haber realizado la visita, es importante que el supervisor pueda realizar consultas sobre el informe para poder aprobarlo. Si dentro de las 48 horas, luego de realizar la visita, el supervisor no recibe respuesta (por correo electr&oacute;nico o tel&eacute;fono), ser&aacute; motivo suficiente para dar de baja la asignaci&oacute;n de la auditoria. Es por esto que es importante que programes tus visitas con tiempo para evitar futuros inconvenientes.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2"><strong>- Recibos o facturas:</strong></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">Dentro del informe podr&aacute;s adjuntar im&aacute;genes escaneadas o fotograf&iacute;as, aseg&uacute;rate que la misma sea legible.</font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2"><strong>- Video:</strong></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">La grabaci&oacute;n del video es muy importante, es por esto que debes tener un buen control de la filmadora, conocer perfectamente su funcionamiento, y saber d&oacute;nde coloc&aacute;rtela, para as&iacute; evitar tener que repetir la auditoria por un mal uso.</font><font face="Arial, Helvetica, sans-serif" size="2"></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2" color="#990033"><strong>IMPORTANTE</strong></font></p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2">Para permanecer en el programa de asignaci&oacute;n de Mystery Shoppers, las direcciones de correo electr&oacute;nico se deben mantener al d&iacute;a. Por favor aseg&uacute;rese de hacernos saber si cambias tu direcci&oacute;n. </font> </p>
                        <p><font face="Arial, Helvetica, sans-serif" size="2"><strong>&iexcl;Muchas Gracias!</strong></font></p></td>
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
