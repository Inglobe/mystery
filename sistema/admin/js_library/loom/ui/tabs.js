/**
 * Original version by Andrew Tetlaw, available at
 * http://tetlaw.id.au/view/blog/fabtabulous-simple-tabs-using-prototype/
 *
 * @author Andrew Tetlaw
 * @author icoloma 
 */
loom.ui.Tabs = Class.create({

  initialize : function(element, options) {
    this.options = Object.extend({
      selectedClass: 'selected' // css class name to apply to the selected li item
    }, options || {});
    this.container = $(element);
    this.links = this.container.select('a');
    var initTab = this.getInitialTab();
    this.show(initTab);
    this.links.without(initTab).each(this.hide.bind(this));
    this.container.observe('click', this.onClick.bind(this));
  },

  /**
   * Invoked when a tab gets clicked
   */
  onClick: function(e) {
    var a = e.findElement('a');
    if (a && this.links.indexOf(a) != -1) {
      e.stop();
	    this.show(a);
	    this.links.without(a).each(this.hide.bind(this));
    }
  },  
  
  hide : function(a) {
    var tab = this.getTabForLink(a);
    if (tab.visible) { 
	    this.container.fire('tabs:deactivate', { tab: tab.id });
      tab.hide();
      a.up('li').removeClassName(this.options.selectedClass);
    }
  },
  
  show : function(a) {
    var tab = this.getTabForLink(a);
    a.up('li').addClassName(this.options.selectedClass);
    tab.show();
    this.container.fire('tabs:activate', { tab: tab.id });
  },
  
  /**
   * Return the tab corresponding to a link
   */
  getTabForLink: function(a) {
    return $(this.getTabId(a.getAttribute('href')));
  },
  
  /**
   * return the tab ID extracted from a url anchor, null if none.
   The corresponding tab content div should have an ID with the same value
   @ href: the URL string
   */
  getTabId: function(href) {
    return href.match(/#(\w.+)/)? RegExp.$1 : null;
  },
  
  getInitialTab : function() {
    var loc = this.getTabId(document.location.href);
    var tab = null;
    if(loc) {
      tab = this.links.find(function(e) { 
        return this.getTabId(e.href) == loc; 
      }.bind(this));
    }
    return tab || this.links.first();
  }
  
});
