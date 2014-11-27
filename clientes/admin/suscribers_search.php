<div id="cont_btns_import_export">
  <div id="btns_import_export">
    <div class="button gradient_theme" style="padding-right:24px;"><a href="javascript:showPopWin('suscribers_import.pop.php',350,180,null)">Importar</a><a href="javascript:showPopWin('suscribers_import.pop.php',350,180,null)"><img src="images/ico_import.png" width="38" height="24" alt="" /></a></div>
    <div class="button gradient_theme" style="padding-right:24px;"><a href="javascript:showPopWin('suscribers_export.pop.php',350,150,null)">Exportar</a><a href="javascript:showPopWin('suscribers_export.pop.php',350,150,null)"><img src="images/ico_export.png" width="38" height="24" alt="" /></a></div>
  </div>
</div>
<?php

	require_once(PATH_ABM_SEARCH);
	
	$sql = "SELECT 
				s.*,
				g.description AS group_desc
			FROM 
				suscribers s
				JOIN groups g ON s.id_group = g.id_group
			";
	
	$abm = new ABMSearch("suscribers","suscribers","id_suscriber","Sistema","Suscriptores",$sql);
	
	//filtros
	$abm->addFilter("textField","nombre","Nombre",32);
	
	//Listado
	$abm->addCol("s.email","email","Nombre",200,"left","left",true);
	$abm->addCol("s.name","name","Nombre",200,"left","left",true);
	$abm->addCol("g.description","group_desc","Grupo",200,"left","left",true);
	
	$abm->show();
?>
