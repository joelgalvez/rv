<?php

class ItemUploadUploads extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'ItemUploadUploads':
	 * @var integer $itemUploadId
	 * @var string $filename
	 * @var string $path
	 * @var string $type
	 * @var string $extension
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
		return 'itemuploaduploads';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('filename','length','max'=>128),
			array('path','length','max'=>512),
			array('type','length','max'=>32),
			array('extension','length','max'=>8),
			array('filename, path, extension', 'required'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'itemUploadId'=>'Item Upload',
			'filename'=>'Filename',
			'path'=>'Path',
			'type'=>'Type',
			'extension'=>'Extension',
		);
	}
}