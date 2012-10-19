<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserFilter
 *
 * @author antobinish
 */
class UserFilter {
    public static function getFilterCondition($userGroup, $category, $year, $max)
    {
        $criteria = new CDbCriteria;

        if($userGroup != null && $userGroup != '' && $userGroup != '0')
        {
            $_criteria = new CDbCriteria;
            $_criteria->condition = "groupId = :uid";
            $_criteria->params = array(":uid"=> $userGroup);

            $criteria->mergeWith($_criteria);
        }

        if($category != null && $category != '' && $category != '0')
        {
            $_criteria = new CDbCriteria;
            $_criteria->condition = " (categoryId = :cid OR categoryId1 = :cid OR categoryId2 = :cid OR categoryId3 = :cid OR categoryId4 = :cid) ";
            $_criteria->params = array(":cid"=> $category);

            $criteria->mergeWith($_criteria);
        }

        if($year != null && $year != '' && $year != '0')
        {
            if ($year > 5) {
                $_criteria = new CDbCriteria;
                $_criteria->condition = "graduated = 1 AND year = :year";
                $_criteria->params = array(":year"=> $year);

                $criteria->mergeWith($_criteria);
            } else {
                $_criteria = new CDbCriteria;
                $_criteria->condition = "year = :year";
                $_criteria->params = array(":year"=> $year);

                $criteria->mergeWith($_criteria);
            }
        }

        if($max != 0)
            $criteria->limit = $max;


        $criteria->order = 'userinfo.name';

        return $criteria;
    }
}
?>
