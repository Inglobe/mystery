<?php
class Report{

	public $data = array();
	public $groupData = array();
	public $dataHeaders = array();
	public $showDate = true;
	public $showPagesNums = true;
	public $showPrintDialog = false;
	public $orientation;
	public $registersPerPage;

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
<script type="text/javascript" src="clases/Report/js/prototype.js"></script>
<script type="text/javascript" src="clases/Report/js/Report.class.js"></script>
<link href="clases/Report/css/reporte.css" rel="stylesheet" type="text/css" />
</head>
<body <?
	if($this->showPrintDialog){
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
			<div id="logo"><img src="clases/Report/img/logo_print.png" alt="" height="70" /></div>
			<div id="fecha">
				<?
				if($this->showDate){
				?>
					<strong>Date: </strong><?=date("d/m/Y H:i:s")?><br />
				<?
				}
				?>
				</div>
			<h1><?=$this->nombre?></h1>
			<div id="no_data"><img src="clases/Report/img/ico_no_data.gif" alt="" /> The requested data was not found!.</div>
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
				<div id="logo"><img src="clases/Report/img/logo_print.png" alt="" height="70" /></div>
				<div id="fecha">
				<?
				if($this->showDate){
				?>
					<strong>Date: </strong><?=date("d/m/Y H:i:s")?><br />
				<?
				}
				if($this->showPagesNums){
				?>
					<strong>Page: </strong><?=$pagina?> of <?=$nro_paginas?>
				<?
				}
				?>
				</div>
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
		$this->renderHeader();
		//$this->renderPages();
		$this->renderFooter();
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