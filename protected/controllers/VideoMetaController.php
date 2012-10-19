<?php

class VideometaController extends CController {
    public function actions()
    {
        return array(
            'markup'=>array(
                'class'=>'CWebServiceAction',
            ),
        );
    }

    /**
     * @param string the content to markdown
     * @return string with the markup
     * @soap
     */
    // WEB SERVICE CALL
    public function getVideometa($url) {
        $parser = new MetaVideo($url);
        return $parser->render();
    }

    //GET -> http://localhost/en/markdown/getMarkup?value=adfasd---fdgdfgfd
    //POST -> http://localhost/en/markdown/getMarkup
    public function actionGetMeta()
    {
        if(isset($_POST['url']) )

        {
            echo $this->getVideometa($_POST['url']);
        }else if(isset($_GET['url']) )
        {
            echo $this->getVideometa($_GET['url']);
        }

    }


}

?>
