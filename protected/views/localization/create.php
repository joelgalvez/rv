<h2>New localization</h2>

<div class="actionBar">
[<?php echo CHtml::link('localization List',array('list')); ?>]
[<?php echo CHtml::link('Manage localization',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>