<?php if(isset($results)): ?>
    <?php
        foreach ($results as &$value) {
            echo("<div>Error importing, name:". $value["name"] ."</div>");
        }

    ?>
<?php else: ?>
    <?php echo CHtml::form('','post', array('enctype'=>'multipart/form-data')); ?>
    <div class="simple">
        <?php echo CHtml::label('Graduation year','gradyear'); ?>
        <?php echo CHtml::textField("gradyear"); ?>
    </div>
    <div class="simple">
            <?php echo CHtml::label('Upload file','filePath'); ?>
            <?php echo CHtml::fileField("filePath"); ?>
    </div>
    <?php echo CHtml::submitButton('Upload'); ?>
    <?php echo CHtml::endForm(); ?>
<?php endif; ?>
