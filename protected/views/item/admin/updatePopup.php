<?php $this->layout = 'popup'; ?>
<?php echo $this->renderPartial('admin/_formPopup', array(
'item'=>$item,
'itemUploads'=>$itemUploads,
'extra'=>$extra,
'update'=>true
)); ?>
