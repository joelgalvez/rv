<?php
$cs=Yii::app()->clientScript;

//Yii::app()->getClientScript()->registerCoreScript('jquery');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/bbq.js', CClientScript::POS_BEGIN);
?>
<script type="text/javascript">
    var MAX_CACHE = 15;
    <?php if($ln == 'en'): ?>
    var uUrl = '<?php echo Yii::app()->createUrl('search/user'); ?>';
    var pUrl = '<?php echo Yii::app()->createUrl('search/page'); ?>';
    var nUrl = '<?php echo Yii::app()->createUrl('search/news'); ?>';
    var gUrl = '<?php echo Yii::app()->createUrl('search/project'); ?>';
    <?php else: ?>
    var uUrl = '<?php echo Yii::app()->createUrl('search/user'); ?>';
    var pUrl = '<?php echo Yii::app()->createUrl('search/pageNl'); ?>';
    var nUrl = '<?php echo Yii::app()->createUrl('search/newsNl'); ?>';
    var gUrl = '<?php echo Yii::app()->createUrl('search/projectNl'); ?>';
    <?php endif; ?>
    var _cache = [];
    var _cacheKeys = [];
    var _lastId = 0;



    function doSearch()
    {
        var q = $.deparam.fragment();

        if(q.q)
        {
            $('#result').show();
            setStatus('Searching....');
            $('#q').val(q.q);

            if(_cache[q.q])
            {
                $('#uResult').html(_cache[q.q].u);
                $('#pResult').html(_cache[q.q].p);
                $('#nResult').html(_cache[q.q].n);
                $('#gResult').html(_cache[q.q].g);
            }else
            {
                setCache(q.q);

                _search(uUrl, '#uResult', q.q, 'u');
                _search(pUrl, '#pResult', q.q, 'p');
                _search(nUrl, '#nResult', q.q, 'n');
                _search(gUrl, '#gResult', q.q, 'g');
            }
        }
    }

    function _search(url, id, q, i)
    {
        var _id = id;
        var _q = q;
        var _i = i;

        $.get(url+ '/?q=' + q, function (data, status){
            if(status == 'success')
            {
                _cache[_q][_i]= data;
                $(_id).html(data);
            }else
            {
                $(_id).html("Error while fetching result");
            }
        });
    }

    function setCache(key)
    {
        if(_lastId >= MAX_CACHE)
        {
            _lastId = 0;
        }
        _cache[_cacheKeys[_lastId]] = null;
        _cacheKeys[_lastId] = key;
        _cache[key] = {u:'',p:'',n:'',g:''};
        _lastId++;
    }

    function triggerSearch()
    {
        $('#result').show();
        setStatus('Searching....');

        q =  '#q=' + $('#q').val();
        window.location.href = q;

        doSearch();
        return false;
    }

    function setStatus(str)
    {
        $('#uResult').html(str);
        $('#pResult').html(str);
        $('#nResult').html(str);
        $('#gResult').html(str);
    }

    $(function(){

        $("input").keypress(function (e) {
            if (e.which == 13) {
                triggerSearch();
            }

        });
        $('#sb').click(function(){
            triggerSearch();
        });

        $(window).bind( 'hashchange', function(e) {
            doSearch();
        });


        $('#result').hide();

        doSearch();

        $(window).trigger( 'hashchange' );

        for(i=0; i< MAX_CACHE; i++)
        {
            _cacheKeys[i] = '';
        }
    }
);
</script>


<div id="result">
    <div class="title"><h1>People</h1></div>
    <div id="uResult"></div>

    <div class="title"><h1>Pages</h1></div>
    <div id="pResult"></div>

   <div class="title"><h1>News</h1></div>
    <div id="nResult"></div>

    <div class="title"><h1>Projects</h1></div>
    <div id="gResult"></div>
</div>