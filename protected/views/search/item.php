<?php if($showUpload): ?>
    <script type="text/javascript">
        var _upUrl = '<?php echo Yii::app()->createUrl('webPage/upload'); ?>';
    </script>
<?php endif; ?>

<?php
    $lnId = Util::GetLocalization();
?>

<?php if(count($items) == 0): ?>
    None
<?php endif; ?>

<?php foreach($items as $item): ?>
    <?php
        $qvalue = $item->friendlyUrl;
        $title = $item->title;
        $qname = ($lnId == 1)?'ln1':'ln2';
    ?>
    <?php if($showUpload): ?>
    <div id="search_upload_<?php echo "$item->namespaceId".((!$itemBased)?$item->uploadId:$item->id); ?>">loading full data...</div>
        <script type="text/javascript">
                var iCounter = 0;
                $.get(_upUrl+ '/?<?php echo ($itemBased)?"iid=$item->id":"uid=$item->uploadId"; ?>', function (data, status){
                    if(status == 'success')
                    {
                        $('#search_upload_<?php echo "$item->namespaceId".((!$itemBased)?$item->uploadId:$item->id); ?>').html(data);
                        //TODO: Do cache

                           searchDone();


                    }else
                    {
                        //TODO: handle error here
                    }
                });

        </script>
    <?php else: ?>
    <?php echo CHtml::link($title,array('webPage/'. $item->namespaceId, $qname=>$qvalue )); ?> |
    <?php endif; ?>
<?php endforeach; ?>

<!--<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>-->