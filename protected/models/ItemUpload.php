<?php

class ItemUpload extends CActiveRecord {
    var $_name;
    var $_otherPositions;

    /**
     * The followings are the available columns in table 'ItemUpload':
     * @var integer $id
     * @var string $type
     * @var integer $uploadSelectedItemId
     * @var integer $uploadBreakpoint
     * @var integer $uploadFilterCount
     * @var string $uploadFactbox
     * @var integer $itemId
     * @var string $title
     * @var string $text
     * @var integer $position
     * @var string $created
     * @var string $online
     * @var string $offline
     * @var integer $localizationId
     * @var integer $categoryId
     * @var integer $ownerId
     * @var integer $editorId
     * @var string $modified
     */

     //onsave modified check fields
     var $compareProperties = array(
         'uploadtype',
         'fileName',
//         'fileType',
//         'imageWidth',
//         'imageHeight',
//         'fileExtension',
         'videolink',
         'uploadSelectedItemId',
         'uploadBreakpoint',
         'uploadFilterCount',
         'factboxType',
         'maxUploadFetch',
         'title',
         'text',
         'position',
         'online',
         'offline',
         'localizationId',
         'categoryId',
         'namespaceId',
         'itemNamespaceId',
         'year',
         'userGroupId',
         'fileNameNl',
         'videolinkNl',
         'titleNl',
         'textNl',
         'priority'
     );

