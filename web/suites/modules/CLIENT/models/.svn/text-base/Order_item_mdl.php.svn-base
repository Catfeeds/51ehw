<?php
/**
 * 订单项
 *
 *
 */
class Order_item_mdl extends CI_Model
{

    public $order_id;

	public $product_id;

	public $product_name;

	public $quantity;

	public $price;

	public $weight;

	public $sku_id;
	
	public $sku_value;


    
	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------

    /**
	 * 添加订单项
	 *
	 *
	 */	
    function create()
    { 
        $this->db->set('order_id', $this->order_id);
		$this->db->set('product_id', $this->product_id);
		$this->db->set('product_name', $this->product_name);					
		$this->db->set('quantity', $this->quantity);
		$this->db->set('price', $this->price);
		$this->db->set('weight', $this->weight);
		$this->db->set('sku_id', $this->sku_id);
		if(!empty($this->sku_value) )
            $this->db->set('sku_value',$this->sku_value);
        return $this->db->insert('order_item');
		// echo $this->db->last_query();

    }
  
    // --------------------------------------------------------------------

    /**
	 * 查找订单项
	 *
	 *
	 */	
	function find_order_items($order_id, $count='')
	{
		if (!$order_id){
            return array();
        }
       
		if ($count){
            $this->db->limit((int)$count, 0);
        }

        $query = $this->db->get_where('order_item',array('order_id' => $order_id));

        $rows = array();
        foreach ($query->result_array() as $row){
            $rows[$row['id']] = $row;
        }
        return $rows;
	}
    
	/**
	 * 修改单价
	 */
	public function up_price( $data ){ 
	    $this->db->set('price',$data['price']);
	    $this->db->where('id',$data['id']);
	    return $this->db->update('order_item');
	}
	
	/**
	 * 查询item表里某个订单买的总价格
	 */
	public function item_goods_total($order_id){ 
	    $this->db->select('sum(quantity * `price`) as total_price')->from('order_item as i')->where('i.order_id',$order_id);
	    return $this->db->get()->row_array();
	}
	
	/**
	 * 查询某个订单下面的所有商品
	 */
	public function order_item_goods( $order_id ){ 
	    $this->db->select('oi.*')->from('order_item as oi');
	    $this->db->join('order as o','o.id = oi.order_id');
	    $this->db->where('o.id',$order_id);
	    return $this->db->get()->result_array();
	}
}