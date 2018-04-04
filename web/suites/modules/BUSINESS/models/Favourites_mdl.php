<?php
/**
 * 常见问题
 *
 *
 */
class Favourites_mdl extends CI_Model
{


    
	function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
	 * load by id
	 *
	 *
	 */	
    function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('faq',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }

    // --------------------------------------------------------------------


    /**
	 * 查询常见问题
	 *
	 *
	 */	
	function findFavouritesByUser($count=0, $offset=0,$userid,$options = array())
	{

		if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
		$this->db->where('customer_id',$userid);

		$this->db->order_by('id','desc');

		$query = $this->_query_orders($options);

        $rows = array();
        foreach ($query->result_array() as $row){
            $rows[] = $row;
        }
		//echo $this->db->last_query();
        return $rows;
	}
    
	
    // --------------------------------------------------------------------

    /**
	 * 私有函数
	 *
	 *
	 */
	function _query_orders($options)
    {
		if($options != null && $options != "")
		{
			$this->db->where($options);
		}
        $this->db->from('favourites');
		
        return $this->db->get();
    }
    
    // --------------------------------------------------------------------

	/**
	 * 收藏商品总数
	 */	
	function count_Favourites($options = null)
	{		
		$this->db->select('COUNT(DISTINCT(id)) as total');       
        $query = $this->_query_orders($options);
        $total = 0;
        if ($row = $query->row_array()){
            $total = (int)$row['total'];
        }
        return $total;
	}

    // --------------------------------------------------------------------
    
	function create($data)
	{
		return $this->db->insert('favourites',$data);
	}

    // ---------------------------------------------------------------------------

	/**
	 * 获取商品收藏信息
	 * @param int $customer_id 用户id
	 * @param int $pid 商品id
	 */
	function _check_fav($customer_id,$pid)
	{
	    if(!$customer_id || !$pid){
	        return array();
	    }
	    if(is_array($pid)){
	        $this->db->where_in('product_id',$pid);
	    }else{
	        $this->db->where('product_id',$pid);
	    }
		$this->db->where('customer_id',$customer_id);
		$this->db->from('favourites');
		$query = $this->db->get();
        return $query->row_array();
	}
	
	// ---------------------------------------------------------------------------
	

	/**
	 * 取消收藏
	 * @param unknown $ids
	 * @param unknown $customerid
	 */
	public function deletefav($ids,$customerid)
	{
				//搜出数据库中的购物车商品
		$this->db->where_in("product_id",$ids);
		$this->db->where("customer_id",$customerid);
		return  $this->db->delete('favourites');

	}
	
	/**
	 * 收藏列表
	 */
	public function fav_product_list($user_id,$count=0, $offset=0){
		if ($count){
            $this->db->limit((int)$count, (int)$offset);
        }
        
	    $this->db->select('a.*,b.name as product_name,b.goods_thumb,b.vip_price as price');
	    $this->db->from('favourites a');
	    $this->db->join('product b','a.product_id=b.id');
		$this->db->where('a.customer_id',$user_id);
		$this->db->where('b.is_on_sale',1);
		$this->db->where('b.is_delete',0);
		$this->db->where('b.is_mc',0);
		$this->db->order_by('a.id','desc');
		return $this->db->get()->result_array();
	}

	// --------------------------------------------------------------------
	
	/**
	 * 收藏商品总数
	 */
	function count_corporation_Favourites($user_id)
	{
	    $this->db->select('COUNT(DISTINCT(id)) as total');
	    $this->db->from("favourites_corporation");
	    $this->db->where("customer_id",$user_id);
	    $row = $this->db->get()->row_array();
	    return $row['total'];
	}

	// --------------------------------------------------------------------
	
	/**
	 * 收藏店铺列表
	 */
	public function fav_corp_list($user_id,$count=0, $offset=0){
	    if ($count){
	        $this->db->limit((int)$count, (int)$offset);
	    }
	    $this->db->select('a.id,a.corporation_name,b.created_at,a.grade,a.img_url,b.id as fid');
	    $this->db->from('customer_corporation a');
	    $this->db->join('favourites_corporation b','a.id=b.corporation_id','left');
	    $this->db->where('b.customer_id',$user_id);
	    $this->db->where('a.status',1);
	    $this->db->order_by('b.id','desc');
	    return $this->db->get()->result_array();
      
	}
	
	// ---------------------------------------------------
	
	/**
	 * 添加收藏商品
	 * @param array $data 
	 */
	public function add_fav($data){
        return $this->db->insert_batch('favourites', $data);
	}
	// ---------------------------------------------------
	
	/**
	 * 取消收藏店铺
	 * @param unknown $id 收藏id
	 */
	public function del_fav_corp($id){
	    $this->db->where_in('id',$id);
	    return $this->db->delete('favourites_corporation');
	}
	
	/**
	 * 取消收藏店铺
	 * @param unknown $corporation_id 店铺id
	 */
	public function del_fav_corp_id($corporation_id){
	    
	    if(!$corporation_id){
	        return false;
	    }
	    
	    $customer_id = $this->session->userdata('user_id');
	    $data = array('corporation_id' => $corporation_id , 'customer_id' => $customer_id);
	    $this->db->where($data);
	    return $this->db->delete('favourites_corporation');
	}
	
	

}