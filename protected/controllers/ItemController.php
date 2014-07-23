<?php

class ItemController extends CController {
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
    public function filters() {
        return array(
        'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
                        array('allow',
                                'actions'=>array('list','show'),
                                'users'=>array('*'),
                        ),
                        array('allow',
                                'actions'=>array('create','update','filter'),
                                'roles'=>array('administrator', 'student', 'teacher', 'staff', 'werkplaats'),
                        ),
                        array('allow',
                                'actions'=>array('adminCreate','adminUpdate'),
                                'roles'=>array('administrator'),
                        ),
                        array('allow',
                                'actions'=>array('admin','delete'),
                                'roles'=>array('administrator'),
                        ),
                        array('deny',
                                'users'=>array('*'),
                        ),
         );
    }


    public function actionFilter() {
        $projectName = Util::Get('q', '');
        $namespace = Util::Get('n', '');
        $category = Util::Get('c', '');
        $itemId = Util::Get('i', null);

        $useGraduation = Util::Get('g', false);
        $onlyOnline = Util::Get('o', false);
        $orderByOnline = Util::Get('obo', false);

        $max = Util::Get('limit', 50);
        $maxU = Util::Get('maxU', 1);
        $output = Util::Get('o', '');


        if($projectName != '') {

//            $projectId = ns::model()
//                ->find("name = :name", array(':name'=>'Project'))
//                ->id;

            $_criteria = new CDbCriteria;
            $_criteria->condition = "title LIKE :title";
            $_criteria->params = array
                (
                ":title"=> "%$projectName%",
//                ":ns"=> $projectId,
            );

            $_criteria->limit = $max;

            $_criteria->select = 'id, title';

            $uploads = item::model()->findAll($_criteria);

            $uploadReturn = '';

            foreach($uploads as $_upload) {
                $uploadReturn .= $_upload->title.'|'.$_upload->id . "\n";
            }

            echo $uploadReturn;

        }else
        {
            echo CJSON::encode(ItemFilter::getUploads($category, $namespace, $max, $itemId, true, $maxU, 0, 0, $useGraduation, $onlyOnline, $orderByOnline));
        }

    }

    /**
     * Shows a particular model.
     */
    public function actionShow() {
        $this->render('show',array('model'=>$this->loaditem()));
    }

    public function actionCreate() {
        $nid = Util::Get('nid', 0);
        if($nid == 3)
        {
            $this->actionAdminCreate();
        }else
        {
               throw new CHttpException(501, 'You are not authorized to perform this action.');
        }
    }

