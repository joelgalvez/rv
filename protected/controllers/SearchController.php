<?php

class SearchController extends CController {
    public $defaultAction='index';

    protected function _search($ln, $ns, $sqlQuery, $showUpload = false, $itemBased = false)
    {
        $query = Util::Get('q', null);

        if($query == null) {
            throw new CHttpException(501,'All informations are not given');
        }

        if($ln == 1)
            $model = enItemUploadsView::model();
        else
            $model = nlItemUploadsView::model();

        $searchCriteria = new CDbCriteria();
        $searchCriteria->select = 'id, title, friendlyUrl, namespaceId' . (($itemBased)?'':', uploadId');
        $searchCriteria->condition = "$ns AND $sqlQuery";
        $searchCriteria->params = array(':q'=>'%'.$query.'%');
        $searchCriteria->distinct = true;

        $count = $model->count($searchCriteria);

        $pages=new CPagination($count);
        $pages->pageSize=Yii::app()->params['resultPerPage'];
        $pages->applyLimit($searchCriteria);

        $items = $model->findAll($searchCriteria);

        $this->renderPartial('item', array(
            'items'=>$items,
            'pages'=>$pages,
            'showUpload'=>$showUpload,
            'itemBased'=>$itemBased
        ));
    }

    public function actionIndex() {
        $this->render('index', array('ln'=>'en'));
    }

    public function actionIndexNl() {
        $this->render('index', array('ln'=>'nl'));
    }

    public function actionUser() {
        $query = $_GET['q'];

        $searchCriteria = new CDbCriteria();
        $searchCriteria->select = 'id, userId, name, friendlyName, year, graduated, categoryName';
        $searchCriteria->condition = 'name like :q OR friendlyName like :q';
        $searchCriteria->params = array(':q'=>'%'.$query.'%' );

        $users = UserInfo::model()->findAll($searchCriteria);
        $this->renderPartial('/webPage/upload/users', array(
                'users'=>$users,
                'fromSearch'=>true
            ));

    }

    public function actionPage(){
        $this->_search(1, "namespaceId = " . ns::PAGE, '(title like :q OR text like :q OR uploadTitle like :q OR uploadText like :q OR owner like :q OR category like :q)', false ,true);
    }

    public function actionNews() {
        $this->_search(1, "namespaceId = " . ns::NEWS, '(uploadTitle like :q OR uploadText like :q OR owner like :q OR category like :q)', true);
    }

    public function actionProject() {

        $this->_search(1, "(namespaceId = " . ns::PROJECT . " or namespaceId = " . ns::GRADUATION . ")", '(title like :q OR text like :q OR uploadTitle like :q OR uploadText like :q OR owner like :q OR category like :q)', true, true);
    }

    public function actionPageNl(){
        $this->_search(2, "namespaceId = " . ns::PAGE, '(title like :q OR text like :q OR uploadTitle like :q OR uploadText like :q OR owner like :q OR category like :q)', false ,true);
    }

    public function actionNewsNl() {
        $this->_search(2, "namespaceId = " . ns::NEWS, '(uploadTitle like :q OR uploadText like :q OR owner like :q OR category like :q)', true);
    }

    public function actionProjectNl() {
        $this->_search(1, "(namespaceId = " . ns::PROJECT . " or namespaceId = " . ns::GRADUATION . ")", '(title like :q OR text like :q OR uploadTitle like :q OR uploadText like :q OR owner like :q OR category like :q)', true ,true);
    }
}
