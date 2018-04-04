<?php
class Login extends Front_Controller
{	
    /**
     * 
     * 同步登陆控制器
     */
    var $account_key;
    var $mem;
    // ------------------------------------------------------------
    /**
     */
     public function __construct()
     {
         parent::__construct();
         $this->mem = $this->tel_memcached();//父类方法里面有
     }
    
    /**
     * 第三方验证key同步登录
     */
    public function redirect_index(){
        
        //验证是否登录
        $this->account_key = $this->input->get('key');
        $location_url = $this->input->get('location_url');
        $cache_result = $this->is_login();
    
        if($cache_result){
            // 判断session是否第一次进来
            if ( !$this->session->userdata('user_key') ) {
        
                $cache_result['user_key'] =  $this->account_key;
                $this->session->set_userdata($cache_result);
            }
            
            header("Location: ".$location_url );
        }else{ 
            header("Location: ".site_url('customer/login') );
        }
    }
    
    //验证是否登录
    public function is_login(){
    
        $mem = $this->mem;
    
        $account_key = $this->account_key;
    
        if(!$account_key){
           return false;
    
        }else{
    
            $val = $mem->get( $account_key );
    
            if($val){
                //设置
                $mem->set($account_key,$val,MEMCACHE_COMPRESSED,1800);
                return $val;
            }
            
            return false;
            
        }
    }
    
//     //连接Memcached
//     public function tel_memcached(){
//         $mem = new Memcache;
         
//         if(!$mem->connect("10.10.51.53",11211)){
//             die('连接失败!');
//         }else{
//             return $mem;
//         }
//     }
}