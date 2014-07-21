<?php

class VideometaController extends CController {
    /**
     * Return a set of properties that describe the video at the given url. The
     * returned data is in JSON format.
     *
     * @param $url
     *
     * @return string
     * @see MetaVideo
     */
    public function actionGetMeta() {
        $videoUrl = (isset($_REQUEST['url'])) ? $_REQUEST['url'] : null;
        if ($videoUrl) {
            $meta = new MetaVideo($videoUrl);
            echo $meta->render();
        }
    }
}

?>