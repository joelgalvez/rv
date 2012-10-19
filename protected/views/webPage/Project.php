<?php

    $parser = new MarkdownParserHighslide();

?>
<div class="project fluid">

    <div class="uploads">
            <?php
                if(!Yii::app()->user->isGuest &&  (Yii::app()->user->id == $model->editorId || Yii::app()->user->groupId == 2) ) {
                        ?>
        <div class="rblock">
            <p><a class="openadmin" href="<?php echo Yii::app()->request->baseUrl; ?>/item/update/id/<?php echo $model->id; ?>/nid/3">Update project</a></p>
            <p><a class="blue confirm" href="<?php echo Yii::app()->request->baseUrl; ?>/site/hideitem/id/<?php echo $model->id; ?>">Delete project</a></p>
        </div>

                        <?php
                }
            ?>

        <div class="rblock">

            
            <h1><?php echo $model->title?></h1>
            <p><?php echo $parser->transform($model->text)?></p>
            <!--
            <h3>Year : <?php echo $model->year; ?></h3>
            <h3>Category : <?php echo $model->categoryId; ?></h3>
            <h3>Name : <?php echo $model->owner->name; ?></h3>
            -->
        </div>

	<?php
		$cnt = 0;
		foreach($model->itemuploads as $i=>$upload):
	?>

	    <?php            
	        echo $this->renderPartial('/webPage/upload/'.$upload->type, array(
	            'upload'=>$upload,
                    'parentItem'=>$model,
	            'parser'=>$parser,
                    'editorial'=>false,
                    'editorial_size'=>600,
                    'lbound'=>200,
                    'hbound'=>350,
                    'big'=>650,
                    'filtered_category'=>false,
                    'filtered_user'=>false,
                    'filtered_year'=>false,
                    'item_title_hide'=>true

	        ));
	    ?>

	<?php
                    $cnt++;
		endforeach;
	?>
    </div>
</div>
