<div class="yiiForm">

    <h3>Creating new <?php echo $extra['namespace'] ?></h3>

    <p>
        Fields with <span class="required">*</span> are required.
    </p>

    <?php echo CHtml::form('','post', array('enctype'=>'multipart/form-data')); ?>

    <?php echo CHtml::errorSummary(array_merge($items,$itemUploads)); ?>



    <?php echo CHtml::activeHiddenField($items[0],"parentId[0]"); ?>
    <?php echo CHtml::activeHiddenField($items[0],"namespaceId[0]"); ?>
    <?php echo CHtml::activeHiddenField($items[0],"itemId[0]"); ?>

    Basic
    <hr/>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'title'); ?>
        <?php echo CHtml::activeTextField($items[0],"title[0]",array('size'=>60,'maxlength'=>256)); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'text'); ?>
        <?php echo CHtml::activeTextArea($items[0],"text[0]",array('rows'=>6, 'cols'=>50)); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'friendlyUrl'); ?>
        <?php echo CHtml::activeTextField($items[0],"friendlyUrl[0]",array('size'=>60,'maxlength'=>1024)); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'commonLn'); ?>
        <?php echo CHtml::activeCheckBox($items[0],"commonLn[0]"); ?>
    </div>

    <div class="simple" <?php echo Util::ShowIf(!$extra['commonLn']); ?>>
        <?php echo CHtml::activeLabelEx($items[0],'localizationId'); ?>
        <?php $this->widget('application.components.ModelList',array(
                'model' => localization::model(),
                'formModel' => $items[0],
                'id' => "localizationId[0]",
                'initialData' => array(),

            )); ?>
    </div>

    <span id="nlItem" <?php echo Util::ShowIf(!$extra['commonLn']); ?>>
        NL <span style="float:right"><input type="button" value="Auto Translate"  onclick="javascript:translateItem()"/> </span>
        <hr/>
        <div class="simple">
            <?php echo CHtml::activeLabelEx($items[1],'title'); ?>
            <?php echo CHtml::activeTextField($items[1],"title[1]",array('size'=>60,'maxlength'=>256)); ?>
        </div>

        <div class="simple">
            <?php echo CHtml::activeLabelEx($items[1],'text'); ?>
            <?php echo CHtml::activeTextArea($items[1],"text[1]",array('rows'=>6, 'cols'=>50)); ?>
        </div>

        <div class="simple">
            <?php echo CHtml::activeLabelEx($items[1], 'friendlyUrl'); ?>
            <?php echo CHtml::activeTextField($items[1], "friendlyUrl[1]",array('size'=>60,'maxlength'=>1024)); ?>
        </div>
        <hr/>
        <br/>
    </span>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'online'); ?>
        <?php echo CHtml::activeTextField($items[0],"online[0]"); ?>
    </div>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'offline'); ?>
        <?php echo CHtml::activeTextField($items[0],"offline[0]"); ?>
    </div>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'uploadNr'); ?>
        <?php echo CHtml::activeTextField($items[0],"uploadNr[0]"); ?>
    </div>

    <!-- Not using now -->
