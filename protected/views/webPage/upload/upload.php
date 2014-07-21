<?php

// Make date facebook style
$date_difference = time() - strtotime($upload->modified);
$date_periods_singular = array("second", "min", "hour", "day", "week", "month", "year", "decade");
$date_periods_plural = array("seconds", "mins", "hours", "days", "weeks", "months", "years", "decades");

$date_lengths = array("60", "60", "24", "7", "4.35", "12", "10");
$date_ending = "ago";

for ($j = 0; $date_difference >= $date_lengths[$j]; $j++){
    $date_difference /= $date_lengths[$j];
}

$date_difference = round($date_difference);
$date_text = "";
if ($date_difference != 1) {
    $date_text = "&nbsp;-&nbsp;$date_difference&nbsp;$date_periods_plural[$j]&nbsp;$date_ending";
} else {
    $date_text = "&nbsp;-&nbsp;$date_difference&nbsp;$date_periods_singular[$j]&nbsp;$date_ending";
}
// end make $date_text date


$ie = false;
if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)){
    $ie = true;
}

if (!isset($lbound)) {
    $editorial_size = 600;
    $lbound = 100;
    $hbound = 250;
    $big = 650;
    $editorial = true;
}

if (!isset($filtered_category)) {
    $filtered_category = false;
}

if (!isset($filtered_year)) {
    $filtered_year = false;
}

$filename = Yii::app()->request->baseUrl . $upload->filePath . $upload->fileName;

$finalworks_url = "/nl/eindexamens";


$short = '';
$ellipsis_length = 30;

// Not text
$size = 0;

// Create a list of thumbnail filenames, indexed by the sizes (ie. $sizes[700] = "/dir1/dir2/700-filename").
$sizes = Yii::app()->params['imageSize'];
$a_sizes = array();
foreach ($sizes as $n) {
    $a_sizes[$n] = $n;
}
$sizes = $a_sizes;
if ($upload->uploadtype != 3) {

    $rpos = stripos(strrev($filename), '/');
    $fn1 = substr($filename, strlen($filename) - $rpos, $rpos);
    $fn2 = substr($filename, 0, strlen($filename) - $rpos);

    //filenames for each size
    foreach ($sizes as $s => $tfn) {
        $sizes[$s] = $fn2 . $s . "-" . $fn1;
    }

    // If .GIF or video then always use original (resize client side)
    if ($upload->uploadtype == 2 || strtolower(substr($filename, strlen($filename) - 3, 3)) == "gif") {
        foreach ($sizes as $s => $tfn) {
            $sizes[$s] = $filename;
        }
    }

    $portrait = false;
    $w = $upload->imageWidth;
    $h = $upload->imageHeight;
    $size = $w;
    if ($h > $w) {
        $portrait = true;
        $size = $h;
    }

    if ($size < end(array_keys($sizes))) {
        $sizes[$size] = $filename;
    }

    foreach ($sizes as $s => $tfn) {
        if ($s > $size) {
            unset($sizes[$s]);
        }
        if ($s == $size) {
            $sizes[$s] = $filename;
        }
    }
}

$lbound_text = $lbound;
if ($lbound_text < 240) $lbound_text = 240;

// Determine the small and big thumbnail sizes based on type and (optionally)
// some other parameters.
$small = 0;
if (isset($upload->customData['noOfUploads'])) {
    $diff = $hbound = $lbound;
    $u = $upload->customData['noOfUploads'];
    if ($u > 20){
        $u = 20;
    }
    $small = $lbound + ($diff * ($u / 20));
} else {
    $small = rand($lbound, $hbound);
}

$type = "upload";
if ($upload->itemNamespaceId == ns::NEWS) {
    $type = "news";
    if ($upload->item->priority == 1) {
        $lbound = 300;
        $hbound = 300;
        $small = 300;
    }
}

