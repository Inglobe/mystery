<?
	include("procesos_globales.php");
	if(isset($_GET["id"])){
		$datos = parse_ini_file("http://www.zephia.com.ar/zas/admin/account_data.php?id=".$_GET["id"]);
		$fila = mysql_fetch_assoc(mysql_query("SELECT *, DATE_FORMAT(created,'%d/%m/%Y'), AES_DECRYPT(password,CONCAT(username,'_FRZ')) AS pass FROM accounts WHERE username = '".$_GET["id"]."'", $link_ferozo));
		echo mysql_error($link_ferozo);
	}
	
	print_r($datos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	margin: 0px;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 0px;
	padding-left: 10px;
}
-->
</style>
<link href="clases/ABMControls/datePicker/styles/fsdateselect.css" rel="stylesheet" type="text/css" />
<link href="css_library/estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js_library/prototype.js"></script>
<script type="text/javascript" src="../includes/funciones_generales.js"></script>
<script type="text/javascript" src="js_library/multi_file_upload.js"></script>
<script type="text/javascript" src="../includes/MySQLDatabase.class.js"></script>
<script type="text/javascript" src="clases/ABMControls/datePicker/scripts/fsdateselect.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<h1><span class="gris">Auditorias</span><span class="separador_tit">/</span><span class="gris">Titulo</span><span class="separador_tit">/</span><span class="gris_claro">Tarea</span></h1>
</title>
</head>
<body>
<form action="accounts_procesar.pop.php" name="addnew" method="post" enctype="application/x-www-form-urlencoded">
<input type="hidden" value="create_account" name="op"/>
<input type="hidden" value="root" name="res_owner"/>
<div id="filtros"  style="padding-bottom: 5px;">
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
      <div class="cuerpo_bloque" style="overflow:auto; height:360px;">
        <div class="subtit_grupos">Datos</div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Dominio</label>
          </div>
		  <?
		  	if(!isset($_GET["id"])){
		  ?>
          <input type="text" name="domain_name" style="width:260px;" />
		  <?
		  	}
			else {
				echo "<div class=\"dato_add\">".$datos["DNS"]."</div>";
			}
		  ?>
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Usuario</label>
          </div>
		  <?
		  	if(!isset($_GET["id"])){
		  ?>
          <input type="text" name="accnt_username" style="width:150px;" />
		  <?
		  	}
			else {
				echo "<div class=\"dato_add\">".$_GET["id"]."</div>";
			}
		  ?>
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Password</label>
          </div>
		  <?
		  	if(!isset($_GET["id"])){
		  ?>
          <input type="text" name="password" style="width:150px;" />
		  <?
		  	}
			else {
				echo "<div class=\"dato_add\">".$fila["pass"]."</div>";
			}
		  ?>
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Espacio asignado</label>
          </div>
          <input type="text" name="quota" style="width:60px;" value="<?=$datos["QUOTA"] / 1024?>" />
          Mb. </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">UID:</label>
          </div>
          <div class="dato_add">610</div>
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">GID:</label>
          </div>
          <div class="dato_add">611</div>
        </div>
        <div class="subtit_grupos" style="padding-top:10px;">Caracter&iacute;sticas</div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Acceso CGI:</label>
          </div>
          <input type="checkbox" name="cgi" value="S" />
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Acceso Shell:</label>
          </div>
          <input type="checkbox" name="shell" value="S" />
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Extensiones de FrontPage:</label>
          </div>
          <input type="checkbox" name="frontpage" value="S" />
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Max. Cuentas FTP:</label>
          </div>
          <input type="text" name="maxftp" style="width:30px;" />
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Max. Cuentas Email:</label>
          </div>
          <input type="text" name="maxemail" style="width:30px;" />
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Max. Listas Email:</label>
          </div>
          <input type="text" name="maxlist" style="width:30px;" />
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Max. Base de datos MySQL:</label>
          </div>
          <input type="text" name="maxsql" style="width:30px;" />
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Max. Subdominios:</label>
          </div>
          <input type="text" name="maxsubdomain" style="width:30px;" />
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Max. Dominios Apuntados:</label>
          </div>
          <input type="text" name="maxpark" style="width:30px;" />
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Max. Dominios Agregados:</label>
          </div>
          <input type="text" name="maxaddon" style="width:30px;" />
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Max. Transferencia:</label>
          </div>
          <input type="text" name="maxbwlimit" style="width:30px;" />
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Paquete:</label>
          </div>
          <select name="package">
            <option value="--">Seleccione un paquete</option>
            <option value="DeRemate">DeRemate</option>
            <option value="Exchange_Hosting">Exchange Hosting</option>
            <option value="MLibre">MLibre</option>
            <option value="Plan_Disenadores">Plan Disenadores</option>
            <option value="Plan_Diseno">Plan Diseno</option>
            <option value="Plan_Empresa">Plan Empresa</option>
            <option value="Plan_Inicio">Plan Inicio</option>
            <option value="Plan_Plus">Plan Plus</option>
            <option value="Plan_Resellers">Plan Resellers</option>
            <option value="Plan_Resellers_2">Plan Resellers 2</option>
            <option value="Promo_Pack">Promo Pack</option>
            <option value="Server_Virtual_1">Server Virtual 1</option>
            <option value="Server_Virtual_2">Server Virtual 2</option>
            <option value="Server_Virtual_3">Server Virtual 3</option>
            <option value="Zephia_Basico">Zephia_Basico</option>
          </select>
        </div>
        <div class="control">
          <div class="label_add">
            <label for="id_tipo_pago">Theme:</label>
          </div>
          <select name="rs">
            <option value="argentina">argentina</option>
            <option value="brasil">brasil</option>
            <option value="chile">chile</option>
            <option value="colombia">colombia</option>
            <option value="conidiomas">conidiomas</option>
            <option value="espana">espana</option>
            <option value="ferozo">ferozo</option>
            <option value="int">int</option>
            <option value="mexico">mexico</option>
            <option value="paneldecontrol">paneldecontrol</option>
            <option value="paraguay">paraguay</option>
            <option value="personalizado">personalizado</option>
            <option value="peru">peru</option>
            <option value="uruguay">uruguay</option>
            <option value="usa">usa</option>
            <option value="venezuela">venezuela</option>
          </select>
        </div>
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
<div class="bloque_sin_degrade" style="padding-bottom: 0px;">
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
        <div id="btns_ok_cancel"><a href="#" id="btn_cancel"><img src="imagenes/btn_cancel.jpg" alt="" border="0" /></a>
          <input type="image" src="imagenes/btn_ok.jpg" alt="" hspace="5" border="0" />
        </div>
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
</form>
</body>
</html>
