<?php if($enableYear || $enableCategory || $enableUser): ?>
<div class="gradfilters">

    <?php if($enableYear): ?>
    <ul class="grad-years">
        <?php foreach($years as $i=>$_year): ?>
        <li class="<?php if($i == $selectedYear) { echo 'selected'; }?>">
            <?php echo CHtml::link($_year,array('webPage/page',$nl=>$friendlyUrl,'y'=>$i)); ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <?php //print_r($categories); ?>
    <?php if($enableCategory): ?>
    <ul class="grad-categories">
        <?php foreach($categories as $i=>$_category): ?>
        
        <?php if($i == '0'){ $i = '';}
            $i = strtolower($i);
        ?>
        <?php
            if (empty($selectedYear)) {
                $selectedYear = 'all';
            }
        ?>
        <li class="<?php if($i == $selectedCategory) { echo 'selected'; $category_as_text = $_category; }?>">
            <?php echo CHtml::link($_category,array('webPage/page',$nl=>$friendlyUrl,'y'=>$selectedYear,'cc'=>$i ) ); ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>


    <?php
        $curUsername = '';
        if($enableUser): ?>
    <ul class="grad-people">

        <?php
            $num = sizeof($users);
            $cnt = 0;
            $cols = 3;
            if($num < 15) {
                $cols = 1;
            } else if ($num < 20) {
                $cols = 2;
            } else if ($num < 58) {
                $cols = 3;
            }

            $part = floor($num / $cols) + ($num%$cols);

        ?>
        <?php foreach($users as $i=>$_user): ?>
                <?php
                    if($cnt > 0 && $cnt%$part == 0) {
                ?>
                    </ul><ul class="grad-people">
                <?php
                    }
                ?>
                
                <?php if ($_user != 'Gerrit'): ?>

                    <li class="<?php if(strtolower($i) == strtolower($selectedUser)) {

                        echo 'selected';
                        $curUsername = $_user;
                    }?>">
                        <?php echo CHtml::link($_user,array('webPage/page',$nl=>$friendlyUrl,'y'=>$selectedYear,'cc'=>$selectedCategory, 'uu'=>$i)); ?>
                    </li>
                <?php endif; ?>

                <?php
                $cnt++;

            endforeach; ?>
    </ul>
    <?php endif; ?>
    <?php if($curUsername == '' && $selectedCategory == '' && $_ns == 4):?>
    <div class="link oldgraduations-factbox">
        <pre><?php if(Util::GetLocalization()==1): ?>Previous final
works websites:
<?php else: ?>Vorige eindexamen
websites:
<?php endif;?>

<a href="http://www.rietveldacademie.nl/finalworks2008">2008</a> <a href="http://www.rietveldacademie.nl/finalworks2007">2007</a> <a href="http://www.rietveldacademie.nl/finalworks2006">2006</a> <a href="http://www.rietveldacademie.nl/finalworks2005">2005</a>
<a href="http://www.rietveldacademie.nl/finalworks2004">2004</a> <a href="http://www.rietveldacademie.nl/finalworks2003">2003</a> <a href="http://www.rietveldacademie.nl/finalworks2002">2002</a></pre>
    </div>
    <?php endif; ?>

</div>



<?php if($curUsername != '') {?>
    <?php //hack! ?>
    <script type="text/javascript">
        
        $(document).ready(function() {
            $('#main').addClass('graduate');
        });

    </script>

    <div class="graduation-top">
    <h1><?php echo $curUsername; ?> – <?php echo $category_as_text; ?> <?php echo $selectedYear; ?></h1>
    </div>
<?php } ?>

<?php if($curUsername == '' && $selectedCategory != '') {?>
    <?php //hack! ?>
    <script type="text/javascript">

        $(document).ready(function() {
            $('#main').addClass('graduation-department');
        });

    </script>

<?php } ?>

<?php if($curUsername == '' && $selectedCategory == '') {?>
    <?php //hack! ?>
    <script type="text/javascript">

        $(document).ready(function() {
            $('#main').addClass('graduation-overview');
        });

    </script>

<?php } ?>

<?php endif; ?>

 <?php
if($selectedUser) {
    //echo('Style me and place me');
    $count = ItemUserInfo::model()->count("namespaceId=3 and friendlyName= :name", array(":name"=>$selectedUser));
    if($count > 0) {
        echo('<div class="file grad-oldprojects"><a href="'.Yii::app()->request->baseUrl."/student/".$selectedUser.'">See '.$count.' old projects</a></div>');
    }
}
?>
