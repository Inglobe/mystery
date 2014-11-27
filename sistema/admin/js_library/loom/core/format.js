'loom.format'.namespace();
/**
 * Date/Number parsing and formatting libraries
 * @author icoloma
 * @author rgrocha
 */

Object.extend(Date, {
	
	DAYS_IN_MONTH: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
	SECOND: 1000, /* milliseconds */
	MINUTE: 60 * 1000,
	HOUR: 60 * 60 * 1000,
	DAY: 24 * 60 * 60 * 1000,
	WEEK: 7 * 24 * 60 * 60 * 1000,
	
	/** local time offset, in hours (2 means UTC+0200) */
	defaultTimezone: new Date().getTimezoneOffset() / -60
	
});

Date.prototype.__msh_oldSetFullYear = Date.prototype.setFullYear;
Object.extend(Date.prototype, {
	
  /**
   * This method is based on previous work by Justin Palmer
   * http://alternateidea.com/blog/articles/2008/2/8/a-strftime-for-prototype
   * @param {String} format the format string as specified by PHP's strftime function 
   */
  format: function(format) {
    // replace token aliases prior to formatting
    var parser = new loom.format.DateParser(format);
    format = parser.format;

    var day = this.getDay();
    var month = this.getMonth();
    var hours = this.getHours();
    var minutes = this.getMinutes();
	var timezone = (this.getTimezoneOffset() / -60) + this.getDaylightSavingOffset(); // apply +2 if DST is active
    function pad(num) { return num.toPaddedString(2); };

    return format.gsub(/\%([aAbBcdDHiImMpSwyYZz%tn])/, function(part) {
      switch(part[1]) {
        case 'a': return parser.shortDayNames[day]; break;
        case 'A': return parser.dayNames[day]; break;
        case 'b': return parser.shortMonthNames[month]; break;
        case 'B': return parser.monthNames[month]; break;
        case 'c': return this.toString(); break;
        case 'd': return pad(this.getDate()); break;
        case 'H': return pad(hours); break;
        case 'i': return (hours === 12 || hours === 0) ? 12 : (hours + 12) % 12; break;
        case 'I': return pad((hours === 12 || hours === 0) ? 12 : (hours + 12) % 12); break;
        case 'm': return pad(month + 1); break;
        case 'M': return pad(minutes); break;
        case 'P': return hours > 11 ? 'pm' : 'am'; break;
        case 'p': return hours > 11 ? 'PM' : 'AM'; break;
        case 'S': return pad(this.getSeconds()); break;
        case 'w': return day; break;
        case 'y': return pad(this.getFullYear() % 100); break;
        case 'Y': return this.getFullYear().toString(); break;
		case 'z':
		case 'Z': return timezone == 0? 'Z' : (timezone > 0? '+' : '-') + pad(timezone.abs()); break;
		case '%': return '%'; break;
		case 't': return '\t'; break;
		case 'n': return '\n'; break;
      }
    }.bind(this));
  },
  

  //Returns the number of days in the current month
  getMonthDays: function(month) {
	  var year = this.getFullYear()
	  month = month || this.getMonth()
	  if (month == 1 && ((0 == (year % 4)) && ( (0 != (year % 100)) || (0 == (year % 400)))))
		return 29
	  else
		return Date.DAYS_IN_MONTH[month]
  },

  setFullYear: function(y) {
	  var d = new Date(this);
	  d.__msh_oldSetFullYear(y);
	  if (d.getMonth() != this.getMonth())
		this.setDate(28);
	  this.__msh_oldSetFullYear(y);
  },
  
  /** 
   * return the DST offset. This method returns the number of hours that should be added to a parsed date  
   */
  getDaylightSavingOffset: function() {
	var diff = 2 * this.getTimezoneOffset() - (new Date(2004, 0)).getTimezoneOffset() - (new Date(2004, 6)).getTimezoneOffset();
    return diff / 60;
  }
  
});

    // initialize token aliases
loom.format.aliases = $H({
  F: '%Y-%m-%d', 
  r: '%I:%M:%S %p', // time in a.m. and p.m. notation
  R: '%H:%M', // time in 24 hour notation 
  T: '%H:%M:%S', // current time
  D: '%m/%d/%y',
  i: '%Y-%m-%dT%H:%M:%S%z' // ISO 8601 date format (extension over the strftime format)
  //c: loom.messages['loom.format.jsDateTime'],
  //x: loom.messages['loom.format.jsDate'], // preferred date representation for the current locale without the time
  //X: loom.messages['loom.format.jsTime'] // preferred time representation for the current locale without the date                   
});

