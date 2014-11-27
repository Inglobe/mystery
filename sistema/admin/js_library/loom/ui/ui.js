/** keycodes that are not text */
loom.ui = {

  /** substitute with "l:" or similar to use namespaced XHTML attributes instead */
  extendedPrefix: 'data-',

  event: {
  
	  SPECIAL_KEYS: [ 
	    Event.KEY_BACKSPACE, Event.KEY_TAB, Event.KEY_RETURN, Event.KEY_ESC, Event.KEY_LEFT, 
	    Event.KEY_UP, Event.KEY_RIGHT, Event.KEY_DOWN, Event.KEY_DELETE, Event.KEY_HOME, 
	    Event.KEY_END, Event.KEY_PAGEUP, Event.KEY_PAGEDOWN
	    ]
	    
	},
	
	/**
	 * Return the (translated) property name  of an element
	 * If there is a surrounding label or a label with the corresponding for attribute,
	 * return its text contents.
	 * Else return the last substring present in element.name (e.g., mortgage.amount returns "amount")
	 */
	getPropertyName: function(element) {
	  var label = element.up('label');
	  if (!label && element.id) 
	    label = $$('label[for=#{id}]'.interpolate({id: element.id})).first();
	  if (label) // if there is a nested span tag, use it instead
	    label = label.down('span') || label;
	    
	  // if there is a label, return that
	  return label? (label.innerText || label.textContent).strip().gsub(':', '') : element.name.gsub(/[^\.]*\./, "");
	  
	}
	
}

Element.addMethods('form', {
   
   // search the next valid index for a multiple field 
   // template: the template to search with syntax 'my.nested.propertyName[${index}]'
   // return the next available field name
   getNextAvailableFieldName: function(form, template) {
   	  for (var i = 0; i < 100; i++) {
   	     var candidate = template.interpolate({ index: i }, /(^|.|\r|\n)(\$\{(.*?)\})/);
   	     if (!$(candidate)) {
   	       return candidate;
   	     }
   	  }
   	  throw new Error('Could not find next field name (max iterations reached).');
   }
   
});

Element.addMethods({

  /**
   * element: the element where to search for this attribute
   * name: the name of the attribute
   * defaultValue: if present, the value to return if no such attribute is found.
   * converter: the method to call to convert the string value to an object type.
   */
  getExtendedAttribute: function(element, name, defaultValue, converter) {
    return (converter || Prototype.K)(element.getAttribute(loom.ui.extendedPrefix + name) || defaultValue);
  },
  
  getExtendedAttributeAsBoolean: function(element, name, defaultValue) {
    return element.getExtendedAttribute(name, defaultValue, function(v) { return /^true$/.match(v); });
  },
  
  getAttributeAsDate: function(element, name) {
    var v = element.getAttribute(name);
    return v? loom.format.parseDate('%i', v) : null;
  }
  
});
