$('print').onclick = function(){
	document.forms[0].action = document.forms[0].id+"_result.php";
	document.forms[0].target = document.forms[0].id;
}

$('download').onclick = function(){
	document.forms[0].action = document.forms[0].id+"_result.php";
	document.forms[0].target = document.forms[0].id;
}

$('chart').onclick = function(){
	document.forms[0].action = "index.php";
	document.forms[0].target = "_self";
}