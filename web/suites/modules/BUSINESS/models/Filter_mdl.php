<?php
/**
 * 
 *
 *
 */
class Filter_mdl extends CI_Model
{

    var $product_id;

	var $attr_id;

	var $attr_value;

    
	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------
	
    
    public function get_filter_by_cate()
    {
    	
    }
    
    //获取筛选器
    public function get_filter()
    {
    	$filter=array();
    	//将需要的CATE查出
    	$mainCate = $this->get_filtercate();
    	foreach ($mainCate as $v)
    	{
    		$subCate = $this->getSubCate($v['id'],array(1,2));
    		$filter[$v["id"]] = $v;
    		foreach($subCate as $s)
    		{

    			$filter[$v["id"]][$s["level"]] =$s;
    			$filter[$v["id"]][$s["level"]][$s["cate_id"]] = $this->getSign($s["cate_id"]);
    		}
    		
    	}
    	//print_r($filter);
    	return $filter;
    	
    }
    
  /*  public function get_filter()
    {
    	$filter=array();

    	foreach ($this->get_filtercate() as $k=>$v)
    	{
    		$filter[$k] = $v;
    		$filter[$k]['attr']  = $this->get_attr_filter($v['id'],1);
    		$filter[$k]['attr2'] = $this->get_attr_filter($v['id'],2);
    	}
    	
    	return $filter;
    }*/
    
    public function getSubCate($cate_cateid,$levels)
    {
    	$this->db->from('sign_cate');
    	$this->db->where('cate_cateid',$cate_cateid);
    	$this->db->where_in('level',$levels);
    	$this->db->order_by('level','DESC');
    	return $this->db->get()->result_array();
    	
    }
    
    
    public function getSign($cateid)
    {
    	$this->db->from('sign');
    	$this->db->where('cate_id',$cateid);
    	return $this->db->get()->result_array();
    	
    }
    
    
    
    //获取参与筛选的分类
    public function get_filtercate()
    {
    	$this->db->select('id,name');
    	$this->db->from('product_cat');
    	$this->db->where('is_filter',1);
    	$this->db->order_by('sort_order','ASC');
    	return $this->db->get()->result_array();
    }
    
    
    //获取属性绑定的筛选
    function get_attr_filter($cid,$level=1)
    {
    	$this->db->select('att_id');
    	$this->db->from('attr_filter');
    	$this->db->where('cate_id',$cid);
    	$this->db->where('level',$level);
    	
    	$attr = array();
    	foreach ($this->db->get()->result_array() as $k=>$v)
    	{
    		$attr = $this->get_attr_by($v['att_id']);
    	}
    	return $attr;
    }
    
    public function get_attr_by($attr_id)
    {
    	$this->db->from('product_attr');
    	$this->db->where('id',$attr_id);
    	return $this->db->get()->row_array();
    }
    
    
}