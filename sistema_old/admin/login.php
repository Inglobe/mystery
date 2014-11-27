<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Zephia Administration System</title>
<link href="css_library/login.css" rel="stylesheet" type="text/css" />
<link href="css_library/cuerpo.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="contenedor">
  <div id="cbza">
    <div id="fondo_sup_izq">
      <div id="sombra_izq"><span></span></div>
    </div>
    <div id="fondo_sup_der">
      <div id="sombra_der"><span></span></div>
    </div>
  </div>
  <div id="sombra_izq_repeat">
    <div id="sombra_der_repeat">
      <div id="cuerpo">
        <div id="linea_cbza">
          <div id="tit"><strong>Sistema de Administraci&oacute;n</strong></div>
		  <div id="logo">
          <img src="imagenes/logo_login.jpg" alt="" name="logo" /></div>
        </div>
        <div id="contenido">
          <form action="index.php" method="post" name="form_enviar">
            <input type="hidden" name="login" value="1"/>
            <div class="campo">
              <div class="label">
                <label for="user">Usuario:</label>
              </div>
              <input type="text" name="user" value="<?=$_POST["user"]?>" id="user" style="width:207px;" />
            </div>
            <div class="campo">
              <div class="label">
                <label for="pass">Contrase&ntilde;a:</label>
              </div>
              <input type="password" name="pass" value="" id="pass" style="width:207px;" />
            </div>
            <div id="btn_ok">
              <input name="submit" type="image" src="imagenes/btn_ok.jpg" value="Ok" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id="pie">
    <div id="fondo_inf_izq"><span></span></div>
    <div id="fondo_inf_der"><span></span></div>
  </div>
</div>
</body>
</html>
