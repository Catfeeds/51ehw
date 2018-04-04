<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper extends Front_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function index()
	{
		$this->load->view('helper/member');
	}
	
	public function detail($sign)
	{
		$view = "helper/".$sign;
		
// 		echo $view;
		
		$this->load->view($view);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */