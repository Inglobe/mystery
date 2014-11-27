/**
 * Form validation 
 * @author icoloma
 */
'loom.validation'.namespace();
 
loom.validation.Validator = Class.create({

    // true to allow empty input
    nullAllowed: true,

    // returns true if the element has an error message
    hasMessage: function() {
      return this.element.hasClassName("error");
    },
    
    // throw an exception with the specified error message
    error: function(message) {
     throw new loom.validation.ValidationException(message, this);
    },
    
    validate: function() {
      try {
        if (!this.element.value.blank() || !this.nullAllowed)
          this.validateImpl();
      } catch (e) {
        // consider possible message override
        var message = this.element.getExtendedAttribute(this.name + "-message");
        if (e instanceof loom.validation.ValidationException && message)
          this.error(message)
        throw e;
      }
    }

});


Object.extend(loom.validation, {

  ValidationException: Class.create({
		initialize: function(message, validator) {
			this.message = message;
			this.validator = validator;
			this.name = "ValidationException";
		}
  }),
  
  RequiredValidator: Class.create(loom.validation.Validator,  {

	  name: "required",
    
    nullAllowed: false,
	    
	  // validate a required field
	  validateImpl: function() {
	    if (this.element.value.blank()) {
	      this.error("loom.validation.requiredFailed");
	    }
	  }
    
  }),

  // validates a string 
  StringValidator: Class.create(loom.validation.Validator, {

	  initValidator: function() {
	    this.name = "string";
	    this.minLength = this.element.getExtendedAttribute('minLength');
	    var m = this.element.getAttribute('pattern');
	    if (m) 
	      this.maskPattern = new RegExp(m);
	  },
	  
	  validateImpl: function() {
	    var c = this.element;
	    var value = c.value.strip();
	    if (this.minLength != null && value.length < this.minLength)
	      this.error("loom.validation.minLengthFailed");
	    else if (this.maskPattern != null && !this.maskPattern.test(value))
	      this.error("loom.validation.maskFailed");
	  },
	  
	  // Fires when a textarea gets modified, and ensures that it does not get longer than maxlength characters
	  onTextAreaKeyPress: function(event) {
	    var evtc = event.keyCode; 
	    var c = this.element;
	  	if (c.value.length >= c.getAttribute('maxlength') && loom.ui.event.SPECIAL_KEYS.indexOf(evtc) == -1) {
	        event.stop();
	    }
	  },
	  
	  // because paste etc are not included in the "keypress" listener:
	  onTextAreaChange: function() {
	     this.element.value = this.element.value.substring(0, this.element.getAttribute('maxlength'));
	  }
  
  }),

  // validates a number
  NumberValidator: Class.create(loom.validation.Validator, {
  
    initValidator: function() {
	    var c = this.element;
		  this.name = "number";
	    this.minValue = loom.format.parseNumber(c.getAttribute('min'));
	    this.maxValue = loom.format.parseNumber(c.getAttribute('max'));
	    this.excludeMin = c.getExtendedAttributeAsBoolean('exclude-min');
	    this.excludeMax = c.getExtendedAttributeAsBoolean('exclude-max', 'true');
	    this.scale = c.getExtendedAttribute('scale');
	    this.precision = c.getExtendedAttribute('precision');
    },
    
	  validateImpl: function() {
	    var c = this.element;
	    var value = loom.format.parseNumber(c.value);
	    var numberFormat = new loom.format.NumberFormat(value);
	    if (isNaN(value))
	      this.error("loom.conversion.numberFailed");
	    else if (this.minValue != null && (this.excludeMin && value <= this.minValue || !this.excludeMin && value < this.minValue))
	      this.error("loom.validation.numberMinFailed");
	    else if (this.maxValue != null && (this.excludeMax && value >= this.maxValue || !this.excludeMax && value > this.maxValue))
	      this.error("loom.validation.numberMaxFailed");
	    else if (this.scale != null && this.scale < numberFormat.scale())
	      this.error("loom.validation.scaleFailed");
	    else if (this.precision != null && this.precision < numberFormat.precision())
	      this.error("loom.validation.precisionFailed");
	  }
  
  }),
  
  // validate a date
  DateValidator: Class.create(loom.validation.Validator, {
	  
    initValidator: function(name) {
      var c = this.element;
      this.dateParser = new loom.format.DateParser(c);
      this.name = "date";
	  this.minValue = c.getAttributeAsDate('min');
      this.maxValue = c.getAttributeAsDate('max');
      (this.minValue) && (this.minValue.date = this.minValue.format(this.dateParser.format)); // for error messages 
      (this.maxValue) && (this.maxValue.date = this.maxValue.format(this.dateParser.format));
      this.excludeMin = c.getExtendedAttributeAsBoolean('exclude-min');
      this.excludeMax = c.getExtendedAttributeAsBoolean('exclude-max', 'true');
    },
	  
	  validateImpl: function() {
		  var c = this.element;      
	    var value = this.dateParser.parse(c.value);
	    
  	    if (!value || value == NaN) 
  	      this.error("loom.conversion.dateFailed");
  	    if (this.minValue && (this.excludeMin && value <= this.minValue || !this.excludeMin && value < this.minValue))
  	      this.error("loom.validation.dateMinFailed");
  	    else if (this.maxValue && (this.excludeMax && value >= this.maxValue || !this.excludeMax && value > this.maxValue))
  	      this.error("loom.validation.dateMaxFailed");
    }
  
  }),
  
  /** 
   * get the error display element associated to this field, if any. 
   * If there is no surrounding label, it will return null.
   * If there is a surrounding label but no error display element, it will create one. 
   */
  getErrorElement: function(element, createIfNull) {
    var label = element.up('label');
    if (!label) {
    	return null;
    }
    var c = label.next();
    if (c && c.tagName == 'SPAN' && c.hasClassName('error'))
      return c;
    label.insert({ after: '<span class="error" style="display:none"></span>' });
    return label.next();
  },
  
  // clears the error message 
  clearMessage: function(element) {
    element.removeClassName("error");
    var label = element.up('label');
    label && label.removeClassName("error");
    element.alt = element._alt || '';
    element.title = element._title || '';
      
    var errorelement = loom.validation.getErrorElement(element);
    errorelement? errorelement.hide().innerHTML = '' : loom.validation.removeUnboundMessage(element.identify());
  },
  
  // assigns an error message to the element
  setMessage: function(exception) {
    var message = loom.validation.translateMessage(exception);
    var element = exception.validator.element;
    var label = element.up('label');
    
   	element.addClassName("error");
   	label && label.addClassName("error");
    element.alt = message;
    element.title = message;
    
    var errorelement = loom.validation.getErrorElement(element);
    if (errorelement) {
      errorelement.innerHTML = message;
      errorelement.show();
    } else {
      loom.validation.addUnboundMessage(element.identify(), message);
    }
  },
  
  
  // returns the translated message
  translateMessage: function (exception) {
    var messageTemplate = loom.messages[exception.message];
    if (messageTemplate == null)
      return exception.message;
    var element = exception.validator.element;
    // use ${} instead of #{} to reuse the same strings on the server side
    return messageTemplate.interpolate({
	      propertyName: loom.ui.getPropertyName(element), validator: exception.validator, value: element.value, length: element.value.length
	    }, /(^|.|\r|\n)(\$\{(.*?)\})/);
  },
  
  // adds an error message for a given element
  addUnboundMessage: function (elementId, message) {
    var errors = $("errors");
    if (errors == null) {
      throw new Error(message);
    }
    var id = "errors-" + elementId;
    var item = $(id);
    if (item != null) {
      item.update(message);
    } else {
      var ul = errors.firstDescendant();
	  if (!ul) {
	  	errors.insert('<ul/>');
	    ul = errors.firstDescendant();
	  }
	  ul.insert('<li id="#{id}">#{message}</li>'.interpolate({id : id, message: message}));
    }
    errors.show();
  },
  
  // removes the error message of a given element
  removeUnboundMessage: function (elementId) {
    var item = $("errors-" + elementId);
    if (item != null) {
      var ul = item.up('ul');
      item.remove();
      if (ul.empty())
        $("errors").hide();
    }
  }
  
});

