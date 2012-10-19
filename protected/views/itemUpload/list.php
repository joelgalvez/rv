<h2>ItemUpload List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New ItemUpload',array('create','itemid'=>($_GET['itemid'])?$_GET['itemid']:0)); ?>]
[<?php echo CHtml::link('Manage ItemUpload',array('admin','itemid'=>($_GET['itemid'])?$_GET['itemid']:0)); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:
<?php echo CHtml::link($model->id,array('show','id'=>$model->id, 'itemid'=>$model->itemId)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('type')); ?>:
<?php echo CHtml::encode($model->type); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('uploadSelectedItemId')); ?>:
<?php echo CHtml::encode($model->uploadSelectedItemId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('uploadBreakpoint')); ?>:
<?php echo CHtml::encode($model->uploadBreakpoint); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('uploadFilterCount')); ?>:
<?php echo CHtml::encode($model->uploadFilterCount); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('uploadFactbox')); ?>:
<?php echo CHtml::encode($model->uploadFactbox); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('itemId')); ?>:
<?php echo CHtml::encode($model->itemId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('title')); ?>:
<?php echo CHtml::encode($model->title); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('text')); ?>:
<?php echo CHtml::encode($model->text); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('position')); ?>:
<?php echo CHtml::encode($model->position); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('created')); ?>:
<?php echo CHtml::encode($model->created); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('online')); ?>:
<?php echo CHtml::encode($model->online); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('offline')); ?>:
<?php echo CHtml::encode($model->offline); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('localizationId')); ?>:
<?php echo CHtml::encode($model->localizationId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('categoryId')); ?>:
<?php echo CHtml::encode($model->categoryId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('ownerId')); ?>:
<?php echo CHtml::encode($model->ownerId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('editorId')); ?>:
<?php echo CHtml::encode($model->editorId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('modified')); ?>:
<?php echo CHtml::encode($model->modified); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>