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
        //判断是否Ajax请求
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){}else{
            if (strstr($_SERVER['REQUEST_URI'], "item")) {
                
                $url = "/order" . strstr($_SERVER['REQUEST_URI'], "?");
                $this->session->set_userdata("redirect", site_url($url)); // 废除待删除
                $this->session->set_userdata("ref_from_url", site_url($url)); // 统一约定使用ref_from_url参数名，不使用关键词redirect
            } else if(strstr($_SERVER['REQUEST_URI'], "order") ){
                
                $this->session->set_userdata('ref_from_url', site_url('cart'));
            }else{ 
                $this->session->set_userdata('ref_from_url', current_url());
            }
        }
        
        
        // 判断用户是否登录
        if ( !$this->input->post('is_api') &&  !$this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
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
	 * 订单界面
	 */
	public function index() {
	    if ($this->input->get_post('item') != null) {
            $this->order_confirm();
        } else {
            redirect('cart');
        }
    }

	// -----------------------------------------------------------------------------

	/**
	 * 确认订单
	 * @param number $payment_id
	 */
	public function order_confirm($payment_id = 0)
	{
	   
        $customer_id = $this->session->userdata('user_id'); 
	    
        $freight = 0;//总运费
        $this->load->model('cart_mdl');
        $this->load->model('goods_mdl');
//         $this->load->model('logistics_mdl');
        $this->load->model('product_mdl');
        $this->load->model('customer_address_mdl');

        $data["item"] = $this->input->get_post("item");//购物清单

        // 查询收货地址
        $data["address_id"] = $this->input->get_post("address_id");
        if ($data["address_id"] == 0) {
            $data['address'] = $this->customer_address_mdl->load_all($customer_id);  
        } else {
            $data['address']['0'] = $this->customer_address_mdl->load_by_customer($data["address_id"], $customer_id);
        }

        
        $corp_product = array();//拆单归类完成（存在失效商品）
        $product_array = array();//拆单归类完成（不存在失效商品）
        $product_freight = array();//需要运费的商品 (存在失效商品)
        $choose_cart = array();//购物车商品
        $product_id_string = '';
        $sku_id_string = '';
        foreach ($this->cart->contents() as $items) 
        {
            // 选择了什么商品
            foreach ($data["item"] as $k=>$i) 
            {
                
                if ($items["rowid"] == $i) 
                {
                    $product_id = substr($items['id'],0,strpos($items['id'],'_') ); //商品ID
                    $sku_id = substr($items['id'],strpos($items['id'],'_')+1 );//skuID
                    
                    $product_id_string .= $product_id.',';
                    $sku_id_string .= $sku_id.',';
                    
                    $choose_cart[$items['id']] = $items;
                }
            }
        }
        
        //用户购买的商品信息-结合SKU;
        $product_id_string = trim($product_id_string,',');
        $sku_id_string = trim($sku_id_string,',');

        
        $all_product_info = $this->product_mdl->load_product_sku($product_id_string,$sku_id_string,$customer_id);//查询订单所有商品
  
        if( $all_product_info )
        {
        
            foreach ( $all_product_info as $product_info )
            { 
                    //查找购物车里面的信息
                $car_key =  $product_info['id'].'_'.(!empty($product_info['sku_val_id'] ) ? $product_info['sku_val_id'] : '0');

                $items = $choose_cart[$car_key];

                //先将普通价格商品赋值
                $items['is_on_sale'] = $product_info['is_on_sale'];
                $items['stock'] = $product_info['stock'];
                $items["price"] = $product_info['vip_price'];
                
                //sku赋值覆盖普通商品
                if(  $items['sku_id'] != 0 )
                {
                    $items["price"] = $product_info['sku_price'];
                    $items['stock'] = $product_info['sku_stock'];
                }
                
                 //特价商品处理 
                if( $items['options']['special_price_end_at'] != '1970-01-01 08:00:00' )
                {
                    if ($product_info['special_price_start_at'] <= date("Y-m-d H:i:s") && $product_info['special_price_end_at'] >= date("Y-m-d H:i:s") && $product_info['is_special_price'] == 1 ) {

                        $items["price"] = $items['sku_id'] ? $product_info['special_offer'] : $product_info['special_price'];
                    } else {
                        $items["price"] = $items['sku_id'] ? $product_info['sku_price'] : $product_info['vip_price'];
                        $items['special_status'] = 'no_special';
                    }
                    
                }
                
                //判断是否上架
                if($product_info['is_on_sale']){
                    //判断库存是否足够
                    $items['is_on_sale'] = ($items['stock'] >= $items['qty']) ? true : false;
                }
                
                //session购物车
                $cart = $this->session->userdata('cart_contents');
            
                if( $items['stock'] < $items['qty'] )
                {
                    $product_status = 'no_stock';
            
                }else{
                    
                    $product_status = 'ok';
                }
                $cart["{$items['rowid']}"]['product_status'] = $product_status;
                $this->session->set_userdata('cart_contents',$cart);
                
                
                $items["is_freight"] = false; //下面注释打开时删除该变量赋值。
//                 //判断是否有运费 --暂时注释
//                 if($product_info["logistics_id"]){
//                     $qty = ($items['stock'] >= $items['qty']) ? $items['qty'] : $items['stock'];//购买数量
//                     //商品相同sku不同的商品数量叠加
//                     if(empty($product_freight[$product_info['id']]['qty'])){
//                         $product_freight[$product_info['id']]['qty'] = $qty;
//                     }else{  
//                         $product_freight[$product_info['id']]['qty'] += $qty;
//                     }
                    
//                     $product_freight[$product_info['id']]['corporation_id'] = $product_info['corporation_id'];
//                     $items["is_freight"] = true;
//                 }else{
//                     $items["is_freight"] = false;
//                 }



                //拆单完成，分店铺和分符合购买的商品
                if( $items['is_on_sale'] && $product_info['is_delete'] == 0)
                {
                    $product_array[$items['corporation_id']][] = $items;
                    //成功一个删一个，剩下的就是无效或者下架商品
                    unset($choose_cart[$car_key]);
                }else{
                    $items["is_on_sale"] = false;
                }
                
                //将同一店铺的商品归类起来。
                $corp_product[$items['corporation_id']]['corporation_name'] = $items['corporation_name'];
                $corp_product[$items['corporation_id']]['corporation_id'] = $items['corporation_id'];
                $corp_product[$items['corporation_id']]['product_info'][] = $items;
                $corp_product[$items['corporation_id']]['freight'] = "0.00";//默认运费0.00
            }
        }else{//非法操作
            echo "<script>history.back(-1);</script>";return;
        }

        //如果购物车中有失效商品 - 下架或者SKU不存在
        if( $choose_cart )
        { 
            //更新session购物车状态.
            $cart = $this->session->userdata('cart_contents');
            
            foreach ($choose_cart as $v)
            { 
                $product_status = 'no_sale';
                $v['is_on_sale'] = false;
                $cart["{$v['rowid']}"]['product_status'] = $product_status;
                $this->session->set_userdata('cart_contents',$cart);
//                 array_push( $corp_product[$v['corporation_id']]['product_info'], $v );
            }
        }

        //防止下单成功返回上一层
        if( empty( $product_array ) ){
            redirect('cart');
            exit();
        }
        
        
        //判断商品是否需要运费。--暂时注释
//         if($product_freight){
//             //根据用户id查询用户地址
//             $this->load->model ( 'customer_address_mdl' );
//             $address = $this->customer_address_mdl->load ($customer_id);
//             if(!$address){
//                 $address['id'] = 0;
//             }
//             foreach($product_freight as $productid => $val){
//                 //根据用户地址查询运费模版信息，如果没有则使用默认运费
//                 $logDetail = $this->logistics_mdl->SuitedRegion($productid,$customer_id,$address['id']);
//                 if($logDetail){
//                     $p_freight = $this->freight_count($logDetail,$val["qty"]);//计算商品运费
//                     $corp_product[$val['corporation_id']]["freight"] += $p_freight;//店铺运费
//                     $freight += $p_freight;//订单总运费

                    
//                 }else{//未知错误
//                     error_log("没有运费模版信息".$this->db->last_query());
//                     echo "<script>history.back(-1);</script>";return;
//                 }
//             }
//         }

        
        
        //订单商品相关的优惠券
        $price = array();//商品总价格 （pid=>price）
        $pid = array();//购买的商品id
        $this->load->model('card_package_mdl');
        foreach ($product_array as $val){
            foreach ($val as $k=>$v){
                $pid[] = $v['product_id'];
                $price[$v['product_id']] = $v['price']*$v["qty"];
            }
        }
        //查询订单可以使用的优惠券
        $package  = $this->card_package_mdl->goods_coupons($pid,$customer_id);
        if($package){
            //筛选出符合要求得优惠券
            foreach ($package as $k=>$v){
                if($v['discount_type']==2 && $v['overtop_price'] > $price[$v['product_id']]){
                    unset($package[$k]);
                }else{
                    unset($package[$k]['product_id']);
                }
            }
            if($package){
                //去除重复的优惠券
                $package = $this->unique_arr($package);
                //优惠券归店铺
                foreach ($package as $v){
                    $corp_product[$v['corporation_id']]['package'][] = $v;
                    $data['package'][$v['corporation_id']][] = $v;//h5使用
                }
            }
        }

        //查询是否有可用的储值卡。
//         $corporation_array = !empty($corp_product) ? array_column($corp_product,'corporation_id'):array();
//         $sift['where']['customer_id'] = $this->session->userdata('user_id');
// 	    $sift['where']['corporation_id'] = $corporation_array;
	    
// 	    $this->load->model('Savings_card_mdl');
// 	    array_column($this->Savings_card_mdl->Load_Customer_Card( $sift ),'corporation_id','corporation_id');
        $data['freight'] = $freight;
        $data['title'] = "确认订单";
        $data['head_set'] = 2;
        $data['corp_product'] = $corp_product;
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
    }
    
    // ---------------------------------------------------------------------------
    
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

	/**
	 * 保存支付方式并跳至支付页面
	 */
	public function save_pay() {

	    /*$condition = $this->input->post();
	    print_r($condition);exit;*/
	}

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

	// ---------------------------------------------------------------------------
	/**
	 *
	 * @param array $order
	 * @return string
	 */
	private function send(array $order) {
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
	    
	    $is_ok = false;
	    $data['status'] = false;
	    $order_id = $this->input->post('id');
	    $pay_passwd = $this->input->post('pass');
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $relation_id = $this->session->userdata ( 'pay_relation' );
	    $card_buy_id = $this->input->post('card_buy_id');
	    $card_pay_amount = $this->input->post('card_pay_amount');
	    $this->load->model('order_mdl');
	    
	    //判断订单是否正确
	    $is_order = $this->order_mdl->is_customer_order( $order_id,array(2),$customer_id );
	    
	    if( $is_order )
	    {      
	        //获取该店主信息
	        $this->load->model('customer_corporation_mdl');
	        $corp_customer = $this->customer_corporation_mdl->corp_load($is_order['corporation_id']);
            $corp_customer_id = $corp_customer['customer_id'];//店主的用户ID
            
            $card_row = true;
            $sift['set']['order_type'] = 1;
            $this->db->trans_begin(); //事物执行方法中的MODEL。
            
            //判断如果使用卡，则调用卡支付逻辑。
//             if( $card_buy_id && $card_pay_amount > 0 )
//             {
//                 $this->load->model('Savings_card_mdl');
//                 $is_order['savings_card_buy_id'] = $card_buy_id;
//                 $is_order['card_pay_amount'] = $card_pay_amount;
                
//                 //卡消费逻辑。
//                 $card_row = $this->Savings_card_mdl->Card_Pay_Order( $is_order );
               
//                 if( $card_row )
//                 { 
//                     //默认1：货豆  2：储值卡支付。3：货豆+储值卡
//                     $sift['set']['order_type'] = $card_pay_amount == $is_order['total_price'] ? 2 : 3;
//                 }
            
//             }
            
            if( $card_row )
            {   
                //改变订单状态
                $sift['set']['status'] = 4;//改变为支付成功
                $sift['where']['id'] = $order_id;
                $update_order_row = $this->order_mdl->Update( $sift );
               
                //如果更新成功才调用
                if( $update_order_row )
                {
                    if( $sift['set']['order_type'] != 2 )
                    {
                        //调用A端货豆支付逻辑。
                        $url = $this->url_prefix.'Order/pay_order';
                        
                        $data_post['relation_id'] = $relation_id;
                        $data_post['pass'] = $pay_passwd;
                        $data_post['corp_customer_id'] = $corp_customer_id;
                        $data_post['total_price'] = $sift['set']['order_type'] == 3 ? $is_order['total_price'] - $card_pay_amount : $is_order['total_price'];
                        $data_post['order_sn'] = $is_order['order_sn'];
                        $data_post['app_id'] =  $is_order['app_id'];
                        
                        $error  =  json_decode($this->curl_post_result( $url,$data_post ),true);
                        
                        $data['status'] =  $error['status'];
                       
                        if( $data['status'] == 1 )
                        { 
                            $is_ok = true;
                        }  
                        
                    }else{ 
                        
                        //储值卡全款支付。
                        $data['status'] = 1;
                        $is_ok = true;
                    }
                }
            }
            
            //如果支付失败则回滚 成功则提交。
            if( !$is_ok )
            { 
                $this->db->trans_rollback();
            }else{ 
                
                //更新为不是第一次购买了。
                $this->load->model('Customer_mdl');
                $this->Customer_mdl->active_account( $customer_id );
                $this->db->trans_commit();
            }
            
	    }else{
	        //'错误订单'
	       $data['status'] = 2;
	    }
      
	    echo json_encode($data);
	}
	
	// ---------------------------------------------------------------------------
	
	/**
	 * 订单支付成功回调页面
	 */
    public function payfinish() {
        
        $data["order_id"] = $this->input->get_post('new_order_id');
        $total_price = $this->input->get('total_price');
        
        if( !empty($data["order_id"]) ){
            $this->load->model ('order_mdl');
            $order_info = $this->order_mdl->is_customer_order( $data["order_id"],array(4,14),$this->session->userdata("user_id") );
            if(count($order_info)!=0){
                $data['pay_account'] = $order_info['total_price'];
                $data['order_sn'] = $order_info['order_sn'];
                $data['order_id'] = $order_info['id'];
            }else{
                redirect('notfound');
            }
        }else{ 
            $data['pay_account'] = $total_price;
        }
       
        $data['head_set'] = 2;
        $data['title'] = '订单支付成功';
      
        $this->load->view('head', $data);
        $this->load->view('_header');
        $this->load->view('order/orderfinish', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
	
	// ---------------------------------------------------------------------------
	
	/**
	 * 需要支付的订单信息
	 */
	public function order_message(){
	    $order_id = $this->input->post('o_id');
	    $card_list = array();
	    //查询订单信息。
	    $this->load->model('order_mdl');
	    $order_message = $this->order_mdl->order_message($order_id);
	   
// 	    if( $order_message )
// 	    {
//     	    //查询可用储值卡。
//     	    $sift['where']['customer_id'] = $this->session->userdata('user_id');
//     	    $sift['where']['corporation_id'] = $order_message['corporation_id'];
//     	    $this->load->model('Savings_card_mdl');
//     	    $card_list = $this->Savings_card_mdl->Load_Customer_Card( $sift );
    	    
// 	    }
// 	    $return['data']['order_info'] = $order_message;
// 	    $return['data']['card_list'] = $card_list;
        $return = $order_message;
	    echo json_encode($return);
	}


	/**
	 * 验证支付密码 并收货
	 * 保持事物，先处理本地数据再进行接口处理，返回判断。
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
            $this->load->model('customer_corporation_mdl');
            $this->load->model("order_rebate_mdl");
            
            //接口-验证支付密码
            $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
            $pay_info = json_decode($this->curl_get_result($url),true);
            
            if( $pay_info['pay_passwd'] == $pass ){
                //获取该店信息
                $corp_customer = $this->customer_corporation_mdl->corp_load($order['corporation_id']);
                
                //店主的用户ID
                $corp_customer_id = $corp_customer['customer_id'];
                
                //执行分成function
                $this->db->trans_begin();
                $order_rebate = $this->order_rebate_mdl->order_rebate($order);
                
        	    //分成ok
        	    if($order_rebate)
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
            	        $data_post['C_commission'] = $order['commission'];
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
	    $customer_id = $this->session->userdata ( 'user_id' );
	    //接口-验证支付密码
	    $url = $this->url_prefix.'Customer/fortune/?customer_id='.$customer_id;
	    $result = json_decode($this->curl_get_result($url),true);
	    
	    if( $result['pay_passwd'] != ''){
	        $is_pay = true;
	    }

	    echo $is_pay;
	}
	
	
	/**
	 * 提取货豆订单的信息
	 */
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
	        $retio_price = strpos($retio_price,'.') ? substr_replace($retio_price, '', strpos($retio_price, '.') + 3) : $retio_price;
	        
	        
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
	 * 生产一张新的订单
	 */
	public function save(){
	   
	    /* 接收表单数据 */

	    $product_data = $this->input->post('product_data');//订单信息
	    $customer_remark = $this->input->post('customer_remark');//留言
	    $address_id = $this->input->post ( 'address_id' );//收货地址id
	    $package_id = $this->input->post ( 'package_id' );//卡包id
	    
	    $customer_id = $this->session->userdata ( 'user_id' );
	    
        $error = array();
        //读取购物的商品信息->检测库存->检测SKU->归类订单->;
        $all_order_price = 0;//全部订单总价格
        $order_id_array = array();
        $invalid_id = array();
        $corp_product = array();
        $cart_data = array();
        
        
        $product_freight = array();//需要运费的商品 (存在失效商品)
        $product_array = array();
        $choose_cart = array();
        $product_id_string = '';
        $sku_id_string = '';
        
        $corporation_id_all = array();//记录有几个企业。
        $corporation_order_info = array();//记录每个企业支付了多少钱（也就是每张订单需要支付的金额。）
        //查询用户收货地址
        $this->load->model ( 'customer_address_mdl' );
        $address = $this->customer_address_mdl->load_by_customer ( $address_id, $customer_id );
        if(!$address){
            $error['type'] = 'fail';
            echo json_encode($error);
            exit();
        }
        
        
        if( $product_data )
        { 
            $this->load->library ( 'cart' );
            $this->load->model("cart_mdl");
            $this->load->model('product_mdl');
            $this->load->model("product_sku_mdl");
//             $this->load->model('logistics_mdl');
            
            foreach ( $product_data as $key => $val)
            {
                $product_id = substr($val['id'],0,strpos($val['id'],'_') ); //商品ID
                $sku_id = substr($val['id'],strpos($val['id'],'_')+1 );//skuID
                
                $product_id_string .= $product_id.',';
                $sku_id_string .= $sku_id.',';
            }
            
            
            //用户购买的商品信息-结合SKU;
            $product_id_string = trim($product_id_string,',');
            $sku_id_string = trim($sku_id_string,',');
            
            
            //查询订单商品信息
            $all_product_info = $this->product_mdl->load_product_sku($product_id_string,$sku_id_string,$customer_id);
            $this->load->model('product_cat_mdl');
            
            
            //判断数量是否正确否则订单内有下架商品，提示用回返回order页面处理。
            if( $all_product_info && count($all_product_info) == count($product_data) )
            { 
                
                
                foreach ($all_product_info as $product_info)
                {
                    //查询比率
                    $result = $this->product_cat_mdl->Load_Leve_One_Two($product_info['cat_id']);
                    
                    $rebate =  !empty($result) ? $result[0]['poundage'] : 0;
                    
                    $is_on_sale = true;
                    //下单信息的数组
                    $car_key =  $product_info['id'].'_'.(!empty($product_info['sku_val_id'] ) ? $product_info['sku_val_id'] : '0');
                    
                    $val = $product_data[$car_key];
                    
                    //先赋值普通商品的信息-下面判断SKU-特价-如果存在覆盖即可。
                    $val['id'] = $product_info['id'];
                    $val['corporation_id'] = $product_info['corporation_id'];
                    $val['price'] = $product_info['vip_price'];
                    $val['product_name'] = $product_info['name'];
                    $val['stock'] = $product_info['stock'];
                    $val['rebate'] = $rebate ? $rebate : 0;
                    
                    //SKU判断赋值覆盖
                    if(  $product_info['sku_val_id'] != 0 )
                    {
                        $val['stock'] = $product_info['sku_stock'];
                        $val['sku_id'] = $product_info['sku_val_id'];
                        $val['price'] = $product_info['sku_price'];
                        $val['sku_value'] = $product_info['sku_name'];
                    
                    }
                    
                    //判断是否加入购物车是否特价状态
                    if( $val['special_price_end_at'] != '1970-01-01 08:00:00')
                    {
                        if ($product_info['special_price_start_at'] <= date("Y-m-d H:i:s") && $product_info['special_price_end_at'] >= date("Y-m-d H:i:s") && $product_info['is_special_price'] == 1 ) {
                            $val["price"] = $product_info['sku_val_id'] ? $product_info['special_offer'] : $product_info['special_price'];
                        } else {
                            $val["price"] = $product_info['sku_val_id'] ? $product_info['sku_price'] : $product_info['vip_price'];
                            $val['special_status'] = 'no_special';
                        }
                        
                    }
                    


                    //判断是否有运费 --暂时注释
//                     if($product_info["logistics_id"]){
//                         $qty = ($val['stock'] >= $val['qty']) ? $val['qty'] : $val['stock'];//购买数量
//                         //商品相同sku不同的商品数量叠加
//                         if(empty($product_freight[$product_info['id']]['qty'])){
//                             $product_freight[$product_info['id']]['qty'] = $qty;
//                         }else{
//                             $product_freight[$product_info['id']]['qty'] += $qty;
//                         }
                    
//                         $product_freight[$product_info['id']]['corporation_id'] = $product_info['corporation_id'];
// //                         $items["is_freight"] = true;
//                     }
                    
                    

                    //判断是否上架并且是否删除
                    if($product_info['is_on_sale'] && $product_info["is_delete"] == 0){
                        //判断库存
                        $is_on_sale = ($val['stock'] >= $val['qty']) ? true : false;
                    }else{
                        $is_on_sale = false;
                    }
                    
                    
                    if( !empty($is_on_sale) )
                    {
                        //计算商品需要付的手续费
                        $val['rebate_price'] = ($val['qty'] * $val['price']) * $val['rebate'];
                        
                        //拼装订单信息
                        $corp_product[$product_info['corporation_id']]['order_info'][] = $val;
                        $corp_product[$product_info['corporation_id']]['corporation_id'] = $product_info['corporation_id'];
                        @$corp_product[$product_info['corporation_id']]['total_product_price'] += $val['qty']*$val['price'];//产品总价
                        @$corp_product[$product_info['corporation_id']]['freight'] += '0.00';//默认运费0.00
                        @$corp_product[$product_info['corporation_id']]['order_rebate_price'] += $val['rebate_price'];//默认运费0.00
                        
                    }else{ 
                        //遇到库存不足就提示。
                        $error['type'] = 'invalid';
                        echo json_encode($error);
                        exit();
                    }
                    
                }
            }else{
                echo "<script>history.back(-1);</script>";return;
            }
            
//             echo '<pre>';
//             var_Dump($corp_product);
//             exit;
            
            //没有进入商品处理返回ORDER页面。
            if( empty($is_on_sale) )
            {
                $error['type'] = 'invalid';
                echo json_encode($error);
                exit();
            }
            
            
            //组装留言信息
            $new_customer_remark = array();
            if( is_array($customer_remark) ){
                foreach ($customer_remark as $key => $val)
                { 
                    $corp_key =  substr($val,0,strpos($val,'_'));
                    $corp_remark = substr($val,strpos($val,'_') + 1) ? substr($val,strpos($val,'_') + 1) : '';
                    $new_customer_remark[$corp_key] = $corp_remark;
                    
                }
            }
            
            
            //判断商品是否需要运费，需要则计算单张订单运费 --暂时注释
//             if($product_freight){
//                 foreach($product_freight as $productid => $val){
//                     //根据用户地址查询运费模版信息，如果没有则使用默认运费
//                     $logDetail = $this->logistics_mdl->SuitedRegion($productid,$customer_id,$address_id);
//                     if($logDetail){
//                         $p_freight = $this->freight_count($logDetail,$val["qty"]);//计算商品运费
//                         $corp_product[$val['corporation_id']]["freight"] += $p_freight;//店铺运费
//                     }else{//未知错误
//                         $error['type'] = 'fail';
//                         echo json_encode($error);
//                         exit();
//                     }
//                 }
//             }

            
            //判断是否有使用优惠券
            if($package_id){
                $this->load->model("card_package_mdl");
                $package_info = $this->card_package_mdl->discount_goods($package_id,$customer_id);//优惠卷相关
                
                if(!$package_info){//非法优惠券
                    $error['type'] = 'fail';
                    echo json_encode($error);
                    exit();
                }
            }
            
            
            //组装后的订单数据
            $this->db->trans_begin(); //事物执行方法中的MODEL。
            $this->load->model('order_mdl');
            $this->load->model('order_item_mdl');
            $this->load->model ( 'order_delivery_mdl' );
            
            $is_ok = array();//记录使用过的优惠券id
            foreach ($corp_product as $k => $v)
            {
                do {
                    $order_sn = get_order_sn ();//生成订单号
                    if ($this->order_mdl->check_order_sn ( $order_sn )) {
                        $order_exist = true;
                    } else {
                        $order_exist = false;
                    }
                } while ( $order_exist ); // 如果是订单号重复则重新提交数据
                
                
                //计算优惠券优惠金额
                $deduction_price = 0;//优惠金额
                if($package_id){
                    foreach ($package_info as $p){
                        foreach($v['order_info'] as $key=>$val){
                            $pid = $val['id'];//商品id
                            if($pid==$p['id']){
                                if($p['coupon_end_at']>=date('Y-m-d')){//有效期
                                    //把优惠券状态改成已经使用
                                    if(in_array($p['package_id'],$is_ok)==false){
                                        $row = $this->card_package_mdl->Clip_coupons($p['package_id'],$customer_id,$order_sn);
                                    }
                                    if(!empty($row)){//记录下优惠券id防止重复
                                        $is_ok[] = $p['package_id'];
                                    }else{//优惠券使用失败
                                        error_log($this->db->last_query());
                                        $this->db->trans_rollback();//回滚
                                        $error['type'] = 'fail';
                                        echo json_encode($error);
                                        exit();
                                    }
                                    
                                    if($p['discount_type']==1)
                                    {
                                        //折扣
                                        
                                        //每个类型商品优惠多少钱
                                        $preferential = ($val['price']*$val['qty'])*(10-$p['discount'])/10;
                                        
                                        //如果有满减先把之前计算好的手续费从总额手续费中减去，重新计算在赋值进总数组。
                                        $v['order_rebate_price'] -= $v['order_info'][$key]['rebate_price'];
                                        
                                        //重新计算手续费
                                        $v['order_info'][$key]['rebate_price'] =  ($val['price']*$val['qty'] - $preferential) * $v['order_info'][$key]['rebate'];
                                        
                                        //重新计算完手续费赋值进去
                                        $v['order_rebate_price'] += $v['order_info'][$key]['rebate_price'];
                                        
                                        //优惠金额
                                        $deduction_price += ($val['price']*$val['qty'])*(10-$p['discount'])/10;
                                        
                                    }else{//满减
                                        
                                        if( $p['overtop_price']<=($val['price']*$val['qty']) ){//判断是否达到满减要求
                                            
                                            //如果有满减先把之前计算好的手续费从总额手续费中减去，重新计算在赋值进总数组。
                                            $v['order_rebate_price'] -= $v['order_info'][$key]['rebate_price'];
                                            
                                            //重新计算手续费
                                            $v['order_info'][$key]['rebate_price'] = ($val['price']*$val['qty'] - $p['deduction_price'] ) * $v['order_info'][$key]['rebate'];
                                            
                                            //重新计算完手续费赋值进去
                                            $v['order_rebate_price'] += $v['order_info'][$key]['rebate_price'];
                                            
                                            //优惠金额
                                            $deduction_price += $p['deduction_price'];
                                            
                                        }
                                        break(2);//跳出循环
                                    } 

                                }else{
                                    //优惠券过期
                                    $this->db->trans_rollback();//回滚
                                    $error['type'] = 'couponexpired';
                                    echo json_encode($error);
                                    exit();
                                }
                            }
                        }
                    }
                }
                //优惠券截取小数点后两位
                $deduction_price = strpos($deduction_price,'.') ? substr_replace($deduction_price, '', strpos($deduction_price, '.') + 3) : $deduction_price;
               //生成订单
                $freight = $v['freight'];//运费
                $all_order_price +=  $v['total_product_price'] + $freight - $deduction_price;//记录全部订单总金额 （产品总额＋运费－优惠金额）
                /* 插入新订单信息 */
                
                $this->order_mdl->customer_id = $customer_id;
                $this->order_mdl->payment_id = $this->input->post ( 'payment_id' ) == NULL ? 0 : $this->input->post ( 'payment_id' ); // 支付方式
                $this->order_mdl->shipping_id = 0; // 物流
                $this->order_mdl->total_product_price = $v['total_product_price'];//产品总价
                $this->order_mdl->auto_freight_fee = $freight;//运费
                $this->order_mdl->total_price =  $v['total_product_price'] + $freight - $deduction_price;//总价格（产品总额＋运费－优惠金额）
                if(stristr($_SERVER['HTTP_USER_AGENT'],"Android") || stristr($_SERVER['HTTP_USER_AGENT'],"iPhone") || stristr($_SERVER['HTTP_USER_AGENT'],"wp")){
                    $this->order_mdl->order_source = 2; // 订单来源
                }
                $this->order_mdl->status = 2;
                $this->order_mdl->customer_remark = !empty($new_customer_remark[$k]) ? $new_customer_remark[$k] : '';
                $this->order_mdl->corporation_id = $v['corporation_id'];
                $this->order_mdl->order_sn = $order_sn;
                $this->order_mdl->commission = $v['order_rebate_price'];
                $new_order_id = $this->order_mdl->create ();//创建订单
                if( $new_order_id )
                {
                    //生成消费记录
                    foreach ( $v['order_info'] as $items ) {
                         
                        if(!empty($items['sku_value'])){
                            $this->order_item_mdl->sku_value = $items['sku_value'];
                        }
                        $this->order_item_mdl->order_id = $new_order_id;
                        $this->order_item_mdl->product_id = $items ['id'];
                        $this->order_item_mdl->product_name = $items ['product_name'];
                        $this->order_item_mdl->quantity = $items ['qty'];
                        $this->order_item_mdl->price = $items ['price'];
                        $this->order_item_mdl->sku_id = !empty($items ['sku_id']) ? $items ['sku_id']:0;
                        $this->order_item_mdl->weight = 0; // $items['options']['weight'];
                       
                        $res = $this->order_item_mdl->create ();
                    
                    
                        //--商品库存处理
                        if($res)
                        {
                            
                            if( !empty($items['sku_id']) )
                            {
                                    
                                //更改SKU库存
                                $condition = array("id"=>$items["sku_id"],"qty"=>$items["qty"]);
                                $sku_stock_row = $this->product_sku_mdl->update_value_stock($condition);
                                
                                if( !$sku_stock_row )
                                { 
                                    $this->db->trans_rollback();
                                    $error['type'] = 'fail';
                                    echo json_encode($error);
                                    exit();
                                }
                                
                            }
                            
                            //更改普通商品总库存
                            $product_stock_row = $this->product_mdl->update_stock($items['id'],$items['qty']);
                            
                            if( !$product_stock_row )
                            { 
                                $this->db->trans_rollback();
                                $error['type'] = 'fail';
                                echo json_encode($error);
                                exit();
                            }
                            
                            
                        }else{ 
                            $this->db->trans_rollback();
                            $error['type'] = 'fail';
                            echo json_encode($error);
                            exit();
                            //停止运行，提示生成失败
                        }
                        	
                        $cart_data[] = $items; //丢进购物车数组
                    }
                    
                    /* 插入收货人信息 */
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
                    $row = $this->db->insert_id();
                    if(!$row){
                        $this->db->trans_rollback();
                        $error['type'] = 'fail';
                        echo json_encode($error);
                        exit();//停止运行，提示生成失败
                    }
                    
                    //生成的订单ID。
                    $order_id_array[] = $new_order_id;
                    
                    //储值卡使用。
                    $corporation_id_all[] =  $v['corporation_id'];
                    $corporation_order_info[$v['corporation_id']]['total_price'] = $this->order_mdl->total_price;
                    $corporation_order_info[$v['corporation_id']]['order_id'] = $new_order_id;
                    
                    
                }else{
                    
                    $this->db->trans_rollback();
                    $error['type'] = 'fail';
                    echo json_encode($error);
                    exit();
                    //停止运行，提示生成失败
                }
            }
         
           
            $this->db->trans_commit(); //能走到这里，说明前面的SQL已经处理完毕->提交事物
            
            //生成订单成功后->删除购物车中的信息。
            foreach ( $cart_data as $v )
            { 
                $data = array (
                    'rowid' => $v['rowid'],
                    'qty' => 0
                );
                $this->cart_mdl->deleteCart($v['cid'],$customer_id);
                $this->cart->update ( $data );
            }
        

            //查询是否有可用的储值卡。
//             $sift['where']['customer_id'] = $this->session->userdata('user_id');
//     	    $sift['where']['corporation_id'] = $corporation_id_all;
     
//     	    $cart_list = [];
//     	    $this->load->model('Savings_card_mdl');
//     	    $cart_all = $this->Savings_card_mdl->Load_Customer_Card( $sift );
    	    
//     	    foreach ( $cart_all as $k=>$v)
//     	    { 
//     	        $cart_list[$v['corporation_id']][] = $v;
//     	    }
            
    	   
            $error['type'] = 'ok';
            $error['total_product_price'] = $all_order_price;
            $error['order_id'] = $order_id_array;
//             $error['cart_list'] = !empty( $cart_list ) ? $cart_list : false;
            $error['corp_order_info'] = !empty( $corporation_order_info) ? $corporation_order_info: false;
            echo json_encode($error);
            exit();
            
        } 
	}
	

	
	
	//计算运费
	//$product 商品信息
	//$qty 数量
	function freight_count($product,$qty){
	    $freight = 0; //运费
	    
        //计算运费
        if($product['logistics_id']){
            $default_freight =  $product['fitst_freight'];//默认价格
            $default_item =  $product['fitst_number'];//默认数量是多少
            $add_item  =  $product['overflow_number'];//每增加多少件
            $add_freight =  $product['overflow_freight'];//每增加X件+多少钱
             
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
                        $freight = ($num_a*$add_freight) +$default_freight;
                    }
                }
            }else{
                $freight = $default_freight;
            }
        }
        return  $freight;
	}
	

	
	/**
	 * 查询卡包相关的商品
	 */
	function discount_goods(){
	    $package_id = $this->input->post("package_id");//卡包id
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $this->load->model('card_package_mdl');
	    $data = $this->card_package_mdl->discount_goods($package_id,$customer_id);
	    echo json_encode($data);
	}
	
	
	/**
	 * 一次性支付多张订单使用
	 */
	public function All_order_pay() 
	{
	    $order = $this->input->post('order');
	    
	   
	    if( !is_array( $order ) )
	    {
	        $order_id_array = explode(',',$order);
	        
	    }else{ 
	        
	        $order_id_array = array_keys($order);
	    }
	    
	    $pay_passwd = $this->input->post('pass');
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $relation_id = $this->session->userdata ( 'pay_relation' );
	    $error['status'] = 'fail';
	    
	    $data_post['total_price'] = 0;
	    

	    
	    $this->load->model('order_mdl');
	    $this->load->model('customer_corporation_mdl');
	    
	     
	    if( $order_id_array ){

	        //接口-验证支付密码
	        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
	        $pay_info = json_decode($this->curl_get_result($url),true);
	        
	        if($pay_info['pay_passwd'] == md5($pay_passwd) ){
	            
	            //查询订单
	            $order_all = $this->order_mdl->load_orderall( $order_id_array );
	           
	            if( count($order_all) == count( $order_id_array ) )
	            { 
	                
	                $this->db->trans_begin(); //事物执行方法中的MODEL。
        	        
	                //所有订单。
            	    foreach ( $order_all as $k => $v )
            	    { 
            	        $card_row = true;
            	        $sift['set']['order_type'] = 1;
            	        
            	        //判断是否选了储值卡。
//             	        $card_buy_id = !empty( $order[$v['id']]['card_buy_id'] ) ? $order[$v['id']]['card_buy_id'] : 0;
//             	        $card_pay_amount = !empty( $order[$v['id']]['card_pay_amount'] ) ? $order[$v['id']]['card_pay_amount'] : 0;
            	        
            	        
// //             	        //判断如果使用卡，则调用卡支付逻辑。
//             	        if( $card_buy_id && $card_pay_amount > 0 )
//             	        {
//             	            $this->load->model('Savings_card_mdl');
//             	            $v['savings_card_buy_id'] = $card_buy_id;
//             	            $v['card_pay_amount'] = $card_pay_amount;
            	        
//             	            //卡消费逻辑。
//             	            $card_row = $this->Savings_card_mdl->Card_Pay_Order( $v );
            	             
//             	            if( $card_row )
//             	            {
//             	                //默认1：货豆  2：储值卡支付。3：货豆+储值卡
//             	                $sift['set']['order_type'] = $card_pay_amount == $v['total_price'] ? 2 : 3;
//             	            }
            	        
//             	        }
            	       
        	            //改变订单状态
                        $sift['set']['status'] = 4;//改变为支付成功
                        $sift['where']['id'] = $v['id'];
                        $update_order_row = $this->order_mdl->Update( $sift );
        	           
        	            if( $update_order_row && $card_row )//如果更新成功才调用
        	            { 
//         	                if( $sift['set']['order_type'] != 2 )
//         	                {
        	                    //构造调用需要的数据
        	                    $data_post['total_price'] += $v['total_price'];
        	                    $data_post['order_info'][$k]['corp_customer_id'] = $v['corp_customer_id'];
        	                    $data_post['order_info'][$k]['total_price'] = $sift['set']['order_type'] == 3 ? $v['total_price'] - $card_pay_amount : $v['total_price'];
        	                    $data_post['order_info'][$k]['order_sn'] = $v['order_sn'];
        	                    $data_post['order_info'][$k]['app_id'] =  $v['app_id'];
//         	                }
        	               
        	                
        	            }else{ 
        	                
        	                $this->db->trans_rollback();
                            $error['status'] = 'fail';
                            echo json_encode($error);
                            exit();
        	            }
            	            
            	       
            	    }
            	    
            	    //有数据才调用-货豆支付接口。
            	    if( !empty( $data_post )  )
            	    { 
            	        //构造调用需要的数据（一维）
            	        $data_post['relation_id'] = $relation_id;
            	        $data_post['pass'] = $pay_passwd;
            	         
            	        //调用接口
            	        $url = $this->url_prefix.'Order/All_order_pay';
            	         
            	        $error  =  json_decode($this->curl_post_result( $url,$data_post ),true);
            	        
            	    }else if( $order_all )
            	    { 
            	        //有订单数据-接口数据是空的-代表是储值卡支付了。
            	        $error['status'] = 'success';
            	    }
            	    
            	    
            	    if( $error['status'] == 'success')
            	    { 
            	        $error['total_price'] = $data_post['total_price'];
            	        $this->db->trans_commit();
            	        
            	        //更新为不是第一次购买了。
            	        $this->load->model('Customer_mdl');
            	        $this->Customer_mdl->active_account( $customer_id );
            	        
            	    }else{ 
            	        
            	        $this->db->trans_rollback();
            	    }
            	    
        	    }else{
        	        
        	        $error['status'] = 'fail';
        	        echo json_encode($error);
        	        exit();
        	    }
        	   
        	}else{ 
        	    
        	    $error['status'] = 'wrong';
        	    echo json_encode($error);
        	    exit();
        	       	
        	}
    	
	    }else{ 
	        $error['status'] = 'fail';
	        echo json_encode($error);
	        exit();
	    }
	    
	    echo json_encode($error);
	    exit();
	}
	
	//-------------------------------------------------------------------
	
	
	/**
	 * 修改收货地址重新计算订单运费
	 */
	public function change_address(){
	    $regionid = $this->input->post("regionid");//收货地址id
	    $orderinfo = $this->input->post("orderinfo");//订单信息
	    $customerid = $this->session->userdata("user_id");
	    //判断数据是否符合要求
	    if(is_array($orderinfo) && is_numeric($regionid)){
	        $this->load->model('logistics_mdl');
	        foreach($orderinfo as $productid => $val){
                $logDetail = $this->logistics_mdl->SuitedRegion($productid,$customerid,$regionid);
                if($logDetail){
                        $data['freight'][$val['corporation_id']] = $this->freight_count($logDetail,$val['qty']);//计算运费
                        $data['status'] = true;
                }else{
                    error_log($this->db->last_query());
                    $data['status'] = false;
                }
	        }
	    }else{
	        error_log("非法传值：regionid:$regionid,orderinfo:$orderinfo");
	        $data['status'] = false;
	    }
	    echo json_encode($data);//返回值
	}
	
	
