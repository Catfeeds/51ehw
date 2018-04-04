<?php

/**
 * 商品
 *
 *
 */
class Customer_rebate_mdl extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 查询app_id的分成比率
     * $sort = 2 //默认购物分成
     */
    function Load( $sift = array() )
    {
        if( empty( $sift['where']['customer_id'] ) )
            return array();
        
        $this->db->select('cr.*,rt.config');
        $this->db->from('customer_rebate as cr');
        $this->db->join('rebate_template as rt','cr.template_id = rt.template_id');
        $this->db->where('cr.customer_id',$sift['where']['customer_id']);
        $query = $this->db->get();
        return $query->row_array();
      
    }
}