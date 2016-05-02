<?php

//1pathinfo ----- index.php/home/user/index   
//2.兼容模式	  index.php?c=home&a=index
/**
 * [fetch_magic description]
 * @param  [string] $str [要获取的模块，控制器，操作名]
 * @return [mixed]      [值或者false]
 */
	function fetch_magic($str){
		//path_info模式
		if(config_get('url_type')==1){
			if(isset($_SERVER['PATH_INFO'])){	
				$path = explode('/',trim($_SERVER['PATH_INFO'],'/'),3);
				$name = array('m','c','a');
				@$path = array_combine($name,$path);
				return isset($path[$str]) ? $path[$str] : false;
			}
			return false;

		}
		//兼容模式
		if(config_get('url_type')==2){
			return isset($_REQUEST[$str]) ? $_REQUEST[$str] : false ;
		}
	}

/**
 * [config_set 配置初始化,存入全局变量]
 * @return [type] []
 */
	function config_set(){
		$config_arr = include GOPHP.'Config.php';
		foreach($config_arr as $key => $config_value){
			$GLOBALS[$key] = $config_value;
		}
	}


/**
 * [config_get    取得配置]
 * @param  [string] $config_name [配置的名字]
 * @return [type]              [description]
 */
	function config_get($config_name){
		return isset($GLOBALS[$config_name]) ? $GLOBALS[$config_name] : false; 
	}

/**
 * [autoloadClass 作为回调函数被被调用，自动加载带有命名空间的控制器类和核心类以及扩展类]
 * @param  [type] $classname [类名]
 * @return [type]            []
 */
 //   new \home\controller\XX;
 //   new common\class\xx
 //   new core\class\xx

	function autoloadClass($classname){
		
		if(substr($classname,0,4)=='Core'){
			  if($str = str_replace('/\\/',DS,trim($classname,'\\'))){
			    	$file = _GOPHP_PATH.$str.'.class.php';
			    	var_dump('类文件的路径是'.$file);
			    	if(file_exists($file)){
			    		include $file;
			        }
			  }
		}else{
			//加载模块里面的核心类和自定义类
			if($str = str_replace('\\',DS,trim($classname,'\\')));
				   $file = APP_PATH.$str.'.class.php';
				   var_dump('类文件的路径是'.$file);
				   if(file_exists($file)){
				   		include $file;
				   }
		}
	}
