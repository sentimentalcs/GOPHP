<?php
  namespace Core\Controller;
  class Controller{

  		function __construct(){
  			//加载smarty模板类
  			//或者使用原生的php作为模板
  			if(config_get('template_engine')=='smarty'){
  				include CORE_PATH.'Lib'.DS.'smarty'.DS.'smarty.class.php';
  			}
  			echo '这是核心controller文件';
  		}
  } 