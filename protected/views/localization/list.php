<h2>localization List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New localization',array('create')); ?>]
[<?php echo CHtml::link('Manage localization',array('admin')); ?>]
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
<?php echo CHtml::encode($model->getAttributeLabel('language')); ?>:
<?php echo CHtml::encode($model->language); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('culture')); ?>:
<?php echo CHtml::encode($model->culture); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>