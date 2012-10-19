


jQuery.fn.offsetToParent = function() {
	var p = $(this).parent();
	var pt = p.offset().top;
	var pl = p.offset().left;

	var t = $(this).offset().top;
	var l = $(this).offset().left;
	return ({'top': (t-pt), 'left': (l-pl)});
};

jQuery.fn.offsetTo = function(e) {

	var et = e.offset().top;
	var el = e.offset().left;

	var t = $(this).offset().top;
	var l = $(this).offset().left;
	return ({'top': (t-et), 'left': (l-el)});
};

//callback from search
function searchDone() {
   
    attachments();
}

function fixIndent() {
	$('#main p').each( function(e,i) {
		if(!$(this).prev().is('p')) {
			$(this).css('text-indent', '0px')
		}
	});
}

function zigZag() {
	$('.block:odd').each( function(e,i) {
		$(this).css('float', 'right');
	});
}

function centerPlayButtons() {
    $('.uninitialized .playbutton').each(function(e) {

       w = $(this).parent().width();
       h = $(this).parent().height();

       $(this).css('left', Math.floor((w/2)-40))
       $(this).css('top', Math.floor((h/2)-32))

    });
}

function arrangeEditButtons() {
    $('#search p').prepend($('.edit').html());
}

function clickedIcon(i) {

    clicked_att = $(i).parent();

    data = clicked_att.data('data');

    if(data['type'] == 'video' && clicked_att.hasClass('zoomed')) {
        return -1;
    }

    in_project = $('#main .project').length > 0;

    icon = clicked_att.find('.icon:first');
    img = icon.find('img:first');
    texttitle = clicked_att.find('.texttitle');
    captionarea = clicked_att.find('.caption-area');
    readmore = clicked_att.find('.readmore');

    var origTopPos = icon.offset().top;

    maximize = true;
    if(clicked_att.hasClass('zoomed')) {
        maximize = false;
    }

    var att_mid = clicked_att.offsetToParent().left+(clicked_att.outerWidth()/2);
    var main_mid = clicked_att.parent().outerWidth()/2;

    if(att_mid > main_mid) {
        float_after_zoom ='right';
    } else {
        float_after_zoom ='left';
    }

    //s = 'tnw ' +  data['tnw'] + ' tnh ' +  data['tnh'] + ' bigw ' + data['bigw'] + ' bigh ' + data['bigh'];
    //alert(s);

    $('.zoomed').each( function(i, val) {
                    var tdata = $(val).data('data');

                    $(val).css('float', $(val).data('float')); //reset float
                    $(val).css('clear', 'none'); //reset clear

                    if(tdata['type'] == 'image') {
                            var ticon = $(val).find('.icon');
                            var timg = ticon.find('img');

                            timg.attr('width', tdata['tnw']);
                            timg.attr('height', tdata['tnh']);
                            timg.attr('src', tdata['tnfn']);

                    } else if(tdata['type'] == 'text') {
                            var ttexttitle = $(val).find('.texttitle');
                            ttexttitle.width(tdata['tnw']);

                    } else if(tdata['type'] == 'video') {
                        $(val).find('.videotn').show();
                        $(val).find('.video').hide();
                    }

                    $(val).removeClass('zoomed');
                    //$(val).css('cursor', 'pointer');
                    $(val).find('.collapsed').hide();
                    $(val).find('.caption-area').css('width', tdata['tnw']+'px')
                    $(val).find('.readmore').show();

                    if(in_project) {
                        $(val).find('.shortversion').show();
                    }


                    //For full pages
                    //$(val).css('float', $(val).data('float'));
                    //$(val).css('clear', 'none');
                    //$(val).css('margin-left', '0px')

    });

    if(maximize) {
        clicked_att	.addClass('zoomed')
                                .find('.shortversion').hide().end()
                                .find('.collapsed').show().end()
                                .find('.readmore').hide();

        if(data['type'] == 'image') {
                
                img.attr('width', data['bigw']);
                img.attr('height', data['bigh']);
                img.attr('src', data['bigfn']);
                
        } else if(data['type'] == 'text') {
                texttitle.width(data['bigw']);
        } else if(data['type'] == 'video') {
                clicked_att.find('.videotn').hide();
                clicked_att.find('.video').show();

        }

        //console.log(icon.css("border"));
        
        captionarea.width(icon.outerWidth());
        //clicked_att.width(img.outerWidth()+16)

        clicked_att.css('float', float_after_zoom);

        //check again, it get stuck, in rare cases, on the wrong side (left/right)
        att_mid = clicked_att.offsetToParent().left+(clicked_att.outerWidth()/2);
        main_mid = clicked_att.parent().outerWidth()/2;


        if( !($.browser.msie && parseInt(jQuery.browser.version) < 8) ) {
            if(att_mid > main_mid) {
                if(float_after_zoom != 'right') {
                    clicked_att.css('clear', float_after_zoom);
                }
            } else {
                if(float_after_zoom != 'left') {
                    clicked_att.css('clear', float_after_zoom);
                }
            }
        }

       



    } else {

        if(!data['type'] == 'video') {
            clicked_att	.removeClass('zoomed').find('.collapsed').hide();

                    if(in_project) {
                        clicked_att.find('.shortversion').show();
                    }


            if(data['type'] == 'image') {
                    var ticon = clicked_att.find('.icon');
                    var timg = ticon.find('img');


                    timg.attr('width', data['tnw']);
                    timg.attr('height', data['tnh']);
                    timg.attr('src', data['tnfn']);

            } else if(data['type'] == 'text') {
                    var ttexttitle = clicked_att.find('.texttitle');
                    ttexttitle.width(data['tnw']);
            }
        }
    }

    /*

    //Only used for full pages

    var xpos = 0;
    // try left corner
    if(data['bigw'] + leftRel < clicked_att.parent().outerWidth()) {
            var xpos = leftRel;
    } else { // Try right corner
            var diff = data['bigw']-data['tnw'];
            xpos = leftRel - diff;
            if(xpos < 0) {
                    xpos = 0;
            }
    }

    clicked_att.data('float', (clicked_att.css('float'))); //Store left or right
    clicked_att.css('float', 'none');
    clicked_att.css('clear', 'both');
    clicked_att.css('margin-left', xpos+'px')
    */


    return origTopPos;
}

