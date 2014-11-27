<?
//session_name("admin");
session_start();

//var_dump($_SESSION);

require_once("../includes/conexion.inc.php");
require_once("../includes/funciones_generales.php");
require_once("funciones_proyecto.php");
require_once("funciones.php");

//LOGIN
//session_register("id_usr");
//session_register("usr_email");
//session_register("usr_nombre");
$error_login=false;

if($_POST["login"] == 1){
	$cadenaSQL="SELECT COUNT(*) AS nro FROM usuarios";
	$result_consulta_tmp = mysql_query($cadenaSQL,$link);
	echo mysql_error();
	$fila_tmp=mysql_fetch_array($result_consulta_tmp);
	if($fila_tmp["nro"] == 0){
		mysql_query("TRUNCATE TABLE usuarios",$link);
		echo mysql_error();
		mysql_query("INSERT INTO usuarios (nombre,user,pass,activo) VALUES('Admin','".$_POST["user"]."',MD5('".$_POST["pass"]."'),'1')",$link);
		echo mysql_error();
	}
	$cadenaSQL="SELECT * FROM usuarios WHERE user LIKE \"".$_POST["user"]."\" AND pass LIKE MD5('".$_POST["pass"]."') AND activo = 1";
	$result_consulta_login = mysql_query($cadenaSQL,$link);
	echo mysql_error();
	$fila_login=mysql_fetch_array($result_consulta_login);
	if(mysql_num_rows($result_consulta_login) == 1 && ($_POST["user"] != "" || $_POST["pass"] != "")){
		$_SESSION["id_usr"]=$fila_login["id_usuario"];
		$_SESSION["usr_user"]=$fila_login["user"];
		$_SESSION["usr_nombre"]=$fila_login["nombre"];
		$_SESSION["usr_email"]=$fila_login["email"];
		$_SESSION["usr_tipo"]=$fila_login["id_tipo_usuario"];

		mysql_query("INSERT INTO logs_loguins (fechahora,id_usuario,ip) VALUES (NOW(),'".$_SESSION["id_usr"]."','".$_SERVER["REMOTE_ADDR"]."')",$link);
		$error_login=false;
	}
	else{
		$error_login=true;
	}
}

if($_GET["logout"] == 1){
	session_destroy();
	$_SESSION["id_usr"] = null;
}
//

//INCLUSION
if(isset($_GET["put"])){
	$put = $_GET["put"];
}
else{
	if(isset($_POST["put"])){
		$put = $_POST["put"];
	}
	else{
		if($_SESSION["id_usr"]!=null){
			$put = "home";
		}
	}
}

if(substr_count($put,"http://") < 1){
	if (($fp = @fopen($put.".php", "r", 1)) and fclose($fp)){
	}
	else{
		$put = "error";
	}
}
//

//CONFIGURAR FECHA EN PAGINA
setlocale(LC_ALL,"english");
//

//PARAMETROS
$result_consulta = mysql_query("SELECT * FROM parametros",$link);
$fila_parametros = mysql_fetch_array($result_consulta);
$paginacion = $fila_parametros["paginacion"];
//

//IDIOMA
$idioma="es";
require_once("idioma/".$idioma."/idioma.php");
//

//SKIN
$abm_skin="gris";
//

if($_SESSION["id_usr"] != NULL){
	$usuarios_tmp = getUsrOnline();
}

//var_dump($_SESSION);

?>