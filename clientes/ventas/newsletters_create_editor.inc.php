<script type="text/javascript" src="../includes/tiny_mce/tiny_mce.js"></script>
<div id="newsletter_create">
  <div class="subtit">
	<h4>Encabezados</h4>
  </div>

  <?
	if($gestor = opendir('../newsletters/default_template/headers')){
		$i=0;
		while (false !== ($archivo = readdir($gestor))){
			if($archivo!="." && $archivo!=".."){
				$tmp=explode(".",$archivo);
				foreach($tmp as $valor){
					$extension=strtolower($valor);
				}
				if($extension=="jpg" || $extension=="gif"){
					$i++;
    ?>
                    <div class="encabezado">
					  <input id="header_<?=$i?>" name="header" type="radio" value="<?=$archivo?>" <?
            		if($i==1)
            			echo "checked";
	?>/>
					  <label for="header_<?=$i?>"><img src="imagen.php?ruta=../newsletters/default_template/headers/<?=$archivo?>&amp;ancho=577" width="577" alt="" /></label>
					</div>
                    <?
		  	  	}
			}
		}
		closedir($gestor);
	}
  ?>  
  <div class="subtit" style="padding-top:20px;">
	<h4>Cuerpo</h4>
  </div>
  <div class="input">
	<div class="label_add">
	  <label for="descripcion">Descripci&oacute;n:</label>
	</div>
	<div class="field_add">
	  <script type="text/javascript">
		// <![CDATA[
			tinyMCE.init({
				// General options
				mode : "exact",
				elements : "description",
				theme : "advanced",
				skin : "o2k7",
				language : "es",
				plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

				// Theme options
				theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				file_browser_callback : "tinyBrowser"
			});
		// ]]>
	  </script>
	  <textarea name="description" id="description" cols="45" rows="5"></textarea>
	</div>
  </div>
  <? /*
  <div class="input">
	<div class="label_add">
	  <label for="email_from">Buscar Publicaciones:</label>
	</div>
	<div class="field_add">
	  <input type="text" value="" id="email_from" name="email_from" size="50">
	</div>
  </div>
  <div class="newsletters_publications_list">
	<div class="title">T&iacute;tulo</div>
	<div class="item"><span>
	  <input name="" type="checkbox" value="" />
	  </span> T&iacute;tulo de publicaci&oacute;n</div>
	<div class="item"><span>
	  <input name="" type="checkbox" value="" />
	  </span> T&iacute;tulo de publicaci&oacute;n</div>
	<div class="item"><span>
	  <input name="" type="checkbox" value="" />
	  </span> T&iacute;tulo de publicaci&oacute;n</div>
	<div class="item"><span>
	  <input name="" type="checkbox" value="" />
	  </span> T&iacute;tulo de publicaci&oacute;n</div>
	<div class="item"><span>
	  <input name="" type="checkbox" value="" />
	  </span> T&iacute;tulo de publicaci&oacute;n</div>
  </div>
  */ ?>
</div>