<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Score_log extends Front_Controller {
	
	public function __construct()
	{
		parent::__construct();
		//判断用户是否登录
		if (!$this->session->userdata('user_in')){
			redirect('customer/login');
			exit();
		}
	}
	
	public function index()
	{
		//$this->info();
	}
	
	public function get_list(){
		$customer_id = $this->session->userdata('user_id');
		$this->load->model('score_log_mdl');
		$data['score_logs'] = $this->score_log_mdl->get_list($customer_id, 1);
		$data['score_used_logs'] = $this->score_log_mdl->get_list($customer_id, 0);
        $data['head_set'] = 3;
		$this->load->view ( 'head' );
		$this->load->view ( '_header', $data );
		$this->load->view('customer/score_log', $data);
		$this->load->view ( '_footer' );
		$this->load->view ( 'foot' );
		
	}
}
?>