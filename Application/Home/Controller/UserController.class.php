<?php

	namespace Home\controller;
	use Core\Controller\Controller;
	class UserController extends Controller{
		//可以选择继承Controller类或者不继承
		function __construct(){
			parent::__construct();
		}

		function index(){
			$data['movie'] = '顾梦佳喜欢看电影';
		
			$this->render($data,'User@index','web');
		}
	}	