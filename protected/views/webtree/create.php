<h2>New webtree</h2>

<div class="actionBar">
[<?php echo CHtml::link('webtree List',array('list')); ?>]
[<?php echo CHtml::link('Manage webtree',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
        'parentlist'=>$parentlist,
	'update'=>false,
)); ?>
