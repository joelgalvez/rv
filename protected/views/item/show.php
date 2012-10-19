<h2>View item <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('item List',array('list')); ?>]
[<?php echo CHtml::link('New item',array('create')); ?>]
[<?php echo CHtml::link('Update item',array('update','id'=>$model->id)); ?>]
[<?php echo CHtml::link('Create a upload',array('itemUpload/create','itemid'=>$model->id)); ?>]
[<?php echo CHtml::link('manage upload',array('itemUpload/admin','itemid'=>$model->id)); ?>]
[<?php echo CHtml::linkButton('Delete item',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage item',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('itemId')); ?>
</th>
    <td><?php echo CHtml::encode($model->itemId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('parentId')); ?>
</th>
    <td><?php echo CHtml::encode($model->parentId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('localizationId')); ?>
</th>
    <td><?php echo CHtml::encode($model->localizationId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('commonLn')); ?>
</th>
    <td><?php echo CHtml::encode($model->commonLn); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('namespaceId')); ?>
</th>
    <td><?php echo CHtml::encode($model->namespaceId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('allowChild')); ?>
</th>
    <td><?php echo CHtml::encode($model->allowChild); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('showChild')); ?>
</th>
    <td><?php echo CHtml::encode($model->showChild); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('categoryId')); ?>
</th>
    <td><?php echo CHtml::encode($model->categoryId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('uploadNr')); ?>
</th>
    <td><?php echo CHtml::encode($model->uploadNr); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('shared')); ?>
</th>
    <td><?php echo CHtml::encode($model->shared); ?>
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
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('templateId')); ?>
</th>
    <td><?php echo CHtml::encode($model->templateId); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('hidden')); ?>
</th>
    <td><?php echo CHtml::encode($model->hidden); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('friendlyUrl')); ?>
</th>
    <td><?php echo CHtml::encode($model->friendlyUrl); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('modified')); ?>
</th>
    <td><?php echo CHtml::encode($model->modified); ?>
</td>
</tr>
</table>
