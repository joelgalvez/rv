<?php

class category_v extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'category_v':
	 * @var integer $id
	 * @var string $name
	 * @var integer $childid
	 * @var string $childname
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
		return 'category_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name','length','max'=>256),
			array('childname','length','max'=>256),
			array('name', 'required'),
			array('id, childid', 'numerical', 'integerOnly'=>true),
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
			'childid' => 'Childid',
			'childname' => 'Childname',
		);
	}

        public function getTree()
        {
            $data = category_v::model()->findAll();
            $tree = array();

            foreach($data as $d)
            {
                if(isset($tree[$d->id]))
                {
                    $tree[$d->id]['children'][$d->childid] = $d->childname;
                }else
                {
                    $tree[$d->id] = array(
                        'name' => $d->name,
                        'id' => $d->id,
                        'children' => array($d->childid=>$d->childname)
                    );
                    
                }
            }

            return $tree;
        }
}