function scrollToAttachment(a, origTopPos) {

    clicked_att = a.parent();

    data = clicked_att.data('data');
    icon = clicked_att.find('.icon:first');

    topAbs2 = icon.offset().top;

    d = topAbs2-origTopPos;
    var ds = 0;
    if(d>0) {
            ds = "+="+Math.abs(d)+"px";
    } else {
            ds = "-="+Math.abs(d)+"px";
    }
    $.scrollTo(ds, 0, {axis:'y', margin:false, offset: {top:0} });


    //top
    td = icon.offset().top - $(window).scrollTop();
    if(td<0 || clicked_att.outerHeight() > $(window).height() ) {
            td = Math.abs(td);
            td += 30;
            $(this).oneTime(120, function() {
                    //$.scrollTo("-="+td+"px", 150, {axis:'y', margin:true, offset: {top:0} });
                    $.scrollTo(clicked_att, 150, {axis:'y', margin:true, offset: {top:-30} });
            });
    } else {
            //bottom

            td = ( ($(window).scrollTop()+$(window).height()) - (icon.offset().top + clicked_att.outerHeight()) );
            if(td<0) {
                    td = Math.abs(td);
                    td += 0;
                    clicked_att.oneTime(120, function() {
                            $.scrollTo("+="+td+"px", 150, {axis:'y', margin:true, offset: {top:0} });
                    });
            }
    }
}


jQuery.fn.sort = function() {
    return this.pushStack( [].sort.apply( this, arguments ), []);
};


function parseAttachmentData() {

    $('.uninitialized.att .data').hide();

    $('.uninitialized.att').each( function(i, val) {

        idVarname = ('data_' + $(this).attr("id"));

        // :-/

        if (window.execScript) {
            window.execScript('jsondata = ' + '(' + idVarname + ')','');
        }
        else {
            jsondata = eval(idVarname);
        }

        jsondata = eval(idVarname);

        $(this).data( 'data', jsondata ) ;
        $(this).data( 'float', $(this).css('float') );
           
    });
}

function sortModified(a,b){
    
    aa = parseInt($(a).data('data')['modified']);
    bb = parseInt($(b).data('data')['modified']);

    return aa < bb ? 1 : -1;
}

function sortPriority(a,b){

    aa = parseInt($(a).data('data')['priority']);
    bb = parseInt($(b).data('data')['priority']);

    return aa < bb ? 1 : -1;
}

function sortPriorityAndModified(a,b){

    aap = parseInt($(a).data('data')['priority']);
    bbp = parseInt($(b).data('data')['priority']);

    aam = parseInt($(a).data('data')['modified']);
    bbm = parseInt($(b).data('data')['modified']);

    if(aap == bbp) {
        return aam < bbm ? 1 : -1;
    } else {
        return aap < bbp ? 1 : -1;
    }    
    
}


