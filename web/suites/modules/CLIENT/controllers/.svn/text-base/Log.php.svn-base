<?php
/**
 * 日志记录
 *
 *
 */
class Log extends Front_Controller {
	function __construct() {
		parent::__construct();
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'customer/login' );
			exit ();
		}
	}
	
	// ------------------------------------------------------------
	/**
	 * 交易记录
	 */
	 public function transaction_list(){
	     $data['title'] = '交易记录';
         $data['head_set'] = 2;
         $data['foot_set'] = 1;
         $relation_id = $this->session->userdata ( 'pay_relation' );
         $url = $this->url_prefix.'log/?relation_id='.$relation_id;
         $result = json_decode($this->curl_get_result($url),true);
        
         //查询储值卡日志。
         $this->load->model('Savings_card_mdl');
          
         //列表
         $sift['where']['customer_id'] = $this->session->userdata('user_id');
         $sift['page']['limit'] = 15;
         $sift['page']['offset'] = 0;
         
         $data['card_log'] = $this->Savings_card_mdl->Load_Card_Log($sift);
        
         $data['m_log'] = $result['m_log'];
         $data['cash_log'] = $result['cash_log'];
         $data['credit_log'] = $result['credit_log'];
    	
         $this->load->view('head', $data);
    	 $this->load->view('_header', $data);
    	 $this->load->view('customer/business_record', $data);
    	 $this->load->view('_footer', $data);
         $this->load->view('foot', $data);
	
    }
    
    /**
     * AJAX获取日志 - 分页
     */
    public function ajax_transaction_list(){ 
        $status = $this->input->post('status');
        $pagesize   = $this->input->post('page');
        $limit  = $this->input->post('limit');
        if(0 == $limit)
        {
            $limit = 1;
        }
        
        if( $status != 4 )
        {
            $relation_id = $this->session->userdata ( 'pay_relation' );
            $url = $this->url_prefix.'log/ajax_transaction_list/?status='.$status.'&page='.$pagesize.'&limit='.$limit.'&relation_id='.$relation_id;
            $result = $this->curl_get_result($url);
            
        }else{ 
            $result['log'] = array();
            $offset   = ($limit - 1 ) * $pagesize;
            
            //查询储值卡日志。
            $this->load->model('Savings_card_mdl');
             
            //列表
            $sift['where']['customer_id'] = $this->session->userdata('user_id');
            $sift['page']['limit'] = $pagesize;
            $sift['page']['offset'] = $offset;
            $result['log'] = $this->Savings_card_mdl->Load_Card_Log($sift); 
           
            $result = json_encode($result);
             
        }
        
        echo $result;
    }
}
