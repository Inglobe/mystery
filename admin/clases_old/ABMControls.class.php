<?php
class ABMControls{

	var $nombre;
	var $nombre_form;
	var $id_javascript;
	var $css_class;
	var $on_change;
	var $desactivar;

	function ABMControls($nombre,$id_javascript="",$nombre_form="",$css_class="",$on_change="",$desactivar=false){
		$this->nombre = $nombre;
		$this->id_javascript = $id_javascript;
		$this->css_class = $css_class;
		$this->on_change = $on_change;
		$this->desactivar = $desactivar;
		$this->nombre_form = $nombre_form;
	}

	public function createTextField($valor,$caracteres_aceptados,$mascara="",$ancho=0,$maximo=0){
		include("ABMControls/textField.inc.php");
	}

	public function createPassField($valor){
		include("ABMControls/passField.inc.php");
	}

	public function createTextArea($valor,$caracteres_aceptados,$mascara="",$columnas=0,$filas=0){
		include("ABMControls/textArea.inc.php");
	}

	public function createRichText($valor,$alto){
		include("ABMControls/richText.inc.php");
	}

	public function createCombo($linkDB,$consultaSQL,$id_db,$campo_mostrar,$id_seleccionado,$item_ninguno=""){
		include("ABMControls/combo.inc.php");
	}

	public function createDatePicker($valor,$permitir_nulo=false,$valor_check=0){
		include("ABMControls/datePicker.inc.php");
	}

	public function createPictureBox($valor,$ruta){
		include("ABMControls/pictureBox.inc.php");
	}

	public function createFileBox($valor,$ruta){
		include("ABMControls/fileBox.inc.php");
	}

	public function createCheckBoxRadio($valor){
		include("ABMControls/checkBoxRadio.inc.php");
	}
}
?>