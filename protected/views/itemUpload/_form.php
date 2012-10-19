<div class="yiiForm">

<p>
Fields with <span class="required">*</span> are required.
</p>

<?php echo CHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data')); ?>

<?php echo CHtml::errorSummary($model); ?>

<b>Basic</b>
<hr/>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'title'); ?>
<?php echo CHtml::activeTextField($model,'title',array('size'=>60,'maxlength'=>512)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'text'); ?>
<?php echo CHtml::activeTextArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'position'); ?>
<?php echo CHtml::activeTextField($model,'position'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'online'); ?>
<?php echo CHtml::activeTextField($model,'online'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'offline'); ?>
<?php echo CHtml::activeTextField($model,'offline'); ?>
</div>

<b>Content</b>
<hr/>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'type'); ?>
<?php echo CHtml::activeDropDownList($model,'type',$model->UploadTypes); ?>
</div>

<span id="upload_item">
    <div class="simple">
        <?php echo CHtml::activeLabelEx($upload,'path'); ?>
        <?php echo CHtml::activeFileField($upload,'path'); ?>
    </div>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($upload,'filename'); ?>
        <?php echo CHtml::activeTextField($upload,'filename'); ?>
    </div>
</span>

<span id="upload_users">
    <div class="simple">
        <?php echo CHtml::activeLabelEx($uploadUser,'userGroupId'); ?>
        <?php $this->widget('application.components.ModelList',array(
        'model' => usergroup::model(),
        'formModel' => $uploadUser,
        'condition'=>'deleted = 0',
        'id'=>'userGroupId',
        'initialData' => array(),
        )); ?>
    </div>
</span>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'uploadSelectedItemId'); ?>
<?php $this->widget('application.components.ModelList',array(
        'model' => item::model(),
        'formModel' => $model,
        'nameField' => 'title',
        'condition'=>'id != ' . ($_GET['itemid'])?$_GET['itemid']:0,
        'id' => 'uploadSelectedItemId',
        'initialData' => array(),

)); ?>
</div>
<!--div class="simple">
<?php echo CHtml::activeLabelEx($model,'uploadBreakpoint'); ?>
<?php echo CHtml::activeTextField($model,'uploadBreakpoint'); ?>
</div-->
<!--div class="simple"  style="display:none">
<?php echo CHtml::activeLabelEx($model,'uploadFilterCount'); ?>
<?php echo CHtml::activeTextField($model,'uploadFilterCount'); ?>
</div-->
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'uploadFactbox'); ?>
<?php echo CHtml::activeTextArea($model,'uploadFactbox',array('rows'=>6, 'cols'=>50)); ?>
</div>

<b>Relations</b>
<hr/>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'localizationId'); ?>
<?php $this->widget('application.components.ModelList',array(
        'model' => localization::model(),
        'formModel' => $model,
        'id' => 'localizationId',
        'initialData' => array(),

)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'categoryId'); ?>
<?php $this->widget('application.components.ModelList',array(
        'model' => category::model(),
        'formModel' => $model,
        'id' => 'categoryId',
        'initialData' => array(0 => '-- Root --'),

)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'ownerId'); ?>
<?php $this->widget('application.components.ModelList',array(
        'model' => User::model(),
        'formModel' => $model,
        'nameField' => 'userId',
        'id' => 'ownerId',

)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'editorId'); ?>
<?php $this->widget('application.components.ModelList',array(
        'model' => User::model(),
        'formModel' => $model,
        'id' => 'editorId',        
        'nameField' => 'userId',
        'initialData' => array(0 => '-- No One --'),

)); ?>
</div>

<hr/>
<div class="action">
<?php echo CHtml::submitButton($update ? '  `Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

<script type="text/javascript">
    $('#ItemUpload_type').val('<?= $model->type;?>')
    updateType();
    
    $('#ItemUpload_type').change(updateType);

    function updateType()
    {
        $('#upload_item').hide();
        $('#upload_users').hide();
        $('#ItemUpload_uploadSelectedItemId').parent().hide();
        $('#ItemUpload_uploadFactbox').parent().hide();
        
        switch($('#ItemUpload_type').val())
        {
            case '1':
                $('#upload_item').show();
                break;

            case '3':
                $('#ItemUpload_uploadSelectedItemId').parent().show();
                break;

            case '4':
                $('#ItemUpload_uploadFactbox').parent().show();
                break;

            case '5':
                $('#upload_users').show();
                break;
                
            case '6':                
                break;

            default:
                alert('Not Done, select another');
                break;
        }
    }
</script>

</div><!-- yiiForm -->