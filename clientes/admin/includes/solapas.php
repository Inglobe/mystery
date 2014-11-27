  <div id="solapas">
<?
  if($accion=="d"){
?>
    <div id="solapa_delete"><a href="#"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/solapa_borrar_on.gif" alt="Borrar" border="0" /></a></div>
<?
  }
?>
<?
  if($accion=="m"){
?>
    <div id="solapa_modify"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/solapa_modificar_on.gif" alt="Modificar" border="0" /></div>
<?
  }
?>
    <div id="solapa_add"><a href="index.php?put=<?=$nombre_abm?>_am&accion=a"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/solapa_agregar_<?
  if($accion=="a")
  	  echo "on";
  else
  	  echo "off";
?>.gif" alt="Agregar" border="0" /></a></div>
    <div id="solapa_search"><a href="index.php?put=<?=$nombre_abm?>_search&accion=s"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/solapa_buscar_<?
  if($accion=="s")
  	  echo "on";
  else
  	  echo "off";
?>.gif" alt="Buscar" border="0" /></a></div>
  </div>
