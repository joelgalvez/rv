<div class="yiiForm">

<p>
Fields with <span class="required">*</span> are required.
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($model); ?>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'name'); ?>
<?php echo CHtml::activeTextField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'commonLn'); ?>
<?php echo CHtml::activeTextField($model,'commonLn'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'allowChildren'); ?>
<?php echo CHtml::activeTextField($model,'allowChildren'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'showChildren'); ?>
<?php echo CHtml::activeTextField($model,'showChildren'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'yearDimension'); ?>
<?php echo CHtml::activeTextField($model,'yearDimension'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'categoryFilter'); ?>
<?php echo CHtml::activeTextField($model,'categoryFilter'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'userFilter'); ?>
<?php echo CHtml::activeTextField($model,'userFilter'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'shared'); ?>
<?php echo CHtml::activeTextField($model,'shared'); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->