function attachments() {

          
            parseAttachmentData();

            
            
            fch = $('#itemFilterResult .uploads.filter');

            first = false;
            if(fch.length == 0) {
                first = true;
                i = $("[id^='itemFilterContent']:last");
                t = $('<div id="itemFilterResult"></div>');
                sib = i.next();
                if(sib.length > 0) {
                    t.insertBefore(sib);
                } else {
                    i.parent().append(t);
                }

                $('#itemFilterResult').append('<div class="uploads filter"></div>');
                fch = $('#itemFilterResult .uploads.filter');
            }

            allunsorted = $(".uninitialized.att");
            allunsorted.sort(sortPriorityAndModified);



      
            allunsorted.appendTo(fch);

            setupAttachments();
}


function setupAttachments() {

        $('.uninitialized.att:odd').css('float', 'right');

	$('.uninitialized.att').each( function(i, val) {
                $(this).data('float', $(this).css('float'));
	});

	$('.uninitialized.att .icon').parent().not('.filtered_user.image').not('.graduationflyer').find('.icon').bind('click', function(e) {
                var origTopPos = clickedIcon($(this));
                if(origTopPos != -1) {
                   scrollToAttachment($(this), origTopPos);
                }
	}).css('cursor','pointer');

	$('.uninitialized.att.news .caption-area .readmore').bind('click', function(e) {
            $(this).parent().parent().parent().parent().find('.icon').trigger('click');
	}).css('cursor','pointer');

        centerPlayButtons();

        $('.uninitialized.att').each( function(i, val) {
            $(this).find('.caption-area').css('width', $(this).find('.icon').outerWidth())
        });

        $('.att').removeClass('uninitialized');

}

function makeHttpLinksNewWindow() {
    $('a[href^="http://"]')
        .attr({
        target: "_blank"
    });


    $("a[href*=.pdf]").attr({"target":"_blank"});


}


function setupMenu() {
        $('#menu .section').each(function(v) {
            if($(this).find('.current').length==1 && $(this).find('.home').length==0) {
                $(this).show();
				if($(this).find('.ind').size() >0) {
					$(this).addClass('margins');
				}
                
            } else {
                $(this).find('.menuitem.ind').hide();
                $(this).show();
                $(this).removeClass('margins');
            }
        });

        $('#menu a.nourl').bind('click', function(e) {

           //$(this).css('cursor', 'default');
           $(this).unbind('click');

           s = $(this).parent().parent();
           s.addClass('margins');
           s.find('.ind').show();

        });

        $('#menu a').css('cursor','pointer');


        if( $('#menu .section:eq(1)').find('.current').length==1 && $('#menu .section:eq(1)').find('.home').length==1 ) {
            s = $('#menu .section:eq(2)');
            $(s).addClass('margins');
            $(s).find('.ind').show();

            s = $('#menu .section:eq(3)');
            $(s).addClass('margins');
            $(s).find('.ind').show();

        }

}

function admin(url, w) {
    a  = '<div class="admin">';
    a += '<iframe id="adminframe" width="' + w + '" class="autoHeight" scrolling="no" frameborder="0" src="' + url + '"></iframe>';
    a += '</div>';

    return a;
}


function getFridenlyUrl(v) {
    v = v.replace(/ /gi, '-');
    v = escape(v);
    return v.toLowerCase();
}


/* Libraries */

//scrollto
;(function(d){var k=d.scrollTo=function(a,i,e){d(window).scrollTo(a,i,e)};k.defaults={axis:'xy',duration:parseFloat(d.fn.jquery)>=1.3?0:1};k.window=function(a){return d(window)._scrollable()};d.fn._scrollable=function(){return this.map(function(){var a=this,i=!a.nodeName||d.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!i)return a;var e=(a.contentWindow||a).document||a.ownerDocument||a;return d.browser.safari||e.compatMode=='BackCompat'?e.body:e.documentElement})};d.fn.scrollTo=function(n,j,b){if(typeof j=='object'){b=j;j=0}if(typeof b=='function')b={onAfter:b};if(n=='max')n=9e9;b=d.extend({},k.defaults,b);j=j||b.speed||b.duration;b.queue=b.queue&&b.axis.length>1;if(b.queue)j/=2;b.offset=p(b.offset);b.over=p(b.over);return this._scrollable().each(function(){var q=this,r=d(q),f=n,s,g={},u=r.is('html,body');switch(typeof f){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(f)){f=p(f);break}f=d(f,this);case'object':if(f.is||f.style)s=(f=d(f)).offset()}d.each(b.axis.split(''),function(a,i){var e=i=='x'?'Left':'Top',h=e.toLowerCase(),c='scroll'+e,l=q[c],m=k.max(q,i);if(s){g[c]=s[h]+(u?0:l-r.offset()[h]);if(b.margin){g[c]-=parseInt(f.css('margin'+e))||0;g[c]-=parseInt(f.css('border'+e+'Width'))||0}g[c]+=b.offset[h]||0;if(b.over[h])g[c]+=f[i=='x'?'width':'height']()*b.over[h]}else{var o=f[h];g[c]=o.slice&&o.slice(-1)=='%'?parseFloat(o)/100*m:o}if(/^\d+$/.test(g[c]))g[c]=g[c]<=0?0:Math.min(g[c],m);if(!a&&b.queue){if(l!=g[c])t(b.onAfterFirst);delete g[c]}});t(b.onAfter);function t(a){r.animate(g,j,b.easing,a&&function(){a.call(this,n,b)})}}).end()};k.max=function(a,i){var e=i=='x'?'Width':'Height',h='scroll'+e;if(!d(a).is('html,body'))return a[h]-d(a)[e.toLowerCase()]();var c='client'+e,l=a.ownerDocument.documentElement,m=a.ownerDocument.body;return Math.max(l[h],m[h])-Math.min(l[c],m[c])};function p(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);



