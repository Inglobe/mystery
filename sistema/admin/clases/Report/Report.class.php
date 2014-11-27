<?php
class Report{
	public $data = array();
	public $groupData = array();
	public $dataHeaders = array();
	public $dataUsers = array();
	public $showDate = true;
	public $showUser = true;
	public $showPageNums = true;
	public $showPrintDialog = false;
	public $orientation;
	public $registersPerPage;
	public $useJavascript = false;
	public $showUsers = false;

	private $nombre;
	private $lineasTexto = array();
	private $footerTotals = array();

	function Report($nombre,$orientacion=0){
		$this->nombre = $nombre;

		$this->orientation = $orientacion;
		if($orientacion == 1){
			$this->registersPerPage = 28;
		}
		else{
			$this->registersPerPage = 40;
		}
	}

	public function addTextLine($titulo, $texto){
		$mat_linea["titulo"] = $titulo;
		$mat_linea["texto"] = $texto;

		$this->lineasTexto[] = $mat_linea;
	}

	public function addFooterTotal($nombre, $numero){
		$mat_footer["nombre"] = $nombre;
		$mat_footer["numero"] = $numero;

		$this->footerTotals[] = $mat_footer;
	}

	private function renderHeader(){
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$this->nombre?></title>
<?
if($this->useJavascript){
?>
<script type="text/javascript" src="clases/Report/js/prototype.js"></script>
<script type="text/javascript" src="clases/Report/js/Report.class.js"></script>
<script type="text/javascript">
// <![CDATA[
	Event.observe(window, 'load', function() {
	    reporte = new Report('<?=$_SERVER["PHP_SELF"]?>');
	    reporte.show();
	});
// ]]>
</script>
<?
}
?>
<link href="clases/Report/css/reporte.css" rel="stylesheet" type="text/css" />
</head>
<body <?
	if($this->showPrintDialog && !$this->useJavascript){
		echo 'onload="window.print()"';
	}
?>>
<div id="contenedor" style="width: <?=($this->orientation==1?"1050":"620")?>px;">
	<?
	}
	private function renderTextLines(){
	?>
	<div class="datos">
	<?
		foreach($this->lineasTexto as $linea){
		?>
			<div class="linea_datos">
				<div class="subtit"><?=$linea["titulo"]?>:</div>
				<div class="dato"><?=$linea["texto"]?></div>
			</div>
		<?
		}
	?>
	</div>
	<?
	}
	private function renderFooterTotals(){
		foreach($this->footerTotals as $footer_total){
		?>
			<div class="total">
				<div class="recuadrito_total"><?=$footer_total["numero"]?></div>
				<div class="tit_total"><?=$footer_total["nombre"]?></div>
			</div>
		<?
		}
	}

