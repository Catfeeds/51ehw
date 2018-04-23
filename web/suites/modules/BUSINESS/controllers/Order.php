<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

include_once 'Common/Uri.php';
class Order extends Front_Controller {
    
    var $order_ration;
	/**
	 * 构造函数
	 */
	public function __construct() {
        /**
         * 构造函数
         */
        parent::__construct();
        $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        if(!$is_ajax){
            if (strstr($_SERVER['REQUEST_URI'], "item")) {
                
                $url = "/order" . strstr($_SERVER['REQUEST_URI'], "?");
                $this->session->set_userdata("redirect", site_url($url)); // 废除待删除
                $this->session->set_userdata("ref_from_url", site_url($url)); // 统一约定使用ref_from_url参数名，不使用关键词redirect
            } else if(strstr($_SERVER['REQUEST_URI'], "order") ){
                
                $this->session->set_userdata('ref_from_url', site_url('cart'));
            }else{ 
                $this->session->set_userdata('ref_from_url', current_url());
            }
            
            // 判断用户是否登录
            if (!$this->input->post('is_api') && ! $this->session->userdata('user_in')  ) {
                redirect('customer/login');
                exit();
            }  
        }
        
        // 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && ! $this->session->userdata("mobile_exist")) {
            $customer_id = $this->session->userdata('user_id');
            $this->load->model("customer_mdl");
            $customer = $this->customer_mdl->load($customer_id);
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
        
        $this->load->helper('order');
    }

	// -----------------------------------------------------------------------------
    
