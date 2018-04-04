<?php
/**
 * 
 *
 * 现金操作日志
 */
class Customer_money_log_mdl extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	/**
	 * 
	 * 添加现金日志
	 */
	public function add_log( $data ){ 
	    $this->db->set('relation_id', $data['relation_id']);
	    $this->db->set('id_event', $data['id_event']);
	    $this->db->set('created_at', date('Y-m-d H:i:s'));
	    $this->db->set('remark', $data['remark']);
	    if(!empty($data['app_id']) )
            $this->db->set('app_id',  $data['app_id']);
	    $this->db->set('cash', $data['cash']);
	    $this->db->set('beginning_balance',$data['beginning_balance']);
	    $this->db->set('ending_balance',$data['ending_balance']);
	    $this->db->set('state',$data['status']);
	    $this->db->set('type',$data['type']);
	    $this->db->set('customer_id', $data['customer_id']);
	    if(isset($data['charge_no']) )
	       $this->db->set('charge_no',$data['charge_no']);
	    if( !empty(PORT_SOURCE) )
	        $this->db->set('port_source',PORT_SOURCE);
	    $this->db->insert('customer_money_log');
	    $log_id = $this->db->insert_id();
	    return $log_id;
	}

    /**
     * 现金交易日志
     */
	public function load($relation_id, $limit = 0, $offset = 0){ 
	    if( !$relation_id )
	        return array();
	    
	    if ($limit)
	        $this->db->limit ( $limit );
	    if ($offset)
	        $this->db->offset ( $offset );
	    $this->db->select('cl.*,c.name,d.name as event,e.serial_number,e.remark as cash_remark');
	    $this->db->from('customer_money_log as cl');
	    $this->db->join('customer as c','cl.customer_id = c.id','left');
	    $this->db->join("datadictionary as d","d.id= cl.id_event","left");
	    $this->db->join("charge_cash_log as e","e.charge_no = cl.charge_no","left");
	    $this->db->where('cl.relation_id',$relation_id);
	    $this->db->order_by('cl.id','desc');
	    $result = $this->db->get()->result_array(); 
// 	    echo $this->db->last_query();
// 	    echo'<pre>';
// 	    var_Dump($result);
	    return $result; 
	}
	
	/**
	 * 最新的一条交易日志
	 */
	public function load_create_desc( $pay_relation_id ){ 
	    if( !$pay_relation_id )
	        return array();
	    
	    $this->db->select('a.*,b.name');
	    $this->db->from('customer_money_log as a');
	    $this->db->join("datadictionary as b","a.id_event=b.id","left");
	    $this->db->where('relation_id',$pay_relation_id);
	    $this->db->order_by('id','desc');
	    $result = $this->db->get()->row_array();
// 	    	    echo $this->db->last_query();
// 	    	    echo'<pre>';
// 	    	    var_Dump($result);
	    return $result;
	}
	
	/**
	 * 现金交易日志 -统计某个人的条数
	 */
	public function load_total($relation_id){
	    $this->db->from('customer_money_log as cl');
	    $this->db->where('relation_id',$relation_id);
	    return $this->db->get()->num_rows();
	}
	
}