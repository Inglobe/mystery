/**
 * A simple example of list menu behavior.
 * Note that all menu items will be expanded by default and we use javascript to un-expand them, 
 * leaving only the path to the selected item expanded.
 *
 * @author rgrocha 
 * @author icoloma 
 */
loom.ui.Menu = Class.create({
  
  /**
   * element: the container of the menu
   */
  initialize: function(element) {
  
    element.select('li a').each(function(e) {
      
      // add event listener to expand submenu on click
      var li = $(e.parentNode);
      if (li.hasClassName('submenu')) {
        e.observe('click', function(event) {
          var e = event.target;
          e.parentNode.toggleClassName('expanded');
			    if (e.getAttribute('href').startsWith('#')) {
			      event.stop();
			    }
        });
      }
      // remove all expanded attributes 
	    li.removeClassName('expanded');
    });
    
    // expand nodes in the path of the sleected menu item
    var li = element.select('li.selected').first();
    if (li) {
      li.ancestors().detect(function(e) { 
        e.addClassName('expanded');
        if (e == element)
          return true;
      });
    }
  }
  
});

/**
 * Menu to select user locale
 */
loom.ui.LocaleMenu = Class.create({

  /**
   * element: the container of the menu
   */
  initialize: function(element) {
    element.observe('click', this.onclick.bindAsEventListener(this));
  },
  
  onclick: function(event) {
    var a = event.findElement('a[hreflang]');
    if (a) {
      event.stop();
      var locale = a.getAttribute('hreflang');
      loom.cookies.set('locale', locale, 10 * 365); // expires in ten years
      this.reload();
    }
  },
  
  /** override for tests */
  reload: function() {
    window.location.reload(true);
  }

});