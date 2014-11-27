<?
require("config.php");
$link=mysql_connect($host_db,$user_db,$pass_db);
mysql_select_db($db_nombre,$link);
?>