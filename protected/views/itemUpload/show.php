<h2>View ItemUpload <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('ItemUpload List',array('list','itemid'=>($_GET['itemid'])?$_GET['itemid']:0)); ?>]
[<?php echo CHtml::link('New ItemUpload',array('create','itemid'=>($_GET['itemid'])?$_GET['itemid']:0)); ?>]
[<?php echo CHtml::link('Update ItemUpload',array('update','id'=>$model->id, 'itemid'=>$model->itemId)); ?>]
[<?php echo CHtml::linkButton('Delete ItemUpload',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage ItemUpload',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('type')); ?>
</th>
    <td><?php echo CHtml::encode($model->type); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('uploadSelectedItemId')); ?>
</th>
    <td><?php echo CHtml::encode($model->uploadSelectedItemId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('uploadBreakpoint')); ?>
</th>
    <td><?php echo CHtml::encode($model->uploadBreakpoint); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('uploadFilterCount')); ?>
</th>
    <td><?php echo CHtml::encode($model->uploadFilterCount); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('uploadFactbox')); ?>
</th>
    <td><?php echo CHtml::encode($model->uploadFactbox); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('itemId')); ?>
</th>
    <td><?php echo CHtml::encode($model->itemId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('title')); ?>
</th>
    <td><?php echo CHtml::encode($model->title); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('text')); ?>
</th>
    <td><?php echo CHtml::encode($model->text); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('position')); ?>
</th>
    <td><?php echo CHtml::encode($model->position); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('created')); ?>
</th>
    <td><?php echo CHtml::encode($model->created); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('online')); ?>
</th>
    <td><?php echo CHtml::encode($model->online); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('offline')); ?>
</th>
    <td><?php echo CHtml::encode($model->offline); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('localizationId')); ?>
</th>
    <td><?php echo CHtml::encode($model->localizationId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('categoryId')); ?>
</th>
    <td><?php echo CHtml::encode($model->categoryId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('ownerId')); ?>
</th>
    <td><?php echo CHtml::encode($model->ownerId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('editorId')); ?>
</th>
    <td><?php echo CHtml::encode($model->editorId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('modified')); ?>
</th>
    <td><?php echo CHtml::encode($model->modified); ?>
</td>
</tr>
</table>
