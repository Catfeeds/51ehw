<?php
/**
 * 用户中心 > 首页
 *
 *
 */
class Home extends Front_Controller {
	function __construct() {
		parent::__construct();
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'login' );
			exit ();
		}
	}
	function index() {
		$this->load->model ( 'customer_mdl' );
		$data = array ();
		$data ['css'] [0] = "<link type='text/css' rel='stylesheet' href='" . base_url () . "css/userhome.css'>";
		$data ['css'] [1] = "<link type='text/css' rel='stylesheet' href='" . base_url () . "css/user_userinfo.css'>";
		$data ['title'] = '我的xx';
		
		$this->load->model ( 'customer_mdl' );
		$data ['customer'] = $this->customer_mdl->load ( $this->session->userdata ( 'user_id' ) );
		$data['head_set'] = 2;
        $data['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/home', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
}
