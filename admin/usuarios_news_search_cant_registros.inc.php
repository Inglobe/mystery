<?
$consulta = "SELECT
					COUNT(*) AS nro
				FROM
					usuarios_news f
					, grupos_news gn
				WHERE
					f.id_grupo_news = gn.id_grupo_news";
if(isset($_GET["filtro_femail"]) && $_GET["filtro_femail"] != ""){
	$consulta .= " AND f.email LIKE '%".$_GET["filtro_femail"]."%'";
}
if(isset($_GET["filtro_fnombre"]) && $_GET["filtro_fnombre"] != ""){
	$consulta .= " AND f.nombre LIKE '%".$_GET["filtro_fnombre"]."%'";
}
if(isset($_GET["filtro_sid_grupo_news"]) && $_GET["filtro_sid_grupo_news"] != 0){
	$consulta .= " AND gn.id_grupo_news = '".$_GET["filtro_sid_grupo_news"]."'";
}

$result = mysql_query($consulta, $link);

echo mysql_error($link);

$fila = mysql_fetch_assoc($result);
?>
<div style="position: absolute; top: 125px; left: 310px;">
	Se encontraron <strong><?=$fila["nro"]?></strong> usuarios en la base de datos.
</div>