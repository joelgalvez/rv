<?php

class ItemUploadController extends CController
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
		return Yii::app()->params['defaultRules'];
	}

	/**
	 * Shows a particular model.
	 */
	public function actionShow()
	{
		$this->render('show',array('model'=>$this->loadItemUpload()));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        
		$model=new ItemUpload;
        $upload = new ItemUploadUploads;
        $uploadUser = new ItemUploadUser;
        
        $file;
        $filePath;

		if(isset($_POST['ItemUpload']))
		{
			$model->attributes=$_POST['ItemUpload'];
            $model = $this->processItem($model);
            $model->created = new CDbExpression('NOW()');
            
            if($model->type == 1)
            {
                if($_POST['ItemUploadUploads'])
                {
                    $file = CUploadedFile::getInstance($upload, 'path');

                    $upload->filename = $_POST['ItemUploadUploads']['filename'];
                    $upload->type = $file->type;
                    $upload->path =  'images/';
                    $upload->extension = $file->extensionName;                                        
                }
            }

            if($model->validate())
            {
                $transaction = $model->dbConnection->beginTransaction();

                try
                {
                    $model->save();

                    if($model->type == 1 && $upload->validate())
                    {
                        $upload->itemUploadId = $model->id;
                        $upload->filename = $upload->itemUploadId . '_' . $upload->filename;
                        $upload->save();

                        $filePath = $upload->path . $upload->filename . '.' . $upload->extension;
                        
                    }                    

                    $transaction->commit();

                    

                }
                catch(Exception $e)
                {
                    $transaction->rollBack();
                    throw new CHttpException(500, "some unknow error occured " . $e);
                    
                }

                if(isset($filePath))
                    $file->saveAs($filePath);

                $this->redirect(array('show','id'=>$model->id));
            }
		}
        
		$this->render('create',array('model'=>$model,'upload'=>$upload,'uploadUser'=>$uploadUser));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        
		$model=$this->loadItemUpload();

        $upload = new ItemUploadUploads;
        $file;
        $filePath;

        if(isset($_POST['ItemUpload']))
		{
			$model->attributes=$_POST['ItemUpload'];
            $model = $this->processItem($model);
            $model->created = new CDbExpression('NOW()');

            if($model->type == 1)
            {
                if($_POST['ItemUploadUploads'])
                {
                    $file = CUploadedFile::getInstance($upload, 'path');

                    $upload->filename = $_POST['ItemUploadUploads']['filename'];
                    $upload->type = $file->type;
                    $upload->path =  'images/';
                    $upload->extension = $file->extensionName;
                }
            }

            if($model->validate())
            {
                $transaction = $model->dbConnection->beginTransaction();

                try
                {
                    $model->save();

                    if($model->type == 1 && $upload->validate())
                    {
                        $upload->itemUploadId = $model->id;
                        $upload->filename = $upload->itemUploadId . '_' . $upload->filename;
                        $upload->save();

                        $filePath = $upload->path . $upload->filename . '.' . $upload->extension;

                    }

                    $transaction->commit();



                }
                catch(Exception $e)
                {
                    $transaction->rollBack();
                    throw new CHttpException(500, "item information is missing");

                }

                if(isset($filePath))
                    $file->saveAs($filePath);

                $this->redirect(array('show','id'=>$model->id));
            }
		}
        
		if(isset($_POST['ItemUpload']))
		{
			$model->attributes=$_POST['ItemUpload'];
            $model = $this->processItem($model);
            
			if($model->save())
				$this->redirect(array('show','id'=>$model->id));
		}
		$this->render('update',array('model'=>$model));
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
			$this->loadItemUpload()->delete();
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
        
        if($_GET['itemid'])
        {
            $criteria->condition = 'itemId=:itemId';
            $criteria->params = array(':itemId'=>$_GET['itemid']);
        }

		$pages=new CPagination(ItemUpload::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$models=ItemUpload::model()->findAll($criteria);

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

        if($_GET['itemid'])
        {
            $criteria->condition = 'itemId=:itemId';
            $criteria->params = array(':itemId'=>$_GET['itemid']);
        }

		$pages=new CPagination(ItemUpload::model()->count($criteria));
		$pages->pageSize=self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('ItemUpload');
		$sort->applyOrder($criteria);

		$models=ItemUpload::model()->findAll($criteria);

		$this->render('admin',array(
			'models'=>$models,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadItemUpload($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=ItemUpload::model()->findbyPk($id!==null ? $id : $_GET['id']);
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
			$this->loadItemUpload($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}

    protected function processItem($model)
    {
        if($_GET['itemid'])
        {
            $model->itemId = $_GET['itemid'];

            if($model->localizationId == 0)
                unset($model->localizationId);

            if($model->categoryId == 0)
                unset($model->categoryId);

            if($model->editorId == 0)
                unset($model->editorId);

            if($model->uploadSelectedItemId == 0)
                unset($model->uploadSelectedItemId);

            return $model;
        }
        else
        {
            throw new CHttpException(500, 'itemId can not be null');
        }
    }
}
