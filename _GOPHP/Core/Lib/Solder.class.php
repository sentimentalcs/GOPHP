<?php

namespace Core\Lib;

	class Solder {
		//要加载的视图类 ----smarty,php
		
		 public function run(){

		 	$this->loadClass();
		 	$this->callHook();

		 }

			

		private	function loadClass(){
			//var_dump($classname);
			$load = function($classname){
				//加载模块里面的核心类  命名空间同一命名 Core\xx;
				
				if(substr(trim($classname,'\\'),0,4)=='Core'){
					  $str = str_replace('/\\/',DS,trim($classname,'\\'));
					  $file = _GOPHP_PATH.$str.'.class.php';	
					  var_dump($file);
					  if(file_exists($file)){
					    	include $file;
					  }else{
					        //var_dump($classname);
					        //die($file.'不存在这个核心文件');
					        }
					  
				}else{
				//加载应用类
					if($str = str_replace('\\',DS,trim($classname,'\\'))){
						   $file = APP_PATH.$str.'.class.php';  
						   if(file_exists($file)){
						   		include $file;
						   }
					}else{
					      var_dump($classname);
				    }
			   }
	        };
			spl_autoload_register($load);
		}


		private function callHook(){
			$module = $this->fetch_magic('m') ? fetch_magic('m') : config_get('default_module') ;

	        $controller= $this->fetch_magic('c') ? fetch_magic('c') : config_get('default_controller');
	        $action = $this->fetch_magic('a') ? fetch_magic('a') : config_get('default_action');
	        $controller_name = $module.DS.'Controller'.DS.$controller.'Controller';
	        if(\config_get('template_engine') == 'smarty'){
	        	//包含原smarty文件
	        	include CORE_PATH.'Lib'.DS.'Smarty'.DS.'Smarty.class.php';
	        	$smarty = new \Smarty();
	        	//加载对smarty的接口文件
	        	$view = new \Core\View\SmartyCustom($smarty,$module); 
	        }elseif(\config_get('template_engine') == 'php'){
	        	$view = new \Core\View\PHPEngine($module);
	        }else{
	        	#code...
	         	die('sdfsdf');
	        }
	        //新建控制器类
	        $controller_obj = new $controller_name($module,$controller,$action,$view);
	        if(method_exists($controller_obj,$action)){
	        	call_user_func(array($controller_obj,$action));
	        }else{
	        	die($controller.'不存在该方法');
	        }

		}




		/**
		 * [fetch_magic 用于获取url并解析]
		 * @param  [type] $str [想要获取的模块名,控制器名，操作名]
		 * @return [type]      [false or 相应的名字]
		 */
	    private function fetch_magic($str){
		//path_info模式  注:config_get是全局函数
			if(config_get('url_type')==1){
				
				if(isset($_SERVER['PATH_INFO'])){
					$part = '';	
					$path = explode('/',trim($_SERVER['PATH_INFO'],'/'));
					//var_dump(count($path));
					switch ($str) {
						case 'm':
							$part = 0;
							break;
						case 'c':
							$part = 1;
							break;
						case 'a':
							$part = 2;
							break;
						case 'q':
							$part = 3;
							break;
					}
					return isset($path[$part]) ? $path[$part] : false;
				}
				

			}
			//兼容模式
			if(config_get('url_type')==2){
				return isset($_REQUEST[$str]) ? $_REQUEST[$str] : false ;
			}
	   }

	








	}