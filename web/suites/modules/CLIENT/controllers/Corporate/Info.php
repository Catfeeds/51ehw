<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Info extends Front_Controller {
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'customer/login' );
			exit ();
		}
		$this->load->model ( 'customer_mdl' );
		$this->load->model('order_comments_mdl','order_comments');
		$this->load->model ( 'corporation_mdl' );
		$this->load->model ( 'customer_address_mdl' );
	}
	public function index() {
		$this->info ();
	}

	// 用户资料界面
	public function info() {

		$account_id = $this->session->userdata ( 'user_id' );
		$corporation_id = $this->session->userdata ( 'corporation_id' );
		// 获取用户资料
		$data ['customer'] = $this->customer_mdl->load ( $account_id );

		//获取账户资金
		$relation_id = $this->session->userdata ('pay_relation');
		//查询账户余额
		$url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
		$data['pay_info'] = json_decode($this->curl_get_result($url),true);

		// 获取企业资料
		$data ['corporation'] = $this->corporation_mdl->load_corp_info ( $corporation_id );

		// 企业为冻结状态，退出。
		if($data['corporation']['status'] == 2){
		    echo "<script>alert('企业状态被冻结');</script>";
            echo "<script>window.history.back(-1); </script>";
        }


		if( empty($data ['corporation']['id']) ){
		    redirect('customer/reg_error');
		}
		if($data['corporation']['status'] == 0 && $data ['corporation']['approval_status']!="2"){
		    redirect('customer/is_authenticate');
		}

// 		// 获取默认收货地址
// 		$data ['address'] = $this->customer_address_mdl->load ( $account_id );
// 		$this->session->set_userdata('corporation_status',$data ['corporation']['status']);

// 		$this->load->model ( 'order_mdl' );
// 		$this->load->model ( 'product_mdl' );
// 		$data ['count_unfinished_orders'] = $this->order_mdl->count_unfinish_orders ( $account_id );
// 		$data ['count_wait_dispatch'] = $this->order_mdl->count_wait_dispatch($corporation_id);//统计未发货的订单数量
// 		$data ['count_wait_comments'] = $this->order_comments->all_comments ($corporation_id ,'', '','','1');//统计未处理的评价
// 		$data ['count_wait_product']  = $this->product_mdl->count_wait_product($account_id);

// 		if (! $data ['address']) {
// 			$data ['address'] = array (
// 					'phone' => null,
// 					'mobile' => null,
// 					'address' => null,
// 					'email' => null,
// 					'postcode' => null,
// 					'address_for_name' => null
// 			);
// 		}

		$data ['title'] = '企业会员中心';
		$data ['head_set'] = 2;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'corporate/info', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}

	// 修改用户资料
	public function info_edit() {
		// 获取用户资料
		$data ['customer'] = $this->customer_mdl->load ( $this->session->userdata ( 'user_id' ) );
		// 获取默认收货地址
		$data ['address'] = $this->customer_address_mdl->load ( $this->session->userdata ( 'user_id' ) );
		if (! $data ['address']) {
			$data ['address'] = array (
					'phone' => null,
					'mobile' => null,
					'address' => null,
					'email' => null,
					'postcode' => null,
					'province_id' => null,
					'city_id' => null,
					'district_id' => null,
					'address_for_name' => null
			);
		}

		$data ['head_set'] = 3;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/info_edit', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}

	// 保存用户资料
	public function info_save() {
		// print_r($_POST);
		// exit();

		// 获取用户资料
		$data ['customer'] = $this->customer_mdl->load ( $this->session->userdata ( 'user_id' ) );
		// 获取默认收货地址
		$data ['address'] = $this->customer_address_mdl->load ( $this->session->userdata ( 'user_id' ) );

		$address_id = $data ['address'] ['id'];
		$consignee = $data ['address'] ['consignee'];
		$province_id = $this->input->post ( 'province_id' );
		$city_id = $this->input->post ( 'city_id' );
		$district_id = $this->input->post ( 'district_id' );
		$email = $this->input->post ( 'email' );
		$phone = $this->input->post ( 'phone' );
		$mobile = $this->input->post ( 'mobile' );
		$address = $this->input->post ( 'address' );
		$postcode = $this->input->post ( 'postcode' );

		$customer_id = $this->session->userdata ( 'user_id' );

		$this->customer_address_mdl->customer_id = $customer_id;
		$this->customer_address_mdl->consignee = $consignee;
		$this->customer_address_mdl->phone = $phone;
		$this->customer_address_mdl->mobile = $mobile;
		$this->customer_address_mdl->province_id = $province_id;
		$this->customer_address_mdl->city_id = $city_id;
		$this->customer_address_mdl->district_id = $district_id;
		$this->customer_address_mdl->address = $address;
		$this->customer_address_mdl->postcode = $postcode;
		$this->customer_address_mdl->email = $email;

		// 更新
		$this->customer_address_mdl->update ( $address_id, $customer_id );

		$sex = $this->input->post ( 'sex' );
		$birthday = $this->input->post ( 'birthday' );
		$job = $this->input->post ( 'job' );

		$this->db->set ( 'sex', $sex );
		$this->db->set ( 'birthday', $birthday );
		$this->db->set ( 'job', $job );
		$this->db->set ( 'email', $email );
		$this->db->set ( 'phone', $phone );
		$this->db->set ( 'mobile', $mobile );

		$this->db->where ( 'id', $customer_id );

		$this->db->update ( 'customer' );

		redirect ( 'member/info' );
	}

	// 修改用户密码界面
	public function pwd_edit() {
		$data ['error_msg'] = $this->uri->segment ( 4, 0 );

		// print_r($data['error_msg']);
		// exit();
		$data ['title'] = "修改密码";
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/changepwd', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}

	// 保存用户密码
	public function pwd_save() {
		$old_pwd = $this->input->post ( 'txtOldPwd' );
		$new_pwd = $this->input->post ( 'txtNewPwd' );

		// echo $new_pwd;
		// echo $this->customer_mdl->update_pwd($this->session->userdata('user_id'),$new_pwd);
		// exit();

		$this->load->model ( 'customer_mdl' );
		if ($this->customer_mdl->check_pwd ( $old_pwd )) {
			// 验证新旧密码是否一致
			if ($this->customer_mdl->check_pwd ( $new_pwd )) {
				redirect ( 'member/info/pwd_edit/pw_repeat' );
			} else {
				if ($this->customer_mdl->update_pwd ( $this->session->userdata ( 'user_id' ), $new_pwd )) {
					header ( "Content-type: text/html; charset=utf-8" );
					echo "<script>alert('密码修改成功');location.href='" . site_url ( 'member/info' ) . "';</script>";
				}
			}
		} else {
			redirect ( 'member/info/pwd_edit/pw_error' );
		}
	}

	//--------------------------------------------------------
	/**
	 * 异步更新店铺最新状态
	 */
	public function corp_update(){
	    $user_id = $this->session->userdata("user_id");
	    //查询判断我是否企业员工，如果是把管理的企业写入session
	    $this->load->model("corporation_staff_mdl");
	    $staff = $this->corporation_staff_mdl->corp_manage($user_id);
	    if(count($staff) > 0){
	        $customer['is_staff'] = true;
	        $corplist = array();
	        foreach ($staff as $v){
	            $corplist[] = $v;
	        }
	        $this->session->userdata("corp_list",$corplist);
	        $data['corplist'] =$corplist;
	        echo json_encode($data);
	    }
	}
	/**
	 * 切换管理店铺
	 */
	public function corp_change(){
	    $corporation_id = $this->input->post("corp_id");//店铺id
	    $customer_id = $this->session->userdata("user_id");//用户id
	    //验证数据
	    if($corporation_id>0 && is_numeric($corporation_id)){
	        //查询判断用户是否有权限管理店铺，如果没有权限则更新企业管理信息
	        $this->load->model("corporation_staff_mdl");
	        $my_power = $this->corporation_staff_mdl->get_staff_authority($corporation_id,$customer_id);
	        if($my_power){//有权限执行
	            $this->load->model("corporation_mdl");
	            $corp_info = $this->corporation_mdl->load_corp_info($corporation_id);
	            $customer['corporation_id'] = $corporation_id;
	            $customer['corp_customerid'] = $corp_info['customer_id'];//企业用户id
	            $customer["power"] = "";
	            foreach ($my_power as $v){
	                $customer["power"] .= ','.$v['url'].',';
	            }
	            $this->session->set_userdata($customer);
	            echo json_encode(array("status"=>1));//成功
	            exit();
	        }else{//没有权限执行
	            //更新企业管理信息
	            $customer['is_staff'] = false;//默认没权限

	            $staff = $this->corporation_staff_mdl->corp_manage($customer_id);
	            if(count($staff) > 0){
	                $customer['is_staff'] = true;
	                $corplist = array();
	                foreach ($staff as $v){
	                    $corplist[] = $v;
	                }
	                $customer['corp_list'] = $corplist;
	            }

	            $this->session->set_userdata($customer);
	            echo json_encode(array("status"=>2));//权限被冻结
	            exit();
	        }

	    }else{
	        echo json_encode(array("status"=>3));//非法操作
	        exit();
	    }
	}


	//------------------------------------------------------

	/**
	 * 员工绑定企业提示页面
	 */
	function staff_prompt(){
	    echo "你没资格";
	}

}