     var $customData;

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'itemupload';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
        array('title, titleNl','length','max'=>512),
        array('position', 'uniquePosition'),
        array('type, created, online, ownerId', 'required'),
        array('uploadBreakpoint, position', 'numerical', 'integerOnly'=>true),
        );
    }

    public function uniquePosition($attr, $params) {
        if(! $this->hasErrors()) {
            if(isset($this->otherPositions[$this->position]))
                $this->addError('position', "Two or more uploads can not have same positions, position: {$this->position}");
        }
    }
    /**
     * @return array relational rules.
     */
    public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
        return array(
        'uploadSelectedItem' => array(self::BELONGS_TO, 'item', 'uploadSelectedItemId'),
        'localization' => array(self::BELONGS_TO, 'Localization', 'localizationId'),
        'category' => array(self::BELONGS_TO, 'Category', 'categoryId'),
        'owner' => array(self::BELONGS_TO, 'User', 'ownerId'),
        'editor' => array(self::BELONGS_TO, 'User', 'editorId'),
        'item' => array(self::BELONGS_TO, 'item', 'itemId'),
        'itemUploadFilters' => array(self::HAS_MANY, 'ItemUploadFilter', 'itemUploadId'),
        'itemUploadUploads' => array(self::HAS_MANY, 'ItemUploadUploads', 'itemUploadId'),
        'itemUploadUsers' => array(self::HAS_MANY, 'ItemUploadUser', 'itemUploadId'),
        );
    }

    public function getName() {
        if($this->_name == null)
        {
            $this->_name = $this->title;
        }
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getOtherPositions() {
        return $this->_otherPositions;
    }

    public function setOtherPositions($otherPositions) {
        $this->_otherPositions = $otherPositions;
    }

    public function scopes() {
        return array(
        'onlineUploads'=>array(
        'condition'=>"( ??.online <= now() AND (??.offline= '0000-00-00 00:00:00' OR ??.offline >= now()) )",
        ),
        'onlineUpload'=>array(
        'condition'=>"( online <= now() AND (offline= '0000-00-00 00:00:00' OR offline >= now()) )",
        ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
        'id'=>'Id',
        'type'=>'Type',
        'uploadtype'=>'Upload Type',
        'fileName'=>'File Name',
        'filePath'=>'File Path',
        'fileExtenstion'=>'File extenstion',
        'fileType'=>'File Type',
        'videolink'=>'Video Link',
        'fileNameNl'=>'File Name NL',
        'filePathNl'=>'File Path NL',
        'fileExtenstionNl'=>'File extenstion NL',
        'fileTypeNl'=>'File Type NL',
        'videolinkNl'=>'Video Link Nl',
        'maxUploadFetch'=>'Max Upload Fetch',
        'uploadSelectedItemId'=>'Upload Selected Item',
        'uploadBreakpoint'=>'Upload Breakpoint',
        'uploadFilterCount'=>'Upload Filter Count',
        'uploadFactbox'=>'Upload Factbox',
        'itemId'=>'Item',
        'title'=>'Title',
        'titleNl'=>'Title NL',
        'text'=>'Text',
        'textNl'=>'Text NL',
        'position'=>'Position',
        'created'=>'Created',
        'online'=>'Online',
        'offline'=>'Offline',
        'localizationId'=>'Localization',
        'categoryId'=>'Category',
        'namespaceId'=>'Namespace',
        'userGroupId'=>'User Group',
        'year'=>'Year',
        'ownerId'=>'Owner',
        'editorId'=>'Editor',
        'modified'=>'Modified',
        );
    }

    public function getUploadTypes() {
        $connection = Yii::app()->db;
        $command = $connection->createCommand("show columns from itemupload  where Field = 'type';");
        $row = $command->queryRow();
        $enum = $row['Type'];


        $start = strpos($enum,"(")+1;
        $end = strpos($enum,")");

        $enum = substr($enum,$start,$end-$start);
        $enum = str_replace("'","",$enum);
        $enum = explode(',',$enum);

        $finalEnum = array();

        foreach($enum as $k=>$v)
            $finalEnum[$v] = $v;

        return $finalEnum;
    }


    public function getUsers() {
        $userCount = ItemUploadUser::model()->count("itemUploadId = :id", array(":id"=>$this->id));
        if($userCount == 0) {
            $criteria = UserFilter::getFilterCondition($this->userGroupId, $this->categoryId, $this->year, $this->uploadFilterCount);

            $users = UserInfo::model()->findAll($criteria);

            return $users;
        }else {
            return  ItemUploadUsersInfo::model()->findAll("uploadId = :id", array(":id"=>$this->id));
        }
    }


    public function getDefaultIfNull() {
        $this->fileNameNl = Util::DefaultIfNull($this->fileNameNl, $this->fileName);
        $this->filePathNl = Util::DefaultIfNull($this->filePathNl, $this->filePath);
        $this->fileTypeNl = Util::DefaultIfNull($this->fileTypeNl, $this->fileType);
        $this->fileExtensionNl = Util::DefaultIfNull($this->fileExtensionNl, $this->fileExtension);
        $this->videoLinkNl = Util::DefaultIfNull($this->videoLinkNl, $this->videolink);
        $this->imageWidthNl = Util::DefaultIfNull($this->imageWidthNl, $this->imageWidth);
        $this->imageHeightNl = Util::DefaultIfNull($this->imageHeightNl, $this->imageHeight);
        $this->titleNl = Util::DefaultIfNull($this->titleNl, $this->title);
        $this->textNl = Util::DefaultIfNull($this->textNl, $this->text);;
    }


    public function changeLocalization() {
        $this->fileName = $this->fileNameNl;
        $this->filePath = $this->filePathNl;
        $this->fileType = $this->fileTypeNl;
        $this->fileExtension = $this->fileExtensionNl;
        $this->videolink = $this->videoLinkNl;
        $this->imageWidth = $this->imageWidthNl;
        $this->imageHeight = $this->imageHeightNl;
        $this->title = $this->titleNl;
        $this->text = $this->textNl;
    }

//    public function beforeValidate($on) {
//        $this->modified = new CDbExpression('NOW()');
//        return true;
//    }

    public function isModified($orginal) {
        foreach($this->compareProperties as $key)
        {
            if(isset($this->$key))
            {
                if($this->$key != $orginal->$key)
                {
                    return true;
                }
            }
        }

        return false;
    }

    public function setAsModified()
    {
        $this->modified = new CDbExpression('NOW()');
    }

}