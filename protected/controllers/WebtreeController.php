<?php

class WebtreeController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'list' and 'show' actions
				'actions'=>array('list','show'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'friendlyUrlLookup','admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Shows a particular model.
	 */
	public function actionShow()
	{
		$this->render('show',array('model'=>$this->loadwebtree()));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		$model=new webtree;

                $criteria = new CDbCriteria;
                $parentlist= webtree::model()->findAll($criteria);
                $aParentlist = null;
                $aParentlist['0'] ='ROOT';
                foreach ($parentlist as $k=>$v) {
                    $aParentlist[$v->id] = $v->name;
                }

                if(isset($_GET['parentId']))
                {
                    if(strtolower($_GET['parentId'] ) != 'null')
                    {
                        $model->parentId = $_GET['parentId'];
                    }
                }

                $cookie = Yii::app()->request->cookies['ln'];
                if($cookie) {
                    $model->localizationId = $cookie->value;
                }

		if(isset($_POST['webtree']))
		{
			$model->attributes=$_POST['webtree'];
			if($model->save())
				$this->redirect(array('show','id'=>$model->id));
		}
		$this->render('create',array('model'=>$model,'parentlist'=>$aParentlist));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadwebtree();

                $criteria = new CDbCriteria;
                $parentlist= webtree::model()->findAll($criteria);
                $aParentlist = null;
                $aParentlist['0'] ='ROOT';
                foreach ($parentlist as $k=>$v) {
                    $aParentlist[$v->id] = $v->name;
                }

		if(isset($_POST['webtree']))
		{
			$model->attributes=$_POST['webtree'];
			if($model->save())
				$this->redirect(array('show','id'=>$model->id));
		}
		$this->render('update',array('model'=>$model,'parentlist'=>$aParentlist));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadwebtree()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$criteria=new CDbCriteria;

		$pages=new CPagination(webtree::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$models=webtree::model()->findAll($criteria);

		$this->render('list',array(
			'models'=>$models,
			'pages'=>$pages,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(webtree::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('webtree');
		$sort->applyOrder($criteria);

		$models=webtree::model()->findAll($criteria);

		$this->render('admin',array(
			'models'=>$models,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

        public function actionFriendlyUrlLookup()
        {
            $url = array();
            $name = $_GET['q'];
            $limit = min($_GET['limit'], 50);
            $ns = Util::Get('ns', 1);

            $criteria = new CDbCriteria;

            if($ns == 1)
            {
                $criteria->condition = "friendlyUrl LIKE :sterm";
            }else
            {
                $criteria->condition = "friendlyUrlNl LIKE :sterm";
            }

            $criteria->params = array(":sterm"=>"%$name%");
            $criteria->limit = $limit;
            $items = item::model()->findAll($criteria);
            $returnVal = '';

            foreach($items as $item) {
                if($ns == 1)
                {
                    $_url = Yii::app()->createUrl('webPage/'. strtolower($item->namespace->name),array('enname'=>$item->friendlyUrl));
                }else
                {
                    $_url = Yii::app()->createUrl('webPage/'. strtolower($item->namespace->name),array('nlname'=>$item->friendlyUrlNl));
                }

                $returnVal .= $_url.'|'
                    .$_url."\n";
            }

            echo $returnVal;
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadwebtree($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=webtree::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadwebtree($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
