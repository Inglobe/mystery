nsp='This page requires a browser version 3.0 or newer !';
dl=document.layers;
oe=window.opera?1:0;
da=document.all&&!oe;
ge=document.getElementById;
ws=window.sidebar?true:false;
izN=navigator.userAgent.toLowerCase().indexOf('netscape')>=0?true:false;
if(ws&&!izN){quogl='iuy'};
var msg='';
function nem(){return true};
window.onerror = nem;

var FSstrNoneText,FSstrLangID,FSstrImagePath;
var FSblnDisableNone,FSblnIsShown;
var FSintHposOffset,FSintVposOffset;
var FSobjDateRef,FSobjSelectorRef,FSobjCalendarArea;
var FSdtToday,FSdtSeasonStart,FSdtSeasonEnd;
var FSintFormatMode=1;
var FSintOneMinute=60 * 1000;
var FSintOneHour=FSintOneMinute * 60;
var FSintOneDay=FSintOneHour * 24;
var FSintSelectedDay=0;
var FSintSelectedMonth=0;
var FSintSelectedYear=0;
var FSintCurrentMonth=0;
var FSintCurrentYear=0;
var FSblnBlockBrowser=false;
var FSblnIEwin=false;
if (navigator.userAgent.indexOf("Gecko")>0) {
	FSstrBrowser="Gecko";
	document.onclick=FSfncHideDateSelector;
}
else {
	FSstrBrowser="IE";
	document.onclick=function() {
		FSfncHideDateSelector(event)
	}
}
if (navigator.userAgent.indexOf("Safari")>0) {
	FSblnBlockBrowser=true;
}
if (navigator.userAgent.indexOf("MSIE 5.0")>0) {
	FSblnBlockBrowser=true;
}
if ((navigator.userAgent.indexOf("MSIE")>0) && (navigator.userAgent.indexOf("Windows")>0) && (navigator.userAgent.indexOf("Opera")<=0)) {
	FSblnIEwin=true;
}
function FSfncShowDateSelector(DateRef,EventRef,DisableNone,LangID,ImagePath,hposOffset,vposOffset) {
	if (FSblnIsShown) {return} else {FSblnIsShown=true}
	FSintHposOffset=hposOffset;
	FSintVposOffset=vposOffset;
	if (document.getElementById) {
		if (!FSobjSelectorRef) {
			// first show tasks
			FSdtToday=new Date();
			FSdtToday.setHours(0,0,0,0);
			FSfncWriteSelectorHTML();
			FSobjSelectorRef=document.getElementById("FSdateSelector");
			FSobjCalendarArea=document.getElementById("FScalendarArea");
		}
		FSobjDateRef=eval(DateRef);
		FSblnDisableNone=DisableNone;
		FSstrLangID=LangID;
		FSstrImagePath=ImagePath;
		switch (FSstrLangID) {
			case "FR":
				FSstrNoneText='Aucune';
				FSintFormatMode=1;
			break;
			case "DE":
				FSstrNoneText='Kein';
				FSintFormatMode=1;
			break;
			case "ES":
				FSstrNoneText='Ninguna';
				FSintFormatMode=1;
				break;
			case "ESUS":
				FSstrNoneText='Ninguna';
				FSintFormatMode=0;
			break;
			case "US":
				FSstrNoneText='None';
				FSintFormatMode=0;
				break;
			default:
				FSstrNoneText='None';
				FSintFormatMode=1;
		}
		//FSdtSeasonStart=new Date(FSdtToday.getTime() - (FSintOneDay * 184));
		//FSdtSeasonEnd=new Date(FSdtToday.getTime() + (FSintOneDay * 182));
		FSintSelectedDay=0;
		if (FSobjDateRef.value==FSstrNoneText) {
			if (FSobjDateRef.defaultValue==FSstrNoneText) {
				var arrCurrentDate=FSfncDateToString(FSdtToday).split("/");
				FSintSelectedMonth=arrCurrentDate[0 + FSintFormatMode] - 1;
			}
			else {
				var arrCurrentDate=FSobjDateRef.defaultValue.split("/");
				FSintSelectedDay=arrCurrentDate[1 - FSintFormatMode];
				FSintSelectedMonth=arrCurrentDate[0 + FSintFormatMode] - 1;
			}
		}
		else {
			var arrCurrentDate=FSobjDateRef.value.split("/");
			FSintSelectedDay=arrCurrentDate[1 - FSintFormatMode];
			FSintSelectedMonth=arrCurrentDate[0 + FSintFormatMode] - 1;
		}
		FSintSelectedYear=arrCurrentDate[2];
		FSintCurrentMonth=parseInt(FSintSelectedMonth,10);
		FSintCurrentYear=parseInt(FSintSelectedYear,10);
		FSobjCalendarArea.innerHTML=FSfncCreateCalendarArea();
		if (FSstrBrowser=="Gecko") {
			FSobjSelectorRef.style.left=(EventRef.clientX + checkScrollValues("left") - 90 + hposOffset) + "px";
			FSobjSelectorRef.style.top=(EventRef.clientY + checkScrollValues("top") + 8 + vposOffset) + "px";
		}
		else {
			if ((FSblnIEwin) && (document.compatMode!="BackCompat")) {
				var pxLeft=-3;
			}
			else {
				var pxLeft=0;
			}
			FSobjSelectorRef.style.left=(pxLeft + EventRef.clientX - EventRef.offsetX - 82 + checkScrollValues("left") + hposOffset) + "px";
			FSobjSelectorRef.style.top=(EventRef.clientY - EventRef.offsetY + 16 + checkScrollValues("top") + vposOffset) + "px";
		}
		FSobjSelectorRef.style.visibility="visible";
	}
}
function checkScrollValues(ScrollDirection) {
	if (ScrollDirection=="left") {
		if ((document.body) && (document.body.scrollLeft>0)) {return document.body.scrollLeft}
		if ((document.documentElement) && (document.documentElement.scrollLeft>0)) {return document.documentElement.scrollLeft}
		return 0;
	}
	else {
		if ((document.body) && (document.body.scrollTop>0)) {return document.body.scrollTop}
		if ((document.documentElement) && (document.documentElement.scrollTop>0)) {return document.documentElement.scrollTop}
		return 0;
	}
}
function FSfncHideDateSelector(TheEvent) {
	if (FSobjSelectorRef) {
		if (FSstrBrowser=="Gecko") {
			if (TheEvent) {
				var ThisIcon="FSdsIcon_" + FSobjDateRef.name;
				var rel = TheEvent.target;
				while (rel) {if ((rel.id=="FSdateSelector") || (rel.id==ThisIcon)) {break} else {rel=rel.parentNode}}
				}
			if (!rel) {FSobjSelectorRef.style.visibility="hidden"; FSblnIsShown=false}
			return;
		}
		else {
			if ((TheEvent)) {
				// check not clicked on calendar
				if ((TheEvent.clientX+checkScrollValues("left")>FSobjSelectorRef.style.posLeft+1) &&
					(TheEvent.clientX+checkScrollValues("left")<FSobjSelectorRef.style.posLeft+FSobjSelectorRef.style.posWidth+10) &&
					(TheEvent.clientY+checkScrollValues("top")>FSobjSelectorRef.style.posTop+1) &&
					(TheEvent.clientY+checkScrollValues("top")<FSobjSelectorRef.style.posTop+FSobjSelectorRef.offsetHeight+2)
					) {return}
				// check not clicked on icon
				if ((TheEvent.clientX+checkScrollValues("left")>FSobjSelectorRef.style.posLeft+81-FSintHposOffset) &&
					(TheEvent.clientX+checkScrollValues("left")<FSobjSelectorRef.style.posLeft+99-FSintHposOffset) &&
					(TheEvent.clientY+checkScrollValues("top")>FSobjSelectorRef.style.posTop-17-FSintVposOffset) &&
					(TheEvent.clientY+checkScrollValues("top")<FSobjSelectorRef.style.posTop-FSintVposOffset)
					) {return}
			}
			FSobjSelectorRef.style.visibility="hidden";
			FSblnIsShown=false;
		}
	}
	else {FSobjSelectorRef=false}
}
function FSfncCreateCalendarArea() {
	switch (FSstrLangID) {
		case "FR":
			var arrDayNames=new Array("Lun","Mar","Mer","Jeu","Ven","Sam","Dim");
			var arrMonthNames=new Array("Janvier","F&eacute;vrier","Mars","Avril","Mai","Juin","Juillet","Ao&ucirc;t","Septembre","Octobre","Novembre","D&eacute;cembre");
			var strTodayLabel="Auj";
			var strNoValue="Aucune";
			break;
		case "DE":
			var arrDayNames=new Array("Mon","Die","Mit","Don","Fre","Sam","Son");
			var arrMonthNames=new Array("Januar","Februar","M&auml;rz","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember");
			var strTodayLabel="Heute";
			var strNoValue="Kein";
			break;
		case "ES" :
		case "ESUS":
			var arrDayNames=new Array("Lun","Mar","Mi&eacute;","Jue","Vie","S&aacute;b","Dom");
			var arrMonthNames=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			var strTodayLabel="Hoy";
			var strNoValue="Ninguna";
			break;
		default:
			var arrDayNames=new Array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
			var arrMonthNames=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
			var strTodayLabel="Today";
			var strNoValue="None";
	}
	var dtFirstOfMonth=new Date(FSintCurrentYear,FSintCurrentMonth,1);
	var intTimeOffset=FSfncGetTimeOffset();
	if (Math.abs(intTimeOffset)>8) {dtFirstOfMonth.setHours(-intTimeOffset,0,0,0)}
	switch (dtFirstOfMonth.getDay()) {
		case 0: var OffsetDays=6; break;
		case 1: var OffsetDays=7; break;
		default: var OffsetDays=dtFirstOfMonth.getDay() - 1;
	}
	OffsetDays-=(FSintFormatMode - 1);
	var dtCalendarStart=new Date(dtFirstOfMonth.getTime() - (FSintOneDay * OffsetDays)); dtCalendarStart.setHours(12);
	var dtCalendarEnd=new Date(dtCalendarStart.getTime() + (FSintOneDay * 41)); dtCalendarEnd.setHours(12);
	strCalendar='<TABLE BORDER="0" CELLPADDING="2" CELLSPACING="0" CLASS="FScalendar">';
	strCalendar+="<TR CLASS='FScalendarTitles' ALIGN='center'>";
	for (var i=0; i<=6; i++) {
		intArrayPointer=i + (FSintFormatMode - 1);
		if (intArrayPointer<0) {intArrayPointer=6}
		strCalendar+="<TD WIDTH='22'>" + arrDayNames[intArrayPointer] + "</TD>"
	}
	strCalendar+="</TR>";
	for (var i=0; i<=41; i++) {
		if (i % 7 == 0) {strCalendar+="<TR ALIGN='center'>"}
		var StyleString="";
		var dtTheDay=new Date(dtCalendarStart.getTime() + (FSintOneDay * i));
		dtTheDay.setHours(0,0,0,0);
		if (dtTheDay.getTime()==FSdtToday.getTime()) {
			if ((dtTheDay.getMonth()==FSintSelectedMonth) && (dtTheDay.getDate()==FSintSelectedDay) && (dtTheDay.getFullYear()==FSintSelectedYear)) {StyleString+="background-image: url(" + FSstrImagePath + "today_selected.gif); background-repeat:no-repeat; "}
			else {StyleString+="background-image: url(" + FSstrImagePath + "today.gif); background-repeat:no-repeat; "}
		}
		else if ((dtTheDay.getMonth()==FSintSelectedMonth) && (dtTheDay.getDate()==FSintSelectedDay) && (dtTheDay.getFullYear()==FSintSelectedYear)) {StyleString+="background-image: url(" + FSstrImagePath + "selected.gif); background-repeat:no-repeat; "}
		if (dtTheDay.getMonth()!=FSintCurrentMonth) {var LinkClass="FSnotInMonth"} else {var LinkClass="FSinMonth"}
		if (((FSdtSeasonStart) && (FSdtSeasonEnd)) && ((dtTheDay<FSdtSeasonStart) || (dtTheDay>FSdtSeasonEnd))) {strCalendar+="<TD CLASS='FSoutOfRange' STYLE='" + StyleString + "'>" + dtTheDay.getDate() + "</TD>"}
		else {strCalendar+="<TD STYLE='" + StyleString + "'><A HREF='Javascript: void FSfncSetDate(\"" + FSfncDateToString(dtTheDay) + "\")' CLASS='" + LinkClass + "'>" + dtTheDay.getDate() + "</A></TD>"}
		if (i%7==6) {strCalendar+="</TR>"}
	}
	strCalendar+="</TABLE>";
	var strMonthOptions="";
	var strSelected="";
	for (var i=0; i<=11; i++) {
		if (i==FSintCurrentMonth) {strSelected=" SELECTED"} else {strSelected=""}
		strMonthOptions+='<OPTION' + strSelected + '>' + arrMonthNames[i] + '</OPTION>';
	}
	if (FSblnDisableNone==true) {NoneButton='<IMG SRC="' + FSstrImagePath + FSstrLangID + '/but_none_dis.gif" WIDTH="44" HEIGHT="18" HSPACE="1">'}
	else {NoneButton='<INPUT TYPE="image" SRC="' + FSstrImagePath + FSstrLangID + '/but_none.gif" WIDTH="44" HEIGHT="18" HSPACE="1" onClick="FSfncSetDate(\'' + strNoValue + '\')">'}
	var strIFRAME="",strSTYLE="";
	if (FSblnIEwin) {
		if (document.compatMode=="BackCompat") {var pxWidth=198; var pxHeight=190} else {var pxWidth=204; var pxHeight=180}
		strIFRAME='<IFRAME SRC="includes/date_picker/scripts/IEFrameWarningBypass.htm" WIDTH="100" HEIGHT="100" FRAMEBORDER="0" STYLE="position:absolute; left:0px; top:0px; width:' + pxWidth + 'px; height:' + pxHeight + 'px; z-index:99"></IFRAME>';
		strSTYLE=' STYLE="position:absolute; left:0; top:0; width:100%; height:100%; z-index:100"';
	}
	strCalendar=strIFRAME + '<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" WIDTH="100%" HEIGHT="100%"' + strSTYLE + ' ID="FSmainTable">' +
		'<TR HEIGHT="22" CLASS="FSbuttonsRow">' +
		'<TD WIDTH="30" ALIGN="left"><INPUT TYPE="image" SRC="' + FSstrImagePath + 'but_prev.gif" WIDTH="18" HEIGHT="18" HSPACE="1" onClick="FSfncAdvanceDate(-1)"></TD>' +
		'<TD><SELECT NAME="FScurrentMonth" CLASS="FSmonthRolldown" onChange="FSfncChangeMonth(this.selectedIndex + 1)">'+ strMonthOptions +'</SELECT></TD>' +
		'<TD><INPUT TYPE="text" NAME="FScurrentYear" VALUE="' + FSintCurrentYear + '" READONLY CLASS="FSyearInput"></TD>' +
		'<TD><INPUT TYPE="image" SRC="' + FSstrImagePath + 'but_yeard.gif" WIDTH="18" HEIGHT="9" onClick="FSfncAdvanceDate(12)"><BR><INPUT TYPE="image" SRC="' + FSstrImagePath + 'but_yearu.gif" WIDTH="18" HEIGHT="9" onClick="FSfncAdvanceDate(-12)"></TD>' +
		'<TD WIDTH="30" ALIGN="right"><INPUT TYPE="image" SRC="' + FSstrImagePath + 'but_next.gif" WIDTH="18" HEIGHT="18" HSPACE="1" onClick="FSfncAdvanceDate(1)"></TD>' +
		'</TR>' +
		'<TR HEIGHT="133" BGCOLOR="#FFFFFF"><TD COLSPAN="5" ALIGN="center">' + strCalendar + '</TD></TR>' +
		'<TR HEIGHT="22" CLASS="FSbuttonsRow">' +
		'<TD COLSPAN="5">' +
		'<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">' +
		'<TR>' +
		'<TD ALIGN="left"><INPUT TYPE="image" SRC="' + FSstrImagePath + FSstrLangID + '/but_today.gif" WIDTH="44" HEIGHT="18" HSPACE="1" onClick="FSfncSetDate(FSfncDateToString(FSdtToday))"></TD>' +
		'<TD ALIGN="center" ID="FSdateToday">' + strTodayLabel + ': ' + FSfncDateToString(FSdtToday) + '</TD>' +
		'<TD ALIGN="right">' + NoneButton + '</TD>' +
		'</TR>' +
		'</TABLE>' +
		'</TD>' +
		'</TR>'
	return strCalendar;
}
function FSfncGetTimeOffset() {
	var rightNow = new Date();
	var date1 = new Date(rightNow.getFullYear(), 0, 1, 0, 0, 0, 0);
	var temp = date1.toGMTString();
	var date3 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	return (date1 - date3) / FSintOneHour;
}
function FSfncSetDate(TheDate) {
	var tempArray=TheDate.split("/");
	var resultingDate=new Date(tempArray[2],tempArray[0 + FSintFormatMode] - 1,tempArray[1 - FSintFormatMode]);
	if (((FSdtSeasonStart) && (FSdtSeasonEnd)) && ((resultingDate<FSdtSeasonStart) || (resultingDate>FSdtSeasonEnd))) {
		switch (FSstrLangID) {
			case "FR": alert("Veuillez choisir une d\u00E2te dans la gamme specifi\u00E9e"); break;
			case "DE": alert("Bitte ein Datum innerhalb des angegebenen Zeitraums w\u00E4hlen"); break;
			case "ES":
			case "ESUS": alert("Por favor, elija una fecha dentro del periodo especificado"); break;
			default: alert("Please select a date in the range specified");
			}
		return false;
	}
	FSintSelectedDay=0;
	FSobjDateRef.value=TheDate;
	FSobjDateRef.defaultValue=TheDate;
	FSfncHideDateSelector();
}
function FSfncAdvanceDate(Adjuster) {
	if ((Adjuster==12) || (Adjuster==-12)) {FSintCurrentYear=FSintCurrentYear + (Adjuster / 12)}
	else {
		FSintCurrentMonth=FSintCurrentMonth + Adjuster;
		if (FSintCurrentMonth==-1) {FSintCurrentMonth=11; FSintCurrentYear--}
		if (FSintCurrentMonth==12) {FSintCurrentMonth=0; FSintCurrentYear++}
	}
	FSobjCalendarArea.innerHTML=FSfncCreateCalendarArea();
}
function FSfncChangeMonth(Adjuster) {
	FSintCurrentMonth=Adjuster-1;
	FSobjCalendarArea.innerHTML=FSfncCreateCalendarArea();
}
function FSfncDateToString(TheDate) {
	if (!TheDate) {return ""}
	else {
		if (FSintFormatMode==1) {return (TheDate.getDate()<10 ? "0" + TheDate.getDate() : TheDate.getDate()) + "/" + (TheDate.getMonth()<9 ? "0" + (TheDate.getMonth() + 1) : (TheDate.getMonth() + 1)) + "/" + TheDate.getFullYear()}
		else {return (TheDate.getMonth()<9 ? "0" + (TheDate.getMonth() + 1) : (TheDate.getMonth() + 1)) + "/" + (TheDate.getDate()<10 ? "0" + TheDate.getDate() : TheDate.getDate()) + "/" + TheDate.getFullYear()}
	}
}
function FSfncMakeDate(TheDay,TheMonth,TheYear) {return new Date(TheYear,TheMonth - 1,TheDay)}
function FSfncCheckDate(thisDateField,LangID) {
	if (!LangID) {LangID=FSstrLangID}
	switch (LangID) {
		case "FR": FSstrNoneText='Aucune'; FSintFormatMode=1; var strFailText="Cette date n'est pas valable"; break;
		case "DE": FSstrNoneText='Keine'; FSintFormatMode=1; var strFailText="Dieses Datum ist ung\u00FCltig"; break;
		case "ES": FSstrNoneText='Ninguna'; FSintFormatMode=1; var strFailText="Esta fecha no es v\u00E1lida"; break;
		case "ESUS": FSstrNoneText='Ninguna'; FSintFormatMode=0; var strFailText="Esta fecha no es v\u00E1lida"; break;
		case "US": FSstrNoneText='None'; FSintFormatMode=0; var strFailText="Date is not valid"; break;
		default: FSstrNoneText='None'; FSintFormatMode=1; var strFailText="Date is not valid";
	}
	if (thisDateField.value=="") {thisDateField.value=FSstrNoneText}
	if ((thisDateField.value!=FSstrNoneText) && (!FSfncCheckDateFormat(thisDateField.value))) {alert(strFailText); thisDateField.value=thisDateField.defaultValue}
}
function FSfncCheckDateFormat(thisDate) {
	if (thisDate.indexOf("/")==-1) {return false}
	var ArrayDate = thisDate.split("/");
	if (ArrayDate.length!=3) {return false}
	if ((isNaN(ArrayDate[0])) || (ArrayDate[0]=="")) {return false}
	if ((isNaN(ArrayDate[1])) || (ArrayDate[1]=="")) {return false}
	if ((isNaN(ArrayDate[2])) || (ArrayDate[2]=="")) {return false}
	var daysInMonth = new Array(0,31,29,31,30,31,30,31,31,30,31,30,31);
	if ((parseInt(ArrayDate[1 - FSintFormatMode],10)<1) || (parseInt(ArrayDate[1 - FSintFormatMode],10)>daysInMonth[parseInt(ArrayDate[0 + FSintFormatMode],10)])) {return false}
	if ((parseInt(ArrayDate[0 + FSintFormatMode],10)==2) && (parseInt(ArrayDate[1 - FSintFormatMode],10)>FSfncDaysInFebruary(parseInt(ArrayDate[2],10)))) {return false}
	if ((parseInt(ArrayDate[0 + FSintFormatMode],10)<1) || (parseInt(ArrayDate[0 + FSintFormatMode],10)>12)) {return false}
	return true;
}
function FSfncDaysInFebruary(year) {return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 )}
function FSfncWriteSelectorHTML() {
	var selectorHTML='' +
		'<FORM ACTION="#" METHOD="GET" NAME="FSdateSelectorForm" onSubmit="return false">' +
		'<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="188" HEIGHT="194" ID="FSdateSelector" STYLE="width:190px; height:222px; position:absolute; left:0; top:0; visibility:hidden">' +
		'<TR><TD ID="FScalendarArea"></TD></TR>' +
		'</TABLE>' +
		'</FORM>';
	if (document.body && document.body.insertAdjacentHTML) {document.body.insertAdjacentHTML("BeforeEnd",selectorHTML)}
    else if (document.createRange) {var r=document.createRange(); r.setStartBefore(document.body); document.body.appendChild(r.createContextualFragment(selectorHTML))}
    else {document.body.innerHTML+=selectorHTML}
}
function FSfncWriteFieldHTML(FormName,FieldName,FieldValue,FieldWidth,ImagePath,LangID,DisableNone,UseOnClick,NotEnabled01,NotEnabled02,HposOffset,VposOffset,NotEnabled03) {
	if (!LangID) {LangID="EN"}
	if (!DisableNone) {DisableNone=false}
	if (ImagePath.charAt(ImagePath.length - 1)!="/") {ImagePath=ImagePath + "/"}
	if (!HposOffset) {HposOffset=0}
	if (!VposOffset) {VposOffset=0}
	if ((document.getElementById) && (FSblnBlockBrowser==false)) {
		// Preload common images
		var FSimg1=new Image(); FSimg1.src=ImagePath + "today_selected.gif";
		var FSimg2=new Image(); FSimg2.src=ImagePath + "today.gif";
		var FSimg3=new Image(); FSimg3.src=ImagePath + "selected.gif";
		var FSimg4=new Image(); FSimg4.src=ImagePath + "but_prev.gif";
		var FSimg5=new Image(); FSimg5.src=ImagePath + "but_yearu.gif";
		var FSimg6=new Image(); FSimg6.src=ImagePath + "but_yeard.gif";
		var FSimg7=new Image(); FSimg7.src=ImagePath + "but_next.gif";
		// Preload lang images
		var FSimg8=new Image(); FSimg8.src=ImagePath + LangID + "/but_today.gif";
		var FSimg9=new Image(); FSimg9.src=ImagePath + LangID + "/but_none.gif";
		var ActionString='FSfncShowDateSelector("document.' + FormName + '.' + FieldName + '",event,' + DisableNone + ',\'' + LangID + '\',\'' + ImagePath + '\',' + HposOffset + ',' + VposOffset + ')';
		if (UseOnClick==true) {
			var ActionEvent="onMouseDown=" + ActionString;
			switch (LangID) {
				case "FR": var IconAltText="Cliquez ici pour choisir une date"; break;
				case "DE": var IconAltText="Hier klicken, um ein Datum auszuw\u00E4hlen"; break;
				case "ES":
				case "ESUS": var IconAltText="Haga clic aqu\u00ED para seleccionar una fecha"; break;
				default: var IconAltText="Click here to select a date";
				}
			}
		else {
			var ActionEvent="onMouseOver=" + ActionString + " onMouseDown=" + ActionString;
			var IconAltText="";
			}
		var formFieldHTML='' +
			'<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" BGCOLOR="#FFFFFF" CLASS="FSdateSelect" ID="' + FieldName + 'FStable" WIDTH="' + FieldWidth + '" HEIGHT="22" STYLE="width:' + FieldWidth + 'px">' +
			'<TR>' +
			'<TD><INPUT TYPE="text" NAME="' + FieldName + '" VALUE="' + FieldValue + '" CLASS="FSdateField" SIZE="9" MAXLENGTH="10" onChange="FSfncCheckDate(this,\'' + LangID + '\')" onBlur="FSfncCheckDate(this,\'' + LangID + '\')"></TD>' +
			'<TD ALIGN="right"><A HREF="JavaScript: void 0" ' + ActionEvent + '><IMG SRC="' + ImagePath + 'calendar.gif" HEIGHT="16" WIDTH="16" HSPACE="3" BORDER="0" ALT="' + IconAltText + '" ID="FSdsIcon_' + FieldName + '"></A></TD>' +
			'</TR>' +
			'</TABLE>';
		document.write(formFieldHTML);
	}
	else {
		var formFieldHTML='<INPUT TYPE="text" NAME="' + FieldName + '" VALUE="' + FieldValue + '" SIZE="10" MAXLENGTH="10" onChange="FSfncCheckDate(this,\'' + LangID + '\')" onBlur="FSfncCheckDate(this,\'' + LangID + '\')" STYLE="width:' + FieldWidth + 'px; height:22px">'
		document.write(formFieldHTML);
	}
}