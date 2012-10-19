<?php

class category extends CActiveRecord {
/**
 * The followings are the available columns in table 'category':
 * @var integer $id
 * @var integer $parentId
 * @var string $name
 * @var string $modified
 * @var integer $deleted
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
        return 'category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
        array('name','length','max'=>256),
        array('name', 'required'),
        array('parentId, deleted', 'numerical', 'integerOnly'=>true),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
        return array(
        'items' => array(self::HAS_MANY, 'Item', 'categoryId'),
        'itemuploads' => array(self::HAS_MANY, 'Itemupload', 'categoryId'),
        'itemuploadfilters' => array(self::HAS_MANY, 'Itemuploadfilter', 'categoryId'),
        'users' => array(self::HAS_MANY, 'User', 'categoryId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
        'id' => 'Id',
        'parentId' => 'Parent',
        'name' => 'Name',
        'modified' => 'Modified',
        'deleted' => 'Deleted',
        );
    }

    static function getCategoryFilter() {
        $categories = '';

        if(!Yii::app()->authManager->isAssigned('administrator', Yii::app()->user->id)) {
            $user = User::model()->findByPk(Yii::app()->user->id);

            if($user->categoryId != null && $user->categoryId != 0) {$categories = 'id='.$user->categoryId;}

            if($user->categoryId1 != null && $user->categoryId1 != 0) {
                if($categories != '') {$categories .= ' OR ';}
                $categories .= 'id='.$user->categoryId1;
            }

            if($user->categoryId2 != null && $user->categoryId2 != 0) {
                if($categories != '') {$categories .= ' OR ';}
                $categories .= 'id='.$user->categoryId2;
            }

            if($user->categoryId3 != null && $user->categoryId3 != 0) {
                if($categories != '') {$categories .= ' OR ';}
                $categories .= 'id='.$user->categoryId3;
            }

            if($user->categoryId4 != null && $user->categoryId4 != 0) {
                if($categories != '') {$categories .= ' OR ';}
                $categories .= 'id='.$user->categoryId4;
            }
        }

        return ($categories == '')?null:$categories;
    }
}