/**
 * jQuery.timers - Timer abstractions for jQuery
 * Written by Blair Mitchelmore (blair DOT mitchelmore AT gmail DOT com)
 * Licensed under the WTFPL (http://sam.zoy.org/wtfpl/).
 * Date: 2009/10/16
 *
 * @author Blair Mitchelmore
 * @version 1.2
 *
 **/

jQuery.fn.extend({
	everyTime: function(interval, label, fn, times) {
		return this.each(function() {
			jQuery.timer.add(this, interval, label, fn, times);
		});
	},
	oneTime: function(interval, label, fn) {
		return this.each(function() {
			jQuery.timer.add(this, interval, label, fn, 1);
		});
	},
	stopTime: function(label, fn) {
		return this.each(function() {
			jQuery.timer.remove(this, label, fn);
		});
	}
});

jQuery.extend({
	timer: {
		global: [],
		guid: 1,
		dataKey: "jQuery.timer",
		regex: /^([0-9]+(?:\.[0-9]*)?)\s*(.*s)?$/,
		powers: {
			// Yeah this is major overkill...
			'ms': 1,
			'cs': 10,
			'ds': 100,
			's': 1000,
			'das': 10000,
			'hs': 100000,
			'ks': 1000000
		},
		timeParse: function(value) {
			if (value == undefined || value == null)
				return null;
			var result = this.regex.exec(jQuery.trim(value.toString()));
			if (result[2]) {
				var num = parseFloat(result[1]);
				var mult = this.powers[result[2]] || 1;
				return num * mult;
			} else {
				return value;
			}
		},
		add: function(element, interval, label, fn, times) {
			var counter = 0;

			if (jQuery.isFunction(label)) {
				if (!times)
					times = fn;
				fn = label;
				label = interval;
			}

			interval = jQuery.timer.timeParse(interval);

			if (typeof interval != 'number' || isNaN(interval) || interval < 0)
				return;

			if (typeof times != 'number' || isNaN(times) || times < 0)
				times = 0;

			times = times || 0;

			var timers = jQuery.data(element, this.dataKey) || jQuery.data(element, this.dataKey, {});

			if (!timers[label])
				timers[label] = {};

			fn.timerID = fn.timerID || this.guid++;

			var handler = function() {
				if ((++counter > times && times !== 0) || fn.call(element, counter) === false)
					jQuery.timer.remove(element, label, fn);
			};

			handler.timerID = fn.timerID;

			if (!timers[label][fn.timerID])
				timers[label][fn.timerID] = window.setInterval(handler,interval);

			this.global.push( element );

		},
		remove: function(element, label, fn) {
			var timers = jQuery.data(element, this.dataKey), ret;

			if ( timers ) {

				if (!label) {
					for ( label in timers )
						this.remove(element, label, fn);
				} else if ( timers[label] ) {
					if ( fn ) {
						if ( fn.timerID ) {
							window.clearInterval(timers[label][fn.timerID]);
							delete timers[label][fn.timerID];
						}
					} else {
						for ( var fn in timers[label] ) {
							window.clearInterval(timers[label][fn]);
							delete timers[label][fn];
						}
					}

					for ( ret in timers[label] ) break;
					if ( !ret ) {
						ret = null;
						delete timers[label];
					}
				}

				for ( ret in timers ) break;
				if ( !ret )
					jQuery.removeData(element, this.dataKey);
			}
		}
	}
});

jQuery(window).bind("unload", function() {
	jQuery.each(jQuery.timer.global, function(index, item) {
		jQuery.timer.remove(item);
	});
});


