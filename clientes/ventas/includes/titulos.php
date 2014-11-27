  <div id="title">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><h1><?=$titulo_abm?></h1></td>
        <td class="title_separator">/</td>
        <td><h1 class="dark_color"><?=$sub_titulo_abm?></h1></td>
        <td class="title_separator">/</td>
        <td><h1 class="light_color"><?
	        switch($accion){
	        	case "a":
					echo "Agregar";
					break;
				case "m":
					echo "Modificar";
					break;
				case "d":
					echo "Eliminar";
					break;
				case "s":
					echo "Buscar";
					break;
			}
		?></h1></td>
      </tr>
    </table>
  </div>
