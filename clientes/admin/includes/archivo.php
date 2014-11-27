<table border="0" cellspacing="0" cellpadding="0" class="box_imagenes">
  <tr>
    <td><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input type="file" name="data_<? echo $nombre_archivo; ?>" />
        </td>
      </tr>
      <tr>
        <td height="20" valign="bottom"><?
						if(${$nombre_archivo}=="")
							echo "--ninguno--";
						else
							echo "<a href=\"".$path.${$nombre_archivo}."\">".${$nombre_archivo}."</a>";
						?></td>
      </tr>
    </table></td>
  </tr>
</table>
