<?php
/**
 * 用户中心 > 个人信息
 *
 *
 */
class Info extends Front_Controller {
	function __construct() {
		parent::__construct ();
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'login' );
			exit ();
		}
	}
	function index() {
		$data = array ();
		$data ['css'] [0] = "<link type='text/css' rel='stylesheet' href='" . base_url () . "css/userhome.css'>";
		$data ['css'] [1] = "<link type='text/css' rel='stylesheet' href='" . base_url () . "css/user_userinfo.css'>";
		$data ['title'] = '个人资料';
		
		$this->load->model ( 'customer_mdl' );
		$data ['customer'] = $this->customer_mdl->load ( $this->session->userdata ( 'user_id' ) );
		
		$this->load->model ( 'customer_address_mdl' );
		$data ['address'] = $this->customer_address_mdl->load ( $data ['customer'] ['id'] );
		if (empty ( $data ['address'] )) {
			$data ['address'] = array (
					'id' => null,
					'address_name' => null,
					'consignee' => null,
					'phone' => null,
					'mobile' => null,
					'invoice_head' => null,
					'province_id' => null,
					'city_id' => null,
					'district_id' => null,
					'address' => null,
					'postcode' => null,
					'fax' => null,
					'remark' => null,
					'is_default' => null 
			);
		}
		$data['head_set'] = 3;
        $data['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/info', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 提交数据
	 */
	function save() {
		$consignee = $this->input->post ( 'consignee' );
		$dob = $this->input->post ( 'dob' );
		$province_id = $this->input->post ( 'province_id' );
		$city_id = $this->input->post ( 'city_id' );
		$district_id = $this->input->post ( 'district_id' );
		$email = $this->input->post ( 'txtEmail' );
		$phone = $this->input->post ( 'txtTel' );
		$mobile = $this->input->post ( 'txtMobile' );
		$address = $this->input->post ( 'txtAddress' );
		$postcode = $this->input->post ( 'txtZipCode' );
		$remark = $this->input->post ( 'txtRemark' );
		
		$this->load->model ( 'customer_mdl' );
		$this->customer_mdl->dob = $dob;
		$this->customer_mdl->email = $email;
		$this->customer_mdl->update ( $this->session->userdata ( 'user_id' ) );
		
		$this->load->model ( 'customer_address_mdl' );
		$this->customer_address_mdl->consignee = $consignee;
		$this->customer_address_mdl->phone = $phone;
		$this->customer_address_mdl->mobile = $mobile;
		$this->customer_address_mdl->province_id = $province_id;
		$this->customer_address_mdl->city_id = $city_id;
		$this->customer_address_mdl->district_id = $district_id;
		$this->customer_address_mdl->address = $address;
		$this->customer_address_mdl->postcode = $postcode;
		$this->customer_address_mdl->remark = $remark;
		$this->customer_address_mdl->update ( $this->session->userdata ( 'user_id' ) );
		
		redirect ( 'customer/info' );
	}
}