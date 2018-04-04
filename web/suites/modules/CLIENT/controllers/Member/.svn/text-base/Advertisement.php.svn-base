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
		
		$this->session->set_userdata ( 'ref_from_url', current_url());
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'customer/login' );
			exit ();
		}
		
		// 判断是否微信浏览器
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) 
		{
		    $this->load->model('customer_mdl');
		    $customer = $this->customer_mdl->load( $this->session->userdata("user_id") );
		    if( !empty($customer['mobile']) ){
		        $this->session->set_userdata("mobile_exist",true);
		        $this->session->set_userdata("mobile",$customer['mobile']);
		    }else{
		        redirect('member/binding/binding_mobile');
		    }
		
		}
		
	}
	
	// --------------------------------------------------------------------
	
	public function index(){ 
	    
	    $status = base_url() == 'http://c.51ehw.com/' ? 1 : 0;
	    
 // 	    连接MEMCACHED
	    $this->mem = $this->tel_memcached();//父类方法里面有
	    
	    //判断是否有登录key
	    if( !empty($this->session->userdata('login_user_key') )  ) { 
	        
	        $login_user_key = $this->session->userdata('login_user_key');
	        $val = $this->mem->get( $login_user_key );//查询信息是否存在
	        
	        if(!$val){ //如果过期重新写入 
	            $val = $this->set_user_memcached();
	        }
	    }else{ 
	        //没有登录key，重新写入
	        $val = $this->set_user_memcached();
	    }
	   
	    //设置成功或者获取成功
	    if($val){ 
 	        
	        //正式 - 测试
	        $url = $status ? 'http://gameapi.51ehw.com/api/v1/useraccount/token' : 'http://ad.api.diabin.cn/api/v1/useraccount/token';
	        $data['key'] = $val['user_key'];
	        
	        $result = $this->curl_advertisement($url,$data);
        	
	        
	        if( !empty($result) && $result['code'] == 0 ){ 
                $redirect_url = $status ? 'http://game.51ehw.com/?token='.$result['result'] : 'http://ad.m.diabin.cn/?token='.$result['result'];

	            header("Location: $redirect_url" );//测试
	            exit();
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
	private function set_user_memcached()
	{ 
	    $customer_id = $this->session->userdata('user_id');
        $key = md5( $customer_id.rand(0,999999) );
        
        $customer_data = array(
            'user_name' => $this->session->userdata('user_name'),
            'user_id' => $this->session->userdata('user_id'),
            'user_in' => TRUE,
            'is_vip' => $this->session->userdata('is_vip'),
            'is_active' => $this->session->userdata('is_active'),
            'user_last_login' => $this->session->userdata('user_last_login'),
            'user_key' => $key,
            'mobile' => $this->session->userdata('mobile'),
            'openid' => $this->session->userdata('openid'),
            'pay_relation' => $this->session->userdata('pay_relation')
           
        );
    
        //是否审核通过企业
        if( $this->session->userdata('approval_status') == 2 )
        { 
            $customer_data['corporation_status'] = $this->session->userdata('corporation_status');
            $customer_data["approval_status"] = 2;
            $customer_data['corporation_id'] = $this->session->userdata('corporation_id');
        }
         
        
        if($this->mem->set($key,$customer_data,MEMCACHE_COMPRESSED,1800)){ 
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
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $data ) );
	   
	    $result = curl_exec ($ch);
// 	    echo $result;exit;
	    curl_close($ch);
	    if(preg_match('/^\xEF\xBB\xBF/',$result))
	    {
	        $result = substr($result,3);
	        
	    }
	    return json_decode($result,true);
	}
}