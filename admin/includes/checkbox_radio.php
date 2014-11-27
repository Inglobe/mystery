					  <?=$texto_check?>:
					  <table border="0" cellpadding="0" cellspacing="0" class="checkboxs">
                        <tr>
                          <td width="80" valign="top">
							<input id="check_<?=$nombre_check?>_si" type="radio" name="check_<?=$nombre_check?>" value="1" <?=((${$nombre_check}==1)?"checked=\"checked\"":"")?> />
							<label for="check_<?=$nombre_check?>_si">Si</label>
							<input id="check_<?=$nombre_check?>_no" type="radio" name="check_<?=$nombre_check?>" value="0" <?=((${$nombre_check}==0)?"checked=\"checked\"":"")?> />
							<label for="check_<?=$nombre_check?>_no">No</label>
				  		  </td>
                          <td width="3">&nbsp;</td>
                        </tr>
                      </table>