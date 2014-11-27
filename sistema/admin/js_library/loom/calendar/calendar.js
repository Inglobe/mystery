/**
 * Prototype-Based JavaScript Calendar
 * 
 * This component has been based on previous work from: 
 *
 * CalendarView by Justin Mecham: http://www.calendarview.org/ 
 * Copyright 2007 Singlesnet, Inc.
 * Copyright 2002-2005 Mihai Bazon
 *
 * Dynarch Calendar: http://www.dynarch.com/projects/calendar
 * Copyright 2003-2008 Dynarch.com
 *
 * This calendar is under the terms of the GNU Lesser General Public License (LGPL):
 * http://www.gnu.org/licenses/lgpl-3.0.txt
 * 
 * Alternatively, this file is licensed under the terms of the Apache Software License version 2.  
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 * 
 */
loom.ui.Calendar = Class.create({

	//------------------------------------------------------------------------------
	// Calendar Instance
	//------------------------------------------------------------------------------

	// The HTML Container Element
	container: null,

	// Callbacks
	selectHandler: null,
	closeHandler: null,

	// Dates
	date: new Date(),
	currentDateElement: null,
	currentHourElement: null,
	currentAMPMElement: null,
	currentMinuteElement: null,

	// Status
	shouldClose: false,
	isPopup: true,

	dateField: null,

	//----------------------------------------------------------------------------
	// Initialize
	//----------------------------------------------------------------------------
	/**
	 * Constructor
	 * @param {Element} dateField the input field used to introduce the date, or a DIV to display the selected date for information purposes. May be empty
	 * @param {Object} options used to customize this Calendar instance
	 */
	initialize: function(dateField, options) {
		this.options = Object.extend({
				triggerElement : null, // the component that triggers the calendar to open. If none is specified, a link will be created next to the field
				parentElement : null, // if specified, the datefield will be used embedded instead of popup
				selectHandler : null,
				closeHandler : null,
				dateFormat: null, // the date format in PHP's strftime format, or a DateParser instance
				minValue : null, // minimum allowed Date
				maxValue : null, // maximum allowed Date
				excludeMin: false, // is minValue a valid Date
				excludeMax: true, // is maxValue a valid Date
				minYear: 1900, // the minimum allowed year
				maxYear: 2100, // the maximum allowed year
				layout: 'horizontal' // vertical to put the time zone under the calendar, horizontal to put it at the side
			}, options || {});

		this.dateParser = new loom.format.DateParser(this.options.dateFormat);
		
		if (dateField) {
			this.dateField = $(dateField);
			this.dateField.setAttribute("autocomplete", "off");
			this.dateField.calendar = this;
		}

		this.selectHandler = this.options.selectHandler || loom.ui.Calendar.defaultSelectHandler;
		this.handleMouseUpEventBound = this.handleMouseUpEvent.bindAsEventListener(this);
		this.handleKeypressEventBound = this.handleKeypressEvent.bindAsEventListener(this);
		
		this.isPopup = !this.options.parentElement;
		if (!this.isPopup) {
			// In-Page Calendar
			this.options.parentElement = $(this.options.parentElement);
			this.show();
			
		} else { 
			// Popup Calendars
		    this.closeHandler = this.options.closeHandler || loom.ui.Calendar.defaultCloseHandler;
		    this.checkCalendarBound = this.checkCalendar.bindAsEventListener(this);

	    	this.triggerElement = this.options.triggerElement? 
	    			$(this.options.triggerElement) : 
	    			this.dateField.insert({ after: '<a class="dateButton">' + loom.messages['loom.ui.calendar.selectDate'] + '</a>' }).next('.dateButton');
		    this.triggerElement.observe('click', function() {		    	
		  	    this.show();
		  	    this.container.down('button').focus();
	    	}.bindAsEventListener(this));
		}
	},

	//----------------------------------------------------------------------------
	// Create/Draw the Calendar HTML Elements
	//----------------------------------------------------------------------------

	create: function() {
		// Calendar Table
		var table = new Element('table', {className : 'calendar'});
		
		// Calendar Header
		var thead = new Element('thead');
		table.appendChild(thead);
		
		// Title Placeholder
		var row = new Element('tr');
		row.appendChild(new Element('td', {colspan : 7, className : 'title'}));
		thead.appendChild(row);
		
		// Calendar Navigation
		row = new Element('tr');
		this._drawButtonCell(row, '&#x00ab;', 1, loom.ui.Calendar.NAV_PREVIOUS_YEAR);
		this._drawButtonCell(row, '&#x2039;', 1, loom.ui.Calendar.NAV_PREVIOUS_MONTH);
		this._drawButtonCell(row, loom.messages['loom.ui.calendar.today'], 3, loom.ui.Calendar.NAV_TODAY);
		this._drawButtonCell(row, '&#x203a;', 1, loom.ui.Calendar.NAV_NEXT_MONTH);
		this._drawButtonCell(row, '&#x00bb;', 1, loom.ui.Calendar.NAV_NEXT_YEAR);
		thead.appendChild(row);
		
		// Day Names
		row = new Element('tr');
		var weekOffset = parseInt(loom.messages['loom.ui.calendar.firstDayInWeek']);
		for (var i = 0; i < 7; ++i) {
			var cell = new Element('th').update(this.dateParser.dayFirstChar[(i + weekOffset) % 7]);
			(i == 0 || i == 6) && cell.addClassName('weekend');
			row.appendChild(cell);
		}
		thead.appendChild(row);
		
		// Calendar Days
		var tbody = table.appendChild(new Element('tbody'));
		for (i = 6; i > 0; --i) {
			row = tbody.appendChild(new Element('tr', { className: 'days' }));
			for (var j = 7; j > 0; --j) {
				cell = row.appendChild(new Element('td'));
				cell.calendar = this;
				cell.navAction = loom.ui.Calendar.NAV_SELECT;
			}
		}
		
		// Calendar Container (div)
		this.container = new Element('div', { className: 'calendar' });
		if (this.dateParser.hasTime() && this.options.layout == 'horizontal') {
			this.container.addClassName('horizontal');
		}
		if (this.isPopup) {
			var pos = this.triggerElement.cumulativeOffset();
			this.container.setStyle({ position: 'absolute', display: 'none', left: pos.left + 'px', top: pos.top + 'px' });
			this.container.addClassName('popup');
		}
		this.container.appendChild(table);

		if (this.dateParser.hasTime()) {
			
			// Time table
			var table = new Element('table', {className : 'time'});
			
			// Time Header
			var thead = new Element('thead');
			table.appendChild(thead);
			
			// Title Placeholder
			var row = new Element('tr');
			var td = new Element('td', {colspan : 7, className : 'title'});
			td.update(loom.messages['loom.ui.calendar.timeTitle']);
			row.appendChild(td);
			thead.appendChild(row);

			// Hours 
			var tbody = table.appendChild(new Element('tbody'));
			var cal = this;
	
			var addHoursRow = function(start) {
				row = new Element('tr', {className : 'hours'});
				$R(start, start + 5).each(function(t) { cal._drawCell(row, t, 1, loom.ui.Calendar.NAV_HOUR_SELECT); });
				start == 0 && cal._drawCell(row, 'AM', 1, loom.ui.Calendar.NAV_HOUR_AM);
				start == 6 && cal._drawCell(row, 'PM', 1, loom.ui.Calendar.NAV_HOUR_PM);
				tbody.appendChild(row);
			}
			addHoursRow(0);
			addHoursRow(6);
			
			// separator
			tbody.insert('<tr class="sep"><td colspan="7"><hr/></td></tr>');
			
			// minutes
			var addMinutesRow = function(start) {
				row = new Element('tr', {className : 'minutes'});
				$R(start, start + 5).each(function(t) { cal._drawCell(row, ':' + (t*5).toPaddedString(2), 1, loom.ui.Calendar.NAV_MINUTE_SELECT); });
				row.appendChild(new Element('td'));
				tbody.appendChild(row);
			}
			addMinutesRow(0);
			addMinutesRow(6);

			// exact minutes
			row = ('<tr class="exactMinutes"><td className="label" colspan="5">#{label}</td>' + 
			'<td class="minutes button"><input type="text" maxlength="2"/></td><td></td></tr>').interpolate({ label: loom.messages['loom.ui.calendar.exactMinutes']});
			tbody.insert(row);
			tbody.down('td.minutes input').observe('change', this.handleExactChangeEvent.bindAsEventListener(this));
			
			this.container.appendChild(table);
		}
		
		// Initialize Calendar
		this.setDateAsString(this.dateField.value);
		
		// Observe the container for mousedown events
		this.container.observe('mousedown', this.handleMouseDownEvent.bindAsEventListener(this));
		
		// Append to parent element
		(this.options.parentElement || $$('body')[0]).appendChild(this.container);
	},

	/** draw a button cell (next/prev month, year, etc) */
	_drawButtonCell: function(parent, text, colSpan, navAction) {
		var cell = new Element('td', {className : 'button'});
		if (colSpan > 1) cell.colSpan = colSpan;
		cell.unselectable = 'on'; // IE
		
		var button =  new Element('button');
		button.calendar = this;
		button.navAction = navAction;
		button.innerHTML = text;
		cell.appendChild(button);
		
		parent.appendChild(cell);
		return cell;
	},

	/** draw a cell (select day, select minute, etc) */
	_drawCell: function(parent, text, colSpan, navAction) {
		var cell = new Element('td', {className : 'button'});
		if (colSpan > 1) cell.colSpan = colSpan;
		cell.unselectable = 'on'; // IE
		cell.calendar = this;
		cell.navAction = navAction;
		cell.innerHTML = text;
		parent.appendChild(cell);
		return cell;
	},


	/**
	 * Update / (Re)initialize Calendar
	 */ 
	update: function(date) {
		if (isNaN(date)) date = new Date();
		
		var today = new Date();
		var thisYear = today.getFullYear();
		var thisMonth = today.getMonth();
		var thisDay = today.getDate();
		var month = date.getMonth();
		var dayOfMonth = date.getDate();

		this.date = new Date(date);
		
		this.container.down('td.title').update( this.dateParser.monthNames[month] + ' ' + date.getFullYear() );

		// Calculate the first day to display (probably on the previous month)
		var weekOffset = parseInt(loom.messages['loom.ui.calendar.firstDayInWeek']);
		date.setDate(1);
		date.setDate(1 + weekOffset - date.getDay());

		// Fill in the days of the month
		this.container.select('table.calendar tbody tr').each(function(row, i) {
			var rowHasDays = false;
			row.immediateDescendants().each(function(cell, j) {
				var day	= date.getDate();
				var dayOfWeek = date.getDay();
				var isCurrentMonth = (date.getMonth() == month);

				// Reset classes on the cell
				cell.className = '';
				cell.date = new Date(date);
				cell.update(day);

				// Account for days of the month other than the current month
				if (this.checkDateInRange(date)) {
					if (!isCurrentMonth) {
					  cell.addClassName('otherDay');
					} else {
					  cell.addClassName('button');
					  rowHasDays = true;
					} 
				} else {
					cell.addClassName('unselectable');
					if (isCurrentMonth) {
					  rowHasDays = true;
					}
				}

				// Ensure the current day is selected
				if (isCurrentMonth && day == dayOfMonth) {
				  cell.addClassName('selected');
				  this.currentDateElement = cell;
				}

				// Today
				if (date.getFullYear() == thisYear && date.getMonth() == thisMonth && day == thisDay) {
					cell.addClassName('today');
				}

				// Weekend
				if ([0, 6].indexOf(dayOfWeek) != -1) {
					cell.addClassName('weekend');
				}
				
				// Set the date to tomorrow
				date.setDate(day + 1);
			}.bind(this));
		
			// Hide the extra row if it contains only days from another month
			!rowHasDays ? row.hide() : row.show();
		}.bind(this));

		if (this.dateParser.hasTime()) {		
			var rows = this.container.select('table.time tbody tr');
			
			// AM/PM
			var row = rows[this.isPM()? 1 : 0];
			var cell = row.select('td')[6];
	 
			this.currentAMPMElement && this.currentAMPMElement.removeClassName('selected');
			this.currentAMPMElement = cell;
			cell.addClassName('selected');
	
			// Hours
			row = rows[parseInt((date.getHours() % 12) / 6)];
			cell = row.select('td')[date.getHours() % 6];
			
			this.currentHourElement && this.currentHourElement.removeClassName('selected');
			this.currentHourElement = cell;
			cell.addClassName('selected');
			
			// Minutes
			if (this.currentMinuteElement) {
				this.currentMinuteElement.removeClassName('selected');
				var input = this.currentMinuteElement.down('input');
				if (input) input.value = '';
			}
			if ((date.getMinutes() % 5) != 0) { // Exact minutes
				cell = this.container.down('table.time td.minutes');
				cell.down('input').value = date.getMinutes();
			} else { // Cell minutes
				row = rows[3 + (date.getMinutes() > 29? 1 : 0)];
				cell = Element.getElementsBySelector(row, 'td')[Math.floor((date.getMinutes() % 30) / 5)];
			}
			this.currentMinuteElement = cell;			
			cell.addClassName('selected');
		}
		
	},

	//------------------------------------------------------------------------------
	// Callbacks
	//------------------------------------------------------------------------------

	// Calls the Select Handler (if defined)
	callSelectHandler: function() {
		this.selectHandler && this.selectHandler(this, this.date.format(this.dateParser.format));
	},

	// Calls the Close Handler (if defined)
	callCloseHandler: function() {
		this.closeHandler && this.closeHandler(this);
	},

	//------------------------------------------------------------------------------
	// Calendar Display Functions
	//------------------------------------------------------------------------------

	// Shows the Calendar
	show: function() {
		this.container || this.create(); // lazy init
		this.dateField.value && this.setDateAsString(this.dateField.value);
		
		// calculate calendar position
		if (this.isPopup) {
			var pos = this.triggerElement.cumulativeOffset();
			var maxTop = document.viewport.getScrollOffsets().top + document.viewport.getHeight() - this.container.getHeight();
			var top = pos.top < maxTop? pos.top : maxTop;
			this.container.setStyle({ left: pos.left + 'px', top: top + 'px' });
		}

		this.container.show();
		this.isPopup && Event.observe(document, 'mousedown', this.checkCalendarBound);
		this.container.observe('keypress', this.handleKeypressEventBound);
		
	},

	// Hides the Calendar
	hide: function() {
		this.isPopup && Event.stopObserving(document, 'mousedown', this.checkCalendarBound);
		this.container.stopObserving('keypress', this.handleKeypressEventBound);
		this.container.hide();
	},

	setDate: function(date) {
		if (!this.isSameDateTime(date)) {
			this.update(date);
		}
	},
	
	/**
	 * Set the calendar value, if it's not empty
	 * @param text the date value, in the same format used by the calendar
	 */
	setDateAsString: function(text) {
		this.setDate(this.dateParser.parse(text));
	},
	
	/** return true is the current hour is AM (< 12), false if PM (> 11) */
	isAM: function() {
		return this.date.getHours() < 12;
	},
	
	isPM: function() {
		return !this.isAM();
	},
	
	/** Checks if the proposed date is the same as this calendar, up to the minute */
	isSameDateTime: function(date) {
	  if (isNaN(date)) return this.date == new Date();
	  return parseInt(this.date.getTime() / Date.MINUTE) == parseInt(date.getTime() / Date.MINUTE);
	},

	// This method gets called when the user presses a mouse button anywhere in the
	// document, if the calendar is shown. If the click was outside the open
	// calendar this function closes it.
	checkCalendar : function(event) {
		if (Element.descendantOf(event.element(), this.container)) {
			return;
		}
		this.callCloseHandler();
		event.stop();
	},

	// Checks if the supplied date is with in the user defined date range, if any,  
	checkDateInRange : function(date) {
  	    var o = this.options;
		return !(o.minValue && (o.excludeMin && date <= o.minValue || !o.excludeMin && date < o.minValue)) && 
			   !(o.maxValue && (o.excludeMax && date >= o.maxValue || !o.excludeMax && date > o.maxValue));
	},
	
	//------------------------------------------------------------------------------
	// Event Handlers
	//------------------------------------------------------------------------------
	handleMouseDownEvent : function(evt) {
		var el = evt.element();

		if (el.descendantOf(this.container) && this.container.visible() && el.tagName == 'INPUT') {
			return true;	
		} else {
			Event.observe(document, 'mouseup', this.handleMouseUpEventBound);
			evt.stop();
		}
	},

	handleMouseUpEvent : function(evt) {
		var el = evt.element();
		var calendar = el.calendar;
		
		// If the element that was clicked on does not have an associated Calendar
		// object, return as we have nothing to do.
		if (this != calendar) return false;
	
		this.handleNavAction(el.navAction, el);
	
		Event.stopObserving(document, 'mouseup', this.handleMouseUpEventBound);
	
		return evt.stop();
	},
	
	handleExactChangeEvent : function (evt) {
		var input = evt.element();
		var el = evt.findElement('td');
		var minute = parseInt(input.value);

		if (!isNaN(minute)) {			
			if (this.currentMinuteElement) {
				this.currentMinuteElement.removeClassName('selected');			
				el.addClassName('selected');
				this.currentMinuteElement = el;
			}
			var minute = parseInt(input.value);
			this.date.setMinutes(minute);
			
			this.container.select('button')[0].focus();
			this.callSelectHandler();
		}
		
		evt.stop();
	},

	/** transforms a keypress into the corresponding action, and invokes it */
	handleKeypressEvent : function(evt) {
		
		var keymap = loom.ui.Calendar[ evt.ctrlKey? 'ctrlKeyMap' : evt.shiftKey? 'shiftKeyMap' : evt.altKey? 'altKeyMap' : 'keyMap' ]; 
		var navAction = keymap[evt.keyCode? evt.keyCode : evt.which];
		if (navAction) {
			this.handleNavAction(navAction);
			evt.stop();
		}
		
	},
	
	/**
	 * Perform an action on the selected date
	 */
	handleNavAction : function(navAction, el) {
		el = el || this.currentDateElement;
		var newDate = new Date(this.date);
		this.shouldClose = false;
		
		var year = newDate.getFullYear();
		var mon = newDate.getMonth();
		
		// change a month and modify the day of the month if too big
		function setMonth(date, m) {
			var day = date.getDate();
			var max = date.getMonthDays(m);
			if (day > max) date.setDate(max);
			date.setMonth(m);
		}
		
		switch (navAction) {
		
		// No-op and close
		case loom.ui.Calendar.CLOSE: 
			this.shouldClose = true;
			break;
		
		// Clicked on a day
		case loom.ui.Calendar.NAV_SELECT:
			if (this.checkDateInRange(el.date)) {
				if (this.currentDateElement != el) {
					this.currentDateElement && this.currentDateElement.removeClassName('selected');
					el.addClassName('selected');
					this.currentDateElement = el;
					newDate = el.date;
					this.shouldClose = !el.hasClassName('otherDay');
				} else {
					this.shouldClose = true;
				}
			}
			break;
			
		// Clicked on an hour
		case loom.ui.Calendar.NAV_HOUR_SELECT:
			this.currentHourElement && this.currentHourElement.removeClassName('selected');
			this.currentHourElement = el;
			el.addClassName('selected');
			var hour = parseInt(el.innerHTML);
			if (this.isPM()) hour += 12;	
			newDate.setHours(hour);
			break;
		
		// Clicked on a minute
		case loom.ui.Calendar.NAV_MINUTE_SELECT:
			if (this.currentMinuteElement) {
				this.currentMinuteElement.removeClassName('selected');
				var input = this.currentMinuteElement.down('input');
				if (input) input.value = '';
			}
			el.addClassName('selected');
			this.currentMinuteElement = el;
			var minute = parseInt(el.innerHTML.substr(1));
			newDate.setMinutes(minute);
			break;
			
		// Clicked on AM or PM
		case loom.ui.Calendar.NAV_HOUR_AM:
		case loom.ui.Calendar.NAV_HOUR_PM:
			
			this.currentAMPMElement && this.currentAMPMElement.removeClassName('selected');
			el.addClassName('selected');
			this.currentAMPMElement = el;
			if (navAction == loom.ui.Calendar.NAV_HOUR_AM && this.isPM()) {
				newDate.setHours(this.date.getHours() - 12);
			} else if (navAction == loom.ui.Calendar.NAV_HOUR_PM && this.isAM()) {
				newDate.setHours(this.date.getHours() + 12);
			}
			break;

		// Previous Year
		case loom.ui.Calendar.NAV_PREVIOUS_YEAR:
			newDate.setFullYear(year - 1);
			break;
			
		// Next Year
		case loom.ui.Calendar.NAV_NEXT_YEAR:
			newDate.setFullYear(year + 1);
			break;

		// Previous Month
		case loom.ui.Calendar.NAV_PREVIOUS_MONTH:
			setMonth(newDate, mon - 1);
			break;
			
		// Next Month
		case loom.ui.Calendar.NAV_NEXT_MONTH:
			setMonth(newDate, mon + 1);
			break;
			
		// Previous Week
		case loom.ui.Calendar.NAV_PREVIOUS_WEEK:
			newDate.setDate(newDate.getDate() - 7);
			break;
			
		// Next Week
		case loom.ui.Calendar.NAV_NEXT_WEEK:
			newDate.setDate(newDate.getDate() + 7);
			break;

		// Today
		case loom.ui.Calendar.NAV_TODAY:
			newDate = new Date();
			break;
			
		// Previous Day
		case loom.ui.Calendar.NAV_PREVIOUS_DAY:
			newDate.setDate(newDate.getDate() - 1);
			break;
			
		// Next Day
		case loom.ui.Calendar.NAV_NEXT_DAY:
			newDate.setDate(newDate.getDate() + 1);
			break;

		}
		
		if (!this.isSameDateTime(newDate) && this.checkDateInRange(newDate)) {
			this.setDate(newDate);
			this.callSelectHandler();
		} else if (this.shouldClose) {
			this.callCloseHandler();
		}
	
	}
		
}); // end Calendar class

