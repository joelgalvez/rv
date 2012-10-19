<?php

    $parser = new MarkdownParserHighslide();

    $editorial_size = 600;
    $lbound = 150;
    $hbound = 250;
    $big = 700;
    $filtered_category = false;
    $filtered_user = false;
?>

<div id="news">

  

    <?php echo CHtml::link("Edit",array('item/adminUpdate','id'=> $model->id)); ?>
<?php if($model->editorId == Yii::app()->user->id): ?>
    <?php endif; ?>
            <div class="edit">
                <?php echo CHtml::link("Edit",array('item/adminUpdate','id'=> $model->id), array('class'=>'editbutton wide')); ?>
            </div>


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
