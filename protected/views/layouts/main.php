<?php
    $uu = $_SERVER["REQUEST_URI"];
    $loginpage = false;
    if(strstr($uu, '/site/login')) $loginpage = true;


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

        <!--[if IE]>
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ieall-main.css" type="text/css" media="screen, projection" />
        <![endif]-->

        <!--[if IE 7]>
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie7-main.css" type="text/css" media="screen, projection" />
        <![endif]-->

        <!--[if IE 6]>
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie6-main.css" type="text/css" media="screen, projection" />
        <![endif]-->

        <title>Gerrit Rietveld Academie<?//php echo $this->pageTitle; ?></title>
<meta name="google-site-verification" content="Joum2E0vt_sMigzdhLTrhg7N4TS38__PGd8Q4wObgag" />
<meta name="google-site-verification" content="obaWa32yt3ggQmoGz0mNe4A7anxusTHydhFQZilNEX0" />
        <?php
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        $_client = Yii::app()->getClientScript();
        $_client->registerScriptFile(Yii::app()->request->baseUrl . "/js/extra.js");
        ?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-10382711-3");
pageTracker._trackPageview();
} catch(err) {}</script>



<?php if(!$loginpage) { ?>
    <script type="text/javascript">
        <?php if (isset($_GET['ac'])): ?>
            var url = window.location.href;
            url = url.replace('?ac','');
            window.parent.location.href = url;
            window.close()
        <?php endif; ?>
            
        function init() {

            //fixIndent();
            attachments();
            zigZag();
            makeHttpLinksNewWindow();
            setupMenu();

		
			
            function openAdmin(url, width) {

               if($('#adminframe').length == 0) {
                    $('body').append(admin(url, width));
                    $(this).everyTime(250, function() {
                       h = $('#adminframe').contents().find('body').outerHeight();
                       $('#adminframe').height(h);
                    });

                    $(window).bind('resize', function() {
                        centerAdmin();
                    });
                    centerAdmin();
               }
            }


            function centerAdmin() {
                sw = $(window).width();
                aw = $('.admin').width();
                x = Math.floor(sw/2-aw/2);
                $('.admin').css('left', x+'px');
                $('.admin').show(); //prevent flicker
            }


            $('a.openadmin').bind('click', function(e) {
                    e.preventDefault();

                    url = $(this).attr('href');
                    
                    width = 500;
                    if($(this).hasClass('wide')) {
                        width=1050;
                    }

                    openAdmin(url, width);

                    
            });

            $('.notimpl-more').bind('click', function(e) {
                alert('No old news or projects')
                e.preventDefault();
            });


            //search
            $('#sb').bind('click', function(e) {
                search();
                e.preventDefault();
            });

            $('#q').keyup(function(e) {
                if(e.keyCode == 13) {
                    search();
                    e.preventDefault();
                }
            });

            i = $('.project .icon, #news .icon');
            if(i.length == 1) {
                clickedIcon(i[0]);
            }

            $('a.confirm').bind('click', function(e) {
               if(!confirm('Are you sure?')) {
                   e.preventDefault();
               }
            });

            if($('.hide_more').length == 1) {
                $('.more').hide();
            }

        }

        $(document).ready(function() {
            init();
        });


        $(window).load(function() {
            if(($.browser.msie)  ){
                $.scrollTo(0);
            }            
        });





        function search() {
           s = new String(window.location).search('search');

           if(s == -1) {
               url = $('#baseurl').text() + '/' + $('#currentlocalisation').text() +  '/search#q=' + $('#q').val();
               window.location.replace(url);
           }
        }

    </script>
    </head>
        <body>
            <div id="container">
                <div id="currentlocalisation"><?php
                        $l =  Util::GetLocalization();
                        if($l==1) {
                           echo "en";
                        } else {
                            echo "nl";
                        }

                ?></div>

                <div id="baseurl"><?php echo Yii::app()->request->baseUrl; ?></div>
                <div id="menu">
                     <?php $this->widget('application.components.WebTreeMenu',array('showChangeLn'=>false, 'redirectIf'=>'site/index')); ?>
                
                     <?php
                        if(!Yii::app()->user->isGuest)
                            if (Yii::app()->user->groupId==2) {
                     ?>
                

                    <div id="adminmenu">
                        <p>&nbsp;</p>
                            <p><a class="blue openadmin wide"href="<?php echo Yii::app()->request->baseUrl; ?>/item/adminCreate/nid/2">New News-Archive</a></p>
                            <p><a class="blue openadmin" href="<?php echo Yii::app()->request->baseUrl; ?>/item/adminCreate/nid/3">New Project</a></p>
                            <p><a class="blue openadmin" href="<?php echo Yii::app()->request->baseUrl; ?>/item/adminCreate/nid/4">New Graduation</a></p>
                            <p><a class="blue openadmin wide" href="<?php echo Yii::app()->request->baseUrl; ?>/item/adminCreate/nid/1">New Page</a></p>

                        <p><?php $this->widget('application.components.MainMenu',array(
                            'items'=>array(
                            array('label'=>'Everything listed', 'url'=>array('/site/index/noredirect/')),
                            //array('label'=>'Home', 'url'=>array('/site/index')),
                            //array('label'=>'Category', 'url'=>array('/category')),
                            //array('label'=>'Items', 'url'=>array('/item')),
                            //array('label'=>'Localization', 'url'=>array('/localization')),
                            array('label'=>'All users', 'url'=>array('/user')),
                            //array('label'=>'User Groups', 'url'=>array('/usergroup')),
                            array('label'=>'Categories/tags', 'url'=>array('/category')),
                            //array('label'=>'User Groups', 'url'=>array('/usergroup')),
                            array('label'=>'Menu', 'url'=>array('/webtree')),
                            array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest)
                            //array('label'=>'Logout', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)

                            ),
                        )); ?></p>

                    </div>
                    <?php
                            }
                    ?>
                </div><!-- menu -->

                <div id="search">

                    <p>
                        <?php $this->widget('application.components.Login'); ?>

                        <?php if(Util::GetLocalization() == 1): ?>
                            <a class="black" href="<?php echo Util::GetChangeLnUrl(); ?>">Nederlands</a>
                        <?php else: ?>
                            <a class="black" href="<?php echo Util::GetChangeLnUrl(); ?>">English</a>
                        <?php endif; ?>

                        <input type="text" value="" id="q" name="q" /> <input type="button" value="Search" id="sb"/>
                    </p>

                </div>
                <div id="content">
                    <div id="main">
                        <?php echo $content; ?>
                    </div>
                </div><!-- frame -->

            </div><!-- container -->


<!-- Piwik -->
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://stats.rietveldacademie.nl/" : "http://stats.rietveldacademie.nl/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://stats.rietveldacademie.nl/piwik.php?idsite=1" style="border:0" alt=""/></p></noscript>
<!-- End Piwik Tag -->


        </body>

    </html>

<?php } else { //loginpage ?>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#close_notloggedin').bind('click', function(e) {
                    a = $(".admin", top.document);
                    a.remove();
                });
            });
        </script>

    </head>
        <body>
            <div id="login">
                <div id="close_notloggedin"><a href="">Close</a></div>
                <div id="msg"><p>Anyone working or studying at the Rietveld can login and add projects here.<br><br><p class="bmarg"><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/forgotpassword" target="_top">Forgot your password?</a><br/><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/forgotpassword" target="_top">New user</a></p></div>
                <?php echo $content; ?>
            </div>
        </body>
    </html>
<?php } ?>

<?php

if(Yii::app()->user->isGuest && $this->uniqueID != "site" && $this->action->id != "login" )
{
    Yii::app()->user->returnUrl = Yii::app()->request->requestUri;
}

?>