<?php
	namespace Home\Controller;
	use Core\Controller\Controller;



	class defaultController extends Controller{
		function index(){
			$data['hello'] = $this->module; 
			$this->assign($data);
			$this->display('index','web');
		}
	}