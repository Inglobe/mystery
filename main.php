<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?= $webtitle?>
</title>
<link href="css_library/estilos.css" rel="stylesheet" type="text/css" />
<link href="css_library/paginador.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<script src="funciones_generales.js" type="text/javascript"></script>

<!--Fancy Box-->
<link rel="stylesheet" type="text/css" href="js_library/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="js_library/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<script src="js_library/fancybox/jquery.mousewheel-3.0.4.pack.js" type="text/javascript"></script>
<script src="js_library/fancybox/fancy_call.js" type="text/javascript"></script>

<!--Nivo Slider-->
<script src="js_library/nivoslider/jquery.nivo.slider.pack.js" type="text/javascript"></script>
<link href="js_library/nivoslider/nivo-slider.css" rel="stylesheet" type="text/css" />
<link href="js_library/nivoslider/themes/default/default.css" rel="stylesheet" type="text/css" />

<!--Accordion-->
<link rel="stylesheet" type="text/css" href="js_library/accordion/style.css" media="screen" />
<script src="js_library/accordion/jquery.accordionza.pack.js" type="text/javascript"></script>
<script src="js_library/accordion/accordion_call.js" type="text/javascript"></script>
<? 
if ($put == "publicacion-amp" ) {
	$consulta = "SELECT *, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_f FROM news WHERE id_new = ".$_GET["id"];
	$result = mysql_query($consulta,$link);
	echo mysql_error($link);
	$fila = mysql_fetch_assoc($result);
?>
<meta property="og:site_name" content="<?= $webtitle?>" />
<meta content="article" property="og:type">
<meta content="zephiaestudio" property="fb:admins">
<meta property="og:url" content="<?=$url_site?>/index.php?put=publicacion-amp&amp;id=<?=$_GET["id"]?>" />
<meta property="og:title" content="<?=xhtmlOut($fila["titulo"])?>" />
<meta property="og:description" content="<?=xhtmlOut($fila["bajada"])?>" />
<meta property="og:image" content="<?=$url_site?>/imagenes/news/fotos/<?=$fila["foto"]?>" />
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'es-419'}
</script>
<?
}
?>
<link rel="shortcut icon" href="favicon.ico" >
</head>

<body id="<? 
if( $put == "home"){
?>background_home<?
} else {
?>background_secc<?
}
?>" >
<div id="fondo_top">
  <div id="fondo_botonera">
    <div id="contenedor">
      <div id="top"> <a href="index.php?put=home"><img src="imagenes/logo-trans.png" alt="" name="logo" width="242" height="75" id="logo" /></a> <img src="imagenes/btns_top.jpg" alt="" width="378" height="63" border="0" usemap="#btns_topMap" id="btns_top" />
        <map name="btns_topMap" id="btns_topMap">
          <area shape="rect" coords="298,11,330,41" href="#" />
          <area shape="rect" coords="272,12,300,39" href="#" />
          <area shape="rect" coords="167,9,270,45" href="sistema" target="_blank" />
          <area shape="rect" coords="65,10,166,44" href="clientes" target="_blank" />
        </map>
        <a href="index.php?put=contacto&amp;prueba=1"><img src="imagenes/solicite-auditoria-trans.png" alt="" name="solicite_auditoria" width="393" height="71" id="solicite_auditoria" /></a>
        <div id="botonera">
          <ul>
            <li><a href="index.php?put=home" <? if($put=="home") {?>class="selected"<? } ?>>Home</a></li>
            <li><a href="index.php?put=nosotros" <? if($put=="nosotros") {?>class="selected"<? } ?>>Nosotros</a></li>
            <li><a href="index.php?put=mystery-shopping" <? if($put=="mystery-shopping"||$put=="mystery-shopping-que-hace"||$put=="mystery-shopping-beneficios"||$put=="mystery-shopping-pasos"||$put=="mystery-shopping-por-que") {?>class="selected"<? } ?>>Mystery Shopping</a></li>
            <li><a href="index.php?put=servicios" <? if($put=="servicios") {?>class="selected"<? } ?>>Servicios</a></li>
            <li><a href="index.php?put=clientes" <? if($put=="clientes") {?>class="selected"<? } ?>>Clientes</a></li>
            <li><a href="index.php?put=publicaciones" <? if($put=="publicaciones" || $put=="publicacion-amp") {?>class="selected"<? } ?>>Novedades</a></li>
            <li><a href="index.php?put=contacto" <? if($put=="contacto") {?>class="selected"<? } ?>>Contacto</a></li>
          </ul>
        </div>
      </div>
      <?
				if ($_GET["put"]=="home" || empty($_GET["put"])) {
					include('box-slide-ppal.inc.php');
				}
			  ?>
      <div id="contenido">
        <?
		require_once($put.".php");
	?>
      </div>
    </div>
  </div>
</div>
<div id="pie">
  <div id="pie_inside"> <a href="clientes" target="_blank"><img src="imagenes/acceso_clientes_pie.png" width="213" height="69" alt="" id="acceso_clientes"/></a> <a href="sistema" target="_blank"><img src="imagenes/acceso_shopper_pie.png" alt="" name="acceso_shopper" width="223" height="69" id="acceso_shopper" /></a> <a href="index.php?put=form-shopper"><img src="imagenes/btn_queres_ser_pie.png" width="144" height="57" alt=""  id="acceso_queres_ser"/></a>
    <div id="copyright">Av. Colon 610 - Piso 15 - Centro, Cordoba, Arg. <br />
      Tel: 0351-153284036 <a href="mailto:Info@mysterysur.com.ar">Info@mysterysur.com.ar</a><br />
    </div>
    <div id="botonera_pie">
      <ul>
        <li><a href="index.php?put=home">Home</a></li>
        <li><a href="index.php?put=mystery-shopping">Mystery Shopping</a></li>
        <li><a href="index.php?put=servicios">Servicios</a></li>
        <li><a href="index.php?put=clientes">Clientes</a></li>
        <li><a href="index.php?put=contacto">Contacto</a></li>
      </ul>
    </div>
    <a href="index.php?put=home"><img src="imagenes/logo_pie.png" width="124" height="41" alt="" id="logo_pie" /></a>
    <div id="box_newsletters"><strong>Suscripci&oacute;n a newsletter</strong>
      <form action="index.php?put=suscripcion-feed" class="validador_form" name="form_suscribe" method="post" id="form_suscribe" enctype="application/x-www-form-urlencoded" onsubmit="return checkForm('form_suscribe')">
        <div class="campo">Nombre y Apellido<br />
          <input type="hidden" name="campo_nombre" value="Nombre"/>
          <input name="nombre" id="nombre" type="text" style="width:80px;" class="required"/>
        </div>
        <div class="campo">E-mail<br />
          <input type="hidden" name="campo_email" value="E-mail"/>
          <input name="email" id="email" type="text" style="width:80px;" class="required email"/>
        </div>
        <input name="" type="image" src="imagenes/btn_enviar_pie.png" id="btn" />
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31157180-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
