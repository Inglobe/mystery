var botones = $$('#botones_sup a');
for(var i=0;botones.length; i++){
	botones[i].onmouseover = function(){
		var lista = $$('#' + this.rel)[0];

		lista.onmouseout = function(){
			this.style.display = "none";
		}

		lista.style.display = "";
	}

	/*botones[i].onmouseout = function(){
		var lista = $$('#' + this.rel)[0];
		lista.style.display = "none";
	}*/
}