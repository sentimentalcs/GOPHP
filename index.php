<?php
//定义常量
	define('DS',DIRECTORY_SEPARATOR);
	define('GOPHP',dirname(__FILE__). DS );
	define('APP_PATH',GOPHP.'Application'.DS);
	define('APP_DEBUG',true);
//包含核心文件
	require GOPHP.'_GOPHP'.DS.'Initial.php' ;
