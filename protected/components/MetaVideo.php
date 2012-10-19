<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MetaVideo
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


    function MetaVideo($url, $isInQuery = false) {

        //$url = $_GET['url'];

        if(!$isInQuery)
        {
            $this->url = $url;
        }

        $_url = $url;
        if(strstr($_url, "youtube")) {
            $_url = parse_url($_url);
            parse_str($_url['query']);

            $this->id = $v;
            $this->type = 'youtube';

        }else if(strstr($_url, "vimeo")) {
                $spos = strripos($_url, "/");
                $this->id = intval(substr($_url, $spos+1));
                $this->type = 'vimeo';
            }

        $this->path = dirname($_SERVER['SCRIPT_FILENAME']).Yii::app()->params['thumbFolder'] . $this->type.$this->id . '.jpg';

        if(file_exists($this->path)) {
            $_path = Yii::app()->request->baseUrl.Yii::app()->params['thumbFolder'];
            $this->tn = "{$_path}{$this->type}{$this->id}.jpg";
            
            //here it would be best to find the image width and height
            $_img = new ImageHandler();
            $_img->load(dirname($_SERVER['SCRIPT_FILENAME']).Yii::app()->params['thumbFolder']."{$this->type}{$this->id}.jpg");
            $this->width = $_img->getWidth();
            $this->height = $_img->getHeight();
            return;

        }

        if(strstr($url, "youtube")) {
            //$this->id = $this->youtubeid($url, $isInQuery);
            $meta = $this->getmetadata("http://gdata.youtube.com/feeds/api/videos/" . $this->id . "?alt=json");

            $meta = json_decode(trim($meta));
            if($meta == "") {
                $this->err("Couldn't json_decode metadata");
            }

            $this->tn = (array)$meta;
            $this->tn = (array)$this->tn['entry'];
            $this->tn = (array)$this->tn['media$group'];
            $this->tn = (array)$this->tn['media$thumbnail'];
            $this->tn = (array)$this->tn[3];
            $this->tn = $this->tn['url'];

            if(!Util::isValidURL($this->tn)) {
                $this->err("Thumbnail don't have valid URL (" . $this->tn . ")");
            }

            //$this->type = "youtube";
            $this->width = 480;
            $this->height = 360;
            $this->ratio = 16 / 9;
            $this->here = 'you';

        } elseif(strstr($url, "vimeo")) {
            //$spos = strripos($url, "/");
            //$this->id = intval(substr($url, $spos+1));
            //$meta = $this->getmetadata('http://vimeo.com/api/clip/' . $this->id . '/php');
			$meta = $this->getmetadata('http://vimeo.com/api/v2/video/' . $this->id . '.php'); 
			//vimeo.com/api/v2/video/6518700.php
			
            //a:0:{}
            if($meta == "a:0:{}") {
                $this->err("Can't find metadata for video");
            }
            $meta = unserialize(trim($meta));
            if($meta == "") {
                $this->err("Couldn't un-serialize metadata");
            }


            $this->tn = $meta[0]['thumbnail_large'];


            if(!Util::isValidURL($this->tn)) {
                $this->err("Thumbnail don't have valid URL (" . $this->tn . ")");
            }

            $this->width = $meta[0]['width'];
            $this->height = $meta[0]['height'];
            $this->ratio = $this->width / $this->height;
            $this->type = "vimeo";
            $this->here = "vim";

        } else {
            $this->err("Don't seem like a video link");
        }

        $this->saveImage();
    }

    function youtubeid($url, $isInQuery) {


		/*
        if (!$isInQuery && preg_match('%youtube\\.com/(.+)%', $url, $match)) {
                $match = $match[1];
                $replace = array("watch?v=", "v/", "vi/", " ");
                $match = str_replace($replace, "", $match);

                return $match;
        }
		else*/


            $url = parse_url($url);
            parse_str($url['query']);

            return $v;

    }


    function getmetadata($url) {
        $contents = @file_get_contents($url);
        if(!$contents) {
            $this->err("Can't get metadata (url: " . $url . ")");
        }

        return $contents;
    }

    function err($msg) {
        $arr = array('status' => 'error', 'msg' => $msg);
        echo json_encode( $arr );
        die;
    }

    function saveImage()
    {
        $_img = new ImageHandler();
        $_img->load( $this->tn );
        $_img->save( $this->path );
    }

    function render() {
        $arr = array('status' => 'ok', 'msg' => '', 'id' => $this->id, 'type' => $this->type, 'tn' => $this->tn, 'width' => $this->width, 'height' => $this->height, 'here' => $this->here);
        return json_encode( $arr );
    }

    static function renderUrlOnly($type, $id) {
        $arr = array('status' => 'ok', 'msg' => '', 'id' => $id, 'type' => $type, 'tn' => MetaVideo::getUrl($type,$id), 'width' => 0, 'height' => 0);
        return json_encode( $arr );
    }
    static function getUrl($type, $id)
    {
        $url = Yii::app()->params['thumbFolder'];
        return "{$url}{$type}{$id}.jpg";
    }
}
?>
