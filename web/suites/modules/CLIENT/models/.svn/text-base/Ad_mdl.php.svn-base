<?php
/**
 * 
 *
 *
 */ 
class Ad_mdl extends CI_Model {
    
	function __construct() {
		parent::__construct ();
	}
	function getBySign($sign, $app_id = -1, $section_id = 0) {
        if (! $sign) {
            return array();
        }
        
        $this->db->select('ad_info.*,ad_position.po_sign');
        $this->db->from('ad_info');
        $this->db->join('ad_position', ' ad_info.po_id = ad_position.po_id');
        $this->db->where('po_sign', $sign);
        $this->db->where('app_id', ($app_id?$app_id:0));

        if ($section_id != 0) {
            $this->db->where('section_id', $section_id);
        }
        $this->db->order_by("sort_order");
        $query = $this->db->get();
        
        if ($row = $query->result_array()) {
            return $row;
        }
        
        return array();
    }
    
	function getLikeSign($sign) {
		if (! $sign) {
			return array ();
		}
		$this->db->select ( 'ad_info.*,ad_position.po_sign' );
		$this->db->from ( 'ad_info' );
		$this->db->join ( 'ad_position', ' ad_info.po_id = ad_position.po_id' );
		
		$query = $this->db->like ( 'po_sign', $sign, 'after' )->get ();
		
		if ($row = $query->result_array ()) {
			return $row;
		}
		
		return array ();
	}
	
	function getlist($corporation_id){
	    
	    if(!$corporation_id){
	        return array();
	    }
	    $this->db->where('corporation_id',$corporation_id);
	    $this->db->order_by('sort_order','asc');
	    $query = $this->db->get('ad_info');
	    
	    if($row = $query->result_array()){
	        return $row;
	    }
	    
	    return array();
	    
	}
	
	function load($id){
	    
	    if(!$id){
	        return array();
	    }

	    $this->db->where('ad_id',$id);
	     
	    $query = $this->db->get('ad_info');
	     
	    if($row = $query->row_array()){
	        return $row;
	    }
	     
	    return array();
	}
	
	function create(){
	    
	    if(isset($this->po_id)){$this->db->set('po_id',$this->po_id);}
	    if(isset($this->title)){$this->db->set('title',$this->title);}
	    $this->db->set('url',$this->url);
	    $this->db->set('sort_order',$this->sort_order);
	    $this->db->set('corporation_id',$this->corporation_id);
	    $this->db->set('app_id',$this->app_id);
	    
	    $res = $this->db->insert('ad_info');
	    
	    return $this->db->insert_id();
	    
	}
	
	function save(){
	    
	     
	    if(isset($this->po_id)){$this->db->set('po_id',$this->po_id);}
	    if(isset($this->title)){$this->db->set('title',$this->title);}
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
	
	function save_imgurl($ad_id = ''){
	    
	    $this->db->set('img_url',$this->img_url);

	    if(isset($ad_id) && $ad_id>0){
	        $this->db->where('ad_id',$ad_id);
	        $res = $this->db->update('ad_info');
	        return $ad_id;
	    }else{
	       $this->db->set('corporation_id',$this->corporation_id);
	       $this->db->set('app_id',$this->app_id);
	       
	       $res = $this->db->insert('ad_info');
	       return $this->db->insert_id();
	    }
	    
	    
	}
	
	/**
	 * 获取广告位置
	 */
	public function get_adpo(){
	    
	    $query = $this->db->get('ad_position');
	    
	    return $query->result_array();
	    
	}
	
	/**
	 * 删除广告
	 */
	public function deleted(){
	    
	    $this->db->where('ad_id',$this->ad_id);
	    
	    if($this->db->delete('ad_info')){
	        return 1;
	    }else{
	        return 0;
	    }
	}
	
}