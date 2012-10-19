<h2>View localization <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('localization List',array('list')); ?>]
[<?php echo CHtml::link('New localization',array('create')); ?>]
[<?php echo CHtml::link('Update localization',array('update','id'=>$model->id)); ?>]
[<?php echo CHtml::linkButton('Delete localization',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage localization',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('name')); ?>
</th>
    <td><?php echo CHtml::encode($model->name); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('language')); ?>
</th>
    <td><?php echo CHtml::encode($model->language); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('culture')); ?>
</th>
    <td><?php echo CHtml::encode($model->culture); ?>
</td>
</tr>
</table>
