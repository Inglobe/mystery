<?
class ABMAddEdit{

	//PARAMETROS
	var $nombre;
	var $tabla;
	var $nombre_id;
	var $categoria;
	var $titulo;
	var $accion;
	var $id_modificar;

	//INTERNAS
	private $linkDB;
	private $campos = array();
	private $debug;


	function ABMAddEdit($linkDB,$nombre,$tabla,$nombre_id,$categoria,$titulo,$accion,$id_modificar=0,$debug=false){
		$this->linkDB = $linkDB;
		$this->nombre = $nombre;
		$this->tabla = $tabla;
		$this->nombre_id = $nombre_id;
		$this->categoria = $categoria;
		$this->titulo = $titulo;
		$this->accion = $accion;
		$this->id_modificar = $id_modificar;
		$this->debug = $debug;
	}

	public function addTextField($label,$nombre_db,$valor,$caracteres_aceptados,$mascara="",$ancho=0,$maximo=0,$validar=true,$texto_alert=""){

		$mat_campo["label"] = $label;
		$mat_campo["nombre_db"] = $nombre_db;
		$mat_campo["valor"] = $valor;
		$mat_campo["validar"] = $validar;
		$mat_campo["texto_alert"] = $texto_alert;
		$mat_campo["tipo"] = "text";
		$mat_campo["text_caracteres_aceptados"] = $caracteres_aceptados;
		$mat_campo["text_mascara"] = $mascara;
		$mat_campo["text_ancho"] = $ancho;
		$mat_campo["text_maximo"] = $maximo;

		$this->campos[] = $mat_campo;
	}

	public function addPassField($label,$nombre_db,$valor){

		$mat_campo["label"] = $label;
		$mat_campo["nombre_db"] = $nombre_db;
		$mat_campo["valor"] = $valor;
		$mat_campo["tipo"] = "pass";

		$this->campos[] = $mat_campo;
	}

	public function addTextArea($label,$nombre_db,$valor,$caracteres_aceptados,$mascara="",$columnas=0,$filas=0,$validar=true,$texto_alert=""){

		$mat_campo["label"] = $label;
		$mat_campo["nombre_db"] = $nombre_db;
		$mat_campo["valor"] = $valor;
		$mat_campo["tipo"] = "textarea";
		$mat_campo["validar"] = $validar;
		$mat_campo["texto_alert"] = $texto_alert;
		$mat_campo["textarea_caracteres_aceptados"] = $caracteres_aceptados;
		$mat_campo["textarea_mascara"] = $mascara;
		$mat_campo["textarea_columnas"] = $columnas;
		$mat_campo["textarea_filas"] = $filas;

		$this->campos[] = $mat_campo;
	}

	public function addRichText($label,$nombre_db,$valor,$alto){

		$mat_campo["label"] = $label;
		$mat_campo["nombre_db"] = $nombre_db;
		$mat_campo["valor"] = $valor;
		$mat_campo["tipo"] = "richtext";
		$mat_campo["richtext_alto"] = $alto;

		$this->campos[] = $mat_campo;
	}

	public function addCombo($label,$nombre_db,$linkDB,$consultaSQL,$id_db,$campo_mostrar,$valor,$item_ninguno="",$validar=true,$texto_alert=""){

		$mat_campo["label"] = $label;
		$mat_campo["nombre_db"] = $nombre_db;
		$mat_campo["valor"] = $valor;
		$mat_campo["tipo"] = "combo";
		$mat_campo["validar"] = $validar;
		$mat_campo["texto_alert"] = $texto_alert;
		$mat_campo["combo_linkDB"] = $linkDB;
		$mat_campo["combo_consultaSQL"] = $consultaSQL;
		$mat_campo["combo_id_db"] = $id_db;
		$mat_campo["combo_campo_mostrar"] = $campo_mostrar;
		$mat_campo["combo_item_ninguno"] = $item_ninguno;

		$this->campos[] = $mat_campo;
	}

	public function addDate($label,$nombre_db,$valor,$permitir_nulo=false,$valor_check=0){

		$mat_campo["label"] = $label;
		$mat_campo["nombre_db"] = $nombre_db;
		$mat_campo["valor"] = $valor;
		$mat_campo["tipo"] = "date";
		$mat_campo["date_permitir_nulo"] = $permitir_nulo;
		$mat_campo["date_valor_check"] = $valor_check;

		$this->campos[] = $mat_campo;
	}

	public function addFoto($label,$nombre_db,$valor,$ruta){

		$mat_campo["label"] = $label;
		$mat_campo["nombre_db"] = $nombre_db;
		$mat_campo["valor"] = $valor;
		$mat_campo["tipo"] = "foto";
		$mat_campo["validar"] = true;
		$mat_campo["foto_ruta"] = $ruta;

		$this->campos[] = $mat_campo;
	}

