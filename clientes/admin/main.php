<?
	if(!defined('PROCESOS_GLOBALES')){
		die('No se encontraron los archivos de configuración.');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de Administraci&oacute;n</title>
<link href="css_library/purple_theme.css" rel="stylesheet" type="text/css" />
<link href="css_library/styles.css" rel="stylesheet" type="text/css" />
<link href="css_library/body.css" rel="stylesheet" type="text/css" />
<link href="css_library/paginacion.css" rel="stylesheet" type="text/css" />
<script src="includes/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<script src="includes/funciones_generales.js" type="text/javascript"></script>

<!--Fancy Box-->
<link rel="stylesheet" type="text/css" href="js_library/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="js_library/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<script src="js_library/fancybox/jquery.mousewheel-3.0.4.pack.js" type="text/javascript"></script>
<script src="js_library/fancybox/fancy_call.js" type="text/javascript"></script>

<!--datepicker-->
<script type="text/javascript" language="javascript" src="js_library/jq_datepicker/jquery.ui.datepicker.js"></script>
<link href="js_library/jq_datepicker/themes/smoothness/styles.css" rel="stylesheet" type="text/css" />

<!--jqtransform-->
<script type="text/javascript" language="javascript" src="js_library/jq_transformplugin/jquery.jqtransform.js"></script>
<link href="js_library/jq_transformplugin/jqtransform.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]><link href="js_library/jq_transformplugin/fix_ie7.css" rel="stylesheet" type="text/css" /><![endif]-->
<script language="javascript">
	$(function(){
		$('form').jqTransform({imgPath:'js_library/jqtransformplugin/img/'});
	});
</script>

<!--jq multipleuploads-->
<script src="js_library/jq_multipleuploads/jquery.flash.min.js" type="text/javascript"></script>
<script src="js_library/jq_multipleuploads/agile-uploader-3.0.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="js_library/jq_multipleuploads/agile-uploader.css" />

<!--jq acordion-->
<script type="text/javascript" language="javascript" src="js_library/jq_accordion.js"></script>


<link rel="shortcut icon" href="favicon.ico" >
</head>
<? 
$put = $data->getPut(true);
?>
<body <? if ($put == "home.php") {?>onload="Reloj()"<? } ?>>
<div id="content_bg">
  <div id="header_line">
    <div id="logo_bg">
      <div class="template_width">
        <div id="logo"><a href="index.php?put=home"><img src="images/logo-trans.png" alt="" /></a></div>
        <div id="tit_sistem">INFORME PARA CLIENTES</div>
        <? 
          	include("box_user.inc.php");
        ?>
      </div>
    </div>
    <div id="version_bg" class="gradient_theme">
      <div class="template_width">
        <div id="version">Version 1.0</div>
      </div>
    </div>
	<?
	if(!$preview){
	?>
    <div id="menu_bg">
      <div class="template_width">
        <div id="menu_left">
          <ul>
            <li><a href="index.php?put=home">Inicio</a></li>
            <li><a href="index.php?put=auditorias_search">Auditorias</a></li>
            <li><a href="index.php?put=reporte_tab_variables_generales">Reportes</a></li>
            <li><a href="index.php?put=support">Soporte</a></li>
            <li><a href="index.php?put=help">Ayuda</a></li>
          </ul>
        </div>
        <div id="menu_right">
          <ul>
            <li><a href="index.php?logout=1">Salir</a></li>
          </ul>
        </div>
      </div>
    </div>
	<?
	}
	?>
  </div>
  <div class="template_width">
    <div id="content">
      <?
		  	require_once($put);
		  ?>
    </div>
  </div>
</div>
<div id="footer"><span></span></div>
<div id="footer_data">
  <div class="template_width"> 
    <!--    <ul>
      <li><a href="#">Gesti&oacute;n de Inventario</a></li>
      <li><a href="#">Gesti&oacute;n de Contacto</a></li>
      <li><a href="#">Gesti&oacute;n de Showroom</a></li>
      <li><a href="#">Promoci&oacute;n Online </a></li>
    </ul>-->
	<?
	if(!$preview){
	?>
    <ul id="submenu">
      <li><a href="index.php?put=home">Inicio</a></li>
      <li><a href="index.php?put=auditorias_search">Auditorias</a></li>
      <li><a href="index.php?put=reporte_tab_variables_generales">Reportes</a></li>
      <li><a href="index.php?put=support">Soporte</a></li>
      <li><a href="index.php?put=help">Ayuda</a></li>
    </ul>
	<?
	}
	?>
  </div>
</div>
</body>
</html>
