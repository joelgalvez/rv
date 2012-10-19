<h2>Managing ns</h2>

<div class="actionBar">
[<?php echo CHtml::link('ns List',array('list')); ?>]
[<?php echo CHtml::link('New ns',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('id'); ?></th>
    <th><?php echo $sort->link('name'); ?></th>
    <th><?php echo $sort->link('commonLn'); ?></th>
    <th><?php echo $sort->link('allowChildren'); ?></th>
    <th><?php echo $sort->link('showChildren'); ?></th>
    <th><?php echo $sort->link('yearDimension'); ?></th>
    <th><?php echo $sort->link('categoryFilter'); ?></th>
    <th><?php echo $sort->link('userFilter'); ?></th>
    <th><?php echo $sort->link('shared'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?></td>
    <td><?php echo CHtml::encode($model->name); ?></td>
    <td><?php echo CHtml::encode($model->commonLn); ?></td>
    <td><?php echo CHtml::encode($model->allowChildren); ?></td>
    <td><?php echo CHtml::encode($model->showChildren); ?></td>
    <td><?php echo CHtml::encode($model->yearDimension); ?></td>
    <td><?php echo CHtml::encode($model->categoryFilter); ?></td>
    <td><?php echo CHtml::encode($model->userFilter); ?></td>
    <td><?php echo CHtml::encode($model->shared); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->id)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->id),
      	  'confirm'=>"Are you sure to delete #{$model->id}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>