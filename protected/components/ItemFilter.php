<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ItemFilter {
    public static function get($itemUploadId,   $itemUpload = null, $index = 0, $useGraduation = false) {
        if( $itemUpload == null) {
            $itemUpload = ItemUpload::model()->findByPk($itemUploadId);
        }

        if( $itemUpload != null) {

            switch($itemUpload->type) {
                case 'uploadSelection':

                    $criteria = new CDbCriteria();
                    $criteria->condition = "type = 'upload'";
                    $criteria->order = 'modified, position';

                    return ItemUpload::model()->onlineUpload()->find($criteria);

                case 'uploadFilter':
                    return ItemFilter::getUploads($itemUpload->categoryId, $itemUpload->namespaceId, $itemUpload->uploadFilterCount, $itemUpload->itemId, false, $itemUpload->maxUploadFetch, $index, $itemUpload->id, $useGraduation, $itemUpload->onlyOnline == 1, $itemUpload->orderByOnline == 1,  $itemUpload->randomOrder);

                default:
                    throw new CHttpException(500, "Invalid opertaion");
                    break;
            }
        }else {
            throw new CHttpException(500, "item information is missing");
        }
    }

    public static function getMaxCount($itemId, $uploadId, $index =0, $onlyOnline = false) {
        $criteria = new CDbCriteria();

        $criteria->select = 'id, uploadFilterCount, type, categoryId, namespaceId';
        $criteria->condition = 'itemId =:itemId AND (type = \'uploadFilter\' OR type = \'uploadSelection\')  ';
        $criteria->order = 'position';
        $criteria->params = array(':itemId'=> $itemId);

        $item = item::model()->findByPk($itemId);

        $maxCount = $item->uploadNr;

        $selected = $index;

        $uploads = ItemUpload::model()->findAll($criteria);

        foreach($uploads as $k=>$upload) {
            $_c = 1;

            if($upload->id == $uploadId) {
                return $maxCount - $selected;
            }
            if($upload->type == 'uploadFilter') {
                if($onlyOnline) {
                    $model = item::model()->onlineItems();
                }else {
                    $model = item::model();
                }

                $_c = $model->count(ItemFilter::getFilterCondition($upload->categoryId, $upload->namespaceId, 0, $itemId, $index));

                if($_c > $upload->uploadFilterCount) {
                    $_c = $upload->uploadFilterCount;
                }
            }

            $selected += $_c;

            if($selected  > $maxCount) {
                return 0;
            }
        }

        return 0;
    }

    public static function getFilterCondition($category, $namespace, $max, $id = null, $index = 0, $useGraduation = false, $onlyOnline = false, $orderByOnline = false, $randomOrder = false) {
        $criteria = new CDbCriteria;
        $_condition = "item.hidden = 0 ";
        $_param = array();

        if($id != null) {
            $_condition .= " AND item.id != :id";
            $_param = array(":id"=> $id);
        }

        $_year = Util::Get('y', null);
        $_category = Util::Get('cc', null);
        $_user = strtolower(Util::Get('uu', null));
        if($_user  == null)
            $_user = Util::Get('u', null);

        if($useGraduation && $_year == null ) {
            $criteriaY = new CDbCriteria();
            $criteriaY->distinct = true;
            $criteriaY->select = 'year';
            $criteriaY->condition = "namespaceId = 4 AND year != ''";
            $criteriaY->order = "year desc";
            $criteriaY->limit = 1;
            $_year = item::model()->find($criteriaY)->year;

        }
        if($_year != null && $_year != 0) {
            $_condition .= " AND item.year = :year";
            $_p = array(":year"=> $_year);
            $_param = array_merge($_param, $_p);
        }

        if($_category != null && $_category != '') {
            $_categoryId = category::model()->find('name = :name', array(':name'=>str_replace("-", " ", $_category)))->id;

            $_condition .= " AND item.categoryId = :category";
            $_p = array(":category"=> $_categoryId);
            $_param = array_merge($_param, $_p);
        }

        if($_user != null && $_user != '') {
            //echo '####'.$_user;
            //die(0);
            $__userId = User::model()->find('friendlyName = :friendlyName', array(':friendlyName'=>$_user));

            if($__userId) {
                $_userId = $__userId->id;
            } else {
                $_userId = '';
            }

            $_condition .= " AND item.ownerId = :user";
            $_p = array(":user"=> $_userId);
            $_param = array_merge($_param, $_p);
        }

        $criteria->condition = $_condition;
        $criteria->params = $_param;
        



        if($max > 0 &&  ! ($onlyOnline && $index ==0) )
            $criteria->limit = $max;
        if($index != 0)
        {
            $criteria->offset = $index;

//            $moreIndex = 0;
//
//            if($onlyOnline)
//            {
//                $cookie = Yii::app()->request->cookies['moreIndex'.$id];
//                if($cookie)
//                    $moreIndex =  $cookie->value;
//            }
//
//            $criteria->offset = $index - $moreIndex;
        }
        //        else if($max == -1)
        //                $criteria->limit = $max; //TODO: do fillup logics here

        $_other = null;

        if($category != null && $category != '' && $category != '0') {
            $_other = new CDbCriteria;
            $_other->condition = "item.categoryId = :cid";
            $_other->params = array(":cid"=> $category);
        }

        if($namespace != null && $namespace != '' && $namespace != '0') {
            $_criteria = new CDbCriteria;
            $_criteria->condition = "item.namespaceId = :nsid";
            $_criteria->params = array(":nsid"=> $namespace);

            if($_other == null) {
                $_other = $_criteria;
            }else {
                $_other->mergeWith($_criteria);
            }
        }

        if($_other != null) {
            $criteria->mergeWith($_other);
        }
        //$criteria->order = 'modified DESC';
        if($randomOrder == 0) {
            if($orderByOnline)
            {
                $criteria->order .= ' item.offline DESC, item.online DESC, item.modified DESC';
            }else
            {
                $criteria->order .= ' item.modified DESC';
            }
        } else {
            $criteria->order .= ' RAND()';
        }
        return $criteria;
    }

    public static function getUploads($category, $namespace, $max, $id = null, $json= false, $maxUpload = 1, $index = 0, $uploadId = 0, $useGraduation = false,  $onlyOnline = false, $orderByOnline = false, $randomOrder = false) {
        if($maxUpload == null)
            $maxUpload = 1;

        if($index != 0 && $max >0)
        {
            $moreIndex = 0;

            $cookie = Yii::app()->request->cookies['moreIndex'.$uploadId];
            if($cookie)
                $moreIndex =  $cookie->value;

            $index = (($index -1) * $max) + $moreIndex;
        }

        if(isset($_GET['uu']))
            $maxUpload = 0;

        $projectId = ns::model()
            ->find("name = :name", array(':name'=>'Project'))
            ->id;

        $criteria = ItemFilter::getFilterCondition($category, $namespace, $max, $id, $index, $useGraduation , $onlyOnline, $orderByOnline,$randomOrder);

        if($max == -1) {
            $_c = ItemFilter::getMaxCount($id, $uploadId, $index, $onlyOnline);

            $criteria->limit = $_c;
        }

        $orderBy = ($maxUpload == 1)?'??.priority desc, ??.modified DESC, ??.position ':'??.position';
        //$orderBy = '??.modified DESC';

        if($onlyOnline && $index == 0) {
            $model = item::model()->onlineItems();
        }else {
            $model = item::model();
        }

        $items = $model->with(array(
                'itemuploads'=>array(
                    'order'=>$orderBy,
                    'condition'=>"type='upload'",
                    'select'=>'id, type, title, text, uploadtype, filePath, fileName, videolink, imageWidth, imageHeight, namespaceId, itemNamespaceId, uploadFilterCount,'.
                    'titleNl, textNl, filePathNl, fileNameNl, videoLinkNl, imageWidthNl, imageHeightNl, itemId, modified',
                    //'together'=>true,
                    //'joinType'=>'INNER JOIN',
                    'limit'=>$maxUpload
                ),
                'owner'=>array(
                    'select'=>'userId, name, friendlyName',
                ),
                'editor'=>array(
                    'select'=>'userId, name',
                ),
                'category'=>array(
                    'select'=>'category.id, name',
                ))
            )->findAll($criteria);

        $uploads = array();
        $_i = 1;

        if($index == 0)
        {
            $cookie = new CHttpCookie('moreIndex'.$uploadId, count($items));
            Yii::app()->request->cookies['moreIndex'.$uploadId] = $cookie;
        }

        foreach($items as $k=>$v) {
            $v->localizationId = Util::GetLocalization();
            $v->getDefaultIfNull(false);

            if($v->localizationId  == 2)
                $v->changeLocalization(false);

            foreach($v->itemuploads as $_k=>$_v) {
                $_v->getDefaultIfNull();
                if($v->localizationId  == 2)
                    $_v->changeLocalization();

                if($json) {
                    $uploads[] = array(
                        'id'=>$_v->id,
                        'type'=>$_v->type,
                        'name'=>$v->title,
                        'title'=>$_v->title,
                        'text'=>substr($_v->text, 0, 18).'...',
                        'filePath'=>$_v->filePath,
                        'fileName'=>$_v->fileName,
                        'uploadtype'=>$_v->uploadtype,
                        'videoLink'=>$_v->videolink,
                        'imageWidth'=>$_v->imageWidth,
                        'imageHeight'=>$_v->imageHeight,
                        'namespaceId'=>$_v->namespaceId,
                    );
                }else {
                    $_v->name = ($v->namespaceId == 2)? $v->title : $_v->title;
                    $_v->item = $v;

                    $_editor = $_v->editor == null ? '' : $_v->editor->name;

                    $_v->customData  = array('year'=>$v->year, 'category'=>(isset($v->category) ? $v->category->name:''), 'owner'=>$v->owner->name,'editor'=>$_editor, 'ownerFriendlyName'=>$v->owner->friendlyName, 'noOfUploads'=>count($v->itemuploads));
                    $uploads[] = $_v;
                }
                //
                //                if( $_i++ >= $maxUpload)
                //                {
                //                    $_i == $maxUpload;
                //                    break;
                //                }

                if($maxUpload != 0 && $_i++ >= $maxUpload) {
                    $_i = $maxUpload;
                    break;
                }

            }
        }

        return $uploads;
    }
}
