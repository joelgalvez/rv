<?php 

class FileUploadController extends CController {
    public function actions() {
        return array(
        'markup'=>array(
        'class'=>'CWebServiceAction',
        ),
        );
    }

    public function accessRules() {
        return array(
        array('allow',
        'actions'=>array('upload','uploadFile'),
        'roles'=>array('authenticated'),
        ),
        array('deny',
        'users'=>array('*'),
        ),
        );
    }

    public $errors = array(
    -1 => "Unknown error",
    //0 => "There is no error, the file uploaded with success",
    1 => "Uploading large file is not allowed",
    2 => "Uploading large file is not allowed",
    3 => "The uploaded file was only partially uploaded, try again",
    4 => "No file was uploaded",
    6 => "Missing a temporary folder",
    7 => "Filed to write the file",
    8 => "Invalid file type"
    );

    /**
     * @param string the content to markdown
     * @return string with the markup
     * @soap
     */
    // WEB SERVICE CALL
    public function uploadFile() {
        $output = array();

        if (!empty($_FILES)) {

            $file = CUploadedFile::getInstanceByName('Filedata');

            $subject = $file->name;
            $subject = strtolower($subject);
            $subject = str_replace(".jpg", "", $subject);
            $subject = str_replace(".gif", "", $subject);
            $pattern = "/[\<\>!@#\$%^&\*.',]+/i";
            if (preg_match($pattern, $subject)) {
                $output = array('error' => 'Illegal file name, / \ : * ? " <> | # <TAB> {} % ~ & - I . \' ');
                return CJSON::encode($output);
            }



            if(! $file->hasError) {
                $name = uniqid(Yii::app()->user->id, false) .'/';

                $baseFolder =  Yii::app()->params['tempFolder']. '/' . $name;

                $output = array(
                    'url' => Yii::app()->request->baseUrl . $baseFolder . $file->name ,
                    'path' => $name . $file->name,
                    'name' => $file->name,
                    'error' => false,
                );

                $baseFolder = dirname($_SERVER['SCRIPT_FILENAME']).$baseFolder;
                $originalFile = $baseFolder. $file->name;

                if(! file_exists($baseFolder)) {
                    mkdir($baseFolder);
                }

                $output['error'] = ! $file->saveAs($originalFile, true);

                if(! $output['error']) {

                    $_img = new ImageHandler();
                    $_img->load( $originalFile );

                    $w = $_img->getWidth();
                    $h = $_img->getHeight();

                    if (($w *$h)  > 9000000) {
                        $output['error'] = 'Maximum image size is 3000px X 3000px or 9 megapixels';
                    }else {

                        $ratio = 0;

                        if($h > $w) {
                            $largeHeight = true;
                            $ratio = $h/$w;
                        } else {
                            $largeHeight = false;
                            $ratio = $w/$h;
                        }

                        $max = ($largeHeight)? $h : $w;

                        $old = $_img;
                        $old_old = $_img;
                        $old_old_old = $_img;

                        foreach(Yii::app()->params['imageSize'] as $k=>$v) {

                            if($v > $max)
                                continue;

                            $newFile = $baseFolder . '/' . $v . '-' . $file->name;

                            $temp_img = new ImageHandler();

                            if($largeHeight) {
                                $temp_img->copyResize($v/$ratio, $v, $old_old_old);
                            } else {
                                $temp_img->copyResize($v, $v/$ratio, $old_old_old);
                            }

                            $temp_img->save($newFile);

                            $old_old_old = $old_old;
                            $old_old = $old;
                            $old = $temp_img;
                        }
                    }
                }

            }else {
                if(isset($error[$file->error])) {
                    $output = array('error' => $error[$file->error]);
                }else {
                    $output = array('error' => $error[-1]);
                }
            }

        }else {
            $output = array('error' => 'No Files uploaded');
        }

        return CJSON::encode($output);

    }

    //GET -> http://localhost/en/markdown/getMarkup?value=adfasd---fdgdfgfd
    //POST -> http://localhost/en/markdown/getMarkup
    public function actionUpload() {
        echo $this->uploadFile();
    }
}


?>
