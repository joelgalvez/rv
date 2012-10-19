<h2>New ns</h2>

<div class="actionBar">
[<?php echo CHtml::link('ns List',array('list')); ?>]
[<?php echo CHtml::link('Manage ns',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>