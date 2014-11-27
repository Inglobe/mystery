/**
 * Link tables where the first link of each row is used when clicking anywhere in the row. 
 *
 * @author rgrocha 
 * @author icoloma 
 */
loom.ui.tables = {

  /**
   * A table where each row is clickable and behaves as a single link
   */
  LinkTable: Class.create({
  
    initialize: function(table) {
      // add CSS class to link rows
      table.select('a').each(function(a) {
        var tr = a.up('tr');
        tr && !tr.up('thead') && tr.addClassName('link');
      });
      
      // listen to click event, using event delegation
      table.observe('click', this.onclick.bindAsEventListener(this));
    },
    
    onclick: function(event) {
      var tagName = event.target.tagName;
      if (tagName != 'INPUT' && tagName != 'SELECT' && tagName != 'A') { 
        var tr = event.findElement('tr');
        var a = tr == null? null : tr.down('td a');
        if (a != null) {
          event.stop();
          this.redirect(a.href);
        }
      }
    },
    
    /** to override in testcases */
    redirect: function(href) {
      window.location.href = href;
    }
  
  }),
  
  /**
	 * Multiple checkbox handling routines.
	 * This class binds a set of checkboxes with a global "select/unselect all" 
	 * checkbox.
	 *
	 * To use, new MultiCheckbox(table);
	 * 
	 * This class will put an extra checkBox (a "gswitch") on the header cell of the first column
	 * where checkboxes are detected. This gswitch will check and uncheck all checkboxes at once. 
	 *
	 * @author icoloma
	 */
	MultiCheckbox: Class.create({
	
	   initialize: function(table, options) {
	     table = $(table);
	     this.checkboxes = table.select('input[type=checkbox]');
	     options = Object.extend({
	        // the position of the global switch column, starting at 0. If not set, 
	        // the first column with a checkbox will be used. In that case, if none is found
	        // (ex. the table is empty) nothing will be initialized.
	       switchColumn: -1
	     }, options || {});
	     this.options = options;
	     
	     this.column = options.switchColumn;
	     if (this.column == -1 && this.checkboxes.size() > 0) {
	       // locate the corresponding th
	       this.column = this.getColumnIndex(this.checkboxes.first());
	     }
	     
	     if (this.column != -1) {
	       // add the gswitch component
	       var th = table.select('th')[this.column];
	       th.update('<input type="checkbox" class="checkbox"/>');
	       this.gswitch = th.down('input');
	       
	       // remove checkboxes on other columns  from the list of managed checkboxes
	       this.checkboxes = this.checkboxes.findAll(function(i) { return this.getColumnIndex(i) == this.column; }.bind(this));
	       table.observe('click', this.onClick.bindAsEventListener(this));
	     }
	   },
	   
	   // return the column index of a checkbox
	   getColumnIndex: function(input) {
	     var cells = input.up('tr').select('td'); 
       return cells.indexOf(input.up('td'));
	   },
	   
	   // fired when a managed checkbox is clicked
	   onClick: function(event) {
	     var input = event.findElement('input[type=checkbox]');
	     if (input) {
	       if (input == this.gswitch) {
		         this.onSwitchClick();
	       } else if (this.checkboxes.indexOf(input) != -1) { // if it's a managed checkbox
			      this.gswitch.checked = !input.checked? false : this.checkboxes.pluck('checked').all();
		   }
	     }
	   },
	   
	   // fired when the global switch has been clicked
	   onSwitchClick: function() {
	     this.checkboxes.each(function(element) { element.checked = this.gswitch.checked }.bind(this) );
	   }
	   
	})

}
