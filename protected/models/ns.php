<?php

class ns extends CActiveRecord {
  /**
   * The followings are the available columns in table 'namespace':
   * @var integer $id
   * @var string $name
   * @var integer $commonLn
   * @var integer $allowChildren
   * @var integer $showChildren
   * @var integer $yearDimension
   * @var integer $categoryFilter
   * @var integer $userFilter
   * @var integer $shared
   */

  const PAGE       = 1;
  const NEWS       = 2;
  const PROJECT    = 3;
  const GRADUATION = 4;
  const CUSTOM     = 5;
  
  /**
   * Returns the static model of the specified AR class.
   * @return CActiveRecord the static model class
   */
  public static function model($className = __CLASS__){
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName(){
    return 'namespace';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules(){
    return array(
      array(
        'name', 'length', 'max' => 256
      ),
      array(
        'name', 'required'
      ),
      array(
        'commonLn, allowChildren, showChildren, yearDimension, categoryFilter, userFilter, shared',
        'numerical',
        'integerOnly' => true
      ),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations(){
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'items' => array(
        self::HAS_MANY, 'Item', 'namespaceId'
      ),
      'itemuploadfilters' => array(
        self::HAS_MANY, 'Itemuploadfilter', 'namespaceId'
      ),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels(){
    return array(
      'id' => 'Id',
      'name' => 'Name',
      'commonLn' => 'Common Ln',
      'allowChildren' => 'Allow Children',
      'showChildren' => 'Show Children',
      'yearDimension' => 'Year Dimension',
      'categoryFilter' => 'Category Filter',
      'userFilter' => 'User Filter',
      'shared' => 'Shared',
    );
  }
}
