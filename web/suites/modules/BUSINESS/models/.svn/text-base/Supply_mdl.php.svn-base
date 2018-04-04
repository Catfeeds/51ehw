<?php
/**
 * 
 *
 *
 */
class Supply_mdl extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	function getList($offset, $num,$app_id =-1,$key = '') {
		
		$this->db->from ( 'notice as a' );

		if ($app_id !== -1) {
			$this->db->where ( 'app_id', $app_id );
		}
		if ($key != '') {
			$this->db->like ( "concat(title,'||',n_content)", $key );
		}
		$this->db->order_by("create_at desc");
		$this->db->limit ( $num, $offset );
		$query = $this->db->get ();
		
		if ($row = $query->result_array ()) {
			return $row;
		}
		
		return array ();
	}
	
	function countList($app_id =-1,$key = '') {
		
		$this->db->from ( 'notice' );

		if ($app_id !== -1) {
			$this->db->where ( 'app_id', $app_id );
		}
		if ($key != '') {
			$this->db->like ( "concat(title,'||',n_content)", $key );
		}

		
		return $this->db->count_all_results ();
	}
	
	function load($id){
	    
	    if(!$id){
	        return array();
	    }

	    $this->db->where('id',$id);
	     
	    $query = $this->db->get('notice');
	     
	    if($row = $query->row_array()){
	        return $row;
	    }
	     
	    return array();
	}
	
	function create($data){
	    
	    
	    $res = $this->db->insert('notice',$data);
	    
	    return $this->db->insert_id();
	    
	}
	
	function save(){
	    
	     
	    $this->db->set('po_id',$this->po_id);
	    $this->db->set('title',$this->title);
	    $this->db->set('url',$this->url);
	    $this->db->set('sort_order',$this->sort_order);
	    $this->db->set('corporation_id',$this->corporation_id);
	    $this->db->set('app_id',$this->app_id);
	    $this->db->where('ad_id',$this->ad_id);
	     
	    $res = $this->db->update('ad_info');
	    if($res){
	        return 'success';
	    } 

	     
	}
	
	
	/**
	 * 删除
	 */
	public function deleted($id){
	    
	    $this->db->where('id',$id);
	    
	    if($this->db->delete('notice')){
	        return 1;
	    }else{
	        return 0;
	    }
	}
	
}