	public function addFile($label,$nombre_db,$valor,$ruta){

		$mat_campo["label"] = $label;
		$mat_campo["nombre_db"] = $nombre_db;
		$mat_campo["valor"] = $valor;
		$mat_campo["tipo"] = "file";
		$mat_campo["validar"] = true;
		$mat_campo["file_ruta"] = $ruta;

		$this->campos[] = $mat_campo;
	}

	public function addCheckBox($label,$nombre_db,$valor){

		$mat_campo["label"] = $label;
		$mat_campo["nombre_db"] = $nombre_db;
		$mat_campo["valor"] = $valor;
		$mat_campo["tipo"] = "checkBox";

		$this->campos[] = $mat_campo;
	}

	public function addHTML($label,$codigo){

		$mat_campo["label"] = $label;
		$mat_campo["HTML_codigo"] = $codigo;
		$mat_campo["tipo"] = "HTML";

		$this->campos[] = $mat_campo;
	}

	private function renderHeaders(){
		?>
		<script type="text/javascript" src="../includes/eventListener.js"></script>
		<script type="text/javascript" src="../includes/inputMask.js"></script>
		<script type="text/javascript" src="clases/ABMControls/datePicker/scripts/fsdateselect.js"></script>
		<link type="text/css" rel="stylesheet" href="clases/ABMControls/datePicker/styles/fsdateselect.css" />
		<script type="text/javascript">
		//<![CDATA[
			function validar(f){
			<?
				foreach($this->campos as $campo){
					if($campo["validar"]){
						switch($campo["tipo"]){
							case "text":
							case "textarea":

							?>
								if(f.<?="texto_".$campo["nombre_db"]?>.value == ""){
									alert("<?=$campo["texto_alert"]?>");
									f.<?="texto_".$campo["nombre_db"]?>.focus();
									return false;
								}
							<?
							break;
							case "combo":
							?>
								if(f.<?="combo_".$campo["nombre_db"]?>.value == 0){
									alert("<?=$campo["texto_alert"]?>");
									f.<?="combo_".$campo["nombre_db"]?>.focus();
									return false;
								}
							<?
							break;
							case "foto":
							?>
								var extensiones_permitidas = new Array(".jpg",".JPG");
								var archivo = f.<?="foto_".$campo["nombre_db"]?>.value;
								var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
								var permitida = false;
								for (var i = 0; i < extensiones_permitidas.length; i++) {
									if (extensiones_permitidas[i] == extension) {
										permitida = true;
										break;
									}
								}
								if(!permitida && archivo != ""){
									alert("Sólo se pueden subir archivos: " + extensiones_permitidas.join());
									return false;
								}
							<?
							break;
						}
					}
				}
			?>
				return true;
			}

		    var r = new Restrict("form_<?=$this->nombre?>");

		    r.onKeyRefuse = function(o, k){
		        o.style.backgroundColor = "#fdc";
		    }
		    r.onKeyAccept = function(o, k){
		        if(k > 30)
		            o.style.backgroundColor = "#ffffff";
		    }
		//]]>
		</script>
		<?
	}

	private function renderTitulos(){
		?>
		<div id="titulo">
	      <h1>
			  <span><?=$this->categoria?></span><span class="separador_tit">/</span><span class="gris"><?=$this->titulo?></span><span class="separador_tit">/</span><span class="gris_claro"><?=$this->accion == "a"?"Agregar":"Modificar"?></span>
		  </h1>
	    </div>
		<?
	}

	private function renderSolapas(){
		?>
		<div id="solapas">
			<?
			if($this->accion == "m"){
				?>
				<div id="solapa_modify"><a href="index.php?put=<?=$this->nombre?>_am&abm_accion=m"><img src="skins/gris/es/solapa_modificar_on.gif" alt="Agregar" border="0" /></a></div>
				<?
		  	}
		  	?>

		  <div id="solapa_add"><a href="index.php?put=<?=$this->nombre?>_am&abm_accion=a"><img src="skins/gris/es/solapa_agregar_<?=$this->accion=="a"?"on":"off"?>.gif" alt="Agregar" border="0" /></a></div>
		  <div id="solapa_search"><a href="index.php?put=<?=$this->nombre?>_search&abm_accion=s"><img src="skins/gris/es/solapa_buscar_off.gif" alt="Buscar" border="0" /></a></div>
		</div>
		<?
	}

