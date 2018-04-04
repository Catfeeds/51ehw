<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 订单信息相关
 * @author Muke
 *
 */
class order_att extends Front_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 地区三级联动
	 * 根据ajax反馈的父id，返回所有子集 （json格式）
	 *
	 */
	function select_children()
	{
		$segments = $this->uri->uri_to_assoc();
		$this->load->model('region_mdl');
		$data['children']   = $this->region_mdl->children_of($segments['parent_id']);
		echo json_encode($data['children']);
	}
	
	public function consignee_list()
	{
		if(!$this->session->userdata('user_in'))
		{
			$data['address'] = array();
			
		}else{
			//收货地址
			$this->load->model('customer_address_mdl');
			$data['address'] = $this->customer_address_mdl->load_all($this->session->userdata('user_id'));
		}
		$this->load->view('order/consignee_list',$data);
	}
	
	//编辑收货地址
	public function consignee_edit()
	{
		
		$data =array();
		$data['address'] = array('province_id'=>null,
								 'city_id'=>null,
								 'district_id'=>null,
								'consignee'=>null,
								'postcode'=>null,
								'address'=>null,
								'mobile'=>null,
								'phone'=>null,
								'email'=>null);
		
		$this->load->view('order/consignee_edit',$data);
	}
	
	//保存收货地址
	public function consignee_save()
	{
		$consignee = $this->input->post('consignee');
		$province_id = $this->input->post('province_id');
		$city_id = $this->input->post('city_id');
		$district_id = $this->input->post('district_id');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$mobile = $this->input->post('mobile');
		$address = $this->input->post('address');
		$postcode = $this->input->post('postcode');
		
		$customer_id = $this->session->userdata('user_id');
		
		//添加新收货地址
		$this->load->model('customer_address_mdl');
		$this->customer_address_mdl->customer_id = $customer_id;
		$this->customer_address_mdl->consignee = $consignee;
		$this->customer_address_mdl->phone = $phone;
		$this->customer_address_mdl->mobile = $mobile;
		$this->customer_address_mdl->province_id = $province_id;
		$this->customer_address_mdl->city_id = $city_id;
		$this->customer_address_mdl->district_id = $district_id;
		$this->customer_address_mdl->address = $address;
		$this->customer_address_mdl->postcode = $postcode;
		
		if($this->customer_address_mdl->create(1))
		{
			echo 1;
		}
		
// 		print_r($this->customer_address_mdl->create(0));
	}
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */