<h2>View User <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('User List',array('list')); ?>]
[<?php echo CHtml::link('New User',array('create')); ?>]
[<?php echo CHtml::link('Update User',array('update','id'=>$model->id)); ?>]
[<?php echo CHtml::linkButton('Delete User',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage User',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('userId')); ?>
</th>
    <td><?php echo CHtml::encode($model->userId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('groupId')); ?>
</th>
    <td><?php echo CHtml::encode($model->groupId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('categoryId')); ?>
</th>
    <td><?php echo CHtml::encode($model->categoryId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('email')); ?>
</th>
    <td><?php echo CHtml::encode($model->email); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('password')); ?>
</th>
    <td><?php echo CHtml::encode($model->password); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('year')); ?>
</th>
    <td><?php echo CHtml::encode($model->year); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('active')); ?>
</th>
    <td><?php echo CHtml::encode($model->active); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('graduated')); ?>
</th>
    <td><?php echo CHtml::encode($model->graduated); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('modified')); ?>
</th>
    <td><?php echo CHtml::encode($model->modified); ?>
</td>
</tr>
</table>
