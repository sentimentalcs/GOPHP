<?php
		namespace Core\Controller;


		class Controller{
			protected $module;
			protected $controller;
			protected $action;
			protected $view;
			function __construct($module,$controller,$action,$view){
				$this->module     = $module;
				$this->controller = $controller;
				$this->action     = $action;
				$this->view       = $view;
			}


			public function assign($name,$value=null){
				$this->view->assign($name,$value);
			}

			public function display($sharp,$layout=null){
				$this->view->display($sharp,$layout);
			}
















		}