loom.format.DateParser = Class.create({

  /**
   * Create a new parser
   * @return {Parser} a parser instance 
   * @param format if a String, it's the expected date format. If an element, the corresponding String will be calculated 
   * for the current locale using its CSS class (date, dateTime, time)
   */
  initialize: function(format) {

	// if Element, transform to the corresponding format String
    if (Object.isElement(format)) {
    	var dateClass = $A(['date', 'dateTime', 'time']).find(function(e) { 
    		return format.hasClassName(e); 
    	});
    	if (!dateClass) throw new Error("Element " + format + " is not recognized as a date field");
    	format = loom.messages['loom.format.js' + dateClass.charAt(0).toUpperCase() + dateClass.substring(1) ];
    }
	
    // initialize this.dayNames, this.shortDayNames, this.monthNames, this.shortMonthNames
    $w('dayFirstChar dayNames monthNames shortDayNames shortMonthNames').each(function(n) {
      this[n] = $w(loom.messages['loom.format.' + n]);
    }.bind(this));
    
    // replace token aliases 
    format = this.resolveAliases(format);
    this.allTokens = this.getAllTokens();
    this.format = format;
    this.regex = '^';
    this.tokens = $A([]);
    for (var i = 0; i < format.length; ) {
      var c = format.charAt(i++);
      if (c == '%') {
        var token = this.allTokens[format.charAt(i++)];
        if (!token)
          throw new SyntaxError("Unknown directive: %" + format.charAt(i-1));
        this.tokens.push(token);
        this.regex += '(' + token.ex + ')';
      } else {
        this.regex += c;
      }
    }
    this.regex = new RegExp(this.regex + '$', "i"), 
    
    loom.format.dateParsers[format] = this;
  },
  
  /**
   * Expected tokens, according to the expected format.
   * For each token, the token data must follow this structure:
   * { 
   * ex: the regular expression that defines this word
   * f the function that parses the input text, null for Prototype.K
   * p the date property that is set with this value, null to discard the value
   * ampm either one of 'am', 'pm' or null if the hour is in 24-hour format 
   * timezone the timezone, if any
   * }
   *
   */
  getAllTokens: function() { 
    var t = { 
    
      a: { // abbreviated weekday name according to the current locale
        ex: this.shortDayNames.join('|')
      },
      A: { // full weekday name according to the current locale
        ex: this.dayNames.join('|')
      },
      b: { // abbreviated month name according to the current locale
        ex: this.shortMonthNames.join('|'),
        f: function(text, parser) { return parser.shortMonthNames.indexOf(text) },
        p: 'mes'
      },
      B: { // full month name according to the current locale
        ex: this.monthNames.join('|'),
      f: function(text, parser) { return parser.monthNames.indexOf(text) },
      p: 'mes'
      },
      d: { // day of the month as a decimal number (range 01 to 31)
        ex: "\\d?\\d",
      p: 'dia'
      },
      H: { // // hour as a decimal number using a 24-hour clock (range 00 to 23)
        ex: "\\d?\\d",
        p: 'hora'
      },
      I: { // hour as a decimal number using a 12-hour clock (range 01 to 12)
        ex: "\\d?\\d",
      //f: function(v) { return parseInt(v) - 1; },
        p: 'hora'
      },
      m: { // month as a decimal number (range 01 to 12)
    
        ex: '\\d?\\d',
      f: function(m) { return m - 1 },
      p: 'mes'
      },
      M: { // minutes as a decimal number
        ex: '\\d?\\d',
      p: 'minuto'
      },
      n: { // carriage return
        ex: '\\n'
      },
      p: { // // 'AM'/'PM' literal
        ex: 'am|pm',
        f: function(m) { return m.toLowerCase(); },
        p: 'ampm'
      },
      S: { // seconds as a decimal number. Milliseconds are optional, but only JodaTime uses them AFAIK. Do not use parenthesis here!
        ex: '\\d{1,2}|\\d{1,2}\\.\\d{3}',
      p: 'second'
      },
      t: { // tab
        ex: '\\t'
      },
      u: { // weekday as a decimal number [1,7], with 1 representing Monday
        ex: '\\d'
      },
      y: { // year as a decimal number without a century (range 00 to 99)
        ex: '\\d\\d',
      f: function(v) { v = parseInt(v); return v > 80? 1900 + v : 2000 + v},
      p: 'year'
      },
      Y: { // year as a decimal number including the century
        ex: '\\d{4}',
      p: 'year'
      },
      Z: { // timezone name or Z for UTC. Do not use parenthesis here!
        ex: 'Z|[+-]\\d{2}|[+-]\\d{4}|[+-]\\d{2}:\\d{2}',
      f: function(v) { 
        if (v == 'Z') // UTC
            return 0;
          var a = /^([+-]\d{2}):?(\d{2})?$/.exec(v); // hour and (optional) minutes
        return parseInt(a[1]) + (!a[2]? 0 : parseInt(a[2]) / 60); 
      },
      p: 'timezone'
      },
      '%': { // '%' character
        ex: '\\%'
      }
    
    };
    
    // format aliases
    t = Object.extend(t, {
      h: t.b, // abbreviated month name according to the current locale
      w: t.u, // day of the week as a decimal, Sunday being 0
      P: t.p, // am/pm as lowercase
      z: t.Z // timezone
    });
    
    return t;
  
  },

  resolveAliases: function(format) {
    loom.format.aliases.each(function(pair) {
        format = format.gsub('%' + pair.key, pair.value);
    });
    return format;
  },
  
  /** return true if this DateFormat instance includes a time attribute in the format (hour, minutes, second) */
  hasTime: function() {
	  return this.format.match(/%[HIMS]/);
  },
  
  parse: function(text) {
    var v = this.regex.exec(text);
    if (!v)
    return NaN;
    
    // process all tokens, if t.p is not null
    var date = {};
    var parser = this;
    this.tokens.each(function(t, index) {
      if (t.p) {
        date[t.p] = (t.f || Prototype.K)(v[index + 1], parser);
      }
    });
  
      
    if (date.hour && date.ampm == 'pm') date.hour = parseInt(date.hour) + 12;
    
    var d = loom.format.createDate(date.year, date.month, date.day, date.hour, date.minute, date.second);
    
    // adjust timezone
    if (date.timezone != null) {
      d = new Date(d.getTime() + (date.timezone - Date.defaultTimezone) * Date.HOUR); 
    }
    
    return d;
  }
  
});

