<?php
/**
 * 
 *
 *
 */
class Corporation_template_set_mdl extends CI_Model {
	
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}
	
	
	public function select_template($corporation_id, $template_id ){ 
	    $this->db->order_by('temp_key','asc');
	    $query = $this->db->get_where('corporation_template_set',array('corporation_id'=> $corporation_id,'template_id'=> $template_id));
	    $result = $query->result_array();
	    
	    foreach ($result as $k => $v){ 
	        $arr = explode('_',$v['temp_key']);
	        $result[$k]['temp_key'] = $arr[0];
	    }
	   
	    return $result;
	}

	public function DeleteByTemplateID($corporation_id, $template_id )
	{
		return $this->db->delete ( 'corporation_template_set', array (
					'corporation_id' => $corporation_id,'template_id'=> $template_id
			) );
	}

}