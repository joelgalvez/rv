<h2>ns List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New ns',array('create')); ?>]
[<?php echo CHtml::link('Manage ns',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:
<?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('name')); ?>:
<?php echo CHtml::encode($model->name); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('commonLn')); ?>:
<?php echo CHtml::encode($model->commonLn); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('allowChildren')); ?>:
<?php echo CHtml::encode($model->allowChildren); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('showChildren')); ?>:
<?php echo CHtml::encode($model->showChildren); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('yearDimension')); ?>:
<?php echo CHtml::encode($model->yearDimension); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('categoryFilter')); ?>:
<?php echo CHtml::encode($model->categoryFilter); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('userFilter')); ?>:
<?php echo CHtml::encode($model->userFilter); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('shared')); ?>:
<?php echo CHtml::encode($model->shared); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>