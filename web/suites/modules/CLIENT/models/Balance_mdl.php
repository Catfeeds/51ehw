<?php
/**
 * 
 *
 *
 */
class Balance_mdl extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }
    
     function create($data)
    {
    	
       $this->db->insert("customer_balance", $data);
	   return $this->db->insert_id();
    }
    
    
     function getBalanceByCustomer($customerid)
    {

		$this->db->select_sum("balancetotal");
		$this->db->from('customer_balance');
		$this->db->where(array('customerid'=>$customerid,'status'=>1));
		$query = $this->db->get();

        if ($row = $query->row_array()){
            return $row;
        }

        return 0;
    }
    
    
    function getBalanceByCustomerForNoPay($customerid)
    {

		$this->db->select_sum("balancetotal");
		$this->db->from('customer_balance');
		$this->db->where(array('customerid'=>$customerid,'status'=>0));
		$query = $this->db->get();

        if ($row = $query->row_array()){
            return $row;
        }

        return 0;
    }
}