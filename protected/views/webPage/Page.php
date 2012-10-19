<?php
Util::redirectGraduation($model->maxYear);

$css = "";
$editorial_size = 600;
$lbound = 200;
$hbound = 300;
$big = 650;
$filtered_category = false;
$filtered_user = false;
$filtered_year = false;
$hide_editorial = false;
$frontpage = false;

$titles = array();
foreach($model->itemuploads as $i=>$upload):
    if($upload->type == "breakpoint") {
        if(strtolower(substr($upload->title, 0, 4)=="css:")) {
            if(strtolower(substr($upload->title, 4, strlen($upload->title)-4)=="workshops")) {
            // workshops
                $editorial_size = 450;
            }

            $css .= (" " . strtolower(substr($upload->title, 4, strlen($upload->title)-4)));
        }
    }

    //echo $upload->type . ', title '. $upload->title . '<br>';

    if($upload->title != "") {
        $t = $upload->title;
        while(substr($t, 0, 1)=='#') {
            $t = substr($t, 1, strlen($t)-1);
        }
        array_push($titles, ($t));
    }

endforeach;
if(!strstr($css, 'fixed') && !strstr($css, 'fluid')) {
    $css .= " fixed";
}

if(strstr($css, 'projects')) {
    //$lbound = 250;
    //$hbound = 350;
}

if(strstr($css, 'frontpage')) {
    //$lbound = 250;
    //$hbound = 350;
    //$big = 500;
    $frontpage = true;
}

if(strstr($css, 'hide-editorial')) {
    $hide_editorial = true;
}



$parser = new MarkdownParserHighslide();

?>
<?php $grad_filter = $this->widget('application.components.GraduationFilter',array(
    'enableYear' => $model->yearFilter,
    'enableCategory' => $model->categoryFilter,
    'enableUser' => $model->userFilter,
    'friendlyUrl' => $model->friendlyUrl,
    'maxYear' => $model->maxYear,
    'itemId' => $model->id
)); ?>


<?php

if($grad_filter->selectedUser != null) {
    $lbound = 500;
    $hbound = 500;
    $big = 700;
    $filtered_user = true;

} elseif($grad_filter->selectedCategory != null) {
    $lbound = 250;
    $hbound = 400;
    $filtered_category = true;

} elseif($grad_filter->selectedYear != null) {
    $lbound = 100;
    $hbound = 250;
    $filtered_year = true;

}

if($filtered_user || $filtered_category) {
//    $css .= " hide_more";
}

?>

<div class="<?php echo $css ?>">
    <?php if(!Yii::app()->user->isGuest && Yii::app()->user->groupId==2) { ?>

        <a class="openadmin wide editpage" href="<?php echo Yii::app()->request->baseUrl; ?>/item/adminUpdate/id/<?php echo $model->id;?>">Edit page</a>

    <?php
        }
    ?>

    <div class="jumpmenu">
        <?php foreach($titles as $t) {

            if(!strstr($t, 'css:') && !strstr($t, 'p:')) {
                ?>

        <div class="anchor"><a href="#<?php echo Util::friendlify($t); ?>"><?php echo $t; ?></a></div>
            <?php }
        } ?>
    </div>



    <div class="block w5 first">
        <h1><?php echo $model->title; ?></h1>
        <?php echo $parser->transform($model->text); ?>
    </div>


    <?php if($model->editorId == Yii::app()->user->id): ?>

    <?php endif; ?>

    <?php
    $cnt = 0;
    
    foreach($model->itemuploads as $i=>$upload):
        ?>
        <?php
        echo $this->renderPartial('/webPage/upload/'.$upload->type, array(
        'upload'=>$upload,
        'parentItem'=>$model,
        'parser'=>new $parser,
        'editorial'=>true,
        'editorial_size'=>$editorial_size,
        'lbound'=>$lbound,
        'hbound'=>$hbound,
        'big'=>$big,
        'filtered_category'=>$filtered_category,
        'filtered_user'=>$filtered_user,
        'filtered_year'=>$filtered_year,
        'hide_editorial'=> $hide_editorial,
        'frontpage'=> $frontpage

        ));
        ?>

        <?php
        $cnt++;
    endforeach;
    ?>

