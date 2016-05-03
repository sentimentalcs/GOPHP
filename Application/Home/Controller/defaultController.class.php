<?php
	namespace Home\Controller;
	use Core\Controller\Controller;
	class defaultController extends Controller{
		function __construct(){
			parent::__construct();
		}

		function index(){
			$data=array();
			$data['title'] = '新闻';
			$data['name']  = 'gmj大笨蛋';
			$this->render($data,'index');
		}
	}