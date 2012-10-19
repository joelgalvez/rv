<h2>New item</h2>

<div class="actionBar">
[<?php echo CHtml::link('item List',array('list')); ?>]
[<?php echo CHtml::link('Manage item',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>