</div>

<?php

/*
 * QUIRK:
 *
 * $upload->uploadFilterCount is only non-zero if the last upload is a upload filter
 * the positive bi-effect of that is that there will be no 'more'-button unless the upload filter
 * is the last thing on a page
 *
 */

?>
<?php if(isset($upload) && $upload->uploadFilterCount > 0 && ! isset($_GET['p'])): ?>
    <?php
    $hasItem = true;
    $_t = $upload->uploadFilterCount;
    $_i = Util::Get('i', 0);
    $_nxt = $_t + $_i;
    if($_i != 0) {
        $_prev =  $_i  - $_t;
    }

    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bbq.js', CClientScript::POS_BEGIN);
    ?>

<script type="text/javascript">
    var MAX_CACHE = 15;
    var uUrl = '<?php echo Yii::app()->request->url; ?>';
    var _cache = [];
    var count = <?php echo $upload->uploadFilterCount; ?>;

    function initCache(id)
    {
        _t = _cache[id - 1];
        _cache[id] = [];

        for(var i in _t)
        {
            _cache[id][i] = _t[i];
        }
    }

    function setToCache(id, index)
    {


        var index = index;
        _i = $("[id^='itemFilterContent" + id + "']");

        if(_cache[index] == null)
        {
            _cache[index] = [];
        }

        _i.each(function(i, v){
            if(_cache[index][i] == null)
            {
                _cache[index][i] = '';
            }

            _cache[index][i] = _cache[index][i] + $(v).html();

        });
    }

    function setContentFrmCache(id, index)
    {
        var index = index;
        _i = $("[id^='itemFilterContent" + id + "']");

        _i.each(function(i, v){
            $(v).html(_cache[index][i]);
        });




    }

    function setStatus(str)
    {
        $('#fetchStatus').html(str);
    }

    function clearStatus()
    {
        $('#fetchStatus').html("");
    }

    function doSearch()
    {
        setStatus('Loading....');

        var q = $.deparam.fragment();
        var i =  parseInt( q.i );

        if(isNaN(i))
            i = 0;

        setNextLink(i + 1);

        if(_cache[i])
        {
            setContentFrmCache('', i);
            clearStatus();
        }else
        {
            _search(i);
        }

        if(i != null && i != 0)
        {
            $('#prevLink').show();
        }else
        {
            $('#prevLink').hide();
        }
    }

    function _search(index)
    {
        var index = index;
        var url = uUrl;

        if(url.indexOf('?') >= 0)
            url = url + '&p&i=';
        else
            url = url + '/?p&i=';

        $.get( url + index, function (data, status){
            if(status == 'success')
            {
                $('#tempParser').html(data);

                /*
                initCache(index);
                setToCache(index, index);
                setContentFrmCache('', index);
                */

                //console.log('tempparser ' + $('#tempParser .att').length)
                attachments();

                clearStatus();
            }else
            {
                setStatus("Error while fetching result");
            }
        });
    }

    function setNextLink(i)
    {
        $('#moreLink')[0].href = '#i=' + i;
    }

    $(function(){
        $(window).bind( 'hashchange', function(e) {
            doSearch();
        });

        setToCache('', 0);
        setNextLink(1);
    });

</script>

<div id="tempParser" style="display:none"></div>

<div id="morebutton" class="more cb">
    <hr />
    <p><a href="#i=0" id="moreLink">More</a></p>
    <p id="fetchStatus"></div>
</div>

    <!-- <a href="#i=0" id="prevLink" style="display:none">Less</a> -->


<?php endif; ?>

