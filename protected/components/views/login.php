    <?php if(!Yii::app()->user->isGuest): ?>
        <?php
            $firstspace = strpos(Yii::app()->user->name, ' ');
            $shortname = '';
            if($firstspace == -1 || $firstspace == '') {
                $shortname = Yii::app()->user->name;
            } else {
                $shortname = substr(Yii::app()->user->name, 0, $firstspace);
            }


        ?>
        <a class="blue" href="<?php echo Yii::app()->request->baseUrl; ?>/site/logout">Logout</a>
        <a class="blue" href="<?php echo Yii::app()->request->baseUrl.Yii::app()->user->friendlyUrl; ?>">My projects</a>
        
        <a href="<?php echo Yii::app()->request->baseUrl ?>/item/create/nid/3" class="openadmin">Add project</a>

    <?php endif; ?>

    <?php if(Yii::app()->user->isGuest) { ?>
        <a href="<?php echo Yii::app()->request->baseUrl ?>/site/login/" class="openadmin">Login to add projects</a>
    <?php } ?>
