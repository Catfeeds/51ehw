<?php
/**
 * 授信日志 
 */
class Customer_credit_log_mdl extends CI_Model {
    function __construct() {
        parent::__construct ();
    }
    
    /*
     * 交易记录
     * $limit 每页记录数
     * $offset 偏移量
     * */
    public function load($relation_id, $limit = 0, $offset = 0)
    {
        if ($limit)
            $this->db->limit ( $limit );
        if ($offset)
            $this->db->offset ( $offset );
        $this->db->select('cl.*');
        $this->db->from('customer_credit_log as cl');
        
        $this->db->where('cl.relation_id',$relation_id);
        $this->db->order_by('cl.id','desc');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    /**
     * 统计
     */
    public function load_total($relation_id)
    {
        $this->db->from('customer_credit_log as cl');
        $this->db->where('relation_id',$relation_id);
        return $this->db->count_all_results();
    }
}