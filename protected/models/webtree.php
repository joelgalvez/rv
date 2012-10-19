<?php

class webtree extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'webtree':
	 * @var integer $id
	 * @var integer $parentId
	 * @var string $name
	 * @var integer $localizationId
	 * @var string $url
	 * @var string $friendlyUrl
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
		return 'webtree';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name','length','max'=>64),
			array('url','length','max'=>512),
			array('friendlyUrl','length','max'=>512),
			array('name, url', 'required'),
			array('parentId, position, deleted', 'numerical', 'integerOnly'=>true),
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
			'localization' => array(self::BELONGS_TO, 'Localization', 'localizationId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'parentId' => 'Parent',
			'name' => 'Name',
			'localizationId' => 'Localization',
			'url' => 'Url',
			'friendlyUrl' => 'Friendly Url',
                        'defaultPage' => 'Default Page',
                        'position' => 'Position',
			'modified' => 'Modified',
			'deleted' => 'Deleted',
		);
	}

        public function beforeSave()
        {
            if(isset($this->parentId) && $this->parentId != null && $this->parentId != 0)
            {
                $this->depth = webtree::model()->findByPk($this->parentId)->depth + 1;
            }else
            {
                 $this->depth = 0;
            }

            if($this->parentId == 0)
            {
                unset($this->parentId);
            }

            return true;
        }

        public function getTree($ln)
        {
            $criteria = new CDbCriteria();
            $criteria->order = "depth, parentId, position";

            if($ln != 0)
            {
                $criteria->condition = 'localizationId =:ln';
                $criteria->params = array('ln'=>$ln);
            }

            $items = webtree::model()->findAll($criteria);

            $new = array();

            foreach($items as $item)
            {
                if($item->parentId == null)
                {
                    $new[] = $item;
                    $new = $this->getChild($item->id, $new, $items);
                }
            }

            return $new;
        }

        protected function getChild($parentId, $tree, $items)
        {
            $new = $tree;
            foreach($items as $node)
            {
                if($node->parentId == $parentId)
                {
                    $new[] = $node;
                    $new = $this->getChild($node->id, $new, $items);
                }
            }

            return $new;
        }
}