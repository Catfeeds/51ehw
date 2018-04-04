<?php
/**
 * 商品
 *
 *
 */
class Requirement_mdl extends CI_Model {

	var $orderitem_id;
	var $product_score;
	var $service_score;
	var $content;
	var $start_time;
	var $end_time;


	function __construct() {
		parent::__construct ();
	}
	
	// --------------------------------------------------------------------
	
    /**
     * 获取发布需求
     */
	public function getList($status='',$search_name='',$start_time='',$end_time='',$cate_id='',$offset='',$count = ''){
        
	    $this->db->limit ( ( int ) $count, ( int ) $offset );
        if($status>=1 && $status<=3){$this->db->where('grade',$status);}
        elseif($status>=4 && $status<=7) {
            $this->db->where('create_at >= ',$start_time);
            $this->db->where('create_at <= ',$end_time);
        }
        if($search_name && $cate_id!=''){$this->db->where('cate_id',$cate_id);$this->db->like('p_content',$search_name);}
        if($search_name=='' && $cate_id!=''){$this->db->where('cate_id',$cate_id);}
        if($search_name && $cate_id==''){$this->db->like('p_content',$search_name);}
        
	    $res = $this->lists();
	    return $res;
	}
	
	/**
	 * 获取发布需求总数
	 * @param string $status
	 * @return unknown|multitype:
	 */
	public function countList($status='',$search_name='',$start_time='',$end_time='',$cate_id='',$offset='',$count = ''){
	    
	        if($status>=1 && $status<=3){$this->db->where('grade',$status);}
	        elseif($status>=4 && $status<=7) {
	            $this->db->where('create_at >= ',$start_time);
	            $this->db->where('create_at <= ',$end_time);
	        }
	       if($search_name && $cate_id!=''){$this->db->where('cate_id',$cate_id);$this->db->like('p_content',$search_name);}
           if($search_name=='' && $cate_id!=''){$this->db->where('cate_id',$cate_id);}
           if($search_name && $cate_id==''){$this->db->like('p_content',$search_name);}
	    
	        $res = count($this->lists());
	        return $res;

	}
	
	/**
	 * 创建需求
	 */
	public function create(){
	     
	     
	    $this->db->set('cate_id',$this->cate_id);
	    $this->db->set('p_name',$this->p_name);
	    $this->db->set('p_count',$this->p_count);
	    $this->db->set('m_price',$this->m_price);
	    $this->db->set('p_content',$this->p_content);
	    $this->db->set('create_by',$this->create_by);
	    $this->db->set('create_at',date('Y-m-d H:i:s'));
	    $this->db->set('ispublish',1);
	     
	    $this->db->insert('requirement');
	    return $this->db->insert_id();
	     
	}
	
	function lists($status=''){
	    $this->db->select('r.*,cc.corporation_name,cc.grade,rc.cate_name');
	    $this->db->from('requirement as r');
	    $this->db->join('customer_corporation as cc','r.create_by = cc.customer_id','left_outer');
	    $this->db->join('requirement_cate as rc','r.cate_id = rc.id','left_outer');
	    $this->db->where('ispublish = 1');
	    $this->db->order_by('create_at','DESC');
	    $res = $this->db->get();
	    
	    //echo $this->db->last_query();
	    if($r = $res->result_array()){
	        return $r;
	    }else{
	        return array();
	    }
	}

	// --------------------------------------------------------------------
	
    
	
	// --------------------------------------------------------------------
	

	
	// --------------------------------------------------------------------
	


	
	// --------------------------------------------------------------------
	


	// --------------------------------------------------------------------
	


	// --------------------------------------------------------------------



	
	// --------------------------------------------------------------------



	
	// --------------------------------------------------------------------
	/**
	 * 统计未评价的条数
	 */

    
    /**
     * 统计全部评价
     */

	
	// --------------------------------------------------------------------
	
    /**
     * 私有崡数
     */
	
	// --------------------------------------------------------------------
	

	
	// --------------------------------------------------------------------
	

	
	// --------------------------------------------------------------------
	

}