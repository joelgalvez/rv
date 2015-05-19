<h2>Update User <?php echo $model->id; ?></h2>

<div class="actionBar simple">
    [<?php echo CHtml::link('User List',array('list')); ?>]
    [<?php echo CHtml::link('New User',array('create')); ?>]
    [<?php echo CHtml::link('Manage User',array('admin')); ?>]
    [<?php echo CHtml::link('Import/Update Students',array('import')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>