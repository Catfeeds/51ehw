<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class cart extends Front_Controller {
	
	/**
	 */
	public function __construct() {
		parent::__construct ();
		$this->load->library ( 'cart' );
	}
	
	// --------------------------------------------------------------
	
	/**
	 * 购物车
	 */
	public function index()
	{        
        $data['total_price'] = round($this->cart->total(), 2);
        
        $pid = $this->input->get('pid', 0);
        $count = $this->input->get('count', 0);
        
        $data['title'] = '购物车';
        $data['head_set'] = 2;
        $data['foot_icon'] = 4;
        // 顾客信息
        $this->load->model('customer_mdl');
        $data['customer'] = $this->customer_mdl->load($this->session->userdata('user_id'));
        
        // 收货地址
        $this->load->model('customer_address_mdl');
        $data['address'] = $this->customer_address_mdl->load_all($this->session->userdata('user_id'));
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('cart', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
	
	
	// --------------------------------------------------------------
	
	/**
	 *
	 * @param number $pid        	
	 * @param number $count        	
	 */
	public function add($pid = 0, $count = 1, $sku_id = 0) {
        $status = $this->add_goods($pid, $count, $sku_id);
        switch ($status) {
            case 'ok':
                redirect('cart');
                exit();
                break;
            case 'no_goods':
                echo "<script>alert('商品已下架。');location.href='".site_url()."';</script>";
//                 redirect();
                exit();
                break;
            case 'fail':
                echo "<script>alert('添加失败');history.back(-1)</script>";
                exit();
                break;
            default:
                echo "<script>alert('网络出错');location.href='".site_url()."';</script>";
//                 redirect();
                exit();
                break;
        }
    }
	
	// --------------------------------------------------------------
	
	/**
	 * 更新购物车商品数量
	 */
	function update() {
        $segments = $this->uri->uri_to_assoc();
        $rowid = $segments['rowid'];
        $qty = $segments['qty'];
        $cid = $segments['id'];
        $this->load->model('goods_mdl');
        $product_id = substr($segments['p_id'],0,strpos($segments['p_id'],'_') );
        $product = $this->goods_mdl->get_by_id($product_id);
        $freight = 0; //运费
        //计算运费
        
        if($product['is_freight'] == 1){
            
            $default_freight =  $product['default_freight'];//默认价格 10
            $default_item =  $product['default_item'];//默认数量是多少 1
            $add_item  =  $product['add_item'];//每增加多少件 3
            $add_freight =  $product['add_freight'];//每增加X件+多少钱 10
        
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
        
        $customer_id = $this->session->userdata('user_id');
        if (isset($customer_id) ? $customer_id : 0 !== 0) {
            $cart = array(
                'quantity' => $qty,
                'freight' => $freight
            );
            $this->load->model("cart_mdl");
            if ($qty != 0) {
                $this->cart_mdl->updateCart($cid, $customer_id, $cart);
            } else {
                $this->cart_mdl->deleteCart($cid, $customer_id);
            }
        }
        
       
        $data = array(
            'rowid' => $rowid,
            'qty' => $qty
        );
        
        $this->cart->update($data);
        
        
        //更新session购物车价格，数量
        if($qty > 0){
            $cart = $this->session->userdata('cart_contents');
            $cart["$rowid"]['freight'] = $freight;
            
            $this->session->set_userdata('cart_contents',$cart);
        }
       
//         echo '<pre>';
//         var_dump($freight);
//         exit;
        $result['freight'] = $freight;
        $result['total'] = round($this->cart->total(), 2);
        echo json_encode($result);
    }
	
	// --------------------------------------------------------------
	
	/**
	 * 清空购物车
	 */
	function destroy() {
		$this->cart->destroy ();
	}
	
	// --------------------------------------------------------------
	
	/**
	 * 异步加入购物车
	 */
	public function ajax_add() {
		$pid = $this->input->post ( 'pid' );
		$qty = $this->input->post ( 'qty' );
		$sku_id = $this->input->post ( 'sku_id' );
		$status = $this->add_goods($pid,$qty,$sku_id);
		
		//获取购物车数量
		$cartcount = 0;
// 		foreach($this->cart->contents() as $items){
// 		    $cartcount = $cartcount + $items['qty'];
// 		}

        $data = array('status'=>$status,'cartcount'=>$cartcount);
        echo json_encode($data);
		
	}
	
	// --------------------------------------------------------------
	
	/**
	 * 加入购物车 和 立即购买公用方法
	 */
	public function add_goods($pid,$qty,$sku_id)
	{
        $this->load->model('goods_mdl');
        $product = $this->goods_mdl->get_by_id($pid); // 商品信息
        if (empty($product)) {
            return 'no_goods';
            exit();
        }
       
        $corporation_id = $product['corporation_id']; // 商品所属店铺ID

        //计算运费
        $freight = $this->freight_count($product,$qty,true);
        
        // 商品没有店铺的处理
        if ($corporation_id == 0 || $corporation_id == "" || $corporation_id == null) {
            return 'add_fail';
            exit();
        }
        
        $this->load->model('corporation_mdl');
        $corporate = $this->corporation_mdl->load_id($corporation_id); // 查询店铺信息
        $corporate_name = $corporate['corporation_name']; // 店铺名称

        
        $customer_id = $this->session->userdata('user_id');
        if ($sku_id != null && $sku_id != 0) {
            $this->load->model('product_sku_mdl');
            $sku = $this->product_sku_mdl->getSKUByValID($sku_id);
            $sku_val = $this->product_sku_mdl->getSKUValue($sku_id);
            
            foreach ($sku as $key => $s) {
                
                $sku_val['sku_name'][$key] = $s['attr_name'] . "：" . $s['sku_name'];
            }
        }
        // 加入购物车出现代码bug测试
        if (isset($customer_id) ? $customer_id : 0 !== 0) {
            $this->load->model('cart_mdl');
            
            $condition['cart'] = $this->cart_mdl->load($customer_id, $pid, $sku_id);
            
            // 购物车有就更新数量，没有就添加数据库
            if (isset($condition['cart']['id'])) {
                $freight = $this->freight_count($product,$condition['cart']['quantity'] + $qty,true);//重新计算运费
                // 如果是特价执行
                if ($product['special_price_start_at'] <= date("Y-m-d H:i:s") && $product['special_price_end_at'] >= date("Y-m-d H:i:s")) {
                    $cart = array(
                        'id' => $condition['cart']['id'],
                        'quantity' => $condition['cart']['quantity'] + $qty,
                        'price' => $product['special_price'],
                        'freight'=>  $freight 
                    );
                } else { // 不是特价执行
                    $cart = array(
                        'id' => $condition['cart']['id'],
                        'quantity' => $condition['cart']['quantity'] + $qty,
                        'price' => $product['vip_price'],
                        'freight'=>  $freight
                    );
                }
                $this->cart_mdl->updateCart($condition['cart']['id'], $customer_id, $cart);
//                 echo $this->db->last_query();
                $res = $condition['cart']['id'];
            } else {
                $cart = array(
                    'customer_id' => $customer_id,
                    'product_id' => $product['id'],
                    'quantity' => $qty,
                    'product_name' => $product['name'],
                    'sku_id' => $sku_id,
                    'img_goods' => $product['goods_thumb'],
                    'freight'=> $freight
                );
                if (isset($sku) && $sku != null && $sku_id != 0) {
                    if ($product['special_price_start_at'] <= date("Y-m-d H:i:s") && $product['special_price_end_at'] >= date("Y-m-d H:i:s")) {
                        $cart["price"] = $sku_val['special_offer'];
                    } else {
                        $cart["price"] = $sku_val['m_price'];
                    }
                } else {
                    // 如果特价执行
                    if ($product['special_price_start_at'] <= date("Y-m-d H:i:s") && $product['special_price_end_at'] >= date("Y-m-d H:i:s")) {
                        $cart["price"] = $product['special_price'];
                    } else { // 不是特价执行
                        $cart["price"] = $product['vip_price'];
                    }
                }
                $res = $this->cart_mdl->add($cart);
            }
        }else{ 
            
             $cart_list = $this->cart->contents();
                if (isset($cart_list) ) {
                    
                    foreach ($cart_list as $key => $v) {
                        if ($v['product_id'] == $product['id']) {
                            $freight = $this->freight_count($product,$v['qty'] + $qty,true);//重新计算运费
                        }
                   
                }
                
            }
            
        }
        
        // 针对特价商品，遍历判定商品是否特价，是则删除,实时更新
        $last_qty = 0;
        $_cart_list = $this->cart->contents();
        foreach ($_cart_list as $key => $v) {
            if ($v['id'] == $product['id'] . '_' . $sku_id) {
                $data = array(
                    'rowid' => $v['rowid'],
                    'id' => $v['id'],
                    'qty' => 0
                );
                $last_qty = $v['qty'];
                $this->cart->update($data);
            }
        }
       
        // ci加入购物车类
        $data = array(
            'corporation_id' => $corporation_id,
            'corporation_name' => $corporate_name,
            'id' => $product['id'] . '_' . $sku_id,
            'product_id'=> $product['id'],
            'qty' => $qty + $last_qty,
            'price' => '',
            'name' => $product['name'],
            'sku_id' => $sku_id,
            'options' => array(
                'goods_img' => $product['file'],
                'special_price_start_at' => $product['special_price_start_at'],
                'special_price_end_at' => $product['special_price_end_at']
            ),
            'freight'=> $freight
        );
        
        if (isset($customer_id) ? $customer_id : 0 !== 0)
            $data['cid'] = $res;
        else
            $data['cid'] = '';
        if (isset($sku) && $sku != null) {
            if ($product['special_price_start_at'] <= date("Y-m-d H:i:s") && $product['special_price_end_at'] >= date("Y-m-d H:i:s")) {
                $data["price"] = $sku_val['special_offer'];
                $data['is_special_price'] = true;
            } else {
                $data["price"] = $sku_val['m_price'];
            }
            $data["sku_name"] = $sku_val['sku_name'];
            $data['stock'] = $sku_val['stock'];
        } else {
            // 如果特价执行
            if ($product['special_price_start_at'] <= date("Y-m-d H:i:s") && $product['special_price_end_at'] >= date("Y-m-d H:i:s")) {
                $data["price"] = $product['special_price'];
                $data['is_special_price'] = true;
            } else { // 不是特价执行
                $data["price"] = $product['vip_price'];
            }
            $data['stock'] = $product['stock'];
        }
        $this->cart->insert($data);
        return 'ok';
    }
	
	// --------------------------------------------------------------
	
	/**
	 * 异步显示购物车
	 */
	public function ajax_showcart() {
		$this->load->view ( 'ajax_cart' );
	}
	
	// --------------------------------------------------------------
	
	/**
	 */
	public function ajax_delete() {
        $id = $this->uri->uri_to_assoc();
        $customer_id = $this->session->userdata('user_id');
        
        $this->load->model('cart_mdl');
        $res = $this->cart_mdl->deleteCart($id['cid'], $customer_id);
        echo $res;
    }
	
	// --------------------------------------------------------------
	
	/**
	 * 获取购物车商品总数
	 */
	public function ajax_countcart() {
        $cartcount = 0;
        foreach ($this->cart->contents() as $items) {
            $cartcount = $cartcount + $items['qty'];
        }
        echo $cartcount;
    }
	
	// -------------------------------------------------------------
	
	
	/**
	 * 查询商品库存
	 */
	public function check_stock($status=''){
        $msg = array(
            "stock" => null
        );
        if ($status == 1) {
            $this->load->model("product_mdl");
            $product = $this->product_mdl->load($this->input->get_post("val_id"), $this->session->userdata("app_info")["id"]);
            if ($product != null)
                $msg = array(
                    "stock" => $product['stock']
                );
        } elseif ($status == 2) {
            $this->load->model("product_sku_mdl");
            $sku = $this->product_sku_mdl->getSKUValue($this->input->get_post("val_id"));
            if ($sku != null)
                $msg = array(
                    "stock" => $sku["stock"]
                );
        }
        echo json_encode($msg);
    }
	
	
	/**
	 * 批量删除购物车
	 */
	function deleteSelect(){
        $cid = $this->input->post('cid');
        $rowid = $this->input->post('rowid');
        $qty = 0;
        
        $customer_id = $this->session->userdata('user_id');
        
        // 删除购物车（数据库）
        if (isset($customer_id) ? $customer_id : 0 !== 0 && $cid[0]) {
            $this->load->model("cart_mdl");
            foreach ($cid as $v) {
                $cart = array(
                    'quantity' => $qty
                );
                
                $this->cart_mdl->deleteCart($v, $customer_id);
            }
        }
        
        // 删除购物车（session）
        foreach ($rowid as $v) {
            $data = array(
                'rowid' => $v,
                'qty' => $qty
            );
            $this->cart->update($data);
        }
    }
    
    //计算运费 
    //$product 商品信息
    //$qty 数量
    function freight_count($product,$qty,$status=null){
         
        $freight = 0; //运费
        if(!$status){
            $this->load->model('goods_mdl');
            $product = $this->goods_mdl->get_by_id($product);
        }
        //计算运费
        if($product['is_freight'] == 1){
            $default_freight =  $product['default_freight'];//默认价格 10
            $default_item =  $product['default_item'];//默认数量是多少 1
            $add_item  =  $product['add_item'];//每增加多少件 3
            $add_freight =  $product['add_freight'];//每增加X件+多少钱 10
             
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
        
        if($status){
            return  $freight;
        }else{ 
            echo $freight;
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */