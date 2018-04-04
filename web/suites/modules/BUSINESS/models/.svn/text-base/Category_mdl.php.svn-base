<?php
/**
 *
 *
 *
 */
class Category_mdl extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }

    //----------------------------------------------------------------
    /**
     * 根据商品id查询商品分类
     * @param int $id 商品id
     */
    function load($id)
    {
        $query = $this->db->get_where('product_cat',array('id' => $id));
        return  $query->row_array();
    }

    //----------------------------------------------------------------
    
    function getByCond($cond=array())
    {
      	$this->db->from('product_cat');
      	if(count($cond))
      	{
      		$this->db->where($cond);
      	}
      	$this->db->order_by("sort_order asc");

        $query = $this->db->get();

        return $query->result_array();
    }
    
	// --------------------------------------------------------------------

	function find_by_level($app_id = 0, $level = 1,$parent_id='')
	{
        $this->db->where('level',(int)$level);
		if ($parent_id != ''){
            $this->db->where('parent_id',(int)$parent_id);
		}
		if ($app_id != 0){
            $this->db->where('app_id',$app_id);
		}
		
	    $this->db->order_by('sort_order','asc');

        $query = $this->db->get('product_cat');


        if ($row = $query->result_array()){
            return $row;
        }

        return array();
	}


    // ---------------------------------------------------------------------------

	/**
	 * 根据父级id查询子分类
	 * @param int $app_id 分站点id
	 * @param int $parentid 父级id
	 * @param int $cat_id 指定不查询的分类id
	 */
	function get_child($app_id = 0,$parentid,$cat_id = 0) {
		$this->db->from ( 'product_cat' );
		$this->db->where ( 'parent_id', $parentid );
		if ($app_id !== 0) {
			$this->db->where ( 'app_id', $app_id );
		}
		if($cat_id){
		   $this->db->where("id !=",$cat_id); 
		}
		$this->db->order_by ( 'path', 'asc' );
		$query = $this->db->get();
		return $query->result_array();
	}
	
	// ---------------------------------------------------------------------------
	

	/**
	 * 查询供需全部分类
	 * @param array $cate_array 分类ID
	 */
	function categroy_deamnd($cate_array){
	    if(!$cate_array){
	        return array();
	    }
	    $this->db->from('product_cat');
	    $this->db->or_where_in('id',$cate_array);
	    $query = $this->db->get();
        return $query->result_array();
	}

	
	/**
	 * 根据分类名查找
	 */
    function getchildbyname($name="",$app_id=""){
        if ($name == NULL){
            return array();
        }
        $this->db->from('product_cat');
        
        $this->db->like('name', $name);
        if ($app_id !== 0) {
            $this->db->where('app_id', $app_id);
        }
        
        $this->db->order_by('path', 'asc');
        $query = $this->db->get();
        
        return $query->result_array();
    }

    /**
     * 查询子分类
     * @param unknown $parent_id
     * @return unknown
     */
	public function get_childcatbyparent($parent_id)
	{
	    $this->db->distinct();
		$query = $this->db->select("pc.id,pc.name")->from ('product_cat as pc')
		->join('product as p','pc.id = p.cat_id')->like('path',$parent_id.",")->get();
		//test bug
// 		->join('product as p','pc.id = p.cat_id')->like('path',$parent_id.",","after")->get();
	    $row = $query->result_array();
	    return $row;
	}

	
    
    /**
     * 根据房产查询下级所有商品
     */
    public function get_cat_property_room($cat_ids_array){
//         $query = $this->db->query("select TABLE1.*,group_concat(TABLE2.option_values ) as attribute from 
//         (SELECT `a`.*,b.attr_set_id as cat_attr_set_id FROM (`9thleaf_product` a) JOIN `9thleaf_product_cat` b ON `b`.`id` = `a`.`cat_id` WHERE `a`.`cat_id` IN ($cat_id_string)) as TABLE1, 
//         (SELECT id as attr_id ,attr_set_id , attr_name,option_values FROM (`9thleaf_product_attr` a)) as TABLE2 
//         where TABLE1.is_on_sale=1 and TABLE1.is_delete=0  AND TABLE1.is_mc=0 and TABLE1.cat_attr_set_id=TABLE2.attr_set_id group by TABLE1.ID");
        $this->db->from('product as a');
        $this->db->join('(select product_id,group_concat(attr_value) as attribute from 9thleaf_product_attr_value group by product_id) as b','a.id = b.product_id','left');
        $this->db->where_in('a.cat_id',$cat_ids_array);
        $this->db->where('a.is_on_sale',1);
        $this->db->where('a.is_delete',0);
        $this->db->where('a.is_mc',0);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
		//echo $this->db->last_query();
        return $query->result_array();
    }


}