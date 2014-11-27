<?
$id = $data->get("id",DATA_EX_TYPE_INT);
?>
<div id="title">
  <h1> <span>Sistema</span><span class="title_separator">/</span><span class="dark_color">Newsletters</span><span class="title_separator">/</span><span class="light_color">Crear</span> </h1>
</div>
<div id="feed_newsletters">
  <p>El newsletter se cre&oacute; correctamente!..</p>
  <div style="padding-left:290px;">
    <div class="button gradient_theme"><a href="index.php?put=newsletters_queue">Pendientes</a></div>
    <div class="button gradient_theme"><a href="newsletters_view.php?id=<?=$id?>" target="_blank">Ver</a></div>
    <div class="button gradient_theme"><a href="index.php?put=newsletters_send&amp;id=<?=$id?>">Enviar</a></div>
    <div class="button gradient_theme"><a href="newsletters_save.php?id=<?=$id?>">Descargar HTML</a></div>
  </div>
</div>
