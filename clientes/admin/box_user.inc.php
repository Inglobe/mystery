<?
	/*if($data->session('usr_foto') != ''){
		$foto_str = "image.php?ruta=../images/usuarios/fotos/".$data->session('usr_foto')."&amp;ancho=61&amp;alto=57&amp;mantener_ratio=1&amp;franjas=1";
	}else{
		$foto_str = "../admin/images/user_default.jpg";
	} */
?>
<div id="box_user">
  <? /*<div id="img_user"><img src="<?=$foto_str?>" alt="" /></div>*/ ?>
  <div id="control_user">
    <div id="username"><?=$_SESSION["usr_nombre"]?></div>
  </div>
</div>
