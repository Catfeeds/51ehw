<?php
/**
 * 内容控制器
 */
class Wechat_group extends Front_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	 
	// --------------------------------------------------------------------

	/**
	 * 内容列表
	 *
	 *
	 */
	function index($section_id = 0)
	{
		
		
	}
	
	function get_list($section_id = 0){
		//$this->load->model('section_mdl');
		
		$this->load->model('content_mdl');
		$data['contents'] = $this->content_mdl->get_list($section_id);
		$data['head_set'] = 3;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
	    $this->load->view('content/list_view',$data);
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
}
?>