<!--div class="simple">
<?php echo CHtml::activeLabelEx($items[0],'templateId'); ?>
<?php echo CHtml::activeTextField($items[0],"templateId[0]"); ?>
</div-->

    <br/>
    More Settings
    <hr/>

    <?php if($extra['categoryFilter']): ?>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'categoryId'); ?>
        <?php $this->widget('application.components.ModelList',array(
                    'model' => category::model(),
                    'formModel' => $items[0],
                    'id' => "categoryId[0]",
                    'initialData' => array(0 => '-- Root --'),

            )); ?>
    </div>
    <?php endif; ?>

    <?php if($extra['yearDimension']): ?>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'year'); ?>
        <?php echo CHtml::activeTextField($items[0],"year[0]"); ?>
    </div>
    <?php endif; ?>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'allowChild'); ?>
        <?php echo CHtml::activeCheckBox($items[0],"allowChild[0]"); ?>
    </div>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'showChild'); ?>
        <?php echo CHtml::activeCheckBox($items[0],"showChild[0]"); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'shared'); ?>
        <?php echo CHtml::activeCheckBox($items[0],"shared[0]"); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'categoryFilter'); ?>
        <?php echo CHtml::activeCheckBox($items[0],"categoryFilter[0]"); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'userFilter'); ?>
        <?php echo CHtml::activeCheckBox($items[0],"userFilter[0]"); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'hidden'); ?>
        <?php echo CHtml::activeCheckBox($items[0],"hidden[0]"); ?>
    </div>


    <br/>
    Access
    <hr/>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'ownerId'); ?>
        <?php $this->widget('application.components.ModelList',array(
                'model' => User::model(),
                'formModel' => $items[0],
                'nameField' => 'userId',
                'id' => "ownerId[0]",

            )); ?>
    </div>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($items[0],'editorId'); ?>
        <?php $this->widget('application.components.ModelList',array(
                'model' => User::model(),
                'formModel' => $items[0],
                'id' => "editorId[0]",
                'nameField' => 'userId',
                'initialData' => array(0 => '-- No One --'),

            )); ?>
    </div>
    <br/>
    <div id="uploads">
        <?php foreach($itemUploads as $i => $itemUpload): ?>
        <div id="upload<?php echo $i; ?>" <?php echo Util::ShowIf($i > -1); ?> >

            <?php echo CHtml::activeHiddenField($itemUpload,"type[$i]"); ?>
            <div class="simple" id="uploadType<?php echo $i; ?>"><?php echo $itemUpload->type ?></div>
            <span onclick="javascript:minimize(<?php echo $i; ?>)" class="ui-icon ui-icon-carat-2-n-s" style="cursor: pointer;float:right"></span>
            <span onclick="javascript:deleteUpload(<?php echo $i; ?>)" class="ui-icon ui-icon-circle-close" style="cursor: pointer;float:right"></span>
            <hr/>
            <div id="uploadPane<?php echo $i; ?>">
                <div class="simple" id="uploadTitle<?php echo $i; ?>"  <?php echo Util::ShowIf($itemUpload->type != 'breakpoint'); ?>>
                    <?php echo CHtml::activeLabelEx($itemUpload,'title'); ?>
                    <?php echo CHtml::activeTextField($itemUpload,"title[$i]",array('size'=>60,'maxlength'=>512)); ?>
                </div>
                <div class="simple" id="uploadText<?php echo $i; ?>" <?php echo Util::ShowIf($itemUpload->type == 'factbox' || $itemUpload->type == 'upload'); ?> >
                    <?php echo CHtml::activeLabelEx($itemUpload,'text'); ?>
                    <?php echo CHtml::activeTextArea($itemUpload,"text[$i]",array('rows'=>6, 'cols'=>50)); ?>
                </div>
                <div class="simple">
                    <?php echo CHtml::activeLabelEx($itemUpload,'position'); ?>
                    <?php echo CHtml::activeTextField($itemUpload,"position[$i]"); ?>
                </div>

                <span id="uploadOnlineOffline<?php echo $i; ?>"  <?php echo Util::ShowIf($itemUpload->type == 'upload'); ?>>
                    <div class="simple">
                        <?php echo CHtml::activeLabelEx($itemUpload,'online'); ?>
                        <?php echo CHtml::activeTextField($itemUpload,"online[$i]"); ?>
                    </div>
                    <div class="simple">
                        <?php echo CHtml::activeLabelEx($itemUpload,'offline'); ?>
                        <?php echo CHtml::activeTextField($itemUpload,"offline[$i]"); ?>
                    </div>
                </span>

                <span id="uploadFile<?php echo $i; ?>"  <?php echo Util::ShowIf($itemUpload->type == 'upload'); ?>>
                    <div class="simple">
                        <?php echo CHtml::activeLabelEx($itemUpload,'filePath'); ?>
                        <?php echo CHtml::activeFileField($itemUpload,"filePath[$i]"); ?>
                    </div>
                </span>

                <span class="simple" id="uploadUser<?php echo $i; ?>" <?php echo Util::ShowIf($itemUpload->type == 'users'); ?>>
                <div class="simple">
                    <?php echo CHtml::label('User Group', "uploadUserGroup[$i]"); ?>
                    <?php $this->widget('application.components.ModelList',array(
                                    'model' => usergroup::model(),
                                    'condition'=>'deleted = 0',
                                    'id' => "uploadUserGroup[$i]",
                                    'initialData' => array(0=>'--none--'),
                                    'view' => 'simpleDropdown',

                        )); ?>
                    </div>
                <div class="simple">
                    <?php echo CHtml::label('Users', "uploadUser[$i]"); ?>
                    <?php $this->widget('application.components.ModelList',array(
                                    'model' => user::model(),
                                    'nameField' => 'userId',
                                    'condition'=>'active = 1',
                                    'id' => "uploadUser[$i]",
                                    'options'=>array('multiple'=>'true'),
                                    'view' => 'simpleList',

                        )); ?>
                    </div>
                </span>

                <div class="simple" id="uploadItem<?php echo $i; ?>"  <?php echo Util::ShowIf($itemUpload->type == 'uploadSelected' || $itemUpload->type == 'uploadFilter'); ?>>
                    <?php echo CHtml::activeLabelEx($itemUpload,'uploadSelectedItemId'); ?>
                    <?php $this->widget('application.components.ModelList',array(
                                    'model' => item::model(),
                                    'formModel' => $itemUpload,
                                    'nameField' => 'title',
                                    'condition'=>'id != ' . Util::Get('itemid', 0),
                                    'id' => "uploadSelectedItemId[$i]",
                                    'initialData' => array(),

                        )); ?>
                </div>
                <div class="simple" style="display:none">
                    <?php echo CHtml::activeLabelEx($itemUpload,'localizationId'); ?>
                    <?php $this->widget('application.components.ModelList',array(
                                    'model' => localization::model(),
                                    'formModel' => $itemUpload,
                                    'id' => "localizationId[$i]",
                                    'initialData' => array(),

                        )); ?>
                </div>
                <div class="simple" id="uploadCategory<?php echo $i; ?>"  <?php echo Util::ShowIf($itemUpload->type == 'uploadFilter'); ?>>
                    <?php echo CHtml::activeLabelEx($itemUpload,'categoryId'); ?>
                    <?php $this->widget('application.components.ModelList',array(
                                    'model' => category::model(),
                                    'formModel' => $itemUpload,
                                    'id' => "categoryId[$i]",
                                    'initialData' => array(0 => '-- Root --'),

                        )); ?>
                </div>

                <span id="uploadNamespace<?php echo $i; ?>"  <?php echo Util::ShowIf($itemUpload->type == 'uploadFilter'); ?>>
                    <div class="simple">
                    <?php echo CHtml::activeLabelEx($itemUpload,'namespaceId'); ?>
                    <?php $this->widget('application.components.ModelList',array(
                                    'model' => ns::model(),
                                    'formModel' => $itemUpload,
                                    'id' => "namespaceId[$i]",
                                    'initialData' => array(0 => '-- none --'),

                        )); ?>
                    </div>
                    <div class="simple">
                        <?php echo CHtml::activeLabelEx($itemUpload,'uploadFilterCount'); ?>
                        <?php echo CHtml::activeTextField($itemUpload,"uploadFilterCount[$i]"); ?>
                    </div>
                </span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    Action
    <hr/>
    <?php echo CHtml::dropDownList('uploadType','0', $extra['uploadTypes'] ); ?>
    <input type="button" value="Add" onclick="addUpload()" />
    <hr/>
    <div class="action">
        <?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
    </div>

    <?php echo CHtml::endForm(); ?>
    <script type="text/javascript">
        var itemClientId = '<?php echo CHtml::activeId($items[0], ''); ?>';
        var uploadClientId = '<?php echo CHtml::activeId($itemUpload, ''); ?>';
        var friendlyUrlClicked = false;
        var friendlyUrlClickedNl = false;
        var uploadCount = <?php echo count($itemUploads) - 1; ?>

        $(function() {
		$('[id$="online"]').datepicker({dateFormat: 'yy-mm-dd'});
                $('[id$="offline"]').datepicker({dateFormat: 'yy-mm-dd'});
	});

        function $i(id)
        {
            return $('#' + itemClientId + '_0_' + id);
        }

        function $iN(id)
        {
            return $('#' + itemClientId + '_1_' + id);
        }

        function nId(id)
        {
            return itemClientId + '_1_' + id;
        }

        function translateItem()
        {
            $i('text').translate('#'+nId('text'));
            $i('title').translate('#'+nId('title'), function(r){
                if(!r.error)
                {
                    $iN('friendlyUrl').val(getFridenlyUrl($iN('title').val()));
                }
            });
        }


        $i('commonLn').change(function(){
            if($i('commonLn')[0].checked)
            {
                $i('localizationId').parent().hide('blind', null,500);
                $('#nlItem').hide('blind', null,500);
            }
            else
            {
                $i('localizationId').parent().show('blind', null,500);
                $('#nlItem').show('blind', null,500);
            }
        });

        $i('friendlyUrl').focus(function(){friendlyUrlClicked=true;});
        $iN('friendlyUrl').focus(function(){friendlyUrlClickedNl=true;});

        $i('title').keyup(function(){
            if(!friendlyUrlClicked)
            {
                $i('friendlyUrl').val(getFridenlyUrl($i('title').val()));
            }
        });

        $iN('title').keyup(function(){
            if(!friendlyUrlClickedNl)
            {
                $iN('friendlyUrl').val(getFridenlyUrl($iN('title').val()));
            }
        });

        function getFridenlyUrl(v)
        {
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

        function $u(id)
        {
            return $('#' + uploadClientId + '_' + uploadCount + '_' + id);
        }

        function addUpload()
        {
            uploadCount++;

            newUpload = $('#upload-1').html();
            newId = '#upload' + uploadCount;

            newUpload = newUpload.replaceAll("-1", uploadCount);
            newUpload = '<div id="upload'+ uploadCount + '">' + newUpload + "</div>"
            $('#uploads').append(newUpload);


            uploadType = $('#uploadType').val();

            if(uploadType != 'upload')
            {
                $('#uploadText'+ uploadCount).hide();
                $('#uploadOnlineOffline'+ uploadCount).hide();
                $('#uploadFile'+ uploadCount).hide();
                $('#uploadCategory'+ uploadCount).hide();
            }

            switch(uploadType)
            {
                case 'upload':
                    $u('online').removeClass('hasDatepicker');
                    $u('offline').removeClass('hasDatepicker');
                    $u('online').datepicker({dateFormat: 'yy-mm-dd'});
                    $u('offline').datepicker({dateFormat: 'yy-mm-dd'});
                    break;
                case 'uploadFilter':
                    $('#uploadCategory'+ uploadCount).show();
                    $('#uploadNamespace'+ uploadCount).show();
                    $('#uploadItem'+ uploadCount).show();
                    break;
                case 'uploadSelection':
                    $('#uploadItem'+ uploadCount).show();
                    break;
                case 'factbox':
                    $('#uploadText'+ uploadCount).show();
                    break;
                case 'users':
                    $('#uploadUser'+ uploadCount).show();
                    break;
                case 'breakpoint':
                    $('#uploadTitle'+ uploadCount).hide();
                    break;
            }

            $('#uploadType' + uploadCount).text(uploadType);
            $u('type').val(uploadType);
            $u('position').val(uploadCount-1);


            $(newId).show('blind', null,500);
        }

        function minimize(id)
        {
            $('#uploadPane' + id).toggle('blind', null,500);
        }

        function deleteUpload(id)
        {
            $('#upload' + id).hide('blind', null,500);
            $('#upload' + id).remove()
        }
    </script>
</div><!-- yiiForm -->