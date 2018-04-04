<?php
/**
 * 
 
 * M卷操作日志
 */
class Customer_currency_log_mdl extends CI_Model {
	function __construct() {
		parent::__construct ();
	}

	
	/**
	 * 
	 * 获取货豆操作记录数
	 */
    public function count_currency_log($customer_id){
        $this->db->from('customer_currency_log as l');
        $this->db->join('pay_relation as r','l.relation_id = r.id');
	    $this->db->where('r.customer_id',$customer_id);
        return $this->db->get()->num_rows();
    }
	
    
	/**
	 * 
	 * 添加M卷日志
	 */
	public function add_log( $data ){ 
	    $this->db->set('relation_id', $data['relation_id']);
	    $this->db->set('id_event', $data['id_event']);
	    $this->db->set('created_at', date('Y-m-d H:i:s'));
	    $this->db->set('remark', $data['remark']);
	    $this->db->set('amount', $data['amount']);
	    $this->db->set('beginning_balance',$data['beginning_balance']);
	    $this->db->set('ending_balance', $data['ending_balance']);
	    $this->db->set('state',$data['status']);
	    $this->db->set('type', $data['type']);
	    if( !empty($data['app_id']) )
	        $this->db->set('app_id',  $data['app_id']);
	    if(isset($data['order_no']) )
	       $this->db->set('order_no', $data['order_no']);
	    if(isset($data['customer_id']) )
	        $this->db->set('customer_id', $data['customer_id']);
	    if( !empty(PORT_SOURCE) )
	        $this->db->set('port_source',PORT_SOURCE);
	    $this->db->insert('customer_currency_log');
	    $log_id = $this->db->insert_id();
	    return $log_id;
	}
	
	
	/**
	 * 批量添加日志
	 */
	public function bath_add_log($data){ 
	    return $this->db->insert_batch('customer_currency_log', $data);
	    
	}
	/**
	 * M卷交易日志
	 */
	public function load($relation_id, $limit = 0, $offset = 0){
	    if( !$relation_id )
	        return array();
	    
	    if ($limit)
	        $this->db->limit ( $limit );
	    if ($offset)
	        $this->db->offset ( $offset );
	    $this->db->select('l.*, c.name, d.name as event');
	    $this->db->from('customer_currency_log as l');
	    $this->db->join('customer as c','l.customer_id = c.id','left');
	    $this->db->join("datadictionary as d","d.id=id_event","left");
	    $this->db->where('l.relation_id',$relation_id);
	    $this->db->order_by('l.id','desc');
	    $result = $this->db->get()->result_array();
// 	    echo $this->db->last_query();
	    return $result;
	}
	
	/**
	 * 添加一张充值M卷的订单
	 */
	public function create_charge_currency( $data ){ 
	    $this->db->set('charge_no', $data['charge_no']);
	    $this->db->set('amount', $data['amount']);
	    $this->db->set('create_date', date('Y-m-d H:i:s') );
	    $this->db->set('customer_id', $data['customer_id']);
	    $this->db->insert('charge_currency');
	    return $this->db->insert_id();
	}
	
	/**
	 * 查询M卷订单号是否存在，存在返回true
	 */
	function check_charge_sn( $charge_no )
	{
	    $this->db->select('id');
	    $query = $this->db->get_where('charge_currency', array(
	        'charge_no' => $charge_no
	    ));
	    if ($query->row_array()) {
	        return true;
	    } else {
	        return false;
	    }
	}
	
	/**
	 * 某个人的最新的交易日志
	 */
	public function load_last( $pay_relation_id ){
	    if( !$pay_relation_id )
	        return array();
	    
	    $this->db->select('*');
	    $this->db->from('customer_currency_log ');
        $this->db->where('relation_id',$pay_relation_id);
        $this->db->order_by('id','desc');
	    $result = $this->db->get()->row_array();
// 	    var_Dump($pay_relation_id);
	    return $result;
	    
	}
	
	/**
	 * M卷交易日志
	 */
	public function load_total($relation_id){
	    if( !$relation_id )
	        return 0;
	    
	    $this->db->from('customer_currency_log');
	    $this->db->where('relation_id',$relation_id);
	    return $this->db->get()->num_rows();
	   
	}
	
}