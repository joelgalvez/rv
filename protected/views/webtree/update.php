<h2>Update webtree <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('webtree List',array('list')); ?>]
[<?php echo CHtml::link('New webtree',array('create')); ?>]
[<?php echo CHtml::link('Manage webtree',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
        'parentlist'=>$parentlist,
	'update'=>true,
)); ?>
