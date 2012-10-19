<h2>Update ItemUpload <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('ItemUpload List',array('list','itemid'=>($_GET['itemid'])?$_GET['itemid']:0)); ?>]
[<?php echo CHtml::link('New ItemUpload',array('create','itemid'=>($_GET['itemid'])?$_GET['itemid']:0)); ?>]
[<?php echo CHtml::link('Manage ItemUpload',array('admin','itemid'=>($_GET['itemid'])?$_GET['itemid']:0)); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>