	private function renderCampos(){
		require("ABMControls.class.php");

		foreach($this->campos as $campo){
			?>
			<div class="control">
				<label for="<?=$campo["tipo"]."_".$campo["nombre_db"]?>"><?=$campo["label"]?></label>
			<?
			switch($campo["tipo"]){
				case "text":
					$control = new ABMControls("texto_".$campo["nombre_db"],"texto_".$campo["nombre_db"],"form_".$this->nombre);
					$control->createTextField($campo["valor"],$campo["text_caracteres_aceptados"],$campo["text_mascara"],$campo["text_ancho"],$campo["text_maximo"]);
				break;
				case "pass":
					$control = new ABMControls("pass_".$campo["nombre_db"],"pass_".$campo["nombre_db"],"form_".$this->nombre);
					$control->createPassField("");
				break;
				case "textarea":
					$control = new ABMControls("texto_".$campo["nombre_db"],"texto_".$campo["nombre_db"],"form_".$this->nombre);
					$control->createTextArea($campo["valor"],$campo["textarea_caracteres_aceptados"],$campo["textarea_mascara"],$campo["textarea_columnas"],$campo["textarea_filas"]);
				break;
				case "richtext":
					$control = new ABMControls("texto_".$campo["nombre_db"],"texto_".$campo["nombre_db"],"form_".$this->nombre);
					$control->createRichText($campo["valor"],$campo["richtext_alto"]);
				break;
				case "combo":
					$control = new ABMControls("combo_".$campo["nombre_db"],"combo_".$campo["nombre_db"],"form_".$this->nombre);
					$control->createCombo($campo["combo_linkDB"],$campo["combo_consultaSQL"],$campo["combo_id_db"],$campo["combo_campo_mostrar"],$campo["valor"],$campo["combo_item_ninguno"]);
				break;
				case "date":
					$aux = explode("-",$campo["valor"]);
					$campo["valor"] = $aux[2]."/".$aux[1]."/".$aux[0];
					$control = new ABMControls("date_".$campo["nombre_db"],"date_".$campo["nombre_db"],"form_".$this->nombre);
					$control->createDatePicker($campo["valor"],$campo["date_permitir_nulo"],$campo["date_valor_check"]);
				break;
				case "foto":
					$control = new ABMControls("foto_".$campo["nombre_db"],"foto_".$campo["nombre_db"],"form_".$this->nombre);
					$control->createPictureBox($campo["valor"],$campo["foto_ruta"]);
				break;
				case "file":
					$control = new ABMControls("data_".$campo["nombre_db"],"data_".$campo["nombre_db"],"form_".$this->nombre);
					$control->createFileBox($campo["valor"],$campo["file_ruta"]);
				break;
				case "checkBox":
					$control = new ABMControls("check_".$campo["nombre_db"],"check_".$campo["nombre_db"],"form_".$this->nombre);
					$control->createCheckBoxRadio($campo["valor"]);
				break;
				case "HTML":
					echo $campo["HTML_codigo"];
				break;
			}
			?>
          	</div>
			<?
		}

	}

	private function loadData(){
		$db_consulta="SELECT * FROM ".$this->tabla." WHERE ".$this->nombre_id." = ".$this->id_modificar;
		$result_consulta = mysql_query($db_consulta,$this->linkDB);
		echo mysql_error($this->linkDB);
		if($result_consulta){
			$fila = mysql_fetch_array($result_consulta);
			$i=0;
			foreach($this->campos as $campo){
				$this->campos[$i]["valor"]=$fila[$campo["nombre_db"]];
				$i++;
			}
		}
	}

	public function show(){
		if($this->accion == "m"){
			$this->loadData();
		}
		$this->renderHeaders();
		$this->renderTitulos();
		$this->renderSolapas();
	?>
	<div id="contenedor_feed" style="display: <?=isset($_GET["feed"])?"":"none"?>">
	  <div id="feed">
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td width="16" align="left" valign="middle"><img src="imagenes/ico_info.gif" alt="" width="10" height="11" /></td>
	        <td><?
	          	  switch($_GET["feed"]){
	          	  	  case "a":
	          	  	  	  echo "Se agregó un registro.";
	          	  	  break;
				  }
			  ?></td>
	      </tr>
	    </table>
	  </div>
	</div>
	<div id="contenido">
	  <form action="index.php?put=<?=$this->nombre?>_procesar&amp;abm_accion=<?=$this->accion?>&amp;id=<?=$this->id_modificar?>" method="post" enctype="multipart/form-data" name="form_<?=$this->nombre?>" id="form_<?=$this->nombre?>" onsubmit="return validar(this)">
	  <div id="recuadro">
		<?
			$this->renderCampos();
		?>
		<div id="botones">
			<a href="index.php?put=<?=$this->nombre?>_search"><img src="skins/gris/es/btn_cancelar.gif" alt="" border="0" /></a>
			<input type="image" src="skins/gris/es/btn_ok.gif" alt="" hspace="5" border="0" />
		</div>
  	  </div>
  	  </form>
    </div>
    <script type="text/javascript">
	//<![CDATA[
	    r.start();
	//]]>
	</script>
		<?
	}
}
?>