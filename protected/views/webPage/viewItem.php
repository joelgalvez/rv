<h2><?php echo $model->title; ?></h2>

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
    <td><?php echo CHtml::encode($model->localization->name); ?>
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
    <td><?php echo CHtml::encode($model->namespace->name); ?>
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
    <td><?php echo CHtml::encode(Util::IsNull($model->category)? "" : $model->category->name); ?>
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
    <td><?php echo CHtml::encode($model->owner->userId.'('. $model->owner->email .')'); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('editorId')); ?>
</th>
    <td><?php echo CHtml::encode(Util::IsNull($model->editor)? "NO ONE": $model->editor->userId.'('.$model->editor->email .')'); ?>
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
