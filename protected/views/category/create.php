<h2>New category</h2>

<div class="actionBar">
[<?php echo CHtml::link('category List',array('list')); ?>]
[<?php echo CHtml::link('Manage category',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
        'parentlist'=>$parentlist,
	'update'=>false,
)); ?>


