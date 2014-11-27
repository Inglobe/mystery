<?
	require("procesos_globales.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	margin: 0px;
	padding: 10px;
}
-->

</style>
<link href="skins/gris/estilos.css" rel="stylesheet" type="text/css" />
<link href="css_library/paginador.css" rel="stylesheet" type="text/css" />
<link href="clases/ABMControls/datePicker/styles/fsdateselect.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js_library/prototype.js"></script>
<script type="text/javascript" src="clases/ABMControls/datePicker/scripts/fsdateselect.js"></script>
<script language="javascript" type="text/javascript">
<!--
function validar(f){
		if(f.descripcion.value == ""){
			alert("Descripcion es requerida.");
			f.descripcion.focus();
			return false;
		}
		return true;
	}
//-->
</script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de administraci&oacute;n</title>
<link href="css_library/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="titulo">
  <h1> <span>
    <?
	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT descripcion_es FROM encuestas WHERE id_encuesta = ".$_GET["id"],$link));
  	echo $fila_tmp["descripcion_es"];
  ?>
    </span><span class="separador_tit">/</span><span class="gris"> Encuesta </span><span class="separador_tit">/</span><span class="gris_claro">
    Agregar
    </span> </h1>
</div>
<div id="btns_sup">
  <a href="banners_reescrituras_search.pop.php?accion=s&amp;id=<?=$_GET["id"]?>"><img src="imagenes/btn_sup_search.jpg" alt="" border="0" /></a></div>
<div id="feed">
  <div id="contenedor_feed_add" style="display: <?=isset($_GET["feed"])?"":"none"?>">
    <div id="feed_add">
      <div id="texto_feed">
        <?
	          	  switch($_GET["feed"]){
	          	  	  case "a":
	          	  	  	  echo "Se ha agregado un registro";
	          	  	  break;
				  }
			  ?>
      </div>
      <img src="imagenes/ico_info.jpg" alt="" /> </div>
  </div>
</div>
<div id="filtros">
  <div class="cbza_bloque">
    <div class="cont_fondo_bloque_sup_izq">
      <div class="fondo_bloque_sup_izq"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_sup_der">
      <div class="fondo_bloque_sup_der"><span></span></div>
    </div>
  </div>
  <div class="borde_bloque_izq">
    <div class="borde_bloque_der">
      <div class="cuerpo_bloque">
        <form action="preguntas_procesar.pop.php?accion=a&amp;id=<?=$_GET["id"]?>" method="post" enctype="multipart/form-data" name="form_am" id="form_am" onsubmit="return validar(this)">
		  <div class="control">
            <div class="label_add">
              <label for="nombre">Descripci&oacute;n</label>
            </div>
			<input type="text" name="descripcion_es" id="descripcion_es" value="" size="50" />
          </div>
          <div id="btns_ok_cancel" style="padding-left: 154px; padding-top: 5px"><a href="preguntas_search.pop.php?id=<?=$_GET["id"]?>"><img src="imagenes/btn_cancelar.gif" alt="" border="0" /></a>
            <input type="image" src="imagenes/btn_ok.gif" alt=""  />
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="pie_bloque">
    <div class="cont_fondo_bloque_inf_izq">
      <div class="fondo_bloque_inf_izq"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_inf_der">
      <div class="fondo_bloque_inf_der"><span></span></div>
    </div>
  </div>
</div>
</body>
</html>
