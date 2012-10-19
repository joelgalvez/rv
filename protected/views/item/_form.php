<div class="yiiForm">

<p>
Fields with <span class="required">*</span> are required.
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($model); ?>

Basic
<hr/>

<?php echo CHtml::activeHiddenField($model,'parentId'); ?>


<div class="simple">
<?php echo CHtml::activeLabelEx($model,'title'); ?>
<?php echo CHtml::activeTextField($model,'title',array('size'=>60,'maxlength'=>256)); ?>
</div>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'text'); ?>
<?php echo CHtml::activeTextArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
</div>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'friendlyUrl'); ?>
<?php echo CHtml::activeTextField($model,'friendlyUrl',array('size'=>60,'maxlength'=>1024)); ?>
</div>

Access
<hr/>

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

Settings
<hr/>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'online'); ?>
<?php echo CHtml::activeTextField($model,'online'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'offline'); ?>
<?php echo CHtml::activeTextField($model,'offline'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'uploadNr'); ?>
<?php echo CHtml::activeTextField($model,'uploadNr'); ?>
</div>

Relations
<hr/>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'namespaceId'); ?>
<?php $this->widget('application.components.ModelList',array(
        'model' => ns::model(),
        'formModel' => $model,
        'id' => 'namespaceId',
        'initialData' => array(0 => '-- Root --'),
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
<?php echo CHtml::activeLabelEx($model,'localizationId'); ?>
<?php $this->widget('application.components.ModelList',array(
        'model' => localization::model(),
        'formModel' => $model,
        'id' => 'localizationId',
        'initialData' => array(),

)); ?>
</div>


<!-- Not using now -->
<!--div class="simple">
<?php echo CHtml::activeLabelEx($model,'templateId'); ?>
<?php echo CHtml::activeTextField($model,'templateId'); ?>
</div-->


More Settings
<hr/>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'commonLn'); ?>
<?php echo CHtml::activeCheckBox($model,'commonLn'); ?>
</div>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'allowChild'); ?>
<?php echo CHtml::activeCheckBox($model,'allowChild'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'showChild'); ?>
<?php echo CHtml::activeCheckBox($model,'showChild'); ?>
</div>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'shared'); ?>
<?php echo CHtml::activeCheckBox($model,'shared'); ?>
</div>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'hidden'); ?>
<?php echo CHtml::activeCheckBox($model,'hidden'); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->