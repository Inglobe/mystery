<?
	require("procesos_globales.php");
?>
<ul>
	<?
		$sql = "
			SELECT
				publicaciones.id_publicacion AS id_publicacion,
				categorias.descripcion AS categoria,
				publicaciones.titulo AS publicacion
			FROM
				publicaciones INNER JOIN categorias ON (
					publicaciones.id_categoria = categorias.id_categoria
				)
			WHERE
				publicaciones.titulo LIKE '%".trim(str_replace(" ","%",$_POST["q"]))."%'
			ORDER BY
				categorias.descripcion ASC,
				publicaciones.fecha ASC
		";
		
		$result = mysql_query($sql." LIMIT 8",$link);
		
		while($fila = mysql_fetch_assoc($result)){
	?>
	<li id="<?=xhtmlOut($fila["id_publicacion"])?>">
		<?=xhtmlOut($fila["categoria"])?> &gt; <?=xhtmlOut($fila["publicacion"])?>
	</li>
	<?
		}
	?>
</ul>