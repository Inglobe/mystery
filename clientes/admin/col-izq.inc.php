<?
$db_load = new database_format;

$sql = "SELECT 
			c.nombre,
			c.email,
			c.domicilio,
			c.logo AS logo_cliente,
			c.id_cliente
		FROM 
			clientes c
			JOIN contactos con ON c.id_cliente = con.id_cliente
		WHERE 
			con.id_contacto = ".$_SESSION["id_usr"]."
		";
		
$db_load->query($sql);

$db_load->fetch();
?>
<script language="JavaScript" type="text/JavaScript">
    var Hoy = new Date("<?php echo date("d M Y H:i:s");?>");
function Reloj(){ 
    Hora = Hoy.getHours() 
    Minutos = Hoy.getMinutes() 
    Segundos = Hoy.getSeconds() 
    if (Hora<=9) Hora = "0" + Hora 
    if (Minutos<=9) Minutos = "0" + Minutos 
    if (Segundos<=9) Segundos = "0" + Segundos 
    var Mes = new Array("ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SEP","OCT","NOV","DIC"); 
    var Anio = Hoy.getFullYear(); 
    var Fecha = "<span class='title_color'>" + Hoy.getDate() + " " + Mes[Hoy.getMonth()] + "</span> | " + Anio ; 
    Script = "<div id='day'>" + Fecha + "</div>" + "<div id='clock'>" +Hora + ":" + Minutos + ":" + Segundos + "</div>"
    document.getElementById('clock_content').innerHTML = Script 
    Hoy.setSeconds(Hoy.getSeconds() +1)
    setTimeout("Reloj()",1000) 
} 
</script>
<div id="col_home_content">
  <div id="clock_content" class="block gradient_normal">
    <div id="day"><span class="title_color">00 ENE</span> | 0000</div>
    <div id="clock">00:00</div>
  </div>
  <div id="menu_content" class="block">
    <div class="tit_menu gradient_theme">
      <div class="ico_tit_menu"><img src="images/ico_auditorias_mini-trans.png" width="22" height="24" alt="" /></div>
      <h3>&Uacute;LTIMAS AUDITOR&Iacute;AS</h3>
    </div>
    <ul>
	<?
	$db_aut = new database_format;
	$db_aut->query("SELECT p.* FROM proyectos p JOIN contactos c ON p.id_cliente = c.id_cliente WHERE c.id_contacto = ".$_SESSION["id_usr"]." AND p.id_estado_proyecto = 3 AND p.plantilla = 0 ORDER BY p.id_proyecto DESC LIMIT 5");
	while($db_aut->fetch()){
	?>
      <li><a href="index.php?put=auditorias_informe&amp;id=<?=$db_aut->getValue("id_proyecto")?>"><?=$db_aut->getXHTMLValue("nombre")?></a></li>
    <?
	}
	?>
    </ul>
    <div class="tit_menu gradient_theme">
      <div class="ico_tit_menu"><img src="images/ico_estadisticas_mini.png" width="24" height="23" alt="" /></div>
      <h3>ESTAD&Iacute;STICAS</h3>
    </div>
    <ul>
	  <li><a href="#">No disponible.</a></li> 
    </ul>
	<?
		$db_pgral = new database;
		$sql = "
				SELECT 
					AVG(
						(
							SELECT 
								SUM(t.tiempo) AS total 
							FROM 
								tareas t 
							WHERE
								t.id_proyecto = p.id_proyecto AND
								t.ocultar = 0
							GROUP BY
								p.id_proyecto
						)
					) AS promedio
				FROM 
					proyectos p
				WHERE
					p.id_cliente = ".$db_load->getValue("id_cliente")." AND
					p.id_estado_proyecto = 3 AND
					p.plantilla = 0
				GROUP BY
					p.id_cliente
				";
		$db_pgral->query($sql);
		
		$db_pgral->fetch();		
		
	?>
    <div id="puntaje_home" class="gradient_theme">PUNTAJE GRAL: <span class="positive_color"><?=number_format($db_pgral->getValue("promedio"),1)?></span></div>
  </div>
</div>