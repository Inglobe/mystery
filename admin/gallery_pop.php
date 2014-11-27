<?
	require "procesos_globales.php";

	$consulta = "SELECT * FROM fotos WHERE id_relacion = ".$_GET["id_relacion"]." AND abm = '".$_GET["nombre_abm"]."'";

	if(isset($_GET["direccion"])){
		ordenarRegistro($_GET["id"],"id_foto","fotos","orden",$_GET["direccion"],$consulta);
	}

	/*$fila_tmp=mysql_fetch_assoc(mysql_query("SELECT ".$campo_desc." FROM galerias WHERE id_relacion = ".$id_relacion,$link));
	echo mysql_error($link);*/

	$consulta .= " ORDER BY orden ASC";

	$result = mysql_query($consulta,$link);
	echo mysql_error($link);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Galeria de Fotos</title>
<link href="skins/gris/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
    #scroll {
        margin: 0 auto;
        padding: 20px;
        text-align:center;
		height:1%;
	}
	#scroll .sorting {
		float: left;
		text-align: right;
		width: 100px;
		margin: 4px;
        padding: 4px;
		border: 1px solid #ccc;
	}
    #scroll .sorting:hover {
        border: 1px solid #666;
        cursor: move;
    }
	#scroll .sorting img {
		margin-bottom: 4px;
	}
#btn_cerrar {
	text-align: right;
	margin-bottom: 6px;
	margin-right:10px;
}
-->
</style>
<script src="../includes/funciones_generales.js" type="text/javascript"></script>
<script src="js_library/prototype.js" type="text/javascript"></script>
<script src="js_library/scriptaculous.js?load=effects,dragdrop" type="text/javascript"></script>
<script src="js_library/sorting.js" type="text/javascript"></script>
<script src="js_library/swfobject.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
	function validar(f){
		if(f.foto_foto.value==""){
			alert("Examinar ruta de Imagen.");
			f.foto_foto.focus();
			return false;
		}
		return true;
	}
//-->
</script>
</head>
<body>
<div id="titulo">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><h1>Galer&iacute;a de Fotos</h1></td>
      <!-- <td class="separador_tit">/</td>
      <td><h1 class="gris"><?=$fila_tmp["descripcion"]?></h1></td> -->
    </tr>
  </table>
</div>
<div id="contenido">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="10" class="recuadro">
          <tr>
            <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td><img src="imagenes/btn_agregar_imagenes.gif" alt="Agregar" width="112" height="19" id="btn_multifile" style="cursor:pointer" /></td>
                </tr>
                <tr>
                  <td align="right"><span>&nbsp;<span id="activityIndicator" style="display: none;">Guardando orden en la base de datos ...</span></span></td>
                </tr>
                <tr>
                  <td><fieldset>
                    <legend>Lista</legend>
                    <div id="scroll">
                      <?
					while($fila=mysql_fetch_assoc($result)){
                ?>
                      <div id="pictureId_<?=$fila["id_foto"]?>" class="sorting" ><img src="imagen.php?ruta=../imagenes/galeria/fotos/<?=$fila["foto"]?>&ancho=100&alto=74&mantener_ratio=1" alt="<?=$fila["descripcion"]?>" width="100" height="74" /> <a href="javascript:MM_openBrWindow('gallery_pop_descripcion.php?id=<?=$fila["id_foto"]?>&id_relacion=<?=$_GET["id_relacion"]?>&nombre_abm=<?=$_GET["nombre_abm"]?>','','width=365,height=190')"><img src="imagenes/btn_edit.gif" alt="" width="13" height="13" border="0" class="imagen" /></a> <a href="gallery_procesar.php?id_eliminar=<?=$fila["id_foto"]?>&id_relacion=<?=$_GET["id_relacion"]?>&nombre_abm=<?=$_GET["nombre_abm"]?>" onclick="return confirm('Esta seguro de borrar esta foto?.')"><img src="imagenes/ico_delete.gif" alt="" width="11" height="11" border="0" /></a></div>
                      <?
                	}
                ?>
                      <div style="clear:both;"><span></span></div>
                    </div>
                    </fieldset></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <div style="position:absolute;top:110px;left:190px; z-index:100;" id="contenedor_multifile"></div>
  <script type="text/javascript">
				    // <![CDATA[
				    $("btn_multifile").onclick = function(){
				    	abrir_multifile();
				    }
				    function abrir_multifile(){
						$("contenedor_multifile").innerHTML = "<div id='btn_cerrar'><a href='javascript:cerrar_multifile()'>cerrar x</a></div><div id='multifile_obj'></div>";
						var flashvars = {
							id_relacion:<?=$_GET["id_relacion"]?>,
							abm:'<?=$_GET["nombre_abm"]?>'
						};
						var params = {menu: "false", wmode: "transparent" };
						var attributes = {};
						swfobject.embedSWF("gallery_multifile_obj.swf", "multifile_obj", "400", "300", "8.0.0","", flashvars, params, attributes);
					}
					function cerrar_multifile(){
						$("contenedor_multifile").innerHTML = "";
					}
					// ]]>
  				  </script>
</div>
</body>
</html>
