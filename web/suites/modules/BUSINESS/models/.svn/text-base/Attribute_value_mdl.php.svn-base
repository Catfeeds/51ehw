<?php
/**
 * 商品属性值
 *
 *
 */
class Attribute_value_mdl extends CI_Model
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
     * 查询属性
     * @param int $id 属性id
     */
    function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('product_attr_value',array('id' => $id));

        return $query->row_array();
    }
    


	// --------------------------------------------------------------------

    /**
	 * 添加产品属性
	 * @param array $data 数组集合
	 */	
    function create($data){
        $this->db->set($data);
		$this->db->insert('product_attr_value');
		return $this->db->insert_id();
    }	

    // --------------------------------------------------------------------

    /**
	 * 更新
	 *
	 *
	 */	
    function update($attr_id,$product_id)
    {
		$this->db->set('product_id', $this->product_id);
		$this->db->set('attr_id', $this->attr_id);
        $this->db->set('attr_value', $this->attr_value);
       
        $this->db->where('attr_id', $attr_id);
		$this->db->where('product_id', $product_id);
        return $this->db->update('product_attr_value');
    }
    
	// --------------------------------------------------------------------

//     /**
// 	 * 删除
// 	 *
// 	 *
// 	 */	
//     function delete($attr_id,$product_id,$attr_values = array())
//     {        
// 		$this->db->where('attr_id', $attr_id);
// 		$this->db->where('product_id', $product_id);
// 		if(!empty($attr_values)){
// 		    $this->db->where_not_in('attr_value', $attr_values);
// 		}

//         return $this->db->delete('product_attr_value'); 
//     }

        /**
    	 * 根据商品id删除属性
    	 */
        function delete_attr($product_id)
        {
    		$this->db->where('product_id', $product_id);
            return $this->db->delete('product_attr_value');
        }


	
    // --------------------------------------------------------------------

    /**
	 * 判断单选属性是否存在
	 *
	 *
	 */	
	function is_exist($attr_id,$product_id)
	{
        $query = $this->db->get_where('product_attr_value',array('attr_id' => $attr_id,'product_id' => $product_id));

        if ($row = $query->row_array()){
            return TRUE;
        }

        return FALSE;
	}

   
    // --------------------------------------------------------------------

    /**
	 * 删除旧属性分组的属性值
	 *
	 *
	 */	
	function delete_old($product_id)
    {   
		$this->db->where('product_id', $product_id);
        return $this->db->delete('product_attr_value'); 
    }

   

    // --------------------------------------------------------------------

    /**
	 * 判断复选属性是否存在
	 *
	 *
	 */	
    function is_exist1($attr_value,$attr_id,$product_id)
	{
        $query = $this->db->get_where('product_attr_value',array('attr_value' => $attr_value,'attr_id'=> $attr_id,'product_id'=>$product_id));

        if ($row = $query->row_array()){
            return TRUE;
        }

        return FALSE;
	}


	function findByProductAttr($productid,$attr_id)
	{
		$this->db->select('attr_value');
		$this->db->where(array('attr_id' => $attr_id,'product_id'=>$productid));
		$this->db->from('product_attr_value');

		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($row = $query->result_array()){
			return $row;
		}else
		{
			return null;
		}
		
	}
	
	/**
	 * 统计专题属性商品属性
	 */
	function count_list($key,$val,$search_val=null){ 
	    $this->db->select('p.name,count(pav.product_id) as num,pav.product_id')->from('product_attr_value as pav');
	    $this->db->join('product as p','p.id = pav.product_id');
	    if($key && $val){
    	    $this->db->where_in('pav.attr_id',$key);
    	    $this->db->where_in('pav.attr_value',$val);
	    }
	    if($search_val){
	    $this->db->where("(pav.attr_value LIKE '%$search_val%' OR p.name LIKE '%$search_val%')");
// 	    $this->db->or_like('p.name',$search_val.')');
	    }
	    $query = $this->db->group_by(' pav.product_id')->get();
	    return $query->result_array();
	}

	/**
	 * 根据属性名称获取value，value值不重复
	 */
	function getValueByArrtName($attr_name){
	    $this->db->distinct();
	    $this->db->select('pa.option_values');
	    $this->db->from('product_attr as pa');
	    $this->db->where_in('pa.attr_name',$attr_name);
	    $this->db->where(array('pa.option_values <>'=>''));
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
}