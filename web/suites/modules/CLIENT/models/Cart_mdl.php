<?php
/**
 * 
 * 购物车模型
 *
 */
class Cart_mdl extends CI_Model {
	
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
		$this->load->library ( 'cart' );
	}
	
	//-------------------------------------------------
	
	/**
	 * 添加到购物车
	 * @param unknown $data
	 */
	function add($data) {
		$this->db->insert ( 'cart', $data );
		return $this->db->insert_id();
	}
	
	//-------------------------------------------------
	
	/**
	 * 登录后重置购物车
	 * @param unknown $customer_id
	 */
	function reinit($customer_id) {		
	    //重置购物车流程：搜索数据库购物车列表->遍历cookie整合cookie购物车->将cookie数据录入数据库整合数据库购物车
		//搜出数据库中的购物车商品		
	    $this->db->select('c.*,cc.id corporation_id,cc.corporation_name,p.stock,p.is_freight, p.default_item, p.default_freight,p.add_item,p.add_freight,p.special_price,p.special_price_start_at,p.special_price_end_at,p.is_special_price');
	    $this->db->from('cart c');
	    $this->db->join('product p','c.product_id = p.id','left outer');
	    $this->db->join('customer_corporation cc','cc.id = p.corporation_id','left outer');
	    $this->db->where('c.customer_id',$customer_id);
        $query = $this->db->get();
		$carts = $query->result_array ();
      
		//遍历cookie中的购物车商品，放入数组
		$cachecart = array ();
		foreach ( $this->cart->contents () as $items ) {
			$cachecart [$items ['id']] [$items ['sku_id']] = $items;
		}

		// 情况一 ：当数据库购物车有商品，需要整合cookie以及数据库。
		//遍历数据库中的购物车商品，比较cookie中的购物车商品
		
		foreach ( $carts as $cart ) {
		
            // 如果发现重复，则数量相加
            if (isset($cachecart[$cart['product_id'] . '_' . $cart['sku_id']])) {
                //session更改购物车cid、qty
                $cart_session = $this->session->userdata('cart_contents');
                $row_id = $cachecart[$cart['product_id'] . '_' . $cart['sku_id']][$cart['sku_id']]['rowid'];
                $qty = (int)($cart_session[$row_id]['qty']) + (int)($cart['quantity']);
                $cart_session[$row_id]['cid'] = $cart['id'];
                $cart_session[$row_id]['qty'] = $qty;
                $cart_session[$row_id]['product_id'] = $cart['product_id'];
//                 $cart_session[$row_id]['freight'] = $this->freight_count($cart['product_id'],$qty);
                $cart_session[$row_id]['freight'] = 0;
                $this->session->set_userdata('cart_contents',$cart_session);
                
            }
            // 否则直接添加新商品到cookie购物车
            else {
                $data = array(
                    'cid' => $cart['id'],
                    'corporation_id' => $cart['corporation_id'],
                    'corporation_name' => $cart['corporation_name'],
                    'id' => $cart['product_id'] . '_' . $cart['sku_id'],
                    'qty' => $cart['quantity'],
                    'price' => $cart['price'],
                    'name' => $cart['product_name'],
                    'sku_id' => $cart['sku_id'],
                    'freight' => $cart['freight'],
                    'product_id' => $cart['product_id'],
                    'product_status'=> 'ok',
                    'options' => array(
                        'goods_img' => $cart['img_goods'],
                        'special_price_start_at' => $cart['is_special_price'] && $cart['special_price_start_at'] <= date("Y-m-d H:i:s") && $cart['special_price_end_at'] >= date("Y-m-d H:i:s") ? $cart['special_price_start_at'] : '1970-01-01 08:00:00',
                        'special_price_end_at' => $cart['is_special_price'] && $cart['special_price_start_at'] <= date("Y-m-d H:i:s") && $cart['special_price_end_at'] >= date("Y-m-d H:i:s") ? $cart['special_price_end_at'] : '1970-01-01 08:00:00'
                    )
                );
                
                // 如果是特价执行
                if ($cart['special_price_start_at'] <= date("Y-m-d H:i:s") && $cart['special_price_end_at'] >= date("Y-m-d H:i:s")) {

                    $data['price'] = $cart['special_price'];
                } 
                
                if ($cart['sku_id'] != 0 && $cart['sku_id'] != null) {
                    $this->load->model('product_sku_mdl');
                    $sku = $this->product_sku_mdl->getSKUByValID($cart['sku_id']);
                    $sku_val = $this->product_sku_mdl->getSKUValue($cart['sku_id']);
                    foreach ($sku as $key => $s) {
                        $sku_val['sku_name'][$key] = $s['sku_name'];
                    }
                    $data['sku_name'] = $sku_val['sku_name'];
                    $data['stock'] = $sku_val['stock'];
                } else {
                    $data['stock'] = isset($cart['stock']) && $cart['stock'] != null ? $cart['stock'] : 0;
                }
                $this->cart->insert($data);
            }
        }
       
        //
        // 情况二 ：当数据库购物车无商品，直接将cookie数据插入数据库
        // 清空用户的购物车商品
        $this->db->delete('cart', array(
            'customer_id' => $customer_id
        ));
        
        // 最后将cookie中的购物车商品，写入数据库
        $insert_cart = array();

        foreach ($this->cart->contents() as $items) {
    
            //重新获取session数据，更新数据库
            $cart_session = $this->session->userdata('cart_contents');
            $row_id = $items['rowid'];
            
            $cart = array(
                'customer_id' => $customer_id,
                'product_id' => explode('_', $items['id'])[0],
                'quantity' => $cart_session[$row_id]['qty'] ,
                'price' => $items['price'],
                'product_name' => $items['name'],
                'sku_id' => $items['sku_id'],
                'img_goods' => $items['options']['goods_img'],
                'freight' => $cart_session[$row_id]['freight']
            );
            $this->db->insert('cart', $cart);
            
            //写入数据库成功，回调操作id插入cookie
            $cond['cid'] = $this->db->insert_id();
            
            $cart_session[$row_id]['cid'] = $cond['cid'];
            $this->session->set_userdata('cart_contents',$cart_session);
        }
	}

	//-------------------------------------------------
	
	public function getCartList($customer_id,$limit = 0, $offset = 0)
	{
        if ($limit)
            $this->db->limit($limit);
        if ($offset)
            $this->db->offset($offset);
        $this->db->select('c.*,cc.id corporation_id,cc.corporation_name');
        $this->db->from('cart c');
        $this->db->join('product p', 'c.product_id = p.id', 'left outer');
        $this->db->join('customer_corporation cc', 'cc.id = p.corporation_id', 'left outer');
        $this->db->where('c.customer_id', $customer_id);
        $query = $this->db->get();
        return $query->result_array();
    }

	public function count_list($customer_id)
	{
        $this->db->select('c.*,cc.id corporation_id,cc.corporation_name');
        $this->db->from('cart c');
        $this->db->join('product p', 'c.product_id = p.id', 'left outer');
        $this->db->join('customer_corporation cc', 'cc.id = p.corporation_id', 'left outer');
        $this->db->where('c.customer_id', $customer_id);
        $query = $this->db->get();
        return $this->db->count_all_results();
    }
    
    // -------------------------------------------------
    
    /**
     * 获取购物车商品数量
     * 
     * @param unknown $customer_id
     * @return unknown
     */
    public function product_amount($customer_id)
    {
        $this->db->select('sum(quantity) as amount,customer_id')
            ->where('customer_id', $customer_id)
            ->from('cart');
        $query = $this->db->get();
        if ($row = $query->result_array()) {
            return $row;
        }
        return array();
    }
    
    // -------------------------------------------------

	public function deleteCart($id,$customerid)
	{
        $this->db->delete('cart', array(
            'id' => $id,
            'customer_id' => $customerid
        ));
        return $this->db->affected_rows();
    }

	//修改单条购物车的内容
	public function updateCart($id,$customerid,$data)
	{
        $this->db->set($data);
        $this->db->where(array(
            'id' => $id,
            'customer_id' => $customerid
        ));
        $this->db->update('cart');
        return $this->db->affected_rows();
    }

	/**
	 * APP版本登录整合购物车
	 * @param unknown $customer_id
	 * @param unknown $cachecart
	 */
	function reinitforapp($customer_id,$cachecart)
	{
	    // 搜出数据库中的购物车商品
        $query = $this->db->get_where('cart', array(
            'customer_id' => $customer_id
        ));
        $carts = $query->result_array();

        // APP传递商品列表商品ID数组
        $_productid_arr = "";
        foreach ($cachecart as $key => $c) {
            $_productid_arr .= (",".$c["product_id"]);
        }
        $productid_arr = explode(",", $_productid_arr);

        // 根据ID数组查询APP传递商品列表详情
	    $this->db->select('p.id,p.is_freight, p.default_item, p.default_freight,p.add_item,p.add_freight');
	    $this->db->from('product p');
	    $this->db->where_in('id',$productid_arr);
        $query = $this->db->get();
		$_productInfo = $query->result_array ();
		$productInfo = array();
        foreach ($_productInfo as $k => $v){
            $productInfo[$v['id']] = $v;
        }
        // 将获取到的数据用product_id定义便于使用
        $uploadlist = array();
        foreach ($cachecart as $key => $c) {
            $cachecart[$key]["customer_id"] = $customer_id;
        }
        
        // 整合数据库，发现重复则修改数据
        foreach ($carts as $cart) {
            // 如果发现重复，则数量相加
            foreach ($cachecart as $key => $cc) {
                if ($cc["product_id"] == $cart["product_id"] && $cc["sku_id"] == $cart["sku_id"]) {
                    $quantity = (int) ($cachecart[$key]["quantity"]) + (int) $cart['quantity'];
                    $data = array(
                        'quantity' => $quantity,
                        'price' => $cart['price'],
//                         'freight' => $this->freight_count($productInfo[$cart["product_id"]], $quantity)//运费暂时注释
                        'freight'=>0
                    );
                    $this->db->set($data);
                    $this->db->where(array(
                        'id' => $cart["id"],
                        'customer_id' => $customer_id
                    ));
                    $this->db->update("cart");
                }
            }
        }

        // 整合数据库，发现不重复则直接插入数据
        $insertList = array();
        foreach ($cachecart as $key => $cc) {
            // 如果发现重复，则数量相加
            $flag = false;
            foreach ($carts as $cart) {
                if ($cc["product_id"] == $cart["product_id"] && $cc["sku_id"] == $cart["sku_id"]) {
                    $flag = true;
                    break;
                }
            }
            
            if (! $flag) {
                $data = array(
                    'customer_id' => $customer_id,
                    'product_id' => $cc['product_id'],
                    'quantity' => $cc['quantity'],
                    'price' => $cc['price'],
                    'product_name' => $cc['product_name'],
                    'sku_id' => $cc['sku_id'],
                    'img_goods' => $cc['img_goods'],
//                     'freight' => $this->freight_count($productInfo[$cc["product_id"]], $cc['quantity'])//运费暂时注释
                    'freight'=>0
                );
                array_push($insertList, $data);
            }
        }
        if (count($insertList) > 0) {
            $this->db->insert_batch('cart', $insertList);
        }
    }


	public function deleteCartByOrder($customerid,$orderid)
	{
		$this->db->where("concat(product_id,'_',sku_id) in(select concat(product_id,'_',sku_id) from ".$this->db->dbprefix('order_item')." where  order_id = ".$orderid.")");
		$this->db->where("customer_id",$customerid);
		$this->db->delete( 'cart');
		return $this->db->affected_rows();
		
	}
	
	public function load($customer_id,$product_id,$sku_id){
	    if($customer_id == 0 || $product_id == 0){
	        return NULL;
	    }
	    $this->db->where('customer_id',$customer_id);
	    $this->db->where('product_id',$product_id);
	    $this->db->where('sku_id',$sku_id);
	    $query = $this->db->get('cart');
	    if ($row = $query->row_array()){
	        return $row;
	    }
	    return NULL;
	    
	}
	
	public function load_result($str_id,$customer_id){ 
// 	    echo $str_id;exit;
	    $query = $this->db->query("select * from 9thleaf_cart where id in ($str_id) ");
	    return $query->result_array();
	}
	
	//计算运费
	//$product 商品信息
	//$qty 数量
	function freight_count($product,$qty){
	    
	    $freight = 0; //运费
	    
	    //计算运费
	    if(isset($product['is_freight']) && $product['is_freight'] == 1){
	        $default_freight =  isset($product['default_freight'])? $product['default_freight']:10;//默认价格 10
	        $default_item =  isset($product['default_item'])? $product['default_item']:1;//默认数量是多少 1
	        $add_item  =  isset($product['add_item'])?$product['add_item']:3;//每增加多少件 3
	        $add_freight =  isset($product['add_freight'])? $product['add_freight']:10;//每增加X件+多少钱 10
	         
	        if($qty > $default_item ){
	            $num = $qty - $default_item;
	            $num_a = $num/$add_item;
	            if(is_int($num_a) ){ //如果是整型
	                $freight = ($num_a*$add_freight)+$default_freight;
	            }else{
	
	                if($num_a < 1){
	                    $freight = $default_freight+$add_freight;
	                }else{
	                    $num_a = intval($num_a);
	                    $freight = ($num_a*$add_freight) + $add_freight+$default_freight;
	                }
	            }
	        }else{
	            $freight = $default_freight;
	        }
	    }
	   return  $freight;
	   
	}
	
}