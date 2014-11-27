bc_newElement = function (tag) {
   return document.createElement(tag);
}
bc_getElement = function (id) {
   return document.getElementById(id);
}

var field_count = 1;

bc_init = function(fileId, displayId) {
    try {
        field = bc_getElement(fileId);
        field.display=bc_getElement(displayId);

        if (!field || !field.type || field.type != 'file' || !field.display) return;

        addEvent(field, 'change', bc_addField);
    } catch ( ex ) { bc_handleError(ex); }
}

bc_load = function (fileId, displayId) {
    addEvent(window, 'load', new Function("bc_init('" + fileId + "', '" + displayId + "');"));
}
// Basado en http://the-stickman.com/web-development/javascript/updated-upload-multiple-files-with-a-single-file-element/
bc_addField = function() {
    try {
        new_field = bc_newElement('INPUT');
        new_field.type = 'file';
        new_field.id = new_field.name = this.id.replace(/-@bc-.*$/g, "") + '-@bc-' + field_count++;
        new_field.name = new_field.id;
        new_field.display = this.display;
        addEvent(new_field, 'change', bc_addField);

        this.parentNode.insertBefore(new_field, this);

        li = bc_newElement('LI');

		a = bc_newElement('A');
		a.href="#";

        img = bc_newElement('IMG');
        img.src="imagenes/ico_delete.gif";
        img.width=10;
        img.height=11;
        img.border=0;
        a.field_id = this.id;

		a.appendChild(img);

		addEvent(a, 'click', bc_removeField);

        li.appendChild(document.createTextNode( this.value.substring( this.value.search(/[^\/\\]+$/) ) ));
        li.appendChild(a);

        this.display.appendChild(li);

        this.style.position = 'absolute';
	    this.style.left = '-1000px';
    } catch ( ex ) { bc_handleError(ex); }
}
bc_removeField = function (event) {
    try {
        (del = bc_getElement(this.field_id)).parentNode.removeChild(del);

        this.parentNode.parentNode.removeChild(this.parentNode);
        if (event && event.preventDefault)
            event.preventDefault();
        return false;
    } catch ( ex ) { bc_handleError(ex); }
}
bc_handleError = function (ex) { alert ( ex ); }
