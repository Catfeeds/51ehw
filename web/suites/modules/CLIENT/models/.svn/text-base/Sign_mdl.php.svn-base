<?php
/**
 * 
 *
 *
 */
class Sign_mdl extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }
    
    function getCateByMainCate($cateid)
    {
    	
        if (!$cateid){
            return array();
        }
        
		$this->db->from('sign_cate');
		$this->db->order_by('sort asc');
        $query = $this->db->where('cate_cateid',$cateid)->get();

        if ($row = $query->result_array()){
            return $row;
        }

        return array();
    }
    
    function getCateByParentCate($cateid,$fid=0)
    {
      
        
		$this->db->from('sign_cate');
		$this->db->order_by('sort asc');
		$this->db->where('cate_cateid',$cateid);
        $query = $this->db->where('parent_cate_id',$fid)->get();
        if ($row = $query->result_array()){
        	//echo $this->db->last_query();
            return $row;
        }

		
        return array();
    }
    
    
    function getByCondition($cond=array(),$select='')
    {
    	if($select)
    		$this->db->select($select);

		$this->db->from('sign');
		if($cond)
		{
			$this->db->where($cond);
		}
		

		$this->db->order_by("sign_id","ASC");
        $query = $this->db->get();

        if ($row = $query->result_array()){
        	// echo $this->db->last_query();
            return $row;
        }
       
        return array();
    }
    
   
    
    function getByMainCate($cateid,$fid)
    {
        if (!$cateid){
            return array();
        }
        if(!$fid)
        {
        	return array();
        }
		
		$this->db->from('sign');
		$this->db->join('sign_cate','sign.cateid = sign_cate.cate_id');
		if(!$fid)
		{
			
			$this->db->where('parent_id',$fid);
		}
		
		$this->db->where('cate_cateid',$cateid);
        $query = $this->db->get();

        if ($row = $query->result_array()){
            return $row;
        }

        return array();
    }
    
    function getByWithCate($condition)
    {
       
		//print_r($condition);
		$this->db->from('sign');
		$this->db->join('sign_cate','sign.cate_id = sign_cate.cate_id');
		if($condition)
		{
			
			$this->db->where($condition);
			
			
		}
		
        $query = $this->db->get();
		echo $this->db->last_query();
        if ($row = $query->result_array()){
        //	
            return $row;
        }

        return array();
    }
    
    
    function getFilterForApp($cateid,$level)
    {
    	$this->db->select('cate_id');
    	$this->db->from('sign_cate');
    	$this->db->where('level',$level);
    	$this->db->where('cate_cateid',$cateid);
    	
    	$query = $this->db->get();
    	if ($row = $query->row_array()){
    		if($row2 = $this->getByCondition(array('cate_id'=>$row['cate_id']),'sign_id,sign_name,cate_id'))
    		{
    			return $row2;
    		}
    	}
    	return array();
    }

}