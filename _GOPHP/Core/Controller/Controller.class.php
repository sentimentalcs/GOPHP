<?php
  namespace Core\Controller;
  class Controller{
        private $isSmarty='';
        public  $smarty='';

    		function __construct(){
    			//加载smarty模板类
    			//或者使用原生的php作为模板
    			//	include CORE_PATH.'Lib'.DS.'Smarty'.DS.'Smarty.class.php';
          
          if(config_get('template_engine')=='smarty'){
      			   include CORE_PATH.'Lib'.DS.'Smarty'.DS.'Smarty.class.php';
               $this->isSmarty  = true;
               $this->smarty    = new \Smarty;
               $this->initialize();
          }

          elseif(config_get('template_engine')=='php'){
               $this->isSmarty = false;

          }else{
              die('目前只支持smarty和php模板引擎！');
          }
    		}

        /**
         * [assign 用于外部调用该类便于操作]
         * @param  [type] $tpl_var [description]
         * @param  [type] $value   [description]
         * @return [type]          [description]
         */
        public function assign($tpl_var,$value=null){
            if($this->isSmarty){
                  $this->smarty->assign($tpl_var,$value);
            }else{
              die('该方法只有smarty模板支持！请在配置文件中设置template_engine为smarty后再试');
            }
        }

        //可以动态配置要加载的模板以及缓存
        /**
         * [display 用于smarty输出]
         * @param  [type] $filename [文件名,不用后缀,会自定识别模块，module@filename可以跨膜块]
         * @param  [type] $layout   [mobile,web,ajax，默认为web]
         * @return [type]           [输出页面]
         */
        public function display($filename,$layout=null){
          if($this->isSmarty){
            if( $layout == null )
              {
                if( is_ajax_request() )
                {
                  $layout = 'ajax';
                }
                elseif( is_mobile_request() )
                {
                  $layout = 'mobile';
                }
                else
                {
                  $layout = 'web';
                }
              }

            if(stripos($filename,'@')){
                 $arr = explode('@',$filename);
                 $module = $arr[0];
              }else{
                 $module = fetch_magic('m') ? fetch_magic('m') : config_get('default_module') ;
              }
            $layout_file = APP_PATH.$module.DS.'view'.DS. $layout.DS.$filename.'.html';
            $this->smarty->display('file:'.$layout_file);
           
          }else{
              die('该方法只有smarty模板支持！请在配置文件中设置template_engine为smarty后再试');
          }
      }

      /**
       * [initialize 初始化smarty配置]
       * @return [type] [description]
       */
        private function initialize(){
            $arr=array('caching','cache_lifetime','left_delimiter','right_delimiter','debugging','cache_dir');
            foreach(config_get($arr) as $key => $value){
                  $this->smarty->$key = $value;
            }  
        }
      /**
       * [render 用于php模板引擎输出]
       * @param  [array] $data   [要分配给模板的变量和值]
       * @param  string $sharp  [模板文件名不用后缀]默认为.html
       * @param  [type] $layout [自动分辨是web,mobile,ajax]
       * @return [type]         [加载指定的模板并输出]
       */
      public function render( $data = NULL , $sharp = 'default',$layout=null){
          if(!$this->isSmarty){
              if( $layout == null )
              {
                if( is_ajax_request() )
                {
                  $layout = 'ajax';
                }
                elseif( is_mobile_request() )
                {
                  $layout = 'mobile';
                }
                else
                {
                  $layout = 'web';
                }
              }
              //若指定模块，则加载指定模块下的模板文件
              //格式 module@模板文件
              if(stripos($sharp,'@')){
                 $arr = explode('@',$sharp);
                 $module = $arr[0];
                 $sharp  = $arr[1]; 
              }else{
                 $module = fetch_magic('m') ? fetch_magic('m') : config_get('default_module') ;
              }
              $layout_file = APP_PATH.$module.DS.'View'.DS. $layout.DS.$sharp.'.html';
              if( file_exists( $layout_file ) )
              {
                //    $data = array('name'=>'a','sex'=>'b')
                //    说明:$data =array(模板变量,)
                //    $name = 'a',$sex='b'
                @extract( $data );
                require( $layout_file );
              }else{
                die($layout_file.'不存在');
              }
              /*
              else
              {
                $layout_file = CROOT . 'view/layout/' . $layout . '/' . $sharp .  '.tpl.html';
                if( file_exists( $layout_file ) )
                {
                  @extract( $data );
                  require( $layout_file );
                } 
                // zhiqian 
                //可以加上ob_end_flush 清晰缓冲区并向上一层输出内容？？？
              }
              */
          }else{
            die('render方法只有php模板支持！请在配置文件中设置template_engine为php后再试');
          }
      } 

      



 } 


