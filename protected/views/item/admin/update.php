<h2>Update item <?php echo $items[0]->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('item List',array('list')); ?>]
[<?php echo CHtml::link('New item',array('create')); ?>]
[<?php echo CHtml::link('Manage item',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('admin/_form', array(
'items'=>$items,
'itemUploads'=>$itemUploads,
'extra'=>$extra,
'update'=>true
)); ?>