// static methods
Object.extend(loom.ui.Calendar, {
	
	NAV_CLOSE : -5,
	NAV_PREVIOUS_YEAR : -4,
	NAV_PREVIOUS_MONTH : -3,
	NAV_PREVIOUS_WEEK : -2,
	NAV_PREVIOUS_DAY : -1,
	NAV_TODAY :  1,
	NAV_NEXT_DAY : 2,
	NAV_NEXT_WEEK : 3,
	NAV_NEXT_MONTH	: 4,
	NAV_NEXT_YEAR : 5,
	NAV_SELECT : 6,
	
	NAV_PREVIOUS_HOUR : 100,
	NAV_PREVIOUS_MINUTE : 101,
	NAV_NEXT_MINUTE : 102,
	NAV_NEXT_HOUR : 103,
	NAV_HOUR_SELECT : 104,
	NAV_HOUR_AM : 105,
	NAV_HOUR_PM : 106,
	NAV_MINUTE_SELECT : 107,
	
	defaultSelectHandler: function(calendar, dateString) {
		if (!calendar.dateField) return false;
	
		// Update dateField value
		if (calendar.dateField.tagName == 'DIV') {
			calendar.dateField.update(dateString);
		} else if (calendar.dateField.tagName == 'INPUT') {
			this.dateField.value = dateString;
		}
	
		// Trigger the onchange callback on the dateField, if one has been defined
		if (typeof calendar.dateField.onchange == 'function')
			calendar.dateField.onchange();
	
		this.dateField.validate && this.dateField.validate();
		this.dateField.fire('calendar:change');
		
		// Call the close handler, if necessary
		if (calendar.shouldClose) calendar.callCloseHandler();
	},
	
	defaultCloseHandler: function(calendar) {
		calendar.hide();
	}

});


