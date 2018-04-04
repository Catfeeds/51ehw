<?php

class Pay_relation_mdl extends CI_Model {
    var $id;
    var $id_pay;
    var $customer_id;
    var $cteated_at;

    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct ();
    }
    
	/**
	 * 添加pay_relation
	 */
	function createpay_relation(){
		$datetime = date ( 'Y-m-d H:i:s' );
	    $this->db->set ( 'id_pay', $this->id_pay );
	    $this->db->set ( 'customer_id', $this->customer_id );
	    $this->db->set ( 'cteated_at', $datetime );

	    $this->db->insert('pay_relation');

	    $pay_relation_id = $this->db->insert_id();
	    
	    error_log ( $this->db->last_query () );
	    return $pay_relation_id;
	}

	/**
	 * 更新表信息
	 * 
	 * @param unknown $id
	 */
	function update($customer_id){
        if ($this->id_pay)
            $this->db->set('id_pay', $this->id_pay);
        if ($this->customer_id)
            $this->db->set('customer_id', $this->customer_id);
        
        $this->db->where('customer_id = ', $customer_id);
        return $this->db->update('pay_account');
    }
    
    function load_by_customerId($customer_id){
        if (! $customer_id) {
            return array();
        }
        $query = $this->db->get_where('pay_relation', array(
            'customer_id' => $customer_id
        ));
        return $query->row_array();
    }
    
    //根据这个表的自增ID获取支付账号
    function load(){ 
        $this->db->select('pa.*,pr.id as r_id');
        $this->db->from('pay_relation as pr');
        $this->db->join('pay_account as pa','pr.id_pay = pa.id');
        $this->db->where('pr.id', $this->id);
        return $this->db->get()->row_array();
    }
    
    function load_id( $customer_id = 0 ){ 
        $query =  $this->db->get_where('pay_relation as r',array('r.customer_id'=> $customer_id) );
        return $query->row_array();
    }
}