if ($upload->uploadtype == 1) {
    // Image
    if ($filtered_user) {
        $small = 650;
    } else {
        if ($filtered_year && !$filtered_category) {
            $small = rand(150, 250);
        }else if ($filtered_year && $filtered_category) {
            $small = 300;
        }
    }
    $small = Util::closest($small, array_keys($sizes));
    $big = Util::closest($big, array_keys($sizes));
    $editorial_size = Util::closest($editorial_size, array_keys($sizes));
} elseif ($upload->uploadtype == 2) {
    // Video
} elseif ($upload->uploadtype == 3) {
    // Text
    $small = rand($lbound_text, $hbound);
}

$project_url = Yii::app()->request->baseUrl . "/project/" . $upload->item->friendlyUrl;

$more = "";
$project_title = "";
if (isset($upload->customData['noOfUploads'])) {
    $uploads_count = $upload->customData['noOfUploads'] - 1;
    If ($uploads_count > 0) {
        $more_images = Util::GetLocalization() == 1 ? " images" : " beelden";
        $more = " +" . $uploads_count . $more_images . "";
    }
}

$project_title = "<a class =\"more\" href=\"" . $project_url . "\">" . $upload->item->title . "" . $more . "</a>";

?>
<?php if ($upload->uploadtype == 1): ?>
    <?php // IMAGE  ?>
    <?php if (!$editorial) : ?>
        <?php

        list($tnw, $tnh) = Util::calculateSize($small, $upload->imageWidth, $upload->imageHeight);
        list($bigw, $bigh) = Util::calculateSize($big, $upload->imageWidth, $upload->imageHeight);

        $arr = array('type' => 'image', 'bigfn' => $sizes[$big], 'bigw' => $bigw, 'bigh' => $bigh, 'tnfn' => $sizes[$small], 'tnw' => $tnw, 'tnh' => $tnh, 'modified' => strtotime($upload->modified), 'priority' => $upload->item->priority);
        $graduationflyer = false;
        if ($upload->itemNamespaceId == ns::GRADUATION && $upload->customData['owner'] == 'Gerrit') {
            $graduationflyer = true;
        }

        ?>

        <div id="att<?php echo $upload->id;?>" class="att image uninitialized<?php echo $graduationflyer ? " graduationflyer" : ""; ?> <?php echo $type?> <?php if($filtered_category) {echo ' filtered_category';}?> <?php if($filtered_user) {echo ' filtered_user';}?>">
            <div class="icon">
                <p style="text-indent: 0px;">
                    <?php if ($graduationflyer): ?>
                        <img width="<?php echo $bigw ?>" height="<?php echo $bigh ?>" alt="" src="<?php echo $sizes[$big] ?>"/>
                    <?php else: ?>
                        <img width="<?php echo $tnw ?>" height="<?php echo $tnh ?>" alt="" src="<?php echo $sizes[$small] ?>"/>
                    <?php endif; ?>
                </p>
            </div>
            <div class="caption-area">

                <?php if (!$graduationflyer) : ?>
                    <?php if($upload->itemNamespaceId != ns::NEWS && $upload->itemNamespaceId != ns::GRADUATION) : ?>
                        <div class="by collapsed">Added by <a href="<?php echo Yii::app()->request->baseUrl; ?>/student/<?php echo $upload->owner->friendlyName; ?>"><?php echo $upload->owner->name; ?></a><?php echo $upload->customData['category'] != '' ? ' in '.$upload->customData['category'] : '' ?></div>
                    <?php endif; ?>
                    <?php if ($upload->itemNamespaceId == ns::GRADUATION) : ?>
                        <div class="by collapsed">Added by <?php echo $upload->customData['editor'] != "" ? $upload->customData['editor'] : "Gerrit"; ?></div>
                    <?php endif; ?>
                    <?php if($upload->itemNamespaceId == ns::NEWS) : ?>
                        <div class="title">
                            <p>
                                <span class="newstitle"><?php echo $upload->item->title ?></span>
                                <span class="readmore"><br><?php echo Util::GetLocalization()==1 ? "Read more" : "Lees meer" ?></span>
                            </p>
                        </div>
                    <?php elseif ($upload->itemNamespaceId == ns::GRADUATION) : ?>
                        <div class="title">
                            <?php if (!isset($upload->customData)) { ?>
                                Error $upload->customData is not set for graduation
                            <?php } ?>

                            <?php
                            $c = $upload->customData['category'];
                            $c_url = strtolower(str_replace(' ', '-', $upload->customData['category']));
                            $year = $upload->customData['year'];
                            $name = $upload->customData['owner'];
                            $grad_url = strtolower($upload->customData['ownerFriendlyName']);
                            ?>

                                                <a href="<?php echo Yii::app()->request->baseUrl; ?><?php echo $finalworks_url; ?>/<?php echo $year; ?>/<?php echo $c_url; ?>/<?php echo $grad_url; ?>"><?php echo $name; ?></a><span class="gradcategoryyear"> – <?php echo $upload->customData['category'];?> <?php echo $upload->customData['year'];?></span>
                        </div>
                    <?php else : /* Anything except NEWS or GRADUATION. */ ?>
                        <?php if (!isset($item_title_hide) || $item_title_hide == false) : ?>
                            <div class="title">
                                <?php echo $project_title; ?><span class="timeago"><?php echo $date_text; ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php

                    $txt = $upload->text;
                    if (mb_strlen($txt) > 0) {
                        $short = mb_substr($txt, 0, $ellipsis_length);
                        if (mb_strlen($txt) > $ellipsis_length) {
                            $short .= "…";
                        }
                    }

                    ?>
                    <div class="shortversion">
                        <div class="description"><?php echo strip_tags($short) ?></div>
                    </div>
                <?php endif; ?>
                <div class="<?php if (!$graduationflyer): ?>collapsed <?php endif; ?>description">
                    <?php if($upload->itemNamespaceId == ns::NEWS) : ?>
                        <?php echo $parser->transform($upload->item->text); ?>
                    <?php else : ?>
                        <?php echo $parser->transform($upload->text); ?>
                    <?php endif; ?>
                </div>
            </div>

            <div style="color: rgb(255, 255, 255); display: none;" class="data">
                <script type="text/javascript">
                    data_att<?php echo $upload->id;?> = (<?php echo json_encode($arr)?>);
                </script>
            </div>
        </div>

    <?php elseif (!$hide_editorial) : // editorial ?>
        <?php

        list($w, $h) = Util::calculateSize($editorial_size, $upload->imageWidth, $upload->imageHeight);
        $ss = Util::closest($editorial_size, array_keys($sizes));

        ?>
        <div class="ed-img">
            <img src="<?php echo $sizes[$ss] ?>" width="<?php echo $w ?>" height="<?php echo $h ?>" alt=""/>
            <?php if (trim($upload->text) != '') { ?>
                <div class="ed-caption">
                    <?php echo $parser->transform($upload->text); ?>
                </div>
            <?php } ?>
        </div>
    <?php endif; ?>

