<?
		$consulta = "SELECT n.*, nc.descripcion AS categoria, DATE_FORMAT(FECHA,'%d/%m/%Y') AS fecha_f
		FROM news n, categorias nc
		WHERE n.activo = 1
		AND n.id_categoria = nc.id_categoria
		AND n.id_new = ".mysql_real_escape_string((int)$_GET["id"]);
		$resultado = mysql_query($consulta,$link);
		echo mysql_error($link);
		$fila_news = mysql_fetch_array($resultado);
?>
<div id="header_seccion"> <img src="imagenes/img_header_novedades.png"alt="" style="padding-top:40px; padding-left:50px;" />
  <h1><span>Novedades</span></h1>
  <h2>Para estar bien informado</h2>
</div>
<div id="fondo_secciones">
  <div class="item_publicacion">
      <div class="tit">
        <h2>
          <?=xhtmlOut($fila_news["titulo"])?>
        </h2>
      </div>
      <div class="fecha">
        <?=$fila_news["fecha_f"]?>
      </div>
      <div class="contenido_publicacion">
        <div class="img">
          <a href="imagenes/news/fotos/<?=$fila_news["foto"]?>" class="fancybox"><img src="imagen.php?ruta=imagenes/news/fotos/<?=$fila_news["foto"]?>&amp;ancho=244&amp;alto=172&amp;mantener_ratio=1" width="244" height="172" alt="" /></a>
          <?php /*?><div id="galeria_publicacion">
            <?
	  	$result_fotos = mysql_query("SELECT * FROM fotos WHERE id_relacion = ".$fila_news["id_new"]." AND abm LIKE 'news'",$link);
		echo mysql_error($link);
		while($fila_foto = mysql_fetch_assoc($result_fotos)){
	  ?>
            <div class="img_galeria"><a href="imagenes/galeria/fotos/<?=rawurlencode($fila_foto["foto"])?>" rel="grupo_fotos" target="_blank" title="<?=$fila_foto["descripcion"]?>"><img src="imagen.php?ruta=imagenes/galeria/fotos/<?=rawurlencode($fila_foto["foto"])?>&amp;ancho=74&amp;alto=50&mantener_ratio=1" alt="" width="74" height="50" border="0"/></a></div>
            <?
	  	}
	  ?>
          </div><?php */?>
        </div>
        <div class="bajada">
          <?=xhtmlOut($fila_news["bajada"])?>
        </div>
        <div class="txt">
          <?=$fila_news["descripcion"]?>
        </div>
        <div id="contenedor_redes">
          <div id="twitter_btn"> 
            <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script> 
            <a href="http://twitter.com/share" class="twitter-share-button">Tweet</a> </div>
          <div id="fb_like_btn"> 
            <script src="http://connect.facebook.net/es_ES/all.js#xfbml=1"></script>
            <fb:like layout="button_count" show_faces="false" width="450"></fb:like>
          </div>
          <div id="google_btn">
            <g:plusone size="medium"></g:plusone>
          </div>
        </div>
      </div>
      <div class="btn"><a href="javascript:history.back();"><strong>volver</strong></a></div>
    </div>
</div>