    /**
     * Let the current user modify the item given by request parameter 'nid'.
     * This method only allows modifying projects and graduations. Other types
     * of pages can only be modified by administrators (using actionAdminUpdate()).
     * @throws CHttpException
     */
    public function actionUpdate() {
        $nid = Util::Get('nid', 0);

        if($nid == ns::PROJECT)
        {
            $this->actionAdminUpdate();
        }elseif($nid == ns::GRADUATION){
            $this->processAdminItems(true, true);
        }else
        {
            throw new CHttpException(501, 'You are not authorized to perform this action.');
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'show' page.
     */
    public function actionAdminCreate() {
    //$this->processItems();
        $this->processAdminItems();
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'show' page.
     */
    public function actionAdminUpdate() {
    //$this->processItems(true);
        $this->processAdminItems(true, false);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     */
    public function actionDelete() {
        if(Yii::app()->request->isPostRequest) {
        // we only allow deletion via POST request
            $this->loaditem()->delete();
            $this->redirect(array('list'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionList() {
        $criteria=new CDbCriteria;

        $pages=new CPagination(item::model()->count($criteria));
        $pages->pageSize=self::PAGE_SIZE;
        $pages->applyLimit($criteria);

        $models=item::model()->findAll($criteria);

        $this->render('list',array(
            'models'=>$models,
            'pages'=>$pages,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->processAdminCommand();

        $criteria=new CDbCriteria;
        $criteria->condition = 'localizationId = 2';

        $pages=new CPagination(item::model()->count($criteria));
        $pages->pageSize=self::PAGE_SIZE;
        $pages->applyLimit($criteria);

        $sort=new CSort('item');
        $sort->applyOrder($criteria);

        $models=item::model()->with('namespace','owner','editor','category')->findAll($criteria);

        $ns = ns::model()->findall();

        $this->render('admin',array(
            'models'=>$models,
            'ns'=>$ns,
            'pages'=>$pages,
            'sort'=>$sort,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     */
    public function loaditem($id=null) {
        if($this->_model===null) {
            if($id!==null || isset($_GET['id']))
                $this->_model=item::model()->findbyPk($id!==null ? $id : $_GET['id']);
            if($this->_model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }
        return $this->_model;
    }

    /**
     * Executes any command triggered on the admin page.
     */
    protected function processAdminCommand() {
        if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete') {
            $this->loaditem($_POST['id'])->delete();
            // reload the current page to avoid duplicated delete actions
            $this->refresh();
        }
    }

    protected function processItem($model) {
        if($model->localizationId == 0)
            unset($model->localizationId);

        if($model->namespaceId == 0)
            unset($model->namespaceId);

        if($model->categoryId == 0)
            unset($model->categoryId);

        if($model->editorId == 0)
            unset($model->editorId);

        return $model;
    }

    protected function processAdminItems($update = false, $allowOnlyOwner = false) {

        $extra = array();

        $item = new item;
        $itemTitle = '';
        $itemTitleNl = '';
        $itemFTitle = '';
        $itemFTitleNl = '';

        $postions = array();
        $_saved = array();
        $itemIdGroups = array();
        $files = array();
        $filesNl = array();
        $view = 'admin/createPopup';

        $itemUploads = array();
        $loadedItemUploads = array();
        $newUploads = array();

        //Model data
        $itemUploads[-1] = new ItemUpload;
        $itemUploads[-1]->type = "upload";

        $extra['usernames'] = array(0=>'', 1=>'' );

        $extra['selectedItems'][-1] = '';
        $extra['useGroup'][-1] = false;

        $nid = Util::Get('nid', 0);

        if($update) {
            $view = 'admin/updatePopup';

            $id = Util::Get('id', 0);
            if($id == 0 ) {
                throw new CHttpException(501, 'Item is not selected');
            }

            $item = item::model()->find("id=:id", array(':id'=>$id));

            if($allowOnlyOwner )
                if($item->ownerId != Yii::app()->user->id){
                    throw new CHttpException(501, 'You are not authorized to perform this action.');
                }

            $itemTitle = $item->title;
            $itemTitleNl = $item->titleNl;
            $itemFTitle = $item->friendlyUrl;
            $itemFTitleNl = $item->friendlyUrlNl;

            $criteria = new CDbCriteria();
            $criteria->condition = "itemId=:itemId";
            $criteria->params = array(':itemId'=>$id);
            $criteria->order = 'position';

            $loadedItemUploads = ItemUpload::model()->findAll($criteria);
            $itemUploads = $itemUploads + $loadedItemUploads;


            foreach( $itemUploads as $k=>$v) {
                $extra['selectedUsers'][$k] = array();

                if($itemUploads[$k]->type == 'users') {

                    $_users = ItemUploadUser::model()->with('user')->findAll('itemUploadId = :uid', array(':uid'=> $itemUploads[$k]->id));

                    $extra['useGroup'][$k] = (count($_users) > 0)? 'true' : 'false';

                    foreach($_users as $_k=>$_v) {
                        $extra['selectedUsers'][$k][$_v->userId] = $_v->user->name;
                    }
                }else
                {
                    $extra['useGroup'][$k] = false;
                }

                if($itemUploads[$k]->uploadSelectedItemId != null) {
                    $criteria = new CDbCriteria;
                    $criteria->select = 'id, title';
                    $criteria->condition = "id = :id";
                    $criteria->params = array(":id"=> $itemUploads[$k]->uploadSelectedItemId);

                    $extra['selectedItems'][$k] = item::model()->find($criteria)->title;
                }else
                {
                    $extra['selectedItems'][$k] = '';
                }

                if(isset($itemUploads[$k]->uploadFilterCount))
                {
                    if($itemUploads[$k]->uploadFilterCount == 0)
                    {
                        $itemUploads[$k]->uploadFilterCount = 'all';
                    }else if($itemUploads[$k]->uploadFilterCount == -1)
                    {
                        $itemUploads[$k]->uploadFilterCount = 'fillup';
                    }
                }
            }


            $extra['usernames'] = array(
                0 => User::model()->findByPk($item->ownerId)->name,
                1 => User::model()->findByPk($item->editorId)->name,
            );

            if($nid == 0)
                $nid = $item->namespaceId;
        }

        if($nid == 0 ) {
            throw new CHttpException(501, 'Namespace is not selected');
        }

        $ns = ns::model()->findByPk($nid);

        $extra['namespace'] = $ns->name;
        $extra['yearDimension'] = $ns->yearDimension;
        $extra['categoryFilter'] = $ns->categoryFilter;
        $extra['commonLn'] = $ns->commonLn;
        $extra['uploadTypes'] = ItemUpload::model()->UploadTypes;
        $extra['saveandclose'] = 0;


        if(isset($_POST['item'])) {
            $valid = true;
            $extra['saveandclose'] = $_POST['savenclose'];

            $item->attributes=$_POST['item'];
            /*Great hot fix*/
            $item->parentId = 0;
            $item->dontChangeDate = $_POST['item']['dontChangeDate'];

            if($item->id == null) {
                if($item->dontChangeDate){
                    $item->modified = date("2001-".date("m").'-'.date("d"));
                }
            }

            
            
            if($itemFTitle != $item->friendlyUrl)
            {
                //$_count = item::model()->count('friendlyUrl = :friendlyurl AND id != :id', array('id'=>(($item->id == null)?0:$item->id), 'friendlyurl'=>$item->friendlyUrl));
                $_count = item::model()->count('title = :title AND id != :id', array('id'=>(($item->id == null)?0:$item->id), 'title'=>$item->title));

                if($_count > 0)
                {
                    $item->friendlyUrl = Util::getFriendlyString3($item->friendlyUrl). $_count;
                }else
                {
                    $item->friendlyUrl = Util::getFriendlyString3($item->friendlyUrl);
                }
            }
            

            if($itemFTitleNl != $item->friendlyUrlNl)
            {
                //$_count = item::model()->count('friendlyUrlNl = :friendlyurl AND id != :id', array('id'=>(($item->id == null)?0:$item->id), 'friendlyurl'=>$item->friendlyUrlNl));
                $_count = item::model()->count('titleNl = :title AND id != :id', array('id'=>(($item->id == null)?0:$item->id), 'title'=>$item->titleNl));

                if($_count > 0)
                {
                    $item->friendlyUrlNl = Util::getFriendlyString3($item->friendlyUrlNl). $_count;
                }else
                {
                    $item->friendlyUrlNl = Util::getFriendlyString3($item->friendlyUrlNl);
                }
            }
           
            $item = Util::UnsetDefaults($item, array('namespaceId','categoryId','editorId'));

            $valid = $item->validate();

            if(isset($_POST['ItemUpload'])) {
                foreach($_POST['ItemUpload'] as $i => $itemUpload) {
                    if($i != -1) {

                        if(!isset($loadedItemUploads[$i]))
                            $newUploads[$i] = true;
                        else
                            $newUploads[$i] = false;


                        if(!$newUploads[$i] && $update) {
                            $itemUploads[$i] = clone $loadedItemUploads[$i];
                        }else {
                            $itemUploads[$i] = new ItemUpload;
                            $itemUploads[$i]->created = new CDbExpression('NOW()');
                            $itemUploads[$i]->ownerId = $item->ownerId;
                            $itemUploads[$i]->editorId = Yii::app()->user->id;
                            $itemUploads[$i]->itemId = $item->id;
                        }


                        $itemUploads[$i]->attributes =  $itemUpload;

                        $itemUploads[$i]->itemNamespaceId = $item->namespaceId;

                        if($update)
                        {
                            $_saved[$itemUploads[$i]->id] = true;
                        }

                        if( !isset($itemUploads[$i]->online) || $itemUploads[$i]->online == '') {
                            $itemUploads[$i]->online = $item->online;
                        }

                        if($itemUploads[$i]->type == 'upload' && $itemUploads[$i]->uploadtype == 1) {

                            $files[$i] = dirname($_SERVER['SCRIPT_FILENAME']).
                                Yii::app()->params['tempFolder'].
                                $itemUploads[$i]->filePath;

                            if(!$newUploads[$i] &&  $loadedItemUploads[$i]->filePath == $itemUploads[$i]->filePath)
                            {
                                $files[$i] = null;
                            }

                            if($files[$i] != null) {
                                $_img = new ImageHandler();
                                $_img->load( $files[$i] );

                                $itemUploads[$i]->imageWidth = $_img->getWidth();
                                $itemUploads[$i]->imageHeight = $_img->getHeight();

                                $itemUploads[$i]->fileType = CFileHelper::getMimeType($files[$i]);

                                //$newUploads[$i] = true;
                            }

                            if(($item->namespaceId == ns::NEWS || $item->namespaceId == ns::PAGE) && $itemUploads[$i]->filePathNl != '' )
                            {
                                $filesNl[$i] = dirname($_SERVER['SCRIPT_FILENAME']).
                                Yii::app()->params['tempFolder'].
                                $itemUploads[$i]->filePathNl;

                                if(!$newUploads[$i] &&  $loadedItemUploads[$i]->filePathNl == $itemUploads[$i]->filePathNl)
                                    $filesNl[$i] = null;

                                if($filesNl[$i] != null) {
                                    if(isset($filesNl[$i]) && file_exists($filesNl[$i]))
                                    {
                                        $_img = new ImageHandler();
                                        $_img->load( $filesNl[$i] );
                                        $itemUploads[$i]->imageWidthNl = $_img->getWidth();
                                        $itemUploads[$i]->imageHeightNl = $_img->getHeight();

                                        $itemUploads[$i]->fileTypeNl = CFileHelper::getMimeType($filesNl[$i]);
                                    }
                                }
                            }

                            if($itemUploads[$i]->filePathNl == '')
                            {
                                $itemUploads[$i]->fileNameNl = '';
                            }

                        }else if($itemUploads[$i]->type == 'upload' && $itemUploads[$i]->uploadtype == 2)
                        {
                            //change this
                            //$itemUploads[$i]->imageWidth = 480;
                            //$itemUploads[$i]->imageHeight = 360;
                        }
                        else if($itemUploads[$i]->type == 'users') {
                                if(! isset($_POST['ItemUpload'][$i]['useGroup'])) {
                                    if(isset($_POST['ItemUpload'][$i]['selectedUsers'])) {
                                        $userGroups[$i] = array();

                                        $extra['selectedUsers'][$i] = $_POST['ItemUpload'][$i]['selectedUsers'];

                                        foreach($_POST['ItemUpload'][$i]['selectedUsers'] as $j=>$v) {
                                            if($j != '{id}') {
                                                $_ug = new ItemUploadUser;
                                                $_ug->userId = $v;

                                                $userGroups[$i][] = $_ug;
                                            }
                                        }
                                    }
                                    else {
                                        $valid = false;
                                    }
                                }

                            }else if($itemUploads[$i]->type == 'uploadFilter') {

                                if( strtolower($itemUploads[$i]->uploadFilterCount) == 'all')
                                {
                                    $itemUploads[$i]->uploadFilterCount = 0;
                                }else if( strtolower($itemUploads[$i]->uploadFilterCount) == 'fillup')
                                {
                                    $itemUploads[$i]->uploadFilterCount = -1;
                                }

                                    if($itemUploads[$i]->namespaceId != 0 || $itemUploads[$i]->categoryId != 0) {
                                        unset($itemUploads[$i]->uploadSelectedItemId);
                                    }
                                }

                        $itemUploads[$i] = Util::UnsetDefaults($itemUploads[$i], array('namespaceId','categoryId'));
                        $itemUploads[$i] = Util::UnsetDefaults($itemUploads[$i], array('editorId', 'videolink'), '');

                        if($itemUploads[$i]->type != 'uploadSelection' && $itemUploads[$i]->type != 'uploadFilter') {
                            unset($itemUploads[$i]->uploadSelectedItemId);
                        }

                        $itemUploads[$i]->otherPositions = $postions;

                        if(isset($loadedItemUploads[$i]) && $itemUploads[$i]->isModified($loadedItemUploads[$i]))
                        {
                            $itemUploads[$i]->setAsModified();
                        }

                        if( !$valid )
                            $itemUploads[$i]->validate();
                        else
                            $valid = $itemUploads[$i]->validate();

                        $postions[$itemUploads[$i]->position] = true;
                        if(!isset($extra['selectedItems'][$i]))
                        {
                            $extra['selectedItems'][$i] = '';
                            $extra['useGroup'][$i]= false;
                            $extra['selectedUsers'][$i]= array();

                        }
                    }
                }
            }

            if($valid) {
                if($item->save()) {
                    foreach($itemUploads as $i => $itemUpload) {
                        if($i != -1) {
                            $itemUpload->itemId = $item->id;

                            if(isset($files[$i]) && file_exists($files[$i])) {
                                $itemUpload->filePath = User::getUserWebPath() . $itemUpload->itemId . '/';
                            }
                            if(isset($filesNl[$i]) && file_exists($filesNl[$i]))
                            {
                                $itemUpload->filePathNl = User::getUserWebPath() . $itemUpload->itemId . '/';
                            }

                            if($itemUpload->save()) {
                               // if(isset($files[$i]) && $files[$i] != null && $newUploads[$i]) {
                                    $basePath = User::getUserBasePath() . $itemUpload->itemId;// . '/';
                                    if(isset($files[$i]) && file_exists($files[$i]))
                                    $this->generateFiles($basePath, $itemUpload->fileName, $files[$i] , $itemUpload->fileType);
                                    if(isset($filesNl[$i]) && file_exists($filesNl[$i]))
                                    {
                                        $this->generateFiles($basePath, $itemUpload->fileNameNl, $filesNl[$i] , $itemUpload->fileTypeNl);
                                    }
                                //}

                                if(isset($userGroups[$i])) {
                                //TODO: Wrong way need to change
                                    foreach($userGroups[$i] as $userGroup) {
                                        $userGroup->itemUploadId = $itemUpload->id;

                                        if( ! $userGroup->save()) {
                                            $valid = false;
                                        }
                                    }
                                }

                            }
                            else if($valid) {
                                    $valid = false;
                                }
                        }
                    }
                }else {
                    $valid = false;
                }

            }

            if($valid && $update)
            {
                foreach($loadedItemUploads as $i => $itemUpload) {
                    $_deleted = ! isset($newUploads[$i]);

                    if(! $_deleted)
                    {
                        $_deleted = (!$newUploads[$i]) && (!isset($_saved[$itemUpload->id]));
                    }


                    if($_deleted)
                    {
                        unset($itemUploads[$i]);

                        ItemUploadUser::model()->deleteAll('itemUploadId = :id', array(':id'=>$itemUpload->id));

                        $itemUpload->delete();
                    }
                }
            }

            if($valid && !isset($_GET["haCK"]))
            {
                if($nid == 3 || ( $allowOnlyOwner && $nid == 4))
                    $this->redirect(array('update','id'=>$item->id, 'nid'=>$nid, 'f'=>'update', 'close'=>$extra['saveandclose']));
                else
                    $this->redirect(array('adminUpdate','id'=>$item->id, 'f'=>'update', 'close'=>$extra['saveandclose']));
            }

        }else {
            if(!$update) {

                $item->namespaceId = $nid;

                $item->parentId = Util::Get('pId',0);

                $item->ownerId = Yii::app()->user->id;
                $item->editorId = Yii::app()->user->id;

                $item->commonLn = $ns->commonLn;
                $item->allowChild = $ns->allowChildren;
                $item->showChild = $ns->showChildren;
                $item->shared = $ns->shared;
                $item->categoryFilter = $ns->categoryFilter;
                $item->userFilter = $ns->userFilter;

                $item->online = date("Y-m-d");

                $item->uploadNr = 15;

                $extra['usernames'] = array(
                    0 => Yii::app()->user->name,
                    1 => Yii::app()->user->name,
                );

                // BEGIN: ************ REMOVE THE FOLLOWING LINES ON LIVE
                if(isset($_GET['autofill'])) {
                    $_a = Util::Get('autofill',0);

                    if($_a == 0) {
                        $item->title = 'My Title En '. time();
                        $item->text = "My text \n***********\n En ". time();
                        $item->friendlyUrl = 'my-title-en-'.time();

                        $item->titleNl = 'My Title Nl '. time();
                        $item->textNl = "My text \n***********\n Nl ". time();
                        $item->friendlyUrlNl = 'my-title-nl-'.time();
                    }
                }
            // END:

            }
        }

        $this->render($view,
            array(
            'item'=>$item,
            'itemUploads'=>$itemUploads,
            'extra'=>$extra
        ));
    }

    protected function generateFiles($basePath, $fileName, $tempFile, $fileType) {
        $tempFolder = dirname($tempFile);
        return Util::moveFolder($tempFolder, $basePath);
    }

}
