<div id="title">
  <h1><span>Sistema</span><span class="title_separator">/</span><span class="dark_color">Newsletters</span><span class="title_separator">/</span><span class="light_color">Crear</span></h1>
</div>
<form action="index.php?put=newsletters_create_process" method="post" name="form_newsletter" id="form_newsletter" enctype="multipart/form-data">
  <input type="hidden" name="action" value="edit" id="action" />
  <div class="block">
    <div class="subtit">
      <h4>Datos</h4>
    </div>
    <div class="input">
      <div class="label_add">
        <label for="asunto">Fecha:</label>
      </div>
      <div class="field_add">
        <input type="text" id="datepicker" name="sent_date" value="<?=date("d/m/Y",time())?>" maxlength="10" />
        <script>
datePickerController.createDatePicker({ 
        // Associate the text input to a DD/MM/YYYY date format    
		 "lang":"es",                        
        formElements:{"datepicker":"%d/%m/%Y"}
        }); 
    </script> 
      </div>
    </div>
    <div class="input">
      <div class="label_add">
        <label for="email_from">E-mail from:</label>
      </div>
      <div class="field_add">
        <input type="text" value="<?=$parametros->newsletter_from_email?>" id="email_from" name="email_from" size="40">
      </div>
    </div>
    <div class="input">
      <div class="label_add">
        <label for="nombre_from">Nombre from:</label>
      </div>
      <div class="field_add">
        <input type="text" value="<?=$parametros->newsletter_from_name?>" id="nombre_from" name="name_from" size="40">
      </div>
    </div>
    <div class="input">
      <div class="label_add">
        <label for="email_reply">E-mail respuesta:</label>
      </div>
      <div class="field_add">
        <input type="text" value="<?=$parametros->newsletter_reply_email?>" id="email_reply" name="email_reply" size="40">
      </div>
    </div>
    <div class="input">
      <div class="label_add">
        <label for="asunto">Asunto:</label>
      </div>
      <div class="field_add">
        <input type="text" value="" id="subject" name="subject" size="100">
      </div>
    </div>
  </div>
  <div id="tabs">
    <div class="tab"><a href="#" class="active" id="editor_tab"><span>Editar</span><img src="images/ico_tab_edit.png" width="18" height="25" alt="" /></a> </div>
    <div class="union_tab"><span></span></div>
    <div class="tab"><a href="#" id="import_tab"><span>Importar</span><img src="images/ico_tab_import.png" width="19" height="25" alt="" /></a> </div>
    <div class="end_tab"><span></span></div>
  </div>
  <div class="block">
    <?
			require("newsletters_create_editor.inc.php");
		?>
  </div>
  <div id="cont_btns_ok_cancel">
    <div id="btns_ok_cancel">
      <div class="button gradient_theme"><a href="#" id="preview_btn">Vista preliminar</a></div>
      <div class="button gradient_theme"><a href="#" id="create_btn">Crear</a></div>
    </div>
  </div>
</form>
<script type="text/javascript" src="js_library/newsletter_crear.js"></script>