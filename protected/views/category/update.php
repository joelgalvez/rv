<h2>Update category <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('category List',array('list')); ?>]
[<?php echo CHtml::link('New category',array('create')); ?>]
[<?php echo CHtml::link('Manage category',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
        'parentlist'=>$parentlist,
	'update'=>true,
)); ?>