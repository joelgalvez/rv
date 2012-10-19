<div class="yiiForm">

<p>
Fields with <span class="required">*</span> are required.
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($model); ?>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'name'); ?>
<?php echo CHtml::activeTextField($model,'name',array('size'=>32,'maxlength'=>32)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'language'); ?>
<?php echo CHtml::activeTextField($model,'language',array('size'=>16,'maxlength'=>16)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'culture'); ?>
<?php echo CHtml::activeTextField($model,'culture',array('size'=>32,'maxlength'=>32)); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->