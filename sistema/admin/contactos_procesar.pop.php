<?
	require_once("procesos_globales.php");

	switch($_GET["accion"]){
		case "d":
			mysql_query("DELETE FROM contactos WHERE id_contacto = ".$_GET["id_eliminar"],$link);
			$redireccionar="contactos_search.pop.php";
		break;
		case "a":
			$stringq="
				INSERT INTO contactos (
					nombre,
					email,
					telefonos,
					area,
					obs,
					id_cliente,
					user,
					pass
				) VALUES (
					'".$_POST["nombre"]."',
					'".$_POST["email"]."',
					'".$_POST["telefonos"]."',
					'".$_POST["area"]."',
					'".$_POST["obs"]."',
					'".$_GET["id"]."',
					'".$_POST["user"]."',
					MD5('".$_POST["pass"]."')
				)
			";
			mysql_query($stringq,$link);
			echo mysql_error($link);
			$redireccionar="contactos_am.pop.php";
			
			ob_start();
			require("mails/mail_bienvenida.php");
			$html = ob_get_contents();
			ob_end_clean();
	
			mail_html($_POST["email"],"website@mysterysur.com.ar","Mystery Sur",$fila_parametros["email_contactenos"],"Bienvenido",$html,strip_tags($html));
		break;
		case "m":

			if(isset($_GET["id_modificar"]) && ($_GET["id_modificar"] != "")){

				$sql = "SELECT * FROM contactos WHERE id_contacto = ".$_GET["id_modificar"];
				$result = mysql_query($sql,$link);

				$stringq = "
						UPDATE
							contactos
						SET
							nombre = '".$_POST["nombre"]."',
							email = '".$_POST["email"]."',
							telefonos = '".$_POST["telefonos"]."',
							area = '".$_POST["area"]."',
							obs = '".$_POST["obs"]."',
							id_cliente = '".$_GET["id"]."',
							";
						if(!empty($_POST["pass"])){
							$stringq .= "pass = MD5('".$_POST["pass"]."'),";
						}
						$stringq .= "
							user = '".$_POST["user"]."'
						WHERE
							id_contacto = ".$_GET["id_modificar"]."
					";
				echo $stringq;
			}

			mysql_query($stringq,$link);
			echo mysql_error($link);
			$redireccionar="contactos_search.pop.php";
		break;
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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de administraci&oacute;n</title>
<link href="css_library/estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js_library/funciones.js"></script>
</head>
<body>
<div id="contenedor_loading_pop">
  <div id="loading_pop">Espere porfavor...<br />
    <img src="imagenes/loadingAnimation.gif" alt="please wait" vspace="4" /></div>
</div>
<script type="text/javascript">
// <![CDATA[
  setTimeout('redireccionar("<?=$redireccionar?>?feed=<?=$_GET["accion"]?>&accion=<?=$_GET["accion"]?>&id=<?=$_GET["id"]?>")', 1500);
// ]]>
</script>
</body>
</html>
