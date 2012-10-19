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
<?php echo CHtml::activeTextField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->