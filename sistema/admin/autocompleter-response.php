<?
	require("procesos_globales.php");
?>

<ul>
<?
$consulta = "	SELECT
					p.*,
					c.nombre AS cliente
				FROM
					proyectos p,
					clientes c
				WHERE
					p.id_cliente = c.id_cliente AND
					(p.nombre LIKE '%".trim(str_replace(" ","%",$_POST["q"]))."%' OR
					 c.nombre LIKE '%".trim(str_replace(" ","%",$_POST["q"]))."%')
				ORDER BY
					p.id_proyecto DESC
			";
$result = mysql_query($consulta." LIMIT 8",$link);
while($fila = mysql_fetch_assoc($result)){
?>
  <li><div class="informal"><a href="index.php?put=proyecto&amp;id_proyecto=<?=$fila["id_proyecto"]?>&amp;id_cliente=<?=$fila["id_cliente"]?>"><?=xhtmlOut($fila["nombre"])?> &gt; <span class="texto_azul" style="font-weight:bold;"><?=xhtmlOut($fila["cliente"])?></span></a></div></li>
<?
}
?>
</ul>