<h2>Update localization <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('localization List',array('list')); ?>]
[<?php echo CHtml::link('New localization',array('create')); ?>]
[<?php echo CHtml::link('Manage localization',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>