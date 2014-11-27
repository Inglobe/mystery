  <?
  	  if(isset($nombre_abm)){
	  	  $nombre_form="form_".$nombre_abm;
	  }
	  if(!isset($fecha_defecto)){
	  	  $fecha_defecto=date("d/m/Y");
	  }
  ?>
  <script language="javascript">FSfncWriteFieldHTML("<?=$nombre_form?>","<?=$nombre_datebox?>","<?=$fecha_defecto?>",100,"includes/date_picker/images/FSdateSelector/","EN",true,true)</script>
  <?
  	  unset($nombre_datebox,$fecha_defecto);
  ?>