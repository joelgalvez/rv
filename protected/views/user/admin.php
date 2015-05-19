<h2>Managing User</h2>

<div class="actionBar simple">
    [<?php echo CHtml::link('User List',array('list')); ?>]
    [<?php echo CHtml::link('New User',array('create')); ?>]
    [<?php echo CHtml::link('Manage User',array('admin')); ?>]
    [<?php echo CHtml::link('Import/Update Students',array('import')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('id'); ?></th>
    <th><?php echo $sort->link('userId'); ?></th>
    <th><?php echo $sort->link('groupId'); ?></th>
    <th><?php echo $sort->link('categoryId'); ?></th>
    <th><?php echo $sort->link('email'); ?></th>
    <th><?php echo $sort->link('year'); ?></th>
    <th><?php echo $sort->link('active'); ?></th>
    <th><?php echo $sort->link('graduated'); ?></th>
    <th><?php echo $sort->link('modified'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?></td>
    <td><?php echo CHtml::encode($model->userId); ?></td>
    <td><?php echo CHtml::encode($model->groupId); ?></td>
    <td><?php echo CHtml::encode($model->categoryId); ?></td>
    <td><?php echo CHtml::encode($model->email); ?></td>
    <td><?php echo CHtml::encode($model->year); ?></td>
    <td><?php echo CHtml::encode($model->active); ?></td>
    <td><?php echo CHtml::encode($model->graduated); ?></td>
    <td><?php echo CHtml::encode($model->modified); ?></td>
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