<?php

class MarkdownController extends CController {
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
    public function getMarkup($markdown) {
        $parser = new MarkdownParserHighslide;
        return $parser->transform($markdown);
    }

    //GET -> http://localhost/en/markdown/getMarkup?value=adfasd---fdgdfgfd
    //POST -> http://localhost/en/markdown/getMarkup
    public function actionGetMarkup()
    {
        if(isset($_POST['value']) )
        {
            echo $this->getMarkup($_POST['value']);
        }

        if(isset($_GET['value']) )
        {
            echo $this->getMarkup($_GET['value']);
        }

    }


}

?>
