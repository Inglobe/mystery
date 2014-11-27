<input id="<?=$nombre_campo?>_text" type="text" name="q" value="Buscar publicacion..." style="width: 320px" />
<div id="<?=$nombre_campo?>_cont" class="autocomplete" style="display: none;"></div>
<script type="text/javascript">
	new Ajax.Autocompleter('<?=$nombre_campo?>_text','<?=$nombre_campo?>_cont','newsletters_buscar_publicaciones.php', { tokens: ',', afterUpdateElement: updateHidden} );
	
	function updateHidden(txt, li){
	
		var exist = true;
		
		var temp;
		
		try{
			$("<?=$nombre_campo?>["+li.id+"]").checked = true;
		}catch(e){
			exist = false;
		}
		
		if(!exist){
			
			var table = $('<?=$nombre_campo?>_lista');
			
			var tr = document.createElement("tr");
			tr.setAttribute("class","lista_oscura");
			
			var td1 = document.createElement("td");
			td1.setAttribute("width","1%");
			td1.setAttribute("align","center");
			
			var input;
			
			try{
				input = document.createElement('<input name="<?=$nombre_campo?>['+li.id+']">');
			}catch(e){
				input = document.createElement("input");
				input.setAttribute("name","<?=$nombre_campo?>["+li.id+"]");
			}
			
			input.setAttribute("id","<?=$nombre_campo?>["+li.id+"]");
			input.setAttribute("type","checkbox");
			input.setAttribute("value",li.id);
			input.setAttribute("checked","checked");
			
			var td3 = document.createElement("td");
			td3.setAttribute("width","89%");
			td3.setAttribute("align","left");
			td3.innerHTML = li.innerHTML;

			td1.appendChild(input);
			
			tr.appendChild(td1);
			tr.appendChild(td3);
			
			table.appendChild(tr);
			
			$("<?=$nombre_campo?>["+li.id+"]").checked = true;
			$("<?=$nombre_campo?>_text").value = "Buscar publicacion...";
		}	
		
		$("txt_buscar").blur();
	}
	
	$("<?=$nombre_campo?>_text").onfocus = function(){
		if($F(this) == "Buscar publicacion..."){
			this.value = "";
		}
	}
	
	$("<?=$nombre_campo?>_text").onblur = function(){
		this.value = "Buscar publicacion...";
	}
	
</script>

<table width="95%"  border="0" cellpadding="0" cellspacing="1" style="margin-top: 20px">
	<tbody id="<?=$nombre_campo?>_lista">
		<tr class="lista_oscura">
			<td>
				Seleccionar
			</td>
			<td>
				Titulo
			</td>
		</tr>
		<?
			if(isset($_GET['id']) && ($_GET['id'] != "")){
			
				$sql = "
					SELECT
						datos.*
					FROM
						(
							SELECT
								valor AS id_publicacion
							FROM
								newsletters_temp_datos
							WHERE
								id_newsletters_temp = ".$_GET['id']." AND
								campo LIKE 'publicaciones[%'
						) guardados INNER JOIN (
							SELECT
								publicaciones.id_publicacion AS id_publicacion,
								categorias.descripcion AS categoria,
								publicaciones.titulo AS publicacion
							FROM
								publicaciones INNER JOIN categorias ON (
									publicaciones.id_categoria = categorias.id_categoria
								)
							WHERE
								publicaciones.newsletter_interno = 1
							ORDER BY
								categorias.descripcion ASC,
								publicaciones.fecha ASC
						) datos ON (
							guardados.id_publicacion = datos.id_publicacion
						)
				";
				
				$result = mysql_query($sql,$link);
			
				if(mysql_num_rows($result) > 0){
			
					while($row_news = mysql_fetch_array($result)){
		?>
		<tr class="lista_oscura">
			<td width="1%" align="center">
				<input name="<?=$nombre_campo?>[<?=$row_news["id_publicacion"]?>]" id="<?=$nombre_campo?>[<?=$row_news["id_publicacion"]?>]" type="checkbox" value="<?=$row_news["id_publicacion"]?>"/>
			</td>
			<td width="89%" align="left">
				<?=$row_news["categoria"]?> &gt; <?=$row_news["publicacion"]?>
			</td>
		</tr>
		<?
					}
				}
			}
		?>
	</tbody>
</table>