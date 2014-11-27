<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket de pago de Hosting</title>
<style type="text/css">
<!--
body {
	margin: 0px;
	padding: 0px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #666666;
}
.texto_azul {
	color: #0066CC;
}
.texto_11 {
	font-size: 11px;
}
.recuadro {
	border: 1px solid #666666;
}
-->
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="recuadro">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="207"><img src="<?=$url_site?>/imagenes/tickets_hosting/logo_zephia.gif" alt="" width="207" height="60" /></td>
          <td><img src="<?=$url_site?>/imagenes/tickets_hosting/fondo_cbza.gif" alt="" width="100%" height="60" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center"><table width="98%" border="0" cellspacing="0" cellpadding="6">
        <tr>
          <td>&nbsp;</td>
          <td align="right">Fecha de emisi&oacute;n: <?=$fila["emision"]?></td>
        </tr>
        <tr>
          <td><span class="texto_azul">Cliente:</span> <?=$fila["cliente"]?></td>
          <td align="right"><span class="texto_azul">Nro de Cliente:</span> 26611</td>
        </tr>
        <tr>
          <td class="texto_azul">Detalle de pago</td>
          <td align="right" class="texto_azul">-</td>
        </tr>
        <tr>
          <td colspan="2"><img src="<?=$url_site?>/imagenes/tickets_hosting/linea.gif" alt="" width="100%" height="1" /></td>
        </tr>
		<tr>
          <td colspan="2"><font color="#000000"><strong><?=$fila["plan"]?> para <?=$fila["dominio"]?></strong></font></td>
        </tr>
    <?
	if(is_array($lineas_detalle)){
		foreach($lineas_detalle as $detalle){
			list($key, $precio) = each($lineas_precio);
			$total+=$precio;
    ?>
        <tr>
          <td><?=$detalle?></td>
          <td align="right"><strong>$<?=$precio?></strong></td>
        </tr>
    <?
    	}
	}
    ?>
        <tr>
          <td colspan="2"><img src="<?=$url_site?>/imagenes/tickets_hosting/linea.gif" alt="" width="100%" height="1" /></td>
        </tr>
        <tr>
          <td><strong>Fecha de vencimiento:</strong> <span class="texto_azul"><?=$fila["vencimiento"]?></span></td>
          <td align="right" class="texto_azul"><strong>Total a pagar: <font size="3" color="#000000">$<?=number_format($fila["monto"],2)?></font></strong></td>
        </tr>
        <tr>
          <td colspan="2" valign="bottom" class="texto_11">Observaciones:</td>
        </tr>
        <tr>
          <td colspan="2" class="texto_11"><?=$fila["detalle"]?></td>
        </tr>
        <tr>
          <td colspan="2" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="22"><img src="<?=$url_site?>/imagenes/tickets_hosting/tijera.gif" alt="" width="22" height="17" /></td>
                <td><img src="<?=$url_site?>/imagenes/tickets_hosting/linea.gif" alt="" width="100%" height="1" /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td colspan="2" align="center">Imprima este c&oacute;digo para pagar con la modalidad Pago F&aacute;cil.</td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25%"><table border="0" align="center" cellpadding="0" cellspacing="2" class="texto_11">
                    <tr>
                      <td align="right"><font size="2">Nro de cliente:</font></td>
                      <td><font size="2" color="#000000"><strong>26611</strong></font></td>
                    </tr>
                    <tr>
                      <td align="right"><font size="2">Vencimiento:</font></td>
                      <td> <font size="2" color="#000000"><strong><?=$fila["vencimiento"]?></strong> </font></td>
                    </tr>
                    <tr>
                      <td align="right"><font size="2">Total a pagar:</font></td>
                      <td><font size="3" color="#000000"><strong>$<?=number_format($fila["monto"],2)?></strong></font></td>
                    </tr>
                  </table></td>
                <td align="center">
				<?
                if ($fila["id_metodo_pago"] == 1){
                ?>
				<img src="<?=$url_site?>/imagenes/tickets_hosting/codigo_datatec.gif" alt="" height="71"/>
				<?
                }
                else if($fila["id_metodo_pago"] == 2){
                ?>
                <img src="<?=$url_site?>/imagenes/tickets_hosting/codigo_hostmar.gif" alt="" height="71"/>
				<?
				}
				?>
				</td>
                <td width="25%" align="center">
				<img src="<?=$url_site?>/imagenes/tickets_hosting/logo_pago_facil.gif" alt="" width="79" height="63" />
				</td>
              </tr>
			  <tr>
		        <td colspan="4" align="center">&nbsp;</td>
		      </tr>
		      <tr>
		        <td colspan="4" align="center"><font color="#000000"><strong>Una vez que haya realizado el pago deber&aacute; informar el mismo con el c&oacute;digo de verificaci&oacute;n Pago Facil. <br />(&Eacute;ste c&oacute;digo, el primero de 4 cifras y el segundo de una letra y 5 cifras, se encuentra en su ticket de pago debajo de la leyenda SEPSA PAGO FACIL, e inmediatamente a la izquierda de la fecha de pago).</strong></font></td>
		      </tr>
			  <tr>
		        <td colspan="4" align="center">&nbsp;</td>
		      </tr>
			  <tr>
		        <td colspan="4" align="center">Para informar el pago haga click en el siguiente bot&oacute;n. <br /><br /><a href="http://www.zephia.com.ar/index.php?put=hosting_informar_pago&amp;id_ticket=<?=$fila["id_ticket_hosting"]?>&amp;vh=<?=md5(time())?>" target="_blank"><img src="<?=$url_site?>/imagenes/tickets_hosting/btn_informar_pago.jpg" alt="Informar Pago" border="0" /></a></td>
		      </tr>
			  <tr>
		        <td colspan="4" align="center">&nbsp;</td>
		      </tr>
			  <tr>
		        <td colspan="4" align="center">Tambi&eacute;n puede informar el pago v&iacute;a E-mail a <a href="mailto:administracion@zephia.com.ar">administracion@zephia.com.ar</a> o telef&oacute;nicamente al 0351-4861035. <br /><br /> <font color="#FF0000">Recuerde que <strong/>EL PAGO NO SE IMPUTAR&Aacute;</strong> en nuestros sistema hasta informar el mismo.</font> </td>
		      </tr>
			  <tr>
		        <td colspan="4" align="center">&nbsp;</td>
		      </tr>
            </table></td>
        </tr>
        <tr>
          <td colspan="2" align="center" bgcolor="#F5F5F5">Rufino Cuervo 1085 Of. 25 (Complejo Las Rosas Plaza) - Tel: +54 351 4861035 - administracion@zephia.com.ar</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
