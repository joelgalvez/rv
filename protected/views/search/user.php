<?php if(count($users) == 0): ?>
    None
<?php endif; ?>

<?php foreach($users as $user): ?>
    <?php echo CHtml::link($user->name, array('user/userInfo','uname'=>$user->friendlyName)); ?> |
<?php endforeach; ?>

<!--<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>-->