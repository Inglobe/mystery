<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Panel de control</title>
<link href="skins/<?=$abm_skin?>/estilos.css" rel="stylesheet" type="text/css" />
<link href="skins/<?=$abm_skin?>/cuerpo.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="idioma/<?=$idioma?>/reloj.js"></script>
<script language="javascript" src="funciones.js" type="text/javascript"></script>
<script src="../includes/funciones_generales.js" type="text/javascript"></script>
<script src="includes/ckeditor/ckeditor.js" type="text/javascript"></script>
</head>
<body onload="JSClock()">
<div id="contenedor">
  <div id="contenedor_msg">
    <div id="msgCargando" style="display: none"><img src="skins/<?=$abm_skin?>/imagenes/cargando.gif" alt="loading" /></div>
    <div id="ayuda"><a href="#"><img src="skins/gris/es/btn_ayuda.gif" alt="" width="47" height="15" border="0" onclick="MM_openBrWindow('ayuda.html','','scrollbars=yes,width=750,height=550')" /></a></div>
  </div>
  <div id="logo"><img src="imagenes/logo.png" alt="Logo"/></div>
  <div id="website">
    <h4>Administrador de contenido</h4>
  </div>
  <div id="fecha"><script language="javascript" src="idioma/<?=$idioma?>/fecha.js"></script>- <span id="relojito"></span></div>
  <div id="izq">
    <div class="bloque_botones">
      <div class="menu_cbza"><a onclick="desplegar_menu('menu_sistema','flecha_sistema','<?=$abm_skin?>');return false;" href="#">Sitio</a><img src="skins/<?=$abm_skin?>/imagenes/flecha_abierta_boton.gif" alt="" id="flecha_sistema" /></div>
      <div class="botones" id="menu_sistema">
        <ul>
          <li><a href="index.php?put=news_search&cambiar=1">Publicaciones</a></li>
        </ul>
      </div>
    </div>
    <div class="bloque_botones">
      <div class="menu_cbza"><a onclick="desplegar_menu('menu_options','flecha_options','<?=$abm_skin?>');return false;" href="#">Opciones</a><img src="skins/<?=$abm_skin?>/imagenes/flecha_abierta_boton.gif" alt="" id="flecha_options" /></div>
      <div class="botones" id="menu_options">
        <ul>
          <li><a href="index.php?put=accesos&cambiar=1">Accesos</a></li>
          <li><a href="index.php?put=parametros&cambiar=1">Parametros</a></li>
          <li><a href="index.php?put=backup_menu&cambiar=1">Backup</a></li>
        </ul>
      </div>
    </div>
    <div class="bloque_botones">
      <div class="menu_cbza"><a onclick="desplegar_menu('menu_newsletters','flecha_newsletters','<?=$abm_skin?>');return false;" href="#">Newsletters</a><img src="skins/<?=$abm_skin?>/imagenes/flecha_abierta_boton.gif" alt="" id="flecha_newsletters" /></div>
      <div class="botones" id="menu_newsletters">
        <ul>
          <li><a href="index.php?put=newsletters_crear&cambiar=1">Crear</a></li>
          <li><a href="index.php?put=newsletters_enviados&cambiar=1">Bandeja de salida</a></li>
          <li><a href="index.php?put=usuarios_news_search&cambiar=1">Suscriptos</a></li>
          <li><a href="index.php?put=grupos_news_search&cambiar=1">Grupos de suscriptos</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div id="der">
    <?php include($put.".php"); ?>
  </div>
  <div id="pie">Panel de control v3.0</div>
  <div id="contenedor_logo_zephia">
    <div id="logo_zephia"><a href="http://www.zephia.com.ar" target="_blank"><img src="skins/<?=$abm_skin?>/imagenes/logo_zephia.gif" alt="by Zephia" border="0" /></a></div>
  </div>
</div>
</body>
</html>