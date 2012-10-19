<h2>Graphic</h2>
<h2><?php echo $model->title; ?></h2>
<h2><?php echo $model->text; ?></h2>
<h2><?php echo count($model->itemuploads); ?></h2>

<?php foreach($model->itemuploads as $i=>$upload): ?>

    <?php
        echo($upload->title);
//        echo $this->renderPartial('upload/'.$upload->type, array(
//            'upload'=>$upload,
//            'parser'=>new Markdown_Parser(),
//        ));
    ?>
<?php endforeach; ?>
