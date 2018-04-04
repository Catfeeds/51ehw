<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class customer extends Front_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function index()
	{
// 		$this->load->view('customer/info');
		redirect(site_url('member/info'));
	}
	
	public function login()
	{
		
		$this->load->view('customer/login');
	}
	
	  /**
	 * 验证名字是否已存在 ajax
	 *
	 *
	 */		
	function check_name()
	{
		
	    $name = $this->input->get('tbxRegisterNickname');
		$this->load->model('customer_mdl');
		$msg = array('Result' => true);
		if ($name){
		    if ($this->customer_mdl->check_name($name)){
				$msg = array('Result' => false);
			}				
		}
        
		echo json_encode($msg);
	}
	
	/**
	 * 注册生成验证码
	 *
	 *
	 */	
	function yzm_img()
	{
		$this->load->helper('captcha');
		code();
	}
	
	/**
	 * 检查注册验证码是否准确
	 *
	 *
	 */	
	function _check_yzm()
	{
		session_start();
        $Verifier = $this->input->post('tbxVerifier');
        if ($_SESSION['verify'] == $Verifier){
			//
		}else{
			//echo "ddd";
			$data["error"] ="验证码错误！";
			$this->load->view('customer/findPwd');
			exit();
		}
		return;
	}
	
	
	 /**
	 * 验证邮箱是否已存在 ajax
	 *
	 *
	 */	
	function check_email()
	{
       
	    $email = $this->input->get('tbxRegisterEmail');
		$this->load->model('customer_mdl');
		$msg = array('Result' => true);
		if ($email){
		    if ($this->customer_mdl->check_email($email)){
				$msg = array('Result' => false);
			}				
		}
        
		echo json_encode($msg);
	}
	
	function check_mobile()
	{
       
	    $mobile = $this->input->get('tbxRegistermobile');
		$this->load->model('customer_mdl');
		$msg = array('Result' => true);
		if ($mobile){
		    if ($this->customer_mdl->check_mobile($mobile)){
				$msg = array('Result' => false);
			}				
		}
        
		echo json_encode($msg);
	}
	
	
	
	/**
	 * 保存注册信息
	 *
	 *
	 */	
	function save()
	{
       // $this->_check_yzm();
       if(isset($_COOKIE['inviteid']))
       {
       	$c = $this->customer_mdl->get_by_condition(array("promo_name"=>$_COOKIE['inviteid']),"id");
       	$this->customer_mdl->parent_id = $c["id"];//$_COOKIE['inviteid'];
       }

		$name = $this->input->post('tbxRegisterNickname');
		$password = $this->input->post('tbxRegisterPassword');
		$email = $this->input->post('tbxRegisterEmail');
		$mobile = $this->input->post('mobile');
		$step = $this->input->post('step');
        $inviteid = $this->input->post('inviteid');
        if(!$email)
        {
        	$email = "";
        }
		
       if($step == 1 && $inviteid != 0){
			  $this->customer_mdl->parent_id = $inviteid;
		}
		
        $this->load->library('validation');
        $this->set_save_form_rules();
        
		if (TRUE == $this->validation->run()){
			$this->load->model('customer_mdl');            
            $this->customer_mdl->name = $name;
		    $this->customer_mdl->email = $email;
		    $this->customer_mdl->password = $password;
		    $this->customer_mdl->mobile = $mobile;
			$this->customer_mdl->create();
            $customer_id = $this->db->insert_id();

// 			$this->load->model('customer_address_mdl');
// 			$this->customer_address_mdl->customer_id = $this->db->insert_id();
// 			$this->customer_address_mdl->is_default = 1;
// 			$this->customer_address_mdl->consignee = null;
// 			$this->customer_address_mdl->phone =  null;
// 			$this->customer_address_mdl->mobile = null;
// 			$this->customer_address_mdl->province_id = null;
// 			$this->customer_address_mdl->city_id = null;
// 			$this->customer_address_mdl->district_id = null;
// 			$this->customer_address_mdl->address = null;
// 			$this->customer_address_mdl->postcode = null;
// 			$this->customer_address_mdl->remark = null;
// 			$this->customer_address_mdl->fax = null;
// 			$this->customer_address_mdl->invoice_head = null;
// 			$this->customer_address_mdl->address_name = null;
// 			$this->customer_address_mdl->create();

			$customer = array(
                   'user_name'  => $name,
				   'user_id'  => $customer_id,
				   'is_vip' => 0,
				   'promo_name' => $name,
				   'user_last_login' => '',
                   'user_in' => TRUE
               );


			//生成二维码图片
			$this->generateBarcode($customer_id);

			if($step == 1){
				
				$this->adding_do($name);
			}else{
				
                $this->session->set_userdata($customer);
				redirect('home');
			}
			
			//if(isset($_COOKIE['inviteid']))
      		// {
      		// 	setcookie('inviteid','',time()-3600); 
      		// }
      		 

		}else{
            redirect('customer/registration');
		}
	}
    
	// --------------------------------------------------------------------

    /**
	 * 注册验证规则
	 *
	 *
	 */	
	function set_save_form_rules()
    {
        $rules['tbxRegisterNickname'] = 'required|min_length[4]|max_length[20]|alpha_dash';	
		$rules['tbxRegisterPassword'] = 'required|min_length[6]|max_length[16]|alpha_dash';	
		//$rules['tbxRegisterEmail'] = 'required|valid_email';	
		$rules['mobile'] = 'required|valid_mobile';	
		$this->validation->set_rules($rules);		
    }
    
	// --------------------------------------------------------------------

    /**
	 * 登出
	 *
	 *
	 */	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('home');
	}
    
	// --------------------------------------------------------------------

    /**
	 * 登陆
	 *
	 *
	 */	
	function check_customer()
	{
		//$this->_check_yzm1();

        $name = $this->input->post('tbxLoginNickname');
		$password = $this->input->post('tbxLoginPassword');	
		
		$this->load->model('customer_mdl');            
        $this->customer_mdl->name = $name;
		$this->customer_mdl->password = $password;
		$_customer = $this->customer_mdl->check_customer();
		if ($_customer){
			$customer = array(
				   'user_name'  => $_customer['name'],
				   'user_id'  => $_customer['id'],
				   'user_in' => TRUE,
				   'is_vip'  => $_customer['is_vip'],
				   'promo_name' => $_customer['promo_name'],
				   'user_last_login' => $_customer['last_login_at']
			   );
			$this->session->set_userdata($customer);

           
			$this->customer_mdl->update_last_login($_customer['id']);

			redirect('home');
			
		}else{
			
            $this->load->view('customer/login',array("message"=>"用户名或密码不正确"));
		}
	}
	
	//不有使用
	public function registration($id=0)
	{
		if($id)
		{
			//保存链接地址
			setcookie("inviteid",$id,time()+10000, '/'); 
		}
		$this->load->view('customer/register');
	}
	
	
	public function info()
	{
		$this->load->model('customer_mdl'); 
		
		$data['info'] = array();// = $this->customer_mdl->load($this->session->get_userdata('user_id'));
		
		$this->load->view('customer/info', $data);
	}
	
	/**
	 * 客户列表
	 * 
	 */
	public function customerdata($level=0,$fid=0)
	{
		if($level<0 || $level>5)
		{
			$this->showMessage("找不到所需页面！",site_url('customer/customerdata'),true,true);
		}
		else
		{
			if($level>0 && $fid==0)
			{
				$this->showMessage("参数错误！",site_url('customer/customerdata'),true,true);
			}else
			{
				if($level == 0)
				{
					$fid = $this->session->userdata('user_id');
				}
				
				$data["begindate"] = $this->input->get_post("begindate");
				$data["enddate"] = $this->input->get_post("enddate");
				$data["username"] = $this->input->get_post("username");
				$data["phone"] = $this->input->get_post("phone");
				$like = array();
				$condition = array();
				if($data["begindate"] && $data["begindate"]!= "")
				{
					$condition["registry_at >="] = $data["begindate"];
				}
				if($data["enddate"] && $data["enddate"]!= "")
				{
					$condition["registry_at <="] = $data["enddate"];
				}
				if($data["username"] && $data["username"]!= "")
				{
					$like["name"] = $data["username"];
				}
				if($data["phone"] && $data["phone"]!= "")
				{
					$like["phone"] = $data["phone"];
				}
				$data["fid"] = $fid;
				$data["level"] =$level;
				$data["result"] = $this->customer_mdl->getChildList($level,$fid,$condition,$like);
			}
		}
		$this->load->view('customer/customer',$data);
	}
	
	public function updateCustomerRebate()
	{

		$userid = $this->session->userdata('user_id');
		if($userid)
		{
					
			//$data["id"] = $this->input->get_post('userid');
			$data["parent_shared"] = $this->input->get_post('rebate');
			
			$maxrate = $this->customer_mdl->getUserRebate($userid);
			//echo $maxrate;
			
			if($data["parent_shared"]>$maxrate)
			{
				echo json_encode("false_".$maxrate);
				return;
			}
			
			$i = $this->customer_mdl->updateByCondition($data,array("parent_id"=>$userid,"id"=>$this->input->get_post('userid')));

			$msg = "success";
		}else
		{
			$msg = "false";
			
			 //redirect('customer/login');
		}
		echo json_encode($msg);
		
	}
	
	
	public function customerDataDetail($level=0,$id)
	{
		
		if($id)
		{
			//判斷用戶是否可以查詢
			if($this->checkUser($level,$id))
			{
				$this->load->model("order_mdl");
				$data["period"] = $this->input->get_post('period');
				$data["status"] = $this->input->get_post('status');
				$data["page"] = $this->input->get_post('page');
				$data["pagesize"] = 5;
				$data["id"] = $id;
				$data["level"] = $level;
				if(!$data["page"])
				{
					$data["page"] =1;
				}
				
				//查詢用戶數據
				$data['user'] = $this->customer_mdl->load($id);
				$data['user']['childcount']= $this->customer_mdl->countChild($id);
				$data['user']['salecount']= $this->order_mdl->count_orders($id);
				
				//查詢用戶消費數據
				$data["saledata"] = $this->customer_mdl->getCustomerSaleData($id,array(),false);
				$data["saledata_month"] = $this->customer_mdl->getCustomerSaleData($id,array("place_at >="=>strtotime("-30 day")),false);
				$data["childdata"] = $this->customer_mdl->getCustomerSaleData($id,array(),true);
				$data["childdata_month"] = $this->customer_mdl->getCustomerSaleData($id,array("place_at >="=>strtotime("-30 day")),true);

				//单订信息
				$condition = array();
				if($data["period"])
				{
					$condition = array("place_at>=",strtotime("-30 day"));
				}
				if($data["status"])
				{
					$condition = array("status",$data["status"]);
				}
				
				//echo $data["page"];
				$data["order"] = $this->order_mdl->get_customer_orders($id,"order_sn,place_at,b.product_id,c.name,quantity,b.price,a.status,a.id,a.total_product_price,c.goods_thumb",$condition,$data["pagesize"],($data["page"]-1)*$data["pagesize"]);
				
				$pagecondition= "?period=".$data["period"]."&status=".$data["status"];
				$this->load->library('pagination');
				$config['base_url'] = site_url('goods/vip/');
				$config['suffix'] = $pagecondition;
				$config['total_rows'] = $this->order_mdl->count_orders($id,$condition);
				$config['per_page'] = $data["pagesize"];
				$config['curr_page'] = $data["page"];
				$config['num_links'] = 10;
				$config['full_tag_open'] = '';
				$config['full_tag_close'] = '';
				$config['num_tag_open'] = '';
				$config['num_tag_close'] = '';
				$config['first_link'] = FALSE ;
				$config['last_link'] = FALSE ;
				$config['next_link'] = '下一页';
				$config['next_tag_css'] = 'class="next"';
				$config['next_tag_open'] = '';
				$config['next_tag_close'] = '';
				$config['prev_link'] = '上一页';
				$config['prev_tag_css'] = 'class="prev"';
				$config['prev_tag_open'] = '';
				$config['prev_tag_close'] = '';
				//$config['cur_tag_css'] = 'class="current"';
				$config['cur_tag_open'] = '<a href="javascript:" class="ui-paging-current">';
				$config['cur_tag_close'] = '</a>';
				$this->pagination->initialize($config);
				$data['pagination'] = $this->pagination->create_links();
			

				$this->load->view('customer/datadetails',$data);
			
			}else
			{
				$this->showMessage("参数错误！",site_url('customer/customerdata'),true,true);
			}
		}else
		{
			$this->showMessage("参数错误！",site_url('customer/customerdata'),true,true);
		}
		
	}
	
	public function checkUser($level,$id)
	{
		return true;
	}
	
	public function userquan()
	{
		$this->load->view('customer/userquan');
	}
	
	public function forgot($msg = "")
	{
		$data["error"] = $msg;
		$this->load->view('customer/findPwd',$data);
	}
	
	public function getPW()
	{
		$this->_check_yzm();
		$this->load->model('customer_mdl');
		$username = $this->input->post("username");
		$email = $this->input->post("email");
		$data["error"] = "";
		
		if($username && $email)
		{
			$email = trim($email);
			$password = rand(100000,999999);
			$condition = array("name"=>$username,"email"=>$email,"is_active"=>"0");
			$user = $this->customer_mdl->get_by_condition($condition);
			if($user)
			{
				$c = $this->customer_mdl->update_pwd($user["id"],$password);
				if($c>0)
				{
					$this->load->library('email');
			
					$this->email->from('2190311733@qq.com', 'Administrator');
					$this->email->to($user["email"]); 
			
					
					$this->email->subject('重置密码邮件（请勿回复此邮件）');
					//$this->email->header("Content-type:text/html; charset=utf-8");
					$this->email->message('尊敬的万嘉欢购客户：<br/> '.$username.'，您好！<br/> 您的密码已被重置，您的新密码是：'.$password.'<br/> 温馨提示：<br/> 1、如果您想修改您的安全邮箱，请登录账号管理里面的【个人资料】进行修改。<br/> 2、本邮件为系统自动发出，请勿回复。<br/> =============================================================== <br/> 万嘉欢购<br/> 敬启'); 
					
					try{
						$this->email->send();
					}catch(Exception $e)
					{
						echo $e;
					}
					
					$data["error"] = "密码已重置成功,请查收EMAIL!";
				   $this->load->view('customer/findPwd',$data );
				}
				
			}
			else
			{
				$data["error"] = "会员名或电子邮件错误！";
				$this->load->view('customer/findPwd',$data);
			}
		}else
		{
			$data["error"] = "数据缺失错误！";
			$this->load->view('customer/findPwd',$data );
		}
		
	}
	
	
	public function address()
	{
		$this->load->view('customer/address');
	}
	public function complaints()
	{
		$this->load->view('customer/complaints');
	}


	public function adding()
	{
		
		$data['customer'] = $this->customer_mdl->load($this->session->userdata('user_id'));
		
		$data['step'] = 1;
		
		$this->load->view('customer/adding', $data);
	}
	
	public function adding_do($name = "")
	{
		$data['name'] = $name;
		
		$data['step'] = 2;
		
		
		
		$this->load->view('customer/adding', $data);
	}
	
	public function storage($type=0)
	{
		$this->load->model('save_mdl');
		$userid = $this->session->userdata('user_id');
		//echo $userid;
		if($type == 0)
		{
			$list = $this->save_mdl->getSaveList($userid);
		}
		else if($type == 1)
		{
			$list = $this->save_mdl->getUserList($userid);
		}else
		{
			$list = $this->save_mdl->getGiftList($userid);
		}
		
		$data["list"] = $list;
			
		$data["count"] = $this->save_mdl->getTotal($userid);
		
		$data["type"] = $type;
		
		//print_r($data);
		$this->load->view('customer/mystorage', $data);
	}
	
	public function giveProduct()
	{
		$productid = $this->input->post("productid");
		$count = $this->input->post("count");
		$touser = $this->input->post("touser");
		$userid = $this->session->userdata('user_id');
		
		$this->load->model("customer_mdl");
		$this->load->model("save_mdl");
		$toUserData = $this->customer_mdl->get_by_condition(array("mobile"=>$touser));
		$data["message"] = "";
		if($toUserData)
		{
			$saveData = $this->save_mdl->getSave_by_condition(array("userid"=>$userid,"productid"=>$productid,"quantity >="=>$count));
			if($saveData)
			{
				$this->save_mdl->giveSave(array("fromuserid"=>$userid,"touserid"=>$toUserData["id"],"quantity"=>$count,"product_id"=>$productid,"action"=>"1"));
				
			}else
			{
				$data["message"] = '存酒信息错误，存酒数量不足';
	 			
			}
		}
		else
		{
			$data["message"] = '赠送对象错误，找不到该对象';
	 		
		}

		//echo $data["message"];
		if($data["message"] == "")
		{
			redirect(site_url('customer/storage/2'));
		}
		else
		{
			$data["type"] = 3;
			$data["item"]["total"] =  $this->input->post("totalcount");
			$data["item"]["name"] =  $this->input->post("productname");
			$data["item"]["touser"] = $touser;
			$data["item"]["count"] = $count;
			$data["item"]["id"] = $productid;
			$this->load->view('customer/mystorage', $data);
		}
		
	}
	

	public function invite()
	{
		$userid = $this->session->userdata('user_id');
		if($userid)
		{
		$this->load->view('customer/invite');
		}else
		{
			redirect('home');
		}
	}
	
	public function rebate()
	{
		$userid = $this->session->userdata('user_id');
		if($userid)
		{
			$this->load->model("order_mdl");
			$this->load->model("balance_mdl");
			
			$totallist =  $this->order_mdl->getCutomerRebateList(array("agentid"=>$userid));
			$hadpay = $this->balance_mdl->getBalanceByCustomer($userid);
			$data["totalcount"] = 0;
			if($totallist && count($totallist)>0)
			{
				$data["totalcount"] = $totallist[0]["rebate_1"];
			}
			
			if($hadpay!=0)
			{
				$data["hadpay"] = $hadpay["balancetotal"]==null?0:$hadpay["balancetotal"];
			}else
			{
				$data["hadpay"] = 0;
			}
			
			$data["nopay"] = $data["totalcount"]-$data["hadpay"];
			//print_r($data);
			$this->load->view('customer/rebate',$data);
		}else
		{
			 redirect('customer/login');
		}
		
	}
	
	public function rebate_do()
	{

		$data['customerid'] = $this->session->userdata('user_id');
		if($data['customerid'])
		{
			$data['balancetotal'] = $this->input->post('total');
			$data['bankname'] =  $this->input->post('bankname');
			$data['banksubname'] =  $this->input->post('banksubname');
			$data['bankaccount'] =  $this->input->post('bankaccount');
			$data['realname'] =  $this->input->post('realname');
	
			
			//$data["create_time"] = time();
			$this->load->model("balance_mdl");
			$this->load->model("order_mdl");
	
			
			$totallist =  $this->order_mdl->getCutomerRebateList(array("agentid"=>$data['customerid']));
			$hadpay = $this->balance_mdl->getBalanceByCustomer($data['customerid']);
			$totalcount = 0;
			if($totallist && count($totallist)>0)
			{
				$totalcount = $totallist[0]["rebate_1"];
			}
	
			if($hadpay!=0)
			{
				$hadpay = $hadpay["balancetotal"]==null?0:$hadpay["balancetotal"];
			}else
			{
				$hadpay = 0;
			}
			
	
			if($totalcount-$hadpay>0 && $totalcount-$hadpay>$data['balancetotal'])
			{
				$id = $this->balance_mdl->create($data);
				if($id)
				{
					$data["totalcount"]=$totalcount;
					$data["hadpay"] = $hadpay;
					$data["nopay"] = $totalcount-$hadpay;
					$data["message"] = "结算申请成功";
					$data["result"] = true;
					
				}
				else
				{
					$data["message"] = "结算申请失败";
					$data["result"] = false;
				}
			}
			else
			{
				$data["message"] = "不需要结算或结算金额太多！";
				$data["result"] = false;
			}
		}
		
		$this->load->view('customer/rebate',$data);

	}
	public function faq()
	{
		$this->load->view('customer/faq');
	}

	
	
	public function mymessage()
	{
		$this->load->view('customer/mymessage');
	}
	
	public function appregist($id=0)
	{
		$data["id"] = $id; 
		$this->load->view('app_regist/register.php',$data);
	}
	
	//wap 注册
	public function appregist_do()
	{
		
		$username = $this->input->post('username',true);
		$password = $this->input->post('password',true);
		$email = $this->input->post('email');
		$mobile = $this->input->post('mobile');
		$name = $this->input->post('name');
		$parentid = $this->input->post('parentid');
		$data["username"] = $username;
		$data["password"] = $password;
		$data["name"] = $name;
		$data["email"] = $email;
		$data["mobile"] = $mobile; 
		$data["id"] = $parentid;
		$message = "";
		//检查用户名是否存在
		if($this->customer_mdl->check_name($username))
		{
			$message = '该用户名已经存在';
			
		}
		
		//检查email是否存在
		//if($this->customer_mdl->check_email($email))
		//{
		//	$message = '该email已经存在';		
		//}
		
		
		if($this->customer_mdl->check_mobile($mobile))
		{
			$message = '该手机已经注册';		
		}
		if($message == "")
		{
			$this->customer_mdl->name = $username;
			$this->customer_mdl->password = $password;
			$this->customer_mdl->email = $email;
			$this->customer_mdl->parent_id = $parentid;
			
			if($mobile)
				$this->customer_mdl->mobile=$mobile;
			if($name != null)
				$this->customer_mdl->phone=$name;
	
			
			$this->customer_mdl->registry_by = 'APP';
			
			if($this->customer_mdl->create())
			{
				$customer_id = $this->db->insert_id();
				
				//echo $customer_id;

				//生成二维码图片
				$this->generateBarcode($customer_id);

				$message = "";
			}else{
				$message = "注册失败";
				
			}
		}
		
		if($message == "")
		{
			
			$this->load->view('app_regist/complete.php',$data);
		}else
		{
			$data["message"] = $message;
			$this->load->view('app_regist/register.php',$data);
		}
		
	}

	public function generateBarcode($userid)
	{
		$data = 'http://www.wjhgw.com/index.php/customer/appregist/'.$userid;
		$size = '400x400';
		$logo = './logo.png';	// 中间那logo图
		
		

        //生成二维码
        include dirname(BASEPATH)."/phpqrcode/qrlib.php";
		$errorCorrectionLevel="L";
		$matrixPointSize="3";
		
		$filename='/uploads/userinfo/'.$userid.'.png';
		$margin=3;
		QRcode::png($data,dirname(BASEPATH). $filename, $errorCorrectionLevel, $matrixPointSize, $margin);

		// 通过google api生成未加logo前的QR图，也可以自己使用RQcode类生成
		//$png = 'http://chart.googleapis.com/chart?chs=' . $size . '&cht=qr&chl=' . urlencode($data) . '&chld=L|1&choe=UTF-8';
		
		//$QR = imagecreatefrompng($png);
		
		 $QR = imagecreatefromstring(file_get_contents($filename));
		
		if($logo !== FALSE)
		{
			$logo = imagecreatefromstring(file_get_contents($logo));
			
			$QR_width = imagesx($QR);
			$QR_height = imagesy($QR);
			
			$logo_width = imagesx($logo);
			$logo_height = imagesy($logo);
			
			$logo_qr_width = $QR_width / 6;
			$scale = $logo_width / $logo_qr_width;
			$logo_qr_height = $logo_height / $scale;
			$from_width = ($QR_width - $logo_qr_width) / 2;
			
			imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
		}

		//header('Content-type: image/png');
		imagepng($QR,'uploads/userinfo/'.$userid.'.png');

		imagedestroy($QR);
	}

 // 	/**
	// * 保存用户添加关注标签
 // 	*/
 // 	public function add_customer_label()
 // 	{
 		
 // 	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */