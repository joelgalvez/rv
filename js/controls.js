// Flash Player Version Detection - Rev 1.6
// Detect Client Browser type
// Copyright(c) 2005-2006 Adobe Macromedia Software, LLC. All rights reserved.
var isIE  = (navigator.appVersion.indexOf("MSIE") != -1) ? true : false;
var isWin = (navigator.appVersion.toLowerCase().indexOf("win") != -1) ? true : false;
var isOpera = (navigator.userAgent.indexOf("Opera") != -1) ? true : false;

function ControlVersion()
{
	var version;
	var axo;
	var e;

	// NOTE : new ActiveXObject(strFoo) throws an exception if strFoo isn't in the registry

	try {
		// version will be set for 7.X or greater players
		axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
		version = axo.GetVariable("$version");
	} catch (e) {
	}

	if (!version)
	{
		try {
			// version will be set for 6.X players only
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");

			// installed player is some revision of 6.0
			// GetVariable("$version") crashes for versions 6.0.22 through 6.0.29,
			// so we have to be careful.

			// default to the first public version
			version = "WIN 6,0,21,0";

			// throws if AllowScripAccess does not exist (introduced in 6.0r47)
			axo.AllowScriptAccess = "always";

			// safe to call for 6.0r47 or greater
			version = axo.GetVariable("$version");

		} catch (e) {
		}
	}

	if (!version)
	{
		try {
			// version will be set for 4.X or 5.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
			version = axo.GetVariable("$version");
		} catch (e) {
		}
	}

	if (!version)
	{
		try {
			// version will be set for 3.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
			version = "WIN 3,0,18,0";
		} catch (e) {
		}
	}

	if (!version)
	{
		try {
			// version will be set for 2.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
			version = "WIN 2,0,0,11";
		} catch (e) {
			version = -1;
		}
	}

	return version;
}

// JavaScript helper required to detect Flash Player PlugIn version information
function GetSwfVer(){
	// NS/Opera version >= 3 check for Flash plugin in plugin array
	var flashVer = -1;

	if (navigator.plugins != null && navigator.plugins.length > 0) {
		if (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]) {
			var swVer2 = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
			var flashDescription = navigator.plugins["Shockwave Flash" + swVer2].description;
			var descArray = flashDescription.split(" ");
			var tempArrayMajor = descArray[2].split(".");
			var versionMajor = tempArrayMajor[0];
			var versionMinor = tempArrayMajor[1];
			var versionRevision = descArray[3];
			if (versionRevision == "") {
				versionRevision = descArray[4];
			}
			if (versionRevision[0] == "d") {
				versionRevision = versionRevision.substring(1);
			} else if (versionRevision[0] == "r") {
				versionRevision = versionRevision.substring(1);
				if (versionRevision.indexOf("d") > 0) {
					versionRevision = versionRevision.substring(0, versionRevision.indexOf("d"));
				}
			}
			var flashVer = versionMajor + "." + versionMinor + "." + versionRevision;

		}
	}
	// MSN/WebTV 2.6 supports Flash 4
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.6") != -1) flashVer = 4;
	// WebTV 2.5 supports Flash 3
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.5") != -1) flashVer = 3;
	// older WebTV supports Flash 2
	else if (navigator.userAgent.toLowerCase().indexOf("webtv") != -1) flashVer = 2;
	else if ( isIE && isWin && !isOpera ) {
		flashVer = ControlVersion();
	}
	return flashVer;
}

// When called with reqMajorVer, reqMinorVer, reqRevision returns true if that version or greater is available
function DetectFlashVer(reqMajorVer, reqMinorVer, reqRevision)
{
	versionStr = GetSwfVer();
	if (versionStr == -1 ) {
		return false;
	} else if (versionStr != 0) {
		if(isIE && isWin && !isOpera) {
			// Given "WIN 2,0,0,11"
			tempArray         = versionStr.split(" "); 	// ["WIN", "2,0,0,11"]
			tempString        = tempArray[1];			// "2,0,0,11"
			versionArray      = tempString.split(",");	// ['2', '0', '0', '11']
		} else {
			versionArray      = versionStr.split(".");
		}
		var versionMajor      = versionArray[0];
		var versionMinor      = versionArray[1];
		var versionRevision   = versionArray[2];

        	// is the major.revision >= requested major.revision AND the minor version >= requested minor
		if (versionMajor > parseFloat(reqMajorVer)) {
			return true;
		} else if (versionMajor == parseFloat(reqMajorVer)) {
			if (versionMinor > parseFloat(reqMinorVer))
				return true;
			else if (versionMinor == parseFloat(reqMinorVer)) {
				if (versionRevision >= parseFloat(reqRevision))
					return true;
			}
		}
		return false;
	}
}

function AC_AddExtension(src, ext)
{
  if (src.indexOf('?') != -1)
    return src.replace(/\?/, ext+'?');
  else
    return src + ext;
}

function AC_Generateobj(objAttrs, params, embedAttrs)
{
    var str = '';
    if (isIE && isWin && !isOpera)
    {
  		str += '<object ';
  		for (var i in objAttrs)
  			str += i + '="' + objAttrs[i] + '" ';
  		for (var i in params)
  			str += '><param name="' + i + '" value="' + params[i] + '" /> ';
  		str += '></object>';
    } else {
  		str += '<embed ';
  		for (var i in embedAttrs)
  			str += i + '="' + embedAttrs[i] + '" ';
  		str += '> </embed>';
    }

    document.write(str);
}

function AC_FL_RunContent(){
  var ret =
    AC_GetArgs
    (  arguments, ".swf", "movie", "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
     , "application/x-shockwave-flash"
    );
  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
}

