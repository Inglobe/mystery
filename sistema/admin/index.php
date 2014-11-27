<?php
require_once("procesos_globales.php");
if($_SESSION["id_usr"] == null){
	require("login.php");
}
else{
	require_once("main.php");
}
?>