<h2>webtree List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New webtree',array('create')); ?>]
[<?php echo CHtml::link('Manage webtree',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:
<?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('parentId')); ?>:
<?php echo CHtml::encode($model->parentId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('name')); ?>:
<?php echo CHtml::encode($model->name); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('localizationId')); ?>:
<?php echo CHtml::encode($model->localizationId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('url')); ?>:
<?php echo CHtml::encode($model->url); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('friendlyUrl')); ?>:
<?php echo CHtml::encode($model->friendlyUrl); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('position')); ?>:
<?php echo CHtml::encode($model->position); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('modified')); ?>:
<?php echo CHtml::encode($model->modified); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('deleted')); ?>:
<?php echo CHtml::encode($model->deleted); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>