function AC_GetArgs(args, ext, srcParamName, classid, mimeType){
  var ret = new Object();
  ret.embedAttrs = new Object();
  ret.params = new Object();
  ret.objAttrs = new Object();
  for (var i=0; i < args.length; i=i+2){
    var currArg = args[i].toLowerCase();

    switch (currArg){
      case "classid":
        break;
      case "pluginspage":
        ret.embedAttrs[args[i]] = args[i+1];
        break;
      case "src":
      case "movie":
        args[i+1] = AC_AddExtension(args[i+1], ext);
        ret.embedAttrs["src"] = args[i+1];
        ret.params[srcParamName] = args[i+1];
        break;
      case "onafterupdate":
      case "onbeforeupdate":
      case "onblur":
      case "oncellchange":
      case "onclick":
      case "ondblClick":
      case "ondrag":
      case "ondragend":
      case "ondragenter":
      case "ondragleave":
      case "ondragover":
      case "ondrop":
      case "onfinish":
      case "onfocus":
      case "onhelp":
      case "onmousedown":
      case "onmouseup":
      case "onmouseover":
      case "onmousemove":
      case "onmouseout":
      case "onkeypress":
      case "onkeydown":
      case "onkeyup":
      case "onload":
      case "onlosecapture":
      case "onpropertychange":
      case "onreadystatechange":
      case "onrowsdelete":
      case "onrowenter":
      case "onrowexit":
      case "onrowsinserted":
      case "onstart":
      case "onscroll":
      case "onbeforeeditfocus":
      case "onactivate":
      case "onbeforedeactivate":
      case "ondeactivate":
      case "type":
      case "codebase":
        ret.objAttrs[args[i]] = args[i+1];
        break;
      case "id":
      case "width":
      case "height":
      case "align":
      case "vspace":
      case "hspace":
      case "class":
      case "title":
      case "accesskey":
      case "name":
      case "tabindex":
        ret.embedAttrs[args[i]] = ret.objAttrs[args[i]] = args[i+1];
        break;
      default:
        ret.embedAttrs[args[i]] = ret.params[args[i]] = args[i+1];
    }
  }
  ret.objAttrs["classid"] = classid;
  if (mimeType) ret.embedAttrs["type"] = mimeType;
  return ret;
}

if(!DetectFlashVer(9, 0, 24)) {
	alert('You will need flash player version 9.0.24 or better to be able to upload images. Either your version is too old, or you are missing the Flash plugin.');
}



// don't declare anything out here in the global namespace

