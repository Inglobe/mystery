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
<link href="skins/gris/estilos.css" rel="stylesheet" type="text/css" />
<link href="css_library/paginador.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de Administraci&oacute;n</title>
</head>
<body>
<div id="titulo">
  <h1><span>
    <?
  	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT descripcion_es FROM encuestas WHERE id_encuesta = ".$_GET["id"],$link));
  	echo $fila_tmp["descripcion_es"];
  ?>
    </span><span class="separador_tit">/</span><span class="gris"> Encuesta </span><span class="separador_tit">/</span><span class="gris_claro">Buscar</span> </h1>
</div>
<div id="btns_sup"><a href="preguntas_am.pop.php?id=<?=$_GET["id"]?>"><img src="skins/gris/es/btn_nuevo.gif" alt="" width="92" height="19" border="0" style="padding-top:10px; padding-bottom:10px;" /></a></div>
<div id="recuadro">
<div id="tabla_search">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th>Descripcion</th>
		<th width="30">Votos</th>
        <th width="100">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?
				$paginacion=10;
				$ls=(isset($_GET["ls"])?$_GET["ls"]:0);

				$consulta = "
					SELECT
						id_pregunta,
						descripcion_es,
						votos
					FROM 
						preguntas
					WHERE 
						preguntas.id_encuesta = ".$_GET["id"]."
					ORDER BY
						id_pregunta ASC
				";
						
				$result = mysql_query($consulta." LIMIT ".$ls.",".$paginacion,$link);
				
				echo mysql_error($link);
				while($fila = mysql_fetch_assoc($result)){
            		$estilo = ($estilo=="lista_clara"?"lista_oscura":"lista_clara");
	            	$link_borrar = "preguntas_procesar.pop.php?id_eliminar=".$fila["id_pregunta"]."&amp;accion=d&amp;id=".$_GET["id"];
            ?>
      <tr>
        <td class="<?=$estilo?>"><?=$fila["descripcion_es"]?></td>
		<td class="<?=$estilo?>" align="right"><?=$fila["votos"]?></td>
        <td class="<?=$estilo?>" align="right"><a href="<?=$link_borrar?>" onclick="return confirm('Esta seguro de borrar el registro?')"><img src="imagenes/ico_delete.gif" alt="" width="10" height="11" hspace="3" vspace="4" border="0" class="ico_imprimir" /></a></td>
      </tr>
      <?
				}
				if(mysql_num_rows($result)==0){
            	?>
      <tr>
        <td colspan="3" align="center"  class="<?=$estilo?>">No data.</td>
      </tr>
      <?
				}
            ?>
    </tbody>
  </table>
</div>
</div>
<?
			include("paginador.inc.php");
		?>
</body>
</html>
