<h2>User List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New User',array('create')); ?>]
[<?php echo CHtml::link('Manage User',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:
<?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('userId')); ?>:
<?php echo CHtml::encode($model->userId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('groupId')); ?>:
<?php echo CHtml::encode($model->groupId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('categoryId')); ?>:
<?php echo CHtml::encode($model->categoryId); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('email')); ?>:
<?php echo CHtml::encode($model->email); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('year')); ?>:
<?php echo CHtml::encode($model->year); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('active')); ?>:
<?php echo CHtml::encode($model->active); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('graduated')); ?>:
<?php echo CHtml::encode($model->graduated); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('modified')); ?>:
<?php echo CHtml::encode($model->modified); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>