<?
require("procesos_globales.php");
$fila_news=mysql_fetch_array(mysql_query("SELECT asunto FROM newsletters WHERE id_newsletter = ".$_GET["id_newsletter"],$link));
echo mysql_error($link);

$consulta="SELECT 		un.nombre AS nombre_usuario,
						un.email,
						DATE_FORMAT(t.fecha,'%d/%m/%Y %H:%i:%S') AS fecha_f,
						t.ip
			FROM 		usuarios_news un,
						trackeo t
			WHERE 		t.id_usuario_news = un.id_usuario_news
			AND 		t.id_newsletter = ".$_GET["id_newsletter"]." ORDER BY un.email ASC";
$result_consulta = mysql_query($consulta,$link);

$numero_aperturas=mysql_num_rows($result_consulta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Control Panel - ABM</title>
<link href="skins/<?=$abm_skin?>/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="titulo">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><h1>Aperturas : <?=$fila_news["asunto"]?></h1></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td height="30" align="right">N&ordm; Aperturas: <strong><?=$numero_aperturas?></strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="recuadro_sin_sup">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td>
				<!--I tabla-->
				<table width="100%" border="0" cellspacing="0">
                    <tr>
                      <td class="lista_cbza">E-mail</td>
                      <td class="lista_cbza">Nombre</td>
                      <td class="lista_cbza">Hora</td>
                      <td class="lista_cbza">IP</td>
                    </tr>
					<?
			while($fila=mysql_fetch_array($result_consulta)){
				if($color=="lista_clara")
					$color="lista_oscura";
				else
					$color="lista_clara";
        ?>
                    <tr>
		                <td class="<?=$color?>"><?=$fila["email"]?></td>
		                <td class="<?=$color?>"><?=$fila["nombre_usuario"]?></td>
		                <td class="<?=$color?>"><?=$fila["fecha_f"]?></td>
		                <td class="<?=$color?>"><a class="lista_links" href="http://network-tools.com/default.asp?host=<?=$fila["ip"]?>" target="_blank" ><?=$fila["ip"]?></a></td>
                    </tr>
					<?
        	}
        	if(mysql_num_rows($result_consulta)==0){
        ?>

        			<tr>
        				<td align="center" colspan="4">No hay registros</td>
					</tr>
		<?
			}
		?>
                  </table>
				  <!--I tabla-->
				  </td>
              </tr>
              <tr>
                <td height="21" class="pie_pagina"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
