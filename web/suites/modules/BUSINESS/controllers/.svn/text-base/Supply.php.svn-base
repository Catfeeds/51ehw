<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Supply extends Front_Controller {
	
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

		$cateid = $this->input->post("cateid");
		$key = $this->input->post("key");

		
		$this->load->model ( 'goods_mdl' );
		$this->load->model('requirement_cate_mdl','recate');
		$data ["app_id"] = $app ['id'];


		$this->load->library('pagination');
	    $config['per_page'] = 1;
	    $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    
	    $data['list'] = $this->goods_mdl->getRequirementList ($offset,$config['per_page'], 0,$key,$cateid);//$app ['id']
	    $config['base_url'] = site_url('supply').'/?';
	    $config['total_rows'] = $this->goods_mdl->countRequirementList( 0,$key,$cateid);//$app ['id']
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
	    $config ['cur_tag_open'] = '<span class="gongying_fenye_xuanzhong" style="margin:0 3px 0 5px;"><a>';
	    $config ['cur_tag_close'] = '</a></span>';
	    
	    
	    
	    $this->pagination->initialize($config);
	    //获取分类列表
	    $data['res'] = $this->recate->getList();
	    $data['total_rows'] = $config['total_rows'];
	    $data['per_page'] = $config['per_page'];
	    $data['cu_page'] = $current_page;
	    $data['page'] =  $this->pagination->create_links();
        $data['title'] = '供应信息';
        //print_r($data);exit;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'supply', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------
	
	
}

