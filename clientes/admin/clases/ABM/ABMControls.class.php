<?php

	if(!defined('CONFIG') && !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_DATABASE);
	
	class ABMControls extends database_format {
	
		var $nombre;
		var $nombre_form;
		var $id_javascript;
		var $css_class;
		var $on_change;
		var $desactivar;
		var $on_keypress;
	
		function __construct($nombre,$id_javascript="",$nombre_form="",$css_class="",$on_change="",$desactivar=false){
		
			parent::__construct();
		
			$this->nombre = $nombre;
			$this->id_javascript = $id_javascript;
			$this->css_class = $css_class;
			$this->on_change = $on_change;
			$this->desactivar = $desactivar;
			$this->nombre_form = $nombre_form;
			$this->on_keypress = '';
		}
	
		public function createTextField($valor,$caracteres_aceptados,$mascara="",$ancho=0,$maximo=0){
			require(PATH_ABM_CONTROLS_TEXT);
		}
	
		public function createPassField($valor){
			require(PATH_ABM_CONTROLS_PASS);
		}
		
		public function createHiddenField($valor){
			require(PATH_ABM_CONTROLS_HIDDEN);
		}
		
		public function createTextArea($valor,$caracteres_aceptados,$mascara="",$columnas=0,$filas=0){
			require(PATH_ABM_CONTROLS_TEXTAREA);
		}
	
		public function createRichText($valor,$alto){
			require(PATH_ABM_CONTROLS_RICHTEXT);
		}
	
		public function createCombo($consultaSQL,$id_db,$campo_mostrar,$id_seleccionado,$item_ninguno=""){
			require(PATH_ABM_CONTROLS_COMBO);
		}
	
		public function createDatePicker($valor,$permitir_nulo=false,$valor_check=0){
			require(PATH_ABM_CONTROLS_DATE);
		}
	
		public function createPictureBox($valor,$ruta){
			require(PATH_ABM_CONTROLS_PICTURE);
		}
	
		public function createFileBox($valor,$ruta){
			require(PATH_ABM_CONTROLS_FILE);
		}
	
		public function createCheckBoxRadio($valor){
			require(PATH_ABM_CONTROLS_CHECK);
		}	
		
		public function createPhotogallery($id_rel,$abm){
			require(PATH_ABM_PHOTO_GALLERY);
		}
	}
?>