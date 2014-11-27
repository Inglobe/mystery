if ((typeof Prototype == 'undefined') || Prototype.Version < '1.6') {
    throw new Error('Loom requires Prototype 1.6.0 or greater');
}

/**
 * Original implementation by by kangax and henrah 
 * at http://thinkweb2.com/projects/prototype/namespacing-made-easy/
 */
String.prototype.namespace = function(separator) {
  this.split(separator || '.').inject(window, function(parent, child) {
    return parent[child] = parent[child] || { };
  })
}

var loom = Object.extend(window['loom'] || {}, {

	/** loom GET params prefix */
	PARAM_PREFIX: '_', 
	
	/** true if this is a IE <7 */ 
	ie6: Prototype.Browser.IE && navigator.appVersion < "4.0 (compatible; MSIE 7",
  
	/**
	 * Original implementation by Carlos Reche:
	 * http://wiki.script.aculo.us/scriptaculous/show/Cookie 
	 */
	cookies: {
	
		// TODO: missing "secure"
	  set: function(name, value, daysToExpire, path) {
	    var expire = '';
	    if (daysToExpire != undefined) {
	      var d = new Date();
	      d.setTime(d.getTime() + (86400000 * parseFloat(daysToExpire)));
	      expire = '; expires=' + d.toGMTString();
	    }
	    path = '; Path=' + (path || '/');
	    return (document.cookie = escape(name) + '=' + escape(value || '') + path + expire);
	  },
	  
	  get: function(name) {
	    var cookie = document.cookie.match(new RegExp('(^|;)\\s*' + escape(name) + '=([^;\\s]*)'));
	    return (cookie ? unescape(cookie[2]) : null);
	  },
	  
	  remove: function(name) {
	    var cookie = loom.cookies.get(name);
	    loom.cookies.set(name, '', -1);
	    return cookie;
	  },
	  
	  /**
	   * return true if the browser has cookies enabled
	   */
	  accept: function() {
	    if (typeof navigator.cookieEnabled == 'boolean') {
	      return navigator.cookieEnabled;
	    }
	    loom.cookies.set('_test', '1');
	    return (loom.cookies.remove('_test') === '1');
	  }
    
	},
	
	/**
	 * Return the full path of the provided js script without the script name, e.g.<b>
	 * loom.getScriptPath('prototype.js') returns 'http://prototype.org/js/script' if the page 
	 * includes http://prototype.org/js/script/prototype.js?something.
	 * If the script is not found, returns null.  
	 */
	getScriptPath: function(filename) {
	    var path = null;
	    $A(document.getElementsByTagName("script")).any( function(s) {
	       var src = s.getAttribute('src');
	       if (src) {
		       var pos = src.indexOf(filename);
	           return pos != -1 && (path = src.substring(0, pos));
           }
        });
        return path;
	}	
});
