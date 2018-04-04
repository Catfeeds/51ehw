<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 会员管理控制器
 * 
 * 查看会员列表
 * 
 * @author 		Clark So
 * @copyright 	Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license		http://www.9-leaf.com/
 * @link		http://www.9-leaf.com/
 * @since		Version 1.0
 * @filesource
 *
 */
class Advertisement extends Front_Controller {
	
	// --------------------------------------------------------------------
	public $mem;
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' ) ) {
			redirect ( 'customer/login' );
			exit ();
		}
		
	}
	
	// --------------------------------------------------------------------
	
	public function index(){ 
	   
	    if( !empty( $this->session->userdata('approval_status') )  && $this->session->userdata('approval_status') == 2 )
	    {
	        //连接MEMCACHED
	        $this->mem = $this->tel_memcached();//父类方法里面有
    	    //判断是否有登录key
    	    if( !empty($this->session->userdata('login_user_key') )  ) 
    	    { 
    	        
    	        $user_key = $this->session->userdata('login_user_key');
    	        $val = $this->mem->get( $user_key );//查询信息是否存在
    	        
    	        if(!$val)
    	        {   //如果过期重新写入 
    	            $val = $this->set_user_memcached();
    	        }
    	    }else{ 
    	        //没有登录key，重新写入
    	        $val = $this->set_user_memcached();
    	    }
    	   
    	    //设置成功或者获取成功
    	    if( $val){ 
    	       
//     	        $url = 'http://gamemp.51ehw.com/Home/GetToken';
    	        $url = 'http://ad.mp.diabin.cn/Home/GetToken';//测试
    	        $data['id'] = $val['corporation_id'];
    	        $data['key'] = $val['user_key'];
    	        
    	        $result = $this->curl_advertisement($url,$data);
            	
    	        if( isset($result) && $result['status'] == 0 ) { 
//     	            header("Location: http://gamemp.51ehw.com/Home/AutoLogin?token=".$result['result'] );
    	            header("Location: http://ad.mp.diabin.cn/Home/AutoLogin?token=".$result['result'] );//测试
    	            exit();
    	        }
    	    }
	    }
	    echo '<meta charset="utf-8">
		        <script type="text/javascript">
                    alert("无法转跳");
                	history.back();
                </script>';
	    exit();
	}
	
// 	//将用户信息写入memcache
	private function set_user_memcached(){ 
	   
	    $customer_id = $this->session->userdata('user_id');
        $key = md5( $customer_id.rand(0,999999) );
        
        $this->load->model('customer_mdl');
        $customer_info = $this->customer_mdl->load( $customer_id );
        
        $customer_data = array(
            'name' => $customer_info['name'],
            'user_name' => $this->session->userdata('user_name'),
            'user_id' => $this->session->userdata('user_id'),
            'user_in' => TRUE,
            'is_vip' => $this->session->userdata('is_vip'),
            'is_active' => $this->session->userdata('is_active'),
            'user_last_login' => $this->session->userdata('user_last_login'),
            'user_key' => $key,
            'mobile' => $customer_info['mobile']
        );
        
       
        
        //是否审核通过企业
        if( $this->session->userdata('approval_status') == 2 )
        { 
            $customer_data["approval_status"] = 2;
            $customer_data['corporation_id'] = $this->session->userdata('corporation_id');
        }
         
        
        if( $this->mem->set($key,$customer_data,MEMCACHE_COMPRESSED,1800 ) ){ 
            $this->session->set_userdata('login_user_key',$key);
            
            return $customer_data;
        }else{ 
            return false;
        }
            
       
	}
	
	//连接Memcached
// 	public function tel_memcached(){
// 	    $mem = new Memcache;
	     
// 	    if(!$mem->connect("10.10.51.53",11211)){
// 	        die('连接失败!');
// 	    }else{
// 	        return $mem;
// 	    }
// 	}
	
	//POST获取所需参数
	private function curl_advertisement($url,$data){ 
	    $ch = curl_init();
	    $res= curl_setopt ($ch, CURLOPT_URL,$url);
	    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
// 	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
// 	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
// 	    curl_setopt ($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	   
	    
	    $result = curl_exec ($ch);
	    curl_close($ch);
	    return json_decode($result,true);
	}
}