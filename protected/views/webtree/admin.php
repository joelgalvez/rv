<h2>Managing webtree</h2>

<div class="actionBar">
[<?php echo CHtml::link('webtree List',array('list')); ?>]
[<?php echo CHtml::link('New webtree',array('create')); ?>]
</div>

<?php $this->widget('application.components.WebTreeMenu',array('edit'=>true, 'localization'=>0)); ?>

