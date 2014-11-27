<div id="title">
  <h1> <span>Sistema</span><span class="title_separator">/</span><span class="dark_color">Newsletters</span><span class="title_separator">/</span><span class="light_color">Enviar</span> </h1>
</div>
<form action="index.php?put=newsletters_send_process&amp;id=<?=$data->get("id",DATA_EX_TYPE_INT)?>" method="post">
  <div class="block">
    <div class="block_top">
      <div class="cont_bg_block_top_left">
        <div class="bg_block_top_left"><span></span></div>
      </div>
      <div class="cont_bg_block_top_right">
        <div class="bg_block_top_right"><span></span></div>
      </div>
    </div>
    <div class="border_block_left">
      <div class="border_block_right">
        <div class="block_body" style="padding-top:15px; padding-left:30px; padding-right:30px; padding-bottom:25px;">
		  <div id="tit_newsletter_send">Enviar: <strong>
		    <?
		  $db_tmp = new database_format;
		  $db_tmp->query("SELECT subject FROM newsletters WHERE id_newsletter = ".$data->get("id",DATA_EX_TYPE_INT));
		  $db_tmp->fetch();
		  echo $db_tmp->getXHTMLValue("subject");		  
		  ?>
		  </strong></div>
          <div class="subtit">
            <h4>
              <? /*<input type="radio" name="radio" id="radio" value="radio" />*/ ?>
              Grupos:</h4>
          </div>
          <div id="list_groups">
		  <?
		  $db_list = new database_format;
		  $db_list->query("SELECT * FROM groups WHERE enabled = 1 ORDER BY description ASC");
		  while($db_list->fetch()){
		  ?>
            <div class="item">
              <input name="groups[]" id="item_grup_<?=$db_list->getValue("id_group")?>" type="checkbox" value="<?=$db_list->getValue("id_group")?>" />
              <label for="item_grup"><?=$db_list->getXHTMLValue("description")?></label>
            </div>
          <?
		  }
		  ?>
          </div>
          <? /*<div class="subtit">
            <h4>
              <input type="radio" name="radio" id="radio2" value="radio" />
              E-mail de prueba:</h4>
          </div>
          E-mail: <span class="field_add">
          <input type="text" value="" id="email_respuesta2" name="email_respuesta2" size="50" /> 
		  */ ?>
          </span></div> 
      </div>
    </div>
    <div class="block_footer">
      <div class="cont_bg_block_footer_left">
        <div class="bg_block_footer_left"><span></span></div>
      </div>
      <div class="cont_bg_block_footer_right">
        <div class="bg_block_footer_right"><span></span></div>
      </div>
    </div>
  </div><div id="cont_btns_ok_cancel">
  <div id="btns_ok_cancel">
    <div class="button gradient_theme"><a href="index.php?put=newsletters_create">Cancelar</a></div>
    <input name="Submit" type="submit" value="Enviar" />
  </div>
  </div>
</form>