/**
 * Modifications of Element are kept to a minimum, to avoid collisions with other frameworks
 */
Element.addMethods({

  // adds a validator to this Element instance
  addValidator: function(element, validator) {
    validator.element = element;
    if (validator.initValidator)
      validator.initValidator();
    if (!element.validators)
      element.validators = [];
    element.validators.push(validator);
  },

  // launches all validators registered for an element
  validate: function(element) {
    try { 
      if (!element.visible() || !element.validators)
        return;
      element.validators.invoke('validate');
      loom.validation.clearMessage(element);
    } catch (e) {
      if (e instanceof loom.validation.ValidationException)
        loom.validation.setMessage(e);
      else
        throw e;
    }
  },

  // bind validations to a single element
  bindValidation: function(element) { 
	  
    if (element.hasClassName("required"))
      element.addValidator(new loom.validation.RequiredValidator());
    if (element.hasClassName("number"))
      element.addValidator(new loom.validation.NumberValidator());
    if (element.hasClassName("date") || element.hasClassName("dateTime") || element.hasClassName("time")) 
      element.addValidator(new loom.validation.DateValidator());
    if (element.hasClassName("string")) {
      var validator = new loom.validation.StringValidator();
      element.addValidator(validator);
		  if (element.tagName == 'TEXTAREA' && element.getAttribute('maxlength')) { 
				element.observe('keypress', validator.onTextAreaKeyPress.bindAsEventListener(validator));
				element.observe('change', validator.onTextAreaChange.bindAsEventListener(validator));
		  }
    }
      
    element.observe("change", element.validate.bindAsEventListener(element));
    element._alt = element.alt;
    element._title  = element.title;
  }
  
});
  
Element.addMethods('FORM', {

  bindValidations: function(form) {

	  form.select('input[type=text]', 'input[type=password]', 'textarea', 'select').invoke('bindValidation');
	  
	  // select the first error element
	  form.select('input.error', 'select.error', 'textarea.error').any(Element.activate);
  }
  
});
    