<?php elseif ($upload->uploadtype == 2): ?>
    <?php // VIDEO  ?>
    <?php

    // Determine type and id of the video and the dimensions of the thumbnail.
    $video           = new MetaVideo($upload->videolink);
    list($tnw, $tnh) = Util::calculateSize($small, $video->width, $video->height);
    list($w, $h)     = Util::calculateSize($big, $video->width, $video->height);

    ?>
    <div id="att<?php echo $upload->id;?>" class="att video uninitialized <?php echo $type; ?>  <?php if($filtered_category) {echo ' filtered_category';}?> <?php if($filtered_user) {echo ' filtered_user';}?>">
        <div class="icon">
            <div class="videotn">
                <div class="playbutton"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/play.png" alt="" /></div>
                <img src="<?php echo $video->tn; ?>" width="<?php echo $tnw; ?>" height="<?php echo $tnh; ?>" alt="" />
            </div>
            <div class="video" style="display:none">
                <!-- id <?php echo $upload->id; ?> -->

                <?php if ($video->type == "youtube") : ?>
                    <?php if ($ie) { ?>
                        <object width="<?php echo $w ?>" height="<?php echo $h ?>">
                            <param name="movie" value="http://www.youtube-nocookie.com/v/<?php echo $video->id; ?>'&hl=en&fs=1&rel=0" />
                            <param name="allowFullScreen" value="true"/>
                            <param name="allowscriptaccess" value="always"/>
                            <embed src="http://www.youtube-nocookie.com/v/<?php echo $video->id; ?>" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="<?php echo $w ?>" height="<?php echo $h ?>" />
                        </object>
                    <?php } else { ?>
                        <embed src="http://www.youtube-nocookie.com/v/<?php echo $video->id; ?>&hl=en&fs=1&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="<?php echo $w ?>" height="<?php echo $h ?>" />
                    <?php } ?>
                <?php elseif ($video->type == "vimeo") : ?>
                    <?php if ($ie) : ?>
                        <object width="<?php echo $w ?>" height="<?php echo $h ?>">
                            <param name="allowfullscreen" value="true"/>
                            <param name="allowscriptaccess" value="always"/>
                            <param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $video->id; ?>&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" />
                            <embed src="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $video->id; ?>&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="<?php echo $w ?>" height="<?php echo $h ?>" />
                        </object>
                    <?php else : ?>
                        <embed src="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $video->id; ?>&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="<?php echo $w ?>" height="<?php echo $h ?>" />
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="caption-area">
            <?php if($upload->itemNamespaceId != ns::NEWS && $upload->itemNamespaceId != ns::GRADUATION): ?>
                <div class="by collapsed">Added by <a href="<?php echo Yii::app()->request->baseUrl; ?>/student/<?php echo $upload->owner->friendlyName; ?>"><?php echo $upload->owner->name; ?></a> <?php echo $upload->customData['category'] != '' ? ' in '.$upload->customData['category'] : '' ?></div>
            <?php endif; ?>
            <?php if($upload->itemNamespaceId == ns::GRADUATION): ?>
                <div class="by collapsed">Added by <?php echo $upload->customData['editor'] != "" ? $upload->customData['editor'] : "Gerrit"; ?></div>
            <?php endif; ?>

            <?php if($upload->itemNamespaceId == ns::NEWS) : ?>
                <div class="title">
                    <p>
                        <span class="newstitle"><?php echo $upload->item->title ?></span>
                        <span class="readmore"><br><?php echo Util::GetLocalization() == 1 ? "Read more" : "Lees meer" ?></span>
                    </p>
                </div>
            <?php elseif($upload->itemNamespaceId == ns::GRADUATION) : ?>
                <div class="title">
                    <?php if (!isset($upload->customData)) { ?>
                        Error $upload->customData is not set for graduation
                    <?php } ?>

                    <?php
                    $c = $upload->customData['category'];
                    $c_url = strtolower(str_replace(' ', '-', $upload->customData['category']));
                    $year = $upload->customData['year'];
                    $name = $upload->customData['owner'];
                    $grad_url = strtolower($upload->customData['ownerFriendlyName']);
                    ?>

                    <a href="<?php echo Yii::app()->request->baseUrl; ?><?php echo $finalworks_url; ?>/<?php echo $year; ?>/<?php echo $c_url; ?>/<?php echo $grad_url; ?>"><?php echo $name; ?></a><span class="gradcategoryyear"> – <?php echo $upload->customData['category'];?> <?php echo $upload->customData['year'];?></span>
                </div>
            <?php else : ?>
                <?php if (!isset($item_title_hide) || $item_title_hide == false) { ?>
                    <div class="title">
                        <?php echo $project_title; ?><span class="timeago"><?php echo $date_text; ?></span>
                    </div>

                <?php } ?>
            <?php endif; ?>

            <?php

            $txt = $upload->text;
            if (mb_strlen($txt) > 0) {
                $short = mb_substr($txt, 0, $ellipsis_length);
                if (strlen($txt) > $ellipsis_length) {
                    $short .= "…";
                }
            }

            ?>
            <div class="shortversion">
                <div class="description"><?php echo strip_tags($short) ?></div>
            </div>

            <div class="collapsed">
                <div class="description"><?php echo $parser->transform($upload->text); ?></div>
            </div>

        </div>

        <?php $arr = array('type' => 'video', 'bigfn' => null, 'bigw' => $w, 'bigh' => $h, 'tnfn' => null, 'tnw' => $tnw, 'tnh' => $tnh, 'modified' => strtotime($upload->modified), 'priority' => $upload->item->priority); ?>
        <div style="color: rgb(255, 255, 255); display: none;" class="data">
            <script type="text/javascript">
                data_att<?php echo $upload->id;?> = (<?php echo json_encode($arr)?>);
            </script>
        </div>

    </div>

