<?php

class WebPage extends CModel {

    public function safeAttributes()
	{
		return $this->attributeNames();
	}

	public function attributeNames()
	{
		$className=get_class($this);
		if(!isset(self::$_names[$className]))
		{
			$class=new ReflectionClass(get_class($this));
			$names=array();
			foreach($class->getProperties() as $property)
			{
				$name=$property->getName();
				if($property->isPublic() && !$property->isStatic())
					$names[]=$name;
			}
			return self::$_names[$className]=$names;
		}
		else
			return self::$_names[$className];
	}

    static function getItemByNameOrId($itemId, $itemName, $localizationId  = 1 , $ns = 1)
    {
        $isFriendlyName = ($itemName)?true:false;

        if($ns == 1 || $ns == 3)
        {
            $_order = '??.position';
        }else
        {
            $_order = '??.priority desc, ??.modified desc, ??.position desc';
        }
        

        $model = item::model()->with(
                array('itemuploads'=>array(
                            'order'=>$_order
                        ),
                        'localization',
                        'namespace',
                        'category',
                        'owner',
                        'editor'
                    )
                );
        $item;

        if($isFriendlyName)
        {
            $fieldName = ($localizationId == 1)? 'friendlyUrl' : 'friendlyUrlNl';

            $criteria = new CDbCriteria;

            $criteria->condition = "$fieldName =:name";
            $criteria->params = array(':name'=>$itemName);

            $item = $model->find($criteria);
        }
        else
        {
            $item = $model->findByPk($itemId);
        }

        if($item)
        {
            $item->localizationId = $localizationId;
        }

        return $item;
    }


    static function getParentCondition($namespaceid = 0, $ob = ''){
        
        $criteria = new CDbCriteria;
        $criteria->condition = 'parentId = 0 and hidden = 0';

        if($namespaceid != 0)
            $criteria->condition .= ' and namespaceId = '. $namespaceid;

        $criteria->select = 'id,title,titleNl,friendlyUrl,friendlyUrlNl, namespaceId,modified,online,offline';
        $criteria->with = array("owner","editor");
        $criteria->order = 'modified desc';
        if ($ob == 'title') {
            if ($namespaceid == 1) {
                $criteria->order = 'titleNl';
            } else {
                $criteria->order = 'title';
            }
        }
        
        return $criteria;
    }

    static function getPagination($criteria){


        return $pages;
    }

    static function getParentItems($namespaceid = 0, &$pages, $ob="")
    {
        
        $criteria = WebPage::getParentCondition($namespaceid, $ob);
        $pages=new CPagination(item::model()->count($criteria));
	$pages->pageSize=30;
	$pages->applyLimit($criteria);
        
        return item::model()->findall($criteria);
    }


}
