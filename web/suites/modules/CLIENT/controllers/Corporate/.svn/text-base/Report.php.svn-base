<?php  
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 需求管理控制器
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
class Report extends Front_Controller {
	
	// --------------------------------------------------------------------
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_id' )) {
			redirect ( 'customer/login' );
			exit ();
		}
		
		if(! $this->session->userdata ( 'corporation_id' )&&$this->session->userdata ( 'status' )!=1) {
			redirect ( 'member/info' );
			exit ();
		}
		$this->load->model('order_rebate_mdl','or');
		$this->load->model('corporation_mdl','cc');
	}
	
	// --------------------------------------------------------------------

	
	//---------------------------------------------------------------------

	function subordinate(){
	    
	    $my_customer_id = $this->session->userdata('user_id');	
        
	    //根据条件进行查询
	    $select_id = $this->input->get_post("product_score");
	    switch ($select_id){
	        case 1 :
	            $customer_id = $this->input->get_post("customer_id");
	            $condition['customer_id'] = $customer_id;
	            $data['customer_id'] = $customer_id;
	            break;
	        case 2 :
	            $corporation_name = $this->input->get_post("corporation_name");
	            $condition['corporation_name'] = $corporation_name;
	            $data['corporation_name'] = $corporation_name;
	            break;
	        case 3 :
	            $name = $this->input->get_post("name");
	            $condition['name'] = $name;
	            $data['name'] = $name;
	            break;
	    }
	    $start_time = $this->input->get_post("start_time");
	    $end_time = $this->input->get_post("end_time");
	    $is_notrebate = $this->input->get_post("is_notrebate");
	    //条件组合成数组
	    $condition['select_id'] = $select_id;
	    $condition['start_time'] = $start_time;
	    $condition['end_time'] = $end_time;
	    $condition['is_notrebate'] = $is_notrebate;	
	    $data['select_id'] = $select_id;
	    $data['start_time'] = $start_time;
	    $data['end_time'] = $end_time;
	    $data['is'] = $is_notrebate;

        //分页的链接(是否有根据条件)
	    $config['base_url'] = site_url('corporate/report/subordinate/?');
        if($select_id||$start_time||$end_time||$is_notrebate)
        {
            if($select_id)
            {
            switch ($select_id)
            {
                case 1 :
                    $config['base_url'] .= "&product_score=".$select_id."&customer_id=".$customer_id."&start_time=".$start_time."&end_time=".$end_time."&is_notrebate=".$is_notrebate;
                    break;
                case 2 :
                    $config['base_url'] .= "&product_score=".$select_id."&corporation_name=".$corporation_name."&start_time=".$start_time."&end_time=".$end_time."&is_notrebate=".$is_notrebate;
                    break;
                case 3 :
                    $config['base_url'] .= "&product_score=".$select_id."&name=".$name."&start_time=".$start_time."&end_time=".$end_time."&is_notrebate=".$is_notrebate;
                    break;
            }
            }
            else
            {
                $config['base_url'] .= "&product_score=".$select_id."&start_time=".$start_time."&end_time=".$end_time."&is_notrebate=".$is_notrebate;
            }
        }
            
        //统计条数-统计分成金额用；
        $data['row'] = $this->or->getList($condition,$my_customer_id,true);
	    //分页
	    $config['per_page'] = 5;
	    $current_page = $this->input->get_post('per_page',true);
	    if($current_page==0) $current_page = 1;
	    $offset = $current_page*$config['per_page']-$config['per_page'];
	    $this->load->library('pagination');
	    $config['curr_page'] = $current_page;
	    $config['use_page_numbers'] = TRUE;
	    $config['page_query_string'] = TRUE;
	    $config['num_link'] = 4;
	    $config['next_link'] = '下一页';
	    $config['prev_link'] = '上一页';
	    $config['next_tag_css'] = 'class="lPage"';
	    $config['prev_tag_css'] = 'class="lPage"';
	    $config['first_link'] = '<<';
	    $config['last_link'] = '>>';
	    $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
	    $config['cur_tag_close'] = '</a>';    	    
	    $config['total_rows'] = $data['row']['count'];   
	    $this->pagination->initialize ( $config );
	    $data['per_page'] = $config['per_page'];
	    $data['cu_page'] = $current_page;
	    $data ['pagination'] = $this->pagination->create_links ();
	    
	    //下线列表
	    $data['rebate'] = $this->or->getList($condition,$my_customer_id,false,$config['per_page'],$offset);
// 	    echo $this->db->last_query();
	    
//         echo '<pre>';
//         var_Dump($data['rebate']);exit;
	    //获取分成总额
	   
	    
// 	    $data['corporate'] = $this->cc->load($condition['customer_id']);
	    
// 	    print_r($data);exit;
		$data ['title'] = '下线分成';
		$data ['head_set'] = 2;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head');
	    $this->load->view ( '_header' );
	    $this->load->view ( 'corporate/report/subordinate',$data);
	    $this->load->view ( '_footer');
	    $this->load->view ( 'foot'); 
	}
	
	function divided_into (){
	    
	    
	    $condition['customer_id'] = $this->session->userdata('user_id');
	    $condition['is_notrebate'] = 1;
	    
	    $select_id = $this->input->get_post("product_score");
	    switch ($select_id){
	        case 1 :
	            $order_sn = $this->input->get_post("order_sn");
	            $condition['order_sn'] = $order_sn;
	            $data['order_sn'] = $order_sn;
	            break;
	        case 2 :
	            $corporation_name = $this->input->get_post("corporation_name");
	            $condition['corporation_name'] = $corporation_name;
	            $data['corporation_name'] = $corporation_name;
	            break;
	    }
	    $start_time = $this->input->get_post("start_time");
	    $end_time = $this->input->get_post("end_time");
	    //条件组合成数组
	    $condition['select_id'] = $select_id;
	    $condition['start_time'] = $start_time;
	    $condition['end_time'] = $end_time;
	    $data['select_id'] = $select_id;
	    $data['start_time'] = $start_time;
	    $data['end_time'] = $end_time;
	    
	    //分页的链接(是否有根据条件)
	    $config['base_url'] = site_url('corporate/report/divided_into/?');
	    if($select_id||$start_time||$end_time)
	    {
	        if($select_id)
	        {
	            switch ($select_id)
	            {
	                case 1 :
	                    $config['base_url'] .= "&product_score=".$select_id."&order_sn=".$order_sn."&start_time=".$start_time."&end_time=".$end_time;
	                    break;
	                case 2 :
	                    $config['base_url'] .= "&product_score=".$select_id."&corporation_name=".$corporation_name."&start_time=".$start_time."&end_time=".$end_time;
	                    break;
	            }
	        }
	        else
	        {
	            $config['base_url'] .= "&product_score=".$select_id."&start_time=".$start_time."&end_time=".$end_time;
	        }
	    }
	    
	    
	    //分页
	    $config['per_page'] = 10;
	    $current_page = $this->input->get_post('per_page',true);
	    if($current_page==0) $current_page = 1;
	    $offset = $current_page*$config['per_page']-$config['per_page'];
	    $data['row'] = $this->or->rebate_detail($condition,$condition['customer_id'],true);
	    $this->load->library('pagination');
	    $config['curr_page'] = $current_page;
	    $config['use_page_numbers'] = TRUE;
	    $config['page_query_string'] = TRUE;
	    $config['num_link'] = 4;
	    $config['next_link'] = '下一页';
	    $config['prev_link'] = '上一页';
	    $config['next_tag_css'] = 'class="lPage"';
	    $config['prev_tag_css'] = 'class="lPage"';
	    $config['first_link'] = '<<';
	    $config['last_link'] = '>>';
	    $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
	    $config['cur_tag_close'] = '</a>';
	    $config['total_rows'] = $data['row']['row_num'];
	    $this->pagination->initialize ( $config );
	    $data ['pagination'] = $this->pagination->create_links ();
	    
	    //下线列表
	    $data['rebate'] = $this->or->rebate_detail($condition,$condition['customer_id'],false,$config['per_page'],$offset);
// 	    echo $this->db->last_query();
	   
	    
// 	    print_r($data);exit;
		$data ['title'] = '下线分成';
		$data ['head_set'] = 2;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head');
	    $this->load->view ( '_header' );
	    $this->load->view ( 'corporate/report/divided_into',$data);
	    $this->load->view ( '_footer');
	    $this->load->view ( 'foot'); 
	}
}