<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$_POST["nombre_form"]?></title>
</head>
<body>
<table width="768"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor="#E9E9E9"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="30" valign="bottom"><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><strong><?=$_POST["nombre_empresa"]?></strong></font></td>
              </tr>
              <tr>
                <td height="30" valign="top"><font color="#666666" size="2" face="Arial, Helvetica, sans-serif"><strong><?=$_POST["nombre_form"]?></strong></font></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td align="center" valign="middle"><table width="750" border="0" align="center" cellpadding="0" cellspacing="7">
			<?
			foreach($datos as $campo){
			?>
              <tr>
                <td align="left"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><?=$campo["titulo"]?></strong></font></td>
              </tr>
              <tr>
                <td align="left"><font color="#333333" size="2" face="Arial, Helvetica, sans-serif">
                  <?=nl2br($campo["valor"])?>
                  </font></td>
              </tr>
			<?
			}
			?>
            </table></td>
        </tr>
        <tr>
          <td bgcolor="#E9E9E9">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>