<!-- <div class="<?php echo $upload->title; ?>">  -->
<?php
    if($upload->type == "breakpoint") {
            if($upload->title=="more") {
                ?>
                        <div class="more cb">
                            <hr />
                            <p><a class="notimpl-more" href="">More</a></p>
                        </div>
                <?php
            } else if ($upload->title=="css:googlemap") {

echo '<iframe width="600" height="380" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.nl/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=rietveld+academie+Fred.+Roeskestraat+96+amsterdam&amp;aq=&amp;sll=52.350546,4.871578&amp;sspn=0.068156,0.136814&amp;ie=UTF8&amp;hq=Gerrit+Rietveld+Academie&amp;hnear=Gerrit+Rietveld+Academie,+Fred.+Roeskestraat+96,+1076+ED+Amsterdam&amp;cid=12581200247324843552&amp;ll=52.349759,4.861708&amp;spn=0.02029,0.055532&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="http://maps.google.nl/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=rietveld+academie+Fred.+Roeskestraat+96+amsterdam&amp;aq=&amp;sll=52.350546,4.871578&amp;sspn=0.068156,0.136814&amp;ie=UTF8&amp;hq=Gerrit+Rietveld+Academie&amp;hnear=Gerrit+Rietveld+Academie,+Fred.+Roeskestraat+96,+1076+ED+Amsterdam&amp;cid=12581200247324843552&amp;ll=52.349759,4.861708&amp;spn=0.02029,0.055532&amp;iwloc=A" style="color:#0000FF;text-align:left">View Larger Map</a></small>';

            } else if ($upload->title=="p:uploadbutton") {

                if(!Yii::app()->user->isGuest && Yii::app()->user->groupId==2) {
                    ?>
                        <div class="openadmin uploadbutton">
                            <div class="url"><?php echo Yii::app()->request->baseUrl ?>/item/adminCreate/nid/3</div>
                            <div class="width">narrow</div>
                            <a href="">Upload</a>
                        </div>
                    <?php
                } else {
                    ?>
                        <div class="openadmin uploadbutton">
                            <div class="url"><?php echo Yii::app()->request->baseUrl ?>/item/create/nid/3</div>
                            <div class="width">narrow</div>
                            <a href="">Upload</a>
                        </div>
                    <?php
                }
            }
    }

?>