<?php elseif($upload->uploadtype == 3): ?>
    <?php // TEXT  ?>
    <div id="att<?php echo $upload->id; ?>" class="att text uninitialized <?php echo $type ?>">
        <div class="icon">
            <div class="texttitle" style="width:<?php echo $small; ?>px;">
                <p><?php echo $upload->title; ?></p>
            </div>
        </div>

        <div class="caption-area">

            <?php if($upload->itemNamespaceId != ns::NEWS && $upload->itemNamespaceId != ns::GRADUATION): ?>
                <div class="by collapsed">Added by <a href="<?php echo Yii::app()->request->baseUrl; ?>/student/<?php echo $upload->owner->friendlyName; ?>"><?php echo $upload->owner->name; ?></a> <?php echo $upload->customData['category'] != '' ? ' in '.$upload->customData['category'] : '' ?></div>
            <?php endif; ?>
            <?php if($upload->itemNamespaceId == ns::GRADUATION): ?>
                <div class="by collapsed">Added by <?php echo $upload->customData['editor'] != "" ? $upload->customData['editor'] : "Gerrit"; ?></div>
            <?php endif; ?>

            <?php if($upload->itemNamespaceId == ns::NEWS) : ?>
                <div class="title">
                    <p>
                        <span class="newstitle"><?php echo $upload->item->title ?></span>
                        <span class="readmore"><br><?php echo Util::GetLocalization() == 1 ? "Read more" : "Lees meer" ?></span>
                    </p>
                </div>
            <?php elseif($upload->itemNamespaceId == ns::GRADUATION) : ?>
                <div class="title">
                    <?php if (!isset($upload->customData)) { ?>
                        Error $upload->customData is not set for graduation
                    <?php } ?>

                    <?php
                    $c = $upload->customData['category'];
                    $c_url = strtolower(str_replace(' ', '-', $upload->customData['category']));
                    $year = $upload->customData['year'];
                    $name = $upload->customData['owner'];
                    $grad_url = strtolower($upload->customData['ownerFriendlyName']);
                    ?>

                    <a href="<?php echo Yii::app()->request->baseUrl; ?><?php echo $finalworks_url; ?>/<?php echo $year; ?>/<?php echo $c_url; ?>/<?php echo $grad_url; ?>"><?php echo $name; ?></a><span class="gradcategoryyear"> – <?php echo $upload->customData['category'];?> <?php echo $upload->customData['year'];?></span>
                </div>
            <?php else : ?>
                <?php if (!isset($item_title_hide) || $item_title_hide == false) { ?>
                    <div class="title">
                        <?php echo $project_title; ?><span class="timeago"><?php echo $date_text; ?></span>
                    </div>
                <?php } ?>
            <?php endif; ?>

            <?php

            $txt = $upload->text;
            if (mb_strlen($txt) > 0) {
                $short = mb_substr($txt, 0, $ellipsis_length);
                if (strlen($txt) > $ellipsis_length) {
                    $short .= "…";
                }
            }

            ?>
            <div class="shortversion">
                <div class="description"><?php echo strip_tags($short) ?></div>
            </div>

            <div class="collapsed">
                <div class="description"><?php echo $parser->transform($upload->text); ?></div>
            </div>

        </div>
        <?php $arr = array('type' => 'text', 'bigfn' => null, 'bigw' => $big, 'bigh' => null, 'tnfn' => null, 'tnw' => $small, 'tnh' => null, 'modified' => strtotime($upload->modified), 'priority' => $upload->item->priority); ?>
        <div style="color: rgb(255, 255, 255); display: none;" class="data">
            <script type="text/javascript">
                data_att<?php echo $upload->id;?> = (<?php echo json_encode($arr)?>);
            </script>
        </div>

    </div>

<?php endif; ?>