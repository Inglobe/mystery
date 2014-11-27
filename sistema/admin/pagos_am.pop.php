<?
	require("procesos_globales.php");
	
	if($_GET["accion"]=="m"){
		$consulta = "SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_f FROM pagos WHERE id_pago = ".$_GET["id_modificar"];
		$result = mysql_query($consulta,$link);
		echo mysql_error($link);
		$fila_load = mysql_fetch_assoc($result);
	}
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
<link href="clases/ABMControls/datePicker/styles/fsdateselect.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js_library/prototype.js"></script>
<script type="text/javascript" src="clases/ABMControls/datePicker/scripts/fsdateselect.js"></script>
<script language="javascript" type="text/javascript">
<!--
function validar(f){
		if(f.monto.value == ""){
			alert("Monto es requerido.");
			f.monto.focus();
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
	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT nombre FROM proveedores WHERE id_proveedor = ".$_GET["id"],$link));
  	echo $fila_tmp["nombre"];
  ?>
    </span><span class="separador_tit">/</span><span class="gris"> Agregar </span><span class="separador_tit">/</span><span class="gris_claro">
    <?
  	if($_GET["accion"] == "m"){
		?>
    Modificar
    <?
	}
	else{
		?>
    Agregar
    <?
	}
  ?>
    </span> </h1>
</div>
<div id="btns_sup">
  <?
				if($_GET["accion"]=="m"){
				?>
  <a href="pagos_am.pop.php?accion=a&amp;id=<?=$_GET["id"]?>"><img src="imagenes/btn_sup_add.jpg" alt="" border="0" /></a>
  <?
				}
				?>
  <a href="pagos_search.pop.php?accion=s&amp;id=<?=$_GET["id"]?>"><img src="imagenes/btn_sup_search.jpg" alt="" border="0" /></a></div>
<div id="feed">
  <div id="contenedor_feed_add" style="display: <?=isset($_GET["feed"])?"":"none"?>">
    <div id="feed_add">
      <div id="texto_feed">
        <?
	          	  switch($_GET["feed"]){
	          	  	  case "a":
	          	  	  	  echo "Se ha agregado un pago";
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
        <form action="pagos_procesar.pop.php?accion=<?=$_GET["accion"]?>&amp;id=<?=$_GET["id"]?><?=($_GET["accion"]=="m"?"&amp;id_modificar=".$_GET["id_modificar"]:"")?>" method="post" enctype="multipart/form-data" name="form_am" id="form_am" onsubmit="return validar(this)">
		  <div class="control">
            <div class="label_add">
              <label for="fecha">Date from:</label>
            </div>
            <script type="text/javascript">
			// <![CDATA[
			<?
				if($_GET["accion"]=="m"){
					$fecha_am = $fila_load["fecha_f"];
				}else{
					$fecha_am = date('d/m/Y',time());
				}
			?>
			  FSfncWriteFieldHTML("form_am","fecha","<?=$fecha_am?>","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
			// ]]>
		  	</script>
          </div>
          <div class="control">
            <div class="label_add">
              <label for="monto">Monto</label>
            </div>
            <input name="monto" id="monto" type="text" value="<?=$fila_load["monto"]?>" size="25" />
          </div>
		  <div class="control">
            <div class="label_add">
              <label for="id_tipo_pago">Tipo de pago</label>
            </div>
            <select name="id_tipo_pago">
				<?
					$result_tmp = mysql_query("SELECT * FROM tipos_pago ORDER BY descripcion ASC",$link);
					while($fila_tmp = mysql_fetch_assoc($result_tmp)){
				?>
					<option value="<?=$fila_tmp["id_tipo_pago"]?>" <?=($fila_tmp["id_tipo_pago"]==$fila_load["id_tipo_pago"]?"selected=\"selected\"":"")?>><?=$fila_tmp["descripcion"]?></option>
				<?
					}
				?>
			</select>
          </div>
		  
          <div id="btns_ok_cancel"><a href="pagos_search.pop.php?id=<?=$_GET["id"]?>"><img src="imagenes/btn_cancel.jpg" alt="" border="0" /></a>
            <input type="image" src="imagenes/btn_ok.jpg" alt=""  />
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
