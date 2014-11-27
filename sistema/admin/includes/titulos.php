  <div id="titulo">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><h1><?=$titulo_abm?></h1></td>
        <td class="separador_tit">/</td>
        <td><h1 class="gris"><?=$sub_titulo_abm?></h1></td>
        <td class="separador_tit">/</td>
        <td><h1 class="gris_claro"><?
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
				default:
					echo $titulo_opcion;
			}
		?></h1></td>
      </tr>
    </table>
  </div>
