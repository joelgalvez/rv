<?php

  $cs=Yii::app()->clientScript;

  Yii::app()->getClientScript()->registerCoreScript('jquery');

  $cs->registerCSSFile(Yii::app()->request->baseUrl.'/css/screen.css', 'screen, projection');
  $cs->registerCSSFile(Yii::app()->request->baseUrl.'/css/style.css', 'screen, projection');
  $cs->registerCSSFile(Yii::app()->request->baseUrl.'/css/uploadify.css', 'screen, projection');
  $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.uploadify.v2.1.0.min.js', CClientScript::POS_HEAD);
  $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/util.js', CClientScript::POS_HEAD);
  $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/swfobject.js', CClientScript::POS_HEAD);
   $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/controls.js', CClientScript::POS_HEAD);
?>
<script type="text/javascript">

    <?php
        if(isset($_GET['close'])) {
            if($_GET['close'] == 1) {
                 echo ('top.document.location.href = top.document.location.href;');
                 echo ('a = $(".admin", top.document);');
                 echo ('a.remove();');
            }
        }

    ?>




    var appName = "<?php echo ((Yii::app()->request->baseUrl == '/')? Yii::app()->request->baseUrl : Yii::app()->request->baseUrl.'/');?>";


    var itemClientId = '<?php echo CHtml::activeId($item, ''); ?>';
    
    function $i(id)
    {
        return $('#' + itemClientId + '_0_' + id);
    }

    var loadedUploads = new Array()

    $(document).ready(function(){
        var ns = '<?php echo $extra['namespace']; ?>';
        var id = '';
        var opts = {'ns':'<?php echo $extra['namespace']; ?>','ug':'<?php echo Yii::app()->user->groupId; ?>'};
        var page = new adminPanel(id, opts);

        //set update
        page.update = <?php echo $update? 'true':'false'; ?>;
        if (page.update) {
            page.attachments = <?php echo count($itemUploads) - 1; ?>;
        }

        $.each(loadedUploads, function(i, _upload){
            page.initEvents(i, _upload);
        });

        $(".defaultText").focus(function()
        {
            if ($(this).val() == $(this)[0].title)
            {
                $(this).removeClass("defaultTextActive");
                $(this).val("");
            }
        });

        $(".defaultText").live("click",function()
        {
            if ($(this).val() == $(this)[0].title)
            {
                $(this).removeClass("defaultTextActive");
                $(this).val("");
            }
        });
        $(".defaultText").live("keypress",function()
        {
            if ($(this).val() == $(this)[0].title)
            {
                $(this).removeClass("defaultTextActive");
                $(this).val("");
            }
        });

        $(".defaultText").blur(function()
        {
            if ($(this).val() == "")
            {
                $(this).addClass("defaultTextActive");
                $(this).val($(this)[0].title);
            }
        });

        $(".defaultText").blur();

        $("#adminsubmitclose").click(function(){
            $("#savenclose").val('1');
        })
        $("#adminsubmit").click(function(){
            $("#savenclose").val('0');
        })

        $("#admin").submit(function(){

            //disable submit until validated or submitted
            $("#adminsubmit").attr("disabled", "true");
            $("#adminsubmitclose").attr("disabled", "true");

            //form validation
            $(".defaultText").each(function(){
                if ($(this).val() == $(this)[0].title) {
                    $(this).val('');
                }
            })

            
            if(ns != 'Page') {
                //change url to friendly
                if($("#item_title").val() != page.itemTitleEN) {
                    $("#item_friendlyUrl").val(getFridenlyUrl($("#item_title").val()));

                }
                if($("#item_titleNl").val() != page.itemTitleNL) {
                    $("#item_friendlyUrlNl").val(getFridenlyUrl($("#item_titleNl").val()));
                }
            } else {
                
                 if($("#item_friendlyUrl").val() == '') {
                     
                    $("#item_friendlyUrl").val(getFridenlyUrl($("#item_title").val()));
                }
                if($("#item_friendlyUrlNl").val() == '') {
                    $("#item_friendlyUrlNl").val(getFridenlyUrl($("#item_titleNl").val()));
                }
            }


            //ns specific texts
            var ns_title = 'title';
            var ns_name = '';
            switch (ns) {
                case 'Page':
                    ns_title = 'name';
                    ns_name = 'A page'
                    break;
                case 'Project':
                    ns_title = 'title';
                    ns_name = 'A project'
                    break;
                case 'News':
                    ns_title = 'title';
                    ns_name = 'News'
                    break;
                case 'Graduation':
                    ns_title = 'title';
                    ns_name = 'A graduation'
                    break;
            }

            var arrErr = {};

            var title = $("#item_title").val()
            title = title.trim();

            if ((title.length == 0) || (title == '')) {
               arrErr[-1] = ns_name+" requires a "+ns_title+"<br/>";
            }
            if ((ns == 'Page') || (ns == 'News')) {
                var title = $("#item_titleNl").val()
                title = title.trim();
                if ((title.length == 0) || (title == '')) {
                   arrErr[-2] = ns_name+" requires a Dutch "+ns_title+"<br/>";
                }
            }

            if(ns == 'Graduation') {
                /*
                !!! No tag needed anymore
                var tag = $("#item_categoryId option:selected").val();
                if (tag == 0) {
                    
                    if (!$("#item_priority").attr('checked')) {
                        arrErr[-5] = ns_name+" requires a tag to be selected<br/>";
                    }
                }*/

                var year = $("#item_year").val();
                if (year.length != 4) {
                   arrErr[-6] = ns_name+" requires a year in this format YYYY<br/>";
                }
            }

            // -1 for te element used for copy
            var uploadnr = $(".theupload").size()-1;

            if (((ns == 'Project') || (ns == 'News')  ) && (uploadnr == 0)) {
                arrErr[-4] = ns_name+" requires at least one upload<br/>";
            }

            if (ns == 'News') {
                var online = $("#item_online").val();
                var offline = $("#item_offline").val();
                //should be a date validation
                if ((online.length == 0) || (offline.length == 0)) {
                    arrErr[-3] = ns_name+" require a valid from and valid to date<br/>";
                }
            }


            $(".theupload").each(function(i){
                var cssclass = $(this).attr('class');
                cssclass = cssclass.replace('theupload ','');
                cssclass = cssclass.replace('theupload','');
                var thisid = $(this).attr('id');
                thisid = thisid.replace('upload','');

                if (cssclass != '') {
                    //correct the position for projects
                     if ((ns == 'Project') || (ns == 'Graduation')) {
                        $("#ItemUpload_"+thisid+"_position").val(i);
                     }

                    switch (cssclass) {
                        case 'image':
                            img = $("#ItemUpload_"+thisid+"_fileName").val();
                            if (img.length == 0) {
                                arrErr[thisid] = "Select a local file for the image upload<br/>"
                            }

                            


                            break;
                        case 'video':
                            url = $("#ItemUpload_"+thisid+"_videolink").val();
                            if (url.length == 0) {
                                arrErr[thisid] = "Video upload require that you insert a youtube or vimeo url<br/>"
                            }

                            

                            break;
                            case 'text':
                            title = $("#ItemUpload_"+thisid+"_title").val();
                            if (title.length == 0) {
                                arrErr[thisid] = "Text uploads require a title<br/>"
                            }

                            

                            break;
                    }
                }
            })




            var i = 0;
            $("#error").html('');
            $("#success").html('');
            for (var err in arrErr) {
                i++;
                $("#error").append(arrErr[err]);
            }

            if (i > 0) {
                $(".defaultText").blur();
                $(".defaultText").each(function(){
                    if ($(this).val() == '') {
                        $(this).val($(this)[0].title);
                    }
                })
                $("#adminsubmit").removeAttr('disabled');
                $("#adminsubmitclose").removeAttr('disabled');

                location.href='#message';

                return false;
            }

            
            
            return true;

        })


        $('#close_loggedin').bind('click', function(e) {
            var answer = confirm("Are you sure you want to close, unsaved changes will be lost!")
            if (answer){
                a = $(".admin", top.document);
                a.remove();
            }
        });


    });

    function nProject(user) {
        var id = '';
        var opts = {'ns':'Project','ug':user};
        var project = new adminPanel(id, opts);
    }
    function nPage(user) {
        var id = '';
        var opts = {'ns':'Page','ug':'1'};
        var pagese = new adminPanel(id, opts);
    }
    function nGrad(user) {
        var id = '';
        var opts = {'ns':'Graduation','ug':'1'};
        var grad = new adminPanel(id, opts);
    }
    function nNews(user) {
        var id = '';
        var opts = {'ns':'News','ug':'1'};
        var news = new adminPanel(id, opts);
    }

    function autoComplete(event, item, id)
    {
        $(id).val(item[1]);
    }

    </script>



