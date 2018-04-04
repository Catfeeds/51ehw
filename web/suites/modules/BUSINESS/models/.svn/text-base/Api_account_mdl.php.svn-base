
    <?php
/**
 * 
 *
 *
 */
class Api_account_mdl extends CI_Model {
    var $shop_number;
    var $key;
    var $customer_id;
    var $type;
    
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
}
 