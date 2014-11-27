<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mystery Sur System</title>
<link href="css_library/estilos.css" rel="stylesheet" type="text/css" />
<link href="css_library/cuerpo.css" rel="stylesheet" type="text/css" />
<link href="css_library/paginador.css" rel="stylesheet" type="text/css" />
<link href="clases/ABMControls/datePicker/styles/fsdateselect.css" rel="stylesheet" type="text/css" />
<link href="css_library/subModal.css" rel="stylesheet" type="text/css" />
<link href="css_library/botonera_sup.css" rel="stylesheet" type="text/css" />
<link href="js_library/loom/calendar/calendar.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 7]>
<link href="css_library/subModal-iefix.css" rel="stylesheet" type="text/css" />
<script defer type="text/javascript" src="js_library/pngfix_map.js"></script>
<script type="text/javascript" src="js_library/stuHover.js"></script>
<![endif]-->
<script defer type="text/javascript" src="js_library/pngfix.js"></script>
<script type="text/javascript" src="js_library/funciones.js"></script>
<script type="text/javascript" src="js_library/prototype.js"></script>
<script type="text/javascript" src="js_library/scriptaculous/scriptaculous.js"></script>
<script type="text/javascript" src="js_library/scriptaculous/unittest.js"></script>
<script type="text/javascript" src="js_library/loom/core/core.js"></script>
<script type="text/javascript" src="js_library/loom/core/format.js"></script>
<script type="text/javascript" src="js_library/loom/ui/ui.js"></script>
<script type="text/javascript" src="js_library/loom/ui/tabs.js"></script>
<script type="text/javascript" src="js_library/loom/calendar/calendar.js"></script>
<script type="text/javascript" src="js_library/loom/tables/tables.js"></script>
<script type="text/javascript" src="js_library/loom/validation/validation.js"></script>
<script type="text/javascript" src="js_library/resources.js"></script>
<script type="text/javascript" src="../includes/MySQLDatabase.class.js"></script>
<script type="text/javascript" src="clases/ABMControls/datePicker/scripts/fsdateselect.js"></script>
<script type="text/javascript" src="../includes/submodal/common.js"></script>
<script type="text/javascript" src="js_library/subModal.js"></script>
<script type="text/javascript" src="js_library/swfobject.js"></script>
<link rel="shortcut icon" href="favicon.ico" >
</head>
<body>
<? //include("box_botonera.inc.php") ?>
<div id="contenedor">
  <div id="cbza">
    <div id="fondo_sup_izq">
      <div id="sombra_izq"><span></span></div>
      <div id="ondas_logo"><span></span></div>
      <div id="logo"><img src="imagenes/logo.png" alt="" width="187" height="70" /></div>
    </div>
    <div id="fondo_sup_der">
      <div id="sombra_der"><span></span></div>
    </div>
  </div>
  <div id="sombra_izq_repeat">
    <div id="sombra_der_repeat">
      <div id="cuerpo">
        <div id="linea_cbza">
          <? include("box_user.inc.php") ?>
        </div>
        <?
        	$usuario_externo = getUsrExterno($_SESSION["id_usr"]);
		?>
		<?
        if($_SESSION["usr_tipo"]==1){
        ?>
		<div id="cont_box_buscar">
			<div id="box_buscar">
	          <input id="txt_buscar" type="text" name="q" value="Buscar auditoria..." style="width: 320px" />
	          <div id="buscar_resultados" class="autocompleter_resultados" style="display: none;"></div>
	          <script type="text/javascript">
					new Ajax.Autocompleter('txt_buscar','buscar_resultados','autocompleter-response.php', { tokens: ',', afterUpdateElement: updateHidden} );
					function updateHidden(txt, li){
						var url_destino = li.getElementsByTagName("a")[0].href;
						window.location.href = url_destino;
					    /*hiddenName = txt.name.replace("_","");
					    id = li.id.replace("auto_","");
					    txt.form[hiddenName].value = id;*/
					}
					$("txt_buscar").onfocus = function(){
						if($F(this) == "Buscar proyecto..."){
							this.value = "";
						}
					}
			  </script>
	        </div>
		</div>
		<?
		}
		?>
        <ul id="nav">
        <?
        if($_SESSION["usr_tipo"]==1){
        ?>
          <li class="top"><a href="#" id="services" class="top_link"><span class="down">Sistema</span></a>
            <ul class="sub">
              <li><a href="index.php?put=clientes_search&amp;cambiar=1">Clientes</a></li>
              <li><a href="index.php?put=usuarios_search&amp;cambiar=1">Usuarios</a></li>
            </ul>
          </li>
          <li class="top"><a href="#" id="services" class="top_link"><span class="down">Auditorias</span></a>
            <ul class="sub">
              <li><a href="index.php?put=proyectos_search&amp;cambiar=1">Administrar auditorias</a></li>
              <li><a href="index.php?put=proyectos_disponibles&amp;cambiar=1">Bolsa de trabajo</a></li>
              <li><a href="index.php?put=proyectos_postulaciones&amp;cambiar=1">Postulaciones</a></li>
              <li><a href="index.php?put=agenda&amp;cambiar=1">Agenda</a></li>
              <li><a href="index.php?put=tipos_proyecto_search&amp;cambiar=1">Tipos de auditoria</a></li>
              <li><a href="#">Reportes</a>
                <ul>
                  <li><a href="reporte_proyectos_pendientes.php" target="_blank">Proyectos pendientes</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="top"><a href="#" id="services" class="top_link"><span class="down">Opciones</span></a>
            <ul class="sub">
              <li><a href="index.php?put=parametros&amp;cambiar=1">Parametros</a></li>
              <li><a href="index.php?put=backup_menu&amp;cambiar=1">Backup</a></li>
            </ul>
          </li>
        <?
        }
        else{
        ?>
          <li class="top"><a href="index.php?put=agenda" id="externo" class="top_link"><span class="">Agenda</span></a></li>
          <li class="top"><a href="index.php?put=proyectos_search" id="externo" class="top_link"><span class="">Auditorias</span></a></li>
          <li class="top"><a href="index.php?put=proyectos_disponibles&amp;cambiar=1" id="externo" class="top_link"><span class="">Bolsa de trabajo</span></a></li>
        <?
        }
        ?>
        </ul>
        <div id="alto_min"><span></span></div>
        <div id="contenido">
          <?
		  	$start = InicioCronometro();
			$PrecisionDecimal = 4;
		  	include($put.".php")
		  ?>
        </div>
      </div>
    </div>
  </div>
  <div id="pie">
    <div id="fondo_inf_izq"><span></span></div>
    <div id="fondo_inf_der"><span></span></div>
    <?
    if($_SESSION["usr_tipo"]==1){
    ?>
	<div style="padding-top:8px;">Usuarios conectados: <strong><?
		foreach($usuarios_tmp as $id_usuario){
			if($id_usuario != $_SESSION["id_usr"]){
				$poner_link = true;
			}
			else{
				$poner_link = false;
			}
			$poner_link = false;
			$usuarios_online[] = ($poner_link?'<a href="javascript:abrir_chat('.$id_usuario.')">':"").ucfirst(getUsrById($id_usuario)).($poner_link?'</a>':"");
		}

		echo implode(", ",$usuarios_online);
	?></strong></div>
	<?
	}
	?>
  </div>
  <div id="tiempo_duracion">El proceso tardo
    <?=number_format(FinCronometro($start), $PrecisionDecimal, '.', '');?>
    seg. en completarse</div>
</div>
<?
if(!isset($_GET["id_padre"])){
?>
<script type="text/javascript" src="js_library/menu.js"></script>
<span id="ruidito"></span>
<span id="fuego_alerta"></span>
<div style="position:absolute; bottom:0px; right:0px;"><span id="toasty"></span></div>
<script type="text/javascript" src="js_library/notificaciones.js"></script>
<script type="text/javascript">
<!--
	function abrir_chat(id_usuario){
		window.open("../chat/private.php?private_id="+id_usuario,"chat","width=300,height=450");
	}
	checkNotificaciones(<?=$_SESSION["id_usr"]?>);
	setInterval('checkNotificaciones(<?=$_SESSION["id_usr"]?>)',60000);
//-->
</script>
<?
}
?>
</body>
</html>
