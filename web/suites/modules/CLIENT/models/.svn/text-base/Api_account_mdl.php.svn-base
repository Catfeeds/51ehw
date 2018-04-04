
    <?php
/**
 * 
 *
 *
 */
class Api_account_mdl extends CI_Model {
    var $id;
    var $shop_number;
    var $key;
    var $customer_id;
    var $type;
    var $corporation_id;
    var $product_id;
    
	function __construct() {
		parent::__construct ();
	}

	
	//根据条件搜索
    function load(){ 
        
        
        if( isset($this->shop_number) )
            $this->db->where('shop_number',$this->shop_number);
        
        if( isset ($this->key) )
            $this->db->where('key',$this->key);
        
        $query = $this->db->from('api_account')->get();
        
        return $query->row_array();
    }
    
    /**
     * 设置参数
     */
    public function Update()
    { 
        $this->db->set('customer_id',$this->customer_id);
        $this->db->set('corporation_id',$this->corporation_id);
        $this->db->set('product_id',$this->product_id);
        $this->db->where('shop_number',$this->shop_number);
        return $this->db->update('api_account');
        
        
    }
}
 