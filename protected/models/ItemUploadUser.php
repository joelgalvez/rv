<?php

class ItemUploadUser extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'ItemUploadUser':
	 * @var integer $itemUploadId
	 * @var integer $userId
	 * @var integer $userGroupId
	 */

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
		return 'itemuploaduser';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
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
			'itemUpload' => array(self::BELONGS_TO, 'ItemUpload', 'itemUploadId'),
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
			'userGroup' => array(self::BELONGS_TO, 'UserGroup', 'userGroupId'),
                        //'userinfo' => array(self::BELONGS_TO, 'UserInfo', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'itemUploadId'=>'Item Upload',
			'userId'=>'User',
			'userGroupId'=>'User Group',
		);
	}
}