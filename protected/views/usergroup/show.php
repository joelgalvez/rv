<h2>View usergroup <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('usergroup List',array('list')); ?>]
[<?php echo CHtml::link('New usergroup',array('create')); ?>]
[<?php echo CHtml::link('Update usergroup',array('update','id'=>$model->id)); ?>]
[<?php echo CHtml::linkButton('Delete usergroup',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage usergroup',array('admin')); ?>]
</div>

<table class="dataGrid">
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
