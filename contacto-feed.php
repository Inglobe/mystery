<?php
	require_once("generar_form.inc.php");
?>

<div id="header_seccion"> <img src="imagenes/img_header_contacto.png" width="182" height="157" alt="" style="padding-top:60px; padding-left:70px;" />
  <h1><span>Contacto</span></h1>
</div>
<div id="fondo_secciones">
  <div id="col_izq_seccion">
    <p class="texto_resaltado">Complet&aacute; el formulario <br />
      y dejanos tus consultas. <br />
      Te contestaremos a la brevedad, muchas gracias.</p>
    <?php include("datos_contacto.inc.php"); ?>
  </div>
  <div id="col_der_seccion">
    <div id="form_contacto">
      <div style="padding-top:100px; padding-bottom:100px; text-align:center;">
        <p>Gracias por su consulta.<br />
          Nos comunicaremos con usted a la brevedad.</p>
        <div><a href="index.php?put=home"><img src="imagenes/btn_ok.png" style="padding-top:10px;" alt="" /></a></div>
      </div>
    </div>
  </div>
</div>
