<h2>New ItemUpload</h2>

<div class="actionBar">
[<?php echo CHtml::link('ItemUpload List',array('list','itemid'=>($_GET['itemid'])?$_GET['itemid']:0)); ?>]
[<?php echo CHtml::link('Manage ItemUpload',array('admin','itemid'=>($_GET['itemid'])?$_GET['itemid']:0)); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
    'upload'=>$upload,
    'uploadUser'=>$uploadUser,
	'update'=>false,
)); ?>