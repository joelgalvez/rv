<?php
    $usergroup = usergroup::model()->findAllByPk($user->groupId);
    $category = category::model()->findAllByPk($user->categoryId);

    
    if(!Yii::app()->user->isGuest) {

        if(Yii::app()->user->groupId == 3) {

            $criteria = new CDbCriteria();
            $criteria->condition = "ownerId = :ownerId AND namespaceId = :namespaceId";
            $criteria->params = array(':ownerId'=>Yii::app()->user->id,':namespaceId'=>ns::GRADUATION);
            $criteria->order = 'item.year desc' ;

            $grad_item = item::model()->with('category','owner')->find($criteria);

            if($grad_item) {
                $cat = strtolower(str_replace(' ', '-', $grad_item->category->name));
                $local = Util::GetLocalization();
                if($local == 1) {
                    $local_url = '/en/final-works/';
                } else {
                    $local_url = '/nl/eindexamens/';
                }
                $grad_url = Yii::app()->request->baseUrl.$local_url.$grad_item->year.'/'.$cat.'/'.$grad_item->owner->friendlyName.'/';
            }
        }
    }
    
?>

<div class="personpage fixed">
    <div class="block">
        <h1><?php echo $user->name; ?>, <?php if($user->groupId > 0) { echo $usergroup[0]->name; } ?> <?php if($user->categoryId > 0) { echo $category[0]->name; } ?></h1>
    </div>
    
    <?php /*
        if(!Yii::app()->user->isGuest) {
            echo(Yii::app()->user->friendlyUrl);
            echo(Yii::app()->user->isGraduating);
        } */
    ?>


     <?php if(!Yii::app()->user->isGuest): ?>
        <?php if(Yii::app()->user->id == $user->id): ?>
            <div id="userpage">
                <a class="pitem" href="<?php echo Yii::app()->request->baseUrl ?>/en/help/">Help page</a>
                <a class="pitem openadmin" href="<?php echo Yii::app()->request->baseUrl ?>/item/create/nid/3">Add new project</a>
                
                <?php  if(Yii::app()->user->groupId == 3) { ?>
                    <?php if($grad_item): ?>
                        <a class="pitem openadmin" href="<?php echo Yii::app()->request->baseUrl ?>/item/update/nid/4/id/<?php echo($grad_item->id); ?>">Update your graduation exhibition</a>
                        <a class="pitem" href="<?php echo $grad_url; ?>">View your graduation exhibition</a></p>
                    <?php endif; ?>
                <?php } ?>
            </div>
            <div class="personpage-sub"><h1>Your projects: (click title for updating)</h1></div>
        <?php endif; ?>
    <?php endif; ?>
    
    
    <div id="userItemInfo">loading...</div>
    <script type="text/javascript">
        var url = '<?php echo Yii::app()->createUrl('webPage/page', array('enname'=>'user-information'));?>';

        $.get(url + '?u=<?php echo $_GET['uname']; ?>&p', function(data, status)
        {
            if(status == 'success')
            {
                $('#userItemInfo').html(data);
                attachments();
            }else
            {
                $('#userItemInfo').html('Error loading content');
            }
        });



    </script>
</div>
