<h2><a href="/rv/">Home</a></h2>

<div class="actionBar">
    [<?php echo CHtml::link('item List',array('list')); ?>]
    [<?php echo CHtml::link('Manage item',array('admin')); ?>]
</div>


<?php echo $this->renderPartial('admin/_form', array(
'items'=>$items,
'itemUploads'=>$itemUploads,
'extra'=>$extra,
'update'=>false
)); ?>