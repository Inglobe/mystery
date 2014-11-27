<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Importar Subscriptores</title>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	margin: 0px;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 0px;
	padding-left: 10px;
}
-->
</style>
<link href="css_library/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="filters">
  <div class="block_top">
    <div class="cont_bg_block_top_left">
      <div class="bg_block_top_left"><span></span></div>
    </div>
    <div class="cont_bg_block_top_right">
      <div class="bg_block_top_right"><span></span></div>
    </div>
  </div>
  <div class="border_block_left">
    <div class="border_block_right">
      <div class="block_body">
        <form action="index.php" method="get" name="form_suscribers" id="form_suscribers">
          <fieldset id="campos">
            <legend style="display:none;">filtros</legend>
            <input type="hidden" value="suscribers_search" name="put">
            <input type="hidden" value="1" name="abm_filtrar">
            <div class="input">
              <input name="" type="file" />
            </div>
            <div class="input">
              <label for="id_filtro_nombre">Grupo:</label>
              <select name="select" id="select">
                <option>-- Seleccionar --</option>
              </select>
            </div>
            <div class="input">
              <label for="id_filtro_nombre">Delimitador de campo:</label>
              <select name="select" id="select">
                <option>; (punto y coma)</option>
              </select>
            </div>
          </fieldset>
          <div id="cont_btns_ok_cancel">
            <div id="btns_ok_cancel">
              <div class="button gradient_theme"><a href="#">Cancelar</a></div>
              <input type="submit" value="Importar" name="Submit">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="block_footer">
    <div class="cont_bg_block_footer_left">
      <div class="bg_block_footer_left"><span></span></div>
    </div>
    <div class="cont_bg_block_footer_right">
      <div class="bg_block_footer_right"><span></span></div>
    </div>
  </div>
</div>
</body>
</html>
