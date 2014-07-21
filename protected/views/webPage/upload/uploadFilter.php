<?php $parser = new MarkdownParserHighslide(); ?>
<div id="itemFilterContent<?php echo Util::Get('i', '') ?>-<?php echo $upload->id; ?>" class="">
<?php //echo ($upload->uploadFilterCount); ?>
<?php

        $hasItem = false;
        $uploads = ItemFilter::get($upload->id, $upload, Util::Get('i', 0), 0, $parentItem->yearFilter);
        
        $ucount = $upload->uploadFilterCount;
        $ucur = 0;

        
        
    
        foreach($uploads as $i=>$_upload): ?>

            <?php $ucur++; ?>
            
            <?php 
                if(($filtered_user) && ($_upload->item->namespaceId == ns::GRADUATION) && ($ucur == 1)) {
            ?>
                <div class="graduation-text">
                    
                    <?php echo $parser->transform($_upload->item->text); ?>
                </div>
            <?php
                }
            ?>
           

            <?php
            if(!$hasItem) { ?>
                <div class="uploads filter <?php echo (Util::Get('i', '') == '')?'':'hidden'; ?>">
            <?php }
            $hasItem = true;
            echo  $this->renderPartial('/webPage/upload/'.$_upload->type, array(
                        'upload'=>$_upload,
                        'parentItem'=>$parentItem,
                        'parser'=>$parser,
                        'editorial'=>false,
                        'namespaceId'=>$upload->namespaceId,
                        'editorial_size'=>$editorial_size,
                        'lbound'=>$lbound,
                        'hbound'=>$hbound,
                        'big'=>$big,
                        'filtered_category'=>$filtered_category,
                        'filtered_user'=>$filtered_user,
                        'filtered_year'=>$filtered_year,
                        'hide_editorial'=> $hide_editorial,
                        'filter_title'=>$upload->title,
                        'item_title_hide'=>false

               ));
           ?>
        <?php endforeach; ?>
                
    <?php if($hasItem) { ?>
        </div>
    <?php }  ?>

</div>
