    <?php    $lnId = Util::GetLocalization();    ?>

    <li>
        <span class="grid"><b><a href="#" class="reorder" id="">Modified</a></b></span>
        <span class="grid"><b>Owner</b></span>
        <span class="grid"><b>Editor</b></span>
        <span class="grid grid2"><b><a href="#" class="reorder" id="title">Title</a></b></span>
    
    </li>
    <?php
    $cnt = 0;
    foreach($models as $id=>$model):
        if ($cnt == 0) {
        ?>
       
            
                <ul class="clearfix">

        <?php
            //print_r($model);
        }


        ?>

        <li>
                <?php
                    $qvalue = ($lnId == 1)?$model->friendlyUrl : $model->friendlyUrlNl;
                    $title = ($lnId == 1)?$model->title : $model->titleNl;
                    $qname = ($lnId == 1)?'enname':'nlname';

                    if( $model->namespaceId != 1 && $model->namespaceId != 2)
                    {
                        $qname = 'fname';
                        $qvalue = $model->friendlyUrl;
                        $title = $model->title;
                        
                    }
                    $modified = $model->modified;
                    $online = $model->online;
                    $offline = $model->offline;
                    $owner = $model->owner->name;
                    $ownerf = Yii::app()->request->baseUrl.'/student/'.$model->owner->friendlyName;
                    $editor = $model->editor->name;
                    $editorf = Yii::app()->request->baseUrl.'/student/'.$model->editor->friendlyName;
                    


                ?>
                <span class="grid"><?php echo date('Y M j G:i', strtotime($modified)); ?></span>
                <span class="grid"><a href="<?php echo $ownerf; ?>"><?php echo $owner; ?></a></span>
                <span class="grid"><a href="<?php echo $editorf; ?>"><?php echo $editor; ?></a></span>
                <span class="grid grid2"><?php echo CHtml::link($title,array('webPage/'. strtolower($model->namespace->name), $qname=>$qvalue )); ?></span>
                <?php if($model->namespaceId == 3): ?>
                    <span class="grid grids">[<?php echo CHtml::link("Update",array('item/update','id'=>$model->id, 'nid'=>$model->namespaceId), array('class'=>'iframe')); ?>]</span>
                <?php else: ?>
                    <span class="grid grids">[<?php echo CHtml::link("Update",array('item/adminUpdate','id'=>$model->id), array('class'=>'iframe')); ?>]</span>
                <?php endif; ?>
                <span class="grid grids">[<?php echo CHtml::link("Delete",array('hideItem','id'=>$model->id)); ?>]</span>
        </li>


        <?php

        $cnt++;
    endforeach;?>
        </ul>

