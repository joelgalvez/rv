<?php

class item extends CActiveRecord {

    var $_dontChangeDate;
/**
 * The followings are the available columns in table 'item':
 * @var integer $id
 * @var integer $itemId
 * @var integer $parentId
 * @var integer $localizationId
 * @var integer $commonLn
 * @var integer $namespaceId
 * @var integer $allowChild
 * @var integer $showChild
 * @var integer $categoryId
 * @var integer $uploadNr
 * @var integer $shared
 * @var integer $ownerId
 * @var integer $editorId
 * @var string $online
 * @var string $offline
 * @var string $title
 * @var string $text
 * @var integer $templateId
 * @var integer $hidden
 * @var string $friendlyUrl
 * @var string $modified
 */

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
        return 'item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
        array('title, titleNl','length','max'=>256),
        array('friendlyUrl, friendlyUrlNl','length','max'=>1024),
        array('friendlyUrl, friendlyUrlNl','isExist'),
        array('online, title, namespaceId, ownerId', 'required'),
        array('parentId, commonLn, year, allowChild, showChild, uploadNr, shared, templateId, hidden, dontChangeDate', 'numerical', 'integerOnly'=>true),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
        return array(
        'localization' => array(self::BELONGS_TO, 'localization', 'localizationId'),
        'namespace' => array(self::BELONGS_TO, 'ns', 'namespaceId'),
        'owner' => array(self::BELONGS_TO, 'User', 'ownerId'),
        'editor' => array(self::BELONGS_TO, 'User', 'editorId'),
        'category' => array(self::BELONGS_TO, 'category', 'categoryId'),
        'itemuploads' => array(self::HAS_MANY, 'ItemUpload', 'itemId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
        'id' => 'Id',
        'itemId' => 'Item Id',
        'parentId' => 'Parent Item',
        'localizationId' => 'Localization',
        'commonLn' => 'Common Language',
        'categoryFilter' => 'Category Filter',
        'userFilter' => 'User Filter',
        'namespaceId' => 'Namespace',
        'allowChild' => 'Allow Child',
        'showChild' => 'Show Child',
        'categoryId' => 'Category',
        'year' => 'Year',
        'uploadNr' => 'Upload Number',
        'shared' => 'Shared',
        'ownerId' => 'Owner',
        'editorId' => 'Editor',
        'online' => 'Online Date',
        'offline' => 'End Date',
        'title' => 'Title',
        'titleNl' => 'Title Nl',
        'text' => 'Text',
        'textNl' => 'Text Nl',
        'templateId' => 'Template',
        'hidden' => 'Hidden',
        'friendlyUrl' => 'Friendly Url',
        'friendlyUrlNl' => 'Friendly Url NL',
        'modified' => 'Modified',
        );
    }

    public function isExist($attr, $params) {
//        if(! $this->hasErrors()) {
//            if(item::model()->exists('( friendlyUrl=:friendlyUrl OR friendlyUrlNl=:friendlyUrl ) AND id != :id ',array(':friendlyUrl'=>$this->friendlyUrl,':id'=>$this->id)))
//                $this->addError('friendlyUrl', 'Friendly Url already Exist');
//        }
    }


    public function scopes()
    {
        return array(
            'onlineItems'=>array(
                'condition'=>"( item.online <= now() AND (item.offline= '0000-00-00 00:00:00' OR item.offline >= now()) )",
            ),
        );
    }

    public function getDefaultIfNull($withUpload) {
        $this->titleNl = Util::DefaultIfNull($this->titleNl, $this->title);
        $this->friendlyUrlNl = Util::DefaultIfNull($this->friendlyUrlNl, $this->friendlyUrl);
        $this->textNl = Util::DefaultIfNull($this->textNl, $this->text);

    }
    public function changeLocalization($withUpload = false) {
    //        if( $this->localizationId == 2)
    //        {
        $this->title = $this->titleNl;
        $this->text = $this->textNl;
        $this->friendlyUrl = $this->friendlyUrlNl;

        if($withUpload) {
            foreach($this->itemuploads as $upload) {
                $upload->getDefaultIfNull();
                $upload->changeLocalization();
            }
        }
    //        }
    }

    public function getDontChangeDate() {
        return $this->_dontChangeDate;
    }

    public function setDontChangeDate($dontChangeDate) {
        $this->_dontChangeDate = $dontChangeDate;
    }

    public function beforeValidate($on) {
          
            if(!$this->dontChangeDate){
            $this->modified = new CDbExpression('NOW()');
            } else {
                $this->modified = date("2001-".date("m").'-'.date("d"));
            }
        return true;
        }


}
