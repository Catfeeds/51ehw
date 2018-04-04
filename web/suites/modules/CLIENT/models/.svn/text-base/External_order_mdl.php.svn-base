<?php
/**
 * 第三方订单表
 *
 *
 */
class External_order_mdl extends CI_Model
{

    public $external_number;
    public $order_sn;
    public $type;
    public $shop_number;
    
	function __construct()
    {
        parent::__construct();
    }

    public function create(){ 
        
        if( isset($this->external_number) )
            $this->db->set('external_number',$this->external_number);
        
        if( isset($this->order_sn) )
            $this->db->set('order_sn',$this->order_sn);
        
        if( isset($this->type) )
            $this->db->set('type',$this->type);
        
        if( isset($this->shop_number) )
            $this->db->set('shop_number',$this->shop_number);
        
        $this->db->set('create_date',date('Y-m-d H:i:s') );
        
        $this->db->insert('external_order');
        
        return $this->db->insert_id();
        
    }
    
    
    /**
     * 根据id select 商品名字
     */
    public function load_product($id){ 
        return $this->db->get_where('product',array('id'=>$id) )->row_array();
     }
   
}