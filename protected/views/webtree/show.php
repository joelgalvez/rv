<h2>View webtree <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('webtree List',array('list')); ?>]
[<?php echo CHtml::link('New webtree',array('create')); ?>]
[<?php echo CHtml::link('Update webtree',array('update','id'=>$model->id)); ?>]
[<?php echo CHtml::linkButton('Delete webtree',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage webtree',array('admin')); ?>]
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
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('localizationId')); ?>
</th>
    <td><?php echo CHtml::encode($model->localizationId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('url')); ?>
</th>
    <td><?php echo CHtml::encode($model->url); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('friendlyUrl')); ?>
</th>
    <td><?php echo CHtml::encode($model->friendlyUrl); ?>
</td>
</tr>

<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('position')); ?>
</th>
    <td><?php echo CHtml::encode($model->position); ?>
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
