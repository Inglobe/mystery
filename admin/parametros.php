<?php
//Titulacion ABM
$titulo_abm="Opciones";
$sub_titulo_abm="Parametros";
$titulo_opcion="Modificar";

if($_POST["re"]==1){
	//print_r($_POST);
	$stringq=" UPDATE parametros";
	$stringq.= " SET email_contactenos = '".$_POST["email_contactenos"]."'";
	$stringq.= ",nombre_email_contactenos = '".$_POST["nombre_email_contactenos"]."'";
	$stringq.= ",email_newsletter = '".$_POST["email_newsletter"]."'";
	$stringq.= ",nombre_email_newsletter = '".$_POST["nombre_email_newsletter"]."'";
	$stringq.= ",email_reply_newsletter = '".$_POST["email_reply_newsletter"]."'";
	$stringq.= ",paginacion = '".$_POST["paginacion_defecto"]."'";
	$stringq.= ",domicilio = '".$_POST["domicilio"]."'";
	$stringq.= ",telefonos = '".$_POST["telefonos"]."'";
	mysql_query($stringq,$link);
	//echo $stringq;
	echo mysql_error($link);
}
$CadenaSQL="SELECT * FROM parametros";
$result_consulta = mysql_query($CadenaSQL,$link);
if($result_consulta){
	$fila=mysql_fetch_array($result_consulta);
	$email_contactenos=$fila["email_contactenos"];
	$nombre_email_contactenos=$fila["nombre_email_contactenos"];
	$email_newsletter=$fila["email_newsletter"];
	$nombre_email_newsletter=$fila["nombre_email_newsletter"];
	$email_reply_newsletter=$fila["email_reply_newsletter"];
	$paginacion_defecto=$fila["paginacion"];
	$domicilio=$fila["domicilio"];
	$telefonos=$fila["telefonos"];
}
include("includes/titulos.php");
?>
  <div id="solapas">
    <div id="solapa_search"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/solapa_parametros_on.gif" alt="Search" border="0" /></div>
  </div>
  <?
  	  if($re==1)
  	  	  $mostrar_feed="";
  	  else
  	  	  $mostrar_feed="none";
  ?>
  <div id="contenedor_feed" style="display: <?=$mostrar_feed?>">
    <div id="feed">
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="16" align="left" valign="middle"><img src="imagenes/ico_info.gif" alt="" width="10" height="11" /></td>
          <td>Parametro Modificado</td>
        </tr>
      </table>
    </div>
  </div>
  <div id="contenido">
    <form id="form1" name="form1" method="post" action="">
    <input type="hidden" name="re" value="1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="recuadro">
            <tr>
              <td><table width="100%" border="0" cellspacing="20" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="3">
                    <tr>
                      <td>
					  		<table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td>E-mail Cont&aacute;ctenos</td>
                        </tr>
                        <tr>
	                          <td><?
									$nombre_campo = "email_contactenos";
									$tamanio_texto = 40;
									$tamanio_texto_maximo = 40;
									$tipo = "normal";
									include("includes/campo_texto.php");

							  ?></td>
                        </tr>
                      	<tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>Nombre E-mail Cont&aacute;ctenos</td>
                        </tr>
                        <tr>
	                          <td><?
									$nombre_campo = "nombre_email_contactenos";
									$tamanio_texto = 40;
									$tamanio_texto_maximo = 40;
									$tipo = "normal";
									include("includes/campo_texto.php");

							  ?></td>
                        </tr>
					    <tr>
                          <td><hr></td>
                        </tr>
                        <tr>
                          <td>E-mail Newsletter</td>
                        </tr>
                        <tr>
	                          <td><?
									$nombre_campo = "email_newsletter";
									$tamanio_texto = 40;
									$tamanio_texto_maximo = 40;
									$tipo = "normal";
									include("includes/campo_texto.php");

							  ?></td>
                        </tr>
					    <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
							<td>Nombre e-mail Newsletter</td>
                        </tr>
                        <tr>
	                          <td><?
									$nombre_campo = "nombre_email_newsletter";
									$tamanio_texto = 40;
									$tamanio_texto_maximo = 40;
									$tipo = "normal";
									include("includes/campo_texto.php");

							  ?></td>
                        </tr>
					    <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>E-mail de respuesta de Newsletter</td>
                        </tr>
                        <tr>
	                          <td><?
									$nombre_campo = "email_reply_newsletter";
									$tamanio_texto = 40;
									$tamanio_texto_maximo = 40;
									$tipo = "normal";
									include("includes/campo_texto.php");

							?></td>
                        </tr>
                        <tr>
                          <td><hr></td>
                        </tr>
						<tr>
                          <td>Paginaci&oacute;n</td>
                        </tr>
                        <tr>
		                          <td><?
										$nombre_campo = "paginacion_defecto";
										$tamanio_texto = 5;
										$tamanio_texto_maximo = 5;
										$tipo = "normal";
										include("includes/campo_texto.php");

								?></td>
                        </tr>
                        <tr>
                          <td><hr></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <!--<tr>
                          <td><strong>Datos de Cont&aacute;ctos</strong></td></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>Domicilio</td>
                        </tr>
                        <tr>
		                    <td><?
									$nombre_campo = "domicilio";
									$tamanio_texto = 60;
									$tamanio_texto_maximo = 200;
									$tipo = "normal";
									include("includes/campo_texto.php");

							?></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>Tel&eacute;fonos</td>
                        </tr>
                        <tr>
		                    <td><?
									$nombre_campo = "telefonos";
									$tamanio_texto = 60;
									$tamanio_texto_maximo = 100;
									$tipo = "normal";
									include("includes/campo_texto.php");

							?></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>-->
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><img src="imagenes/spacer.gif" alt="spacer" width="1" height="5" /></td>
        </tr>
        <tr>
          <td align="right"><input type="image" src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_ok.gif" alt="Ok" border="0" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </form>
  </div>