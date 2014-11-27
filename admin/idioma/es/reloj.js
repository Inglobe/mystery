// Reloj ***********************************************************************************************
function JSClock() {          
	var time = new Date()          
	var hour = time.getHours()          
	var minute = time.getMinutes()          
	var second = time.getSeconds()          
	var temp = ((hour > 12) ? hour - 12 : hour)          
	temp += ((minute < 10) ? ":0" : ":") + minute          
	temp += ((second < 10) ? ":0" : ":") + second          
	temp += (hour >= 12) ? "&nbsp;P.M." : "&nbsp;A.M."          
	document.getElementById("relojito").innerHTML = temp
	id = setTimeout("JSClock()",1000)
}