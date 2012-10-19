<h2>Update ns <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('ns List',array('list')); ?>]
[<?php echo CHtml::link('New ns',array('create')); ?>]
[<?php echo CHtml::link('Manage ns',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>