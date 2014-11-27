<div id="header_seccion"> <img src="imagenes/img_header_novedades.png"alt="" style="padding-top:40px; padding-left:50px;" />
  <h1><span>Novedades</span></h1>
  <h2>Para estar bien informado</h2>
</div>
<div id="fondo_secciones">
  <?
  		$paginacion=5;
	  	$ls=(isset($_GET["ls"])?$_GET["ls"]:0);
	  	
		$consulta = "SELECT
							n.*,
							nc.descripcion AS categoria,
							DATE_FORMAT(FECHA,'%d/%m/%Y') AS fecha_f
						FROM
							news n,
							categorias nc
						WHERE
							n.activo = 1 AND
							n.id_categoria = nc.id_categoria
						";
			$consulta.=" AND n.id_categoria = 1 ";
	    //echo "<hr />".$consulta."<hr />";
		$resultado = mysql_query($consulta." ORDER BY n.fecha DESC, n.orden ASC LIMIT ".mysql_real_escape_string((int)$ls).", ".$paginacion,$link);
		echo mysql_error($link);
		while($fila_news = mysql_fetch_array($resultado)){
?>
  <div class="item_publicaciones">
    <div class="img"><a href="index.php?put=publicacion-amp&amp;id=<?=$fila_news["id_new"]?>"><img src="imagen.php?ruta=imagenes/news/fotos/<?=$fila_news["foto"]?>&amp;ancho=162&amp;alto=120&amp;mantener_ratio=1" width="162" height="120" alt="" /></a></div>
    <div class="addthis_toolbox addthis_default_style "> <a class="addthis_button_preferred_3" addthis:url="<?=$url_site?>/index.php?put=publicacion-amp&amp;id=<?=$fila_news["id_new"]?>"></a> <a class="addthis_button_preferred_1" addthis:url="<?=$url_site?>/index.php?put=publicacion-amp&amp;id=<?=$fila_news["id_new"]?>"></a> <a class="addthis_counter addthis_bubble_style" addthis:url="<?=$url_site?>/index.php?put=publicacion-amp&amp;id=<?=$fila_news["id_new"]?>"></a> </div>
    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f624c123181e3e7"></script>
    <div class="fecha">
      <?=$fila_news["fecha_f"]?>
    </div>
    <div class="tit">
      <h2><a href="index.php?put=publicacion-amp&amp;id=<?=$fila_news["id_new"]?>">
        <?=xhtmlOut($fila_news["titulo"])?>
        </a></h2>
    </div>
    <div class="txt">
      <?=xhtmlOut(recortar_texto($fila_news["bajada"],250))?>
    </div>
    <div class="btn"><a href="index.php?put=publicacion-amp&amp;id=<?=$fila_news["id_new"]?>"><strong>m&aacute;s info [+]</strong></a></div>
  </div>
  <?
		}
		if(mysql_num_rows($resultado) == 0){
?>
  <div id="sin_registros" style="padding:100px; text-align:center">No se encontraron registros.</div>
  <?
		}
	?>
  <?
	include("paginador.inc.php");
?>
</div>