	/**
	 * 确认订单
	 */
	public function index() {
	    $data["item"] = $this->input->get_post("item");//订单商品
        if ($data["item"]) {
            
            $result = $this->order_confirm();//订单验证数据处理
            if($result["status"] == 1 || $result["status"] == 2){//商品不存在
                redirect('cart');
                return;
            }
            $customer_id = $this->session->userdata("user_id");//用户id
            
            $this->load->model('customer_address_mdl');
            $address = $this->customer_address_mdl->load_all($customer_id);//查询我的收货地址
            
            $data['free_shipping_status'] = 0;
            $data['price_floor'] = 0;
            if(isset($result['corp_id']) && $result['corp_id']){
                //判断订单是否满足包邮
                $this->load->model('Corporation_freight_mdl');
                $free_shipping = $this->Corporation_freight_mdl->load($result['corp_id']);
                if( $free_shipping  )
                {
                    //免邮费
                    $data['free_shipping_status'] = 1;
                    $data['price_floor'] = $free_shipping['price_floor'];
                }
            }
            
            if(!empty($result['package'])){
                $data['package'] = $result['package'];
            }else{
                $data['package'] = array();
            }
           
            $data['address'] = $address;//收货地址
            $data['commission'] = $result["commission"];//现金手续费
            $data['freight'] = $result["freight"];//运费
            $data['rebate'] = isset($result["rebate"]) ? $result["rebate"]:0;//比率
            $data['total_product_price'] = $result["total_product_price"];//产品总价
            $data["itemarray"] = $result["itemarray"];//订单数据集合
            
            $data['title'] = "确认订单";
            $data['head_set'] = 2;
           
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            // H5弹窗
            if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
                $data['bullet_set'] = '0';
                $this->load->view('widget/bullet', $data);
            }
            $this->load->view('order', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        } else {
            redirect('cart');
        }
    }

// -----------------------------------------------------------------------------

    

/**
 * 订单验证数据处理
 */
private function order_confirm()
{
    $data["item"] = $this->input->get_post("item");//订单商品
    $customer_id = $this->session->userdata('user_id');//用户id
    $package_id = $this->input->get_post ('package_id');//卡包id-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    $time = date("Y-m-d H:i:s"); 
    
    $this->load->helpers("product");//商品辅助函数
    
    $this->load->model('goods_mdl');
    $this->load->model("cart_mdl");
    $this->load->model("Customer_corporation_mdl");
    $this->load->model("card_package_mdl");
    $this->load->model('Corporation_freight_mdl');
     
    $total_product_price = 0;//产品总价（不包含运费手续费）
    //循环筛选出要购买的商品
    $product_array = array();//要购买的商品
    $sku_string = null;//要购买的商品sukid
    $cart = array();//购物车信息
    foreach ($this->cart->contents() as $items) {
        foreach ($data["item"] as $i) {
            if ($items["rowid"] == $i) {
                list($product_id,$sku_id) = explode("_",$items["id"]);
                $product_array[] = $product_id;
                $sku_string .= $sku_id.",";
                $cart[$items['id']] = $items;
            }
        }
    }
    

    if(!$product_array || !$sku_string){//非法操作
        $return = array(
            'status' => '1',
            'errorMessage' => "非法数据"
        );
        return $return;
    }

    $sku_string = trim($sku_string,",");//要购买的商品sukid
    
    $product_info = $this->goods_mdl->load_goods_sku($product_array,$sku_string);//查询商品
    //判断是否有商品
    if($product_info){
        
        $order_corpid = $product_info[0]['corporation_id'];//订单所属企业id
        //实时更新购物车信息
        $array = array();//记录商品最新信息
        $goods_price = array();//商品总价格 (array[0]=array("product_id"=>"11","price_total"=>"2000"))
        $array["status"] = 1;//默认状态：1正常
        $deduction_price = 0;//优惠总金额：默认0
        $itemarray = array();//订单数据集合
        $goods_qty = array();//每种商品的购买数量（运费用） (array[0]=array("product_id"=>"11","qty"=>"2000"))
        $pids = array();//记录需要运费的商品id
        foreach ($product_info as $v){
            
            //数据库查询的数据
            $product_id = $v["id"];//商品id
            
            //购物车商品数据
            $items = $product_id.'_'.($v["sku_id"]?$v["sku_id"]:"0");
            $goods_cart = $cart[$items];

            $is_tribeVIP = $this->check_tribe($product_id);//查询是否部落商品
            
            //判断是否sku商品
            if($v["sku_id"] > 0){
                $special_price = $v["special_offer"];//特价
                $vip_price = $v["sku_m_price"];//易货价
                $tribe_price = $v["sku_tribe_price"];//部落价
                $stock = $v["sku_stock"];//库存
            }else{
                $special_price = $v["special_price"];//特价
                $vip_price = $v["vip_price"];//易货价
                $tribe_price = $v['tribe_price'];//部落价
                $stock = $v["stock"];//库存
            }


            //判断库存
            if($stock < 1){
                $array["status"] = "2";//状态：0无效1正常2已售罄3商品数量超过库存
            }else if($stock < $goods_cart["qty"]){
                $array["status"] = "3";//状态：0无效1正常2已售罄3商品数量超过库存
            }
            
            
            //判断商品是否上架 || 是否删除
            if($v["is_on_sale"] != 1 || $v["is_delete"] != 0 ){
                $array["status"] = "0"; //状态：0无效1正常2已售罄3商品数量超过库存
            }
            
            //判断是否特价
            if($v["is_special_price"] == 1 && $v["special_price_start_at"] <= $time && $v["special_price_end_at"] >=  $time){
                $array["price"] = $special_price;//更新单价
            }else if($is_tribeVIP){//部落商品
                $array["price"] = $tribe_price;//更新部落价
            }else {
                $array["price"] = $vip_price;//更新单价
            }
            
            $array["stock"] = $stock;//更新库存
            $array["rowid"] = $goods_cart["rowid"];

            $price_total = $array["price"]*$goods_cart["qty"];//商品小计
            $this->cart->update($array);//更新购物车session

            //判断此商品是否生效
            if($array["status"] == 1){//生效
                $productids[] = $product_id;//记录生效的商品
                $goods_price[] = array("product_id"=>$product_id,"price_total"=>$price_total);//记录每个商品的总价（优惠券用）
                $total_product_price += $price_total;//产品总价（不包含运费手续费）

                //判断是否自付运费产品
                if($v["is_freight"] == 1){
                    //判断是否重复记录商品id，如果重复记录则叠加商品购买的数量
                    if(!in_array($product_id,$pids)){
                        $pids[] = $product_id;//记录需要运费的商品id
                        $goods_qty[$product_id] = array("product"=>$v,"qty"=>$goods_cart["qty"]);//每种商品的购买数量（运费用）
                    }else{
                        $goods_qty[$product_id]["qty"] += $goods_cart["qty"];//sku商品叠加购买数量（运费用）
                    }
                }
                $zong = 0;
                //判断是否使用优惠卷
                if($package_id){
                    $package_info = $this->card_package_mdl->goods_coupons($product_id,$customer_id,$package_id);//卡包信息
                    //判断此商品是否有权使用此优惠卷
                    if($package_info){
                        switch ($package_info[0]['discount_type']){
                            case 1://折扣运算
                                $deduction_price += ($array["price"]*$goods_cart["qty"]-($array["price"]*$goods_cart["qty"]*$package_info[0]['discount']/10));//优惠金额
                                break;
                            case 2://满减运算
                                $zong += $array["price"]*$goods_cart["qty"];//总额
                                if($zong >= $package_info[0]["overtop_price"]){//判断是否买满
                                    $deduction_price = $package_info[0]["deduction_price"];//优惠金额
                                }
                                break;
                        }
                        //优惠券截取小数点后两位
                        $deduction_price = strpos($deduction_price,'.') ? substr_replace($deduction_price, '', strpos($deduction_price, '.') + 3) : $deduction_price;
                    }
                }
                

                //订单数据集合
                $itemarray[] = array(
                    "product_id" => $product_id,//商品id
                    "product_name" => $v['name'],//商品名称
                    "qty" => $goods_cart["qty"],//购买数量
                    "price" => $array["price"],//商品单价
                    "sku_id" => ($goods_cart['sku_id']?$goods_cart['sku_id']:0),//skuid
                    "rowid" => $goods_cart["rowid"],//购物车rowid
                    "corporation_id" => $goods_cart['corporation_id'],//店铺id
                    "sku_value" => (!empty($goods_cart['sku']) ? $goods_cart['sku']:null),//sku信息
                    "source" => ($is_tribeVIP?1:0),//来源
                    "corporation_name" => $goods_cart["corporation_name"],//企业名称
                    "subtotal" => $goods_cart["subtotal"],//商品小计
                    "goods_thumb" => $goods_cart["options"]["goods_img"]//商品图片
                );



            }else{
                //删除订单商品
                if(($key = array_search($goods_cart["rowid"],$data["item"]))){
                    unset($data["item"][$key]);
                }
                if($array["status"] == 0){
                    $return["Invalid"] = true;//失效识别
                }else if($array["status"] == 2 || $array["status"] == 3){
                    $return["stock"] = true;//库存不足识别
                }
            }
        }
    }else{
        $return = array(
            'status' => '1',
            'errorMessage' => "商品不存在"
        );
        return $return;
    }

    //筛选完成，判断是否有商品符合下单要求
    if(!empty($productids)){
        $return['package'] = $this->coupons($productids,$goods_price);//可用优惠券
    }else{
        $return["status"] = "2";
        $return["errorMessage"] = "全部商品失效或者库存不足";
        return $return;
    }



    //判断订单是否满足包邮
    $freight = 0;//默认免邮费
    $total = $total_product_price - $deduction_price;//产品总价-优惠价
    $free_shipping = $this->Corporation_freight_mdl->load($order_corpid);
    if( $free_shipping && $total >= $free_shipping['price_floor'] ){
        $freight = 0;//免邮费
    }else{
        //如果存在自付运费商品，则计算运费
        if(!empty($goods_qty)){
            foreach ($goods_qty as $k=>$v){
                $freight += freight_count($v["product"],$v["qty"]);
            }
        }
    }
    
    //如果是企业买家才算手续费--
    $commission = 0;//默认手续费
    $corp_detaile = $this->Customer_corporation_mdl->load( $customer_id );
    if( !empty($corp_detaile) && !empty( $corp_detaile['commission_rate'] ) && $corp_detaile['approval_status'] == 2){
        $total = $total_product_price + $freight - $deduction_price;//产品总价+运费-优惠价
        $commission = $this->commission($corp_detaile['commission_rate'],$total);//计算企业手续费
        
        $return["rebate"] = $corp_detaile['commission_rate']/100;//比率
        $return["corp_id"] = $corp_detaile['id'];//企业ID
    }

    //返回数据
    $return["status"] = 3;//成功状态码
    $return["deduction_price"] = $deduction_price;//优惠金额
    $return["order_corpid"] = $order_corpid;//订单所属企业id
    $return["total_price"] = $total_product_price + $freight - $deduction_price;//订单需付款金额(产品总价+运费-优惠价)
    $return["total_product_price"] = $total_product_price;//产品总价（不包含运费手续费）
    $return["freight"] = $freight;//运费
    $return["commission"] = $commission;//手续费
    $return["itemarray"] = $itemarray;//订单数据集合
   
  
    return $return;
}

// ---------------------------------------------------------------------

    
    
    /**
     * 去除二维数组重复
     * @param unknown $array2D
     * @param string $stkeep
     * @param string $ndformat
     * @return unknown
     */
    function unique_arr($array2D,$stkeep=false,$ndformat=true)
    {
        // 判断是否保留一级数组键 (一级数组键可以为非数字)
        if($stkeep) $stArr = array_keys($array2D);
    
        // 判断是否保留二级数组键 (所有二级数组键必须相同)
        if($ndformat) $ndArr = array_keys(end($array2D));
    
        //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
        foreach ($array2D as $v){
            $v = join(",",$v);
            $temp[] = $v;
        }
    
        //去掉重复的字符串,也就是重复的一维数组
        $temp = array_unique($temp);
    
        //再将拆开的数组重新组装
        foreach ($temp as $k => $v)
        {
            if($stkeep) $k = $stArr[$k];
            if($ndformat)
            {
                $tempArr = explode(",",$v);
                foreach($tempArr as $ndkey => $ndval) $output[$k][$ndArr[$ndkey]] = $ndval;
            }
            else $output[$k] = explode(",",$v);
        }
    
        return $output;
    }
    