<div class="container">
<!-- admin area -->
    <div id="adminwrapper">
        <?php echo CHtml::form('','post', array('enctype'=>'multipart/form-data', 'id'=>'admin')); ?>
            <input type="hidden" id="savenclose" name="savenclose" value="<?php echo $extra['saveandclose'] ?>">
            
            
            <?php echo CHtml::activeHiddenField($item,"namespaceId"); ?>
            <?php echo CHtml::activeHiddenField($item,"id"); ?>
            <?php echo CHtml::activeHiddenField($item,"itemId"); ?>
            <?php echo CHtml::activeHiddenField($item,"localizationId"); ?>
            <?php

            //define texts and css classes
            $columns = 'half';
            $titletext = '';
            $titletext_nl = '';
            $descriptiontext = '';
            $descriptiontext_nl = '';
            switch ($item->namespaceId) {
                case '1':
                    $titletext = 'Enter page name';
                    $titletext_nl = 'Voer pagina naam';
                    $descriptiontext = 'Enter main text';
                    $descriptiontext_nl = 'Voer hoofdtekst';
                    break;
                case '2':
                    $titletext = 'Enter news title';
                    $titletext_nl = 'Voer nieuws titel';
                    $descriptiontext = 'Enter main text';
                    $descriptiontext_nl = 'Voer hoofdtekst';
                    break;
                case '3':
                    $columns = '';
                    $titletext = 'Enter project title';
                    $descriptiontext = 'Enter project description';
                    break;
                case '4':
                    $titletext = 'Enter graduation title';
                    $descriptiontext = 'Enter graduation description';
                    break;
            }
            ?>
            <!-- item start -->
            <div id="item">
                <ul id="gentabs" class="tab hidden clearfix">
                    <li id="general"><a href="#" id="np_general" class="tab selected">General</a></li>
                    <li id="advanced"><a href="#" id="np_advanced" class="tab">Advanced</a></li>
                    <li id="help"><a href="<?php echo Yii::app()->request->baseUrl; ?>/en/help/" target="_blank" id="np_help" class="tab">Help</a></li>
                    <li id="close" class="last"><a id="close_loggedin" href="#">Close</a></li>
                </ul>
                <div id="msg">
                    <a name="message"></a>
                    <div id="error">
                        <?php echo CHtml::errorSummary( array($item) + $itemUploads ); ?>
                    </div>
                    <div id="success">
                        <?php if($update && isset($_GET['f'])): ?>
                             Saved
                        <?php endif; ?>
                    </div>
                </div>
                <div class="np_general tabwin">
                    <div id="en_gen" class="half">
                        <p class="<?php echo Util::HiddenIf( $item->namespaceId == 3); echo Util::HiddenIf( $item->namespaceId == 4); ?>">en</p>
                        <p id="itemtitlep"><?php echo CHtml::activeTextField($item,"title",array('size'=>30,'maxlength'=>256, 'title'=>$titletext, 'class'=>'inp_title defaultText')); ?></p>
                        <p><?php echo CHtml::activeTextArea($item,"text",array('rows'=>6, 'cols'=>50, 'class'=>'defaultText inp_text', 'title'=>$descriptiontext)); ?></p>
                        <p id="friendlyurlen" class="<?php echo Util::HiddenIf( $item->namespaceId == 3); echo Util::HiddenIf( $item->namespaceId == 4); ?>">
                            Friendly url: <?php echo Yii::app()->createUrl("webPage/". strtolower($extra['namespace']), array('enname'=>'')); ?> <span class="generate short" style="display:none" id="_friendlyUrl"></span>
                            <?php echo CHtml::activeTextField($item,"friendlyUrl",array('size'=>40,'maxlength'=>1024)); ?>
                        </p>

                        <p id="projectCategory" class="hidden">
                            <label for="ItemUpload_categoryId">Tag</label>
                            <!--this list should contain only the users category, if an admin all categories-->
                            <?php $this->widget('application.components.ModelList',array(
                                'model' => category::model(),
                                'formModel' => $item,
                                'id' => "categoryId",
                                'condition' => category::getCategoryFilter(),
                                'initialData' => array(0 => '-- None --'),
                            )); ?>

                        </p>

                        <p id="projectShare" class="hidden">
                            <span><?php echo CHtml::activeCheckBox($item,"shared"); ?> Share</span> <br>
                            <span class="ns small">By sharing other students can also make uploads into this project</span>
                        </p>
                        <p id="priority" class="hidden">
                            <span><?php echo CHtml::activeCheckBox($item,"priority"); ?> Priority</span> <br>
                        </p>
                        <p id="nochangedate" class="hidden">
                            <span><?php echo CHtml::activeCheckBox($item,"dontChangeDate"); ?> Do not display on frontpage</span> <br>
                        </p>
                        
                        <p id="projectYear" class="hidden">
                            <label for="item_year">Year</label>
                            <?php echo CHtml::activeTextField($item,"year"); ?>
                        </p>
                        
                    </div>
                    <div id="nl_gen" class="half last hidden">
                        <p>nl</p>
                        <p><?php echo CHtml::activeTextField($item,"titleNl",array('size'=>30,'maxlength'=>256, 'title'=>$titletext_nl, 'class'=>'inp_title defaultText')); ?></p>
                        <p><?php echo CHtml::activeTextArea($item,"textNl",array('rows'=>6, 'cols'=>50, 'class'=>'defaultText inp_text', 'title'=>$descriptiontext_nl)); ?></p>
                        <p>
                            Friendly url: <?php echo Yii::app()->createUrl("webPage/". strtolower($extra['namespace']), array('nlname'=>'')); ?> <span class="generate short" style="display:none" id="_friendlyUrlNl"> </span>
                            <?php echo CHtml::activeTextField($item,"friendlyUrlNl",array('size'=>40,'maxlength'=>1024)); ?>
                        </p>
                    </div>
                </div>
                <div class="np_advanced tabwin">
                    <?php if($item->namespaceId != 2) { ?>
                    <div class="third"><p><label>Online:</label><?php echo CHtml::activeTextField($item,"online"); ?></p></div>
                    <div class="third"><p><label>Offline:</label><?php echo CHtml::activeTextField($item,"offline"); ?></p></div>
                    <?php  } ?>
                    <div class="third last"><p><label>Total uploads:</label><?php echo CHtml::activeTextField($item,"uploadNr"); ?></p></div>
                    <div id="owner" class="third">
                        <p>
                            <label>Owner:</label>
                            <?php $this->widget('CAutoComplete',
                                array(
                                     'name'=>'item[ownername]',
                                     'url'=>array('user/autoCompleteLookup'),
                                     'max'=>50,
                                     'minChars'=>1,
                                     'delay'=>500,
                                     'matchCase'=>false,
                                     'value' => $extra['usernames'][0],
                                     'methodChain'=>".result(function(event,item){autoComplete(event,item,'#item_ownerId');})",
                                ));
                            ?>
                            <?php echo CHtml::activeHiddenField($item,"ownerId"); ?>
                        </p>
                    </div>
                    <div class="third">
                        <p>
                            <label>Editor:</label>
                            <?php $this->widget('CAutoComplete',
                                array(
                                     'name'=>'item[editorname]',
                                     'url'=>array('user/autoCompleteLookup'),
                                     'max'=>50,
                                     'minChars'=>1,
                                     'delay'=>500,
                                     'matchCase'=>false,
                                    'value' => $extra['usernames'][1],
                                     'methodChain'=>".result(function(event,item){autoComplete(event,item,'#item_editorId');})",
                                ));
                            ?>
                            <?php echo CHtml::activeHiddenField($item,"editorId"); ?>
                        </p>
                    </div>
                    <div class="clear"></div>
                    <p class="s5"><?php echo CHtml::activeCheckBox($item,"commonLn"); ?>Single language. By selecting a single language the Dutch and English versions will share content</p>
                    <p class="s5"><?php echo CHtml::activeCheckBox($item,"allowChild"); ?>Allow projects. By allowing projects students and teachers can upload new projects on this page</p>
                    <p class="s5"><?php echo CHtml::activeCheckBox($item,"showChild"); ?>Show projects. By showing projects this page will display the latest projects uploaded on it</p>
                    <p class="s5"><?php echo CHtml::activeCheckBox($item,"hidden"); ?>Hide page. By hiding a page only administrators can navigate to it</p>
                    <p class="s5"><?php echo CHtml::activeCheckBox($item,"yearFilter"); ?>Year filter. The filter allows users to filter uploads on the page by year</p>
                    <p class="s5"><?php echo CHtml::activeCheckBox($item,"categoryFilter"); ?>Category filter. The filter allows users to filter uploads on the page by category</p>
                    <p class="s5"><?php echo CHtml::activeCheckBox($item,"userFilter"); ?>Student filter. The filter allows users to filter uploads on the page by student. The filter is only available if the category filter is selected</p>
                    <p id="projectMaxYear">
                            <label for="item_maxYear">Max year to show</label>
                            <?php echo CHtml::activeTextField($item,"maxYear"); ?>
                    </p>

                </div>
                <div class="fullwidth">
                    <?php if($item->namespaceId == 2) { ?>
                    <div class="l rs5"><p><label>Valid from:</label><?php echo CHtml::activeTextField($item,"online"); ?></p></div>
                    <div class="l"><p><label>Valid to:</label><?php echo CHtml::activeTextField($item,"offline"); ?></p></div>
                    <div class="clear"></div>
                    <?php  } ?>
                </div>
            </div>
            <!-- item end -->
            <!-- upload menu start -->
            <div id="menu" class="addupload">
                <div id="addUpload_-1" >
                    <div class="clear clearfix"></div>
                    <ul class="addu l">
                        <li><a href="#" id="upload" class="attachment_btn hidden">File upload</a></li>
                        <li><a href="#" id="pimage" class="attachment_btn hidden">Add image</a></li>
                        <li><a href="#" id="ptext" class="attachment_btn hidden">Add text</a></li>
                        <li><a href="#" id="pvideo" class="attachment_btn hidden">Add video</a></li>
                        <li><a href="#" id="factbox" class="attachment_btn hidden">Add text</a></li>
                        <li><a href="#" id="users" class="attachment_btn hidden">Add user list</a></li>
                        <!--<li><a href="#" id="uploadSelection" class="attachment_btn hidden">Project</a></li>-->
                        <li><a href="#" id="uploadFilter" class="attachment_btn hidden">Add filter</a></li>
                        <li><a href="#" id="breakpoint" class="attachment_btn hidden">Add break</a></li>
                    </ul>
                    <div class="r"><?php echo CHtml::submitButton('Save & close',array('class'=>'bigbut2 saveclose','id'=>'adminsubmitclose')); ?></div>
                    <div class="r"><?php echo CHtml::submitButton('Save',array('class'=>'bigbut','id'=>'adminsubmit')); ?></div>
                    <div class="clear"></div>
                </div>

            </div>
            <!-- upload menu end -->
            <!-- attachment list start -->
            <div id="attachment">
                <?php foreach($itemUploads as $i => $itemUpload): ?>
                    <?php if($i != -1): ?>
                        <script type="text/javascript"> loadedUploads[<?php echo $i; ?>] = '<?php echo $itemUpload->type; ?>'; </script>
                    <?php endif; ?>
                <!--upload copy starts -->
                <?php

                $upload_class = '';
                $description_class = '';
                $description_text = '';
                $description_text_nl = '';
                switch ($itemUpload->uploadtype) {
                    case '1':
                        $upload_class = 'image';
                        $description_class = 'inp_short';
                        $description_text = 'Enter caption';
                        $description_text_nl = 'Voer bijschrift';
                        break;
                    case '2':
                        $upload_class = 'video';
                        $description_class = 'inp_short';
                        $description_text = 'Enter description';
                        $description_text_nl = 'Voer beschrijving';
                        break;
                    case '3':
                        $upload_class = 'text';
                        $description_text = 'Enter text';
                        $description_text_nl = 'Tekst invoeren';
                        break;
                }

                ?>

                <div id="upload<?php echo $i; ?>" <?php echo Util::ShowIf($i > -1); ?> class="theupload <?php echo $upload_class; ?>">
                    <?php echo CHtml::activeHiddenField($itemUpload,"type[$i]"); ?>
                    <hr/>
                    <div class="r"><a href="#" class="black" id="delete_<?php echo $i; ?>">Delete</a></div>
                    <br clear="all" />

                    <div class="<?php echo $columns; ?>">
                        <div id="priority" class="hidden"><?php echo CHtml::activeCheckBox($itemUpload,"priority[$i]"); ?>Priority</div>

                        <div id="uploadFile<?php echo $i; ?>" class="hidden">
                            Upload: <span><?php echo CHtml::activeRadioButtonList($itemUpload,"uploadtype[$i]",array(1=>"Image",2=>"Video", 3=>"Text"))?></span>
                        </div>
                        <div id="fileInput_<?php echo $i; ?>" class="simple <?php echo Util::HiddenIf( $itemUpload->type != 'upload'); ?>">
                            <div id="uploadimgdiv_<?php echo $i; ?>" class="split l <?php echo Util::HiddenIf( $item->namespaceId == 3); echo Util::HiddenIf( $itemUpload->uploadtype == 2);  ?> ">
                                <?php echo CHtml::activeHiddenField($itemUpload,"filePath[$i]"); ?>
                                <?php echo CHtml::activeHiddenField($itemUpload,"fileName[$i]"); ?>
                            </div>

                            <div id="video_link_<?php echo $i; ?>" class="split <?php echo Util::HiddenIf( $itemUpload->uploadtype != 2); ?>">
                                <!--NOTE-->
                                <label>Paste a video link</label><br/>
                                <?php echo CHtml::activeTextField($itemUpload,"videolink[$i]",array('style'=>'width:450px','maxlength'=>2056, 'class'=>'inp_text')); ?>
                                <p class="ns small">Examples: http://www.vimeo.com/8484565</p>
                                <p class="ns small">http://www.youtube.com/watch?v=hcd4jISSvLE</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div id="uploadFile<?php echo $i; ?>_preview" class="l previewimage <?php echo Util::HiddenIf( $itemUpload->type != 'upload'); ?>" >
                            <img id="uploadFile<?php echo $i; ?>_preview_image" src = "<?php echo Yii::app()->request->baseUrl.$itemUpload->filePath.'150-'.$itemUpload->fileName; ?>" class="<?php echo Util::HiddenIf( $itemUpload->uploadtype != 1); ?>" width="125"/>
                        </div>
                        <div class="hidden" id="imageWidth<?php echo $i; ?>">
                            <?php echo CHtml::activeTextField($itemUpload,"imageWidth[$i]"); ?>
                        </div>
                        <div class="hidden" id="imageHeight<?php echo $i; ?>">
                            <?php echo CHtml::activeTextField($itemUpload,"imageHeight[$i]"); ?>
                        </div>
                        <div class="simple <?php echo Util::HiddenIf( ($itemUpload->uploadtype == 1 || $itemUpload->uploadtype == 2)); ?>" id="uploadTitle<?php echo $i; ?>"  >
                            <?php echo CHtml::activeTextField($itemUpload,"title[$i]",array('size'=>30,'maxlength'=>512, 'class'=>'inp_title defaultText', 'title'=>'Enter title')); ?>
                        </div>

                        <div class="simple <?php echo Util::HiddenIf( $itemUpload->type != 'upload' && $itemUpload->type != 'factbox' );  echo  Util::LeftIf( $item->namespaceId == 3) ?>" id="uploadText<?php echo $i; ?>"  >
                            <?php echo CHtml::activeTextArea($itemUpload,"text[$i]",array('rows'=>6, 'cols'=>27, 'class'=>'inp_text defaultText '.$description_class, 'title'=>$description_text)); ?>
                        </div>
                        <div class="clear"></div>
                        <div class="simple <?php echo Util::HiddenIf( $itemUpload->type != 'factbox' ); ?>" id="factboxType<?php echo $i; ?>">
                            <label for="ItemUpload_factboxType">Text type</label>
                            <?php echo CHtml::activeRadioButtonList($itemUpload,"factboxType[$i]",array("text"=>"Text","link"=>"Link", "file"=>"File", "deadline"=>"Deadline", "anchor"=>"Anchor"),array("separator"=>""))?>
                        </div>
                        <!--online was here-->
                        
                        <div class="simple <?php echo Util::HiddenIf( $item->namespaceId == 3 ); echo Util::HiddenIf( $item->namespaceId == 4 ); ?>">
                            <?php echo CHtml::activeLabelEx($itemUpload,'position'); ?>
                            <?php echo CHtml::activeTextField($itemUpload,"position[$i]",array('class'=>'position')); ?>

                        </div>
                        <div class="simple hidden">
                            <?php echo CHtml::activeLabelEx($itemUpload,'localizationId'); ?>
                            <?php $this->widget('application.components.ModelList',array(
                                'model' => localization::model(),
                                'formModel' => $itemUpload,
                                'id' => "localizationId[$i]",
                                'initialData' => array(),

                                )); ?>
                        </div>
                        <div class="simple <?php echo Util::HiddenIf( $itemUpload->type != 'uploadSelection' && $itemUpload->type != 'uploadFilter'); ?>" id="uploadItem<?php echo $i; ?>">
                            <label for="ItemUpload_uploadSelectedItemId">Search for a project</label>
                            <?php $this->widget('CAutoComplete',
                                array(
                                     'name'=>"projectSelected[$i]",
                                     'url'=>array('item/filter'),
                                     'max'=>50,
                                     'minChars'=>1,
                                     'delay'=>500,
                                     'matchCase'=>false,
                                     'value'=>$extra['selectedItems'][$i],
                                     'methodChain'=>".result(function(event,item){autoComplete(event,item,'#ItemUpload_".$i."_uploadSelectedItemId');})",
                                ));
                            ?>
                            <?php echo CHtml::activeHiddenField($itemUpload,"uploadSelectedItemId[$i]"); ?>

                        </div>
                        <div  class="simple <?php echo Util::HiddenIf( $itemUpload->type != 'uploadFilter'); ?>" id="uploadFilter<?php echo $i; ?>">
                            <div id="uploadNamespace<?php echo $i; ?>" class="bs5">
                                <?php echo CHtml::activeLabelEx($itemUpload,'categoryId'); ?>
                                <?php $this->widget('application.components.ModelList',array(
                                        'model' => category::model(),
                                        'formModel' => $itemUpload,
                                        'id' => "categoryId[$i]",
                                        'initialData' => array(0 => '-- None  --'),

                                    )); ?>
                            </div>
                            <div id="uploadCategory<?php echo $i; ?>" class="bs5">
                                <?php echo CHtml::activeLabelEx($itemUpload,'namespaceId'); ?>
                                <?php $this->widget('application.components.ModelList',array(
                                        'model' => ns::model(),
                                        'formModel' => $itemUpload,
                                        'id' => "namespaceId[$i]",
                                        'initialData' => array(0 => '-- None --'),

                                    )); ?>
                            </div>
                            <div  id="uploadNumber<?php echo $i; ?>" class="bs5">

                                <?php echo CHtml::activeLabelEx($itemUpload,'uploadFilterCount'); ?>
                                <?php echo CHtml::activeTextField($itemUpload,"uploadFilterCount[$i]"); ?>

                                <p class="ns small">possible values: number, all, fillup</p>
                            </div>

                            <div  id="uploadUploadFetch<?php echo $i; ?>" class="bs5">

                                <?php echo CHtml::activeLabelEx($itemUpload,'maxUploadFetch'); ?>
                                <?php echo CHtml::activeTextField($itemUpload,"maxUploadFetch[$i]"); ?>

                                <p class="ns small">possible values: number, 0 for all, default 1</p>

                            </div>

                            <div  id="uploadFilterYear<?php echo $i; ?>" class="bs5">

                                <?php echo CHtml::activeLabelEx($itemUpload,'filterYear'); ?>
                                <?php echo CHtml::activeTextField($itemUpload,"filterYear[$i]"); ?>
                                <p class="ns small">Currently only supported for graduations</p>
                            </div>

                            <div><?php echo CHtml::activeCheckBox($itemUpload,"onlyOnline[$i]"); ?>Show only online items on first page</div>
                            <div><?php echo CHtml::activeCheckBox($itemUpload,"orderByOnline[$i]"); ?>Order all items by online,offline date, default order is by modified date</div>
                            <div><?php echo CHtml::activeCheckBox($itemUpload,"randomOrder[$i]"); ?>Order all items randomly</div>

                        </div>
                    </div>
                    <div class="half last">
                        <div id="fileInput_<?php echo $i; ?>_nl" class="simple <?php echo Util::HiddenIf( !( $itemUpload->type == 'upload'  && ($item->namespaceId == 2  || $item->namespaceId == 1) ) ); ?>">
                            <div class="split l <?php echo Util::HiddenIf( $itemUpload->uploadtype == 2); ?>">
                                <?php echo CHtml::activeHiddenField($itemUpload,"filePathNl[$i]"); ?>
                                <?php echo CHtml::activeHiddenField($itemUpload,"fileNameNl[$i]"); ?>
                            </div>
                            <div id="video_link_<?php echo $i; ?>_nl" class="split <?php echo Util::HiddenIf( $itemUpload->uploadtype != 2 ); ?>">
                                <!--NOTE-->
                                <label>Paste a video link</label><br/>
                                <?php echo CHtml::activeTextField($itemUpload,"videoLinkNl[$i]",array('style'=>'width:450px','maxlength'=>2056, 'class'=>'inp_text')); ?>
                                <p class="ns small">Examples: http://www.vimeo.com/8484565</p>
                                <p class="ns small">http://www.youtube.com/watch?v=hcd4jISSvLE</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="hidden" id="imageWidth<?php echo $i; ?>Nl">
                            <?php echo CHtml::activeTextField($itemUpload,"imageWidthNl[$i]"); ?>
                        </div>
                        <div class="hidden" id="imageHeight<?php echo $i; ?>Nl">
                            <?php echo CHtml::activeTextField($itemUpload,"imageHeightNl[$i]"); ?>
                        </div>
                        <div id="uploadFile<?php echo $i; ?>_preview_nl" class="l previewimage <?php echo Util::HiddenIf( ! ($itemUpload->type == 'upload' && ($item->namespaceId == 2 || $item->namespaceId == 1 ))); ?>" >
                            <img id="uploadFile<?php echo $i; ?>_preview_image_nl" src="<?php echo $itemUpload->filePathNl.$itemUpload->fileNameNl; ?>" class="<?php echo Util::HiddenIf( $itemUpload->uploadtype != 1); ?>" width="125"/>
                        </div>
                        <div class="simple <?php echo Util::HiddenIf( ($itemUpload->type != 'factbox') && ($itemUpload->type != 'users') ); ?>" id="uploadTitleNl<?php echo $i; ?>">
                            <?php echo CHtml::activeTextField($itemUpload,"titleNl[$i]",array('size'=>30,'maxlength'=>512, 'class'=>'inp_title defaultText', 'title'=>'Voer de titel in')); ?>
                        </div>

                        <div class="simple <?php echo Util::HiddenIf( $itemUpload->type != 'factbox'  && !($itemUpload->type == 'upload'  && ($item->namespaceId == 2 || $item->namespaceId == 1) )); ?>" id="uploadTextNl<?php echo $i; ?>"  >
                            <?php echo CHtml::activeTextArea($itemUpload,"textNl[$i]",array('rows'=>6, 'cols'=>50, 'class'=>'inp_text defaultText '.$description_class, 'title'=>$description_text_nl)); ?>
                        </div>

                        <div id="uploadFilter<?php echo $i; ?>_preview" class="<?php echo Util::HiddenIf( $itemUpload->type != 'uploadFilter'); ?> list" >
                            <p>Filter uploads preview</p>
                            <div class="hidden" id="uploadsList<?php echo $i; ?>sample"><p><img src="%url%" width="50px" height="50px" /></p><p class="s5">{name}</p></div>
                            <div class="hidden" id="uploadsList<?php echo $i; ?>sampleVedio"><p>
                                <img id="uploadsList<?php echo $i; ?>-{id}vimg" src="" width="50px" height="50px" />
                            </p><p class="s5">{name}</p></div>
                            <div class="hidden" id="uploadsList<?php echo $i; ?>sampleText"><p class="s5">{title}</p><p> {text} </p></div>
                            <div class="split3 l" id="uploadsList<?php echo $i; ?>0">
                            </div>
                            <div class="split3 l" id="uploadsList<?php echo $i; ?>1">
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <br clear="all" />
                    <div class="fullwidth">
                        <span class="simple <?php echo Util::HiddenIf( $itemUpload->type != 'users'); ?>" id="uploadUser<?php echo $i; ?>">
                            <div class="simple">
                                <span class="rs5">
                                    <?php echo CHtml::activeLabelEx($itemUpload,'userGroupId'); ?>
                                    <?php $this->widget('application.components.ModelList',array(
                                                            'model' => usergroup::model(),
                                                            'condition'=>'deleted = 0',
                                                            'formModel' => $itemUpload,
                                                            'id' => "userGroupId[$i]",
                                                            'initialData' => array(0=>'-- None --'),
                                        )); ?>
                                </span>
                                <span class="rs5">
                                    <label for="uploadUserCategory[<?php echo $i; ?>]">Category</label>
                                    <select name="uploadUserCategory[<?php echo $i; ?>]" id="uploadUserCategory_<?php echo $i; ?>">
                                    </select>
                                    <script type="text/javascript">
                                        $('#uploadUserCategory_<?php echo $i; ?>').html($('#ItemUpload_<?php echo $i; ?>_categoryId').html())
                                        $('#uploadUserCategory_<?php echo $i; ?>').val($('#ItemUpload_<?php echo $i; ?>_categoryId').val());
                                        $('#uploadUserCategory_<?php echo $i; ?>').change(
                                            function()
                                            {
                                                $('#ItemUpload_<?php echo $i; ?>_categoryId')
                                                    .val(
                                                            $('#uploadUserCategory_<?php echo $i; ?>').val()
                                                        )
                                            }
                                        );
                                    </script>
                                </span>
                                <span>
                                    <?php echo CHtml::activeLabelEx($itemUpload,'year'); ?>
                                    <?php echo CHtml::activeDropDownList($itemUpload,"year[$i]", array("--none--","1"=>"1st","2"=>"2nd","3"=>"3rd","4"=>"4th","5"=>"5th", "2009"=>"Graduated 2009","2010"=>"Graduated 2010","2011"=>"Graduated 2011","2012"=>"Graduated 2012","2013"=>"Graduated 2013")); ?>
                                </span>
                                <span>
                                    <input type="checkbox" <?php echo ((bool)$extra['useGroup'][$i] == true)? "checked":""; ?> name="ItemUpload[<?php echo $i; ?>][useGroup]" id="uploadSelectUserGroup_<?php echo $i; ?>">
                                    <label for="ItemUpload_<?php echo $i; ?>_useGroup">Apply as filter</label>
                                </span>
                            </div>
                            <div class="simple">
                                <p><a href="#" id="uploadUserCheck_<?php echo $i; ?>">Check all</a> / <a href="#" id="uploadUserUncheck_<?php echo $i; ?>">Uncheck all</a></p>
                                <div class="list" id="uploadUser_<?php echo $i; ?>">
                                    <div class="hidden" id="uploadUserList<?php echo $i; ?>sample"><p class="s5"><input type="checkbox" value="{value}" id="ItemUpload_<?php echo $i; ?>_selectedUsers_{id}" name="ItemUpload[<?php echo $i; ?>][selectedUsers][{id}]" > {name}</p></div>
                                    <div class="half" id="uploadUserList<?php echo $i; ?>0">
                                        <?php if(isset($extra['selectedUsers'][$i])): ?>
                                            <?php foreach($extra['selectedUsers'][$i] as $j=>$k): ?>
                                                <?php if($j != 0): ?>
                                                    <p class="s5"><input type="checkbox" value="<?php echo $j ?>" id="ItemUpload_<?php echo $i; ?>_selectedUsers_<?php echo $j; ?>" name="ItemUpload[<?php echo $i; ?>][selectedUsers][<?php echo $j; ?>]" checked > <?php echo $k; ?></p>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="halfend" id="uploadUserList<?php echo $i; ?>1">
                                    </div>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>

                <?php endforeach; ?>
                <hr/>
            </div>
        <?php echo CHtml::endForm(); ?>
        <!-- attachment list end -->
    </div>
</div>


