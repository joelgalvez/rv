<?php

class UserInfo extends CActiveRecord
{
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'userinfo';
    }

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
}