//------------------------------------------------------------------------------
// Class constants
// The init method will never be called, we needed a way to avoid repeating "loom.ui.Calendar" all over
//------------------------------------------------------------------------------

(function(cal) {
	
	// Create a map using the key code, instead of the key name
	var createKeyMap = function(keys) {
		var result = {};
		for (var key in keys) {
			result[Event[key]] = keys[key];
		}
		return result;
	}
	
	cal.keyMap = createKeyMap({ KEY_RETURN: cal.NAV_SELECT, KEY_ESC: cal.NAV_CLOSE, KEY_LEFT: cal.NAV_PREVIOUS_DAY, 
			KEY_UP: cal.NAV_PREVIOUS_WEEK, KEY_RIGHT: cal.NAV_NEXT_DAY, KEY_DOWN: cal.NAV_NEXT_WEEK });
	cal.ctrlKeyMap = createKeyMap({ KEY_LEFT: cal.NAV_PREVIOUS_YEAR, KEY_RIGHT: cal.NAV_NEXT_YEAR });
	cal.shiftKeyMap = createKeyMap({ KEY_LEFT: cal.NAV_PREVIOUS_MONTH, KEY_RIGHT: cal.NAV_NEXT_MONTH });
	cal.altKeyMap = createKeyMap({ KEY_LEFT: cal.NAV_PREVIOUS_HOUR, KEY_RIGHT: cal.NAV_NEXT_HOUR });
	
})(loom.ui.Calendar);

/**
 * Creates a popup calendar bound to an input text field 
 * @param {Element} element the input type=text" field to bind the calendar to
 * @return the created instance of loom.ui.Calendar
 */
loom.ui.createCalendar = function(element, options) {
	element = $(element);
	if (!element.disabled) {
		options = Object.extend({
			dateFormat: new loom.format.DateParser(element).format,
			minValue: element.getAttributeAsDate('min'),
			maxValue: element.getAttributeAsDate('max'),
			excludeMin: element.getExtendedAttributeAsBoolean('exclude-min'),
			excludeMax: element.getExtendedAttributeAsBoolean('exclude-max', 'true')
		}, options || {})
		return new loom.ui.Calendar(element, options);
	}
}