<?php
if  (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// require_once(dirname(__FILE__) . '/../config/configurations.php');
    // ------------------------------------------------------------------------

/**
 * 切换端口调用数据
 *
 */
class Log extends Account_Controller
{

    public function __construct()
    {
        parent::__construct();
        
    }
    //日志
    public function index(){ 
	$relation_id = $this->input->get('relation_id');
        $this->load->model('customer_currency_log_mdl','customer_currency_log');
        $this->load->model('customer_money_log_mdl','customer_money_log');
        $this->load->model('customer_credit_log_mdl','customer_credit_log');
        $data['cash_log'] = $this->customer_money_log->load($relation_id,'15', '0');//现金日志
        $data['m_log']    = $this->customer_currency_log->load($relation_id,'15', '0');//M卷日志
        $data['credit_log'] = $this->customer_credit_log->load($relation_id,'15', '0');//授信日志
        
        echo json_encode($data);
    }
    
    
    /**
     * AJAX获取日志 - 分页
     */
    public function ajax_transaction_list(){ 
	 $status = $this->input->get('status');
        $pagesize   = $this->input->get('page');
        $limit  = $this->input->get('limit');
        $relation_id = $this->input->get('relation_id');
        if(0 == $limit)
        {
            $limit = 1;
        }
        $offset   = ($limit - 1 ) * $pagesize;
        
        $customer_id = $this->session->userdata ( 'user_id' );
        if($status == 1){ 
            $this->load->model('customer_currency_log_mdl','customer_currency_log');
            $data['log']    = $this->customer_currency_log->load($relation_id,$pagesize, $offset);//M卷日志
        }else if($status == 2){
	    $this->load->model('customer_money_log_mdl','customer_money_log');
            $data['log'] = $this->customer_money_log->load($relation_id,$pagesize, $offset);//现金日志
//             echo $this->db->last_query();
        }else{ 
            $this->load->model('customer_credit_log_mdl','customer_credit_log');
            $data['log'] = $this->customer_credit_log->load($relation_id,$pagesize, $offset);//授信日志
        }

        echo json_encode($data);
    }
  
}

?>
