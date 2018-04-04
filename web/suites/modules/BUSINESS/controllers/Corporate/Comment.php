<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 评论管理控制器
 * 
 * 增删改查评论
 * 
 * @author 		Clark So
 * @copyright 	Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license		http://www.9-leaf.com/
 * @link		http://www.9-leaf.com/
 * @since		Version 1.0
 * @filesource
 *
 */
class Comment extends Front_Controller {
	
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
	public function get_list($type=''){
		
	    if( !$this->session->userdata("corporation_id") )
	    {
	        redirect('Corporation/home_page');
	        exit();
	         
	    }
	    
	    $this->load->model('order_comments_mdl','order_comments');
	    $corporation_id = $this->session->userdata("corporation_id");
	    $appInfo = $this->session->userdata ( 'app_info' );
	    
	    $condition['corporation_id']=$corporation_id;
	    
	    // 判断是企业会员还是个人
	    $customer_id = $this->session->userdata ( 'user_id' );
	    
	    // 获取企业资料
// 	    $data ['corporation'] = $this->corporation_mdl->load ( $customer_id );
	    
	    $search_name=$this->input->get();
	
//         print_r($search_name);exit;
	    $config['per_page'] = 4;
	    $current_page          = ($this->input->get_post('per_page',true));  //获取当前分页页码数
	     
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    
	    $this->load->library ( 'pagination' );
	    if(isset($type) && $type > 0){
	       $config ['base_url'] = site_url ('corporate/comment/get_list/'.$type.'/?');
	    }else if(isset($search_name['product_name']) ||isset($search_name['product_id']) ||isset($search_name['start_time']) ||isset($search_name['end_time']) ||isset($search_name['guanjizi']) ||isset($search_name['username']) ||isset($search_name['product_score']) ||isset($search_name['dingdannum']) ||isset($search_name['reply'])){
	        $config ['base_url'] = site_url ('corporate/comment/get_list/?');
	        $config ['base_url'] .= '&product_name='.$search_name['product_name'].'&product_id='.$search_name['product_id'].'&start_time='.$search_name['start_time'].'&end_time='.$search_name['end_time'].'&content='.$search_name['content'].'&username='.$search_name['username'].'&product_score='.$search_name['product_score'].'&reply='.$search_name['reply'].'&order_sn='.$search_name['order_sn'];
	    }else{
	       $config ['base_url'] = site_url ('corporate/comment/get_list/?');
	    }
	    //$config ['suffix'] = $pagecondition;
	    $config ['total_rows'] = $this->order_comments->all_comments ( $condition['corporation_id'] ,$count = '', $offset = '',$search_name,$type);
	    $config ['per_page'] = $config['per_page'];
	    $config ['curr_page'] = $current_page;
	    $config['use_page_numbers']   = TRUE;
	    $config['page_query_string']  = TRUE;
	    $config['num_links'] = 3; //可以看到当前页后面的3页a连接
	    $config ['next_link'] = '下一页';
	    $config ['next_tag_css'] = 'class="lPage"';
	    $config ['prev_link'] = '上一页';
	    $config ['prev_tag_css'] = 'class="lPage"';
        $config ['first_link'] = '<<';
        $config ['last_link'] = '>>';
	    $config ['cur_tag_open'] = '&nbsp;<a class="cpage">';
	    $config ['cur_tag_close'] = '</a>';
	    $this->pagination->initialize ( $config );
	    $data ['pagination'] = $this->pagination->create_links ();
        
	    $offset   = ($current_page  - 1 ) * $config['per_page'];
	    
	    $data['comments']=$this->order_comments->find_comments($condition['corporation_id'],$config ['per_page'],$offset,$search_name,$type);
	    
	    $data ['title'] = $this->session->userdata ( 'app_info' )['app_name'];
	    $data ['head_set'] = 4;
	    $data['page'] = $current_page;$data['pagesize'] = $config['per_page'];
	    $data['totalcount'] = $config ['total_rows'];
	    
	    //全部评价总数
	    $data ['allcount'] = $this->order_comments->all_comments ( $condition['corporation_id'] ,$count = '', $offset = '',$search_name);
        //未回复总数
	    $data ['noreplycount'] = $this->order_comments->all_comments ( $condition['corporation_id'] ,$count = '', $offset = '',$search_name,1);
	    //已回复总数
	    $data['replycount'] = $this->order_comments->all_comments ( $condition['corporation_id'] ,$count = '', $offset = '',$search_name,2);
	    //咨询条数
	    $this->load->model('demand_mdl');
	    $data['askcount'] = $this->demand_mdl->get_demand($corporation_id,null,null,1);//显示总条数
	    
	    $data['types'] = $type;
	    $data['search'] = $search_name;
	    
	    //print_r($data);exit();
	    $this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'corporate/comment/list', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	/**
	 * 回复
	 */
	public function reply(){
	    
	    // 判断是企业会员还是个人
	    $customer_id = $this->session->userdata ( 'user_id' );
        //echo $customer_id;exit;
	    // 获取企业资料
	    //$data ['corporation'] = $this->corporation_mdl->load ( $customer_id );
	    
	    $reply_content = $this->input->post('reply_content');
	    $id = $this->input->post('id');
	    
	    $this->load->model('order_comments_mdl','order_comments');
	    
	    $this->order_comments->reply_content = $reply_content;
	    $this->order_comments->reply_by = $customer_id;
	    $this->order_comments->id = $id;
	    
	    $result = $this->order_comments->reply();
	    
	    echo $result;
	    
	}
	
	/**
	 * 审核
	 */
	public function examine(){
	    
	    $id = $this->input->post('id');
	    
	    $this->load->model('order_comments_mdl','order_comments');
	    $this->order_comments->id = $id;
	    
	    $result = $this->order_comments->examine();
	    
	    echo $result;
	    
	}
	
	/**
	 * 商品咨询
	 */
	public function product_ask(){
	    
	    if( !$this->session->userdata("corporation_id") )
	    {
	        redirect('Corporation/home_page');
	        exit();
	    
	    }
	    
	    $this->load->model('demand_mdl');
	    $this->load->model('order_comments_mdl','order_comments');
	    
	    $corporation_id = $this->session->userdata('corporation_id');
	    //分页
	    $this->load->library('pagination');
	    $config['per_page'] = 10; //每页显示几条
	    $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
	    //判断如果没有页数默认一页
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    $app_id = $this->session->userdata("app_info")["id"];
	    //偏移量
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    //查询供需列表
	    $data['demand'] = $this->demand_mdl->get_demand($corporation_id,$config['per_page'],$offset);
	    $config['base_url'] = site_url('corporate/comment/product_ask').'?/';//路径配置
	    $data['askcount'] = $config['total_rows'] = $this->demand_mdl->get_demand($corporation_id,null,null,1);//显示总条数
	    $config['use_page_numbers']   = TRUE;//默认分页的 URL 中显示的是你当前正在从哪条记录开始分页，如果你希望显示实际的页数，将该参数设置为 TRUE 。
	    $config['page_query_string']  = TRUE;//默认情况下，分页类假设你使用 URI 段 ，并像这样构造你的链接：http://example.com/index.php/test/page/20
	    $config['num_links'] = 3; //可以看到当前页后面的3页a连接
	    $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
	    $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
	    $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
	    $config ['prev_tag_css'] = 'class="lPage"';//样式 给一个class='lPage' 样式用css控制
	    $config ['next_link'] = '下一页';
	    $config ['next_tag_css'] = 'class="lPage"';//样式 给一个class='lPage' 样式用css控制
	    $config['first_link'] = '<<';
	    $config['last_link'] = '>>';
	    $this->pagination->initialize($config);//初始化配置
	    $data['page'] =  $this->pagination->create_links();//执行
	    
	    $condition['corporation_id'] = $this->session->userdata ['corporation_id' ];

	    
	    //全部评价总数
	    $data ['allcount'] = $this->order_comments->all_comments ( $condition['corporation_id'] ,$count = '', $offset = '',null);
	    //未回复总数
	    $data ['noreplycount'] = $this->order_comments->all_comments ( $condition['corporation_id'] ,$count = '', $offset = '',null,1);
	    //已回复总数
	    $data['replycount'] = $this->order_comments->all_comments ( $condition['corporation_id'] ,$count = '', $offset = '',null,2);
	    $data['search'] = null;
	    $data ['title'] = '商品咨询';
		$data ['head_set'] = 2;
		$data ['foot_set'] = 1;
	    $this->load->view ( 'head');
	    $this->load->view ( '_header' );
	    $this->load->view ( 'corporate/comment/product_ask',$data);
	    $this->load->view ( '_footer');
	    $this->load->view ( 'foot'); 
	}
}