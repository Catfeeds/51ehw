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
         $data['head_set'] = 3;
         $data['foot_set'] = 1;
         $customer_id = $this->session->userdata ( 'user_id' );
         $this->load->model('customer_currency_log_mdl','customer_currency_log');
         $this->load->model('customer_money_log_mdl','customer_money_log');
         $this->load->model('customer_credit_log_mdl','customer_credit_log');
         $data['cash_log'] = $this->customer_money_log->load($customer_id,'15', '0');//现金日志
//          echo $this->db->last_query();
         $data['m_log']    = $this->customer_currency_log->load($customer_id,'15', '0');//M卷日志
         $data['credit_log'] = $this->customer_credit_log->load($customer_id,'15', '0');//授信日志
         
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
        $offset   = ($limit - 1 ) * $pagesize;
        
        $customer_id = $this->session->userdata ( 'user_id' );
        if($status == 1){ 
            $this->load->model('customer_currency_log_mdl','customer_currency_log');
            $data['log']    = $this->customer_currency_log->load($customer_id,$pagesize, $offset);//M卷日志
        }else if($status == 2){ 
            $this->load->model('customer_money_log_mdl','customer_money_log');
            $data['log'] = $this->customer_money_log->load($customer_id,$pagesize, $offset);//现金日志
//             echo $this->db->last_query();
        }else{ 
            $this->load->model('customer_credit_log_mdl','customer_credit_log');
            $data['log'] = $this->customer_credit_log->load($customer_id,$pagesize, $offset);//授信日志
        }
//         echo $this->db->last_query();
        echo json_encode($data);
    }
}
