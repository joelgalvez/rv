<h2>View category <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('category List',array('list')); ?>]
[<?php echo CHtml::link('New category',array('create')); ?>]
[<?php echo CHtml::link('Update category',array('update','id'=>$model->id)); ?>]
[<?php echo CHtml::linkButton('Delete category',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage category',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('parentId')); ?>
</th>
    <td><?php echo CHtml::encode($model->parentId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('name')); ?>
</th>
    <td><?php echo CHtml::encode($model->name); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('modified')); ?>
</th>
    <td><?php echo CHtml::encode($model->modified); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('deleted')); ?>
</th>
    <td><?php echo CHtml::encode($model->deleted); ?>
</td>
</tr>
</table>
