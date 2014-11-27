Event.observe(window, 'load', windowLoaded);

function windowLoaded(){

	var mysql;
	var sql = "";
	
	var check = false;
	
	var campos = new Array();

	if($F('id_newsletters_temp') != ""){

		sql = "SELECT campo,valor FROM newsletters_temp_datos WHERE id_newsletters_temp = "+$F('id_newsletters_temp');

		mysql = new MySQLDatabase();

		mysql.query(sql);

		if(mysql.getNumRows() > 0){
			
			while(mysql.nextRow()){
				//alert(mysql.getField("campo")+' '+mysql.getField("valor"));
				campos[mysql.getField("campo")] = mysql.getField("valor");
			}
			
			check = true;
		}
	}
	
	cambiarTemplate(campos["template"]);
	
	if(check){
		
		var f = $('form_newsletter');
		
		for(i=0; i < f.elements.length; i++){
				
			campo = f.elements[i];
			
			if(campo.name != "id_newsletters_temp"){
					
				if(typeof(campos[campo.name]) == "undefined"){
					campos[campo.name] = "";
				}
	
	//alert(campo.type+' '+campo.name+' '+campo.value+' '+campos[campo.name]);
					
				if(campo.name == "descripcion"){
					FCKeditorAPI.GetInstance("descripcion").SetHTML(campos[campo.name]);
				}else if(campo.name == "descripcion_blanco"){
					FCKeditorAPI.GetInstance("descripcion_blanco").SetHTML(campos[campo.name]);
				}else{
					switch(campo.type){
						case "radio":
							campo.checked = (campo.value == campos[campo.name]) ? true : false;
							break;
						case "checkbox":
							campo.checked = (campo.value == campos[campo.name]) ? true : false;
							break;
						default:
							campo.value = campos[campo.name];
							break;
					}
				}
			}
		}
	}
}