// 	/**
// 	 * 审核分成记录中的现金分成或者货豆分成--一一分到用户账户上
// 	 */
// 	public function rebate()
// 	{ 
	    
// 	    //查询order_rebate中的记录
// 	    $this->load->model('Order_rebate_mdl');
// 	    $this->Order_rebate_mdl->id = 223;
// 	    $rebate_info = $this->Order_rebate_mdl->load();
	    
// 	    $return['status'] = false; //默认不存在的状态
	    
// 	    if( $rebate_info )
// 	    {
// 	        //更改状态为审核成功。
//             $row = true;//sql 更新
	        
//             if( $row )
//             {
//                 if( $rebate_info['rebate_type'] == 1)
//                 {
                    
//                     //开互助店的分成-现金
                    
//                     //通过接口调用
//                     $url = $this->url_prefix.'Order_rebate/cash_rebate';
//                     $data_post['data'] = $rebate_info;
//                     var_Dump($this->curl_post_result($url,$data_post));exit;
//                     $return = json_decode($this->curl_post_result($url,$data_post),true);
                    
                    
//                 }else{
                   
//                     //销售的分成-货豆
//                     //通过接口调用
//                     $url = $this->url_prefix.'Order_rebate/M_rebate';
//                     $data_post['data'] = $rebate_info;
                    
//                     var_Dump($this->curl_post_result($url,$data_post));exit;
//                     $return = json_decode($this->curl_post_result($url,$data_post),true);
//                 }
            
//             }
            
//             if( $return['status'] == 1)
//             { 
//                 //分成成功
//                 //更改状态为成功
//                 $this->db->trans_commit();
//                 $result['message'] = 'OK';
//                 return;
//             }//else if //做各种返回状态提示信息 && 回滚 $this->db->trans_rollback();exit;
            
// 	    }else{ 
	        
// 	        //提示不存在
// 	    }
// 	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */