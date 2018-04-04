<?php
/**
 * 商家运费
 *
 *
 */
class Corporation_freight_mdl extends CI_Model
{


    
	function __construct()
    {
        parent::__construct();
    }

    
	// --------------------------------------------------------------------
	
    /**
     * 查询商家运费设置
     * @param int $corporation_id 企业id
     */
	public function load($corporation_id)
	{
	    if( !$corporation_id ){
	        return array();
        }
        
        $query = $this->db->get_where('corporation_freight',array('corporation_id'=>$corporation_id) );
         
	    return $query->row_array();
	}

}