$.fn.isIE = function() {
	if($.browser.msie && ($.browser.version=="6.0" || $.browser.version=="7.0")) {
		return true;
	} else {
		return false;
	}
};

$.fn.throbLoad = function(imgURL,width) {
	origElem = $(this);

	$(this).html('<img src="throbber.gif">');
	var img = $('<img />').attr('src', imgURL).attr('width', width);


	suf = '';
	if($(this).isIE()) {
		suf = '?r=' + Math.random();
	}

	$('<img />')
	    .attr('src', imgURL + suf)
	    .load(function(){
			origElem.html(img);
	}).bind('load', function(ev) {
		origElem.trigger('load', ev);
	});

	return $(this);

};

$.fn.fancyDebug = function(msg) {
	if ( $("#fancydebug_container").length == 0 ) {
		dc = $('<div />').attr('id', 'fancydebug_container');
		$('body').prepend(dc);
	}
	d = $('<div />').addClass('fancydebug').append(msg).show();
	$('#fancydebug_container').prepend(d);

	d.fadeOut(4000);

};


String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

function getFridenlyUrl(v) {

    var unwanted = {'Š':'S', 'š':'s', 'Ž':'Z', 'ž':'z', 'À':'A', 'Á':'A', 'Â':'A', 'Ã':'A', 'Ä':'A', 'Å':'A', 'Æ':'Ae', 'Ç':'C', 'È':'E', 'É':'E','Ê':'E', 'Ë':'E', 'Ì':'I', 'Í':'I', 'Î':'I', 'Ï':'I', 'Ñ':'N', 'Ò':'O', 'Ó':'O', 'Ô':'O', 'Õ':'O', 'Ö':'O', 'Ø':'O', 'Ù':'U','Ú':'U', 'Û':'U', 'Ü':'U', 'Ý':'Y', 'Þ':'Th', 'ß':'Ss', 'à':'a', 'á':'a', 'â':'a', 'ã':'a', 'ä':'a', 'å':'a', 'æ':'ae', 'ç':'c','è':'e', 'é':'e', 'ê':'e', 'ë':'e', 'ì':'i', 'í':'i', 'î':'i', 'ï':'i', 'ð':'d', 'ñ':'n', 'ò':'o', 'ó':'o', 'ô':'o', 'õ':'o','ö':'o', 'ø':'o', 'ù':'u', 'ú':'u', 'û':'u', 'ý':'y', 'ý':'y', 'þ':'th', 'ÿ':'y', ' ':'-' };

    v = v.replace(' ', '-');
    var arrChars = v.split('');

    for (i=0;i<arrChars.length;i++) {
        if (unwanted[arrChars[i]]) {
            arrChars[i] = unwanted[arrChars[i]]
        }
    }
    v = arrChars.join('');
    v = v.replace(/[^a-zA-Z 0-9-]+/g,'');
    v = escape(v);
    return v.toLowerCase();
}