    // ---------------------------------------------------------------------------
    
    /**
     * 检查是否我的部落
     * @param int $pid 商品id
     */
    private function check_tribe($pid){
        $this->load->model("tribe_mdl");
        
        $customer_id = $this->session->userdata("user_id");     
        //判断是否部落商品
        $is_tribeVIP = false; //默认不是
        $MyTribe = $this->tribe_mdl->MyTribe($customer_id);//查询我的部落
        if($MyTribe){
            $MyTribe_id = array_column($MyTribe,"id");
            $data['details'] = $this->tribe_mdl->Whether_my_tribe($pid,$MyTribe_id);//查询商品是否属于我的部落
            if($data['details']){
                $is_tribeVIP = true;//会员
            }
        }
        return $is_tribeVIP;

    }
    
    // ---------------------------------------------------------------------------
    
    /**
     * 获取订单相关的优惠券
     * @param array $pid 商品id
     * @param array $goods_price 商品总价格 (array[0]=array("product_id"=>"11","price_total"=>"2000"))
     */
    private function coupons($pid,$goods_price){
        $customer_id = $this->session->userdata("user_id");//用户id
        //订单商品相关的优惠券
        $this->load->model('card_package_mdl');
        //查询订单可以使用的优惠券
        $package  = $this->card_package_mdl->goods_coupons($pid,$customer_id);
        if($package){
            //筛选出符合要求得优惠券
            $package_array = array();//记录筛选成功优惠券
            foreach ($package as $key=>$val){
                foreach ($goods_price as $k=>$v){
                    if($val['discount_type']==1){//折扣
                        unset($package[$key]['product_id']);
                        $package_array[] = $package[$key];
                    }else if($val['discount_type']==2 && $val['overtop_price'] <= $v["price_total"]){//满减
                        unset($package[$key]['product_id']);
                        $package_array[] = $package[$key];
                    }
                }
            }
            if($package_array){
                return $this->unique_arr($package_array);//优惠券信息
            }
        }
        return array();
    }

	// ---------------------------------------------------------------------------

