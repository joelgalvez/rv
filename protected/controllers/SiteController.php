<?php

class SiteController extends CController {
/**
 * Declares class-based actions.
 */
    public function actions() {
        return array(
        // captcha action renders the CAPTCHA image
        // this is used by the contact page
        'captcha'=>array(
        'class'=>'CCaptchaAction',
        'backColor'=>0xEBF4FB,
        ),
        );
    }

    public function accessRules() {
        return array(
        array('allow',
        'actions'=>array('index','contact','login','logout'),
        'users'=>array('*'),
        ),
        array('allow',
        'actions'=>array('hideItem'),
        'roles'=>array('administrator', 'student', 'teacher', 'staff', 'werkplaats'),
        ),
        array('deny',
        'users'=>array('*'),
        ),
        );
    }


    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {

        if( isset($_GET['noredirect']) && Yii::app()->authManager->isAssigned('administrator', Yii::app()->user->id))
        {
            $_order = '';
            if (isset($_GET['ob'])){
                $_order = $_GET['ob'];
            }
            
            $pagesPage = $newsPage = $projectPage = $gradPage = $customPage = null;

            $pages = WebPage::getParentItems(1, $pagesPage,$_order);
            $news = WebPage::getParentItems(2, $newsPage,$_order);
            $project = WebPage::getParentItems(3, $projectPage,$_order);
            $graduation = WebPage::getParentItems(4, $gradPage,$_order);
            $custom = WebPage::getParentItems(5, $customPage);

            $this->render('index', array(
                'pages'=>$pages,
                'news'=>$news,
                'project'=>$project,
                'graduation'=>$graduation,
                'custom'=>$custom,
                'ns'=>ns::model()->findAll(),
                'pagesPage' => $pagesPage,
                'newsPage' => $newsPage,
                'projectPage' => $projectPage,
                'gradPage' => $gradPage,
                'customPage' => $customPage
            ));
            return;
        }

        Util::defaultRedirect();
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $contact=new ContactForm;
        if(isset($_POST['ContactForm'])) {
            $contact->attributes=$_POST['ContactForm'];
            if($contact->validate()) {
                $headers="From: {$contact->email}\r\nReply-To: {$contact->email}";
                mail(Yii::app()->params['adminEmail'],$contact->subject,$contact->body,$headers);
                Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }

        $this->render('contact',array('contact'=>$contact));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $form=new LoginForm;
        // collect user input data
        if(isset($_POST['LoginForm'])) {
            $form->attributes=$_POST['LoginForm'];
            // validate user input and redirect to previous page if valid
            if($form->validate()) {
                User::initUser();
                $this->redirect(Yii::app()->request->baseUrl.Yii::app()->user->friendlyUrl.'/?ac');
            }
        }else{
            //Yii::app()->request->baseUrl
        }
        // display the login form
        $this->render('login',array('form'=>$form));
    }

    /**
     * Logout the current user and redirect to homepage.
     */
    public function actionLogout() {

        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionHideItem() {
        if(isset($_GET['id'])) {
            $_id = $_GET['id'];
            $item = item::model()->findByPk($_id);
            if((!Yii::app()->authManager->isAssigned('administrator', Yii::app()->user->id)) && $item->editorId != Yii::app()->user->id)
            {
                throw new CHttpException(501, "User does not have accesss to this data");
            }

            ItemUpload::model()->deleteAll('itemId=:id', array(':id'=>$item->id));

            $item->delete();
            //$this->redirect(Yii::app()->user->returnUrl);
             if(Util::GetLocalization() == 1) {
                $this->redirect(Yii::app()->request->baseUrl . '/en/projects');
            } else {
                $this->redirect(Yii::app()->request->baseUrl . '/nl/projecten');
            }
        }
    }
}