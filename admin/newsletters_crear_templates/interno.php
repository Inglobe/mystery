				<table width="95%" border="0" align="right" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="30"><strong>Encabezados</strong></td>
                    </tr>
                    <tr>
                      <td><!--inicio tabla-->
                        <table width="100%" border="0" cellspacing="5" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <?
	if($gestor = opendir('../newsletters/modelo_interno/encabezados')){
		$i=0;
		while (false !== ($archivo = readdir($gestor))){
			if($archivo!="." && $archivo!=".."){
				$tmp=explode(".",$archivo);
				foreach($tmp as $valor){
					$extension=$valor;
				}
				if($extension=="JPG" || $extension=="jpg"){
					$i++;
    ?>
                                <tr>
                                  <td><input name="encabezado" type="radio" value="<?=$archivo?>" <?
            		if($i==1)
            			echo "checked";
	?>/>
                                  </td>
                                  <td><table border="0" cellspacing="5" cellpadding="0">
                                      <tr>
                                        <td><!--cabezal-->
                                          <img src="imagen.php?ruta=../newsletters/modelo_interno/encabezados/<?=$archivo?>&amp;ancho=512"/> </td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <?
		  	  	}
			}
		}
		closedir($gestor);
	}
	?>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="30"><strong>Cuerpo</strong></td>
                    </tr>
                    <tr>
                      <td><table width="100%" border="0" cellspacing="10" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td>Descripci&oacute;n:</td>
                                </tr>
                                <tr>
                                  <td><?
						$nombre_campo="descripcion";
                    	$alto_richtext=400;
                    	$tipo="richtext";
                    	include("includes/campo_texto.php");
                    ?></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <!-- <tr>
                      <td>Publicacion Principal</td>
                    </tr>
                     <tr>
                      <td><select name="id_publicacion_principal">

                <?
                	$result_categorias = mysql_query("SELECT * FROM categorias ORDER BY descripcion",$link);
					while($fila_categoria = mysql_fetch_assoc($result_categorias)){
				?>
						<optgroup label="<?=$fila_categoria["descripcion"]?>">
				<?
	                	$sql = "SELECT * FROM publicaciones WHERE newsletter_interno = 1 AND id_categoria = ".$fila_categoria["id_categoria"]." ORDER BY fecha DESC";
						$result = mysql_query($sql,$link);
						echo mysql_error($link);
						while($row_publi_princ = mysql_fetch_array($result)){
                ?>
                      		<option value="<?=$row_publi_princ["id_publicacion"]?>"><?=$row_publi_princ["titulo"]?></option>
                <?
                		}
                ?>
                		</optgroup>
                <?
                	}
                ?>
					  </select></td>
                    </tr> -->
                    <!--Inicio Lista-->
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
<?
    	//INICIO PUBLICACIONES
		$result = mysql_query("SELECT COUNT(*) AS nro FROM publicaciones WHERE newsletter_interno = 1",$link);
		echo mysql_error($link);
		$row_news = mysql_fetch_array($result);
		if($row_news["nro"] > 0){
			$result_categorias = mysql_query("SELECT * FROM categorias ORDER BY descripcion",$link);
			while($fila_categoria = mysql_fetch_assoc($result_categorias)){
?>
                    <tr>
                      <td height="30"><strong><?=xhtmlOut($fila_categoria["descripcion"])?></strong></td>
                    </tr>
<?
					$sql = "SELECT *, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_f FROM publicaciones WHERE newsletter_interno = 1 AND id_categoria = ".$fila_categoria["id_categoria"]." ORDER BY fecha DESC";
					$result = mysql_query($sql,$link);
					echo mysql_error($link);
?>
                    <tr>
                      <td><table width="95%"  border="0" cellpadding="0" cellspacing="1">
<?
                	while($row_news = mysql_fetch_array($result)){
?>
                          <tr class="lista_oscura">
                            <td width="1%" align="center"><input name="publicaciones[<?=$fila_categoria["id_categoria"]?>][<?=$row_news["id_publicacion"]?>]" id="publicaciones[<?=$fila_categoria["id_categoria"]?>][<?=$row_news["id_publicacion"]?>]" type="checkbox" value="<?=$row_news["id_publicacion"]?>" checked="checked"/></td>
                            <td width="89%" align="left"><?=$row_news["titulo"]?></td>
                          </tr>
                          <?
                    }
                  ?>
                        </table></td>
                    </tr>
                    <?
            }

		}
	?>
                   <tr>
                      <td>&nbsp;</td>
                    </tr>
<?
    	//INICIO ENCUESTAS
		$result = mysql_query("SELECT
					*
				FROM
					encuestas
				ORDER BY
					descripcion_es ASC",$link);
		echo mysql_error($link);

			while($fila_categoria = mysql_fetch_assoc($result)){
?>
                    <tr>
                      <td height="30"><strong><input type="checkbox" name="encuestas[]" value="<?=$fila_categoria["id_encuesta"]?>" /><?=xhtmlOut($fila_categoria["descripcion_es"])?></strong></td>
                    </tr><?

            }

	?>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
					<tr>
                      <td>Usuario conociendonos</td>
                    </tr>
					<tr>
                      <td><?php
							$id_combo = "id_usuario_conociendo";
							$id_db = "id_usuario";
							$id_javascript = "id_usuario_conociendo";
							$item_ninguno = "--seleccionar--"; //ACORDARSE DE VALIDAR FORM
							$cadena_combo = "SELECT id_usuario, CONCAT(nombre,' ',apellido) AS nombre FROM usuarios ORDER BY TRIM(nombre) ASC";
							$campo_mostrar = "nombre";
							include("includes/combo.php");
						?></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>