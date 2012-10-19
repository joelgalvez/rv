<div class="yiiForm">

    <p>
        Fields with <span class="required">*</span> are required.
    </p>

    <?php echo CHtml::beginForm(); ?>

    <?php echo CHtml::errorSummary($model); ?>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'parentId'); ?>
        <?php echo CHtml::activeDropDownList($model,'parentId',$parentlist); ?>
    </div>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'name'); ?>
        <?php echo CHtml::activeTextField($model,'name',array('size'=>60,'maxlength'=>64)); ?>
    </div>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'localizationId'); ?>
        <?php $this->widget('application.components.ModelList',array(
                'model' => localization::model(),
                'formModel' => $model,
                'id' => "localizationId",
                'initialData' => array(),

            )); ?>
    </div>
    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'url'); ?>
        <?php $this->widget('CAutoComplete',
            array(
            'url'=>array('webtree/friendlyUrlLookup'),
            'max'=>50,
            'minChars'=>1,
            'delay'=>500,
            'matchCase'=>false,
            'attribute'=>'url',
            'extraParams'=>array('ns'=>'js:function(){return $(\'#webtree_localizationId\').val()}'),
            'model'=>$model,
        ));
        ?>
    </div>


    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'friendlyUrl'); ?>
        <?php echo CHtml::activeTextField($model,'friendlyUrl',array('size'=>60,'maxlength'=>512)); ?>
    </div>


    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'defaultPage'); ?>
        <?php echo CHtml::activeCheckBox($model,'defaultPage'); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::activeLabelEx($model,'position'); ?>
        <?php echo CHtml::activeTextField($model,'position'); ?>
    </div>

    <div class="action">
        <?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->