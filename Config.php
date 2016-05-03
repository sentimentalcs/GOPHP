<?php
//可以适当添加 支持PATH_INFO模式
 return $config  = array(
        //默认模块配置
          'default_module'      => 'home',
          'default_view'        => 'defautl',
          'default_controller' => 'defaultController',
          'default_action'      => 'index',
          'default_language'    => 'zh_cn',
        //默认数据库配置
          'db_type'             =>  'mysql',
          'db_host'             =>  'localhost',
          'db_name'             =>  '',
          'db_username'         => 'root',
          'db_password'         => '310256023',	
        //错误处理配置
          'error_reporting'     => 'E_ALL',
          'display_errors'      =>  true,
          'url_type'            =>  1   ,         //url类型默认为1,1=>pathinfo,2=>兼容模式   


          'template_engine'     => 'smarty',  //默认为smarty，可选php
  );