
function bbb() {

var BrowserDetect = {
    init: function () {
        this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
        this.version = this.searchVersion(navigator.userAgent)
                || this.searchVersion(navigator.appVersion)
                || "an unknown version";
        this.OS = this.searchString(this.dataOS) || "an unknown OS";
    },
    searchString: function (data) {
        for (var i=0;i<data.length;i++) {
                var dataString = data[i].string;
                var dataProp = data[i].prop;
                this.versionSearchString = data[i].versionSearch || data[i].identity;
                if (dataString) {
                        if (dataString.indexOf(data[i].subString) != -1)
                                return data[i].identity;
                }
                else if (dataProp)
                        return data[i].identity;
        }
    },
    searchVersion: function (dataString) {
        var index = dataString.indexOf(this.versionSearchString);
        if (index == -1) return;
        return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
    },
    dataBrowser: [
        {
                string: navigator.userAgent,
                subString: "Chrome",
                identity: "Chrome"
        },
        {       string: navigator.userAgent,
                subString: "OmniWeb",
                versionSearch: "OmniWeb/",
                identity: "OmniWeb"
        },
        {
                string: navigator.vendor,
                subString: "Apple",
                identity: "Safari",
                versionSearch: "Version"
        },
        {
                prop: window.opera,
                identity: "Opera"
        },
        {
                string: navigator.vendor,
                subString: "iCab",
                identity: "iCab"
        },
        {
                string: navigator.vendor,
                subString: "KDE",
                identity: "Konqueror"
        },
        {
                string: navigator.userAgent,
                subString: "Firefox",
                identity: "Firefox"
        },
        {
                string: navigator.vendor,
                subString: "Camino",
                identity: "Camino"
        },
        {               // for newer Netscapes (6+)
                string: navigator.userAgent,
                subString: "Netscape",
                identity: "Netscape"
        },
        {
                string: navigator.userAgent,
                subString: "MSIE",
                identity: "Explorer",
                versionSearch: "MSIE"
        },
        {
                string: navigator.userAgent,
                subString: "Gecko",
                identity: "Mozilla",
                versionSearch: "rv"
        },
        {               // for older Netscapes (4-)
                string: navigator.userAgent,
                subString: "Mozilla",
                identity: "Netscape",
                versionSearch: "Mozilla"
        }
    ],
    dataOS : [
        {
                string: navigator.platform,
                subString: "Win",
                identity: "Windows"
        },
        {
                string: navigator.platform,
                subString: "Mac",
                identity: "Mac"
        },
        {
                   string: navigator.userAgent,
                   subString: "iPhone",
                   identity: "iPhone/iPod"
        },
        {
                string: navigator.platform,
                subString: "Linux",
                identity: "Linux"
        }
    ]

};
BrowserDetect.init();

if ( ( BrowserDetect.browser != "Explorer") ) {
zzz();
}

$('#att8663').click(function(){
imgg=$("img", this).attr('src');
d = new Date();
if ((imgg.indexOf("thumbs") >= 0) || (imgg.indexOf("200-flyer") >= 0)) {
$("img", this).attr("src", "/gradposters/200-flyer.php?"+d.getTime());
}
else {
$("img", this).attr("src", "/gradposters/650-flyer.php?"+d.getTime());
}
});

}