	private function renderPages(){

		global $link;

		if(count($this->data) == 0){
			$cont_tmp = 0;
			foreach($this->groupData as $grupo){
				foreach($grupo["data"] as $fila_tmp){
					$cont_tmp++;
				}
			}
			$nro_registros = $cont_tmp;
		}
		else{
			$nro_registros = count($this->data);
		}

		$nro_paginas=ceil($nro_registros/$this->registersPerPage);

		if($nro_registros == 0){
		?>
		  <div class="header">
			<div class="logo"><img src="clases/Report/img/logo_print.png" alt="" height="70" /></div>
			<div class="fecha">
				<?
				if($this->showDate){
				?>
					<strong>Fecha: </strong><?=date("d/m/Y H:i:s")?><br />
				<?
				}
				if($this->showUser){
					$usr = mysql_fetch_array(mysql_query("SELECT * FROM usuarios WHERE id_usuario=".$_SESSION["id_usr"],$link));
				?>
					<strong>Usuario: </strong><?=$usr["nombre"]?><br />
				<?
				}
				?>
			</div>
			<?
			if($this->showUsers){
			?>
			<div class="usuarios">
			  <ul>
			<?
				foreach($this->dataUsers as $usuario){
			?>
				<li><div class="cont_usuario"><img src="imagen.php?ruta=../imagenes/usuarios/fotos/<?=$usuario["foto"]?>&amp;ancho=50&amp;alto=49&amp;mantener_ratio=1" alt="<?=$usuario["nombre"]?>"><span><?=ucfirst($usuario["user"])?></span></div></li>
			<?
				}
			?>
			  </ul>
			</div>
		  </div>
			<?
			}
			?>
			<h1><?=$this->nombre?></h1>
			<div id="no_data"><img src="clases/Report/img/ico_no_data.gif" alt="" /> No se encontraron registros!.</div>
		<?
		}
		else{
			$ultimo_reg_grupo = true;
			$cont_registros_grupo = 0;
			$cont_grupo = 0;
			for($pagina=1;$pagina<=$nro_paginas;$pagina++){
				$cont_registros=0;
	            $nro_columnas = count($this->dataHeaders);

			?>
			<div class="header">
				<div class="logo"><img src="clases/Report/img/logo_print.png" alt="" /></div>
				<div class="fecha">
				<?
				if($this->showDate){
				?>
					<strong>Fecha: </strong><?=date("d/m/Y H:i:s")?><br />
				<?
				}
				if($this->showUser){
					$usr = mysql_fetch_array(mysql_query("SELECT * FROM usuarios WHERE id_usuario=".$_SESSION["id_usr"],$link));
					echo mysql_error($link);
				?>
					<strong>Usuario: </strong><?=$usr["nombre"]?><br />
				<?
				}
				if($this->showPageNums){
				?>
					<strong>P&aacute;gina: </strong><?=$pagina?> de <?=$nro_paginas?>
				<?
				}
				?>
				</div>
				<?
				if($this->showUsers){
				?>
				<div class="usuarios">
				  <ul>
				<?
				foreach($this->dataUsers as $usuario){
				?>
					<li><div class="cont_usuario"><img src="imagen.php?ruta=../imagenes/usuarios/fotos/<?=$usuario["foto"]?>&amp;ancho=50&amp;alto=49&amp;mantener_ratio=1" alt="<?=$usuario["nombre"]?>"><span><?=ucfirst($usuario["user"])?></span></div></li>
				<?
				}
				?>
				  </ul>
				</div>
			  </div>
				<?
			}
				?>
				<h1><?=$this->nombre?></h1>
			<?
				$this->renderTextLines();
			?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<thead>
					  <tr>
					  <?
					  foreach($this->dataHeaders as $col_header){
					  ?>
					    <th><?=$col_header?></th>
					  <?
					  }
					  ?>
					  </tr>
					</thead>
					<tbody>
				<?
							reset($this->groupData);

				 while($cont_registros<$this->registersPerPage){

	            	$cont_registros++;
	            	$cont_registros_grupo++;

					if(count($this->data) != 0){
	            		list($clave_reg, $fila) = each($this->data);
	            	}else{
	            		if($ultimo_reg_grupo){
	            			$cont_grupo++;

	            			list($clave_grupo, $grupo) = each($this->groupData);
							$ultimo_reg_grupo = false;
							if($cont_grupo <= count($this->groupData)){
						?>
					  <tr>
					    <th colspan="<?=$nro_columnas?>"><?=$grupo["titulo"]?></th>
					  </tr>
						<?
							}
						}
	            		if(is_array($grupo["data"])){
	            			if($cont_registros_grupo == count($grupo["data"])){
		            			$ultimo_reg_grupo = true;
		            			$cont_registros_grupo = 0;
		            		}
	            			list($clave_reg, $fila) = each($grupo["data"]);
	            		}

					}
				?>
					  <tr>
					<?

					for($col=0;$col<$nro_columnas;$col++){
						if(is_array($fila)){
							list($clave_col, $valor) = each($fila);
						}
						else{
							$valor = "&nbsp;";
						}
					?>
					  <td><?=($valor!=""?$valor:"&nbsp;")?></td>
					<?

					}
					?>
					  </tr>
				<?
					if(count($this->groupData) != 0){
						if($ultimo_reg_grupo){
						?>
					  <tr>
					    <td colspan="<?=$nro_columnas?>" align="right" class="td_subtototales"><table border="0" cellpadding="0" cellspacing="0">
					    	<?
					    	foreach($grupo["subtotalData"] as $subtotal){
					    	?>
						  <tr>
						    <th align="right"><?=$subtotal["nombre"]?>:</th>
						    <td><?=$subtotal["numero"]?></td>
						  </tr>
							<?
							}
							?>
						</table></td>
					  </tr>
						<?
						}
					}
				  }
				?>

					</tbody>
				</table>
			<?
			}
			$this->renderFooterTotals();
		}
	}

	private function renderFooter(){
	?>
</div>
</body>
</html>
	<?
	}

