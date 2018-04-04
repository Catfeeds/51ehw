<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 会员管理控制器
 * 
 * 查看会员列表
 * 
 * @author 		Clark So
 * @copyright 	Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license		http://www.9-leaf.com/
 * @link		http://www.9-leaf.com/
 * @since		Version 1.0
 * @filesource
 *
 */
class Customer extends Front_Controller {
	
	// --------------------------------------------------------------------
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'customer/login' );
			exit ();
		}
		$this->load->model ( 'customer_mdl' );
		$this->load->model ( 'corporation_mdl' );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 获取列表
	 * 带分页功能 
	 */
	public function get_list(){
	    $corporation_id = $this->session->userdata['corporation_id'];
	    $customer_name  = $this->input->get_post('customer_name');
	    
	    $this->load->library('pagination');
	    $config['per_page'] = 10;
	    $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    
	    $data['list'] = $this->customer_mdl->get_list($corporation_id,$offset,$config['per_page'],$customer_name);
	    $config['base_url'] = site_url('corporate/customer/get_list').'?/';
	    $config['total_rows'] = $this->customer_mdl->count_customer( $corporation_id, $customer_name);
	    $config['use_page_numbers']   = TRUE;
	    $config['page_query_string']  = TRUE;
	    $config['num_links'] = 3; //可以看到当前页后面的3页a连接
	    $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
	    $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
	    $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
	    $config['prev_tag_css'] = 'class="lPage"';
	    $config['next_link'] = '下一页';
	    $config['next_tag_css'] = 'class="lPage"';
	    $config['first_link'] = '<<';
	    $config['last_link'] = '>>';
	    
	    
	    $this->pagination->initialize($config);
	    
	    $data['total_rows'] = $config['total_rows'];
	    $data['per_page'] = $config['per_page'];
	    $data['cu_page'] = $current_page;
	    $data['page'] =  $this->pagination->create_links();
	    $data['title'] = $this->session->userdata('app_info')['app_name'];
	    
	    //$this->load->view ( 'head');
	    $this->load->view ( 'head',$data);
	    $this->load->view ( '_header' ,$data);
	    $this->load->view ('corporate/customer/list',$data);
	    $this->load->view ( '_footer',$data);
	    $this->load->view ( 'foot',$data);

	   
		
	}

    
	/**
	 * 客户的消费记录
	 * @param int $customer_id 客户ID。
	 */
    public function customer_consume_list( $customer_id ){ 
        $corporation_id = $this->session->userdata['corporation_id'];
        $product_name  = $this->input->get_post('product_name');
        $this->load->library('pagination');
        $config['per_page'] = 10; //每页显示几条数据
        $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
        if(0 == $current_page)
        {
            $current_page = 1;
        }
        $offset   = ($current_page - 1 ) * $config['per_page'];
//         echo $offset;
        $data['list'] = $this->customer_mdl->customer_consume_list( $customer_id ,$offset, $config['per_page'], $product_name,$corporation_id);
//         echo $this->db->last_query();
        $config['base_url'] = site_url('corporate/customer/customer_consume_list/'.$customer_id).'/?';
        $config['total_rows'] = $this->customer_mdl->count_consume_list( $customer_id, $product_name,$corporation_id);
        $config['use_page_numbers']   = TRUE;
        $config['page_query_string']  = TRUE;
        $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config ['prev_tag_css'] = 'class="lPage"';
        $config ['next_link'] = '下一页';
        $config ['next_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        
        if( $product_name ) $config['base_url'].="&product_name=".$_GET['product_name'];
        $data['total_rows'] = $config['total_rows'];
        $data['per_page'] = $config['per_page'];
        $data['cu_page'] = $current_page;
        $this->pagination->initialize($config);
        $data['page'] =  $this->pagination->create_links();
        $data['title'] = $this->session->userdata('app_info')['app_name'];
        
        $this->load->view ( 'head',$data);
        $this->load->view ( '_header' ,$data);
        $data['customer_id'] = $customer_id;
        $this->load->view ('corporate/customer/consume_list',$data);
        $this->load->view ( '_footer',$data);
        $this->load->view ( 'foot',$data);
    }


	// --------------------------------------------------------------------
	
	/**
	 * 审批商品
	 */
	public function check(){
	    $this->load->view ( 'head');
	    $this->load->view ( '_header' );
	    $this->load->view ( 'corporate/customer/check_view');
	    $this->load->view ( '_footer');
	    $this->load->view ( 'foot');
	}

	// --------------------------------------------------------------------
	
	/**
	 * 等级管理
	 */
	public function grade(){
	    $this->load->view ( 'head');
	    $this->load->view ( '_header' );
	    $this->load->view ( 'corporate/customer/grade_view');
	    $this->load->view ( '_footer');
	    $this->load->view ( 'foot');
	}

}