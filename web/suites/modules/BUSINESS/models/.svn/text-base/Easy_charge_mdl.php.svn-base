<?php
/**
 * 
 *
 *
 */
class Easy_charge_mdl extends CI_Model
{
	
	
	function __construct()
    {
        parent::__construct();
    }
    
    
    
    /**
	 * 添加
	 */	
	function Create($data)
    { 
		$datetime = date('Y-m-d H:i:s');
		$inser_charge['create_at'] = $datetime;
		$inser_charge['charge_no'] = $data['charge_no'];
		$inser_charge['amount'] = $data['amount'];
		$inser_charge['customer_id'] = $data['customer_id'];
		$inser_charge['payment_id'] = $data['payment_id'];
		$inser_charge['source'] = $data['source'];
		
// 		if( empty( $data['app_sign'] ) )
// 		{ 
// 		    $data['app_sign'] = '51ehw';
// 		}
		$this->db->insert('easy_charge',$inser_charge);
		$charge_id = $this->db->insert_id ();
        return $charge_id;
    }

    
    /**
     * 添加
     */
    function CreateItem( $data )
    {
        $this->db->insert('easy_charge_item',$data );
        return $this->db->insert_id ();
    }
    
    // --------------------------------------------------------------------
	function CheckOrdernum($chargeno)
	{
        $this->db->select('id');
        $query = $this->db->get_where('easy_charge',array('charge_no' => $chargeno));
		if ($query->row_array()){
			return true;
		}
		return false;
	}

	// --------------------------------------------------------------------

    /**
	 * load by itme
	 *
	 */	
    function LoadItem($charge_id,$status = false)
    {
      
       $query = $this->db->get_where('easy_charge_item',array('easy_charge_id'=>$charge_id) );
       
       if( !$status )
       {
           return $query->row_array();
       }else{ 
           return $query->result_array();
       }
    }

	function LoadByChangeNo($chargenum,$customer_id = null)
    {
		 if (!$chargenum){
            return array();
        }

        if($customer_id)
            $this->db->where('customer_id', $customer_id);
        
        $query = $this->db->get_where('easy_charge',array('charge_no' => $chargenum));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }


    /**
     * 更新
     * @param unknown $order_sn
     * @param unknown $params
     */
    function Update($id,$params){
	    $this->db->set($params);
	    $this->db->where("id",$id);
	    $this->db->update("easy_charge");
	    return $this->db->affected_rows();
	}
    
   
	/**
	 * 查询主表
	 */
	function Load($charge_id = 0 )
	{ 
	    $query = $this->db->get_where('easy_charge',array('id' => $charge_id) );
	    return $query->row_array();
	}
	
	
}