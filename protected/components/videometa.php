<?php
error_reporting(-1);

class videometa {


    function videometa($url) {

        //$url = $_GET['url'];
        $tn = -1;
        $width = -1;
        $height = -1;
        $ratio = -1;
        $id = -1;
        $type = -1;


        if(strstr($url, "youtube")) {
            $id = $this->youtubeid($url);
            $meta = $this->getmetadata("http://gdata.youtube.com/feeds/api/videos/" . $id . "?alt=json");

            $meta = json_decode(trim($meta));
            if($meta == "") {
                $this->err("Couldn't json_decode metadata");
            }

            $tn = (array)$meta;
            $tn = (array)$tn['entry'];
            $tn = (array)$tn['media$group'];
            $tn = (array)$tn['media$thumbnail'];
            $tn = (array)$tn[3];
            $tn = $tn['url'];

            if(!Util::isValidURL($tn)) {
                err("Thumbnail don't have valid URL (" . $tn . ")");
            }

            $type = "youtube";
            $width = 640;
            $height = 360;
            $ratio = 16 / 9;

        } elseif(strstr($url, "vimeo")) {

            $spos = strripos($url, "/");
            $id = intval(substr($url, $spos+1));
            $meta = $this->getmetadata('http://vimeo.com/api/clip/' . $id . '/php');
            //a:0:{}
            if($meta == "a:0:{}") {
                $this->err("Can't find metadata for video");
            }
            $meta = unserialize(trim($meta));
            if($meta == "") {
                $this->err("Couldn't un-serialize metadata");
            }


            $tn = $meta[0]['thumbnail_large'];


            if(!Util::isValidURL($tn)) {
                $this->err("Thumbnail don't have valid URL (" . $tn . ")");
            }

            $width = $meta[0]['width'];
            $height = $meta[0]['height'];
            $ratio = $width / $height;
            $type = "vimeo";

        } else {
            err("Don't seem like a video link");
        }
    }

    function youtubeid($url) {
    /*        if (preg_match('%youtube\\.com/(.+)%', $url, $match)) {
                    $match = $match[1];
                    $replace = array("watch?v=", "v/", "vi/");
                    $match = str_replace($replace, "", $match);
            }
            return $match;
    */


        $url = parse_url($url);
        parse_str($url['query']);
        return $v; //7KdMiRUbHi0
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



    //print_r($array);
    function render() {
        $arr = array('status' => 'ok', 'msg' => '', 'id' => $id, 'type' => $type, 'tn' => $tn, 'width' => $width, 'height' => $height);
        return json_encode( $arr );
    }
}
?>
