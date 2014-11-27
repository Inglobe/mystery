<?php
//Titulacion ABM
$titulo_abm="Opciones";
$sub_titulo_abm="Cambio de mes";
$titulo_opcion="Modificar";
$nombre_abm="copiar_proyect";
?>
<script language="javascript" type="text/javascript">
	function validar_parametros(f){
		if(f.mes.value == 0){
			alert("Seleccione un mes.");
			f.mes.focus();
			return false;
		}
		if(f.anio.value == 0){
			alert("Seleccione un año.");
			f.anio.focus();
			return false;
		}
		return confirm("Este proceso generará todas las tareas y puede durar varios minutos, ¿desea continuar?");

	}
</script>
<?
  	  if($re==1)
  	  	  $mostrar_feed="";
  	  else
  	  	  $mostrar_feed="none";
  ?>
<div id="titulo">
  <h1><span>Options</span><span class="separador_tit">/</span><span class="gris">Cambio de mes</span></h1>
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
      <form id="form_copiar_proyecto" name="form_copiar_proyecto" method="get" action="index.php" onsubmit="return validar_parametros(this)">
        <input type="hidden" name="put" value="copiar_proyecto_feed">
        <div class="control">
          <div class="label_add_parametros">Mes</div>
		  <select name="mes" id="mes">
		  	<option value="0">--seleccione--</option>
			<option value="01">Enero</option>
			<option value="02">Febrero</option>
			<option value="03">Marzo</option>
			<option value="04">Abril</option>
			<option value="05">Mayo</option>
			<option value="06">Junio</option>
			<option value="07">Julio</option>
			<option value="08">Agosto</option>
			<option value="09">Septiembre</option>
			<option value="10">Octubre</option>
			<option value="11">Noviembre</option>
			<option value="12">Diciembre</option>
		  </select>
		  </div>
        <div class="control">
          <div class="label_add_parametros">A&ntilde;o</div>
		  <select name="anio" id="anio">
		  	<option value="0">--seleccione--</option>
			<?
			$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT YEAR(NOW()) AS anio FROM parametros",$link)); 
			for($i = $fila_tmp["anio"];$i < ($fila_tmp["anio"] + 3);$i++){
			?>
			<option value="<?=$i?>"><?=$i?></option>
			<?
			}
			?>
		  </select></div>
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
