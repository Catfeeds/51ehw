<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class notice extends Front_Controller {
	
	/**
	 * 
	 */
	public function __construct() {
		parent::__construct ();
	}
	  
	// --------------------------------------------------------------------
	
	/**
	 * 
	 */
	public function index() {
		$app = $this->session->userdata ( 'app_info' );

		$key = $this->input->get("key");

		
		$this->load->model ( 'content_mdl' );
		$data ["app_id"] = $app ['id'];


		$this->load->library('pagination');
	    $config['per_page'] = 20;
	    $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	  
	    $data['list'] = $this->content_mdl->getList ($offset,$config['per_page'], $app ['id'],$key);
	    
	    $config['base_url'] = site_url('notice').'/?';
	
	    $config['total_rows'] = $this->content_mdl->countList( $app['id'],$key);
	    
	    $config['use_page_numbers']   = TRUE;
	    $config['page_query_string']  = TRUE;
	    $config['num_links'] = 3; //可以看到当前页后面的3页a连接
	    $config ['next_link'] = '下一页';
	    $config ['next_tag_css'] = 'class="gongying_fenye_next"';
	    $config ['prev_link'] = '上一页';
	    $config ['prev_tag_css'] = 'class="gongying_fenye_last"';
	    $config ['first_link'] = '首页';
	    $config ['first_tag_css'] = 'class="gongying_fenye_last"';
	    $config ['last_link'] = '尾页';
	    $config ['last_tag_css'] = 'class="gongying_fenye_last"';
	    $config ['cur_tag_open'] = '<span class="gongying_fenye_xuanzhong" style="margin:0 3px 0 5px;"><a >';
	    $config ['cur_tag_close'] = '</a></span>';
	    
	    if( isset($key) )$config['base_url'].="&key=".$key;
	    $data['search'] = $key;
	    $this->pagination->initialize($config);
	    $data ['pagination'] = $this->pagination->create_links ();
	    $data['todaynotice'] = $this->content_mdl->getList(0, 20,$app['id'],$key = '');
	    
	    $data['total_rows'] = $config['total_rows'];
	    $data['per_page'] = $config['per_page'];
	    $data['cu_page'] = $current_page;
	    $data['title'] = '公告';

//         print_r($data);exit;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'notice', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 公告详请
	 */
	public function detail($id){
	    
	    $this->load->model('content_mdl');
	    $app = $this->session->userdata('app_info');
	    $data['detail'] = $this->content_mdl->load($id);

	    $data['new_notice'] = $this->content_mdl->getList(0, 20,$app['id'],$key = '');

	    $data['title'] = '公告详情';

	    $this->load->view ( 'head', $data );
	    $this->load->view ( '_header', $data );
	    $this->load->view ( 'notice_detail', $data );
	    $this->load->view ( '_footer', $data );
	    $this->load->view ( 'foot', $data );
	    
	}
	
}

