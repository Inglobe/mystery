/**
 *
 * @access public
 * @return void
 **/

Element.addMethods({
	appendText: function(element, text) {
		text = document.createTextNode(text);
		element.appendChild(text);
		return $(element);
	}
});

var Report = Class.create({
	initialize: function(data_path){
		this.data_path = data_path;
		this.contenedor = $('contenedor');
		this.registros_por_pagina = 40;
		this.alto_pagina = 1050;
	},
	renderPages: function(dataXML){
		alert("Hay " + dataXML.getElementsByTagName('fila').length + " registros");

		var dataInformacion = dataXML.getElementsByTagName('informacion')[0];
		var dataLineasTexto = dataXML.getElementsByTagName('linea_texto');
		var dataHeaders = dataXML.getElementsByTagName('columna');
		var dataItems = dataXML.getElementsByTagName('fila');
		var dataFooterTotals = dataXML.getElementsByTagName('footer_total');

		this.nombre = dataInformacion.getElementsByTagName('nombre')[0].firstChild.data;
		this.fecha = dataInformacion.getElementsByTagName('fecha')[0].firstChild.data;
		this.numero_registros = dataItems.length
		this.numero_paginas = Math.ceil(this.numero_registros / this.registros_por_pagina);
		this.numero_columnas = dataHeaders.length;

		if(dataInformacion.getElementsByTagName('orientation')[0].firstChild.data == 1){
			this.alto_pagina = 700;
		}

		var hay_registros = true;
		var pagina = 0;
		var indice=0;

		while(hay_registros){
			pagina++;
			var div_pagina = new Element('div',{'class':'cont_pagina'});

			//header ***********************************************************
			var div_logo = new Element('div',{'id':'logo'});
			var img_logo = new Element('img',{'src':'clases/Report/img/logo_print.png', 'width':'218', 'height':'46'});
			div_logo.appendChild(img_logo);

			div_pagina.appendChild(div_logo);

			var cont_fecha = new Element('div',{'id':'fecha'});
			if(dataInformacion.getElementsByTagName('showDate')[0].firstChild.data == 'true'){
				cont_fecha.appendChild(new Element('strong').appendText('Date: '));
				cont_fecha.appendText(this.fecha);
				cont_fecha.appendChild(new Element('br'));
			}
			if(dataInformacion.getElementsByTagName('showPageNums')[0].firstChild.data == 'true'){
				cont_fecha.appendChild(new Element('strong').appendText('Page: '));
				cont_fecha.appendText(pagina + ' of ' + this.numero_paginas);
			}
			div_pagina.appendChild(cont_fecha);
			div_pagina.appendChild(new Element('h1').appendText(this.nombre));

			var div_datos = new Element('div',{'class':'datos'});

			for (var i = 0;i<dataLineasTexto.length;i++){
				if(dataLineasTexto[i].nodeType == 1){
					var div_linea_datos = new Element('div',{'class':'linea_datos'});
					div_linea_datos.appendChild(new Element('div',{'class':'subtit'}).appendText(dataLineasTexto[i].getElementsByTagName('titulo')[0].firstChild.data));
					div_linea_datos.appendChild(new Element('div',{'class':'dato'}).appendText(dataLineasTexto[i].getElementsByTagName('texto')[0].firstChild.data));
					div_datos.appendChild(div_linea_datos);
				}
			}
			div_pagina.appendChild(div_datos);
			//******************************************************************

			//tabla ************************************************************
			var tabla = new Element('table', {'width': '100%','border': '0', 'cellSpacing': '0', 'cellPadding': '0'});
			div_pagina.appendChild(tabla);
			this.contenedor.appendChild(div_pagina);

			var thead = new Element('thead');
			tabla.appendChild(thead);

			var fila_thead = new Element('tr');

			for (var i=0;i < dataHeaders.lenght;i++){
				if(dataHeaders[i].nodeType == 1){
					fila_thead.appendChild(new Element('th').appendText(dataHeaders[i].firstChild.nodeValue));
				}
			}

			thead.appendChild(fila_thead);

			var tbody = new Element('tbody');
			tabla.appendChild(tbody);

			while(div_pagina.getHeight() < this.alto_pagina){

				var fila = new Element('tr');

				try{
					for (var j=0;j < dataItems[indice].childNodes.length;j++){
						if(dataItems[indice].childNodes[j].nodeType == 1){
							fila.appendChild(new Element('td').appendText(dataItems[indice].childNodes[j].firstChild.nodeValue));
						}
					}
				}
				catch(e){
					for(var k = 0;k < this.numero_columnas; k++){
						fila.appendChild(new Element('td').update("&nbsp;"));
					}
				}

				tbody.appendChild(fila);

				indice++;
			}

			if(this.numero_registros < indice){
				hay_registros = false;

				for (var i = 0;i<dataFooterTotals.length;i++){
					if(dataFooterTotals[i].nodeType == 1){
						var div_footertotal = new Element('div',{'class':'total'});
						div_footertotal.appendChild(new Element('div',{'class':'recuadrito_total'}).appendText(dataFooterTotals[i].getElementsByTagName('numero')[0].firstChild.data));
						div_footertotal.appendChild(new Element('div',{'class':'tit_total'}).appendText(dataFooterTotals[i].getElementsByTagName('nombre')[0].firstChild.data));
						div_pagina.appendChild(div_footertotal);
					}
				}
			}
		}
		//**********************************************************************

		//debug
		var debug_textarea = new Element('textarea', {'width': '100%','cols':'80','rows':'10'});
		debug_textarea.value=this.contenedor.innerHTML;
		this.contenedor.appendChild(debug_textarea);

		$("preloader").hide();
		if(dataInformacion.getElementsByTagName('showPrintDialog')[0].firstChild.data == 'true'){
			window.print();
		}
	},
	show: function(){
		this.contenedor.update('');
		this.contenedor.appendChild(new Element('div',{'id':'preloader'}).appendText('Loading...'));

		var padre = this;

		var ajaxObj = new Ajax.Request(this.data_path, {
			method:'get',
			parameters: {'xml_mode': '1'} ,
			onSuccess: function(transport){
				padre.renderPages(transport.responseXML);
			},
			onFailure: function(){
				alert('Error loading XML data...')
			}
		})
	}
});