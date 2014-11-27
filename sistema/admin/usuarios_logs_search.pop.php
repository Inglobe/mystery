<?
	require("procesos_globales.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	margin: 0px;
	padding: 10px;
}

-->
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de Administraci&oacute;n</title>
<link href="css_library/estilos.css" rel="stylesheet" type="text/css" />
<link href="css_library/paginador.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="titulo">
  <h1><span> <?
  	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT nombre FROM usuarios WHERE id_usuario = ".$_GET["id"],$link));
  	echo $fila_tmp["nombre"];
  ?> </span><span class="separador_tit">/</span><span class="gris"> Historial </span><span class="separador_tit">/</span><span class="gris_claro">Buscar</span> </h1>
</div>
<div id="lista">
  <div class="cbza_bloque_lista">
    <div class="cont_fondo_bloque_sup_izq">
      <div class="fondo_bloque_sup_izq_lista"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_sup_der">
      <div class="fondo_bloque_sup_der_lista"><span></span></div>
    </div>
  </div>
  <div class="borde_bloque_izq">
    <div class="borde_bloque_der">
      <div class="cuerpo_bloque_lista">
        <div id="tabla">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
			  	<th>Fecha</th>
				<th>Hora</th>
				<th>IP</th>
              </tr>
            </thead>
            <tbody>
            <?
				$paginacion=300;
				$ls=(isset($_GET["ls"])?$_GET["ls"]:0);

				$consulta = "SELECT
								ll.*
								, DATE_FORMAT(ll.fechahora,'%d/%m/%Y') AS fecha_f
								, DATE_FORMAT(ll.fechahora,'%H:%i:%s') AS hora_f
							FROM 
								logs_loguins ll
							WHERE
								ll.id_usuario = ".$_GET["id"]."
							ORDER BY
								fechahora DESC
							";
				$result = mysql_query($consulta." LIMIT ".$ls.",".$paginacion,$link);
				echo mysql_error($link);
				while($fila = mysql_fetch_assoc($result)){
            		$estilo = ($estilo=="lista_clara"?"lista_oscura":"lista_clara");
            ?>
              <tr class="<?=$estilo?>">
			  	<td valign="top"><?=$fila["fecha_f"]?></td>
				<td valign="top"><?=$fila["hora_f"]?></td>
			  	<td valign="top"><?=$fila["ip"]?></td>
              </tr>
            <?
				}
				if(mysql_num_rows($result)==0){
            	?>
              <tr class="<?=$estilo?>">
                <td colspan="3" align="center">No data.</td>
              </tr>
            	<?
				}
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="pie_bloque_lista">
    <div class="cont_fondo_bloque_inf_izq">
      <div class="fondo_bloque_inf_izq_lista"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_inf_der">
      <div class="fondo_bloque_inf_der_lista"><span></span></div>
    </div>
  </div>
</div>
<div class="bloque_sin_degrade">
  <div class="cbza_bloque_sin_degrade">
    <div class="cont_fondo_bloque_sup_izq">
      <div class="fondo_bloque_sup_izq_sin_degrade"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_sup_der">
      <div class="fondo_bloque_sup_der_sin_degrade"><span></span></div>
    </div>
  </div>
  <div class="borde_bloque_izq">
    <div class="borde_bloque_der">
      <div class="cuerpo_bloque_sin_degrade">
        <?
			include("paginador.inc.php");
		?>
      </div>
    </div>
  </div>
  <div class="pie_bloque">
    <div class="cont_fondo_bloque_inf_izq">
      <div class="fondo_bloque_inf_izq"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_inf_der">
      <div class="fondo_bloque_inf_der"><span></span></div>
    </div>
  </div>
</div>
</body>
</html>
