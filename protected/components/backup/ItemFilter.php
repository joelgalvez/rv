<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ItemFilter {
    public static function get($itemUploadId,   $itemUpload = null) {
        if( $itemUpload == null) {
            $itemUpload = ItemUpload::model()->findByPk($itemUploadId);
        }

        if( $itemUpload != null) {
            
            switch($itemUpload->type) {
                case 'uploadSelection':

                    $criteria = new CDbCriteria();
                    $criteria->condition = "type = 'upload'";
                    $criteria->order = 'modified, position';
                    $criteria->condition = 'itemid = :itemId';
                    $criteria->params = array(':itemId'=>$itemUpload->uploadSelectedItemId);
                    
                    return ItemUpload::model()->find($criteria);

                case 'uploadFilter':
                    return ItemFilter::getUploads($itemUpload->categoryId, $itemUpload->namespaceId, $itemUpload->uploadFilterCount, $itemUpload->itemId);

               default:
                   throw new CHttpException(500, "Invalid pertaion");
                   break;
            }
        }else {
            throw new CHttpException(500, "item information is missing");
        }
    }

    public static function getUploads($category, $namespace, $max, $id = null, $json= false)
    {
        $projectId = ns::model()
            ->find("name = :name", array(':name'=>'Project'))
            ->id;

        $criteria = new CDbCriteria;

        if($id != null)
        {
            $criteria->condition = "id != :id";
            $criteria->params = array(":id"=> $id);
        }
        
        if($max > 0)
            $criteria->limit = $max;
        else if($max == -1)
            $criteria->limit = $max; //TODO: do fillup logics here

        $_other = null;

        if($category != null && $category != '' && $category != '0') {
            $_other = new CDbCriteria;
            $_other->condition = "categoryId = :cid";
            $_other->params = array(":cid"=> $category);
        }

        if($namespace != null && $namespace != '' && $namespace != '0') {
            $_criteria = new CDbCriteria;
            $_criteria->condition = "namespaceId = :nsid";
            $_criteria->params = array(":nsid"=> $namespace);

            if($_other == null)
            {
                $_other = $_criteria;
            }else
            {
                $_other->mergeWith($_criteria, false);
            }
        }

        if($_other != null)
        {
            $criteria->mergeWith($_other);
        }

        $items = item::model()->with(array('itemuploads'=>array(
                'order'=>'position',
                'condition'=>"type='upload'",
                'select'=>'id, type, title, text, uploadtype, filePath, fileName, videolink',
            )))->findAll($criteria);

        $uploads = array();

        foreach($items as $k=>$v)
        {
            foreach($v->itemuploads as $_k=>$_v)
            {
                if($json)
                {
                    $uploads[] = array(
                            'id'=>$_v->id,
                            'name'=>$v->title,
                            'title'=>$_v->title,
                            'text'=>substr($_v->text, 0, 18).'...',
                            'filePath'=>$_v->filePath,
                            'fileName'=>$_v->fileName,
                            'uploadtype'=>$_v->uploadtype,
                            'videoLink'=>$_v->videolink,
                        );
                }else
                {
                    $uploads[] = $_v;
                }
            }
        }

        return $uploads;
    }
}
