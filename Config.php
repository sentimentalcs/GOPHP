<?php
//可以适当添加 支持PATH_INFO模式
 return $config  = array(
        //默认模块配置
          'default_module'      => 'home',
          'default_view'        => 'defautl',
          'default_controller'  => 'default',
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

          //以下为smaty模板配置
          'template_engine'     => 'php',  //默认为smarty，可选php    
          'caching'             =>  true,     //是否开启模板缓存
          'cache_lifetime'      => -1,           //-1,0,或者具体的时间以秒计
          'left_delimiter'      => "{",       //左定界符
          'right_delimiter'     => "}",       //右定界符
          'debugging'           => false,     //模板调试模式
          'cache_dir'           => './cache' //缓存目录，相对于index.php文件
  
          //如果为php模板引擎则不支持缓存
  );