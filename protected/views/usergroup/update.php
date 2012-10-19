<h2>Update usergroup <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('usergroup List',array('list')); ?>]
[<?php echo CHtml::link('New usergroup',array('create')); ?>]
[<?php echo CHtml::link('Manage usergroup',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>