<?php
	//检测有没有被路口文件包含
	if(!defined('GOPHP')) die('没有在路口文件中包含此文件！');
	if(!defined('DS'))		 define('DS',DIRECTORY_SEPARATOR);
	header('content-type:text/html;charset=utf-8');
	//定义常量
	define('_GOPHP_PATH',__DIR__.DS);
	define('CORE_PATH',_GOPHP_PATH.'Core'.DS);

	//加载核心函数文件
	require CORE_PATH.'Lib'.DS.'Core.function.php';
	//加载应用公共函数
	require APP_PATH.'Common'.DS.'Functions'.DS.'functions.php';
	//初始化配置文件
	config_set();

	$module = fetch_magic('m') ? fetch_magic('m') : config_get('default_module') ;
	$control= fetch_magic('c') ? fetch_magic('c') : config_get('default_controller');
	$action = fetch_magic('a') ? fetch_magic('a') : config_get('default_action');
	//自动装载控制器类和核心函数类
	//var_dump(fetch_magic('c'));
	spl_autoload_register('autoloadClass');
	

	$control_prefix = $module.'\\'.'Controller'.'\\'.$control.'controller';
	//var_dump(fetch_magic('m'));
	//var_dump(fetch_magic('c'));
	//var_dump(fetch_magic('a'));
	$control_class  = new $control_prefix;
 	 //var_dump(SMARTY_SYSPLUGINS_DIR);
	//检查类中是否已经定义该方法
	if(!method_exists($control_class,$action)){
		die ('不能找到'.$control.'中的'.$action.'方法！');
	}

	//通过gzip进行压缩
	if(stripos($_SERVER['HTTP_ACCEPT_ENCODING'],'gzip')!==false && @ini_get('zlib.output_compression'))
	ob_start("ob_gzhandler");
    call_user_func(array($control_class,$action));
	
   

