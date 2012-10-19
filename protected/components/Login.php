<?php

class Login extends CWidget {

    public function run()
    {
        		$form=new LoginForm;
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$form->attributes=$_POST['LoginForm'];
			// validate user input and redirect to previous page if valid
			if($form->validate())
                        {
                            User::initUser();
                            $this->controller->redirect(Yii::app()->user->returnUrl);
                        }
		}
		// display the login form

		$this->render('login',array('form'=>$form));
    }
}