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
	//加载solder.class.php(解析url调用方法)
	require CORE_PATH.'Lib'.DS.'Solder.class.php';
	//加载应用公共函数
	require APP_PATH.'Common'.DS.'Functions'.DS.'functions.php';

	config_set();
	var_dump($GLOBALS);
	$solder = new Core\Lib\Solder();
	$solder -> run();


	

	
   

