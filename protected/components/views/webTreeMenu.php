<?php

    $default = 1;
    $cnt = 0;
    $tags_arr = Array();

    $url = $_SERVER["REQUEST_URI"];

    // =/nl/eindexamens/2009/grafisch-ontwerp
    // =/en/grafisch-ontwerp
    $url_part = substr($url, strlen(Yii::app()->request->baseUrl), strlen($url)-strlen(Yii::app()->request->baseUrl) );
    $slashes_count = substr_count($url_part, '/');

    $slash_pos = strrpos($url, '/');
    $q_pos = strrpos($url, '?');

    if(!$q_pos) {
     $q_pos = strlen($url);
    }

    $qlen = strlen($url) - $q_pos;
    $plen = strlen($url) - $slash_pos;
    $url_slug = substr($url, $slash_pos+1, $plen - $qlen-1);

    $locale = '';
    if($localization == 1) {
     $locale = 'en';
    } else {
     $locale = 'nl';
    }

?>

<?php foreach($tree as $node): ?>
<?php
    $tags = "";
    
    $slash_pos = strrpos($node->url, '/');
    
    if($slash_pos) {
        $node_slug = substr($node->url, $slash_pos+1, strlen($node->url)-$slash_pos-1) ;
    } else {
        $node_slug = $node->url;
    }
    
    if($node->depth > 0) {
        $tags = "ind";
    } else {
        $tags = "root";
    }

    if ($node->url == "nourl") {
        $tags . " nourl";
    }
?>

 <?php
    //HACK!!
    if($node->depth == 0 && strstr( strtolower($node->url), 'project' ) != false ) {
        $tags .= " sep";
    }

    if($node->depth == 0 && strstr( strtolower($node->url), 'studium-generale' ) != false ) {
        $tags .= " sep";
    }
 ?>

<?php

    $graduation = false;
    if( strstr($node->url, 'final-works') != null || strstr($node->url, 'eindexamens') != null ) {
        if(strstr($url, 'eindexamens')  != null || strstr($url, 'final-works')  != null ) {
            $tags .= " current";
            $default = 0;
            $graduation = true;

        }
    }

    //if deeper in hierarchy then dont show dpt-match
    //ie. if in grad, dont open corresponding dpt
    if($url_slug == $node_slug && $slashes_count < 3) {
        $tags .= " current";
        $default = 0;
    }

    if( strstr($node->url, 'projects') != null || strstr($node->url, 'projecten') != null ) {
        if(strstr($url, 'project') != null) {
            $tags .= " current";
            $default = 0;
        }
    }


    if( strstr($url, 'visum') != null || strstr($url, 'verblijfsvergunning') != null || strstr($url, 'residence-permit') != null ) {
        if($node->url == 'aanmelden'|| $node->url == 'apply' ) {
            $tags .= " current";
            $default = 0;            
        }        
    }

    if( $cnt == 0) {
        $tags .= " home";
    }

    $tags_arr[$node->id] = $tags;

    $cnt++;

?>

<?php endforeach; ?>
<?php
    $arr = Array();

    //if showing an unknown match in the menu structure, then
    //expand full and part time
    if( $default) {
        
        //ugly:
        $first = true;
        foreach ($tags_arr as $key => $value) {
            if($first) {
                $value .= " current";
                $first = false;
            }
            
            $arr[$key] = $value;
        }

    } else {
        $arr = $tags_arr;
    }

?>

<div class="section">
<?php foreach($tree as $node): ?>
    <?php
        $url = '';
        if(strstr($node->url, 'gerrit-rietveld-academie')) {
            $url = '';
        } else {
            $url = $node->url;
        }
    ?>


    <?php if($node->depth == 0) { ?>
        </div>
        <div class="section" style="display:none;">
        <?php } ?>


    <div class="menuitem <?php echo $arr[$node->id]?>">
    <?php if($node->url != "nourl") {?>
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo $locale; ?>/<?php echo $url; ?>">
        <?php } else { ?>
            <a class="nourl">
        <?php } ?>

        <?php echo $node->name; ?>

        <?php if($node->url != "nourl") {?>
            </a>
        <?php } else { ?>
        </a>
    <?php } ?>
            <?php if($edit): ?>
        [<?php echo CHtml::link('Edit',array('webtree/update','id'=>$node->id)); ?>] |
        [<?php echo CHtml::link('New',array('webtree/create','parentId'=>$node->id)); ?>] |
                <?php echo CHtml::linkButton('Delete',array(
                'submit'=>'',
                'params'=>array('command'=>'delete','id'=>$node->id),
                'confirm'=>"Are you sure to delete \"{$node->name}?\"")); ?>
            <?php endif; ?>

    </div>
<?php endforeach; ?>
</div>

<?php if($showChangeLn): ?>
    <?php if($localization == 1): ?>
        <a href="?chln=2">Nederlands</a>
    <?php else: ?>
        <a href="?chln=1">English</a>
    <?php endif; ?>
<?php endif; ?>

<?php if($edit): ?>
[<?php echo CHtml::link('New',array('webtree/create',)); ?>]
<?php endif; ?>

