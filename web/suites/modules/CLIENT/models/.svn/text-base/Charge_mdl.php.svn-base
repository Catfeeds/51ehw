<?php
/**
 * 
 *
 *
 */
class Charge_mdl extends CI_Model
{
	
	

	function __construct()
    {
        parent::__construct();
    }
    
    
    
      /**
	 * 添加
	 *
	 *
	 */	
	function create($data)
    { 

		$datetime = date('Y-m-d H:i:s');
		$data['create_date'] = $datetime;
		
		$this->db->insert('charge',$data);
		
        return $this->db->insert_id ();
    }

    // --------------------------------------------------------------------
	function check_ordernum($chargeno)
	{
        $this->db->select('id');
        $query = $this->db->get_where('charge',array('chargeno' => $chargeno));
		if ($query->row_array()){
			return true;
		}
		return false;
	}

	// --------------------------------------------------------------------
	/**
	 * 获取购买互助店流水单号记录
	 * 
	 * 
	 */
	function load_shop_byid($customer_id){
	   $this->db->select('*');
	   $this->db->where('customer_id',$customer_id);//用户
	   $this->db->where('is_shop',1);//互助店购买记录标识
	   $this->db->where('status',1);//互助店购买记录标识
	   $this->db->from('charge');
	   $query =  $this->db->get()->row_array();
       return   $query;
	}
	
	// --------------------------------------------------------------------

    /**
	 * load by id
	 *
	 *
	 */	
    function load($id ,$customer_id=null, $status=null)
    {
        if (!$id){
            return array();
        }
        if(isset($customer_id) )
            $this->db->where('customer_id', $customer_id);
        if(isset( $status ) )
            $this->db->where('status', $status);
        $query = $this->db->get_where('charge',array('id' => $id));
        
        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }

	function load_byChangeNum($chargenum,$customer_id = null)
    {
		 if (!$chargenum){
            return array();
        }

        if($customer_id)
            $this->db->where('customer_id', $customer_id);
        
        $query = $this->db->get_where('charge',array('chargeno' => $chargenum));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }

    
    /**
	 * 更新
	 *
	 *
	 */	
	function update_pay($id,$tran_no = "")
    {
		$datetime = date('Y-m-d H:i:s');
		$this->db->set('status', 1);	
		$this->db->set('pay_date', date('Y-m-d H:i:s'));
		$this->db->set('remark',$tran_no);
        $this->db->where('id', $id);
        $this->db->update('charge');
        return $this->db->affected_rows();
    }
    
    
    /**
     * 更新支付方式
     */
    function update_payment($id,$payment_id)
    {
    
        $this->db->set('payment_id', $payment_id);
        $this->db->where('id', $id);
        $this->db->update('charge');
        return $this->db->affected_rows();
    }
	// --------------------------------------------------------------------

    /**
     * 根据条件更新
     *
     */
    function chargeno_update_pay($chargeno,$tran_no = "")
    {
        $datetime = date('Y-m-d H:i:s');
        $this->db->set('status', 1);
        $this->db->set('pay_date', date('Y-m-d H:i:s'));
        $this->db->set('remark',$tran_no);
        $this->db->where('chargeno', $chargeno);
        $this->db->where('status',0);
        $this->db->update('charge');
        return $this->db->affected_rows();
    }
	
	//查询注册用户数量
	public function get_counts()
	{
// 		$this->db->from('customer');
		
		//return $this->db->count_all_results('charge');
		
	}
	
	
	
	public function get_by_condition($where=array(),$select='')
	{
		
	
		if(!empty($select))
			$this->db->select($select);
		$this->db->where($where);
		$this->db->from("charge");
		
		$details = $this->db->get()->row_array();
		
		
		return $details;
	}

	// --------------------------------------------------------------------
	
	/**
	 * 
	 * @param unknown $chargeno
	 * @param string $tran_no
	 */
	public function charge_confirm_paid($chargeno, $tran_no = ""){

		$datetime = date('Y-m-d H:i:s');
		$this->db->set('status', 2);
		$this->db->set('pay_date', date('Y-m-d H:i:s') );
		$this->db->set('remark',$tran_no);
		$this->db->where('chargeno', $chargeno);
		return $this->db->update('charge');
		
	}
	
	
	/**
	 * 根据单号状态查询 - 单条
	 */
	public function get_ok_charge( $chargeno, $status ){ 
	   if( !$chargeno ){ 
	       return array();
	   }
	   $query = $this->db->get_where('charge',array('chargeno' => $chargeno,'status' => $status) );

       if ($row = $query->row_array()){
            return $row;
       }
	}
	
	/**
	 * 修改状态
	 */
	public function update_charge_status( $chargeno, $customer_id){ 
	    $this->db->set('status', 4);
	    $this->db->where('customer_id', $customer_id);
		$this->db->where('chargeno', $chargeno);
		$this->db->update('charge');
// 		echo $this->db->last_query();
        return $this->db->affected_rows();
	}
	
	/**
	 * 修改状态
	 */
	public function update_status( $chargeno, $status){
	    $this->db->set('status', $status);
	    $this->db->where('chargeno', $chargeno);
	    $this->db->update('charge');
	    // 		echo $this->db->last_query();
	    return $this->db->affected_rows();
	}
}