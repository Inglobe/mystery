<?php
//Titulacion ABM
$titulo_abm="Opciones";
$sub_titulo_abm="Parametros";
$titulo_opcion="Modificar";
$nombre_abm="parametros";

if($re==1){
	//print_r($_POST);
	$stringq=" UPDATE parametros";
	$stringq.= " SET email_contactenos = '".$email_contactenos."'";
	$stringq.= ",nombre_email_contactenos = '".$nombre_email_contactenos."'";
	$stringq.= ",email_newsletter = '".$email_newsletter."'";
	$stringq.= ",nombre_email_newsletter = '".$nombre_email_newsletter."'";
	$stringq.= ",email_reply_newsletter = '".$email_reply_newsletter."'";
	$stringq.= ",id_grupo_news_site = '".$id_grupo_news_site."'";
	$stringq.= ",paginacion = '".$paginacion_defecto."'";
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
	$id_grupo_news_site=$fila["id_grupo_news_site"];
	$paginacion_defecto=$fila["paginacion"];
}
?>
<script language="javascript" type="text/javascript">
	function validar_parametros(f){
		if(f.id_grupo_news_site.value == 0){
			alert("Seleccione un Grupo.");
			f.id_grupo_news_site.focus();
			return false;
		}
		else{
			return true;
		}

	}
</script>
<?
  	  if($re==1)
  	  	  $mostrar_feed="";
  	  else
  	  	  $mostrar_feed="none";
  ?>
<div id="titulo">
  <h1><span>Options</span><span class="separador_tit">/</span><span class="gris">Parameters</span></h1>
</div>
<div id="contenedor_feed_add" style="display: <?=$mostrar_feed?>">
  <div id="feed_add">
    <div id="texto_feed">Parameters Modified</div>
    <img src="imagenes/ico_info.jpg" alt="" /> </div>
</div>
<div id="paremetros">
<div class="cbza_bloque">
  <div class="cont_fondo_bloque_sup_izq">
    <div class="fondo_bloque_sup_izq"><span></span></div>
  </div>
  <div class="cont_fondo_bloque_sup_der">
    <div class="fondo_bloque_sup_der"><span></span></div>
  </div>
</div>
<div class="borde_bloque_izq">
  <div class="borde_bloque_der">
    <div class="cuerpo_bloque">
      <form id="form_parametros" name="form_parametros" method="post" action="" onsubmit="return validar_parametros(this)">
        <input type="hidden" name="re" value="1">
        <div class="control">
          <div class="label_add_parametros">E-mail Cont&aacute;ctenos</div>
		  <?
					$nombre_campo = "email_contactenos";
					$tamanio_texto = 40;
					$tamanio_texto_maximo = 40;
					$tipo = "normal";
					include("includes/campo_texto.php");
		  ?></div>
		    <div class="control">
          <div class="label_add_parametros">Nombre E-mail Cont&aacute;ctenos</div>
		  <?
					$nombre_campo = "nombre_email_contactenos";
					$tamanio_texto = 40;
					$tamanio_texto_maximo = 40;
					$tipo = "normal";
					include("includes/campo_texto.php");
		  ?></div>
			<div class="control">
          <div class="label_add_parametros">E-mail Newsletter</div>
		  <?
					$nombre_campo = "email_newsletter";
					$tamanio_texto = 40;
					$tamanio_texto_maximo = 40;
					$tipo = "normal";
					include("includes/campo_texto.php");
		  ?></div>
        <div class="control">
          <div class="label_add_parametros">Nombre e-mail Newsletter</div>
		  <?
					$nombre_campo = "nombre_email_newsletter";
					$tamanio_texto = 40;
					$tamanio_texto_maximo = 40;
					$tipo = "normal";
					include("includes/campo_texto.php");
		  ?></div>
        <div class="control">
          <div class="label_add_parametros">E-mail de respuesta de Newsletter</div>
		  <?
					$nombre_campo = "email_reply_newsletter";
					$tamanio_texto = 40;
					$tamanio_texto_maximo = 40;
					$tipo = "normal";
					include("includes/campo_texto.php");
		  ?></div>
        <div class="control">
          <div class="label_add_parametros">Grupo usuarios del sitio</div>
		  <?
					$id_combo = "id_grupo_news_site";
					$id_db = "id_grupo_news";
					$item_ninguno = "--seleccionar--"; //ACORDARSE DE VALIDAR FORM
					$cadena_combo = "SELECT * FROM grupos_news ORDER BY descripcion ASC";
					$campo_mostrar = "descripcion";
					include("includes/combo.php");
		?></div>
        <div class="control">
          <div class="label_add_parametros">Paginaci&oacute;n</div>
		  <?
					$nombre_campo = "paginacion_defecto";
					$tamanio_texto = 5;
					$tamanio_texto_maximo = 5;
					$tipo = "normal";
					include("includes/campo_texto.php");
		  ?></div>
        <div id="btns_ok_cancel">
          <input type="image" src="imagenes/btn_ok.jpg" alt="Ok" />
        </div>
      </form>
	  </div>
    </div>
  </div>
  <div class="pie_bloque">
    <div class="cont_fondo_bloque_inf_izq">
      <div class="fondo_bloque_inf_izq"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_inf_der">
      <div class="fondo_bloque_inf_der"><span></span></div>
    </div>
  </div>
</div>
