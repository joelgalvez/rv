<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class GraduationFilter extends CWidget {

    public $enableAjax = false;

    public $enableYear = false;
    public $enableCategory = false;
    public $enableUser = false;

    public $selectedYear = null;
    public $selectedCategory = null;
    public $selectedUser = null;

    public $friendlyUrl = '';
    public $itemId = null;
    public $maxYear = null;

    public $_ns = 4;


    public function run()
    {

        if($this->enableYear || $this->enableCategory || $this->enableUser)
        {
        $years = array();
        $categories = array();
        $users = array();

        $this->selectedYear = Util::Get('y', null);
        $this->selectedCategory = Util::Get('cc', null);
        $this->selectedUser = strtolower(Util::Get('uu', null));


        /* default namespace is 4 */
        /* To support filters on more pages add the page id in the check below */
        $nsId = 4;
        if (!is_null($this->itemId)) {
            if($this->itemId == 63) {
                $nsId = 3;
            }
        }
        $this->_ns = $nsId;


        $this->selectedYear = $this->selectedYear == 0 ? null : $this->selectedYear;
        $this->selectedCategory = $this->selectedCategory == '' ? null : $this->selectedCategory;
        $this->selectedUser = $this->selectedUser == '' ? null : $this->selectedUser;

        
        if(! $this->enableAjax)
        {
            if($this->enableYear)
            {
                $criteria = new CDbCriteria();
                $criteria->distinct = true;

                //$years[0] = 'All';
                $maxCondition = '';
                if ($this->maxYear) {
                    $maxCondition = ' AND year <= '.$this->maxYear;
                }

                $criteria->select = 'year';
                $criteria->condition = "namespaceId = ".$nsId." AND year != ''".$maxCondition;
                $criteria->order = "year desc";

                foreach(item::model()->findAll($criteria) as $_year)
                {
                    if($this->selectedYear == null)
                    {
                        $this->selectedYear = $_year->year;
                    }

                    $years[$_year->year] = $_year->year;
                }
            }

            if($this->enableCategory)
            {
                $criteria = new CDbCriteria();
                $criteria->distinct = true;

                $categories['0'] = 'All';

                $criteria->select = 'categoryId';
                $_condition = "namespaceId = ".$nsId." AND categoryId != ''";
                $_param = array();

                if($this->selectedYear != null)
                {
                    $_condition .= " AND item.year = :year";
                    $_param = array(':year'=> $this->selectedYear);
                }

                $criteria->condition = $_condition;
                $criteria->params = $_param;

                foreach(item::model()->with(array('category'=>array('select'=>'name,parentId')))->findAll($criteria) as $_categoryId)
                {
                    /* only show department categories */
                    if ($_categoryId->category->parentId == 5) {
                        $categories[str_replace(" ", "-", $_categoryId->category->name)] = $_categoryId->category->name;
                    }
                    
                }
                asort($categories);
            }

            if($this->enableUser && ($this->enableCategory && $this->selectedCategory != null))
            {
                $criteria = new CDbCriteria();
                $criteria->distinct = true;

                //$users[0] = 'All';

                $criteria->select = 'ownerId';

                $_condition = "namespaceId = :namespaceId AND ownerId != ''";
                $_param = array(":namespaceId"=>ns::GRADUATION);

                if($this->selectedYear != null)
                {
                    $_condition .= " AND item.year = :year";
                    $_param[':year'] = $this->selectedYear;
                }

                if($this->selectedCategory != null)
                {
                    $_categoryId = category::model()->find('name = :name', array(':name'=>str_replace("-", " ", $this->selectedCategory)))->id;
                    $_condition .= " AND item.categoryId = :categoryId";
                    $_param[':categoryId'] = $_categoryId;
                }

                $criteria->condition = $_condition;
                $criteria->params = $_param;

                foreach(item::model()->with(array('owner'=>array('select'=>'name, friendlyName')))->findAll($criteria) as $_user)
                {
                    $users[$_user->owner->friendlyName] = $_user->owner->name;
                }
            }
        }

        $this->render("graduationFilter",
            array(
                'enableYear'=>$this->enableYear,
                'enableCategory'=>$this->enableCategory,
                'enableUser'=>$this->enableUser,

                'selectedYear'=>$this->selectedYear,
                'selectedCategory'=>$this->selectedCategory,
                'selectedUser'=>$this->selectedUser,

                'years'=>$years,
                'categories'=>$categories,
                'users'=>$users,

                '_ns'=>$this->_ns,

                'friendlyUrl'=>$this->friendlyUrl,
                'nl'=>(Util::GetLocalization() == 1)?'enname':'nlname',
            ));
        }

        ;
    }

    public static function getItems()
    {

    }
}
