<h2>item List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New item',array('create')); ?>]
[<?php echo CHtml::link('Manage item',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
[<?php echo CHtml::link('Create a upload',array('itemUpload/create','itemid'=>$model->id)); ?>]
[<?php echo CHtml::link('manage upload',array('itemUpload/admin','itemid'=>$model->id)); ?>]
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:
<?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('itemId')); ?>:
<?php echo CHtml::encode($model->itemId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('parentId')); ?>:
<?php echo CHtml::encode($model->parentId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('localizationId')); ?>:
<?php echo CHtml::encode($model->localizationId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('commonLn')); ?>:
<?php echo CHtml::encode($model->commonLn); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('namespaceId')); ?>:
<?php echo CHtml::encode($model->namespaceId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('allowChild')); ?>:
<?php echo CHtml::encode($model->allowChild); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('showChild')); ?>:
<?php echo CHtml::encode($model->showChild); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('categoryId')); ?>:
<?php echo CHtml::encode($model->categoryId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('uploadNr')); ?>:
<?php echo CHtml::encode($model->uploadNr); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('shared')); ?>:
<?php echo CHtml::encode($model->shared); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('ownerId')); ?>:
<?php echo CHtml::encode($model->ownerId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('editorId')); ?>:
<?php echo CHtml::encode($model->editorId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('online')); ?>:
<?php echo CHtml::encode($model->online); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('offline')); ?>:
<?php echo CHtml::encode($model->offline); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('title')); ?>:
<?php echo CHtml::encode($model->title); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('text')); ?>:
<?php echo CHtml::encode($model->text); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('templateId')); ?>:
<?php echo CHtml::encode($model->templateId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('hidden')); ?>:
<?php echo CHtml::encode($model->hidden); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('friendlyUrl')); ?>:
<?php echo CHtml::encode($model->friendlyUrl); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('modified')); ?>:
<?php echo CHtml::encode($model->modified); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>