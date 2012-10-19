<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Util {
    static function DefaultIfNull($value, $defaultValue) {
        if( Util::IsNull($value) ) {
            return $defaultValue;
        }

        return $value;
    }

    static function Get($param, $defaultValue = null) {
        $value = isset($_GET[$param])?$_GET[$param]:'';

        return Util::DefaultIfNull($value, $defaultValue);
    }

    static function GetPost($param, $defaultValue = null) {
        $value = isset($_POST[$param])?$_POST[$param]:'';

        return Util::DefaultIfNull($value, $defaultValue);
    }

    static function ShowIf($condition) {
        return ($condition)?"":"style=display:none";
    }

    static function HiddenIf($condition) {
        return ($condition)?"hidden":"";
    }
    static function LeftIf($condition) {
        return ($condition)?"l":"";
    }

    static function IsNull($object) {
        if( (!isset($object) || $object == null || $object == '')) {
            return true;
        }

        return false;
    }

    static function GetLocalization() {
    //------this is crap--------
        $en = Yii::app()->request->baseUrl.'/en/';
        $nl = Yii::app()->request->baseUrl.'/nl/';

        $pos = strpos(Yii::app()->request->requestUri, $en);
        if($pos === false) {
        //echo 'not english';
        } else {
            return 1;
        }
        $pos = strpos(Yii::app()->request->requestUri, $nl);
        if($pos === false) {
        //echo 'not dutch';
        } else {
            return 2;
        }
        //------crap end--------

        if(isset($_GET['chln'])) {
            return $_GET['chln'];
        }

        $cookie = Yii::app()->request->cookies['ln'];
        if($cookie) {
            return  $cookie->value;
        }

        return Yii::app()->params['defaultLn'];
    }


    static function AddQuery($query) {
        $_url = $_SERVER["REQUEST_URI"];

        if(strpos($_url, '?') == false)
            return $_url  . '?' . $query;

        return $_url  . '&' . $query;
    }
    static function GetChangeLnUrl() {
        $lnId = Util::GetLocalization();
        $chln  =  ($lnId == 1)?2:1;

        $nsCookie = Yii::app()->request->cookies['namespace'];
        if($nsCookie != null && $nsCookie->value == 'index') {
            return Yii::app()->baseUrl . (($lnId == 1)?'/nl/?chln=2':'/en/?chln=1') ;
        }

        if(Yii::app()->request->cookies['enUrl'] || Yii::app()->request->cookies['nlUrl']) {
            $qname = ($lnId == 1)?'nlname':'enname';

            $cookie = Yii::app()->request->cookies['namespace'];
            $namespace =  $cookie->value;

            //            $cookie = Yii::app()->request->cookies['nxtUrl'];
            //            $url =  $cookie->value;

            if($chln == 1)
                $url = Yii::app()->request->cookies['enUrl']->value;
            else
                $url = Yii::app()->request->cookies['nlUrl']->value;

            if( $namespace != 'Page' && $namespace != 'News') {
                $qname = 'fname';
            }

            return Yii::app()->createUrl('webPage/'. strtolower($namespace), array($qname=>$url, 'chln'=>$chln));
        }
        else {
            return Util::AddQuery('chln='.$chln);
        }
    }

    static function UnsetDefaults($model, $properties, $defaultValue = 0) {
        foreach($properties as $property)
            if($model->$property == $defaultValue)
                unset($model->$property);

        return $model;
    }

    static function isValidURL($url) {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
    }

    static function createRandomPassword() {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;

        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }

    static function closest($match, $arr) {
        $set = $arr;
        foreach ($set as $fib) {
            $diff[$fib] = (int) abs($match - $fib);
        }
        $fibs = array_flip($diff);
        $closest = $fibs[min($diff)];

        return $closest;
    }

    static function calculateSize($size, $origw, $origh) {
        if($origw == 0 || $origh ==0) return array(0,0);

        if($origw > $origh) {
            return array( $size , floor($size / $origw * $origh));
        } else {
            return array( floor($size / $origh * $origw),  $size);
        }
    }

    static function friendlify($url) {


        $u1 = strtolower($url);
        $u2 = str_replace(' ', '-', $u1);

        $u3 = preg_replace('/[^a-zA-Z0-9-]*/', '', $u2);

        return $u3;





    }

    static function getFriendlyString2($string) {
        $result = '';
        $charArray = Util::str_split_utf8($string);
        foreach($charArray as $c) {
            $result .= Util::getFriendlyChar($c);
        }

        return $result;
    }
    static function getFriendlyString3($string) {
        $result = '';
        $charArray = Util::str_split_utf8($string);
        foreach($charArray as $c) {
            $result .= Util::getFriendlyChar($c);
        }

        $result = preg_replace("/[^0-9a-zA-Z\-]/", "", $result);

        return $result;
    }
    static function getFriendlyChar($char) {
        $characters = array(
            'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'Ae', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'Th', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'ae', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'d', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'th', 'ÿ'=>'y', ' '=>'-', '('=>'', ')'=>''
        );

        if(isset($characters[$char])) {
            return $characters[$char];
        }

        return $char;

    }

    static function getFriendlyString( $str ) {
    # Quotes cleanup
        $str = str_replace( chr(ord("`")), "'", $str );        # `
        $str = str_replace( chr(ord("´")), "'", $str );        # ´
        $str = str_replace( chr(ord("„")), ",", $str );        # „
        $str = str_replace( chr(ord("`")), "'", $str );        # `
        $str = str_replace( chr(ord("´")), "'", $str );        # ´
        $str = str_replace( chr(ord("“")), "\"", $str );        # “
        $str = str_replace( chr(ord("”")), "\"", $str );        # ”
        $str = str_replace( chr(ord("´")), "'", $str );        # ´
        $str = str_replace( chr(ord(" ")), "-", $str );        # ´
        $str = str_replace( chr(ord("(")), "", $str );        # ´
        $str = str_replace( chr(ord(")")), "", $str );        # ´

        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'Ae', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'Th', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'ae', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'d', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'th', 'ÿ'=>'y', ' '=>'-', );
        $str = strtr( $str, $unwanted_array );

        echo $str;

        # Bullets, dashes, and trademarks
        $str = str_replace( chr(149), "&#8226;", $str );    # bullet •
        $str = str_replace( chr(150), "&ndash;", $str );    # en dash
        $str = str_replace( chr(151), "&mdash;", $str );    # em dash
        $str = str_replace( chr(153), "&#8482;", $str );    # trademark
        $str = str_replace( chr(169), "&copy;", $str );    # copyright mark
        $str = str_replace( chr(174), "&reg;", $str );        # registration mark

        return $str;
    }

    static function str_split_utf8($str) {
    // place each character of the string into and array
        $split=1;
        $array = array();
        for ( $i=0; $i < strlen( $str ); ) {
            $value = ord($str[$i]);
            if($value > 127) {
                if($value >= 192 && $value <= 223)
                    $split=2;
                elseif($value >= 224 && $value <= 239)
                    $split=3;
                elseif($value >= 240 && $value <= 247)
                    $split=4;
            }else {
                $split=1;
            }
            $key = NULL;
            for ( $j = 0; $j < $split; $j++, $i++ ) {
                $key .= $str[$i];
            }
            array_push( $array, $key );
        }
        return $array;
    }


    static function defaultRedirect() {
        $url = (Util::GetLocalization() == 1)?'/en/':'/nl/';
        Yii::app()->request->redirect(Yii::app()->baseUrl . $url);
    }


    static function setLn($_ln) {
        $cookie = new CHttpCookie('ln', $_ln);
        Yii::app()->request->cookies['ln'] = $cookie;
    }

    static function moveFolder($oldfile,$newfile) {
        if (file_exists($newfile) ){
            if ($handle = opendir($oldfile)) {
                while (false !== ($file = readdir($handle))) {
                    if($file != '.' && $file != '..')
                    {
                        rename($oldfile. '/'. $file, $newfile. '/' . basename($file));
                    }
                }
            }
            closedir($handle);
            //unlink($oldfile);
        }
        else
        {
            rename($oldfile,$newfile);
        }
        //          if (copy ($oldfile,$newfile)) {
        //             unlink($oldfile);
        //             return TRUE;
        //          }
        //          return FALSE;

        return TRUE;
    }

    static function redirectGraduation($maxYear){
        if (empty($maxYear))
            return false;
        
        $c_url = str_replace(Yii::app()->request->baseUrl,'',$_SERVER["REQUEST_URI"]);
        $c_url = str_replace('?chln=2','',$c_url);
        $c_url = str_replace('?chln=1','',$c_url);
        $ib = '/';
        if ($c_url[strlen($c_url)-1] == '/') {$ib = '';}

        if(($c_url == '/nl/eindexamens/') || ($c_url == '/nl/eindexamens') || ($c_url == '/en/final-works/') || ($c_url == '/en/final-works')) {
            header( 'Location: '.Yii::app()->request->baseUrl.$c_url.$ib.$maxYear) ;
        }

    }

}

