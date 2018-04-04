<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Property extends Front_Controller {
    
	public function __construct()
	{
		parent::__construct();
		//判断用户是否登录
		if (!$this->session->userdata('user_in')){
			redirect('customer/login');
			exit();
		}
		$this->load->model ( 'customer_mdl','customer');
		$this->load->model('property_mdl','property');
	}
	
	/**
	 * 资产列表
	 * $status =  支付记录状态
	 */
	public function get_list( $status='' )
	{
	    $this->load->library('pagination');
	    $config['per_page'] = 5; //每页显示几条
	    $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    
	    //调用接口获取数据
	    if( $status != 4 )
	    {
    	    $relation_id = $this->session->userdata ( 'pay_relation' );
    	    $url = $this->url_prefix.'Customer/property/?relation_id='.$relation_id.'&status='.$status.'&per_page='.$config['per_page'].'&offset='.$offset;
    	    $result = json_decode($this->curl_get_result($url),true);
    	    
	    }else{ 
	        
	        //查询储值卡日志。
	        $this->load->model('Savings_card_mdl');
	        
	        //条数
	        $sift['where']['customer_id'] = $this->session->userdata('user_id');
	        $sift['return_rows'] = true;
	        $result['total_rows'] = $this->Savings_card_mdl->Load_Card_Log($sift);
	        
	        //列表
	        $sift['return_rows'] = false;
	        $sift['page']['limit'] = $config['per_page'];
	        $sift['page']['offset'] = $offset;
	        $result['list'] = $this->Savings_card_mdl->Load_Card_Log($sift);
	        
	        
	    }
	    
        if( $status ){
	        $config['base_url'] = site_url('member/property/get_list').'/';
	        $config['base_url'] .= $status.'/?';
	    }else{
	        $config['base_url'] = site_url('member/property/get_list').'?/';
	    }
	    
	    $config['total_rows'] = $result['total_rows'];
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
	    $data['status'] = $status;
	    $data['list'] = $result['list'];
	    $data['customer'] = !empty( $result['customer'] ) ? $result['customer'] : array();
	    $data['title'] = '我的资产';
	    $this->load->view ( 'head',$data);
	    $this->load->view ( '_header' ,$data);
	    $this->load->view('property/list',$data);
	    $this->load->view ( '_footer' ,$data);
	    $this->load->view ( 'foot',$data);
	}
	
	/**
	 * 充值选择页
	 */
	public function pay_index(){ 
	    $customer_id = $this->session->userdata['user_id'];
	    //接口获取支付账户信息
	    $url = $this->url_prefix.'Customer/fortune?customer_id='.$customer_id;
	    $data["customer"] = json_decode($this->curl_get_result($url),true);
	    
	    $data['title'] = "现金充值";
	    $this->load->view ( 'head' ,$data );
	    $this->load->view ( '_header' ,$data );
	    $this->load->view ( 'property/pay_index' ,$data );
	    $this->load->view ( '_footer' ,$data ) ;
	    $this->load->view ( 'foot' ,$data );
	}

	/**
	 * 24小时后未支付订单自动取消
	 */
	public function close_charge(){
	    
	    $list = $this->property->get_nopay();
	    
	    if(count($list)){
	        foreach ($list as $l){
	            if(strtotime(date('Y-m-d H:i:s'))-strtotime($l['create_date'])>24*60*60&&$l['status']==0){
	                $this->property->status = 2;
	                $this->property->update($l['id']);
	            }
	        }
	    }
	    
	}
	
}