	/**
	 * 联系人
	 */
	public function consignee() {
        $data = array();
        $data['head_set'] = 3;
        $this->load->view('head', $data);
        $this->load->view('_header');
        $this->load->view('order/consignee_edit', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }



	// ---------------------------------------------------------------------------

	/**
	 * 订单完成页面
	 */
    public function orderfinish() {
        $data["order_id"] = $this->input->get_post('new_order_id');
        $data["order_sn"] = $this->input->get_post('order_sn');
        $status = $this->input->get_post('status');
        if (isset($data["order_id"]) && $data["order_id"] != null) {
            $data["errorcode"] = 1;
            if ($status == 1) {
                $data["message"] = "您的订单已提交成功，请等待卖家确认，再进行付款";
            } else {
                $data["message"] = "您的订单已被卖家确认，请进行付款";
            }
            $data['status'] = $status;
            $data['order_finish'] = 1;
            $data['head_set'] = 2;
            $data['title'] = '订单递交成功';
            $data['back'] = 'member/order';
            
            $this->load->view('head', $data);
            $this->load->view('_header');
            $this->load->view('order/orderfinish', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        } else {
            redirect('order');
        }
    }
    
	// ---------------------------------------------------------------------------

	/**
	 * 订单支付页面
	 */
	public function order_pay($order_id = 0) {
		if (! $order_id) {
			redirect ( 'customer' );
		}

		$this->load->model ( 'order_mdl' );
		$user_id = $this->session->userdata ( 'user_id' );
		$order = $this->order_mdl->load ( $order_id );

		// 不是自己的订单
		if ($order ['customer_id'] != $user_id) {
			redirect ( 'customer' );
		}

		$this->load->model ( 'order_delivery_mdl' );
		$this->load->model ( 'region_mdl' );
		$order_delivery = $this->order_delivery_mdl->load ( $order_id );

		// print_r($order_delivery);
		// exit();

		$data ['order_sn'] = $order ['order_sn'];
		$data ['total_price'] = $order ['total_price'];
		$data ['order_id'] = $order ['id']; // $new_order_id;
		$data ['consignee'] = $order_delivery ['consignee'];
		$data ['contact_mobile'] = $order_delivery ['contact_mobile'];
		$data ['contact_phone'] = $order_delivery ['contact_phone'];
		$data ['invoice'] = $order['is_need_invoice'];

		$province = $this->region_mdl->get_name ( $order_delivery ['province_id'] );
		$city = $this->region_mdl->get_name ( $order_delivery ['city_id'] );
		$district = $this->region_mdl->get_name ( $order_delivery ['district_id'] );

		$data ['address'] = $province . '省' . $city . '市' . $district . ' ' . $order_delivery ['address'];

		/*if ($order ['payment_id'] == 2) {
			error_log ( "即将进入微信支付！" );
			// 微信支付
			if (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false) {
				error_log ( "微信客户端" );
				redirect ( 'wechatpay/js_api_call/pay/' . $order_id );
			} else {
				error_log ( "非微信客户端" );
				redirect ( 'wechatpay/native_dynamic_qrcode?orderid=' . $order_id );
			}
		} else {
			// 支付宝
		}*/
		$data ['title'] = '我的订单支付';
        $data['back'] = 'member/order';
        
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header' );
		$this->load->view ( 'order/pay', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}

	// ---------------------------------------------------------------------------


	// ---------------------------------------------------------------------------

	/**
	 * 订单再次支付
	 *
	 * @param unknown $orderid
	 */
	public function pay_again($orderid, $pay_type = 2) {
		if ($pay_type === 2) {
			// 微信支付
			if (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false) {
				redirect ( 'wechatpay/js_api_call/pay/' . $orderid );
			} else {
				redirect ( 'wechatpay/native_dynamic_qrcode?orderid=' . $orderid );
			}
		} else {
			// 支付宝
		}
	}


	// ---------------------------------------------------------------------------

	/**
	 *
	 * @param unknown $price
	 * @return unknown
	 */
	private function _convert_yuan_to_fen($price) {
		$intTmp = intval ( round ( $price * 100 ) );

		return $intTmp;
	}

	// ----------------------------------------------------------------

	/**
	 * 立即购买
	 */
	function buynow() {
	    
		$product_id = $this->input->post ( 'product_id' );
		$this->load->model ( 'goods_mdl' );
		$product = $this->goods_mdl->get_by_id ( $product_id );
		$item_num = $this->input->post ( 'item_num' );
		$this->load->model('product_sku_mdl');

		/* 插入新订单信息 */
		$this->load->model ( 'order_mdl' );
		$this->order_mdl->customer_id = $this->session->userdata ( 'user_id' );
		$this->order_mdl->payment_id = $this->input->post ( 'payment_id' ); // $payment_id;
		$this->order_mdl->shipping_id = 0; // $shipping_id;
		$this->order_mdl->total_product_price = $product ['price'];
		$this->order_mdl->auto_freight_fee = 0;
		$this->order_mdl->total_price = $product ['price'] * $item_num;

		$this->order_mdl->status = 1;

		$order_exist = false;
		do {
			$order_sn = get_order_sn ();
			if ($this->order_mdl->check_order_sn ( $order_sn )) {
				$order_exist = true;
			} else {
				$this->order_mdl->order_sn = $order_sn;
				$this->order_mdl->create ();
				$new_order_id = $this->db->insert_id ();
			}
		} while ( $order_exist ); // 如果是订单号重复则重新提交数据

		/* 插入订单商品 */
		$this->load->model ( 'order_item_mdl' );

		$this->order_item_mdl->order_id = $new_order_id;
		$this->order_item_mdl->product_id = $product ['id'];
		$this->order_item_mdl->product_name = $product ['name'];
		$this->order_item_mdl->quantity = $item_num;
		$this->order_item_mdl->price = $product ['price'];
		$this->order_item_mdl->weight = 0; // $items['options']['weight'];
		$this->order_item_mdl->create ();

		if ($this->input->post ( 'payment_id' ) == 2) {
			// 微信支付
			if (isMobile () || is_wechat ()) {
				redirect ( 'wechatpay/js_api_call/pay/' . $new_order_id );
			} else {
				redirect ( 'wechatpay/native_dynamic_qrcode?orderid=' . $new_order_id );
			}
		} else {
			// 支付宝
		}
	}

	// ------------------------------------------------------------------------------------
	/**
	 * 保存订单地址
	 */
	public function save_snap() {
		$address_id = $this->input->post ( "address_id" );
		$order_id = $this->input->post ( "order_id" );

		/* 插入收货人信息 */
		$this->load->model ( 'customer_address_mdl' );
		$address = $this->customer_address_mdl->load_by_id ( $address_id );

		$this->load->model ( 'order_delivery_mdl' );
		$this->order_delivery_mdl->order_id = $order_id;
		$this->order_delivery_mdl->consignee = $address ['consignee']; // isset ( $address ['consignee'] ) ? $address ['consignee'] : $this->session->userdata ( 'nick_name' );
		$this->order_delivery_mdl->address = $address ['address']; // isset ( $address ['address'] ) ? $address ['address'] : "";
		$this->order_delivery_mdl->province_id = $address ['province_id']; // isset ( $address ['province_id'] ) ? $address ['province_id'] : "";
		;
		$this->order_delivery_mdl->city_id = $address ['city_id']; // isset ( $address ['city_id'] ) ? $address ['city_id'] : "";
		;
		$this->order_delivery_mdl->district_id = $address ['district_id']; // isset ( $address ['district_id'] ) ? $address ['district_id'] : "";
		;
		$this->order_delivery_mdl->contact_phone = $address ['phone']; // isset ( $address ['phone'] ) ? $address ['phone'] : "";
		;
		$this->order_delivery_mdl->contact_mobile = $address ['mobile']; // isset ( $address ['mobile'] ) ? $address ['mobile'] : "";
		;
		$this->order_delivery_mdl->postcode = $address ['postcode']; // isset ( $address ['postcode'] ) ? $address ['postcode'] : "";
		;
		$this->order_delivery_mdl->create ();

		redirect ( "member/order/detail/" . $order_id );
	}

	// -----------------------------------------------------------------

	/**
	 * 确认订单并改为代发货
	 */
	public function update_confirm($order_sn) {
		// @TODO:需要添加用户验证订单
		$this->load->model ( 'order_mdl' );
		$this->order_mdl->order_confirm_address ( $order_sn );

		redirect ( "member/order/detail/" . $order_id );
	}

	// -----------------------------------------------------------------

	/**
	 * 余额支付
	 */
	public function pay_amount() {

		// @TODO:余额支付
		$user_id = $this->session->userdata ( 'user_id' );
		$this->load->model ( 'customer_mdl' );
		$customer = $this->customer_mdl->load ( $user_id );
		if ($customer ['safety_password'] == NULL) {
			?>
		<script type="text/javascript">
			alert("您还没设置安全密码，点击确认马上跳到安全密码设置！");
			location.href = "<?php echo site_url("security/unlock/set_gesture");?>";
		</script>
		<?php
		} else {
			// @TODO:跳到安全密码输入
			redirect(site_url("security/unlock/gesture"));
		}
	}

	// -----------------------------------------------------------------
	public function pay_commission() {
		// @TODO:财富值支付
	}

	/**
	 * 订单支付
	 */
	public function pay_order(){
	    $data['status'] = false;
	    $is_ok = false;
	    $order_id = $this->input->post('id');
	    $pay_passwd = $this->input->post('pass');
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $relation_id = $this->session->userdata ( 'pay_relation' );
	    
	    $this->load->model('order_mdl');
	    
	    //判断订单是否正确
	    $is_order = $this->order_mdl->is_customer_order($order_id,array(2),$customer_id);
	   
	    if( $is_order ){ //因为面对面支付，没有支付订单默认是取消状态
	       
	           
	        //获取该店主信息
	        $this->load->model('customer_corporation_mdl');
	        $corp_customer = $this->customer_corporation_mdl->corp_load($is_order['corporation_id']);
            $corp_customer_id = $corp_customer['customer_id'];//店主的用户ID
            
            
            //改状态
            $change_status = 4;
            
            if($is_order['total_price'] == 0){
                $this->db->trans_begin(); //事物执行方法中的MODEL。
                $up_status = $this->order_mdl->update_order_status($order_id, $change_status);
                if($up_status){
                    $this->db->trans_commit();
                    $data['status'] = 1;
                     
                }else{
                    $this->db->trans_rollback();
                     $data['status'] = 2;
                }
                echo json_encode($data);
                exit();
            }
            
            
            $this->db->trans_begin(); //事物执行方法中的MODEL。
            $process = true;//事物标志
            $up_status = $this->order_mdl->update_order_status($order_id, $change_status);
            
            //如果更新成功才调用
            if( $up_status ){ 
                $url = $this->url_prefix.'Order/pay_order';
                
                $data_post['relation_id'] = $relation_id;
                $data_post['pass'] = $pay_passwd;
                $data_post['corp_customer_id'] = $corp_customer_id;
                $data_post['total_price'] = $is_order['total_price'];
                $data_post['order_sn'] = $is_order['order_sn'];
                $data_post['app_id'] =  $is_order['app_id'];
                $data_post['commission'] = $is_order['commission'];
                
                $error  =  json_decode($this->curl_post_result( $url,$data_post ),true);
                
                $data['status'] =  $error['status'];
               
                if($data['status'] == 1){ 
                    $is_ok = true;
                    $this->db->trans_commit();
                    //支付成功,插入支付成功信息
                    $this->load->model('Customer_message_mdl',"Message");
                    
                    $link = $this->url_prefix.'Customer/load?';
                    $dta['customer_id'] = $customer_id;
                    $customer = json_decode($this->curl_post_result($link,$dta),true);
                    //模板
                    $Msg_info['template_id']= 6;
                    //标题
                    $Msg_info['name']= '支付订单成功';
                    $Msg_info['customer_id']= $customer_id;
                    $Msg_info['obj_id'] = $order_id;
                    $Msg_info['type'] = 2;
                    $Msg_info['parameter']['name'] = isset($customer['nick_name']) && !empty($customer['nick_name'])? $customer['nick_name']:$customer['name'];
                    $Msg_info['parameter']['number'] =$is_order['order_sn'];
                    $this->Message->Create_Message($Msg_info);
                }    
            }
            
	    }else{
	        //'错误订单'
	       $data['status'] = 2;
	    }

	    if( empty($is_ok) && !empty($process) )
	       $this->db->trans_rollback();
	    
	    echo json_encode($data);
	}
	
	// ---------------------------------------------------------------------------
	
	/**
	 * 订单支付成功回调页面
	 */
    public function payfinish() {
        
        $data["order_id"] = $this->input->get_post('new_order_id');
        

        $this->load->model ('order_mdl');
        $order_info = $this->order_mdl->is_customer_order( $data["order_id"],array(4,14),$this->session->userdata("user_id") );
        if(count($order_info)!=0){
            $data['pay_account'] = $order_info['total_price'];
            $data['order_sn'] = $order_info['order_sn'];
            $data['order_id'] = $order_info['id'];
        }else{
            redirect('notfound');
        }
        
        $data['head_set'] = 2;
        $data['title'] = '订单支付成功';
        
        $this->load->view('head', $data);
        $this->load->view('_header');
        $this->load->view('order/orderfinish', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
	
	// ----------------------------兴业银行活动-----------------------------------------------
	
    
   public  function ajax_insert_CIB(){
       $name = $this->input->get_post('name');
       $mobile = $this->input->get_post('mobile');
       if(empty($mobile) || empty($name)){
           $data = array(
               'Result' => false
           );
           
           echo json_encode($data); exit;
       }
       $this->load->model('order_mdl');
       $rows = $this->order_mdl->check_CIB();
       if($rows){
           $data = array(
               'Result' => '300'
           );
           echo json_encode($data);exit;
       }
     
       $id = $this->order_mdl->insert_CIB($name,$mobile);
   
       if($id){
           $data = array(
               'Result' => true
           );
       }else{
           $data = array(
               'Result' => false
           );
       }
       echo json_encode($data);
   }
   public function ajax_check_order(){
      $pro_id = $this->input->get_post('pro_id');
      $this->load->model('order_mdl');
      $order_id = $this->order_mdl->load_order_by_productId($pro_id);
    
      if($order_id){
          $data = array(
              'Result' => false
          );
      }else{
          $data = array(
              'Result' => true
          );
      }
      echo json_encode($data);
   } 
    
    //---------------------------------------------------------------------------
    
    
	/**
	 * 需要支付的订单信息
	 */
	public function order_message(){
	    $credit = 0;
	    
	    //获取账户资金信息
	    $relation_id = $this->session->userdata ('pay_relation');
	    
	    $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
	    $pay_info = json_decode($this->curl_get_result($url),true);
	    
	    if($pay_info && !empty($pay_info['pay_passwd']) ){
	    
    	    $order_id = $this->input->post('o_id');
    	    $this->load->model('order_mdl');
    	    $order_message = $this->order_mdl->order_message($order_id);
    	    
    	    $time = date('Y-m-d H:i:s');
    	   
            if($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time)
                $credit = $pay_info['credit'];
            
            //可用余额
            $my_M_price = $pay_info["M_credit"]+$credit;
            
            $order_message['pay_commission'] = empty($order_message['commission']) ? 0.00 :  $pay_info['cash'] >= $order_message['commission'] ? 0.00 : round($order_message['commission'] - $pay_info['cash'],2); //还需支付的手续费
            
            if( $my_M_price < $order_message['total_price'] )
            { 
                $order_message['pay_commission'] = $order_message['pay_commission'] + $order_message['total_price'] - $my_M_price ; 
            }
           
            if( $my_M_price < $order_message['total_price'] || $pay_info['cash']  < $order_message['commission']  )
            { //提货权不够支付订单 或者 现金不够支付手续费的时候
                $order_message['pay_status'] = 1; 
                $pay_order_M = round($my_M_price - $order_message['total_price'],2);
            }
            
            $order_message['my_M_price'] = $my_M_price;
            $order_message['my_cash'] = $pay_info['cash'];
            $order_message['commission'] = empty($order_message['commission']) ? $order_message['commission'] = 0.00 : $order_message['commission'];
            $order_message['pay_passwd_status'] = 1;
	    }else{ 
	        $order_message['pay_passwd_status'] = 0;
	    }
	    
	    echo json_encode($order_message);
	}

	/**
	 * 验证支付密码 并收货
	 */
	public function receive(){
	     
	    if( $this->input->post('is_api') )
	    { 
	        $pass = $this->input->post('pass');
	        $customer_id = $this->input->post ( 'user_id' );
	        $relation_id = $this->input->post ('pay_relation');
	        
	    }else{ 
	        $pass = md5( $this->input->post('pass') );
	        $customer_id = $this->session->userdata ( 'user_id' );
	        $relation_id = $this->session->userdata ('pay_relation');
	        
	    }
	    $status = false;
	    $order_id = $this->input->post('id');
	    
	    $this->load->model ('order_mdl');
	    $order = $this->order_mdl->is_customer_order($order_id, 6, $customer_id);
	    
        
	    //判断传过来的是否是该商家的订单ID并且是正确的状态
        if( $order ){
            $this->load->model('pay_account_mdl');
            $this->load->model('order_rebate_mdl');
            $this->load->model('customer_corporation_mdl');
            $this->load->model("customer_currency_log_mdl",'customer_currency_log');
            
            //接口-验证支付密码
            $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
            $pay_info = json_decode($this->curl_get_result($url),true);
            
            if( $pay_info['pay_passwd'] == $pass ){
                
                if($order['total_price'] == 0){
                    $this->db->trans_begin();
                    //执行收货-改状态
                    $row = $this->order_mdl->update_order_status($order_id, 9);
                    if($row){
                        $this->db->trans_commit(); //提交事物
                         $status = 1;
                    }else{
                        $this->db->trans_rollback(); //事物回滚
                        $status = 2;
                    }
                    echo json_encode($status);exit;
                }
                
                
                
                //获取该店信息
                $corp_customer = $this->customer_corporation_mdl->corp_load($order['corporation_id']);
                
                //店主的用户ID
                $corp_customer_id = $corp_customer['customer_id'];
                
                //执行分成function
                $this->db->trans_begin();
                $order_rebate = $this->order_rebate_mdl->order_rebate($order);
                
        	    //分成状态
        	    if( $order_rebate )
        	    { 
        	        //执行收货-改状态
        	        $row = $this->order_mdl->update_order_status($order_id, 9);
        	        
        	        if( $row )
        	        {
        	            //通过接口调用收货流程接口
    	                $url = $this->url_prefix.'Order/order_receive';
    	                $data_post['corp_customer_id'] = $corp_customer_id;
    	                $data_post['relation_id'] = $relation_id;
    	                $data_post['password'] = $pass;
    	                $data_post['order_sn'] = $order['order_sn'];
    	                $data_post['total_price'] = $order['total_price'];
    	                $data_post['app_id'] = $order['app_id'];
    	                $data_post['is_api'] = $this->input->post('is_api');
//     	                var_Dump($this->curl_post_result($url,$data_post));
    	                $B_error = json_decode($this->curl_post_result($url,$data_post),true);
    	        
    	                if( $B_error['status'] )
    	                {
    	                    $this->db->trans_commit(); //提交事物
    	                    $status = 1;
    	                }
        	        }
        	    }
        	    
            }else{ 
                $status = 3;
            }   
        }else{
            $status = 2; //订单错误
        }
         
        if(!$status)
            $this->db->trans_rollback(); //事物回滚
       
        echo json_encode($status);
	}

	/**
     * 用户修改订单备注使用
     */
	public function update_remark(){
	    $status = false;
	    $order_id = $this->input->post('id');
	    $remark   = $this->input->post('remark');
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $this->load->model('order_mdl');

	    //查询是否正确的订单和状态
	    $is_order = $this->order_mdl->is_customer_order( $order_id,1,$customer_id );

	    if($is_order){
	        //执行修改备注
	        $result = $this->order_mdl->update_remark( $order_id , $remark );

	        if( $result ){
	            $status = 1;//修改成功
	        }else{
	            $status = 3; // 未修改；
	        }

	    }else{
	        $status = 2;//商家已接单不能修改
	    }

	    echo json_encode($status);
	}

	/**
	 * 买家取消订单
	 */
	public function cancel_order(){
	    $this->load->model('order_mdl');
	    $this->load->model('order_item_mdl','order_item');
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $order_id = $this->input->post('id');
	    $status = array(1,2); //未确认
	    $up_status = 10; //修改取消订单的状态
	    $is_order = $this->order_mdl->is_customer_order( $order_id,$status,$customer_id );
	    $goods = $this->order_item->order_item_goods( $order_id );

	    if( $is_order){
	        //执行事务取消订单
	        $is_ok = $this->order_mdl->cancel_order( $order_id , $up_status, $goods);

	       //$row = $this->order_mdl->update_order_status($order_id, $up_status);
	    }
	    $result['is_ok'] = $is_ok;
	    $result['status'] = $up_status;
	    echo json_encode($result);
	}

	/**
	 * 验证用户是否设置了支付密码
	 */
	public function is_pay_passwd(){
	    $is_pay = false;
	    $relation_id = $this->session->userdata ('pay_relation');
	    //接口-验证支付密码
	    $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
	    $result = json_decode($this->curl_get_result($url),true);
	    
	    if( $result['pay_passwd'] != ''){
	        $is_pay = true;
	    }

	    echo $is_pay;
	}

	
	/**
	 * 店主执行订单分成使用  (B端废弃勿用)
	 * 保持事物，先处理本地数据再进行接口处理，所以会分成几小块方法，需要注意。
	
	public function carry_rebate( ){ 
	    $order_id = $this->input->post('order_id');
	    $pass = $this->input->post('pass');
	    $status = false;
	    $this->load->model('order_mdl');
	    $corporation_id = $this->session->userdata['corporation_id'];
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $relation_id = $this->session->userdata ('pay_relation');
	    $order = $this->order_mdl->is_corp_order($order_id,7,$corporation_id); //如果是未提取的状态才执行
	    
	    if($order){ 
	        
	        //接口-验证支付密码
	        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
	        $pay_info = json_decode($this->curl_get_result($url),true);
        
            if($pay_info['pay_passwd'] == md5($pass) ){ 
                
                $this->db->trans_begin(); //事物执行方法中的MODEL。
                
                $process = true; //事物进程
                //执行分成
                $this->load->model('customer_corporation_mdl');
                $order_rebate = $this->order_rebate( $order );
                
                if($order_rebate == 1)
                { 
                    
                    //执行-改状态
                    $row = $this->order_mdl->update_order_status($order_id, 9);
                    
                    if( $row ){ 
                        //通过接口调用写日志+提货权流程
                        $url = $this->url_prefix.'Order/carry_rebate';
                        $data_post['buy_customer_id'] = $order['customer_id'];
                        $data_post['customer_id'] = $customer_id;
                        $data_post['relation_id'] = $relation_id;
                        $data_post['password'] = $pass;
                        $data_post['order_sn'] = $order['order_sn'];
                        $data_post['total_price'] = $order['total_price'];
                        $data_post['app_id'] = $order['app_id'];
                        $A_error = json_decode($this->curl_post_result($url,$data_post),true);
                        
                        if( $A_error['status'] ){ 
                            
                            //通过接口处理扣除-写分成日志处理
                            $url = $this->url_prefix.'Order/order_rebate';
                            $data_post['retio_price'] = $this->order_ration;
                            $data_post['order_sn'] = $order['order_sn'];
                            $data_post['customer_id'] = $order['customer_id'];
                            $data_post['corp_customer_id'] = $this->session->userdata ( 'user_id' );
                            $data_post['app_id'] = $order['app_id'];
                            $B_error = json_decode($this->curl_post_result($url,$data_post),true);
                            
                            if( $B_error['status'] ){
                                $this->db->trans_commit(); //提交事物
                                $status = 1;//完成
                            }
                        }
                    }
                        
                }else if($order_rebate == 2)
                { 
                    $this->db->trans_commit(); //提交事物
                    echo json_encode(2);//钱还是不够分
                    return ;
                    
                }else if( $order_rebate == 3)
                { 
                    //执行-改状态
                    $row = $this->order_mdl->update_order_status($order_id, 9);
                    
                    if( $row ){
                        
                        //通过接口调用写日志+提货权流程
                        $url = $this->url_prefix.'Order/carry_rebate';
                        $data_post['buy_customer_id'] = $order['customer_id'];
                        $data_post['customer_id'] = $customer_id;
                        $data_post['relation_id'] = $relation_id;
                        $data_post['password'] = $pass;
                        $data_post['order_sn'] = $order['order_sn'];
                        $data_post['total_price'] = $order['total_price'];
                        $data_post['app_id'] = $order['app_id'];
                        $A_error = json_decode($this->curl_post_result($url,$data_post),true);
                        
                        if( $A_error['status'] ){
                            
                            $this->db->trans_commit(); //提交事物
                            $status = 1;//完成
                        }
                    }
                }
                
            }else{ 
                $status = 4;//密码错误
                
            }
        }else{ 
	        $status = 3;//订单错误
	    }
	    
	    if(!empty($process) && empty($status) )
	        $this->db->trans_rollback(); //事物回滚
	    
	    echo json_encode($status);
	}
	 
	 **/
	    
	/**
	 * 提取提货权订单的信息(B端废弃)
	 
	public function load_pay_order(){ 
	    $order_id = $this->input->post('order_id');
	    $this->load->model('order_mdl');
	    $this->load->model('rebate_mdl');
	    $this->load->model ( 'customer_corporation_mdl' );
	    $corporation_id = $this->session->userdata['corporation_id'];
// 	    $app_id = $this->session->userdata('app_info')['id'];
// 	    $customer_id = $this->session->userdata ( 'user_id' );
	    $relation_id = $this->session->userdata ('pay_relation');
	    $order = $this->order_mdl->is_corp_order($order_id,7,$corporation_id); //如果是未提取的状态才执行
        
        if($order){ 
	        //查询需要分成的百分比
// 	        $ratio = $this->rebate_mdl->load("'$app_id'");

	        //店主信息 //查询需要分成的百分比
	        $corp_detaile = $this->customer_corporation_mdl->getById($order['corporation_id']);
	        
	        //购物分成比例
// 	        $order_ration = $ratio['rate'];
        
	        //2016-09-20；改成读customer_corporation表的分成率;
	        $order_ration = $corp_detaile['commission_rate'];
	        
	        //可以分成的总额
	        $retio_price = $order['total_price']*$order_ration/100;
	         
	        //处理可以分成的总额
	        $retio_price = is_float($retio_price) ? substr_replace($retio_price, '', strpos($retio_price, '.') + 3) : $retio_price;
	        
	        
	        //接口-支付账号
	        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
	        $corp_customer_pay = json_decode($this->curl_get_result($url),true);
	        
	        $data['order_sn'] = $order['order_sn'];//订单号
	        $data['cash'] = $corp_customer_pay['cash'];//剩余现金余额
	        $data['price'] = $order['total_price'];//订单交易金额
	        $data['commission'] = $retio_price;
	    }else{ 
	        return false;
	    }
	    echo json_encode($data);
	}



    /**
     * 生成订单
     */
    public function save(){

        $item = $this->input->post("item");//订单商品
        $customer_remark = $this->input->post('customer_remark');//备注
        $address_id = $this->input->post ( 'address_id' );//收货地址id
        $package_id = $this->input->post ('package_id');//卡包id
        $customer_id = $this->session->userdata('user_id');//用户id
        $datetime = date('Y-m-d H:i:s');//当前时间
        
        
        if(!$customer_remark && $customer_remark =='请输入备注信息'){
            $customer_remark = null;
        }
        
        
        $result = $this->order_confirm();//订单数据处理
        
        if($result["status"] == 1){//商品不存在
            redirect('cart');
            return;
        }

        //判断是否有商品失效
        if(!empty($result["Invalid"])){
            //失败返回
            $result = array(
                "type" => "removed",
                "message" => "此订单存在失效商品"
            );
            echo json_encode($result);exit;
        }
        
        if(!empty($result["stock"])){
            //失败返回
            $result = array(
                "type" => "stock",
                "message" => "商品超过总库存"
            );
            echo json_encode($result);exit;
        }
        $deduction_price = $result["deduction_price"];//优惠券优惠金额
        $order_corpid = $result["order_corpid"];//订单所属企业id
        $total_price = $result["total_price"];//订单需付款金额(产品总价+运费-优惠价)
        $total_product_price = $result["total_product_price"];//产品总价（不包含运费手续费）
        $commission = $result["commission"];//现金手续费
        $freight = $result["freight"];//运费
        $itemarray = $result["itemarray"];//订单数据集合


        $this->load->model("order_mdl");
        $this->load->model("customer_corporation_mdl");
        $this->load->model("order_item_mdl");
        $this->load->model("product_sku_mdl");
        $this->load->model("product_mdl");
        $this->load->model ("customer_address_mdl");
        $this->load->model ("order_delivery_mdl");


        //查询订单所属店铺信息
        $_corporation = $this->customer_corporation_mdl->corp_load($order_corpid);
        if($_corporation['auto_order_amount'] >= $total_price){
            $status = 2;
        }else{
            $status = 1;
        }
        
        
        // 生成订单号，如果是订单号重复则重新提交数据
        do {
            $order_sn = get_order_sn ();//生成订单号
            if ($this->order_mdl->check_order_sn ( $order_sn )) {
                $order_exist = true;
            } else {
                $order_exist = false;
            }
        } while ( $order_exist ); 
        
        $address = $this->customer_address_mdl->load_by_customer ( $address_id, $customer_id );//查询收货信息
        
        $this->db->trans_begin();//开启事务
        
        /* 插入新订单信息 */
        $data["customer_id"] = $customer_id;
        $data["payment_id"] = $this->input->post ( 'payment_id' ) == NULL ? 2 : $this->input->post ( 'payment_id' ); // 支付方式
        $data["shipping_id"] = 0; // 物流
        $data["total_product_price"] = $total_product_price;//产品总价
        $data["auto_freight_fee"] = $freight;//运费
        $data["total_price"] = $total_price;//订单需付款金额（包含运费和优惠卷）
        $data["commission"] = $commission;//手续费
        $data["status"] = $status;//状态
        $data["corporation_id"] = $order_corpid;//企业id
        $data["customer_remark"] = $customer_remark;
        $data["order_sn"] = $order_sn;//订单号
        $data["place_at"] = $datetime;
        $data["app_id"] = $_corporation["app_id"];//分站点id
        if(stristr($_SERVER['HTTP_USER_AGENT'],"Android") || stristr($_SERVER['HTTP_USER_AGENT'],"iPhone") || stristr($_SERVER['HTTP_USER_AGENT'],"wp")){
            $data["order_source"] = 2; // 订单来源
        }
        $new_order_id = $this->order_mdl->create ($data);//创建新订单
        
        if($new_order_id){
            $rowids = array();//记录已经被购买的产品
            foreach ( $itemarray as $items ) {
                $rowids[] = $items['rowid'];
                
                //删除数据库购物车已被购买的商品
                $row = $this->cart_mdl->deleteCart($customer_id,$items['product_id'],$items['sku_id']);
                if(!$row){
                    //失败返回
                    $result = array(
                        "type" => "fail",
                        "message" => "购物车删除失败"
                    );
                    echo json_encode($result);exit;
                }
                
                $data = array(
                    "sku_value" => $items['sku_value'],
                    "order_id" => $new_order_id,
                    "product_id" => $items ['product_id'],
                    "product_name" => $items ['product_name'],
                    "price" => $items ['price'],
                    "sku_id" => $items ['sku_id'],
                    "weight" => 0,
                    "source" => $items ['source'],
                    "quantity" => $items ['qty'],
                    "goods_thumb" => $items["goods_thumb"],
                );
                $res = $this->order_item_mdl->create ($data);//生成item订单信息
                
                if($res){
                    //判断是否sku产品，如果是则更新sku产品库存
                    if( $items['sku_id'] ){
                        $condition = array("id"=>$items["sku_id"],"qty"=>$items["qty"]);
                        $row = $this->product_sku_mdl->update_value_stock($condition);
                        if(!$row){
                            //失败返回
                            $result = array(
                                "type" => "fail",
                                "message" => "更新sku库存失败"
                            );
                            echo json_encode($result);exit;
                        }
                    }
                    //更改商品总库存
                    $row = $this->product_mdl->update_stock($items['product_id'],$items['qty']);
                    if(!$row){
                        //失败返回
                        $result = array(
                            "type" => "fail",
                            "message" => "更新总库存失败"
                        );
                        echo json_encode($result);exit;
                    }
                }else{
                    //失败返回
                    $result = array(
                        "type" => "fail",
                        "message" => "生成item订单信息失败"
                    );
                    echo json_encode($result);exit;
                }
            }
        }else{
           //失败返回
           $result = array(
               "type" => "fail",
               "message" => "生成订单失败"
           );
           echo json_encode($result);exit;
        }

        //插入收货人信息
        $this->order_delivery_mdl->order_id = $new_order_id;
        $this->order_delivery_mdl->consignee = isset ( $address ['consignee'] ) ? $address ['consignee'] : $this->session->userdata ( 'nick_name' );
        $this->order_delivery_mdl->address = isset ( $address ['address'] ) ? $address ['address'] : "";
        $this->order_delivery_mdl->province_id = isset ( $address ['province_id'] ) ? $address ['province_id'] : 0;
        $this->order_delivery_mdl->city_id = isset ( $address ['city_id'] ) ? $address ['city_id'] : 0;
        $this->order_delivery_mdl->district_id = isset ( $address ['district_id'] ) ? $address ['district_id'] : 0;
        $this->order_delivery_mdl->contact_phone = isset ( $address ['phone'] ) ? $address ['phone'] : "";
        $this->order_delivery_mdl->contact_mobile = isset ( $address ['mobile'] ) ? $address ['mobile'] : "";
        $this->order_delivery_mdl->postcode = isset ( $address ['postcode'] ) ? $address ['postcode'] : "";
        $this->order_delivery_mdl->create ();
        $row  = $this->db->insert_id();
        if(!$row){
            //失败返回
            $result = array(
                "type" => "fail",
                "message" => "收货地址insert失败"
            );
            echo json_encode($result);exit;
        }
        
        //判断是否使用优惠卷
        if($package_id && $deduction_price > 0){
            $row = $this->card_package_mdl->Clip_coupons($package_id,$customer_id,$order_sn);//把优惠券改成已使用
            if(!$row){
                //失败返回
                $result = array(
                    "type" => "fail",
                    "message" => "优惠券使用失败"
                );
                echo json_encode($result);exit;
            }
        }

        //删除session购物车已被购买的商品
        foreach($rowids as $rowid){
            $data = array (
                'rowid' => $rowid,
                'qty' => 0
            );
            $this->cart->update ( $data );
        }
        
	    $this->db->trans_commit();//事务提交 
	           
        //成功返回
        $result = array(
            'type' => 'ok',
            'new_order_id' => $new_order_id,
            'order_sn' => $order_sn,
            'status' => $status
        );
        echo json_encode($result);

	}
	
	
    // ----------------------------------------------------------------------------------
	

	
	
	// ----------------------------------------------------------------------------------
	
	
	/**
	 * 运算优惠金额
	 */
// 	function calculate(){
// 	    $customer_id = $this->session->userdata('user_id');
// 	    $data["item"] = json_decode($this->input->post('item'));//订单id(数组)
// 	    $id = $this->input->post("id");//使用优惠卷id(数组)


// 	    $array = array();
// 	    $pid = array();//订单的所有商品id
// 	    foreach ($this->cart->contents() as $items) {
// 	        // 选择了什么商品
// 	        foreach ($data["item"] as $i) {
// 	            if ($items["rowid"] == $i) {
// 	                $array[] = $items;
// 	                if (!in_array($items['product_id'],$pid)){
// 	                   $pid[] = $items['product_id'];
// 	                }
// 	            }
// 	        }
// 	    }
	    

//         //查询优惠卷信息
//         $this->load->model('card_package_mdl');
//         $p_info = $this->card_package_mdl->calculate($id,$customer_id,$pid);//卡包信息
//         $total = 0;//优惠金额
//         $zong = 0;//总额
//         if($p_info){
//             foreach ($array as $k => $v){
//                 foreach ($p_info as $i){
//                     if($v["product_id"] == $i['id']){
//                         switch ($i['discount_type']){
//                             case 1://折扣运算
//                                 $total += ($v["price"]*$v["qty"]-$v["price"]*$v["qty"]*$i['discount']/10);
//                                 break;
//                             case 2://满减运算
//                                 $zong += $v["price"]*$v["qty"];//总额
//                                 if($zong >= $i["overtop_price"]){
//                                    $total = $i["deduction_price"];
//                                    break 3;
//                                 }
//                                 break;
//                         }
//                     }
//                 }
//             }
//             echo $total;exit;//优惠额度
//         }else{
//             //有问题返回0
//             echo 0;exit;
//         }
// 	}

	/**
	 * 查询卡包相关的商品
	 */
	function discount_goods(){
	    $package_id = $this->input->post("package_id");//卡包id
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $this->load->model('card_package_mdl');
	    $data = $this->card_package_mdl->discount_goods($package_id,$customer_id,0,0,"default");
	 
	    echo json_encode($data);
	}
	
	/**
	 * 检测是否包邮
	 */
	public function is_free_shipping( $corporation_id = 0)
	{ 
	    $corporation_id = $this->input->post('corp_id');
	    $total_price = $this->input->post('total');
	    //判断订单是否满足包邮
        $data['is_free_shipping'] = 0;
        $data['free_shipping_price'] = 0;
        $this->load->model('Corporation_freight_mdl');
        $this->Corporation_freight_mdl->corporation_id = $corporation_id;
        $free_shipping = $this->Corporation_freight_mdl->load();
         
        if( $free_shipping && $total_price >= $free_shipping['price_floor'] )
        {
            //免邮费
            $data['is_free_shipping'] = 1;
            $data['free_shipping_price'] = $free_shipping['price_floor'];
        }
        
        echo json_encode($data);
	}
	
    // ---------------------------------------------------------------------

	/**
	 * 计算企业手续费
	 * @param number $commission_rate 手续费比率
	 * @param number $total_price 总价
	 */
	private function commission($commission_rate,$total_price){
	    $commission = ($commission_rate/100) * $total_price;
	
	    $commission = strpos($commission,'.') ? substr_replace($commission, '', strpos($commission, '.') + 3) : $commission;
	
	    if($commission < 0.01){
	        $commission = 0;
	    }
	    return $commission;
	}
	

	
	// ---------------------------------------------------------------------
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */