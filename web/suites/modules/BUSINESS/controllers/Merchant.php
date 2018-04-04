<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Merchant extends Front_Controller
{

	public function __construct()
	{

	    parent::__construct();
	    $this->load->helper('url');
	   
	        // 判断用户是否登录
	        if (! $this->session->userdata('user_in')) {
	            redirect('customer/login');
	            exit();
	        }
	        
	        // 微信用户绑定监测
	        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && ! $this->session->userdata("mobile_exist")) {
	            // 如果没有写手机
	            if (empty($customer['mobile'])) {
	                redirect('member/binding/binding_mobile');
	                return;
	            }
	        }
	        
	        $this->load->helper('order');
	   
	}

	
	//商家入驻首页
	public function home_page()
	{
		$data = [];
		// $data ['status'] = $status;
        $data ['title'] = '商家入驻';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;

        // 初始进入页面限定
        $data['switch'] = $this->jump_page();

		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/home_page', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}

	// 入驻须知
	public function arrival_guide()
	{
		$data = [];
		// $data ['status'] = $status;
        $data ['title'] = '入驻须知';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/arrival_guide', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}

	// 微信扫码
	public function wechat_qrcode()
	{
		$data = [];
		// $data ['status'] = $status;
        $data ['title'] = '微信支付结果';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/wechat_qrcode', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}

	/**
	* 初始页面跳转判断
	*/
	public function jump_page()
	{
		// step1
		$this->load->model('customer_corporation_mdl');
		$this->load->model("corporation_detail_mdl");

		$switch = '';
		// 查询用户是否有店铺
		$customer_id = $this->session->userdata("user_id");
		$customer_info = $this->customer_corporation_mdl->get_corporation_by_uid($customer_id);
		if(isset($customer_info) && !empty($customer_info)){
			$corporation_id = $customer_info['id'];
			$this->session->set_userdata('corporation_id',$corporation_id);

			// 按店铺id查询店铺详情
			$corporation_id = $customer_info['id'];
			$corporation_detail_info = $this->corporation_detail_mdl->get_corporation_detail_one($corporation_id);
			$data['corporation_detail_info'] = $corporation_detail_info;

			if(isset($corporation_detail_info['bus_licence_img']) && isset($corporation_detail_info['company_registration']) && isset($customer_info['grade'])){
				$switch = 3;
			}else if(isset($corporation_detail_info['company_registration']) && isset($customer_info['grade'])){
				$switch = 2;
			}else if(isset($customer_info['grade'])){
				$switch = 1;
			}

		}else{
			$switch = 0;
		}

		return $switch;
		
	}

	//	// 支付宝支付页面
	public function pay_notify()
	{
		$data = [];
		// $data ['status'] = $status;
        $data ['title'] = '支付宝支付结果';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/pay_notify', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}

	// 选择行业
	public function industry()
	{
		
		// $data ['status'] = $status;
		// 获取店铺类型信息
		$customer_id = $this->session->userdata('user_id');
		$corporation_id = $this->session->userdata('corporation_id');
		$this->load->model('customer_corporation_mdl');
		$this->load->model('corporation_detail_mdl');
		if(isset($corporation_id) && $corporation_id != ''){
			$data['corporation_info'] = $this->customer_corporation_mdl->get_customer_status($corporation_id,$customer_id);
			if(!$data['corporation_info']){
				$this->session->set_userdata('corporation_id');
			}else{
				$data['corporation_detail'] = $this->corporation_detail_mdl->get_corporation_detail_one($corporation_id);
			}
			
		}

		$this->load->model('corporation_mdl');
		$data['cor_ind'] = $this->corporation_mdl->cor_ind_info();
        $data ['title'] = '入驻须知';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/industry', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}

	/**
	* 公司信息
	*/
	public function information()
	{
		$data = [];
		// $data ['status'] = $status;
		// 获取省份信息
		$this->load->model('region_mdl');
		$data['province'] = $this->region_mdl->provinces();
		$customer_id = $this->session->userdata('user_id');
		$corporation_id = $this->session->userdata('corporation_id');
		$this->load->model('customer_corporation_mdl');
		$this->load->model('corporation_detail_mdl');
		if(isset($corporation_id) && $corporation_id != ''){
			$data['corporation_info'] = $this->customer_corporation_mdl->get_customer_status($corporation_id,$customer_id);
			// var_dump($data['corporation_info']);

			$data['corporation_detail'] = $this->corporation_detail_mdl->get_corporation_detail_one($corporation_id);
			// var_dump($data['corporation_detail']);
			if(isset($data['corporation_detail']['license_province_id'])){
				$this->load->model('region_mdl');
				$data['city_one'] = $this->region_mdl->get_city($data['corporation_detail']['license_province_id']);
				// var_dump( $data['city_one']);
			}
		}

		// 定义法人归属地
		$data['legal_person_place'] = ['中国大陆', '港澳', '台湾','外籍'];

		// 获取邀请人
		if(isset($data['corporation_info'])){
			$agent_id = $data['corporation_info']['agent_customer_id'];
			$this->load->model('customer_mdl');
			$data['phone'] = $this->customer_mdl->get_customer_by_id($agent_id);
		}

		// $this->dump($data['province']);
        $data ['title'] = '公司信息';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/information', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}

	// 上传资质
	public function qualification()
	{
		$data = [];
		// $data ['status'] = $status;

		// 查询证件相关信息
		$corporation_id = $this->session->userdata('corporation_id');

		$this->load->model("corporation_detail_mdl");

		if(isset($corporation_id)){
		$data['imgs'] = $this->corporation_detail_mdl->get_corporation_detail_one($corporation_id);
		$data['license_type'] = $data['imgs']['license_type'];
		// $data['license_type'] = 1;
		}


        $data ['title'] = '上传资质';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/qualification', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}

	// 等待审核
	public function to_examine()
	{
		$data = [];
		// $data ['status'] = $status;
		$corporation_id = $this->session->userdata('corporation_id');
		$customer_id = $this->session->userdata('user_id');
		$this->load->model('customer_corporation_mdl');
		$data['approval_status'] = $this->customer_corporation_mdl->get_customer_status($corporation_id,$customer_id)['approval_status'];
		$data['approval_desc'] = $this->customer_corporation_mdl->get_customer_status($corporation_id,$customer_id)['approval_desc'];
		// echo $data['approval_status'];
		if($data['approval_status'] == 0){
			$data ['title'] = '未绑定';
		}elseif($data['approval_status'] == 1){
			$data ['title'] = '等待审核';
		}elseif($data['approval_status'] == 2){
			$data ['title'] = '恭喜您！审核已通过';
		}else{
			$data ['title'] = '店铺暂未审核通过';
		}
       
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/to_examine', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}


	// 缴纳保证金
	public function online_payment()
	{
		$data = [];
		// $data ['status'] = $status;
		$customer_id = $this->session->userdata('user_id');
		$corporation_id = $this->session->userdata('corporation_id');
		$this->load->model('customer_corporation_mdl');
		$this->load->model('corporation_detail_mdl');
		if(isset($corporation_id) && $corporation_id != ''){
			$data['corporation_info'] = $this->customer_corporation_mdl->get_customer_status($corporation_id,$customer_id);
			// var_dump($data['corporation_info']);

			$data['corporation_detail'] = $this->corporation_detail_mdl->get_corporation_detail_one($corporation_id);
		}

        $data ['title'] = '网上缴费／店铺上线';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/online_payment', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}


	// 入驻协议
	public function agreement()
	{
		$data = [];
		// $data ['status'] = $status;
        $data ['title'] = '入驻协议';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/agreement', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}


	/**
	* 保存step1
	*/
	public function save_step1()
	{
		// 获取行业，店铺类型信息
		$grade = $this->input->post('grade');
		$Industrial_Info = $this->input->post('Industrial_Info');
		
		$costomer_id = $this->session->userdata('user_id');

		// 新增店铺
		$this->load->model('customer_corporation_mdl');
		if($grade == 1){
			$deposit = 10000;
		}else if($grade == 2){
			$deposit = 100000;
		}else{
			$deposit = 50000;
		}

		$corporation_id = $this->customer_corporation_mdl->add_customer_corporation($costomer_id,$grade,$deposit);

		// 将$corporation_id保存到session中
		$this->session->set_userdata('corporation_id', $corporation_id);
		

		// 新增店铺详情
		$this->load->model('corporation_detail_mdl');
		if($corporation_id){
			$res = $this->corporation_detail_mdl->add_corporation_detail($corporation_id,$Industrial_Info);
		}
		if($corporation_id && $res){
			echo json_encode(['code'=>1, 'msg'=>'success']);
		}else{
			echo json_encode(['code'=>0, 'msg'=>'failure']);
		}
		
	}


	/**
	* 保存step2
	*/
	public function save_step2()
	{
		$step2_data = $this->input->post();
		// var_dump($step2_data);
		$data = [];
		$corporation_id = $this->session->userdata('corporation_id');//店铺id
		// var_dump($corporation_id);
		$data['legal_person'] = $step2_data['legal_person'];//法人
		$data['idcard'] = $step2_data['idcard'];//身份证
		$data['company_registration'] = $step2_data['company_registration'];//工商注册号
		$data['Registered_Capital'] = $step2_data['Registered_Capital'];
		// $license_type = $step2_data['license_type'];

		$data['license_type'] = $step2_data['license_type'];//是否为新版营业执照

		$data['license_province_id'] = $step2_data['license_province_id'];
		$data['licecse_city_id'] = $step2_data['license_city_id'];
		$data['license_address'] = $step2_data['license_address'];
		$data['license_range'] = $step2_data['license_range'];
		$data['license_date_from'] = $step2_data['license_date_from'];
		$data['license_date_to'] = $step2_data['license_date_to'];

		// 旧营业执照必须的
		$organization_code_num1 = $step2_data['organization_code_num1'];
		$organization_code_num2 = $step2_data['organization_code_num2'];
		$data['organization_code_num'] = $organization_code_num1.'-'.$organization_code_num2;//组织机构编号
		$data['organization_date_from'] = $step2_data['organization_date_from'];
		$data['organization_date_to'] = $step2_data['organization_date_to'];
		$data['tax_number'] = $step2_data['tax_number'];//税务登记证号
		// // 旧营业执照必须的结束

		// $is_taxplayer = $step2_data['is_taxplayer'];
		$data['is_taxplayer'] = $step2_data['is_taxplayer'];

		$data['legal_person_place'] = $step2_data['legal_person_place'];

		// 将信息存入店铺详情
		$this->load->model('corporation_detail_mdl');

		$affect_rows = $this->corporation_detail_mdl->update_corporation_detail($data,$corporation_id);



		// 将信息保存到店铺表
		$data_customer = [];
		$data_customer['contact_name'] = $step2_data['contact_name'];
		$data_customer['contact_mobile'] = $step2_data['contact_mobile'];
		$data_customer['email'] = $step2_data['email'];
		$tel_num1 = $step2_data['tel_num1'];
		$tel_num2 = $step2_data['tel_num2'];
		$data_customer['tel_num'] = $tel_num1.'-'.$tel_num2;
		$data_customer['corporation_name'] = $step2_data['corporation_name'];
		$data_customer['corporation_area'] = $step2_data['corporation_area'];
		$data_customer['tel_num_extension'] = 0;
		$data_customer['approval_status'] = 1;
		// $data_customer['order_no'] = $this->create_order_no();
		$inviter_id = $step2_data['agent_customer_id'];

		// 获取邀请人用户id
		if($inviter_id){
			$this->load->model('customer_mdl');
			$res = $this->customer_mdl->get_customer_by_phone($inviter_id);
			if($res['id']){
				$data_customer['agent_id'] = $res['id'];
			}
		}
		// $data_customer['inviter_id'] = $step2_data['inviter_id'];
		$this->load->model('customer_corporation_mdl');
		$affect_rows = $this->customer_corporation_mdl->update_customer_corporation($data_customer,$corporation_id);

		echo json_encode(['code'=>1,'step2_data'=>$step2_data]);
		
		// echo json_encode(['code'=>1,'step2_data'=>$step2_data]);
	}


	// 生成订单编号
	public function create_order_no()
	{
		// $date = date('Ymd');
		// list($usec, $sec) = explode(" ", microtime());
		// $usec = (float)$usec * 1000000;
		
		// return $date.mt_rand(10,999).$usec;
		// return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
		return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
	}

	/**
	* 保存step3
	*/
	public function save_step3()
	{

		// 上传资质
		$year = date('Y');
		$month = date('m');
		$save_path = 'uploads/merchant/'.$year.'/'.$month.'/';
		$path = FCPATH.UPLOAD_PATH.$save_path; // 文件保存目录
		if(!file_exists($path)){
			mkdir($path,0777,true);
		}

		//修改允许上传文件的类型，为('jpeg','jpg','png','gif')，也可以增加新的，如pdf，pptx等等  
		$allowExt=array('jpeg','jpg','png','gif');
		$files = $this->getFiles();
		// var_dump($files);
		$file_data = [];
		if(count($files) > 5){
			
			$res = '';
			foreach($files as $index=>$val){
				$res = $this->uploadFile($val,$path,true,$allowExt);
				if($res['dest']){
					$file_data[] = [$index=>$res['dest']];
				}else{
					echo '上传失败';
				}
			}

		}else{
			
			$res = '';
			foreach($files as $index=>$val){
				
				$res = $this->uploadFile($val,$path,true,$allowExt);

				if($res['dest']){
					$file_data[] = [$index=>$res['dest']];
				}else{
					echo '上传失败';
				}
				
			}

			// var_dump($file_data);
		}
		$license_type = $this->input->post('license_type');
		// var_dump($license_type);
		$img_data = [];
		$corporation_id = $this->session->userdata('corporation_id');// 商铺id
		if($license_type == 1){
			
			// 保存资质信息
				$img_data['bus_licence_img'] =  $file_data[0]['bus_licence_img1'];//营业执照
				$img_data['idcard_img'] =  $file_data[1]['idcard_img1'].';'.$file_data[2]['idcard_img2'];//身份证
				$img_data['industry_qua'] = $file_data[3]['industry_qua'];//行业资质
				$img_data['proxy_img'] = $file_data[4]['platform_authorize_img'];//平台委托
				$img_data['license_type'] = 1;

				$this->load->model('corporation_detail_mdl');
				$res = $this->corporation_detail_mdl->update_corporation_detail2($corporation_id,$img_data);

				// echo $res;
				if($res){
					redirect('merchant/to_examine');
				}
			}else{
		
				$img_data['license_type'] = 0;
				$img_data['bus_licence_img'] =  $file_data[0]['bus_licence_img1'];//营业执照
				$img_data['organization_code_image'] = $file_data[1]['organization_code_image'];//组织机构代码图
				$img_data['tax_images'] = $file_data[2]['tax_images'];//税务
				$img_data['idcard_img'] = $file_data[3]['idcard_img1'].";".$file_data[4]['idcard_img2'];// 身份证
				$img_data['industry_qua'] = $file_data[5]['industry_qua'];// 行业资质
				$img_data['proxy_img'] = $file_data[6]['platform_authorize_img'];//平台委托

				$this->load->model('corporation_detail_mdl');
				$res = $this->corporation_detail_mdl->update_corporation_detail2($corporation_id,$img_data);
				if($res){
					// echo 'ok';
					// echo $this->create_order_no();
					redirect('merchant/to_examine');
				}
			}

		
	}



	public function save_examine()
	{
		$license_type = $this->input->post();
		echo json_encode($license_type);


	}

	
	
	/** 
	 * 针对于单文件、多个单文件、多文件的上传 
	 * @param array $fileInfo 
	 * @param string $path 
	 * @param bool $flag 
	 * @param int $maxSize 
	 * @param array $allowExt 
	 * @return array 
	 */ 
	function uploadFile($fileInfo,$path='uploads',$flag=true,$allowExt=array('jpeg','jpg','png','gif'),$maxSize=200000){  
	  	$res = [];
	    //判断错误号  
	    if($fileInfo['error']===UPLOAD_ERR_OK){  
	        //检测上传文件的大小  
	        if($fileInfo['size']>$maxSize){  
	            $res['mes']=$fileInfo['name'].'上传文件过大';  
	        }  
	        $ext=$this->getExt($fileInfo['name']);  
	        //检测上传文件的文件类型  
	        if(!in_array($ext,$allowExt)){  
	            $res['mes']=$fileInfo['name'].'非法文件类型';  
	        }  
	        //检测是否是真实的图片类型  
	        if($flag){  
	            if(!getimagesize($fileInfo['tmp_name'])){  
	                $res['mes']=$fileInfo['name'].'不是真实图片类型';  
	            }  
	        }  
	        //检测文件是否是通过HTTP POST上传上来的  
	        if(!is_uploaded_file($fileInfo['tmp_name'])){  
	            $res['mes']=$fileInfo['name'].'文件不是通过HTTP POST方式上传上来的';  
	        }  
	        if( $res ) return $res; //如果要不显示错误信息的话，用if( @$res ) return $res;  
	          
	        //$path='./uploads';  
	        //如果没有这个文件夹，那么就创建一  
	        if(!file_exists($path)){  
	            mkdir($path,0777,true);  
	            chmod($path,0777);  
	        }  
	          
	        //新文件名唯一  
	        $uniName=$this->getUniName();  
	        $destination=$path.$uniName.'.'.$ext;  
	          
	        //@符号是为了不让客户看到错误信，也可以删除  
	        if(!@move_uploaded_file($fileInfo['tmp_name'],$destination)){  
	            $res['mes']=$fileInfo['name'].'文件移动失败';  
	        }  
	        $res['mes']=$fileInfo['name'].'上传成功';  
	        $res['dest']=$destination; 
	        // echo  $res['dest'];
	        return $res;  
	    }else{  
	        //匹配错误信息  
	        //注意！错误信息没有5  
	        switch($fileInfo['error']){  
	            case 1:  
	                $res['mes'] = '上传文件超过了PHP配置文件中upload_max_filesize选项的值';  
	                break;  
	            case 2:  
	                $res['mes'] = '超过了HTML表单MAX_FILE_SIZE限制的大小';  
	                break;  
	            case 3:  
	                $res['mes'] = '文件部分被上传';  
	                break;  
	            case 4:  
	                $res['mes'] = '没有选择上传文件';  
	                break;  
	            case 6:  
	                $res['mes'] = '没有找到临时目录';  
	                break;  
	            case 7:  
	                $res['mes'] = '文件写入失败';  
	                break;  
	            case 8:  
	                $res['mes'] = '上传的文件被PHP扩展程序中断';  
	                break;  
	                  
	        }     
	        return $res;  
	    }  
	} 

	/** 
	 * 构建上传文件信息 
	 * @return mixed 
	 */  
	function getFiles() {  
	    // $i = 0;
	    $files = [];  
	    echo '<pre>';
	    echo '<pre>';
	    var_dump($_FILES);
	    exit();
	    foreach($_FILES as $index => $file) {  
	        //单文件或者多个单文件上传  
	        if(is_string($file['name'])) {  
	            $files[$index] = $file;  
	            // $i++;  
	        } //多文件上传  
	        elseif(is_array($file['name'])) {  
	            foreach($file['name'] as $key=>$val) {  
	                $files[$key]['name'] = $file['name'][$key];  
	                $files[$key]['type'] = $file['type'][$key];  
	                $files[$key]['tmp_name'] = $file['tmp_name'][$key];  
	                $files[$key]['error'] = $file['error'][$key];  
	                $files[$key]['size'] = $file['size'][$key];  
	                // $i++;  
	            }  
	        }  
	    }  
	    return $files;  
	} 

	/** 
	 * 获取文件扩展名 
	 */  
	function getExt($filename) {  
	    return strtolower(pathinfo($filename,PATHINFO_EXTENSION));  
	} 

	/** 
	 * 获取唯一字符串 
	 */  
	function getUniName() {  
	    return md5(uniqid(microtime(true), true));  
	}

	// 封装打印函数
	function dump($info)
	{
		echo '<pre>';
			print_r($info);
		echo '</pre>';
	}

	// 查找市级信息
	function city()
	{
		$province_id = $this->input->post('province_id');
		if(isset($province_id) && $province_id !== ''){
			$this->load->model('region_mdl');
			$city = $this->region_mdl->get_city($province_id);
			echo json_encode(['code'=>1, 'data'=>$city]);
		}
	}



	// 校验订单
	public function check_order_no($order_no)
	{
		$corporation_id = $this->session->userdata('corporation_id');
		$this->load->model('customer_corporation_mdl');
		if(isset($corporation_id) && $corporation_id != ''){
			$data['corporation_info'] = $this->customer_corporation_mdl->get_customer_status($corporation_id);
		}
		if($data['corporation_info']['order_no'] == $order_no && $data['corporation_info']['is_paied'] == 0 ){
			return $order_no;
		}else{
			return '';
		}
	}

	/**
	* 商家入驻资讯
	*/
	public function merchant_content()
	{
		// 获取商家入驻频道
		$this->load->model('content_mdl');

		$channel = $this->content_mdl->get_channel();

		$channel_id = $channel[10]['id']; 

		// 获取商家入驻资讯
		if($channel_id){

			$content_info = $this->content_mdl->get_merchant_content($channel_id);

		}

		return $content_info;
	}

	/**
	* 商家入驻要求
	*/
	public function merchant_requirement()
	{
		$data = [];
	
		// 商家入驻资讯
		$content_info = $this->merchant_content();

		// 商家入驻要求
		$data['content_info'] = $content_info[0];
		// var_dump($data['content_info']);
		// $data ['status'] = $status;
        $data ['title'] = '商家入驻要求';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;

		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/rule_page1', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}

	/**
	* 商家管理规则总则
	*/
	public function merchant_mrule()
	{
		$data = [];
		// $data ['status'] = $status;
		// 商家入驻资讯
		$content_info = $this->merchant_content();
		$data['content_info'] = $content_info[1];
		// var_dump($data['content_info']);

        $data ['title'] = '商家管理规则总则';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;

		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/rule_page2', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}

	/**
	* 商家商品发布规范
	*/
	public function merchant_prule()
	{
		$data = [];
		// $data ['status'] = $status;
		// 商家入驻资讯
		$content_info = $this->merchant_content();
		$data['content_info'] = $content_info[2];

        $data ['title'] = '商家商品发布规范';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;

		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/rule_page3', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}


	/**
	* 订单处理及售后规范总则
	*/
	public function merchant_osrule()
	{
		$data = [];
		// $data ['status'] = $status;

		// 商家入驻资讯
		$content_info = $this->merchant_content();
		$data['content_info'] = $content_info[3];

        $data ['title'] = '订单处理及售后规范总则';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;

		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/rule_page4', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}

	/**
	* 订单处理及售后规范总则
	*/
	public function merchant_illegal_rule()
	{
		$data = [];
		// $data ['status'] = $status;
		// 商家入驻资讯
		$content_info = $this->merchant_content();
		$data['content_info'] = $content_info[4];

        $data ['title'] = '订单处理及售后规范总则';
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;

		$this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('merchant/rule_page5', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
	}

	/**
	* 邀请人校验
	*/
	public function ajax_check_phone()
	{
		$phone = $this->input->post('phone');

		if($phone){
			$this->load->model('customer_mdl');
			$result = $this->customer_mdl->get_customer_by_phone($phone);

			if($result){
				echo json_encode(['code'=> 1, 'msg' => '通过']);
			}else{
				echo json_encode(['code'=> 0, 'msg' => '暂无该邀请人']);	
			}
		}
		

	}
	

}

