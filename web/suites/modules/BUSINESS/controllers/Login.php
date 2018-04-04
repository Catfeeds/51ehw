<?php
/**
 * 登录，注册，注销
 *
 *
 */
class Login extends Front_Controller {
	function __construct() {
		parent::__construct ();
		
		$this->session->set_userdata('ref_from_url', current_url());
		if (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false) {
		    if (! $this->session->userdata('user_in')) {
		        redirect ( 'third_signin/wechat' );
		    }
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 登录，注册 界面
	 */
	function index() {
		if (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false) {
			redirect ( 'third_signin/wechat' );
		}
		$data = array ();
		$data ['css'] [0] = "<link type='text/css' rel='stylesheet' href='" . base_url () . "css/login.css'>";
		$data ['css'] [1] = "<link type='text/css' rel='stylesheet' href='" . base_url () . "css/jq_login.css'>";
		$data ['title'] = '用户登录';
		
		$data ['error_msg'] = $this->uri->segment ( 3, 0 );
		$data['head_set'] = 3;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'login', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 验证名字是否已存在 ajax
	 */
	function check_name() {
		$qs = query_string_to_array ();
		$name = $qs ['tbxRegisterNickname'];
		$this->load->model ( 'customer_mdl' );
		$msg = array (
				'Result' => true 
		);
		if ($name) {
			if ($this->customer_mdl->check_name ( $name )) {
				$msg = array (
						'Result' => false 
				);
			}
		}
		
		echo json_encode ( $msg );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 验证邮箱是否已存在 ajax
	 */
	function check_email() {
		$qs = query_string_to_array ();
		$email = $qs ['tbxRegisterEmail'];
		$this->load->model ( 'customer_mdl' );
		$msg = array (
				'Result' => true 
		);
		if ($email) {
			if ($this->customer_mdl->check_email ( $email )) {
				$msg = array (
						'Result' => false 
				);
			}
		}
		
		echo json_encode ( $msg );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 注册生成验证码
	 */
	function yzm_img() {
		$this->load->helper ( 'captcha' );
		code ();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 登录生成验证码
	 */
	function yzm_img1() {
		$this->load->helper ( 'captcha1' );
		code ();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 检查注册验证码是否准确
	 */
	function _check_yzm() {
		session_start ();
		$Verifier = $this->input->post ( 'tbxRegisterVerifier' );
		if ($_SESSION ['verify'] == $Verifier) {
			//
		} else {
			redirect ( 'login/index/verifier' );
		}
		return;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 检查登录验证码是否准确
	 */
	function _check_yzm1() {
		session_start ();
		$Verifier = $this->input->post ( 'tbxLoginVerifier' );
		if (! empty ( $_SESSION ['verify1'] ) && $_SESSION ['verify1'] == $Verifier) {
			//
		} else {
			redirect ( 'login/index/verifier1' );
		}
		return;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 保存注册信息
	 */
	function save() {
		$this->_check_yzm ();
		
		$name = $this->input->post ( 'tbxRegisterNickname' );
		$password = $this->input->post ( 'tbxRegisterPassword' );
		$email = $this->input->post ( 'tbxRegisterEmail' );
		
		$this->load->library ( 'validation' );
		$this->set_save_form_rules ();
		
		if (TRUE == $this->validation->run ()) {
			$this->load->model ( 'customer_mdl' );
			$this->customer_mdl->name = $name;
			$this->customer_mdl->email = $email;
			$this->customer_mdl->password = $password;
			$this->customer_mdl->create ();
			$customer_id = $this->db->insert_id ();
			
			$this->load->model ( 'customer_address_mdl' );
			$this->customer_address_mdl->customer_id = $this->db->insert_id ();
			$this->customer_address_mdl->is_default = 1;
			$this->customer_address_mdl->consignee = null;
			$this->customer_address_mdl->phone = null;
			$this->customer_address_mdl->mobile = null;
			$this->customer_address_mdl->province_id = null;
			$this->customer_address_mdl->city_id = null;
			$this->customer_address_mdl->district_id = null;
			$this->customer_address_mdl->address = null;
			$this->customer_address_mdl->postcode = null;
			$this->customer_address_mdl->remark = null;
			$this->customer_address_mdl->fax = null;
			$this->customer_address_mdl->invoice_head = null;
			$this->customer_address_mdl->address_name = null;
			$this->customer_address_mdl->create ();
			
			$customer = array (
					'user_name' => $name,
					'user_id' => $customer_id,
					'user_in' => TRUE 
			);
			$this->session->set_userdata ( $customer );
			redirect ( 'home' );
		} else {
			redirect ( 'login' );
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 注册验证规则
	 */
	function set_save_form_rules() {
		$rules ['tbxRegisterNickname'] = 'required|min_length[4]|max_length[20]|alpha_dash';
		$rules ['tbxRegisterPassword'] = 'required|min_length[6]|max_length[16]|alpha_dash';
		$rules ['tbxRegisterEmail'] = 'required|valid_email';
		$this->validation->set_rules ( $rules );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 登出
	 */
	function logout() {
		$this->session->sess_destroy ();
		redirect ( 'home' );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 手机验证码登录页面
	 */
	public function code_login( $tribe_id,$err_msg = 0 )
	{
	    $this->load->model("Tribe_mdl");
	
        $inviteid = $this->input->get('in_id');
        
        if ($inviteid)
        {
            //保存上线用户ID
            $this->session->set_userdata('inviteid',$inviteid);
        }
        
        $invitetp = $this->input->get('in_tp');//部落二维码邀请
        if($invitetp && $invitetp == 'code'){
            setcookie('invitetp_'.$tribe_id,true, time()+60,'/');
        }
        if ( $this->session->userdata('user_in') && $this->session->userdata("mobile_exist") || $this->session->userdata('user_in') && $this->session->userdata("mobile") )
        {
            if ($invitetp){
                $customer_id = $this->session->userdata("user_id");//用户id
                $ts_info = $this->Tribe_mdl->verify_tribe_customer($tribe_id,$customer_id,0);//检查我是否存在部落
                if($ts_info){
                    //当是部落二维码邀请时并且是管理员邀请的话则用户加入部落默认审核通过
                     $authority = $this->Tribe_mdl->ManagementTribe($inviteid,$tribe_id);
                        if($authority){
                            $_update['id'] =  $ts_info['id'];
                            $_update["status"] = 2;
                            $aff = $this->Tribe_mdl->update_member($_update,$tribe_id);
                        }
                }
            }
            //转跳是否加入部落。
            redirect('Login/Join_tribe/'.$tribe_id.'/'.$invitetp);
            return;
            
        }else{ 
            $this->session->set_userdata('ref_activity_url',site_url("Tribe/Home/".$tribe_id));
        }
        $this->load->model('tribe_mdl');
        
	    // 微信用户绑定监测
//         if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && ! $this->session->userdata("mobile_exist") ) 
//         {
//             if ( empty( $customer['mobile'] ) ) 
//             {
//                 redirect('member/binding/binding_mobile/1/0?tribe_id='.$tribe_id);
//                 return;
//             }
//         }
       
        $tribe_info = $this->tribe_mdl->get_tribe($tribe_id);
        $data['staff_status'] = $tribe_info['staff_status'];
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $data['title'] = '回家喽';
	    $data['tribe_id'] = $tribe_id;
	    $data['err_msg'] = $err_msg;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('tribe/tribe_logon', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	/**
	 * 验证码登录方法
	 */
	public function customer_login()
	{
	   
	    $code = $this->input->post('code');
	    $mobile = $this->input->post('mobile');
	    $vertify = $this->session->userdata('verfity_yzm_255');
	    $tribe_id = $this->input->post('tribe_id');
	    $parent_id = $this->input->post('parent_id');
	    $real_name = $this->input->post('real_name');
	    
	    if(!$parent_id){
	        $parent_id = $this->session->userdata('inviteid');
	    }
	
	    if( !$tribe_id  || !is_numeric($tribe_id)  || !is_int($tribe_id+0) )
	    {
	        redirect('Login/code_login/0/3/?tribe_id='.$tribe_id);
	        exit();
	        //参数错误
	    }
	    $this->load->model("tribe_mdl");
	    //判断验证码是否正确
	    if(  $vertify == $code  )
	    {
	        $post['tbxLoginNickname'] = $mobile;
	        $post['status'] = 'code';
	
	        //接口获取用户信息
	        $url = $this->url_prefix.'Customer/check_customer';
	
	        $_customer = json_decode($this->curl_post_result($url,$post),true);
	        $this->session->unset_userdata('verfity_yzm_255');
	      
	        //普通浏览器
	        if( $_customer && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false )
	        { 
	          
	            $this->customer_session( $_customer, $mobile, $tribe_id ,$real_name);
	            
	        }else{
	            
	            //首先判断是否预录入的用户 -- 如果是才注册 -- else 跳入注册页面
	            $this->load->model('Tribe_mdl');
	            $ts_info = $this->Tribe_mdl->verify_tribe_user( $tribe_id, $mobile );
	            
	            if( $ts_info )
	            {
	                //普通浏览器
	                if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false){
    	                //如果是预录入用户
        	            $data_post['mobile'] = $mobile;
                        $data_post['tbxRegisterPassword'] = '8888'.date('ymdhis');
                        $data_post['registry_by'] = "H5";
                        $data_post['app_id'] = $this->session->userdata("app_info")["id"];
                        $data_post['time'] = date("Y-m-d H:i:s");
                        $data_post['module'] = "B";
                        $data_post['real_name'] = $real_name;
                        $data_post['Nickname'] = '访客';
                        
                        if( $this->session->userdata("inviteid") )
                        {
                            $data_post['parent_id'] = $this->session->userdata("inviteid");
                        }
                        $url = $this->url_prefix.'Customer/save';
                        $user = json_decode($this->curl_post_result($url,$data_post),true);
                        
                        if( $user['status'] == 3 )
                        { 
                            $customer_id = $user['customer_id'];
                            
                            //更新部落信息
//                             $update_data['customer_id'] = $customer_id;
//                             $update_data['mobile'] = $mobile;
//                             $this->tribe_mdl->update_tribe_staff( $update_data );
                        
                       
                            
                            //同步族员姓名
                            $aff = $this->tribe_mdl->update_tribe_member_name($real_name,$customer_id);
                            
                            //加载用户支付账户信息写入session
                            $p_data =array();
                            $p_data['customer_id'] = $customer_id;
                            $url = $this->url_prefix.'Customer/get_pay_relation_id?';
                            $pay_data = json_decode($this->curl_post_result($url,$p_data),true);
                             
                            $this->load->helper("session");
                            $this->load->model("customer_mdl");
                            $info = $this->customer_mdl->load($customer_id);
                            $info['pay_relation'] = $pay_data;
                            set_customer($info,"other");
                        
                            redirect('Tribe/home/'.$tribe_id);
                            exit();
                            
                        }else{ 
                            //登录失败
                            redirect('Login/code_login/'.$tribe_id.'/2/?tribe_id='.$tribe_id);
                            exit();
                        }
	                  }else{//微信浏览器
	                     $this->wx_customer_session($mobile,$parent_id,$tribe_id,$real_name);  
	                  }
	            }else{ 
	              
	                $this->load->model('tribe_mdl');
	                // 新增新用户直接注册入口 并且加入部落
	                if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
	                    $this->wx_customer_session($mobile,$parent_id,$tribe_id,$real_name); //type 未申请加入部落
	                }else{
	                    $post['mobile'] = $mobile;
	                    $post['tbxRegisterPassword'] = "ehw888888";
	                    $post['Nickname'] = "访客";
	                    $post['real_name'] = $real_name;
	                    $post['registry_by'] = "H5";
	                    $post['app_id'] = $this->session->userdata("app_info")["id"];
	                    $post['time'] = date("Y-m-d H:i:s");
	                    $post['module'] = "B";
	                    $post['parent_id'] = $parent_id;
	                    $url = $this->url_prefix.'Customer/save';
	                    $user = json_decode($this->curl_post_result($url,$post),true);
	                    if($user){
	                        $user_id = $user['customer_id'];
	                        //同步族员姓名
	                        $aff = $this->tribe_mdl->update_tribe_member_name($real_name,$user_id);
	                    }else{
	                        redirect('Home');
	                        exit;
	                    }
	                }
	                 
	               
	                //查询部落信息
	                $tribe_info = $this->tribe_mdl->get_tribe($tribe_id);
	                if($tribe_info['staff_status']){
	                    //要审核
	                    $data['status'] = 1;
	                }else{
	                    $data['status'] = 2;
	                }
	                $ts_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$user_id,0);//检查我是否存在部落
	                if(!$ts_info){
	                    if( !empty($_COOKIE['invitetp_'.$tribe_id])){
	                        //当是部落二维码邀请时并且是管理员邀请的话则用户加入部落默认审核通过
	                       $inviteid =  $this->session->userdata('inviteid');
	                       $authority = $this->tribe_mdl->ManagementTribe($inviteid,$tribe_id);
	                       if($authority){
	                           $data["status"] = 2;
	                       }
	                    }
	                    
	                    //加入部落
	                    $data["customer_id"] = $user_id;
	                    $data["tribe_id"] = $tribe_id;
	                    $data["mobile"] = $mobile;
	                    $data["member_name"] = $real_name;
	                    $aff = $this->tribe_mdl->add_staff($data);
	                    
	                }else if($ts_info['status'] == 3 || $ts_info['status'] == 4){
	                    
	                    $_update['id'] =  $ts_info['id'];
	                    $_update['status'] =  1;
	                    
	                    if( !empty($_COOKIE['invitetp_'.$tribe_id])){
	                        //当是部落二维码邀请时并且是管理员邀请的话则用户加入部落默认审核通过
	                        $inviteid =  $this->session->userdata('inviteid');
	                        $authority = $this->tribe_mdl->ManagementTribe($inviteid,$tribe_id);
	                        if($authority){
	                            $_update["status"] = 2;
	                        }
	                    }
	                    $aff = $this->tribe_mdl->update_member($_update,$tribe_id);
	                }
	            
	                 
	                //加载用户支付账户信息写入session
	                $p_data =array();
	                $p_data['customer_id'] = $user_id;
	                $url = $this->url_prefix.'Customer/get_pay_relation_id?';
	                $pay_data = json_decode($this->curl_post_result($url,$p_data),true);
	                
	                $this->load->helper("session");
	                $this->load->model("customer_mdl");
	                $user_info = $this->customer_mdl->load($user_id);
	                $user_info['pay_relation'] = $pay_data;
	               
	                set_customer($user_info,"other");
	               
	                if( $data['status']  == 1){
	                    if( !empty($_COOKIE['invitetp_'.$tribe_id])){
	                        redirect('Tribe/home/'.$tribe_id);
	                    }
	                    redirect('Login/Join_tribe/'.$tribe_id);
	                }else{
	                    redirect('Tribe/home/'.$tribe_id);
	                }
	            }
	        }
	        
	    }else{
	        redirect('Login/code_login/'.$tribe_id.'/1/?tribe_id='.$tribe_id);
	        exit();
	    }
	}
	
	
	/**WX
	 * 用户登录 绑定微信账号  SEESION写入
	 */
	public function  wx_customer_session($mobile,$parent_id,$tribe_id,$real_name){//
	    $this->load->model('tribe_mdl');
	    //微信
	    $post['mobile'] = $mobile;
	    $url = $this->url_prefix.'Customer/load_by_mobile';
	    $_customer = json_decode($this->curl_post_result($url,$post),true);
	 
	    if($_customer ){
	        
	        //更新所有部落的族员姓名
	        $aff = $this->tribe_mdl->update_tribe_member_name($real_name,$_customer['id']);
	        if($_customer['wechat_account']){
	            //真实姓名同步
	            $url = $this->url_prefix.'Customer/info_save';
	            $req['real_name'] = $real_name;
	            $req['user_id'] = $_customer['id'];
	            $aff = json_decode($this->curl_post_result($url,$req),true);
	            echo "<script>history.back(-1);alert('该手机已绑定了微信');</script>";exit;
	        }else{
	             
	            if(!$_customer['nick_name'] || $_customer['nick_name'] == '访客'){
	                $update['nick_name'] = $this->session->userdata('wechat_nickname');
	                $update['Nickname'] = $this->session->userdata('wechat_nickname');
	            }
	            $update['user_id'] = $_customer['id'];
	            $update['mobile'] = $mobile;
	            $update['real_name'] = $real_name;//真会姓名
	            $update['openid'] = $this->session->userdata('openid');
	            $update['unionid'] = $this->session->userdata('unionid');
	            $update['wechat_avatar'] = $this->session->userdata('wechat_avatar');
	            $update['wechat_nickname'] = $this->session->userdata('wechat_nickname');
	            $url = $this->url_prefix.'Customer/info_save';
	            $is_binding = json_decode($this->curl_post_result($url,$update),true);
	             
	            //发送绑定成功信息
	            $this->load->model('Customer_message_mdl',"Message");
	             
	            $link = $this->url_prefix.'Customer/load?';
	            $dta['customer_id'] = $update['user_id'];
	            $customers = json_decode($this->curl_post_result($link,$dta),true);
	            //模板
	            $Msg_info['template_id']= 4;
	            //标题
	            $Msg_info['name']= '账号绑定';
	            $Msg_info['customer_id']= $update['user_id'];
	            $Msg_info['obj_id'] = 0;
	            $Msg_info['type'] = 1;
	            $Msg_info['parameter']['name'] = isset($customers['nick_name']) && !empty($customers['nick_name'])? $customers['nick_name']:$customers['name'];
	            $this->Message->Create_Message($Msg_info);
	             
	            //将微信注册账号给失效
	            $info['customer_id'] = $this->session->userdata("user_id");
	            $info['type'] = 'wechat';
	            //接口-
	            $url = $this->url_prefix.'Customer/unbundling';
	            json_decode($this->curl_post_result($url,$info),true);
	             
	            
	            $user_id = $_customer['id'];
	            //加载用户支付账户信息写入session
	            $p_data =array();
	            $p_data['customer_id'] = $user_id;
	            $url = $this->url_prefix.'Customer/get_pay_relation_id?';
	            $pay_data = json_decode($this->curl_post_result($url,$p_data),true);
	             
	            $this->load->helper("session");
	            $this->load->model("customer_mdl");
	            $user_info = $this->customer_mdl->load($user_id);
	            $user_info['pay_relation'] = $pay_data;
	            set_customer($user_info,"other");
	        }
	    }else{
	       
	        $post['tbxRegisterPassword'] = 'ehw888888';
	        $post['real_name'] = $real_name;
	        $post['nickname'] = $this->session->userdata('wechat_nickname');
	        $post['Nickname'] = $this->session->userdata('wechat_nickname');
	        $post['unionid'] = $this->session->userdata('unionid');
	        $post['headimgurl'] = $this->session->userdata('wechat_avatar');
	        $post['openid'] = $this->session->userdata('openid');
	        $post['registry_by'] = "H5";
	        $post['app_id'] = $this->session->userdata("app_info")["id"];
	        $post['time'] = date("Y-m-d H:i:s");
	        $post['module'] = "B";
	        $post['parent_id'] = $parent_id;
	        $url = $this->url_prefix.'Customer/save';
	        
	        $user = json_decode($this->curl_post_result($url,$post),true);
	        if($user){
	            $info['customer_id'] =   $this->session->userdata("user_id");
	            $info['type'] = 'wechat';
	            //接口-失效
	            $url = $this->url_prefix.'Customer/unbundling';
	            json_decode($this->curl_post_result($url,$info),true);
	            
	            $user_id = $user['customer_id'];
	            
	            //更新部落信息
// 	            $update_data['customer_id'] = $user_id;
// 	            $update_data['mobile'] = $mobile;
// 	            $this->tribe_mdl->update_tribe_staff( $update_data );
	            
	            //同步族员姓名
	            $aff = $this->tribe_mdl->update_tribe_member_name($real_name,$user_id);
	           
	            //加载用户支付账户信息写入session
	            $p_data =array();
	            $p_data['customer_id'] = $user_id;
	            $url = $this->url_prefix.'Customer/get_pay_relation_id?';
	            $pay_data = json_decode($this->curl_post_result($url,$p_data),true);
	            
	            $this->load->helper("session");
	            $this->load->model("customer_mdl");
	            $user_info = $this->customer_mdl->load($user_id);
	            $user_info['pay_relation'] = $pay_data;
	            set_customer($user_info,"other");
	            
	        }else{
	            redirect('Home');
	            exit;
	        }
	    }
	    //查询部落信息
	    $tribe_info = $this->tribe_mdl->get_tribe($tribe_id);
	    if($tribe_info['staff_status']){
	        //要审核
	        $data['status'] = 1;
	    }else{
	        $data['status'] = 2;
	    }
	    $ts_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$user_id,0);//检查我是否存在部落
	    if(!$ts_info){
	        
	        if( !empty($_COOKIE['invitetp_'.$tribe_id])){
	            //当是部落二维码邀请时并且是管理员邀请的话则用户加入部落默认审核通过
	            $inviteid =  $this->session->userdata('inviteid');
	            $authority = $this->tribe_mdl->ManagementTribe($inviteid,$tribe_id);
	            if($authority){
	                $data["status"] = 2;
	            }
	        }
	        
	        
	        //加入部落
	        $data["customer_id"] = $user_id;
	        $data["tribe_id"] = $tribe_id;
	        $data["mobile"] = $mobile;
	        $data["member_name"] = $real_name;
	        $aff = $this->tribe_mdl->add_staff($data);
	    }else if($ts_info['status'] == 3 || $ts_info['status'] == 4){
            $_update['id'] =  $ts_info['id'];
            $_update['status'] =  1;
            
            if( !empty($_COOKIE['invitetp_'.$tribe_id])){
                //当是部落二维码邀请时并且是管理员邀请的话则用户加入部落默认审核通过
                $inviteid =  $this->session->userdata('inviteid');
                $authority = $this->tribe_mdl->ManagementTribe($inviteid,$tribe_id);
                if($authority){
                    $_update['id'] =  $ts_info['id'];
                    $_update["status"] = 2;
                    $aff = $this->tribe_mdl->update_member($_update,$tribe_id);
                }
                redirect('Tribe/home/'.$tribe_id);
            }
            $aff = $this->tribe_mdl->update_member($_update,$tribe_id);
        }
        
	    if( $data['status']  == 1){
	        redirect('Login/Join_tribe/'.$tribe_id);
	    }else{
	        redirect('Tribe/home/'.$tribe_id);
	    }
	    
	}
	
	/**H5
	 * 用户登录SEESION写入
	 */
	public function customer_session( $_customer,$mobile,$tribe_id,$real_name)
	{ 
	    $this->load->model('tribe_mdl');
	    $customer_id = $_customer['id'];
	    
	    //先把真实姓名同步
	    $url = $this->url_prefix.'Customer/info_save';
	    $req['real_name'] = $real_name;
	    $req['user_id'] = $customer_id;
	    $aff = json_decode($this->curl_post_result($url,$req),true);
	    
	    //更新所有部落的族员姓名
	    $aff = $this->tribe_mdl->update_tribe_member_name($real_name,$customer_id);
	    
	    //加载用户支付账户信息写入session
	    $p_data =array();
	    $p_data['customer_id'] = $customer_id;
	    $url = $this->url_prefix.'Customer/get_pay_relation_id?';
	    $pay_data = json_decode($this->curl_post_result($url,$p_data),true);
	     
	    $this->load->helper("session");
	    $this->load->model("customer_mdl");
	    $info = $this->customer_mdl->load($customer_id);
	    $info['pay_relation'] = $pay_data;
	    set_customer($info,"other");
	    
	    $ts_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$customer_id,0);//检查我是否存在部落
        if(!$ts_info){
            //未申请
            //查询部落信息
            $tribe_info = $this->tribe_mdl->get_tribe($tribe_id);
            if($tribe_info['staff_status']){
                //要审核
                $data['status'] = 1;
            }else{
                $data['status'] = 2;
            }
            
            if( !empty($_COOKIE['invitetp_'.$tribe_id])){
                //当是部落二维码邀请时并且是管理员邀请的话则用户加入部落默认审核通过
                $inviteid =  $this->session->userdata('inviteid');
                $authority = $this->tribe_mdl->ManagementTribe($inviteid,$tribe_id);
                if($authority){
                    $data["status"] = 2;
                }
            }
        
            //加入部落
            $data["customer_id"] = $customer_id;
            $data["tribe_id"] = $tribe_id;
            $data["mobile"] = $mobile;
            $data["member_name"] = $real_name;
            $aff = $this->tribe_mdl->add_staff($data);
           
            if($data['status'] == 1){
                redirect('Login/Join_tribe/'.$tribe_id);
            }else
            {
                redirect('Tribe/home/'.$tribe_id);
            }
            
        }else if($ts_info['status'] == 3 || $ts_info['status'] == 1){
            if( !empty($_COOKIE['invitetp_'.$tribe_id])){
                //当是部落二维码邀请时并且是管理员邀请的话则用户加入部落默认审核通过
                $inviteid =  $this->session->userdata('inviteid');
                $authority = $this->tribe_mdl->ManagementTribe($inviteid,$tribe_id);
                if($authority){
                    $_update['id'] =  $ts_info['id'];
                    $_update["status"] = 2;
                    
                    $aff = $this->tribe_mdl->update_member($_update,$tribe_id);
                }
                redirect('Tribe/home/'.$tribe_id);
            }
            //提交申请了  还是待审核或拒绝加入
            redirect('Login/Join_tribe/'.$tribe_id);
        }else{
            if( !empty($_COOKIE['invitetp_'.$tribe_id])){
                //当是部落二维码邀请时并且是管理员邀请的话则用户加入部落默认审核通过
                $inviteid =  $this->session->userdata('inviteid');
                $authority = $this->tribe_mdl->ManagementTribe($inviteid,$tribe_id);
                if($authority){
                    $_update['id'] =  $ts_info['id'];
                    $_update["status"] = 2;
                    
                    $aff = $this->tribe_mdl->update_member($_update,$tribe_id);
                }
            }
            redirect('Tribe/home/'.$tribe_id);
        }
	}
	 
	/**
	 * 检测绑定手机-加入部落。
	 *  $invitetp = $this->input->get('in_tp');//部落二维码邀请
	 */
	public function Join_tribe( $tribe_id = 0 ,$invitetp = 0)
	{ 
	    
	    if( !$this->session->userdata('user_in') )
	    { 
	        $this->session->set_userdata('ref_from_url', current_url());
	        redirect('customer/login');
	        return;
	    }
	    
	    if($invitetp){
	        $data['code_invite'] = $invitetp;
	    }
	    $this->load->model('tribe_mdl');
	    $customer_id = $this->session->userdata("user_id");//用户id
	    
	    $url = $this->url_prefix.'Customer/load';
	    $post['customer_id']=$customer_id;
	    $customer = json_decode($this->curl_post_result($url,$post),true);
	    
	    //判断是否绑定手机
	    if( $customer["mobile"] )
	    {
	        $tribe_staff_info = $this->tribe_mdl->check_My_apply( $tribe_id,$customer_id );//查询部落
	        
	        if( $tribe_staff_info )
	        { 
	            //成员存在 && 审核通过
	            if( $tribe_staff_info['tribe_staff_id'] && $tribe_staff_info['status'] == 2 )
	            { 
	                //转跳页面-已经是该成员。
	                redirect('Tribe/Home/'.$tribe_id);
	                return;
	                
	            }else{ 
	                $real_name = '';
	                $str_name ='';
	                if($customer['real_name']){
	                    $str_name =  $real_name =$customer['real_name'];
	                    $length = mb_strlen($str_name);
	                    $str_name = '**'. mb_substr($str_name,$length-1,$length);
	                }
	                $data['str_name'] = $str_name;
	                $data['real_name'] = $real_name;
	                $data['apply_status'] = $tribe_staff_info['status'];
	                $data['mobile'] = $customer["mobile"];
	                
	                $data['head_set'] = 2;
            	    $data['foot_set'] = 1;
            	    $data['title'] = '回家喽';
            	    $data['tribe_id'] = $tribe_id;
            	    $this->load->view('head', $data);
            	    $this->load->view('_header', $data);
            	    $this->load->view('tribe/tribe_join', $data);
            	    $this->load->view('_footer', $data);
            	    $this->load->view('foot', $data);
	    
	            }
	            
	            
	        }else{ 
	            
	            //部落不存在。
	            echo "<script>history.back(-1);alert('部落不存在');</script>";exit;
	        }
	        
	    }else{ 
	        
	        redirect('member/binding/binding_mobile');
	        exit;//手机未绑定
	    }
	    
	}
	
}
