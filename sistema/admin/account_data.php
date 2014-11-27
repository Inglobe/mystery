<?
	require("procesos_globales.php");

	$post_data["us"] = base64_encode($_GET["id"]);
	
	$auth["user"] = "dhmcontrol";
	$auth["pass"] = "9L7SFSir6e";

	$headers["User-Agent"] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; es-AR; rv:1.8.1.7) Gecko/20070914 Firefox/2.0.0.7";
	$headers["Accept-Language"] = "es-es,es;q=0.8,en-us;q=0.5,en;q=0.3";
	$headers["Accept-Charset"] = "ISO-8859-1,utf-8;q=0.7,*;q=0.7";

	$datos = httpRequest("www.zephia.com.ar:2083/accounts/zephia_getaccountdata.php","post",$post_data,$headers,NULL,$auth);

	echo $datos;
?>
