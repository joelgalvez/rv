<?php

    $parser = new MarkdownParserHighslide();

    $editorial_size = 600;
    $lbound = 150;
    $hbound = 250;
    $big = 700;
    $filtered_category = false;
    $filtered_user = false;
    $currentUser = Yii::app()->user;
?>

<div id="news">

  

  <?php if(!$currentUser->isGuest && ($currentUser == $model->editorId || $currentUser->groupId == 2)): ?>
    <?php echo CHtml::link("Edit news",array('item/adminUpdate','id'=> $model->id), array('class'=>'openadmin wide editpage')); ?>
  <?php endif; ?>


        <!--
	<div class="rblock w5">
		<h1><?php echo $model->title; ?></h1>
		<p><?php echo $parser->transform($model->text); ?></p>
	</div>
        -->



	<?php
		$cnt = 0;
		foreach($model->itemuploads as $i=>$upload):
	?>

	    <?php
	        echo $this->renderPartial('upload/'.$upload->type, array(
	            'upload'=>$upload,
                    'parentItem'=>$model,
                    'editorial_size'=>$editorial_size,
                    'lbound'=>$lbound,
                    'hbound'=>$hbound,
                    'big'=>$big,
                    'filtered_category'=>$filtered_category,
                    'filtered_user'=>$filtered_user,
	            'parser'=>new MarkdownParserHighslide,
                    'editorial'=>false,
                    'lbound'=>300,
                    'hbound'=>300,
                    'big'=>600,
                    'editorial_size'=>600,
                    'filtered_category'=>false,
                    'filtered_user'=>false
	        ));
	    ?>

	<?php
            $cnt++;
            endforeach;
	?>
</div>
