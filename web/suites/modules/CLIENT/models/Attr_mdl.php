<?php
/**
 * 商品属性值
 *
 *
 */
class Attr_mdl extends CI_Model
{

    var $product_id;

	var $attr_id;

	var $attr_value;

    
	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------

    /**
	 * 某个商品属性值
	 *
	 *
	 */	
	function find_product_attr_values($product_id = '')
	{
		if (empty($product_id)){
			return array();
		}
		//attr_value
        $this->db->select('v.*,a.attr_type');
		//attr
        $this->db->select('attr_name as attr_name');

		$this->db->from('product_attr_value as v');
        $this->db->join('product_attr as a', 'a.id = v.attr_id', 'left outer');

		$this->db->where('product_id' , (int)$product_id);
		$this->db->where('attr_type !=' , 'related');

		$query = $this->db->get();
		//echo $this->db->last_query();
        $rows = array();
        foreach ($query->result_array() as $row){
            $rows[] = $row;
        }
        return $rows;
	}

	function find_attrs_by_attr_set($cat_id=0,$attr_type = '')
	{
		if($attr_type !="")
		{
			$this->db->where('product_attr.attr_type',$attr_type);
		}
		$this->db->select("product_attr.*");
		$this->db->order_by("sequence");
		$this->db->join('product_cat','product_cat.attr_set_id = product_attr.attr_set_id');
		$query = $this->db->get_where('product_attr',array('product_cat.id' => $cat_id));


		
		//echo $this->db->last_query();
        $rows = array();
        foreach ($query->result_array() as $row){
            $rows[] = $row;
        }
        return $rows;
	}
}