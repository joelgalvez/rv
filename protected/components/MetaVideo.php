<?php

/**
 * Parses the given url - which is supposed to point to an online video, like
 * on youtube or vimeo - and provides meta information like the actual id of the
 * video, the type (youtube or vimeo), a thumbnail (including width x height).
 *
 * @author kjartan
 */
class MetaVideo {
    var $tn = -1;
    var $width = -1;
    var $height = -1;
    var $ratio = -1;
    var $id = -1;
    var $type = -1;
    var $url = '';
    var $path = '';
    var $here = 'none';


    function MetaVideo($url) {
        // 1. Determine the type (youtube/vimeo) and id of the video.
        // 2. Determine the thumbnail.

        $this->url = $url;

        // 1. Determine type and id.
        if (strstr($this->url, "youtube")) {
            $urlParts = parse_url($this->url);
            parse_str($urlParts['query']);
            $this->id   = $v;
            $this->type = 'youtube';
        } else if (strstr($this->url, "vimeo")) {
            $spos       = strripos($this->url, "/");
            $this->id   = intval(substr($this->url, $spos + 1));
            $this->type = 'vimeo';
        }

        // 2. Determine the thumbnail (and its dimensions) of this video.
        // 2.1 Check if we already have a thumb on disk. If so, load it to
        //    determine the dimensions. And exit this constructor.
        // 2.2 If there is not local thumb yet, get it from the video service
        //    save it to disk and determine the dimensions.

        // 2.1 Check if the thumb exists.
        $this->path = dirname($_SERVER['SCRIPT_FILENAME']) . Yii::app()->params['thumbFolder'] . $this->type . $this->id . '.jpg';
        if (file_exists($this->path)) {
            $_path    = Yii::app()->request->baseUrl . Yii::app()->params['thumbFolder'];
            $this->tn = "{$_path}{$this->type}{$this->id}.jpg";

            //here it would be best to find the image width and height
            $_img = new ImageHandler();
            $_img->load(dirname($_SERVER['SCRIPT_FILENAME']) . Yii::app()->params['thumbFolder'] . "{$this->type}{$this->id}.jpg");
            $this->width  = $_img->getWidth();
            $this->height = $_img->getHeight();
            return;

        }

        // 2.2 Get the thumb from the video service.
        if (strstr($this->url, "youtube")) {
            $meta = $this->getmetadata("http://gdata.youtube.com/feeds/api/videos/" . $this->id . "?alt=json");

            $meta = json_decode(trim($meta));
            if ($meta == "") {
                $this->err("Couldn't json_decode metadata");
            }

            $this->tn = (array)$meta;
            $this->tn = (array)$this->tn['entry'];
            $this->tn = (array)$this->tn['media$group'];
            $this->tn = (array)$this->tn['media$thumbnail'];
            $this->tn = (array)$this->tn[3];
            $this->tn = $this->tn['url'];

            if (!Util::isValidURL($this->tn)) {
                $this->err("Thumbnail don't have valid URL (" . $this->tn . ")");
            }

            $this->width  = 480;
            $this->height = 360;
            $this->ratio  = 16 / 9;
            $this->here   = 'you';

        } elseif (strstr($this->url, "vimeo")) {
            $meta = $this->getmetadata('http://vimeo.com/api/v2/video/' . $this->id . '.php');
            // vimeo.com/api/v2/video/6518700.php

            if ($meta == "a:0:{}") {
                $this->err("Can't find metadata for video");
            }
            $meta = unserialize(trim($meta));
            if ($meta == "") {
                $this->err("Couldn't un-serialize metadata");
            }

            $this->tn = $meta[0]['thumbnail_large'];

            if (!Util::isValidURL($this->tn)) {
                $this->err("Thumbnail don't have valid URL (" . $this->tn . ")");
            }

            $this->width  = $meta[0]['width'];
            $this->height = $meta[0]['height'];
            $this->ratio  = $this->width / $this->height;
            $this->type   = "vimeo";
            $this->here   = "vim";

        } else {
            $this->err("Don't seem like a video link");
        }

        $this->saveImage();
    }

    function youtubeid($url) {

        $url = parse_url($url);
        parse_str($url['query']);

        return $v;
    }


    function getmetadata($url) {
        $contents = @file_get_contents($url);
        if (!$contents) {
            $this->err("Can't get metadata (url: " . $url . ")");
        }

        return $contents;
    }

    function err($msg) {
        $arr = array('status' => 'error', 'msg' => $msg);
        echo json_encode($arr);
        die;
    }

    function saveImage() {
        $_img = new ImageHandler();
        $_img->load($this->tn);
        $_img->save($this->path);
    }

    /**
     * Returns this MetaVideo's properties, formatted as a JSON string.
     *
     * @return string
     */
    function render() {
        $arr = array('status' => 'ok', 'msg' => '', 'id' => $this->id, 'type' => $this->type, 'tn' => $this->tn, 'width' => $this->width, 'height' => $this->height, 'here' => $this->here);
        return json_encode($arr);
    }

    /**
     * Returns a JSON string, containing the url to the thumbnail of the video
     * with the given type and id. Width and height of the thumbnail are not
     * looked up, but set to 0.
     *
     * @param string $type One of the supported online video services (youtube or vimeo).
     * @param string $id The id of the video.
     *
     * @return string
     */
    static function renderUrlOnly($type, $id) {
        $arr = array('status' => 'ok', 'msg' => '', 'id' => $id, 'type' => $type, 'tn' => MetaVideo::getUrl($type, $id), 'width' => 0, 'height' => 0);
        return json_encode($arr);
    }

    /**
     * Returns the url to the thumbnail of the video of given type and id.
     *
     * @param string $type One of the supported online video services (youtube or vimeo).
     * @param string $id The id of the video.
     *
     * @return string
     */
    static function getUrl($type, $id) {
        $url = Yii::app()->params['thumbFolder'];
        return "{$url}{$type}{$id}.jpg";
    }
}
