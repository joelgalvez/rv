<h2>Managing item</h2>

<div class="actionBar">
| <?php echo CHtml::link('item List',array('list')); ?> |
<?php foreach($ns as $key=>$namespace): ?>
    <?php echo CHtml::link('New '. $namespace->name ,array('adminCreate','nid'=>$namespace->id)); ?> |
<?php endforeach; ?>
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('id'); ?></th>
    <th><?php echo $sort->link('itemId'); ?></th>
    <th><?php echo $sort->link('title'); ?></th>
    <th><?php echo $sort->link('friendlyUrl'); ?></th>
    <th><?php echo $sort->link('categoryId'); ?></th>
    <th><?php echo $sort->link('namespaceId'); ?></th>
    <th><?php echo $sort->link('ownerId'); ?></th>
    <th><?php echo $sort->link('editorId'); ?></th>
    <th><?php echo $sort->link('hidden'); ?></th>
    <th><?php echo $sort->link('online'); ?></th>
    <th><?php echo $sort->link('offline'); ?></th>            
    <th><?php echo $sort->link('modified'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?></td>
    <td><?php echo CHtml::encode($model->itemId); ?></td>
    <td><?php echo CHtml::encode($model->title); ?></td>
    <td><?php echo CHtml::encode($model->friendlyUrl); ?></td>
    <td><?php echo CHtml::encode(Util::IsNull($model->category)? "" : $model->category->name );?></td>
    <td><?php echo CHtml::encode($model->namespace->name);?></td>
    <td><?php echo CHtml::encode($model->owner->userId);?></td>
    <td><?php echo CHtml::encode(Util::IsNull($model->editor)? "": $model->editor->userId);?></td>
    <td><?php echo ($model->hidden)?"Yes":"No"; ?></td>
    <td><?php echo date('D, j-M-Y g:i a',strtotime($model->online)); ?></td>
    <td><?php echo ($model->offline =="0000-00-00 00:00:00")? "Not set":date('D, j-M-Y g:i a', strtotime($model->offline));
    ?></td>
    <td><?php echo date("D, j-M-Y g:i a", strtotime($model->modified));
    ?></td>
    <td>
      <?php echo CHtml::link('Update',array('adminUpdate','id'=>$model->itemId,'nid'=>$model->namespaceId)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->id),
      	  'confirm'=>"Are you sure to delete #{$model->id}?")); ?>
      <?php echo CHtml::link('Create a upload',array('itemUpload/create','itemid'=>$model->id)); ?>
      <?php echo CHtml::link('manage upload',array('itemUpload/admin','itemid'=>$model->id)); ?>

      <?php foreach($ns as $key=>$namespace): ?>
         <?php echo CHtml::link('New '. $namespace->name ,array('adminCreate','nid'=>$namespace->id,'pId'=>$model->itemId)); ?> |
      <?php endforeach; ?>

	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>