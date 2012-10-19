<?php

class UserController extends CController {
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
        'actions'=>array('show','update','autoCompleteLookup', 'filter' ),
        //TODO: this should be changee to verfiy the actul user updating it
        'roles'=>array('authenticated'),
        ),
        array('allow',
        'actions'=>array('create', 'adminUpdate', 'list','admin','delete', 'import', 'importStaff', 'addfriendly'),
        'roles'=>array('administrator'),
        ),
        array('allow',
        'actions'=>array('userInfo','forgotPassword','changePassword'),
        'users'=>array('*'),
        ),
        array('deny',
        'users'=>array('*'),
        ),
        );
    }

    public function actionAutoCompleteLookup() {
        if(Yii::app()->request->isAjaxRequest && isset($_GET['q'])) {
            $name = $_GET['q'];
            $limit = min($_GET['limit'], 50);
            $criteria = new CDbCriteria;
            $criteria->condition = "name LIKE :sterm";
            $criteria->params = array(":sterm"=>"%$name%");
            $criteria->limit = $limit;
            $userArray = User::model()->findAll($criteria);
            $returnVal = '';
            foreach($userArray as $userAccount) {
                $returnVal .= $userAccount->name.'|'
                    .$userAccount->id."\n";
            }
            echo $returnVal;
        }
    }

    public function actionFilter() {
        $userGroup = Util::Get('ug', '');
        $category = Util::Get('c', '');
        $year = Util::Get('y', '');
        $max = Util::Get('max', 50);

        $criteria = UserFilter::getFilterCondition($userGroup, $category, $year, $max);
        $criteria->select = 'name, userId, year, id';

        $userArray = UserInfo::model()->findAll($criteria);

        $users = array();

        foreach($userArray as $_user) {
            $users[] = array(
                'id'=> $_user->id,
                'name'=> CHtml::encode($_user->name),
                'userId'=> $_user->userId,
                'year'=> $_user->year,
                //'categoryName'=> ( ($_user->category != null)? $_user->category->name : '' ),
                'categoryName'=>$_user->categoryName
            );
        }


        //print_r($users);
        echo CJSON::encode($users);

    }

    /**
     * Shows a particular model.
     */
    public function actionShow() {
        $this->render('show',array('model'=>$this->loadUser()));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'show' page.
     */
    public function actionCreate() {
    //        if(!Yii::app()->user->isGuest)
    //        $this->redirect(array('user/update'));

        $model=new User;
        if(isset($_POST['User'])) {
            $model = $this->processUpdate($model);
            if($model->save()) {
                if(Yii::app()->user->isGuest)
                    $this->redirect(array('site/login'));
                else
                    $this->redirect(array('show','id'=>$model->id));
            }
            else {
                $model->password = '';
            }
        //$this->redirect(array('show','id'=>$model->id));
        }

        $this->render('create',array('model'=>$model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'show' page.
     */
    public function actionUpdate() {
        $model=$this->loadUser();
        if(isset($_POST['User'])) {
            $model = $this->processUpdate($model);

            //$externalId = User::model()->find("userId = :id", array(':id'=>$model->userId));
            

            //$model->save();
            if($model->save())
                $this->redirect(array('show','id'=>$model->id));
        }else {
            $model->readCategories();
        }

        $model->password = '';
        $this->render('update',array('model'=>$model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     */
    public function actionDelete() {
        if(Yii::app()->request->isPostRequest) {
        // we only allow deletion via POST request
            $this->loadUser()->delete();
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

        $pages=new CPagination(User::model()->count($criteria));
        $pages->pageSize=self::PAGE_SIZE;
        $pages->applyLimit($criteria);

        $models=User::model()->findAll($criteria);

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

        $pages=new CPagination(User::model()->count($criteria));
        $pages->pageSize=self::PAGE_SIZE;
        $pages->applyLimit($criteria);

        $sort=new CSort('User');
        $sort->applyOrder($criteria);

        $models=User::model()->findAll($criteria);

        $this->render('admin',array(
            'models'=>$models,
            'pages'=>$pages,
            'sort'=>$sort,
        ));
    }

    public function actionImport() {
    //if($_POST['user']) {
        if (!empty($_FILES)) {
            $file = CUploadedFile::getInstanceByName("filePath");
            $gradyear = $_POST['gradyear'];

            error_reporting(E_ALL ^ E_NOTICE);
            $data = new Spreadsheet_Excel_Reader($file->tempName);

            $importSql = '';
            $categoryCode = array (
                "DZBJ1" => "DOGtime Basisjaar 1",
                "DZBJ2" => "DOGtime Basisjaar 2",
                "DZBK" => "DOGtime Beeldende Kunst",
                "DZMM" => "DOGtime ID UM",
                "ORC2" => "Orientatiejaar",
                "VOAV" => "VAV",
                "VOBA" => "Architectonisch Ontwerp",
                "VOBJ" => "Basisjaar",
                "VOBK" => "Beeldende Kunst",
                "VOED" => "Sieradenafdeling",
                "VOFO" => "Fotografie",
                "VOGL" => "Glas",
                "VOGO" => "Grafisch Ontwerp",
                "VOID" => "DesignLAB",
                "VOKR" => "Keramiek",
                "VOMD" => "Mode",
                "VOOR" => "Preparatory Course",
                "VOSA" => "Beeld en Taal",
                "VOTE" => "TxT (Textiel)"
            );
            $categoryIds = array();

            $groupId = usergroup::model()->find('name =:name ', array(':name'=>'student' ) )->id;
            $connection = Yii::app()->db;
            $results = array();
            $name = '';
            //            for($i =1; $i < $data->rowcount(1); $i++) {
            Yii::trace($data->rowcount());
            for($i = 1; $i < $data->rowcount(); $i++) {

                try {
                    $year = $data->val($i,13);

                    if($year != 'M') {

                        $userid = $data->val($i,5);
                        $email =$data->val($i,19);
                        $password = md5(Util::createRandomPassword());
                        $name = $data->val($i,8);
                        $midname = $data->val($i,7);

                        if (!empty($midname)) {
                            $name = $name. ' ' .$midname;
                        }
                        $name = $name. ' ' .$data->val($i,6);

                        $category = $data->val($i,11);

                        if (substr($category,0,4) == 'DZBJ') {
                            $category = substr($category,0,5);
                        } else {
                            $category = substr($category,0,4);
                        }
                        if($categoryIds[$category] == null) {
                            $catId = category::model()->find('name =:name ', array(':name'=>$categoryCode[$category] ) )->id;
                            $categoryIds[$category] = $catId;
                        }
                        $graduated = $data->val($i,12);
                        if($graduated == 'VZ') {
                            $active = 0;
                            $graduated = 0;
                        } elseif ($graduated == 'VM') {
                            $active = 0;
                            $graduated = 1;
                            if (!empty($gradyear)) {
                                $year = $gradyear;
                            }
                        } else {
                            $active = 1;
                            $graduated = 0;
                        }


                        $name = trim($name);
                        $strAt = strchr($email,'@');

                        if(empty($email) || empty($name) || empty($userid) || empty($strAt)) {
                            Yii::trace("was empty");
                            $results[] = array('status'=>false, 'name'=>$name, 'studentid'=>$userid,  'msg'=>false );
                        } else {


                            $_friendlyName = Util::getFriendlyString2($name);

                            $_ncount =  User::model()->count("name = :name", array(':name'=>$name));

                            if($_ncount > 0) {
                                $_friendlyName .= $_ncount;
                            }

                            $importCmd = $connection->createCommand("INSERT INTO user (userId, groupId, categoryId, name, email, password, year, active, graduated, friendlyName)".
                                " VALUES (:userid, :groupId, :categoryId, :name, :email, :password, :year, :active, :graduated, :friendlyName)".
                                " ON DUPLICATE KEY UPDATE email = :email, year = :year, categoryId = :categoryId, active = :active, graduated = :graduated;" );
                            $importCmd->bindParam(':userid',$userid);
                            $importCmd->bindParam(':groupId' , $groupId);
                            $importCmd->bindParam(':categoryId' , $categoryIds[$category]);
                            $importCmd->bindParam(':name', $name);
                            $importCmd->bindParam(':email' , $email);
                            $importCmd->bindParam(':password' , $password);
                            $importCmd->bindParam(':year' , $year);
                            $importCmd->bindParam(':active' , $active);
                            $importCmd->bindParam(':graduated' , $graduated);
                            $importCmd->bindParam(':friendlyName' , $_friendlyName);

                            $importCmd->execute();
                        }
                    }
                }catch(Exception $e) {
                    $results[] = array('status'=>false, 'name'=>'>'. $_friendlyName, 'studentid'=>$userid, 'msg'=>false );
                }
            }

            // $command = $connection->createCommand($importSql);




            $this->render('import', array('results'=> $results));


        }else {

            $this->render('import');
        }
    }

    public function actionImportStaff() {
    //if($_POST['user']) {
        if (!empty($_FILES)) {
            $file = CUploadedFile::getInstanceByName("filePath");
            error_reporting(E_ALL ^ E_NOTICE);
            $data = new Spreadsheet_Excel_Reader($file->tempName);

            $importSql = '';
            $categoryCode = array (
                "DZBJ1" => "DOGtime Basisjaar 1",
                "DZBJ2" => "DOGtime Basisjaar 2",
                "DZBK" => "DOGtime Beeldende Kunst",
                "DZMM" => "DOGtime ID UM",
                "ORC2" => "Orientatiejaar",
                "VOAV" => "VAV",
                "VOBA" => "Architectonisch Ontwerp",
                "VOBJ" => "Basisjaar",
                "VOBK" => "Beeldende Kunst",
                "VOED" => "Sieradenafdeling",
                "VOFO" => "Fotografie",
                "VOGL" => "Glas",
                "VOGO" => "Grafisch Ontwerp",
                "VOID" => "DesignLAB",
                "VOKR" => "Keramiek",
                "VOMD" => "Mode",
                "VOOR" => "Preparatory Course",
                "VOSA" => "Beeld en Taal",
                "VOTE" => "TxT (Textiel)"
            );
            $categoryIds = array();
            $categoryIds['NA'] = NULL;
            $groupId = usergroup::model()->find('name =:name ', array(':name'=>'teacher' ) )->id;
            $connection = Yii::app()->db;
            $results = array();
            $name = '';
            //            for($i =1; $i < $data->rowcount(1); $i++) {
            Yii::trace($data->rowcount());
            for($i = 1; $i < $data->rowcount(); $i++) {

                try {
                    $email =$data->val($i,13);
                    $password = md5(Util::createRandomPassword());
                    $name = $data->val($i,5);
                    $midname = $data->val($i,4);

                    if (!empty($midname)) {
                        $name = $name. ' ' .$midname;
                    }
                    $name = $name. ' ' .$data->val($i,3);

                    //echo $i.' name: '.$name.' email: '.$email.'<br>';
                    $category = $data->val($i,11);

                    if (!empty($category)) {

                        if (substr($category,0,4) == 'DZBJ') {
                            $category = substr($category,0,5);
                        } else {
                            $category = substr($category,0,4);
                        }
                        if($categoryIds[$category] == null) {
                            $catId = category::model()->find('name =:name ', array(':name'=>$categoryCode[$category] ) )->id;
                            $categoryIds[$category] = $catId;
                        }
                    } else {
                        $category = 'NA';
                    }



                    $active = 1;

                    $name = trim($name);

                    $strAt = strchr($email,'@');
                    if(empty($email) || empty($name) || empty($strAt)) {
                        Yii::trace("was empty");
                        $results[] = array('status'=>false, 'name'=>$name, 'msg'=>false );
                    } else {


                        $_friendlyName = Util::getFriendlyString2($name);

                        $_ncount =  User::model()->count("name = :name", array(':name'=>$name));

                        if($_ncount > 0) {
                            $_friendlyName .= $_ncount;
                        }

                        $importCmd = $connection->createCommand("INSERT INTO user (groupId, categoryId, name, email, password, active, friendlyName)".
                            " VALUES (:groupId, :categoryId, :name, :email, :password, :active, :friendlyName)".
                            " ON DUPLICATE KEY UPDATE email = :email, categoryId = :categoryId, active = :active;" );
                        $importCmd->bindParam(':groupId' , $groupId);
                        $importCmd->bindParam(':categoryId' , $categoryIds[$category]);
                        $importCmd->bindParam(':name', $name);
                        $importCmd->bindParam(':email' , $email);
                        $importCmd->bindParam(':password' , $password);
                        $importCmd->bindParam(':active' , $active);
                        $importCmd->bindParam(':friendlyName' , $_friendlyName);

                        $importCmd->execute();
                    }

                }catch(Exception $e) {
                    $resuts[] = array('status'=>false, 'name'=>'>'. $_friendlyName, 'msg'=>false );
                }
            }

            // $command = $connection->createCommand($importSql);




            $this->render('import', array('results'=> $results));


        }else {

            $this->render('import');
        }
    }


    public function actionAddFriendly() {
        $users = User::model()->findAll("friendlyName = ''");
        foreach($users as $user) {

            $_friendlyName = Util::getFriendlyString2($user->name);
            $_friendlyName = strtolower($_friendlyName);

            //$_ncount =  User::model()->count("friendlyName like :friendlyName%", array(':friendlyName'=>$_friendlyName));
            $_ncount =  User::model()->count('friendlyName like :friendlyName', array(':friendlyName'=>$_friendlyName.'%'));


            if($_ncount > 0) {
                $_friendlyName .= $_ncount;
            }
            //echo $_friendlyName;

            $user->friendlyName = $_friendlyName;
            $user->update();
        }

    }

    public function actionUserInfo() {
        $uname = Util::Get('uname', '');

        if($uname != '') {
            $user = User::model()->find("friendlyName=:userId", array(':userId'=>$uname));

            if($user != null) {
            //$items = item::model()->with('itemuploads')->findAll("(ownerId=:ownerId) and ( namespaceId=3 or namespaceId=4 )", array(':ownerId'=>$user->id));

                unset(Yii::app()->request->cookies['enUrl']);
                unset(Yii::app()->request->cookies['nlUrl']);
                $this->render('userInfo', array('user'=> $user));//, 'items'=> $items));
                return;
            }
        }

        throw new CHttpException(500,'User does not exist.');
    }

    public function actionForgotPassword() {
        $error = array();
        $email = Util::GetPost('email');

        if($email) {
            $user = User::model()->find("email=:email", array(':email'=>$email));

            if($user == null) {
                $error[] = 'User with this email is not found';
            }else if($this->canResetPassword($user)) {
                    $passwd = Util::createRandomPassword();
                    $subject = "Password change requested";
                    $url = "http://". $_SERVER["HTTP_HOST"] . Yii::app()->createUrl('user/changePassword',array('key'=>$passwd));
                    $body = "Hi {$user->name},\r\n Click this url to change the password \r\n $url \r\nRegards,\r\nWebmaster";
                    $fromEmail = Yii::app()->params['adminEmail'];
                    $headers="From: {$fromEmail}\r\nReply-To: {$fromEmail}";

                    if($user->requested <= Yii::app()->params['maxChangeRequest'])
                        $user->requested++;
                    else
                        $user->requested = 1;

                    $user->lastRequested = new CDbExpression('NOW()');
                    $user->modified = new CDbExpression('NOW()');
                    $user->pwdResetkey = md5($passwd);
                    $user->update();

                    if(!mail($email, $subject, $body, $headers)) {
                        $error[] = 'Error while sending mail';
                    }
                }else {
                    $error[] = 'Too many attempts to reset the password';
                }
        }

        $this->render('forgotPassword', array('error'=>$error));
    }

    public function actionChangePassword() {
        $error = array();
        $showForm = false;
        $key = Util::Get('key');

        $pwd = Util::GetPost('pwd');
        $cPwd = Util::GetPost('cpwd');
        $pkey = Util::GetPost('key');

        if($pwd != null && $cPwd != null &&  $pkey != null) {

            if($pwd != $cPwd) {
                $error[] = 'Password does not match';
                $showForm = true;
            }else {

                $pwdKey = md5($pkey);
                $user = User::model()->find("pwdResetkey=:key", array(':key'=>$pwdKey));

                if($user == null) {
                    $error[] = 'Invalid key provided';
                }else {

                    $user->pwdResetkey = '';
                    $user->password = md5($pwd);
                    $user->modified = new CDbExpression('NOW()');
                    $user->update();
                }
            }

        }else if($key != null  && $key != '') {
                $pwdKey = md5($key);
                $user = User::model()->find("pwdResetkey = :key", array(':key'=>$pwdKey));

                if($user == null) {
                    $error[] = 'Invalid key provided';
                }else {
                    $showForm = true;
                }
            }else {
                $error[] = 'Invalid action';
            }

        $this->render('changePassword', array('error'=>$error,'showForm'=>$showForm));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     */
    public function loadUser($id=null) {
        if($id!==null || isset($_GET['id']))
            $this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
        else
            $this->_model=User::model()->findbyPk(Yii::app()->user->id);
        if($this->_model===null)
            throw new CHttpException(500,'User does not exist.');
        return $this->_model;
    }

    protected function canResetPassword($user) {
        if($user->requested < Yii::app()->params['maxChangeRequest'])
            return true;

        $date = new DateTime($user->lastRequested);

        $diff = date_create()->diff($date);

        if($diff->d > 1)
            return true;

        return false;
    }

    /**
     * Executes any command triggered on the admin page.
     */
    protected function processAdminCommand() {
        if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete') {
            $this->loadUser($_POST['id'])->delete();
            // reload the current page to avoid duplicated delete actions
            $this->refresh();
        }
    }

    protected function processUpdate($model) {
        $model->attributes=$_POST['User'];

        $model->password = md5($model->password);

        $_friendlyName = strtolower(Util::getFriendlyString2($model->name));

        $_ncount =  User::model()->count("name = :name", array(':name'=>$model->name));

        if($_ncount > 0) {
            $_friendlyName .= $_ncount;
        }

        $model->friendlyName = $_friendlyName;

        // if($model->groupId == 0)
        // unset($model->groupId);

//        if($model->categoryId == 0)
//            unset($model->categoryId);

        return $model;
    }
}
