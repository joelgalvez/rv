<h2>View ns <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('ns List',array('list')); ?>]
[<?php echo CHtml::link('New ns',array('create')); ?>]
[<?php echo CHtml::link('Update ns',array('update','id'=>$model->id)); ?>]
[<?php echo CHtml::linkButton('Delete ns',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage ns',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('name')); ?>
</th>
    <td><?php echo CHtml::encode($model->name); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('commonLn')); ?>
</th>
    <td><?php echo CHtml::encode($model->commonLn); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('allowChildren')); ?>
</th>
    <td><?php echo CHtml::encode($model->allowChildren); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('showChildren')); ?>
</th>
    <td><?php echo CHtml::encode($model->showChildren); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('yearDimension')); ?>
</th>
    <td><?php echo CHtml::encode($model->yearDimension); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('categoryFilter')); ?>
</th>
    <td><?php echo CHtml::encode($model->categoryFilter); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('userFilter')); ?>
</th>
    <td><?php echo CHtml::encode($model->userFilter); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('shared')); ?>
</th>
    <td><?php echo CHtml::encode($model->shared); ?>
</td>
</tr>
</table>