function zzz() {

var oo = document.getElementById('search');

var linko = document.createElement('div');

linko.setAttribute('id','linko');

linko.innerHTML += '<div align=left><a style="font-size:17px; color: red; text-decoration: none; border-bottom: 2px solid red" href="http://www.rietveldacademie.nl/gradvid/new.php">Add Graduation Show Video</a></div>';

oo.appendChild(linko)


var ii = document.getElementById('main');
/*
var newdiv = document.createElement('div');

newdiv.setAttribute('id','gra1');

newdiv.setAttribute('class','vigra');

newdiv.setAttribute('style','border:8px solid #f00;position: fixed; top: 405px; cursor:pointer; right: 500px; ');


newdiv.innerHTML = '  <div class="playa">                <div class="videogradtn"> <img src="../gradvid/img/gradeplay.jpg" width="105" height="75" alt="" /></div><div class="videograd" style="display:none"><div style="position:absolute; right:15px; bottom:5px"><p style="font-size:12px; font-family:sans-serif; text-decoration: underline">Close</div><iframe class="framo" src="http://www.rietveldacademie.nl/gradvid/videor.html" width="550" height="520" /></div></div></div>';

ii.appendChild(newdiv);


var newdiv3 = document.createElement('div');

newdiv3.setAttribute('id','gra3');

newdiv3.setAttribute('class','vigra');

newdiv3.setAttribute('style','border:8px solid #f00;position: fixed; top: 205px; cursor:pointer; left: 400px;');

newdiv3.innerHTML = '  <div class="playa">                <div class="videogradtn"> <img src="../gradvid/img/gradeplay.jpg" width="105" height="75" alt="" /></div><div class="videograd" style="display:none"><div style="position:absolute; right:15px; bottom:5px"><p style="font-size:12px; font-family:sans-serif; text-decoration: underline">Close</div><iframe class="framo" src="http://www.rietveldacademie.nl/gradvid/videor.html" width="550" height="520" /></div></div></div>';

ii.appendChild(newdiv3);


var newdiv4 = document.createElement('div');

newdiv4.setAttribute('id','gra4');

newdiv4.setAttribute('class','vigra');

newdiv4.setAttribute('style','border:8px solid #f00;position: fixed; top: 105px; cursor:pointer; left: 620px;');

newdiv4.innerHTML = '  <div class="playa">                <div class="videogradtn"> <img src="../gradvid/img/gradeplay.jpg" width="105" height="75" alt="" /></div><div class="videograd" style="display:none"><div style="position:absolute; right:15px; bottom:5px"><p style="font-size:12px; font-family:sans-serif; text-decoration: underline">Close</div><iframe class="framo" src="http://www.rietveldacademie.nl/gradvid/videor.html" width="550" height="520" /></div></div></div>';

ii.appendChild(newdiv4);


var newdiv5 = document.createElement('div');

newdiv5.setAttribute('id','gra5');

newdiv5.setAttribute('class','vigra');

newdiv5.setAttribute('style','border:8px solid #f00;position: fixed; top: 405px; cursor:pointer; right: 100px;');

newdiv5.innerHTML = '  <div class="playa">                <div class="videogradtn"> <img src="../gradvid/img/gradeplay.jpg" width="105" height="75" alt="" /></div><div class="videograd" style="display:none"><div style="position:absolute; right:15px; bottom:5px"><p style="font-size:12px; font-family:sans-serif; text-decoration: underline">Close</div><iframe class="framo" src="http://www.rietveldacademie.nl/gradvid/videor.html" width="550" height="520" /></div></div></div>';

ii.appendChild(newdiv5);
*/


var newdiv6 = document.createElement('div');

newdiv6.setAttribute('id','gra6');

newdiv6.setAttribute('class','vigra');

newdiv6.setAttribute('style','border:8px solid #f00;position: fixed; top: 155px; cursor:pointer;left: 250px;');

newdiv6.innerHTML = '  <div class="playa">                <div class="videogradtn"> <img src="../gradvid/img/gradeplay.jpg" width="105" height="75" alt="" /></div><div class="videograd" style="display:none"><div style="position:absolute; right:15px; bottom:5px"><p style="font-size:12px; font-family:sans-serif; text-decoration: underline">Close</div><iframe class="framo" src="/gradvid/videor.html" width="550" height="520" /></div></div></div>';

ii.appendChild(newdiv6);



var newdiv2 = document.createElement('div');

newdiv2.setAttribute('id','gra2');

newdiv2.setAttribute('class','vigra');

newdiv2.setAttribute('style','border:8px solid #f00;position: fixed; top: 15px; cursor:pointer; left: 550px;');

newdiv2.innerHTML = '  <div class="playa">                <div class="videogradtn"> <img src="../gradvid/img/gradeplay.jpg" width="105" height="75" alt="" /></div><div class="videograd" style="display:none"><div style="position:absolute; right:15px; bottom:5px"><p style="font-size:12px; font-family:sans-serif; text-decoration: underline">Close</div><iframe class="framo" src="/gradvid/videor.html" width="550" height="520" /></div></div></div>';



ii.appendChild(newdiv2);

$('.att').click(function(){ 
if($('#video_on').length > 0 ) { 
		$('#video_on').find('.videograd').hide(); $('#video_on').find('.videogradtn').show(); $('#video_on').find('.framo')[0].contentWindow.location.reload(true); $('#video_on').attr("id","");
		} 
});


$('.vigra').click(function(){ 
	if( $(this).find('.videograd').is(":hidden") ) {
	$(this).find('.videograd').show(); $(this).find('.videogradtn').hide();
	}
	if($('#video_on').length > 0 ) { 
		$('#video_on').find('.videograd').hide(); $('#video_on').find('.videogradtn').show(); $('#video_on').find('.framo')[0].contentWindow.location.reload(true); $('#video_on').attr("id","");
		} 
	 if( $(this).find('.videograd').is(":visible") ) {
$(this).attr("id","video_on"); }
	}); 

}