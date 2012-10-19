<?php
    //echo '$fromSearch ' . $fromSearch;

    if (!isset($fromSearch))
    {
        $users =  ($upload->getUsers());
    }

    

    $num = sizeof($users);


    $cnt = 0;
    $cols = 3;
    if($num < 10) {
        $cols = 1;
    } else if ($num < 20) {
        $cols = 2;
    } else if ($num < 58) {
        $cols = 3;
    } else {
        $cols = 4;
    }

    $part = floor($num / $cols) + ($num%$cols);

?>

<div class="cb"></div><?php //ie fix ?>
<div class="block people  <?php if($cols == 1 && !isset($fromSearch)) { echo 'padded'; }?>">

<?php if(! isset($fromSearch)): ?>
    <?php if($upload->title != "") { ?>

        <a name="<?php echo Util::friendlify($upload->title); ?>"></a>
    <?php } ?>
        <p class="title"><?php echo $upload->title; ?></p>
<?php endif; ?>
    <div class="col">
        <?php foreach($users as $u=>$user): ?>
        
            <?php
                if($cnt > 0 && $cnt%$part == 0) {
            ?>
                </div><div class="col">
            <?php
                }
            ?>
            <div class="person">
            <?php if($user->graduated && isset($user->categoryName)) { ?>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/en/final-works/<?php echo $user->year; ?>/<?php echo strtolower(str_replace(' ', '-', $user->categoryName)); ?>/<?php echo $user->friendlyName; ?>"><?php echo $user->name; ?></a>
            <?php } else { ?>
                <?php if(isset($fromSearch) || isset($user->uploadCount) && $user->uploadCount>0) {?>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/student/<?php echo $user->friendlyName; ?>"><?php echo $user->name; ?></a>
                <?php } else { ?>
                    <?php echo $user->name; ?>
                <?php } ?>
            <?php } ?>
                     <?php
                        if(!Yii::app()->user->isGuest)
                            if (Yii::app()->user->groupId==2) {
                     ?>
                        <a class="blue" href="<?php echo Yii::app()->request->baseUrl; ?>/user/show/id/<?php echo $user->id; ?>">Edit</a>
                    <?php } ?>

            </div>
        <?php
                $cnt++;
            endforeach;
        ?>
    </div>
</div>
