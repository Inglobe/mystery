<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<style>
* {font-family : Verdana, Arial, Helvetica, sans-serif; font-size : 13px; }
</style>
<LINK REL="STYLESHEET" HREF="#css_link#" TYPE="text/css">
<LINK REL="SHORTCUT ICON" HREF="#LTChatTemplatePath#/img/shortcut.bmp">
<SCRIPT language="JavaScript">
   var room = "#room#";
   var private_id = '#private_id#';
   var datatype = 'all_data';
   var refresh_after = '#refresh_after#';
   var ChatTemplatePath = '#LTChatTemplatePath#';
   var change_room_msg = '#LTChatRoomChangeMsg#';
</SCRIPT>

  <script language="JavaScript" type="text/javascript" src="#LTChatTemplatePath#chat_commands_handle.js"></script>
  <script language="JavaScript" type="text/javascript" src="#LTChatTemplatePath#chat_functions.js"></script>
</head>
<body bgcolor="#71828A" leftmargin=0 topmargin=0>
<table  width="100%" height="100%" border="0">
  <tr>
    <td>
      <table  width="100%" height="100%" >
      <tr>
        <td>
			<TABLE border="0"  cellspacing="0" cellpadding="0" width="100%" height="100%">
			<tr>
			<td height="6px;">
			  <table width="100%" border="0" style='height:6px;' cellspacing="0"> 
			  <tr>
			    <td background="#LTChatTemplatePath#img/chat_box/lt.bmp" style='width:4px;'></td>
			    <td bgcolor="White" style=""></td>
			    <td background="#LTChatTemplatePath#img/chat_box/rt.bmp" style='width:5px;'></td>
			  </tr>
			  </table>
			</td>
			</tr>
			<tr>
			  <td bgcolor="White" style="padding-left:5px;padding-right:5px;border-right:1px #7A7B7B solid;">
			    <table width="100%" height="100%">
			    <tr>
			      <td height="10px">
			    	<div id='room' ></div>
                  </td>
                </tr>
			    <tr>
			      <td>
                    <IFRAME style='width:100%;height:100%;' frameborder="0" scrolling="true" name="IFRAME_TEXT" id="IFRAME_TEXT" src='iframe.php?type=chat_frame'></IFRAME>
                  </td>
                </tr>
                </table>
			  </td>
			</tr>
			<tr>
			<td height="6px;">
			    <table width="100%" border="0" style='height:7px;' cellspacing="0"> 
			    <tr>
			      <td background="#LTChatTemplatePath#img/chat_box/lb.bmp"	style='width:5px;'></td>
			      <td bgcolor="White" style=""></td>
			      <td background="#LTChatTemplatePath#img/chat_box/rb.bmp" style='width:5px;'></td>
			    </tr>
			    </table>
			  </td>
			</tr>
			</TABLE>
        </td>
      </tr>
      <tr>
        <td height="70px;">
      	<TABLE border="0"  cellspacing="0" cellpadding="0" width="100%" height="100%">
		<tr>
		<td height="6px;">
		  <table width="100%" border="0" style='height:6px;' cellspacing="0"> 
		  <tr>
		    <td background="#LTChatTemplatePath#img/chat_box/lt.bmp" style='width:4px;'></td>
		    <td bgcolor="White" style=""></td>
		    <td background="#LTChatTemplatePath#img/chat_box/rt.bmp" style='width:5px;'></td>
		  </tr>
		  </table>
		</td>
		</tr>
		<tr>
		  <td bgcolor="White" style="padding-left:5px;padding-right:5px;border-right:1px #7A7B7B solid;">
           <TEXTAREA style='width:100%;height:100%;font-size:12px;' name='message' id='message' onkeypress="if(this.value.length > 255) this.value = this.value.substring(0, 255);" onKeyup="if(!isNS4){  key_u(event.keyCode);  } else { key_u(event.which);}"></TEXTAREA>
		  </td>
		</tr>
		<tr>
		<td height="6px;">
		    <table width="100%" border="0" style='height:7px;' cellspacing="0"> 
		    <tr>
		      <td background="#LTChatTemplatePath#img/chat_box/lb.bmp"	style='width:5px;'></td>
		      <td bgcolor="White" style=""></td>
		      <td background="#LTChatTemplatePath#img/chat_box/rb.bmp" style='width:5px;'></td>
		    </tr>
		    </table>
		  </td>
		</tr>
		</TABLE>
        </td>
      </tr>
      </table>
    </td>
    <td width="19%">
		<TABLE border="0"  cellspacing="0" cellpadding="0" width="100%" height="100%">
		<tr>
		<td height="6px;">
		  <table width="100%" border="0" style='height:6px;' cellspacing="0"> 
		  <tr>
		    <td background="#LTChatTemplatePath#img/chat_box/lt.bmp" style='width:4px;'></td>
		    <td bgcolor="White" style=""></td>
		    <td background="#LTChatTemplatePath#img/chat_box/rt.bmp" style='width:5px;'></td>
		  </tr>
		  </table>
		</td>
		</tr>
		<tr>
		  <td bgcolor="White" style="padding-left:5px;padding-right:5px;border-right:1px #7A7B7B solid;">
		    <table width="100%" height="100%">
		    <tr><td>
		    <IFRAME style='width:100%;height:100%;' frameborder="0" name="LTuser_status" id="LTuser_status" scrolling="auto" src='iframe.php?type=users_list'></IFRAME>
		    </td></tr></table>
		  </td>
		</tr>
		<tr>
		<td height="6px;">
		    <table width="100%" border="0" style='height:7px;' cellspacing="0"> 
		    <tr>
		      <td background="#LTChatTemplatePath#img/chat_box/lb.bmp"	style='width:5px;'></td>
		      <td bgcolor="White" style=""></td>
		      <td background="#LTChatTemplatePath#img/chat_box/rb.bmp" style='width:5px;'></td>
		    </tr>
		    </table>
		  </td>
		</tr>
		</TABLE>
    </td>
  </tr>    
</table>

</body>