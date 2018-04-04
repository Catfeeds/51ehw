<?php
/**
 * 部落产品
 *
 *
 */
class Product_tribe_mdl extends CI_Model {

	function __construct() {
		parent::__construct ();
	}
	
	// ---------------------------------------------------
	
	/**
	 * 产品列表，商品查询
	 * @param int $corporation_id 企业id
	 * @param array $tribeids 部落id
	 * @param array $productids 产品id
	 * @param string $keywork 关键词
	 * @param int $status 状态：0全部1销售中2待发布3已经售罄
	 */
	public function get_list($corporation_id,$tribeids,$limit=0,$offset=0,$productids=0,$keywork=null,$status=0){
	    $this->db->select("a.id as product_id,a.productnum,a.on_sale_at,a.name ,a.is_on_sale,a.goods_thumb,a.stock,a.tribe_price");
	    $this->db->select("any_value(b.id) as id");
	    $this->db->select("c.name as cat_name,if(any_value(b.tribe_id),group_concat(d.name separator '、'),'') as tribe_name,group_concat(b.tribe_id separator '-') as tribe_id,e.tribe_sales");
	    $this->db->from("product as a");
	    $this->db->join("product_tribe as b","a.id = b.product_id");
	    $this->db->join("product_cat as c","a.cat_id = c.id");
	    $this->db->join("tribe as d","d.id = b.tribe_id or b.tribe_id is null or b.tribe_id = ''");
	    $this->db->join("product_sales_view as e",'e.id = a.id','left');
	    $this->db->where("a.corporation_id",$corporation_id);
	    $this->db->where("is_delete","0");
	    $this->db->where_in("d.id",$tribeids);
	    if($productids){
	        $this->db->where_in("a.id",$productids);
	    }
	    if($limit){
	        $this->db->limit($limit,$offset);
	    }
	    if($status){
	        switch ($status){
	            case 1:
	                $this->db->where("a.is_on_sale",1);
	                break;
	            case 2:
	                $this->db->where_in("a.is_on_sale",array(0,3));
	                break;
	            case 3:
	                $this->db->where("a.is_on_sale",1);
	                $this->db->where("a.stock",0);
	                break; 
	        }
	    }else if(strlen($keywork) >0){
	        $this->db->like('a.name',$keywork);
	    }
	    $this->db->group_by("a.id");
	    $this->db->order_by("a.id","desc");
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	// ---------------------------------------------------------------------------
	
	/**
	 * 添加部落产品
	 * @param array 数据集合
	 */
	public function add($data){
	    $this->db->set($data);
	    $this->db->insert("product_tribe");
	    return $this->db->affected_rows();
	}
	
	// ---------------------------------------------------------------------------
	
	/**
	 * 更新数据
	 * @param array $productids 产品id
	 * @param array $data 数据集合
	 */
	public function save($productids,$data){
	    $this->db->set($data);
	    $this->db->where_in("product_id",$productids);
	    return $this->db->update("product_tribe");
	}
	
	// ---------------------------------------------------------------------------
	
	/**
	 * 根据id查询部落产品
	 * @param int $product_id 产品id
	 */
	public function get_TribeProduct($product_id){
	    $this->db->from("product_tribe");
	    $this->db->where_in("product_id",$product_id);
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	// ---------------------------------------------------------------------------
	
	/**
	 * 根据删除部落产品
	 * @param int $product_id 产品id
	 * @param int $trive_id 部落id
	 */
	public function del($product_id,$tribe_id = 0){
	    
	    $this->db->where("product_id",$product_id);
	    if($tribe_id){
	       $this->db->where("tribe_id",$tribe_id);
	    }
	    return $this->db->delete("product_tribe");
	}
	 
	 
}