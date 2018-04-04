<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends Front_Controller {
	
	public function __construct()
	{
		parent::__construct();
		//判断用户是否登录
		if (!$this->session->userdata('user_in')){
			redirect('customer/login');
			exit();
		}
	}
	
	//常见问题列表
	public function index()
	{
// 		$user_id = $this->session->userdata('user_id');
// 		$this->load->model('order_mdl');
// 		$data['orders'] = $this->order_mdl->find_customer_orders_with_goods($user_id,null,0,0);
// 		print_r($data['orders']); 
// 		exit();

		$this->load->model('faq_mdl');
		
		
		//分页设置
		$this->load->library('pagination');
		$config['base_url'] = site_url('member/faq/index');
		$config['total_rows'] = $this->faq_mdl->count_orders();
		$config['per_page'] = 12;
		$config['uri_segment'] = 4;
		$config['num_links'] = 6;
		$config['full_tag_open'] = '<ul class="page">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = FALSE ;
		$config['last_link'] = FALSE ;
		$config['next_link'] = '下一页';//lang('page_next');
		$config['next_tag_open'] = '<li class="next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '上一页';//lang('page_prev');
		$config['prev_tag_open'] = '<li class="prev">';//'<li class="prev">';
		$config['prev_tag_close'] = '</li>';//'</li>';
		$config['cur_tag_open'] = '<li class="current">';
		$config['cur_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		$data['title'] = '帮助';
		$data['lists'] = $this->faq_mdl->find_faqs($config['per_page'],$this->uri->segment($config['uri_segment'], 0));
// 		print_r($data['lists']);

        $data['head_set'] = 3;
        $data['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view('customer/faq_list',$data);
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	//问题详情
	public function detail($id=0)
	{
		if(!$id)
		{
			//跳转404页面
			redirect('member/faq');
		}
		
		$this->load->model('faq_mdl');
		$data['detail'] = $this->faq_mdl->load($id);
		
		if(!$data['detail'])
		{
			//跳转404页面
			redirect('member/faq');
		}

		$data['title'] = $data['detail']['title'];
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view('customer/faq_detail',$data);
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	
	
	
}