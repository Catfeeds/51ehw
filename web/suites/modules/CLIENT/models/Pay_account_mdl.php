<?php

class Pay_account_mdl extends CI_Model {
    var $name;
    var $passwd;
    var $credit;
    var $cash;
    var $pay_passwd;
    var $M_credit;
    var $fingerprint_passwd;
    var $gesture_passwd;

    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct ();
    }

	/**
	 * 添加pay_account
	 */
	function createpay_account(){
	    $this->db->set ( 'name', $this->name );
		$this->db->set ( 'passwd', md5 ( $this->passwd ) );

	    $this->db->insert('pay_account');

	    $pay_account_id = $this->db->insert_id();

	    error_log ( $this->db->last_query () );
	    
	    return $pay_account_id;
	}

    /**
     * 更新用户信息
     * @param unknown $id
     */
	function update($id){
	    
	    if ($this->name)
	        $this->db->set ('name', $this->name );
		if(isset($this->passwd))
		    $this->db->set('passwd',md5 ( $this->passwd ) );
		if(isset($this->credit))
		    $this->db->set('credit',$this->credit);
		if(isset($this->cash))
		    $this->db->set('cash',$this->cash);
		if(isset($this->pay_passwd))
		    $this->db->set('pay_passwd',md5 ( $this->pay_passwd ) );
		if(isset($this->M_credit))
		    $this->db->set('M_credit',$this->M_credit);
		if(isset($this->fingerprint_passwd))
		    $this->db->set('fingerprint_passwd',$this->fingerprint_passwd);
		if(isset($this->gesture_passwd))
		    $this->db->set('gesture_passwd',$this->gesture_passwd);
		
	    $query = $this->db->select('id_pay')->from('pay_relation')->where('customer_id',$id)->get();
	    $row = $query->row_array ();
	    foreach($row as $key=> $value){
	        $this->db->where('pay_account.id = '.$value);
	        return $this->db->update('pay_account');
	    }
	}


	/**
	 * 查询支付账户
	 */
	public function load( $customer_id ){
	    $this->db->select('pa.*,pr.id as r_id');
	    $this->db->from('pay_relation as pr');
	    $this->db->join('pay_account as pa','pr.id_pay = pa.id');
	    $this->db->where('pr.customer_id', $customer_id);
	    return $this->db->get()->row_array();
	}

	/**
	 * 扣去现金余额
	 */
	public function update_cash($id, $total ){
	    $this->db->set ( 'cash', "`cash`-" . $total, false );
	    $this->db->where ( 'id', $id );
	    $this->db->where ( 'cash  >=', $total );
	    $this->db->update ( 'pay_account' );

	    $res = $this->db->affected_rows();
	    return $res;

	}


	/**
	 * 增加M卷
	 */
	public function charge_M_credit($id, $total) {

	    $this->db->set ( 'M_credit', "`M_credit` + " . $total, false );
	    $this->db->where ( 'id', $id );
	    $this->db->update ( 'pay_account' );
	    return $this->db->affected_rows();
	}

	/**
	 * 增加现金余额
	 */
	public function charge_cash($id, $cash){
	    $this->db->set ( 'cash', "`cash` + " . $cash, false );
	    $this->db->where ( 'id', $id );
	    $this->db->update ( 'pay_account' );
	    return $this->db->affected_rows();
	}

	/**
	 * 扣除M卷
	 */
	public function update_M_creadit($id, $total, $credit = null){
	    $this->db->set ( 'M_credit', "`M_credit` - " . $total, false );
	    $this->db->where ( 'id', $id );
	    if($credit)
	        $this->db->where('M_credit >=',$total+$credit);
	    $this->db->update ( 'pay_account' );
	    $res = $this->db->affected_rows();
	    return $res;
	}

	/**
	*根据orderid 查询payid
	*/
	public function load_salerinfo_byorder( $orderid ){
	    $this->db->select('pa.*,pr.id as r_id,,pr.customer_id');
	    $this->db->from('pay_relation as pr');
	    $this->db->join('pay_account as pa','pr.id_pay = pa.id');
		$this->db->join('customer_corporation as cc','cc.customer_id = pr.customer_id' );
		$this->db->join('order as o','o.corporation_id = cc.id');
	    $this->db->where('o.id', $orderid);
	    $query =  $this->db->get();
		return $query->row_array();
	}
	
	/**
	 * 根据用户账户查询支付账户信息
	 */
	public function load_account_name( $name ){ 
	    $this->db->select('pa.*,pr.customer_id,pr.id as r_id');
	    $this->db->from('pay_account as pa');
	    $this->db->join('pay_relation as pr','pr.id_pay = pa.id');
	    $this->db->where('pa.name',$name);
	    $query =  $this->db->get();
	    return $query->row_array();
	}

}
