<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebTree
 *
 * @author antobinish
 */
class WebTreeMenu extends CWidget{
    public $root;
    public $edit = false;
    public $showChangeLn = false;
    public $localization = null;
    public $redirectIf = null;

    public function run()
    {
        $this->changeLn();
        $this->redirectDefault();
        $this->getLn();

        $this->render('webTreeMenu',array(
                    'tree'=>webtree::model()->getTree($this->localization),
                    'edit'=>$this->edit,
                    'showChangeLn'=>$this->showChangeLn,
                    'localization'=>$this->localization,
                    )
            );
    }

    protected function redirectDefault()
    {
//        if($this->redirectIf != null && (!isset($_GET['noredirect']))) {
//            $currentPath = $this->controller->uniqueID . '/' . $this->controller->action->id;
//
//            if($currentPath == $this->redirectIf)
//            {
//                $node = webtree::model()->find('defaultPage = 1');
//                if($node)
//                {
//                    $this->_setLn($node->localizationId);
//                    Yii::app()->request->redirect($node->url);
//                }
//            }
//        }

        return false;
    }

    protected function changeLn()
    {
        if(isset($_GET['chln'])) {
            $this->_setLn($_GET['chln']);
        }
        else {
            if( ! isset(Yii::app()->request->cookies['ln'])) {//        if($this->redirectIf != null && (!isset($_GET['noredirect']))) {

                $this->_setLn(Yii::app()->params['defaultLn']);
            }
        }
    }

    protected function getLn()
    {
        if($this->localization === null) {
            $this->localization = Util::GetLocalization();
            //$this->getCookeLn();
        }
    }

    protected function getCookeLn()
    {
        $cookie = Yii::app()->request->cookies['ln'];
        if($cookie) {
            $this->localization = $cookie->value;
        }

        return $this->localization;
    }

    protected function _setLn($_ln)
    {
        $cookie = new CHttpCookie('ln', $_ln);
        Yii::app()->request->cookies['ln'] = $cookie;
    }
}
?>