(function($) { // create private scope (inside you can use $ instead of jQuery)

    // functions and vars declared here are effectively 'singletons'.  there will be only a single
    // instance of them.  so this is a good place to declare any immutable items or stateless
    // functions.  for example:

	var today = new Date(); // used in defaults
        var months = 'January,February,March,April,May,June,July,August,September,October,November,December'.split(',');
	var monthlengths = '31,28,31,30,31,30,31,31,30,31,30,31'.split(',');
  	var dateRegEx = /^\d{1,2}\/\d{1,2}\/\d{2}|\d{4}$/;
	var yearRegEx = /^\d{4,4}$/;

    // next, declare the plugin function
    $.fn.simpleDatepicker = function(options) {

        // functions and vars declared here are created each time your plugn function is invoked

        // you could probably refactor your 'build', 'load_month', etc, functions to be passed
        // the DOM element from below

		var opts = jQuery.extend({}, jQuery.fn.simpleDatepicker.defaults, options);

		// replaces a date string with a date object in opts.startdate and opts.enddate, if one exists
		// populates two new properties with a ready-to-use year: opts.startyear and opts.endyear

		setupYearRange();
		/** extracts and setup a valid year range from the opts object **/
		function setupYearRange () {

			var startyear, endyear;
			if (opts.startdate.constructor == Date) {
				startyear = opts.startdate.getFullYear();
			} else if (opts.startdate) {
				if (yearRegEx.test(opts.startdate)) {
				startyear = opts.startdate;
				} else if (dateRegEx.test(opts.startdate)) {
					opts.startdate = new Date(opts.startdate);
					startyear = opts.startdate.getFullYear();
				} else {
				startyear = today.getFullYear();
				}
			} else {
				startyear = today.getFullYear();
			}
			opts.startyear = startyear;

			if (opts.enddate.constructor == Date) {
				endyear = opts.enddate.getFullYear();
			} else if (opts.enddate) {
				if (yearRegEx.test(opts.enddate)) {
					endyear = opts.enddate;
				} else if (dateRegEx.test(opts.enddate)) {
					opts.enddate = new Date(opts.enddate);
					endyear = opts.enddate.getFullYear();
				} else {
					endyear = today.getFullYear();
				}
			} else {
				endyear = today.getFullYear();
			}
			opts.endyear = endyear;
		}

		/** HTML factory for the actual datepicker table element **/
		// has to read the year range so it can setup the correct years in our HTML <select>
		function newDatepickerHTML () {

			var years = [];

			// process year range into an array
			for (var i = 0; i <= opts.endyear - opts.startyear; i ++) years[i] = opts.startyear + i;

			// build the table structure
			var table = jQuery('<table class="datepicker" cellpadding="0" cellspacing="0"></table>');
			table.append('<thead></thead>');
			table.append('<tfoot></tfoot>');
			table.append('<tbody></tbody>');

				// month select field
				var monthselect = '<select name="month">';
				for (var i in months) monthselect += '<option value="'+i+'">'+months[i]+'</option>';
				monthselect += '</select>';

				// year select field
				var yearselect = '<select name="year">';
				for (var i in years) yearselect += '<option>'+years[i]+'</option>';
				yearselect += '</select>';

			jQuery("thead",table).append('<tr class="controls"><th colspan="7"><span class="prevMonth">&laquo;</span>&nbsp;'+monthselect+yearselect+'&nbsp;<span class="nextMonth">&raquo;</span></th></tr>');
			jQuery("thead",table).append('<tr class="days"><th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th></tr>');
			jQuery("tfoot",table).append('<tr><td colspan="2"><span class="today">today</span></td><td colspan="3">&nbsp;</td><td colspan="2"><span class="close">close</span></td></tr>');
			for (var i = 0; i < 6; i++) jQuery("tbody",table).append('<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>');
			return table;
		}

		/** get the real position of the input (well, anything really) **/
		//http://www.quirksmode.org/js/findpos.html
		function findPosition (obj) {
			var curleft = curtop = 0;
			if (obj.offsetParent) {
				do {
					curleft += obj.offsetLeft;
					curtop += obj.offsetTop;
				} while (obj = obj.offsetParent);
				return [curleft,curtop];
			} else {
				return false;
			}
		}

		/** load the initial date and handle all date-navigation **/
		// initial calendar load (e is null)
		// prevMonth & nextMonth buttons
		// onchange for the select fields
		function loadMonth (e, el, datepicker, chosendate) {

			// reference our years for the nextMonth and prevMonth buttons
			var mo = jQuery("select[name=month]", datepicker).get(0).selectedIndex;
			var yr = jQuery("select[name=year]", datepicker).get(0).selectedIndex;
			var yrs = jQuery("select[name=year] option", datepicker).get().length;

			// first try to process buttons that may change the month we're on
			if (e && jQuery(e.target).hasClass('prevMonth')) {
				if (0 == mo && yr) {
					yr -= 1; mo = 11;
					jQuery("select[name=month]", datepicker).get(0).selectedIndex = 11;
					jQuery("select[name=year]", datepicker).get(0).selectedIndex = yr;
				} else {
					mo -= 1;
					jQuery("select[name=month]", datepicker).get(0).selectedIndex = mo;
				}
			} else if (e && jQuery(e.target).hasClass('nextMonth')) {
				if (11 == mo && yr + 1 < yrs) {
					yr += 1; mo = 0;
					jQuery("select[name=month]", datepicker).get(0).selectedIndex = 0;
					jQuery("select[name=year]", datepicker).get(0).selectedIndex = yr;
				} else {
					mo += 1;
					jQuery("select[name=month]", datepicker).get(0).selectedIndex = mo;
				}
			}

			// maybe hide buttons
			if (0 == mo && !yr) jQuery("span.prevMonth", datepicker).hide();
			else jQuery("span.prevMonth", datepicker).show();
			if (yr + 1 == yrs && 11 == mo) jQuery("span.nextMonth", datepicker).hide();
			else jQuery("span.nextMonth", datepicker).show();

			// clear the old cells
			var cells = jQuery("tbody td", datepicker).unbind().empty().removeClass('date');

			// figure out what month and year to load
			var m = jQuery("select[name=month]", datepicker).val();
			var y = jQuery("select[name=year]", datepicker).val();
			var d = new Date(y, m, 1);
			var startindex = d.getDay();
			var numdays = monthlengths[m];

			// http://en.wikipedia.org/wiki/Leap_year
			if (1 == m && ((y%4 == 0 && y%100 != 0) || y%400 == 0)) numdays = 29;

			// test for end dates (instead of just a year range)
			if (opts.startdate.constructor == Date) {
				var startMonth = opts.startdate.getMonth();
				var startDate = opts.startdate.getDate();
			}
			if (opts.enddate.constructor == Date) {
				var endMonth = opts.enddate.getMonth();
				var endDate = opts.enddate.getDate();
			}

			// walk through the index and populate each cell, binding events too
			for (var i = 0; i < numdays; i++) {

				var cell = jQuery(cells.get(i+startindex)).removeClass('chosen');

				// test that the date falls within a range, if we have a range
				if (
					(yr || ((!startDate && !startMonth) || ((i+1 >= startDate && mo == startMonth) || mo > startMonth))) &&
					(yr + 1 < yrs || ((!endDate && !endMonth) || ((i+1 <= endDate && mo == endMonth) || mo < endMonth)))) {

					cell
						.text(i+1)
						.addClass('date')
						.hover(
							function () { jQuery(this).addClass('over'); },
							function () { jQuery(this).removeClass('over'); })
						.click(function () {
							var chosenDateObj = new Date(jQuery("select[name=year]", datepicker).val(), jQuery("select[name=month]", datepicker).val(), jQuery(this).text());
							closeIt(el, datepicker, chosenDateObj);
						});

					// highlight the previous chosen date
					if (i+1 == chosendate.getDate() && m == chosendate.getMonth() && y == chosendate.getFullYear()) cell.addClass('chosen');
				}
			}
		}

		/** closes the datepicker **/
		// sets the currently matched input element's value to the date, if one is available
		// remove the table element from the DOM
		// indicate that there is no datepicker for the currently matched input element
		function closeIt (el, datepicker, dateObj) {
			if (dateObj && dateObj.constructor == Date)
			el.val(jQuery.fn.simpleDatepicker.formatOutput(dateObj));
			datepicker.remove();
			datepicker = null;
			jQuery.data(el.get(0), "simpleDatepicker", { hasDatepicker : false });
		}

        // iterate the matched nodeset
        return this.each(function() {

            // functions and vars declared here are created for each matched element. so if
            // your functions need to manage or access per-node state you can defined them
            // here and use $this to get at the DOM element

			if ( jQuery(this).is('input') && 'text' == jQuery(this).attr('type')) {

				var datepicker;
				jQuery.data(jQuery(this).get(0), "simpleDatepicker", { hasDatepicker : false });

				// open a datepicker on the click event
				jQuery(this).click(function (ev) {

					var $this = jQuery(ev.target);

					if (false == jQuery.data($this.get(0), "simpleDatepicker").hasDatepicker) {

						// store data telling us there is already a datepicker
						jQuery.data($this.get(0), "simpleDatepicker", { hasDatepicker : true });

						// validate the form's initial content for a date
						var initialDate = $this.val();

						if (initialDate && dateRegEx.test(initialDate)) {
							var chosendate = new Date(initialDate);
						} else if (opts.chosendate.constructor == Date) {
							var chosendate = opts.chosendate;
						} else if (opts.chosendate) {
							var chosendate = new Date(opts.chosendate);
						} else {
							var chosendate = today;
						}

						// insert the datepicker in the DOM
						datepicker = newDatepickerHTML();
						jQuery("body").prepend(datepicker);

						// position the datepicker
						var elPos = findPosition($this.get(0));
						var x = (parseInt(opts.x) ? parseInt(opts.x) : 0) + elPos[0];
						var y = (parseInt(opts.y) ? parseInt(opts.y) : 0) + elPos[1];
						jQuery(datepicker).css({ position: 'absolute', left: x, top: y });

						// bind events to the table controls
						jQuery("span", datepicker).css("cursor","pointer");
						jQuery("select", datepicker).bind('change', function () { loadMonth (null, $this, datepicker, chosendate); });
						jQuery("span.prevMonth", datepicker).click(function (e) { loadMonth (e, $this, datepicker, chosendate); });
						jQuery("span.nextMonth", datepicker).click(function (e) { loadMonth (e, $this, datepicker, chosendate); });
						jQuery("span.today", datepicker).click(function () { closeIt($this, datepicker, new Date()); });
						jQuery("span.close", datepicker).click(function () { closeIt($this, datepicker); });

						// set the initial values for the month and year select fields
						// and load the first month
						jQuery("select[name=month]", datepicker).get(0).selectedIndex = chosendate.getMonth();
						jQuery("select[name=year]", datepicker).get(0).selectedIndex = Math.max(0, chosendate.getFullYear() - opts.startyear);
						loadMonth(null, $this, datepicker, chosendate);
					}

				});
			}

        });

    };

    // finally, I like to expose default plugin options as public so they can be manipulated.  one
    // way to do this is to add a property to the already-public plugin fn

	jQuery.fn.simpleDatepicker.formatOutput = function (dateObj) {
		return dateObj.getFullYear() + "-" + (dateObj.getMonth() + 1) + "-" + dateObj.getDate();
	};

	jQuery.fn.simpleDatepicker.defaults = {
		// date string matching /^\d{1,2}\/\d{1,2}\/\d{2}|\d{4}$/
		chosendate : today,

		// date string matching /^\d{1,2}\/\d{1,2}\/\d{2}|\d{4}$/
		// or four digit year
		startdate : today.getFullYear(),
		enddate : today.getFullYear() + 1,

		// offset from the top left corner of the input element
		x : 18, // must be in px
		y : 18 // must be in px
	};

})(jQuery);


   /*************************************************************************
    *	Common functions for extending classes etc.
    *	Borrowed from prototype.js
    */
    var Class = {
            create: function() {
                    return function() {
                            this.initialize.apply(this, arguments);
                    }
            }
    }


    /*************************************************************************
    * class adminpanel
    */
    var adminPanel = Class.create();

    adminPanel.prototype = {
        // static members
        // constructor
        initialize: function (id, options) {

            // instance members
            var that = this;
            this.id = id;
            this.options = options;
            this.ns = options.ns;
            this.ug = options.ug;
            this.uploadIndex = new Array();
            this.itemTitleEN = $("#item_title").attr('value');
            this.itemTitleNL = $("#item_titleNl").attr('value');
            
            this.reset();


            var newPosition = 0;
            $(".position").each(function(){
                if ($(this).attr('value') > newPosition) {
                    newPosition = $(this).attr('value');
                }

            })

            //this.attachments = $(".attachment").size();
            this.attachments = newPosition;

            this.initInterface();

            this.initMenu();

            //set the datepickers
            $("#item_online").simpleDatepicker();
            $("#item_offline").simpleDatepicker();

        },

        reset : function(){
            $("#gentabs").removeClass("hidden").addClass("hidden");
            $("#np_general").removeClass("selected").addClass("selected");
            $("#np_advanced").removeClass("selected");
            $("#nl_gen").removeClass("hidden").addClass("hidden");
            $(".np_general").show();
            $(".np_advanced").hide();
            $("#owner").removeClass("third").addClass("third")

            //menu
            $(".addu").css('width','550px');
            $("#upload").removeClass("hidden").addClass("hidden");
            $("#factbox").removeClass("hidden").addClass("hidden");
            $("#users").removeClass("hidden").addClass("hidden");
            $("#uploadSelection").removeClass("hidden").addClass("hidden");
            $("#uploadFilter").removeClass("hidden").addClass("hidden");
            $("#breakpoint").removeClass("hidden").addClass("hidden");

        },

        initInterface : function(){
            $("#uploadFile-1").addClass("hidden");
            $("#uploadTitle-1").addClass("hidden");
            $("#video_link_-1").addClass("hidden");
            $("#fileInput_-1").addClass("hidden");
            $("#uploadText-1").addClass("hidden");

            $("#uploadTitleNl-1" ).addClass("hidden");
            $("#uploadFile-1_nl").addClass("hidden");
            $("#video_link_-1_nl").addClass("hidden");
            $("#fileInput_-1_nl").addClass("hidden");
            $("#uploadTextNl-1" ).addClass("hidden");


            switch(this.ns) {

                case 'Page':
                    if (this.ug != 2) return;

                    //admin width
                    $("#adminwrapper").removeClass("narrow").addClass("wide");

                    //default settings
                    $("#item_namespaceId").val('1')

                    //insert text
                    $("#_title").text("Enter page title");
                    $("#_titleNl").text("Enter page title");
                    $("#_text").text("Enter page text");
                    $("#_textNl").text("Enter page text");

                    $("#nl_gen").removeClass("hidden");

                    //menu itmes
                    $(".addu").css('width','700px');
                    $("#pimage").removeClass("hidden");
                    $("#pvideo").removeClass("hidden");
                    $("#users").removeClass("hidden");
                    $("#factbox").removeClass("hidden");
                    $("#uploadSelection").removeClass("hidden");
                    $("#uploadFilter").removeClass("hidden");
                    $("#breakpoint").removeClass("hidden");

                    this.initTabs();
                    break;
                case 'Project':
                    //insert specific fields
                    $("#projectCategory").removeClass("hidden");

                     if (this.ug == 2) {
                        $("#priority").removeClass("hidden");
                     }
                     $("#nochangedate").removeClass("hidden");

                    //TODO not ready for use
                    //$("#projectShare").removeClass("hidden");

                    //remove localization
                    $("#en_gen").removeClass("half");

                    //settings
                    $("#item_namespaceId").val('3')
                    $("#item_commonLn").attr('checked', true);

                    //insert text
                    $("#general").addClass("hidden");
                    $("#advanced").addClass("hidden");
                    $("#gentabs").removeClass("hidden");


                    $(".addu").css('width','280px');
                    //menu items to display
                    $("#pimage").removeClass("hidden");
                    $("#ptext").removeClass("hidden");
                    $("#pvideo").removeClass("hidden");
                    $(".halfend").addClass("hidden");
                    break;
                case 'News':
                     if (this.ug != 2) return;

                    //admin width
                    $("#adminwrapper").removeClass("narrow").addClass("wide");

                    //settings
                    $("#item_namespaceId").val('2')

                    //insert text
                    $("#projectCategory").removeClass("hidden");
                    $("#priority").removeClass("hidden");
                    $("#nochangedate").removeClass("hidden");
                    $("#_title").text("Enter news title");
                    $("#_titleNl").text("Enter news title");
                    $("#_text").text("Enter news text")
                    $("#_textNl").text("Enter news text")

                     $("#nl_gen").removeClass("hidden");

                    //menu itmes
                    $(".addu").css('width','700px');
                    $("#pimage").removeClass("hidden");
                    $("#pvideo").removeClass("hidden");
                    $("#factbox").removeClass("hidden");
                    break;

                case 'Graduation':
                    
                    $(".addu").css('width','280px');

                    //insert specific fields
                    if (this.ug == 2) {
                        $("#projectCategory").removeClass("hidden");
                        $("#projectYear").removeClass("hidden");
                        $("#en_gen").append($("#owner"));
                        $("#owner").removeClass("third");
                        $("#priority").removeClass("hidden");
                        $("#friendlyurlen").removeClass("hidden");
                    }
                    if (this.ug != 2) {
                        $("#item_title").attr('disabled','true');
                        $("#item_title").addClass('hidden');
                        $("#itemtitlep").append('<h1>'+$("#item_title").val()+'</h1>');
                    }
                    $("#nochangedate").removeClass("hidden");

                    //remove localization
                    $("#en_gen").removeClass("half");

                    //settings
                    $("#item_namespaceId").val('4')
                    $("#item_commonLn").attr('checked', true);

                    //tabs
                    $("#general").addClass("hidden");
                    $("#advanced").addClass("hidden");
                    $("#gentabs").removeClass("hidden");


                    $("#pimage").removeClass("hidden");
                    $("#ptext").removeClass("hidden");
                    $("#pvideo").removeClass("hidden");
                    $(".halfend").addClass("hidden");

                    break;
            }

            //set global events
            //set the friendly url
            var ns = this.ns
            $("#item_title").keyup(function(){
                if(ns != 'Page') { // if page custom friendly url
                    $("#item_friendlyUrl").val(getFridenlyUrl($("#item_title").val()));
                }
            })

            $("#item_titleNl").keyup(function(){
                if(ns != 'Page') { // if page custom friendly url
                    $("#item_friendlyUrlNl").val(getFridenlyUrl($("#item_titleNl").val()));
                }
            })


            $("#admin").removeClass("hidden");
        },

        // member functions
        initTabs : function(){

             $("a.tab").click(function(){
                $(".tabwin").hide();
                $("a.tab").removeClass('selected')
                $(this).addClass('selected')
                $("."+$(this).attr('id')).show();
             })

             $("#gentabs").removeClass("hidden");

        },

        initMenu : function() {
            //attachemnt click events
            var that = this;
            $(".attachment_btn").click(function(){
                var id = $(this).attr("id");
                switch(id) {
                    case 'upload':
                        that.addUpload('upload');
                        break;
                    case 'pimage':
                        that.addUpload('pimage');
                        break;
                    case 'ptext':
                        that.addUpload('ptext');
                        break;
                    case 'pvideo':
                        that.addUpload('pvideo');
                        break;
                    case 'factbox':
                         that.addUpload('factbox');
                        break;
                    case 'users':
                        that.addUpload('users');
                        break;
                    case 'uploadSelection':
                        //that.addUpload('uploadSelection');
                        break;
                    case 'uploadFilter':
                        that.addUpload('uploadFilter');
                        break;
                    case 'breakpoint':
                        that.addUpload('breakpoint');
                        break;
                    default:
                        that.addUpload('upload');
                       break;
                }
            })
        },

        addUpload : function(type, update){
            var that = this;
            

            this.attachments++; //maintain upload count
            this.uploadIndex[this.attachments] = this.attachments; //update array of uploads

            var upload_class = 'theupload';
            switch(type)
            {
                case 'pimage':
                    upload_class="theupload image";
                    break;
                case 'ptext':
                    upload_class="theupload text";
                    break;
                case 'pvideo':
                    upload_class="theupload video";
                    break;
            }

            newUpload = $('#upload-1').html(); //copy the markup
            newId = '#upload' + this.attachments;
            newUpload = newUpload.replace(/-1/gi, this.attachments); //give the markup container a new id
            newUpload = '<div id="upload'+ this.attachments + '" class="'+upload_class+'">' + newUpload + "</div>"
            $('#attachment').prepend(newUpload); //append the new upload to the admin

            switch(type)
            {
                case 'pimage':
                    $("#ItemUpload_"+this.attachments+"_position").val(this.attachments); //set the position
                    $("#firsthalf"+this.attachments).removeClass("half") //display only the en half
                    $("#uploadFile" + that.attachments).addClass("hidden");
                    $("#video_link_"+that.attachments).addClass("hidden");
                    $("#fileInput_" + that.attachments).removeClass("hidden");
                    $("#uploadText" + that.attachments).removeClass("hidden");
                    $("#ItemUpload_"+this.attachments+"_text").css('width','320px');
                    if((that.ns == 'News') || (that.ns == 'Page'))
                    {
                        $("#uploadTextNl" + this.attachments).removeClass("hidden");
                        $("#fileInput_" + this.attachments + "_nl").removeClass("hidden");
                        $("#ItemUpload_"+this.attachments+"_textNl").css('width','320px');
                         //default text
                        $("#ItemUpload_"+this.attachments+"_textNl").val("Voer bijschrift");
                        $("#ItemUpload_"+this.attachments+"_textNl").attr("title","Voer bijschrift");
                    }
                    $("#uploadTitle" + that.attachments).addClass("hidden");
                    $("#uploadimgdiv_" + that.attachments).removeClass("hidden");

                    //select the upload type
                    $("#ItemUpload_"+this.attachments+"_uploadtype_0").attr("checked", "checked");

                    //default text
                    $("#ItemUpload_"+this.attachments+"_text").val("Enter caption");
                    $("#ItemUpload_"+this.attachments+"_text").attr("title","Enter caption");

                    this.initImgUpload("ItemUpload_"+this.attachments+"_filePath",this.attachments, 1);
                    if((that.ns == 'News') || (that.ns == 'Page'))
                    {
                        this.initImgUpload("ItemUpload_"+this.attachments+"_filePathNl",this.attachments, 2);
                    }
                    //reset type to pimage parent type
                    type = 'upload';

                    break;
                case 'pvideo':
                    $("#ItemUpload_"+this.attachments+"_position").val(this.attachments); //set the position
                    $("#firsthalf"+this.attachments).removeClass("half") //display only the en half

                   $("#uploadFile" + that.attachments).addClass("hidden");
                    $("#video_link_"+that.attachments).removeClass("hidden");
                    $("#fileInput_" + that.attachments).removeClass("hidden");
                    $("#uploadText" + that.attachments).removeClass("hidden");
                    $("#uploadTitle" + that.attachments).addClass("hidden");
                    $("#ItemUpload_"+this.attachments+"_text").css('width','320px');
                    if(that.ns == 'News')
                    {
                        $("#uploadTextNl" + this.attachments).removeClass("hidden");
                        $("#video_link_"+that.attachments+"_nl").removeClass("hidden");
                        $("#fileInput_" + this.attachments + "_nl").removeClass("hidden");
                        $("#ItemUpload_"+this.attachments+"_textNl").css('width','320px');
                         //default text
                        $("#ItemUpload_"+this.attachments+"_textNl").val("Voer bijschrift");
                        $("#ItemUpload_"+this.attachments+"_textNl").attr("title","Voer bijschrift");
                    }

                    //select the upload type
                    $("#ItemUpload_"+this.attachments+"_uploadtype_1").attr("checked", "checked");

                    //default text
                    $("#ItemUpload_"+this.attachments+"_text").val("Enter description");
                    $("#ItemUpload_"+this.attachments+"_text").attr("title","Enter description");


                    //untill video upload is supported
                    this.initVideoUrl("#ItemUpload_"+this.attachments+"_videolink",this.attachments, 1);
                     if(this.ns == 'News')
                    {
                        this.initVideoUrl("#ItemUpload_"+this.attachments+"_videoLinkNl",this.attachments, 2);
                    }
                    //reset type to pimage parent type
                    type = 'upload';

                    break;
                case 'ptext':
                    $("#ItemUpload_"+this.attachments+"_position").val(this.attachments); //set the position
                    $("#firsthalf"+this.attachments).removeClass("half") //display only the en half

                    $("#uploadFile" + that.attachments).addClass("hidden");
                    $("#fileInput_" + that.attachments).addClass("hidden");
                    $("#uploadTitle" + that.attachments).removeClass("hidden");
                    $("#uploadText" + that.attachments).removeClass("hidden");

                    $("#ItemUpload_"+this.attachments+"_uploadtype_2").attr("checked", "checked");
                    //default text
                    $("#ItemUpload_"+this.attachments+"_title").val("Enter title");
                    $("#ItemUpload_"+this.attachments+"_text").val("Enter text");
                    $("#ItemUpload_"+this.attachments+"_title").attr("title","Enter title");
                    $("#ItemUpload_"+this.attachments+"_text").attr("title","Enter text");

                    //reset type to pimage parent type
                    type = 'upload';

                    break;

                case 'upload':
                    //### keep upload
                    $("#ItemUpload_"+this.attachments+"_position").val(this.attachments);
                    $("#firsthalf"+this.attachments).removeClass("half")


                    $("#ItemUpload_"+ this.attachments + "_uploadtype_0").click(function(){
                        $("#uploadFile" + that.attachments).addClass("hidden");

                        $("#video_link_"+that.attachments).addClass("hidden");
                        $("#fileInput_" + that.attachments).removeClass("hidden");
                        $("#uploadText" + that.attachments).removeClass("hidden");
                        if(that.ns == 'News')
                        {
                            $("#uploadTitle" + that.attachments).removeClass("hidden");
                            $("#uploadTitle"+ "Nl" + that.attachments ).removeClass("hidden");

                            $("#uploadFile" + that.attachments + "_nl").addClass("hidden");
                            $("#video_link_"+that.attachments + "_nl").addClass("hidden");
                            $("#fileInput_" + that.attachments + "_nl").removeClass("hidden");
                            $("#uploadText" + "Nl" + that.attachments ).removeClass("hidden");
                        }else
                        {
                            $("#uploadTitle" + that.attachments).addClass("hidden");
                        }
                    })
                    $("#ItemUpload_"+ this.attachments + "_uploadtype_1").click(function(){
                        $("#uploadFile" + that.attachments).addClass("hidden");

                        $("#video_link_"+that.attachments).removeClass("hidden");
                        $("#fileInput_" + that.attachments).removeClass("hidden");
                        $("#uploadText" + that.attachments).removeClass("hidden");
                        if(that.ns == 'News')
                        {
                            $("#uploadTitle" + that.attachments).removeClass("hidden");
                            $("#uploadTitle" + "Nl"  + that.attachments ).removeClass("hidden");

                            $("#uploadFile" + that.attachments + "_nl").addClass("hidden");
                            $("#video_link_"+that.attachments + "_nl").removeClass("hidden");
                            $("#fileInput_" + that.attachments + "_nl").removeClass("hidden");
                            $("#uploadText" + "Nl" + that.attachments ).removeClass("hidden");
                        }else
                        {
                            $("#uploadTitle" + that.attachments).addClass("hidden");
                        }
                    })
                    $("#ItemUpload_"+ this.attachments + "_uploadtype_2").click(function(){
                        $("#uploadFile" + that.attachments).addClass("hidden");
                        $("#fileInput_" + that.attachments).addClass("hidden");
                        $("#uploadTitle" + that.attachments).removeClass("hidden");
                        $("#uploadText" + that.attachments).removeClass("hidden");

                        if(that.ns == 'News')
                        {
                            //$("#uploadFile" + that.attachments + "_nl").addClass("hidden");
                            $("#fileInput_" + that.attachments + "_nl").addClass("hidden");
                            $("#uploadTitle" + "Nl" + that.attachments).removeClass("hidden");
                            $("#uploadText"+ "Nl" + that.attachments ).removeClass("hidden");
                        }
                    })

                    $("#uploadFile" + this.attachments).removeClass("hidden");

                    this.initImgUpload("ItemUpload_"+this.attachments+"_filePath",this.attachments, 1);
                    this.initVideoUrl("#ItemUpload_"+this.attachments+"_videolink",this.attachments, 1);

                    this.initImgUpload("ItemUpload_"+this.attachments+"_filePathNl",this.attachments, 2);
                    this.initVideoUrl("#ItemUpload_"+this.attachments+"_videoLinkNl",this.attachments, 2);

                    break;
                case 'uploadFilter':
                    //default texts
                    $("#ItemUpload_"+this.attachments+"_title").val("Enter filter title");
                    $("#ItemUpload_"+this.attachments+"_titleNl").val("Voer filter titel");

                    $("#ItemUpload_"+this.attachments+"_title").attr("title","Enter filter title");
                    $("#ItemUpload_"+this.attachments+"_titleNl").attr("title","Voer filter titel");

                    $("#uploadTitle" + this.attachments).removeClass("hidden");
                    $("#uploadTitleNl" + this.attachments).removeClass("hidden");
                    $("#uploadItem"+ this.attachments).removeClass("hidden");
                    $("#uploadFilter"+ this.attachments).removeClass("hidden");
                    $("#uploadFilter" + this.attachments + "_preview").removeClass("hidden");
                    $("#ItemUpload_"+this.attachments+"_position").val(this.attachments);

                    $("#projectSelected_" + this.attachments)
                        .autocomplete(appName+"item/filter",{'minChars':1,'delay':500,'matchCase':false,'max':50}).result(function(event,item)
                            {
                                autoComplete(event,item,'#ItemUpload_'+ that.attachments + '_uploadSelectedItemId');
                            });

                    this.initProjectSearch(this.attachments)

                    break;
                case 'factbox':
                    //default texts
                    $("#ItemUpload_"+this.attachments+"_title").val("Enter title");
                    $("#ItemUpload_"+this.attachments+"_text").val("Enter text");
                    $("#ItemUpload_"+this.attachments+"_titleNl").val("Voer de titel in");
                    $("#ItemUpload_"+this.attachments+"_textNl").val("Tekst invoeren");

                    $("#ItemUpload_"+this.attachments+"_title").attr("title","Enter title");
                    $("#ItemUpload_"+this.attachments+"_text").attr("title","Enter text");
                    $("#ItemUpload_"+this.attachments+"_titleNl").attr("title","Voer de titel in");
                    $("#ItemUpload_"+this.attachments+"_textNl").attr("title","Tekst invoeren");

                    //display correct fields
                    $("#uploadTitle" + this.attachments).removeClass("hidden");
                    $("#uploadText" + this.attachments).removeClass("hidden");
                    $("#uploadTitleNl" + this.attachments).removeClass("hidden");
                    $("#uploadTextNl" + this.attachments).removeClass("hidden");
                    $("#ItemUpload_"+this.attachments+"_position").val(this.attachments);
                    $("#factboxType"+ this.attachments).removeClass("hidden");
                    break;
                case 'users':
                    //default texts
                    $("#ItemUpload_"+this.attachments+"_title").val("Enter user list title");
                    $("#ItemUpload_"+this.attachments+"_titleNl").val("Voer gebruikerslijst titel");

                    $("#ItemUpload_"+this.attachments+"_title").attr("title","Enter user list title");
                    $("#ItemUpload_"+this.attachments+"_titleNl").attr("title","Voer gebruikerslijst titel");

                    $("#uploadTitle" + this.attachments).removeClass("hidden");
                    $("#uploadTitleNl" + this.attachments).removeClass("hidden");
                    $("#uploadUser" + this.attachments).removeClass("hidden");
                    $("#ItemUpload_"+this.attachments+"_position").val(this.attachments);

                    this.initUserEvents(this.attachments)

                    break;
                case 'breakpoint':
                    //default texts
                    $("#ItemUpload_"+this.attachments+"_title").val("Enter data");
                    $("#ItemUpload_"+this.attachments+"_title").attr("title","Enter data");

                    $("#uploadTitle" + this.attachments).removeClass("hidden");
                    $("#ItemUpload_"+this.attachments+"_position").val(this.attachments);
                    break;
            }


            $("#ItemUpload_"+this.attachments+"_type").val(type);

            this.initUploadControl(this.attachments);

            $(newId).show();

        },

        initEvents : function(nr, type){

            switch(type)
            {
                case 'upload':

                    this.initImgUpload("ItemUpload_"+nr+"_filePath",nr, 1);
                    this.initVideoUrl("#ItemUpload_"+nr+"_videolink",nr, 1);

                    this.initImgUpload("ItemUpload_"+nr+"_filePathNl",nr, 2);
                    this.initVideoUrl("#ItemUpload_"+nr+"_videoLinkNl",nr, 2);

                    if($("#ItemUpload_"+nr+"_videoLinkNl").val() != '' || $("#ItemUpload_"+nr+"_videoLinkNl").val() != null)
                    {
                        $("#ItemUpload_"+nr+"_videoLinkNl").keyup();
                    }

                    if($("#ItemUpload_"+nr+"_videolink").val() != '' || $("#ItemUpload_"+nr+"_videolink").val() != null)
                    {
                        $("#ItemUpload_"+nr+"_videolink").keyup();

                    }

                    break;

                case 'uploadFilter':
                case 'uploadSelection':

                    $("#projectSelected_" + nr)
                        .autocomplete(appName+"item/filter",{'minChars':1,'delay':500,'matchCase':false,'max':50}).result(function(event,item)
                            {
                                autoComplete(event,item,'#ItemUpload_'+ nr + '_uploadSelectedItemId');
                            });

                    this.initProjectSearch(nr)

                    $('#ItemUpload_' + nr + '_categoryId').change();

                    break;

                case 'factbox':
                    break;

                case 'users':

                    this.initUserEvents(nr);
                    $("#uploadUserCategory_" + nr).change();
                    break;
                case 'breakpoint':
                    break;
            }

            $("#ItemUpload_"+nr+"_type").val(type);

            this.initUploadControl(nr);
        },


        initUploadControl : function(nr){

            var that = this;

            $("#delete_" + nr).click(function(){
                var answer = confirm("Are you sure you want to delete this upload?");
                if(answer) {
                    $("#upload"+nr).remove();
                }
            })
        },

        initProjectSearch : function(nr){
            var that = this;
            var pos = nr;

            $('#ItemUpload_' + nr + '_namespaceId').change(function(){
                that.filterUploads(pos);
            });

            $('#ItemUpload_' + nr + '_categoryId').change(function(){
                that.filterUploads(pos);
            });

            $('#ItemUpload_' + nr + '_uploadFilterCount').keyup(function(){
                that.filterUploads(pos);
            });

            $('#ItemUpload_' + nr + '_maxUploadFetch').keyup(function(){
                that.filterUploads(pos);
            });



            $("#projectSearch_" + nr).submit(function(){
                if($("#ItemUpload_" + nr + "_uploadSelectedItemId").val() != '') {
                    //console.log("ajax search for items with namespace project")
                }
                return false;
            })
        },

        initUserEvents : function(nr) {
            var pos = nr;
            var that = this;


            $('#ItemUpload_' + nr + '_userGroupId').change(function(){
                that.filterUser(pos);
            })

            $("#uploadUserCategory_" + nr).change(function(){
                that.filterUser(pos);
            })

            $('#ItemUpload_' + nr + '_year').change(function(){
                that.filterUser(pos);
            })

            $("#uploadUserCheck_" + nr).click(function(){
                $("#uploadUser_" + nr).find('input').each(function(){
                    $(this).attr('checked', true);
                })
            })

            $("#uploadUserUncheck_" + nr).click(function(){
                $("#uploadUser_" + nr).find('input').each(function(){
                    $(this).attr('checked', false);
                })
            })
        },

        initImgUpload : function(inp,nr, ln){
            //ItemUpload_1_filePath
            var _ln = ln;
            $('#'+inp).uploadify({
                'uploader'  : appName+'assets/uploadify.swf',
                'script'    : appName+'fileUpload/upload/',
                'cancelImg' : appName+'images/cancel.png',
                'auto'      : true,
                'folder'    : '/tmp/',
                'fileDesc'  : 'Image extensions allowed: jpg, gif',
                'fileExt'   : '*.jpg;*.jpeg;*.gif;',
                'sizeLimit' : '10485760',
                'buttonImg' : appName+'images/browse.png',
                'onError' : function(a, b, c, d){
                   if (d.type ==="File Size") {
                      _tId = (_ln == 1)? '' : '_nl';
                      _tName = (_ln == 1)? '' : 'Nl';
                       $("#uploadFile"+nr+"_preview"+ _tId).html('The image is to big, maximum image size is 10 mb').removeClass("hidden");
                   }

                },
                'onComplete' : function(e,q,file,r){
                      r = eval('(' + r + ')');

                      _tId = (_ln == 1)? '' : '_nl';
                      _tName = (_ln == 1)? '' : 'Nl';

                      $("#uploadFile"+nr+"_preview"+ _tId).removeClass("hidden");

                      if(! r.error)
                      {
                        $("#uploadFile"+nr+"_preview_image" + _tId).attr('src',r.url);

                        //$("#fileInput_"+nr).hide();
                        $("#uploadFile"+nr+"_preview_image" + _tId).load(function(){
                            $(this).removeClass("hidden");
                        })

                        $('#ItemUpload_' +nr+ '_filePath' + _tName).val( r.path );
                        $('#ItemUpload_' +nr+ '_fileName' + _tName).val( r.name );
                      }
                      else
                      {
                        $("#uploadFile"+nr+"_preview"+ _tId).html('Error While uploading file, ' + r.error).removeClass("hidden");
                      }


                }
            });
        },

        initVideoUrl : function(inp,nr, ln) {

            $(inp).data('oldtag','---')
            $(inp).data('oldid','---')
            var pos = nr;
            var _ln = ln;


            $(inp).bind("keyup", function(e){
                
                var that = this;
                var tag = $(this).val();
                var __ln = _ln;

                if( tag == '')
                    return;

                thumbnail = null;
                if(__ln == 1)
                {
                    tthis = $('#uploadFile'+pos+'_preview');
                    $('#ItemUpload_' +nr+ '_filePath').val(tag);
                }
                else
                {
                    tthis = $('#uploadFile'+pos+'_preview_nl');
                    $('#ItemUpload_' +nr+ '_filePathNl').val(tag);
                }


                if (tag.trim()=='')
                    return;

                var _pos = pos;

              
                if(tag != $(this).data('oldtag')) {

			$.getJSON(appName+"videoMeta/getMeta?url="+tag, null, function(data, textStatus) {
                                _tId = (__ln == 1)? '' : '_nl';
                                tId = (__ln == 1)? '' : 'Nl';
                                
				if(textStatus == "success" && data['status'] == "ok" && data['tn'] != "") {

					if(data['id'] != $(that).data('oldid')) {

                                                var thumbnail = $('#videourl_tn_'+_pos + _tId);
						if(thumbnail) {
							thumbnail.remove();
							thumbnail = null;
						}

						thumbnail = $('<div></div>').attr('id', 'videourl_tn_'+_pos + _tId);
						$('#uploadFile'+_pos+'_preview' + _tId).append(thumbnail);
                                                $("#uploadFile"+_pos+"_preview" + _tId).removeClass("hidden")
                                                $("#uploadFile"+_pos).hide();

                                                thumbnail.html('<img width="125" id ="vpreview_'+ _pos + _tId +'" src="'+data['tn']+'">');

                                                suf = '';
                                                if(thumbnail.isIE()) {
                                                    suf = '?r=' + Math.random();
                                                }

                                                var _img = $('#vpreview_'+ _pos + _tId )

                                                _img
                                                .attr('src', data['tn'] + suf)
                                                .load(function(){
                                                    thumbnail.html(_img);

                                                }).bind('load', function(ev) {
                                                    thumbnail.trigger('load', ev);
                                                });

						thumbnail.bind('click', function() {

							var html = '';
							if(data['type'] == "youtube") {
								html = '<object width="350"><param name="movie" value="http://www.youtube-nocookie.com/v/' + data['id'] + '&hl=en&fs=1&rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube-nocookie.com/v/' + data['id'] + '&hl=en&fs=1&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="350"></embed></object>';
							}

							if(data['type'] == "vimeo") {
								html = '<object width="350"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=' + data['id'] + '&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=' + data['id'] + '&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="350"></embed></object>';
							}

							$(this).html(html);
						});

                                                
                                                if(data['width'] != -1 && data['height'] != -1) {
                                                    $("#ItemUpload_"+_pos+"_imageWidth"+tId).val(data['width']);
                                                    $("#ItemUpload_"+_pos+"_imageHeight"+tId).val(data['height']);
                                                }
					}
				} else {

					$('#videourl_tn_'+_pos + _tId).remove();

                                        console.log(that)
                                        $(that).val('');
					oldid = "---";
                                        $("#error").html("");
                                        $("#success").html("");
                                        $("#error").append("The video was not found");
                                        location.href='#message';
				}

				oldtag = tag;
			});

		}
            })



        },

        filterUser : function(nr){
            $("#uploadUserList" + nr + '0').html('Loading...');
            $("#uploadUserList" + nr + '1').html('');

            ug = $('#ItemUpload_' + nr + '_userGroupId').val();
            c = $("#uploadUserCategory_" + nr).val();
            y = $('#ItemUpload_' + nr + '_year').val();

            var pos = nr;

            $.getJSON(appName+"user/filter/?ug=" + ug + "&c=" + c + "&y=" + y,
                function(data){

                    $("#uploadUserList" + pos + '0').html('');

                    $.each(data, function(i,item){
                        d = $("#uploadUserList" + pos + "sample").html();
                        d = d.replaceAll('{id}', item.id);
                        d = d.replaceAll('{name}', item.name + ", " + item.categoryName + ", " + item.year);
                        d = d.replaceAll('{value}', item.id);
                        $("#uploadUserList" + pos + ((i % 2 == 0)? '0':'1')).append(d);
                    });

                    if(data.length == 0)
                    {
                        $("#uploadUserList" + pos + '0').html('No Result found');
                    }

                });
        },

        filterUploads : function(nr){

            $("#uploadsList" + nr + '0').html('Loading...');
            $("#uploadsList" + nr + '1').html('');

            i = $('#item_id').val();
            n = $('#ItemUpload_' + nr + '_namespaceId').val();
            c = $('#ItemUpload_' + nr + '_categoryId').val();
            limit = $('#ItemUpload_' + nr + '_uploadFilterCount').val();
            maxU = $('#ItemUpload_' + nr + '_maxUploadFetch').val();

            var pos = nr;
            var that = this;

            $.getJSON(appName+"item/filter/?o=json&n=" + n + "&i=" + i +"&c=" + c + "&limit=" + limit + "&maxU=" + maxU,
                function(data){

                    $("#uploadsList" + pos + '0').html('');

                    $.each(data, function(i,item){
                        d = '';

                        if(item.uploadtype == 1)
                        {
                            d = $("#uploadsList" + pos + "sample").html();
                            d = d.replaceAll('{name}', item.name);
                            d = d.replaceAll('%url%', (item.filePath + item.fileName));
                        }
                        else if(item.uploadtype == 2)
                        {
                            d = $("#uploadsList" + pos + "sampleVedio").html();
                            d = d.replaceAll('{name}', item.name);
                            d = d.replaceAll('{id}', item.id);
                            that.loadImage(item.videoLink, pos, item.id);
                        }
                        else if(item.uploadtype == 3)
                        {
                            d = $("#uploadsList" + pos + "sampleText").html();
                            d = d.replaceAll('{title}', item.name);
                            d = d.replaceAll('{text}', item.text);
                        }

                        $("#uploadsList" + pos + ((i % 2 == 0)? '0':'1')).append(d);
                    });

                    if(data.length == 0)
                    {
                        $("#uploadsList" + pos + '0').html('No Result found');
                    }

            });

        },

        loadImage: function(url, nr, id)
        {
            var pos = nr;
            var _id = id
            $.getJSON(appName+"videoMeta/getMeta?url="+url, null, function(data, result) {
                 $("#uploadsList" + pos + '-' + _id + 'vimg').attr('src',data.tn);
            });
        }
    }


