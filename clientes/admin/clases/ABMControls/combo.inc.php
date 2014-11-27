<?php
	echo "<select ";
	
	if($this->css_class != ""){
		echo "class=\"".$this->css_class."\" ";
	}
	
	echo "name=\"".$this->nombre."\" ";
	
	if($this->desactivar){
		echo "disabled ";
	}
	
	if($this->on_change != ""){
		echo " onchange=\"".$this->on_change."\" ";
	}
	
	if($this->id_javascript != ""){
		echo " id=\"".$this->id_javascript."\" ";
	}
	
	echo ">\n";
	
	if($item_ninguno != ""){
		echo "<option value=\"0\">".$item_ninguno."</option>\n";
	}

	if(strpos($id_db,".") === false){
		$id_limpio = $id_db;
	}else{
		$id_limpio = substr($id_db,strpos($id_db,".")+1);
	}

	$this->query($consultaSQL);
	
	while($this->fetch()){
	
		echo "<option value=\"".$this->getValue($id_limpio)."\" ";
		
		if($id_seleccionado == $this->getValue($id_limpio)){
			echo 'selected="selected"';
		}
		
		echo ">".$this->getValue($campo_mostrar)."</option>\n";
	}

	echo "</select>\n";
?>