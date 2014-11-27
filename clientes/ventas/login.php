<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema inmobiliario</title>
<link href="css_library/body.css" rel="stylesheet" type="text/css" />
<link href="css_library/green_theme.css" rel="stylesheet" type="text/css" />
<link href="css_library/styles.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico" >
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<!--jqtransform-->
<script type="text/javascript" language="javascript" src="js_library/jq_transformplugin/jquery.jqtransform.js"></script>
<link href="js_library/jq_transformplugin/jqtransform.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	$(function(){
		$('form').jqTransform({imgPath:'js_library/jqtransformplugin/img/'});
	});
</script>
</head>
<body>
<div id="login_box">
  <div id="container">
    <div id="top_login">
      <div id="tit"><strong>Sistema de ventas</strong></div>
      <div id="logo"> <img src="images/logo_login.jpg" alt="" name="logo" /></div>
    </div>
    <div id="content_login">
      <form action="index.php" method="post" name="form_enviar">
        <input type="hidden" name="login" value="1"/>
        <div class="input" style="height:auto;">
          <label for="user">Usuario:</label>
          <input type="text" name="user" id="user" size="23" value="<?=$data->post('user','',false)?>" />
        </div>
        <div class="input" style="height:auto;">
          <label for="pass">Contrase&ntilde;a:</label>
          <input type="password" name="pass" value="" size="23" id="pass" />
        </div>
        <div id="btn_login">
          <input name="Submit" type="submit" value="Ok" class="gradient_theme" />
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
