<?php

$db = require(dirname(__FILE__) . '/db.php');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Gerrit Rietveld Academie',

	// preloading 'log' component
        //'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
	),

	// application components
	'components'=>array(
                'request'=>array(
                    'enableCookieValidation'=>true,
                ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
                array(
					'class'=>'CWebLogRoute',
                                        'levels'=>'error, warning, trace',
                                        //'categories'=>'application'
				),
			),
		),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to set up database

		'db'=>$db,

        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'roles',
            'itemChildTable'=>'taskRoles',
            'assignmentTable'=>'userRoles',
            'defaultRoles'=>array('authenticated', 'guest', 'all'),
        ),

        'urlManager'=>array(
            'showScriptName'=>false,
            'urlFormat'=>'path',
            'rules'=>array(

                'en/news/<enname>'=>'webPage/news',
                'nl/news/<nlname>'=>'webPage/news',
                'en/news/<ln1>'=>'webPage/2',
                'nl/news/<ln2>'=>'webPage/2',

                'en/search/page'=>'search/page',
                'en/search/news'=>'search/news',
                'en/search/project'=>'search/project',
                'en/search/item'=>'search/item',
                'en/search'=>'search/index',

                'nl/search/page'=>'search/pageNl',
                'nl/search/news'=>'search/newsNl',
                'nl/search/project'=>'search/projectNl',
                'nl/search/item'=>'search/itemNl',
                'nl/search'=>'search/indexNl',

                'en/<enname>/<y>/<cc>/<uu>'=>array('webPage/page','caseSensitive'=>false),
                'en/<enname>/<y>/<cc>/'=>'webPage/page',
                'en/<enname>/<y>'=>'webPage/page',
                'nl/<nlname>/<y>/<cc>/<uu>'=>array('webPage/page','caseSensitive'=>false),
                'nl/<nlname>/<y>/<cc>/'=>'webPage/page',
                'nl/<nlname>/<y>'=>'webPage/page',

                'en/<enname>'=>'webPage/page',
                'nl/<nlname>'=>'webPage/page',

                'project/<fname>'=>'webPage/project',
                'graduation/<fname>'=>'webPage/graduation',
                'project/<enname>'=>'webPage/project',
                'project/<nlname>'=>'webPage/project',
                'graduation/<enname>'=>'webPage/graduation',
                'graduation/<nlname>'=>'webPage/graduation',

                'en/<ln1>'=>'webPage/1',
                'nl/<ln2>'=>'webPage/1',

                'project/<ln1>'=>'webPage/3',
                'project/<ln2>'=>'webPage/3',
                'graduation/<ln1>'=>'webPage/4',
                'graduation/<ln2>'=>'webPage/4',


                'c/<fname>'=>'webPage/custom',
                'student/<uname>'=>array('user/userInfo','caseSensitive'=>false),

                'nl'=>'webPage/index',
                'en'=>'webPage/index',



            )
        ),

	),




	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'site2010@rietveldacademie.nl',
                'tempFolder'=> '/tmp/',
                'uploadFolder'=> '/u/',
                'thumbFolder'=> '/u/thumb/',
                'imageSize' => array(740,700,650,600,500,400,300,250,200,150,50),
                'defaultLn' =>2,
                'resultPerPage' => 25,
                'maxChangeRequest'=>3,

        'defaultRules'=> array(
			array('allow',
				'actions'=>array('list','show'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('create','filter'),
				'roles'=>array('authenticated'),
			),
			array('allow',
				'actions'=>array('update'),
				'roles'=>array('authenticated'),//TODO: Need to check is it the same user
			),
			array('allow',
				'actions'=>array('adminCreate','adminUpdate'),
				'roles'=>array('administrator'),
			),
			array('allow',
				'actions'=>array('admin','delete'),
				'roles'=>array('administrator'),
			),
			array('deny',
				'users'=>array('*'),
			),
         ),

         'adminDefaultRules'=> array(
			array('allow',
				'actions'=>array('list','show','create','update','admin','delete'),
				'roles'=>array('administrator'),
			),
			array('deny',
				'users'=>array('*'),
			),
		 )
	),
);