/**
 * Handle decimal numbers format and parsing
 */ 
loom.format.NumberFormat = Class.create({

  initialize: function(number) {
    this.number = number;
  },

  // returns the number of digits
  precision: function() {
    return Math.abs(this.number).toString().replace('.', '').length;
  },
  
  // returns the number of decimal digits
  scale: function(number) {
    var stringValue = this.number.toString();
    var pos = stringValue.indexOf('.');
    return pos == -1? 0 : stringValue.length - (pos + 1);
  },
  
  // format a number and return a localized String
  format: function() {
    return this.number.toString().gsub('\\.', loom.messages['loom.format.decimalSeparator']);
  }
});

loom.format = Object.extend(loom.format, {

  /** list of configured parsers */
  dateParsers: {},

   /**
    * Parse the provided text as a date with the expected format.
    * @param text text to be parsed
    * @param format of the date: see 
    * http://www.opengroup.org/onlinepubs/007908799/xsh/strftime.html
    * @return date the parsed Date, or NaN if the text does not confirm to the expected format
    */
    parseDate: function(format, text) {
      return (loom.format.dateParsers[format] || new loom.format.DateParser(format)).parse(text);
    },
    
    /**
     * Create a date.
     * Some of the fields may be null. If the year, month or day are missing, return NaN
     */
    createDate: function(year, month, day, hour, minute, second) {
      if (year && month != null && day) { // month may be 0
            return new Date(year, month, day, hour || 0, minute || 0, second || 0);
        }
        
      // some required fields are missing
      return NaN;
    },
    
    // parse a text and return a number
    parseNumber: function(text) {
      if (text == null)
        return null;
      if (!loom.messages['loom.format.number'].test(text))
        return NaN;
      text = text.gsub('\\' + loom.messages['loom.format.groupingSeparator'], '').gsub('\\' + loom.messages['loom.format.decimalSeparator'], '.');
      return parseFloat(text);
    }
    
});

    
