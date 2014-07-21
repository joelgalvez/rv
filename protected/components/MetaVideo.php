<?php

/**
 * Parses the given url - which is supposed to point to an online video, like
 * on youtube or vimeo - and provides meta information like the actual id of the
 * video, the type (youtube or vimeo), a thumbnail (including width x height).
 *
 * @author kjartan
 * @author Jan Willem
 */
class MetaVideo {
    var $tn = -1;
    var $width = -1;
    var $height = -1;
    var $ratio = -1;
    var $id = null;
    var $type = null;
    var $url = '';
    var $path = '';
    var $here = 'none';
    var $error = null;

    function MetaVideo($url) {
        // 1. Determine the type (youtube/vimeo) and id of the video.
        // 2. Determine the thumbnail.

        $this->url = $url;

        // 1. Determine type and id.
        $this->determineTypeAndId();
        if (!$this->id){
            $this->err("Couldn't determine the video id. Please make sure it's a valid url.");
            return;
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
        if ($this->type == "youtube") {
            $meta = $this->getmetadata("http://gdata.youtube.com/feeds/api/videos/" . $this->id . "?alt=json");

            $meta = json_decode(trim($meta));
            if ($meta == "") {
                $this->err("Couldn't json_decode metadata");
                return;
            }

            $this->tn = (array)$meta;
            $this->tn = (array)$this->tn['entry'];
            $this->tn = (array)$this->tn['media$group'];
            $this->tn = (array)$this->tn['media$thumbnail'];
            $this->tn = (array)$this->tn[3];
            $this->tn = $this->tn['url'];

            if (!Util::isValidURL($this->tn)) {
                $this->err("Thumbnail don't have valid URL (" . $this->tn . ")");
                return;
            }

            $this->width  = 480;
            $this->height = 360;
            $this->ratio  = 16 / 9;
            $this->here   = 'you';

        } elseif ($this->type == "vimeo") {
            $meta = $this->getmetadata('http://vimeo.com/api/v2/video/' . $this->id . '.php');
            // vimeo.com/api/v2/video/6518700.php

            if ($meta == "a:0:{}") {
                $this->err("Can't find metadata for video");
                return;
            }
            $meta = unserialize(trim($meta));
            if ($meta == "") {
                $this->err("Couldn't un-serialize metadata");
                return;
            }

            $this->tn = $meta[0]['thumbnail_large'];

            if (!Util::isValidURL($this->tn)) {
                $this->err("Thumbnail don't have valid URL (" . $this->tn . ")");
                return;
            }

            $this->width  = $meta[0]['width'];
            $this->height = $meta[0]['height'];
            $this->ratio  = $this->width / $this->height;
            $this->type   = "vimeo";
            $this->here   = "vim";

        } else {
            $this->err("Unsupported video site. Should be either youtube or vimeo.");
            return;
        }

        $this->saveImage();
    }

    /**
     * Sets this MetaVideo's type and id by evaluating/parsing its url.
     */
    private function determineTypeAndId(){
        if (strstr($this->url, "youtube") || strstr($this->url, "youtu.be")) {
            $this->type = "youtube";
            $this->id   = $this->determineYoutubeId($this->url);
        } else if (strstr($this->url, "vimeo")) {
            $this->type = "vimeo";
            $this->id   = $this->determineVimeoId($this->url);
        } else {
            $this->type = null;
            $this->id   = null;
        }
    }

    /**
     * Matches the url against Youtube url patterns and returns the video's ID
     * from it.
     *
     * Can handle:
     * - https://www.youtube.com/watch?v=VfzeA4gm3Ug (ID in query parameter 'v')
     * - http://www.youtube.com/embed/6MfJEzVEjCw
     * - http://youtu.be/1tmtaQ3FXR8
     *
     * @param string $url
     *
     * @return string
     */
    private function determineYoutubeId($url) {
        // Parse the url. If it's not a url or doesn't contain a query, return null.
        $urlParts = parse_url($url);
        if (!$urlParts){
            return null;
        }else if ($urlParts['path'] == '/watch'){
            // We expect the v=ID parameter in the youtube url.
            // Like https://www.youtube.com/watch?v=VfzeA4gm3Ug
            if (isset($urlParts['query'])){
                parse_str($urlParts['query'], $parameters);
                if (isset($parameters['v'])){
                    return $parameters['v'];
                }
            }
        }else if(strpos($urlParts['path'], '/embed') === 0 || $urlParts['host'] == 'youtu.be'){
            // The ID is the last part of the path (ie. it's not in the query).
            // Like http://www.youtube.com/embed/6MfJEzVEjCw
            // Like http://youtu.be/1tmtaQ3FXR8
            $pathParts = explode('/', $urlParts['path']);
            return $pathParts[count($pathParts)-1];
        }

        return null;
    }

    /**
     * Matches the url against Vimeo url patterns and returns the video's ID
     * from it.
     *
     * Can handle:
     * - http://vimeo.com/98747766 (ID is the full path)
     *
     * @param string $url
     *
     * @return string
     */
    private function determineVimeoId($url){
        $urlParts = parse_url($url);
        if ($urlParts && isset($urlParts['path'])){
            return str_replace('/', '', $urlParts['path']);
        }else{
            return null;
        }
    }

    function getmetadata($url) {
        $contents = @file_get_contents($url);
        if (!$contents) {
            $this->err("Can't get metadata (url: " . $url . ")");
        }
        return $contents;
    }

    /**
     * Store the given message and flag this MetaVideo as invalid. The error
     * will be returned by render() (if called).
     *
     * @param $msg
     */
    function err($msg) {
        $this->error = array('status' => 'error', 'msg' => $msg);
    }

    function saveImage() {
        $_img = new ImageHandler();
        $_img->load($this->tn);
        $_img->save($this->path);
    }

    /**
     * Returns this MetaVideo's properties, formatted as a JSON string. If this
     * MetaVideo is invalid (error is set using err()), the error message is
     * returned.
     *
     * @return string
     */
    function render() {
        if ($this->error){
            $arr = $this->error;
        }else{
            $arr = array('status' => 'ok', 'msg' => '', 'id' => $this->id, 'type' => $this->type, 'tn' => $this->tn, 'width' => $this->width, 'height' => $this->height, 'here' => $this->here);
        }
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
