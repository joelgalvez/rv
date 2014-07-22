<?php
/**
 * Controller for the front end interface
 *
 * @author antobinish
 */
class WebPageController extends CController {

    public function actionIndex() {
        $ln  = Util::GetLocalization();
        $url = webtree::model()->find('defaultPage = 1 AND localizationId = :ln', array(':ln' => $ln));
        $this->renderItem(ns::PAGE, $url->url, $ln, true);
    }

    public function action1(){ return $this->renderItem(1); }
    public function action2(){ return $this->renderItem(2); }
    public function action3(){ return $this->renderItem(3); }
    public function action4(){ return $this->renderItem(4); }
    public function action5(){ return $this->renderItem(5); }

    public function actionPage()        { return $this->renderItem(ns::PAGE); }
    public function actionNews()        { return $this->renderItem(ns::NEWS); }
    public function actionProject()     { return $this->renderItem(ns::PROJECT); }
    public function actionGraduation()  { return $this->renderItem(ns::GRADUATION); }
    public function actionCustom()      { return $this->renderItem(ns::CUSTOM); }

    protected function renderItem($ns = ns::PAGE, $itemName = null, $localizationId = null, $default = false) {
        if (isset($_GET['itemid']) || isset($_GET['fname']) || isset($_GET['enname']) || isset($_GET['nlname']) || isset($itemName)) {
            $itemId = Util::Get('itemid', 0);
            if ($itemName == null) {
                $itemName = Util::Get('fname', '');
            }

            if ($localizationId == null) {
                $localizationId = localization::EN;
            }

            if ($itemName == '') {
                $itemName = Util::Get('enname', '');
            }

            if ($itemName == '') {
                $itemName = Util::Get('nlname', '');
                if ($itemName != '') {
                    $localizationId = localization::NL;
                }
            }

            $isFriendlyName = ($itemName) ? true : false;

            $item = WebPage::getItemByNameOrId($itemId, $itemName, $localizationId, $ns);

            if ($item) {
                $item->getDefaultIfNull(true);

                if (!$default) {
                    Yii::app()->request->cookies['enUrl'] = new CHttpCookie('enUrl', $item->friendlyUrl);
                    Yii::app()->request->cookies['nlUrl'] = new CHttpCookie('nlUrl', $item->friendlyUrlNl);
                    Yii::app()->request->cookies['namespace'] = new CHttpCookie('namespace', $item->namespace->name);
                } else {
                    Yii::app()->request->cookies['namespace'] = new CHttpCookie('namespace', 'index');
                    Yii::app()->request->cookies['enUrl']     = new CHttpCookie('enUrl', '');
                    Yii::app()->request->cookies['nlUrl']     = new CHttpCookie('nlUrl', '');
                }

                // Switch the fields of the item to the Dutch content if the user 
                // is currently in the Dutch section.
                if (Util::GetLocalization() == localization::NL) {
                    $item->changeLocalization(true);
                }

                // Determine the view (within the webPage folder).
                // If the item has a specific template set, use that.
                // Otherwise use the name of the item's namespace (ie. Page, News, etc.).
                if ($item->templateId != null) {
                    $_v = $item->templateId;
                    $this->render($item->templateId, array('model' => $item));
                } else {
                    $_v = $item->namespace->name;
                }

                if (isset($_GET['p'])) {
                    $this->renderPartial($_v, array('model' => $item));
                } else {
                    $this->render($_v, array('model' => $item));
                }
            } else {
                throw new CHttpException(404, 'Item with ' . (($isFriendlyName) ? 'name [' . $itemName . ']' : 'id [' . $itemId . ']') . ' Not Found');
            }

        } else {
            throw new CHttpException(500, "item information is missing");
        }
    }

    public function actionUpload() {
        $uid = Util::Get('uid');
        $iid = Util::Get('iid');

        if ($uid != null || $iid != null) {
            if ($iid != null) {
                $criteria            = new CDbCriteria();
                $criteria->order     = 'itemupload.created desc, itemupload.modified desc, itemupload.position';
                $criteria->condition = 'itemupload.itemId = :id';
                $criteria->params    = array(':id' => $iid);
                $upload = ItemUpload::model()->with('item')->find($criteria);
            } else {
                $upload = ItemUpload::model()->with('item')->findByPk($uid);
            }

            if ($upload != null) {
                $upload->customData = array(
                    'year'     => $upload->item->year,
                    'category' => (isset($upload->item->category) ? $upload->item->category->name : ''),
                    'owner'    => $upload->item->owner->name
                );
                $this->renderPartial(
                    '/webPage/upload/' . $upload->type,
                    array(
                        'upload'            => $upload,
                        'parentItem'        => null,
                        'parser'            => new MarkdownParserHighslide(),
                        'editorial'         => false,
                        'editorial_size'    => 600,
                        'lbound'            => 200,
                        'hbound'            => 350,
                        'big'               => 600,
                        'filtered_category' => false,
                        'filtered_user'     => false,
                        'search'            => true
                    )
                );
            } else {
                throw new CHttpException(404, 'Upload Not Found for $uid');
            }

        } else {
            throw new CHttpException(500, "item information is missing");
        }
    }
}
