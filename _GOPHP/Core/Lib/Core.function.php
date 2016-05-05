<?php

//1pathinfo ----- index.php/home/user/index   
//2.兼容模式	  index.php?c=home&a=index
/**
 * [fetch_magic description]
 * @param  [string] $str [要获取的模块，控制器，]
 * @return [mixed]      [值或者false]
 */
	function fetch_magic($str){
		//path_info模式
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
		if(is_string($config_name)){
			return isset($GLOBALS[$config_name]) ? $GLOBALS[$config_name] : false; 
	    } 
	    if(is_array($config_name)){
	    	$array = array();
	    	foreach($config_name as $value){
	    		 $array[$value] = $GLOBALS[$value]; 
	    	}
	    	return $array;
	    }
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
			    	
			    	if(file_exists($file)){
			    		include $file;
			        }else{
			        	die($file.'不存在core');
			        }
			  }
		}
		else{
			//加载模块里面的核心类和自定义类
			if($str = str_replace('\\',DS,trim($classname,'\\')));
				   $file = APP_PATH.$str.'.class.php';
				   
				   if(file_exists($file)){
				   		include $file;
				   }elseif(substr($classname,-10,10)=='controller'){
						die($file.'不存在');
		           }else{
			        	//die($file.'不存在nocore');
			        }
		}
	}



	/**
	 * ajax_echo      用ajax输出函数
	 */

	function ajax_echo( $info )
	{
		if( !headers_sent() )
		{
			header("Content-Type:text/html;charset=utf-8");
			header("Expires: Thu, 01 Jan 1970 00:00:01 GMT");
			header("Cache-Control: no-cache, must-revalidate");
			header("Pragma: no-cache");
		}
		
		echo $info;
	}

/*
	
            	需要进一步处理
	function info_page( $info , $title = '系统消息' )
	{
		if( is_ajax_request() )
			$layout = 'ajax';
		else
			$layout = 'web';
		$data['top_title'] = $data['title'] = $title;
		$data['info'] = $info;	
		render( $data , $layout , 'info' );
		
	}

*/


	/**
	 * [is_ajax_request 判断是否是ajax请求]
	 * @return boolean [description]
	 */
	function is_ajax_request()
	{
		$headers = apache_request_headers();
		return (isset( $headers['X-Requested-With'] ) && ( $headers['X-Requested-With'] == 'XMLHttpRequest' )) || (isset( $headers['x-requested-with'] ) && ($headers['x-requested-with'] == 'XMLHttpRequest' ));
	}

	if (!function_exists('apache_request_headers')) 
	{ 
		function apache_request_headers()
		{ 
			foreach($_SERVER as $key=>$value)
			{ 
				if (substr($key,0,5)=="HTTP_")
				{ 
					$key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5))))); 
	                    $out[$key]=$value; 
				}
				else
				{ 
					$out[$key]=$value; 
				}
	       } 
	       
		   return $out; 
	   } 
	} 


	/**
	 * [is_mobile_request 判断是否是移动设备请求]
	 * @return boolean [返回布尔值]
	 */
	function is_mobile_request()
	{
	    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
	 
	    $mobile_browser = '0';
	 
	    if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
	        $mobile_browser++;
	 
	    if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
	        $mobile_browser++;
	 
	    if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
	        $mobile_browser++;
	 
	    if(isset($_SERVER['HTTP_PROFILE']))
	        $mobile_browser++;
	 
	    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
	    $mobile_agents = array(
	                        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
	                        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
	                        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
	                        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
	                        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
	                        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
	                        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
	                        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
	                        'wapr','webc','winw','winw','xda','xda-'
	                        );
	 
	    if(in_array($mobile_ua, $mobile_agents))
	        $mobile_browser++;
	 
	    if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
	        $mobile_browser++;
	 
	    // Pre-final check to reset everything if the user is on Windows
	    if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
	        $mobile_browser=0;
	 
	    // But WP7 is also Windows, with a slightly different characteristic
	    if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
	        $mobile_browser++;
	 
	    if($mobile_browser>0)
	        return true;
	    else
	        return false;
	}

	

	