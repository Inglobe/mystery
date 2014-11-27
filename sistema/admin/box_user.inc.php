			<?
				$fila_user = mysql_fetch_assoc(mysql_query("SELECT * FROM usuarios WHERE id_usuario = ".$_SESSION["id_usr"],$link));
				if($fila_user["foto"]!=""){
					$foto_str = "imagen.php?ruta=../imagenes/usuarios/fotos/".$fila_user["foto"]."&amp;ancho=68&amp;alto=67&mantener_ratio=1";
				}
				else{
					$foto_str = "imagenes/user_default.jpg";
				}
			?>
			<div id="box_user">
			  <div id="notificaciones" style="display: none"></div>
              <div id="img_user"><img src="imagenes/mascara_foto_usuario.png" alt="" id="mascara_img" /><img src="<?=$foto_str?>" alt="" /></div>
              <div id="control_user">
                <div id="nombre_user"><?=$_SESSION["usr_nombre"]?></div>
                <div id="ver_perfil"><a href="index.php?logout=1">Logout</a></div>
              </div>
            </div>