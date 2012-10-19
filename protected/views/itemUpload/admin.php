<h2>Managing ItemUpload</h2>

<div class="actionBar">
[<?php echo CHtml::link('ItemUpload List',array('list','itemid'=>($_GET['itemid'])?$_GET['itemid']:0)); ?>]
[<?php echo CHtml::link('New ItemUpload',array('create','itemid'=>($_GET['itemid'])?$_GET['itemid']:0)); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('id'); ?></th>
    <th><?php echo $sort->link('type'); ?></th>
    <th><?php echo $sort->link('uploadSelectedItemId'); ?></th>
    <th><?php echo $sort->link('uploadBreakpoint'); ?></th>
    <th><?php echo $sort->link('uploadFilterCount'); ?></th>
    <th><?php echo $sort->link('itemId'); ?></th>
    <th><?php echo $sort->link('title'); ?></th>
    <th><?php echo $sort->link('position'); ?></th>
    <th><?php echo $sort->link('created'); ?></th>
    <th><?php echo $sort->link('online'); ?></th>
    <th><?php echo $sort->link('offline'); ?></th>
    <th><?php echo $sort->link('localizationId'); ?></th>
    <th><?php echo $sort->link('categoryId'); ?></th>
    <th><?php echo $sort->link('ownerId'); ?></th>
    <th><?php echo $sort->link('editorId'); ?></th>
    <th><?php echo $sort->link('modified'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?></td>
    <td><?php echo CHtml::encode($model->type); ?></td>
    <td><?php echo CHtml::encode($model->uploadSelectedItemId); ?></td>
    <td><?php echo CHtml::encode($model->uploadBreakpoint); ?></td>
    <td><?php echo CHtml::encode($model->uploadFilterCount); ?></td>
    <td><?php echo CHtml::encode($model->itemId); ?></td>
    <td><?php echo CHtml::encode($model->title); ?></td>
    <td><?php echo CHtml::encode($model->position); ?></td>
    <td><?php echo CHtml::encode($model->created); ?></td>
    <td><?php echo CHtml::encode($model->online); ?></td>
    <td><?php echo CHtml::encode($model->offline); ?></td>
    <td><?php echo CHtml::encode($model->localizationId); ?></td>
    <td><?php echo CHtml::encode($model->categoryId); ?></td>
    <td><?php echo CHtml::encode($model->ownerId); ?></td>
    <td><?php echo CHtml::encode($model->editorId); ?></td>
    <td><?php echo CHtml::encode($model->modified); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->id, 'itemid'=>$model->itemId)); ?>
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