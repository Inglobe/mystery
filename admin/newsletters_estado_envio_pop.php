<?php
require("procesos_globales.php");
function check_apertura($id_newsletter, $id_usuario_news)
{
    global $link;
    $result = mysql_query("SELECT COUNT(*) AS nro FROM trackeo WHERE id_newsletter = ".$id_newsletter." AND id_usuario_news = ".$id_usuario_news, $link);
    $fila = mysql_fetch_array($result);
    if($fila["nro"] == 0)
        return false;
    else
        return true;
}

$fila_news = mysql_fetch_array(mysql_query("SELECT asunto, nombre_from, email_from, email_reply, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_f FROM newsletters WHERE id_newsletter = ".$_GET["id_newsletter"], $link));
echo mysql_error($link);

$consulta = "SELECT	 	un.nombre AS nombre_usuario,
						m.id_newsletter,
						m.id_usuario_news,
						un.email,
						DATE_FORMAT(m.fecha_creacion,'%d/%m/%Y %H:%i:%S') AS fecha_cf,
						DATE_FORMAT(m.fecha_envio,'%d/%m/%Y %H:%i:%S') AS fecha_ef,
						m.id_estado_envio,
						ee.descripcion AS estado_envio_desc
			FROM 		usuarios_news un,
						mailbox m,
						estados_envio ee
			WHERE 		m.id_usuario_news = un.id_usuario_news
			AND			ee.id_estado_envio = m.id_estado_envio
			AND 		m.id_newsletter = ".$_GET["id_newsletter"];

if(isset($_GET["filtro"]) && $_GET["filtro"] != 0) {
    $consulta .= " AND m.id_estado_envio = " . $_GET["filtro"];
}
$result_consulta = mysql_query($consulta . " ORDER BY un.email", $link);
if(isset($_GET["filtro"]) && $_GET["filtro"] != 0){
	$nro_encontrados = mysql_num_rows($result_consulta);
}
echo mysql_error($link);

$fila_numero_envios = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS nro FROM mailbox WHERE id_newsletter = ".$_GET["id_newsletter"], $link));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Control Panel - ABM</title>
<link href="skins/<?=$abm_skin?>/estilos.css" rel="stylesheet" type="text/css" />
<?php
if($_GET["error_pendientes"] == 1) {
    mysql_query("UPDATE mailbox SET id_estado_envio = 1 WHERE id_newsletter = ".$_GET["id_newsletter"]." AND id_estado_envio = 3", $link);
    echo "
	<script language=\"javascript\">
		alert('Se actualizó el estado de los envíos erroneos a pendientes.');
	</script>
	";
}

?>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="titulo">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><h1>Estado del Newsletter: <?=$fila_news["asunto"]?></h1></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td align="right">N&ordm; de envios: <strong><?=$fila_numero_envios["nro"]?></strong></td>
  </tr>
  <tr>
    <td align="right"><table  border="0" align="left" cellpadding="0" cellspacing="3">
		<tr>
			<td width="95"><strong>Fecha de envio: </strong></td>
			<td width="200" align="left"><?=$fila_news["fecha_f"]?></td>
		</tr>
		<tr>
			<td><strong>De:</strong></td>
			<td align="left"><?=$fila_news["nombre_from"]?> &lt;<?=$fila_news["email_from"]?>&gt;</td>
		</tr>
		<tr>
			<td><strong>Responder a:</strong></td>
			<td align="left"><?=$fila_news["email_reply"]?></td>
		</tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="recuadro">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><table width="100%" border="0" cellspacing="5" cellpadding="0">
                    <tr>
                      <td>
					  <form id="form1" name="form1" method="get" action="newsletters_estado_envio_pop.php">
					  	<input type="hidden" name="id_newsletter" value="<?=$_GET["id_newsletter"]?>" />
					  <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="35" width="100">
							  <select name="filtro" onchange="document.form1.submit();">
		                        <option value="todos" <?=($_GET["filtro"] == "todos")?"selected":""?>>--todos--</option>
		                        <option value="1" <?=($_GET["filtro"] == 1)?"selected":""?>>Pendientes</option>
		                        <option value="2" <?=($_GET["filtro"] == 2)?"selected":""?>>Enviados</option>
		                        <option value="3" <?=($_GET["filtro"] == 3)?"selected":""?>>Error</option>
		                      </select>							  </td>
							<td><?=($nro_encontrados!=null)?"Encontrados: <strong>".$nro_encontrados."</strong>":""?></td>
                            <td align="right"><a href="newsletters_estado_envio_pop.php?id_newsletter=<?=$_GET["id_newsletter"]?>&error_pendientes=1" onclick="return confirm('Esta operación pasará los envios con error a pendientes.\nDesea continuar?')"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_erroneos_pendientes.gif" alt="Erroneos a Pendientes" border="0" /></a></td>
                          </tr>
                        </table>
					  </form></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td>
				<!--I tabla-->
				<table width="100%" border="0" cellspacing="0">
                    <tr>
                      <td class="lista_cbza">E-mail</td>
                      <td class="lista_cbza">Nombre</td>
                      <td class="lista_cbza">Fecha de creaci&oacute;n </td>
                      <td class="lista_cbza">fecha de envio </td>
                      <td width="50" align="right" class="lista_cbza">Estado</td>
                    </tr>
		<?php
		while($fila = mysql_fetch_array($result_consulta)) {
		    if($color == "lista_clara")
		        $color = "lista_oscura";
		    else
		        $color = "lista_clara";

		?>

	                <tr>
	                  <td class="<?=$color?>"><?=$fila["email"]?></td>
	                  <td class="<?=$color?>"><?=$fila["nombre_usuario"]?></td>
	                  <td class="<?=$color?>"><?=$fila["fecha_cf"]?></td>
	                  <td class="<?=$color?>"><?php
					    if($fila["fecha_ef"] != "00/00/0000 00:00:00") {
					        echo $fila["fecha_ef"];
					    }

					    ?></td>
	                  <td align="right" class="<?=$color?>"><table border="0" cellspacing="0" cellpadding="0">
	                      <tr>
			                <td width="25" align="left" class="<?=$color?>">
								<img src="imagenes/ico_estado_<?=$fila["id_estado_envio"]?>.gif" alt="<?=$fila["estado_envio_desc"]?>" alt="Pendiente" width="16" height="7"/>							</td>
	                    	<td class="<?=$color?>">
							<?
							    if(check_apertura($fila["id_newsletter"], $fila["id_usuario_news"])) {

							?>
									<img src="imagenes/ico_estado_abierto.gif" alt="Le&iacute;do" width="11" height="7"/>
						    <?
							    }
								else {

							?>
									<img src="imagenes/spacer.gif" width="11" height="7"/>
							<?
							    }

							?>							</td>
			              </tr>
	                  </table></td>
					</tr><?php
		}
		?>
			<?
				if(mysql_num_rows($result_consulta)==0){
			?>
					<tr>
						<td colspan="5" align="center">No hay registros</td>
					</tr>
			<?
				}
			?>
                </table>
				<!--F tabla-->				</td>
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
