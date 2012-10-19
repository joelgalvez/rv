<h2>Managing category</h2>

<div class="actionBar">
[<?php echo CHtml::link('category List',array('list')); ?>]
[<?php echo CHtml::link('New category',array('create')); ?>]
</div>

<?php
foreach($tree as $key=>$node):
    ?>
        <div style="float:left;width:150px;"><?php echo($node['name']) ?></div>
        <div style="float:left;width:50px;"><?php echo CHtml::link('Update',array('update','id'=>$node['id'])); ?></div>
        <div style="float:left;width:50px;"><?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$node['id']),
      	  'confirm'=>"Are you sure to delete #{$node['id']}?")); ?>
        </div>
        <div style="clear:both;"></div>
    <?php
    foreach($node['children'] as $key=>$value):
        if ($key) {
        ?>
            <div style="padding-left:20px;float:left;width:130px;"><?php echo($value) ?></div>
            <div style="float:left;width:50px;"><?php echo CHtml::link('Update',array('update','id'=>$key)); ?></div>
            <div style="float:left;width:50px;"><?php echo CHtml::linkButton('Delete',array(
              'submit'=>'',
              'params'=>array('command'=>'delete','id'=>$key),
              'confirm'=>"Are you sure to delete #{$key}?")); ?>
            </div>
            <div style="clear:both;"></div>
        <?php
        }
    endforeach;
endforeach;
?>



<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>