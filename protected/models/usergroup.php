<?php

class usergroup extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'usergroup':
	 * @var integer $id
	 * @var string $name
	 * @var string $modified
	 * @var integer $deleted
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
		return 'usergroup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name','length','max'=>256),
			array('name', 'required'),
			array('deleted', 'numerical', 'integerOnly'=>true),
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
			'itemuploadusers' => array(self::HAS_MANY, 'Itemuploaduser', 'userGroupId'),
			'users' => array(self::HAS_MANY, 'User', 'groupId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'modified' => 'Modified',
			'deleted' => 'Deleted',
		);
	}
}