<?php

class localization extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'localization':
	 * @var integer $id
	 * @var string $name
	 * @var string $language
	 * @var string $culture
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
		return 'localization';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name','length','max'=>32),
			array('language','length','max'=>16),
			array('culture','length','max'=>32),
			array('name, language', 'required'),
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
			'items' => array(self::HAS_MANY, 'Item', 'localizationId'),
			'itemuploads' => array(self::HAS_MANY, 'Itemupload', 'localizationId'),
			'webtrees' => array(self::HAS_MANY, 'Webtree', 'localizationId'),
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
			'language' => 'Language',
			'culture' => 'Culture',
		);
	}
}