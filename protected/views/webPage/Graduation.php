<?php

    $parser = new MarkdownParserHighslide();

?>
Graduation.php
<div class="project fluid">
    <div class="edit">
	<?php echo CHtml::link("Edit",array('item/adminUpdate','id'=> $model->id), array('class'=>'editbutton narrow')); ?>
    </div>
    
    <div class="uploads">

        <!--
        <div class="uploads-login">
            <div class="upload-btn">
                <p style="text-indent: 0px;">
                    <a href="">Upload</a>
                </p>
            </div>
            <div class="uploads-login-form" style="display: none;">
                <div class="upload-close-btn">
                    <p style="text-indent: 0px;">
                        <a href="">Close</a>
                    </p>
                </div>
                <p style="text-indent: 0px;"> If you are working or studying at the Rietveld you can add projects</p><form><label for="email">E-mail</label><input type="text" value="" name="email"/><label for="password">Password</label><input type="password" value="" name="password"/><a href="">Login</a></form><p class="login-note" style="text-indent: 0px;">
                    <a href="">No password</a>
                </p>
            </div>
        </div>

        -->

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
                    'big'=>600,
                    'filtered_category'=>false,
                    'filtered_user'=>false,
                    'graduation'=>true

	        ));
	    ?>

	<?php
                    $cnt++;
		endforeach;
	?>
    </div>
</div>
