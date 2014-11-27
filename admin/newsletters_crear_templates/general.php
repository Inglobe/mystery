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
	if($gestor = opendir('../newsletters/modelo_general/encabezados')){
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
                                  <td><input name="encabezado_general" type="radio" value="<?=$archivo?>" <?
            		if($i==1)
            			echo "checked";
	?>/>
                                  </td>
                                  <td><table border="0" cellspacing="5" cellpadding="0">
                                      <tr>
                                        <td><!--cabezal-->
                                          <img src="imagen.php?ruta=../newsletters/modelo_general/encabezados/<?=$archivo?>&amp;ancho=512"/> </td>
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
						$nombre_campo="descripcion_general";
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
					<tr>
						<td height="30">
							<strong>Publicaciones principales</strong>
						</td>
					</tr>
					<tr>
						<td>
							<? 
								$nombre_campo = "publicaciones_gen_princ";
								include("newsletters_campo_buscar_publicaciones.php"); 
							?>
						</td>
					</tr>
					<tr>
                      <td>&nbsp;</td>
                    </tr>
					<tr>
						<td height="30">
							<strong>Publicaciones normales</strong>
						</td>
					</tr>
					<tr>
						<td>
							<? 
								$nombre_campo = "publicaciones_gen_normales";
								include("newsletters_campo_buscar_publicaciones.php"); 
							?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
						<td height="30">
							<strong>Institucionales</strong>
						</td>
					</tr>
					<tr>
						<td>
							<? 
								$nombre_campo = "publicaciones_instit";
								include("newsletters_campo_buscar_publicaciones.php"); 
							?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
						<td height="30">
							<strong>Eventos</strong>
						</td>
					</tr>
					<tr>
						<td>
							<? 
								$nombre_campo = "publicaciones_eventos";
								include("newsletters_campo_buscar_publicaciones.php"); 
							?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
						<td height="30">
							<strong>Curiosidades</strong>
						</td>
					</tr>
					<tr>
						<td>
							<? 
								$nombre_campo = "publicaciones_curios";
								include("newsletters_campo_buscar_publicaciones.php"); 
							?>
						</td>
					</tr>
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
                      <td height="30"><strong><input type="checkbox" name="encuestas_general[]" value="<?=$fila_categoria["id_encuesta"]?>" /><?=xhtmlOut($fila_categoria["descripcion_es"])?></strong></td>
                    </tr><?

            }
?>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>