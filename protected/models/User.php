<?php

class User extends CActiveRecord
{
        /**
         * The followings are the available columns in table 'User':
         * @var integer $id
         * @var string $userId
         * @var integer $groupId
         * @var integer $categoryId
         * @var string $email
         * @var string $password
         * @var integer $year
         * @var integer $active
         * @var integer $graduated
         * @var string $modified
         */

    private $_categories;
        /**
         * Returns the static model of the specified AR class.
         * @return CActiveRecord the static model class
         */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

        /**
         * @return string the associated database table name
         */
    public function tableName()
    {
        return 'user';
    }

        /**
         * @return array validation rules for model attributes.
         */
    public function rules()
    {
        return array(
            array('userId, name','length','max'=>256),
            array('email','isExist'),
            array('email','isExistUserId'),
            array('friendlyName','isExistName'),
            array('email','length','max'=>512),
            array('password','length','max'=>512),
            array('email, password, name, friendlyName, userId', 'required'),
            array('year, active, graduated', 'numerical', 'integerOnly'=>true),
        );

    }

        /**
         * @return array relational rules.
         */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                        'items' => array(self::HAS_MANY, 'Item', 'editorId'),
                        'itemUploads' => array(self::HAS_MANY, 'ItemUpload', 'editorId'),
                        'itemUploadUsers' => array(self::HAS_MANY, 'ItemUploadUser', 'userId'),
                        'category' => array(self::BELONGS_TO, 'category', 'categoryId'),
                        'group' => array(self::BELONGS_TO, 'UserGroup', 'groupId'),
        );
    }

        /**
         * @return array customized attribute labels (name=>label)
         */
    public function attributeLabels()
    {
        return array(
                        'id'=>'Id',
                        'name'=>'Name',
                        'userId'=>'External id',
                        'groupId'=>'Group',
                        'categories'=>'Categories',
                        'categoryId'=>'Category',
                        'email'=>'Email',
                        'password'=>'Password',
                        'year'=>'Current year',
                        'friendlyName'=>'Friendly Name',
                        'active'=>'Active',
                        'graduated'=>'Graduated',
                        'modified'=>'Modified',
        );
    }

    public function readCategories()
    {
        $c = array();

        if(isset($this->categoryId) && $this->categoryId != null){$c[] = $this->categoryId;}
        if(isset($this->categoryId1) && $this->categoryId1 != null){$c[] = $this->categoryId1;}
        if(isset($this->categoryId2) && $this->categoryId2 != null){$c[] = $this->categoryId2;}
        if(isset($this->categoryId3) && $this->categoryId3 != null){$c[] = $this->categoryId3;}
        if(isset($this->categoryId4) && $this->categoryId4 != null){$c[] = $this->categoryId4;}

        $this->categories = $c;
        return $c;
    }

    public function swapCategories()
    {
        $c = $this->categories;

        if(isset($c[0]) && $c[0] != null) {$this->categoryId = $c[0];} else {$this->categoryId = 0;}
        if(isset($c[1]) && $c[1] != null) {$this->categoryId1 = $c[1];} else {$this->categoryId1 = 0;}
        if(isset($c[2]) && $c[2] != null) {$this->categoryId2 = $c[2];} else {$this->categoryId2 = 0;}
        if(isset($c[3]) && $c[3] != null) {$this->categoryId3 = $c[3];} else {$this->categoryId3 = 0;}
        if(isset($c[4]) && $c[4] != null) {$this->categoryId4 = $c[4];} else {$this->categoryId4 = 0;}
    }

    public function beforeValidate($on) {
        $this->swapCategories();
        return true;
    }

    public function isExist($attr, $params)
    {
        if(! $this->hasErrors())
        {
            if(empty($this->id)) {
                if(User::model()->exists('email=:email',array(':email'=>$this->email)))
                $this->addError('email', 'User email already Exist');
            } else {
                if(User::model()->exists('email=:email AND id!=:id',array(':email'=>$this->email, ':id'=>$this->id)))
                $this->addError('email', 'User email already Exist');
            }
        }
    }

    public function isExistUserId($attr, $params)
    {
        if(! $this->hasErrors())
        {
            if(empty($this->id)) {
                if(User::model()->exists('userId=:userid',array(':userid'=>$this->userId)))
                $this->addError('userid', 'User id already Exist');
            } else {
                if(User::model()->exists('userId=:userid AND id!=:id',array(':userid'=>$this->userId, ':id'=>$this->id)))
                $this->addError('userid', 'User id already Exist');
            }
        }
    }

    public function isExistName($attr, $params)
    {
        if(! $this->hasErrors())
        {
            if(User::model()->exists('friendlyName=:friendlyName AND id!=:id',array(':friendlyName'=>$this->friendlyName, ':id'=>$this->id)))
            $this->addError('friendlyName', 'User friendlyName already Exist');
        }
    }

    public static function initUser()
    {
        $basePath = User::getUserBasePath();

        if( ! file_exists($basePath))
        {
            mkdir($basePath);
        }

    }

    public static function getUserBasePath()
    {
        return  dirname($_SERVER['SCRIPT_FILENAME']).
                Yii::app()->params['uploadFolder'].
                Yii::app()->user->id . '/';
    }

    public static function getUserWebPath()
    {
        return  Yii::app()->params['appName'].
                Yii::app()->params['uploadFolder'].
                Yii::app()->user->id . '/';
    }

    //    static function parse($data)
    //    {
    //        $user = new User;
    //        $user->userId = $data[]
    //    }
}