	private function xmlcharacters($string, $trans='') {
		$trans=(is_array($trans))? $trans:get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
		foreach ($trans as $k=>$v)
			$trans[$k]= "&#".ord($k).";";
		return strtr($string, $trans);
	}

	private function renderXML(){
		header("Content-Type: text/xml; charset=iso-8859-1");

		echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\n";
		echo "<raiz>\n";

		echo "\t<informacion>\n";
		echo "\t\t<nombre>".$this->xmlcharacters($this->nombre)."</nombre>\n";
		echo "\t\t<fecha>".$this->xmlcharacters(date("d/m/Y H:i:s"))."</fecha>\n";
		echo "\t\t<orientation>".$this->xmlcharacters($this->orientation)."</orientation>\n";
		echo "\t\t<showPageNums>".$this->xmlcharacters(($this->showPageNums?"true":"false"))."</showPageNums>\n";
		echo "\t\t<showPrintDialog>".$this->xmlcharacters(($this->showPrintDialog?"true":"false"))."</showPrintDialog>\n";
		echo "\t\t<showDate>".$this->xmlcharacters(($this->showDate?"true":"false"))."</showDate>\n";
		echo "\t</informacion>\n";

		for($i=0;$i<count($this->lineasTexto);$i++){
			echo "\t\t<linea_texto>";
			echo "\t\t\t<titulo>".$this->xmlcharacters($this->lineasTexto[$i]["titulo"])."</titulo>\n";
			echo "\t\t\t<texto>".$this->xmlcharacters($this->lineasTexto[$i]["texto"])."</texto>\n";
			echo "\t\t</linea_texto>\n";
		}

		for($i=0;$i<count($this->dataHeaders);$i++){
			echo "\t<columna>";
			echo $this->xmlcharacters($this->dataHeaders[$i]);
			echo "\t</columna>\n";
		}

		foreach($this->data as $fila){
			echo "\t<fila>\n";
			$claves=array_keys($fila);
			foreach($claves as $clave){
				if(!is_integer($clave)){
					echo "\t\t<".$clave.">";
					echo $this->xmlcharacters($fila[$clave]);
					echo "</".$clave.">\n";
				}
			}
			echo "\t</fila>\n";
		}

		for($i=0;$i<count($this->footerTotals);$i++){
			echo "\t\t<footer_total>";
			echo "\t\t\t<nombre>".$this->xmlcharacters($this->footerTotals[$i]["nombre"])."</nombre>\n";
			echo "\t\t\t<numero>".$this->xmlcharacters($this->footerTotals[$i]["numero"])."</numero>\n";
			echo "\t\t</footer_total>\n";
		}

		echo "</raiz>";
	}

	private function checkCSVData($datos){
		foreach($datos as $valor){
			$valor = str_replace('"',"",$valor);
			$valor = str_replace("\n","",$valor);
			$valor = str_replace("\r","",$valor);

			$mat_salida[] = $valor;
		}

		return $mat_salida;
	}

	public function show(){
		if(isset($_GET["xml_mode"])){
			$this->renderXML();
		}
		else{
			$this->renderHeader();
			if(!$this->useJavascript){
				$this->renderPages();
			}
			$this->renderFooter();
		}
	}

	public function downloadCSV($separador = ";"){
		if(count($this->data) != 0){

			$csv = '"'.implode('"'.$separador.'"',$this->dataHeaders).'"'."\n";

			foreach($this->data as $fila){
				$csv .= '"'.implode('"'.$separador.'"',$this->checkCSVData($fila)).'"'."\n";
			}

			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Cache-Control: public');
			header('Content-Description: File Transfer');
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="'.$this->nombre.'.csv"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.strlen($csv));

			echo $csv;
		}
		else{
			require("lib/zip.lib.php");

			$archivo_zip = new zipfile();

			foreach($this->groupData as $grupo){
				$csv = '"'.implode('"'.$separador.'"',$this->dataHeaders).'"'."\n";

				foreach($grupo["data"] as $fila){
					$csv .= '"'.implode('"'.$separador.'"',$this->checkCSVData($fila)).'"'."\n";
				}

				$archivo_zip->addFile($csv, $grupo["titulo"].".csv");
			}

			$salida = $archivo_zip->file();

			header('Content-Type: application/octet-stream');
			header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			header('Content-Disposition: inline; filename="'.$this->nombre.'.zip"');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: '.strlen($salida));

			echo $salida;
		}
	}
}

?>