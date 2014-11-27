<?
	if(!defined('PROCESOS_GLOBALES')){
		die('No se encontraron los archivos de configuración.');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema inmobiliario</title>
<link href="css_library/green_theme.css" rel="stylesheet" type="text/css" />
<link href="css_library/styles.css" rel="stylesheet" type="text/css" />
<link href="css_library/body.css" rel="stylesheet" type="text/css" />
<link href="css_library/paginacion.css" rel="stylesheet" type="text/css" />
<script src="includes/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>

<!--datepicker-->
<script type="text/javascript" language="javascript" src="js_library/jq_datepicker/jquery.ui.datepicker.js"></script>
<link href="js_library/jq_datepicker/themes/smoothness/styles.css" rel="stylesheet" type="text/css" />

<!--jqtransform-->
<script type="text/javascript" language="javascript" src="js_library/jq_transformplugin/jquery.jqtransform.js"></script>
<link href="js_library/jq_transformplugin/jqtransform.css" rel="stylesheet" type="text/css" />
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

<script type="text/javascript" language="javascript" src="js_library/jquery.flot.js"></script>
<link rel="shortcut icon" href="favicon.ico" >
</head>
<body>
<div id="body_bg">
  <div id="container">
    <div id="header_line">
      <div id="logo_bg">
        <div id="logo"><a href="index.php?put=home"><img src="images/logo-trans.png" alt="" /></a></div>
        <div id="tit_sistem">Sistema de ventas</div>
        <? 
          	include("box_user.inc.php");
        ?>
      </div>
      <div id="version_bg" class="gradient_theme">
        <div id="version">Version 0.6</div>
      </div>
      <div id="menu_bg">
        <div id="menu_right">
          <ul>
            <li><a href="index.php?logout=1">Salir</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div id="content">
      <div id="menu_content">
        <div class="tit_menu gradient_theme">
          <div class="ico_tit_menu"><img src="images/ico_menu_01-trans.png" width="50" height="50" alt="" /></div>
          <h3>Sistema</h3>
        </div>
        <ul>
          <li><a href="index.php?put=home">Inicio</a></li>
          <li><a href="index.php?put=properties_search">Inmuebles</a></li>
          <li><a href="index.php?put=properties_types_search">Tipos de inmueble</a></li>
          <li><a href="index.php?put=features_search">Caracter&iacute;sticas</a></li>
          <li><a href="index.php?put=features_types_search">Tipos de caracter&iacute;sticas</a></li>
          <li><a href="index.php?put=statistics">Estad&iacute;sticas</a></li>
        </ul>
       <?/* <div class="tit_menu gradient_theme">
          <div class="ico_tit_menu"><img src="images/ico_menu_02-trans.png" width="50" height="50" alt="" /></div>
          <h3>Sistema</h3>
        </div>
        <ul>
          <li><a class="accordionButton"><strong>Propiedades lista</strong></a>
            <ul class="accordionContent">
              <li><a href="#">Lista de Inmuebles</a></li>
              <li><a href="#">Lista de Inmuebles</a></li>
            </ul>
          </li>
          <li><a class="accordionButton"><strong>Emprendimientos</strong></a>
            <ul class="accordionContent">
              <li><a href="#">Lista de Inmuebles</a></li>
              <li><a href="#">Lista de Inmuebles</a></li>
            </ul>
          </li>
          <li><a class="accordionButton"><strong>Tipos de operaciones</strong></a>
            <ul class="accordionContent">
              <li><a href="#">Lista de Inmuebles</a></li>
              <li><a href="#">Lista de Inmuebles</a></li>
            </ul>
          </li>
        </ul> */?>
        <div class="tit_menu gradient_theme">
          <div class="ico_tit_menu"><img src="images/ico_menu_04-trans.png" width="50" height="50" alt="" /></div>
          <h3>Contactos</h3>
        </div>
        <ul>
          <li><a href="index.php?put=suscribers_search">Contactos</a></li>
          <li><a href="index.php?put=groups_search">Grupos de contactos</a></li>
        </ul>
      </div>
      <?
		  	require_once($data->getPut(true));
		  ?>
    </div>
    <div id="footer">
      <div id="footer_data">Inmosale &copy; 2011 All Rights Reserved - <a href="#">Terminos y condiciones</a><img src="images/logo_footer-trans.png" width="88" height="24" alt="" id="logo_footer" /></div>
    </div>
  </div>
</div>
</body>
</html>
