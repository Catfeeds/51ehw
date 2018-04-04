<?php
/**
 * 内容控制器
 */
class Content extends Front_Controller
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
		if ($section_id == 0) {
			show_404();
		}
		
		$this->load->model('content_mdl');
		$data['contents'] = $this->content_mdl->get_list($section_id);
		$data['head_set'] = 3;
		$this->load->model('section_mdl');
		$data['section'] = $this->section_mdl->load($section_id);
		$data['title'] = $data['section']['section_name'];
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
	    $this->load->view('content/list_view',$data);
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	function detail($content_id = 0){
		if ($content_id == 0) {
			show_404();
		}
		
		$this->load->model('content_mdl');
		$data['contents'] = $this->content_mdl->get_detail($content_id);
		
		$data['title'] = $data['contents']['title'];
		$data['head_set'] = 3;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
	    $this->load->view('content/detail_view',$data);
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
}