<div id="everythinglisted">
    <?php $this->pageTitle=Yii::app()->name; ?>
    <h3>
            Welcome, <?php echo Yii::app()->user->name; ?>!
    </h3>
    <div>
        <?php foreach($ns as $k=>$v): ?>
            <?php if($v->id == 3): ?>
                <?php echo CHtml::link("Create a " . $v->name,array('item/create','nid'=> $v->id), array('class'=>'iframe')); ?> |
            <?php else: ?>
                <?php echo CHtml::link("Create a " . $v->name,array('item/adminCreate','nid'=> $v->id), array('class'=>'iframe')); ?> |
            <?php endif; ?>

        <?php endforeach;?>

        
    </div>
    <script>
       
        function setCookie(c_name,value,expiredays)
            {
            var exdate=new Date();
            exdate.setDate(exdate.getDate()+expiredays);
            document.cookie=c_name+ "=" +escape(value)+
            ((expiredays==null) ? "" : ";expires="+exdate.toUTCString());
        }

        function getCookie(c_name)
        {
        if (document.cookie.length>0)
          {
          c_start=document.cookie.indexOf(c_name + "=");
          if (c_start!=-1)
            {
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
            }
          }
        return "";
        }

        $(document).ready(function(){

           // var tab = '<?php if (isset($_GET["tab"])) { echo $_GET["tab"]; } ?>';
           // console.log(tab);
           var select = getCookie('tabs');
            
            if (select != '') {
                $("div.tab").addClass('hide');
                $(".tabm").removeClass('sel');

                $("#"+select).addClass('sel');
                $("."+select).removeClass('hide');
            }

            $(".tabm").click(function(){
                $("div.tab").addClass('hide');
                $(".tabm").removeClass('sel');
                $(this).addClass('sel');
                $("."+$(this).attr('id')).removeClass('hide');

                //console.log('setcookie ' +$(this).attr('id'))
                setCookie('tabs',$(this).attr('id'),5);

            })

            $(".reorder").click(function(){
                id= $(this).attr('id');
                //rv/site/index/noredirect/?ob=title
                //console.log(window.location.pathname)
                //window.location.href = "http://" + window.location.host + window.location.pathname + '?ob=' + id;
                window.location.href = "/site/index/noredirect/" + '?ob=' + id;
            })

            /*$(".pagnation a").click(function(e){
                e.preventDefault();
                id = $(this).closest('.pagnation').attr('id');
                id = id.substring(1);

                window.location.replace($(this).attr('href')+'/?tab='+id);
            })*/
        });

    </script>
        <div>
            <ul class="menu clearfix">
                <li><h1><a id="page" href="#" class="tabm sel">Pages</a></h1></li>
                <li><h1><a id="news" href="#" class="tabm">News</a></h1></li>
                <li><h1><a id="project" href="#" class="tabm">Projects</a></h1></li>
                <li><h1><a id="grad" href="#" class="tabm">Graduation</a></h1></li>
                <!--<li><h1><a id="custom" href="#" class="tabm">Custom</a></h1></li>-->
            </ul>
        </div>

        <div class="page tab">
            <?php  $this->renderPartial('_itemList', array('models'=>$pages)); ?>
            <div id="ipage" class="pagnation"><?php $this->widget('CLinkPager',array('pages'=>$pagesPage)); ?></div>
        </div>
        <div class="news tab hide">
            <?php  $this->renderPartial('_itemList', array('models'=>$news)); ?>
            <div id="inews" class="pagnation"><?php $this->widget('CLinkPager',array('pages'=>$newsPage)); ?></div>
        </div>
        <div class="project tab hide">
            <?php  $this->renderPartial('_itemList', array('models'=>$project)); ?>
            <div id="iproject" class="pagnation"><?php $this->widget('CLinkPager',array('pages'=>$projectPage)); ?></div>
        </div>
        <div class="grad tab hide">
            <?php  $this->renderPartial('_itemList', array('models'=>$graduation)); ?>
            <div id="igrad" class="pagnation"><?php $this->widget('CLinkPager',array('pages'=>$gradPage)); ?></div>
        </div>
        <div class="custom tab hide">
            <?php  $this->renderPartial('_itemList', array('models'=>$custom)); ?>
            <div class="pagnation"><?php $this->widget('CLinkPager',array('pages'=>$customPage)); ?></div>
        </div>

    <br class="clear">

    <script>
               $("a[href*='hideItem']").bind('click', function(e) {
                   if(!confirm('Are you sure?')) {
                       e.preventDefault();
                   }
                });
    </script>
</div>