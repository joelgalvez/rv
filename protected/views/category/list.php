<h2>category List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New category',array('create')); ?>]
[<?php echo CHtml::link('Manage category',array('admin')); ?>]
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