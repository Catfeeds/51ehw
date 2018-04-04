<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_comment extends Front_Controller {
    
	public function __construct()
	{
		parent::__construct();
		//判断用户是否登录
		if (!$this->session->userdata('user_in')){
			redirect('customer/login');
			exit();
		}
		$this->load->model('order_comments_mdl','order_comments');
	}
	
	/**
	 * 我的评论
	 * 
	 */
	public function get_list($status='')
	{
	    $user_id = $this->session->userdata['user_id'];
	    
	    $this->load->library('pagination');
	    $config['per_page'] = 15;
	    $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    if( $status ){
	        $config['base_url'] = site_url('member/my_comment/get_list').'/';
	        $config['base_url'] .= $status.'/?';
	    }else{
	        $config['base_url'] = site_url('member/my_comment/get_list').'?/';
	    }
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    $data['list'] = $this->order_comments->my_comment( $user_id ,$status,$offset,$config['per_page']);
	    $config['total_rows'] = $this->order_comments->count_comment($user_id, $status);
	    $config['use_page_numbers']   = TRUE;
	    $config['page_query_string']  = TRUE;
	    $config['num_links'] = 3; //可以看到当前页后面的3页a连接
	    $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
	    $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
	    $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
	    $config ['prev_tag_css'] = 'class="lPage"';
	    $config ['next_link'] = '下一页';
	    $config ['next_tag_css'] = 'class="lPage"';
	    $config['first_link'] = '<<';
	    $config['last_link'] = '>>';
	    $this->pagination->initialize($config);
	    $data['total_rows'] = $config['total_rows'];
	    $data['per_page'] = $config['per_page'];
	    $data['cu_page'] = $current_page;
	    $data['page'] =  $this->pagination->create_links();
	    $data['title'] = '我的评论';
	    
	    $this->load->view ( 'head',$data);
	    $this->load->view ( '_header' ,$data);
	    $data['status'] = $status;
	    $data['yes_comment_num'] = $this->order_comments->count_yes_comment($user_id);
	    $data['no_comment_num']  = $this->order_comments->count_no_comment($user_id);
	    $data['all_comment_num'] = $this->order_comments->count_all_commnet($user_id);
	    
	    
	    
	    $this->load->view ( 'customer/my_comment',$data);
	    $this->load->view ( '_footer' ,$data);
	    $this->load->view ( 'foot',$data);
	}   

	/**
	 * 增加一条商品评论
	 */
	public function increase_comment(){ 
	    $data = $this->input->post();
	    $data['yes_on'] = $this->order_comments->increase_comment($data);
	    echo json_encode($data['yes_on']);
	}
	
	/**
	 * 商品评论
	 */
	public function product_comment($id,$details=''){
	    
	    $user_id = $this->session->userdata['user_id'];
	    $this->load->model('order_comments');
	    $data['list'] = $this->order_comments->my_comment( $user_id , $status='details', $offset='', $num=1,$id,$details);
	    $data['status'] = 'one_comment';
	    
	    $data['title'] = '商品评论';
	    $data['head_set'] = 2;
	    
	    $this->load->view ( 'head',$data);
	    $this->load->view ( '_header' ,$data);
	    $this->load->view ( 'customer/my_comment',$data);
	    $this->load->view ( '_footer' ,$data);
	    $this->load->view ( 'foot',$data);
	}
	
}