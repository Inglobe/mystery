<?php
	require_once("../includes/fckeditor/fckeditor.php");
	$oFCKeditor = new FCKeditor($this->nombre);
	$oFCKeditor->BasePath="../includes/fckeditor/";
	$oFCKeditor->Config['DefaultLanguage']=$_SESSION["idioma"];
	$oFCKeditor->Value=$valor;
	$oFCKeditor->Height=$alto;
	$oFCKeditor->Create();
?>