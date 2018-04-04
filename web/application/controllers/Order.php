<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

include_once 'common/uri.php';
class order extends Front_Controller {

	/**
	 * 构造函数
	 */
	public function __construct() {
        
        /**
         * 构造函数
         */
        parent::__construct();
        
        if (strstr($_SERVER['REQUEST_URI'], "item")) {
            
            $url = "/order" . strstr($_SERVER['REQUEST_URI'], "?");
            $this->session->set_userdata("redirect", site_url($url)); // 废除待删除
            $this->session->set_userdata("ref_from_url", site_url($url)); // 统一约定使用ref_from_url参数名，不使用关键词redirect
        } else {
            
            $this->session->set_userdata('ref_from_url', current_url());
        }
        
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
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
            redirect('nofound');
        }
    }

	// -----------------------------------------------------------------------------

	/**
	 * 确认订单
	 * @param number $payment_id
	 */
	public function order_confirm($payment_id = 0)
	{
	    
	    $freight = 0;
	    $this->load->model('cart_mdl');
	    $this->load->model('goods_mdl');
	    // 顾客信息
        $data["item"] = $this->input->get_post("item");
        
        foreach($this->cart->contents() as $items){ //选择了什么商品
            foreach($data["item"] as $i)
            {
                if($items["rowid"] == $i)
                {
                    $array[] = $items;
                }
            }
        }
        
        
        $item = array();
        foreach($array as $k=>$v){ //处理相同商品ID就叠加数量
            if(!isset($item[$v['product_id']])){
                $item[$v['product_id']]= $v;
            }else{
                $item[$v['product_id']]['qty']+=$v['qty'];
            }
        }
        
//         echo '<pre>';
//         var_Dump($item);
        
        foreach ($item as $v){ //统计每个商品的运费
            $product = $this->goods_mdl->get_by_id($v['product_id']);
            $freight += $this->freight_count($product,$v['qty']);
        }
        $data['freight'] = $freight;
        
        // 收货地址
        $this->load->model('customer_address_mdl');
        $data['address'] = $this->customer_address_mdl->load_all($this->session->userdata('user_id'));
        
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
	 * 完成所有订单操作，提交到数据库
	 * 旧的
	 */
	public function save_ago() {
        
		/* 接收表单数据 */
		$item = $this->input->post('item');
		$customer_remark = $this->input->post('customer_remark');

		$address_id = $this->input->post ( 'address_id' );
		$this->load->library ( 'cart' );
        if($item!=null&&$address_id!=null){
    		$itemarray = array();
    		$product_fee = 0;
    		$ok = true;
    		foreach ( $this->cart->contents () as $items ) {
    			foreach($item as $i)
    			{
    				if($items["rowid"] == $i)
    				{
    				    $product_id = substr($items["id"],0,-2);
    				    
    				    if($items["sku_id"] > 0){
    				        $this->load->model("product_sku_mdl");
                            $p_array = $this->product_sku_mdl->getSKUValue($items["sku_id"]);//sku
    				    }else{
    				        $this->load->model("product_mdl");
    				        $p_array = $this->product_mdl->load($product_id,$this->session->userdata('app_info')['id']);//商品
    				        //检测特价有效值
				            $product_special = $this->product_mdl->load_special($product_id)[0];

    				    }
    				    //实时检查库存
    				    if($items['qty']>$p_array['stock']){
    				         echo '<script type="text/javascript">alert("库存不足！");location.href="'.site_url("goods/detail/$product_id").'"</script>';
    				         exit;
    				         break;
    				    }
    				    if(isset($product_special)){
    				        //实时检查限时优惠
    				        if( count($product_special) ==  0  ||  $product_special['special_price_start_at'] > date("Y-m-d H:i:s") || $product_special['special_price_end_at'] < date("Y-m-d H:i:s")){
                                    $this->load->model ( 'cart_mdl' );
    				                //删除购物车
    				                $cart = array(
                                        'rowid' => $items['rowid'],
                                        'qty' => 0
    				                );
    				            
    				                $this->cart_mdl->deleteCart($items['cid'],$this->session->userdata ( 'user_id' ));
    				            
    				                $this->cart->update ( $cart );
    				            echo '<script type="text/javascript">alert("特价商品已下架！");location.href="'.site_url("goods/detail/$product_id").'"</script>';
        				        exit;
        				        break;
        				    }
    				    }
    					array_push($itemarray,array("product_id"=>explode("_",$items ['id'])[0],"product_name"=>$items ['name'],"qty"=>$items["qty"],"price"=>$items["price"],"sky_id"=>$items ['sku_id'],"rowid"=>$items["rowid"],"cid"=>$items['cid'],"corporation_id"=>$items['corporation_id']));
    					$product_fee = $product_fee+$items["price"]*$items["qty"];
    				}
    			}
    		}
            
            if($ok){
    		//$product_fee = $this->cart->total ();
    		$shipping_fee = 0;

    	    //判断余额是否足够　
    		$this->load->model ( 'customer_mdl' );
    		$customer = $this->customer_mdl->load($this->session->userdata ( 'user_id' ));
            $customer_id = $this->session->userdata ( 'user_id' );

    		error_log ( "post payment id:" . $this->input->post ( 'payment_id', TRUE ) );

    		/* 插入新订单信息 */
    		$this->load->model ( 'order_mdl' );
    		$this->order_mdl->customer_id = $customer_id;
    		$this->order_mdl->payment_id = $this->input->post ( 'payment_id' ) == NULL ? 2 : $this->input->post ( 'payment_id' ); // $payment_id;
    		$this->order_mdl->shipping_id = 0; // $shipping_id;
    		$this->order_mdl->total_product_price = $product_fee;
    		$this->order_mdl->auto_freight_fee = $shipping_fee;
    		$this->order_mdl->total_price = $product_fee + $shipping_fee;
    		/*if($customer != null && $customer["credit"]>=($product_fee + $shipping_fee))
    		{
    			$this->order_mdl->status = 4;
    			$this->order_mdl->alreadly_pay = ($product_fee + $shipping_fee);
    		}else
    		{*/
    		//}
    		$this->load->model ( 'customer_corporation_mdl' );
    		$_corporation = $this->customer_corporation_mdl->corp_load($items['corporation_id']);
    		if($_corporation['auto_order_amount'] >= $product_fee){
    		    $status = 2;
    		    $this->order_mdl->status = 2;
    		}else{
    		    $status = 1;
    			$this->order_mdl->status = 1;
    		}
    			    
    		if(isset($customer_remark))
                $this->order_mdl->customer_remark = $customer_remark;
            $corporation_id = 0;
            foreach ($itemarray as $ii){
                $corporation_id = $ii['corporation_id'];
            }
            $this->order_mdl->corporation_id = $corporation_id;

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

    		/*if($customer != null && $customer["credit"]>=($product_fee + $shipping_fee))
    		{
    			//支付
    			$this->customer_mdl->update_Credit($this->session->userdata ( 'user_id' ),($product_fee + $shipping_fee));

    		}*/



    		/* 插入订单商品 */
    		$this->load->model ( 'order_item_mdl' );
            $this->load->model ( 'cart_mdl' );
            
    		foreach ( $itemarray as $items ) {

    			$this->order_item_mdl->order_id = $new_order_id;
    			$this->order_item_mdl->product_id = $items ['product_id'];
    			$this->order_item_mdl->product_name = $items ['product_name'];
    			$this->order_item_mdl->quantity = $items ['qty'];
    			$this->order_item_mdl->price = $items ['price'];
    			$this->order_item_mdl->sku_id = $items ['sky_id']==null || $items ['sky_id']==''?0:$items ['sky_id'];
    			$this->order_item_mdl->weight = 0; // $items['options']['weight'];
    			$res = $this->order_item_mdl->create ();
    			//删除购物车
    			$data = array (
    				'rowid' => $items['rowid'],
    				'qty' => 0
    			);

    			$this->cart_mdl->deleteCart($items['cid'],$customer_id);

    			$this->cart->update ( $data );
    			//更改商品库存
    			
    			if($res){
    			    if($items['sky_id']!=null)
    			    {
    			        $this->load->model('product_sku_mdl');
    			        $condition = array("id"=>$items["sky_id"],"qty"=>$items["qty"]);    			        
    			        $this->product_sku_mdl->update_value_stock($condition);
    			        $this->load->model('product_mdl');
    			        $this->product_mdl->update_stock($items['product_id'],$items['qty']);
    			    }
                    else
    			    {
        			    $this->load->model('product_mdl');
        			    $this->product_mdl->update_stock($items['product_id'],$items['qty']);
    			    }
    			}

    		}
    		/* 插入收货人信息 */
    		$this->load->model ( 'customer_address_mdl' );
    		$address = $this->customer_address_mdl->load_by_customer ( $address_id, $this->session->userdata ( 'user_id' ) );
    		
    		$this->load->model ( 'order_delivery_mdl' );
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
            
    		/*if($customer != null && $customer["credit"]>=($product_fee + $shipping_fee))
    		{
    			$data["errorcode"] = 0;
    			$data["message"] = "订单完成！";
    			$data["order_id"] = $new_order_id;

    		}else
    		{*/

    		//}
            redirect('order/orderfinish?new_order_id='.$new_order_id.'&status='.$status);
            }else{
               $data['url'] = site_url('cart');
               $this->load->view("redirect_view", $data);
               return;
            }
        }else{
            redirect("member/address/add?path=".site_url('cart'));
        }

		/* 清空购物车 */
		//$this->cart->destroy ();

		// 跳转至选择支付方式
		//redirect ( 'order/order_pay/' . $new_order_id );
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

	/**
	 * 支付返回
	 *
	 * @param number $order_sn
	 * @param number $status
	 */
	public function after_pay($order_sn = 0, $status = 2) {
		$data = array ();
		// 是否支付成功
		if ($status == 1) {
			$user_id   = $this->session->userdata ( 'user_id' );
			$parent_id = $this->session->userdata ( 'parent_id' );
			// 判定是否有介绍人
			if ($parent_id != 0) {
				$this->load->model ( "customer_mdl", "customer" );
				$pre_parent_id = $this->customer->get_parent ( $user_id );
				// 如果之前没有人介绍过，把他变成介绍人的下线
				if (( int ) $pre_parent_id === 0 && $user_id != $parent_id) {
					$this->customer->update_parent ( $user_id, $parent_id );
					$this->session->unset_userdata ( 'parent_id' );
				}
			}

			$this->load->model ( "customer_mdl" );

			$this->customer_mdl->active_account ( $this->session->userdata ( 'user_id' ) );

			// 修改订单状态为已支付
			$this->load->model ( "order_mdl", "order" );
			$this->order->order_paid ( $order_sn );

			// 读取订单内容
			$data ['order'] = $this->order->load_by_sn ( $order_sn );

			$order_log = $this->order->get_order_log ( $data ['order'] ['id'], 3 );

			$data ['pay_date'] = $order_log ['log_date'];

			$data ["title"] = "支付成功";
		}

		if ($status == 2) {
			$this->load->model ( "order_mdl", "order" );

			// 读取订单内容
			$data ['order'] = $this->order->load_by_sn ( $order_sn );

			$data ["title"] = "支付取消";
		}

		if ($status == 3) {
			$this->load->model ( "order_mdl", "order" );

			// 读取订单内容
			$data ['order'] = $this->order->load_by_sn ( $order_sn );
			$data ["title"] = "支付失败";
		}
		$data ['status'] = $status;
		$data ['head_set'] = 2;
		$data ['foot_set'] = 1;
        $data['back'] = 'member/order';

		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'payment/afterpay_status_view', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}

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
	    $status = false;
	    $order_id = $this->input->post('id');
	    $pay_passwd = md5($this->input->post('pass') );
	    $customer_id = $this->session->userdata ( 'user_id' );
	    
	    $this->load->model('order_mdl');
	    
	    //判断订单是否正确
	    $is_order = $this->order_mdl->is_customer_order($order_id,2,$customer_id);
	    
	    if($is_order){
	        $this->load->model ( 'pay_account_mdl' );
	        $this->load->model('customer_corporation_mdl');
	        $this->load->model("customer_currency_log_mdl",'customer_currency_log');
            
            //支付账号
	        $customer_pay  = $this->pay_account_mdl->load( $this->session->userdata ( 'user_id' ) );

	        $pay_account_id = $customer_pay['id'];//支付账号ID
	        $pay_relation_id = $customer_pay['r_id']; //关联表的ID
	        $surplus_m = $customer_pay['M_credit']; //支付前的M券余额
	        $credit = '0.00'; //授信
	        $time = date('Y-m-d H:i:s');
	        if($customer_pay['credit_start_time'] <= $time && $customer_pay['credit_end_time'] >= $time){ 
	            $credit = $customer_pay['credit'];
	        }
	           
	        //获取该店主信息
	        $corp_customer = $this->customer_corporation_mdl->corp_load($is_order['corporation_id']);

	        //上一次M券交易的日志中的信息
	        $last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
	        
	        $corp_customer_id = $corp_customer['customer_id'];//店主的用户ID
	        
	        
	           //验证支付密码是否正确
	           if($customer_pay['pay_passwd'] != null && $customer_pay['pay_passwd'] == $pay_passwd ){

	               //判断M卷余额和是否足够　
        	        if($customer_pay != null && ($customer_pay["M_credit"]+$credit) >= $is_order['total_price'] )
        	        {
        	            $this->db->trans_begin(); //事物执行方法中的MODEL。
        	            //扣M券
        	            $row = $this->pay_account_mdl->update_M_creadit($pay_account_id, $is_order['total_price']);
        	            
        	            //改状态
        	            $up_status = $this->order_mdl->update_order_status($order_id, 4);
        	            
        	            //检测M券是否异常
        	            if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $surplus_m){
        	                $M_credit_data['status'] = '1';
        	            }else if(!$last_m_log && $surplus_m =='0'){
        	                $M_credit_data['status'] = '1';
        	            }else{
        	                $M_credit_data['status'] = '2';
        	            }
        	            
        	            //M券日志
        	            $M_credit_data['relation_id'] = $pay_relation_id;
        	            $M_credit_data['id_event'] = '60';
        	            $M_credit_data['remark'] = '购物支出';
        	            $M_credit_data['amount'] = $is_order['total_price'];
        	            $M_credit_data['order_no'] = $is_order['order_sn'];
        	            $M_credit_data['type'] = '2';
        	            $M_credit_data['beginning_balance'] = $surplus_m;
        	            $M_credit_data['ending_balance'] = $surplus_m-$is_order['total_price'];
        	            $M_credit_data['customer_id'] = $corp_customer_id;
        	            $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
        	            
        	            //上一次平台的M券交易日志
        	            $to_last_m_log    = $this->customer_currency_log->load_last('-1');
        	            
        	            //支出方M券日志
        	            $M_credit_data['remark'] = '平台收入';
        	            $M_credit_data['relation_id'] = '-1';
        	            $M_credit_data['type'] = '1';
        	            $M_credit_data['status'] = '1';
        	            $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';
        	            $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance']+$is_order['total_price']:$is_order['total_price'] ;
        	            $M_credit_data['customer_id'] = $customer_id;
        	            //收入方M券日志
        	            $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
        	            
        	            
//         	            if ($this->db->trans_status() === FALSE) {
//         	                $this->db->trans_rollback();
//         	                echo json_encode(5);
//         	                exit;
//         	            }
        	            
        	            if ($row && $up_status && $M_credit_log && $to_M_credit_log) {
        	                $this->db->trans_commit();
        	                $status = 1;//支付成功
        	            } else {
        	                $this->db->trans_rollback();
        	                $status = 5;//支付失败
        	            }
        	            
        	        }else{

        	           //'余额不足';
        	           $status = 4;
        	        }
	           }else{
	               //支付密码错误
	               $status = 3;
	           }
	    }else{
	        //'错误订单'
	       $status = 2;
	    }

	    echo json_encode($status);
	}
	
	// ---------------------------------------------------------------------------
	
	/**
	 * 订单支付成功回调页面
	 */
    public function payfinish() {
        
        $data["order_id"] = $this->input->get_post('new_order_id');
        $data["order_status"] = $this->input->get_post('order_status');

        $this->load->model ('order_mdl');
        $order_info = $this->order_mdl->is_customer_order( $data["order_id"],$data["order_status"],$this->session->userdata("user_id"));
        
        if(count($order_info)!=0){
            $data['pay_account'] = $order_info['total_price'];
            $data['order_sn'] = $order_info['order_sn'];
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
	
	// ---------------------------------------------------------------------------
	
	/**
	 * 需要支付的订单信息
	 */
	public function order_message(){
	    $order_id = $this->input->post('o_id');
	    $this->load->model('order_mdl');
	    $order_message = $this->order_mdl->order_message($order_id);
	    echo json_encode($order_message);
	}


	/**
	 * 验证支付密码 并收货
	 */
	public function receive(){
	   
	    $status = false;
	    $pass = $this->input->post('pass');
	    $order_id = $this->input->post('id');
	    $customer_id = $this->session->userdata ( 'user_id' );
	    
	    $this->load->model ('order_mdl');
	    $order = $this->order_mdl->is_customer_order($order_id, 6, $customer_id);
	    

	    //判断传过来的是否是该商家的订单ID并且是正确的状态
        if( $order ){
            $this->load->model ( 'pay_account_mdl' );
            $this->load->model('customer_corporation_mdl');
            $this->load->model("customer_currency_log_mdl",'customer_currency_log');
            
            //获取该店信息
            $corp_customer = $this->customer_corporation_mdl->corp_load($order['corporation_id']);
            
            //店主的用户ID
            $corp_customer_id = $corp_customer['customer_id'];
            
            //支付账号
            $customer_pay = $this->pay_account_mdl->load( $customer_id );
            
            //店主的支付账号
            $corp_customer_pay = $this->pay_account_mdl->load( $corp_customer_id );
           
            //店主支付账号ID
            $corp_pay_id = $corp_customer_pay['id'];
            
            //店主关联支付账号表的ID
            $pay_relation_id = $corp_customer_pay['r_id'];
            
            //收货前店主剩余的M券
            $corp_surplus_m = $corp_customer_pay['M_credit'];
            
            if($customer_pay['pay_passwd'] != null && $customer_pay['pay_passwd'] == md5($pass) ){
    	        //开启事物
    	        $this->db->trans_begin(); //事物执行方法中的MODEL。
    	        
    	        //执行分成
    	        $order_rebate = $this->order_rebate($order,$corp_customer_pay);
    	        
    	        if($order_rebate === 2){ //店主余额不足以扣除分成 
    	            
    	            $row = $this->order_mdl->update_order_status($order_id, 7);
    	            if($row) 
    	               $this->db->trans_commit();
    	               echo json_encode(1);
    	               exit;
    	        }
    	        
                //执行收货-改状态
    	        $row = $this->order_mdl->update_order_status($order_id, 9);
    	        
    	        //上一次店主M券交易的日志中的信息
    	        $last_m_log = $this->customer_currency_log->load_last($pay_relation_id);
    	        
    	        //店主账号+M券
    	        $up_row = $this->pay_account_mdl->charge_M_credit($corp_pay_id, $order['total_price'] );
    	        
    	        //上一次平台的M券交易日志
    	        $to_last_m_log    = $this->customer_currency_log->load_last('-1');
    	        
    	        //平台支出M券日志
    	        $M_credit_data['relation_id'] = '-1';
    	        $M_credit_data['id_event'] = '62';
    	        $M_credit_data['remark'] = '平台支出';
    	        $M_credit_data['type'] = '2';
    	        $M_credit_data['amount'] = $order['total_price'];
    	        $M_credit_data['order_no'] = $order['order_sn'];
    	        $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';;
    	        $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance']-$order['total_price']: -$order['total_price'] ;
    	        $M_credit_data['customer_id'] = $corp_customer_id;
    	        $M_credit_data['status'] = '1';
    	        
    	        //支出方M券日志
    	        $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
    	        
    	        
    	        //收入检测M券是否异常
    	        if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $corp_surplus_m){
    	            $M_credit_data['status'] = '1';
    	        }else if(!$last_m_log && $corp_surplus_m =='0'){
    	            $M_credit_data['status'] = '1';
    	        }else{
    	            $M_credit_data['status'] = '2';
    	        }
    	        
    	        //店主收入M券日志
    	        $M_credit_data['relation_id'] = $pay_relation_id;
    	        $M_credit_data['id_event'] = '62';
    	        $M_credit_data['remark'] = '销售收入';
    	        $M_credit_data['type'] = '1';
    	        $M_credit_data['amount'] = $order['total_price'];
    	        $M_credit_data['order_no'] = $order['order_sn'];
    	        $M_credit_data['beginning_balance'] = $corp_surplus_m;
    	        $M_credit_data['ending_balance'] = $corp_surplus_m+$order['total_price'];
    	        $M_credit_data['customer_id'] = $customer_id;
    	         
    	         
    	        //写入M券日志
    	        $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
    	        
                
          
                if($row && $up_row && $M_credit_log && $to_M_credit_log && $order_rebate  ){ 
                    $this->db->trans_commit(); //提交事物
                    $status = 1;
                }else { 
                    $this->db->trans_rollback(); //事物回滚
                }
                     
    	    }else{
    	         $status = 3; //密码错误
    	    }
        }else{
            $status = 2; //订单错误
        }
        //$status = 1;
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
	    $this->load->model ( 'pay_account_mdl' );
	    $result = $this->pay_account_mdl->load($customer_id);
	    
	    if( $result['pay_passwd'] != ''){
	        $is_pay = true;
	    }

	    echo $is_pay;
	}

	/**
	 * 分成系统
	 * @$order_detaile = 订单详情;
	 * @$corp_customer_pay = 店主的支付账号信息;
	 */
	public function order_rebate( $order_detaile, $corp_customer_pay ){
	   
	    
	    $this->load->model('rebate_mdl');
	    $this->load->model('customer_mdl');
	    $this->load->model('platform_rebate_mdl');
	    $this->load->model('order_rebate_mdl');
	    $this->load->model("customer_money_log_mdl",'customer_money_log');
	    if( $order_detaile ){ 
	        //店主信息
	        $corp_detaile = $this->customer_corporation_mdl->getById($order_detaile['corporation_id']);

	        //订单商品总价 
	        $total_price = $order_detaile['total_price'];
            $order_id = $order_detaile['id'];//订单ID    	       
	        $app_id = $corp_detaile['app_id'];//店主分站id
	        $agent_id = $corp_detaile['agent_id'];//合伙人id
	        $customer_id = $corp_detaile['customer_id'];//店主的用户ID;
	        $corp_id  = $order_detaile['corporation_id'];//店铺ID
            $cash = $corp_customer_pay['cash']; //店主的现金余额
            $pay_id = $corp_customer_pay['id']; //店主支付账号的ID
            $pay_relation_id = $corp_customer_pay['r_id'];//关联支付表的ID
	        //查询店主的用户信息;
	        $customer_detaile = $this->customer_mdl->load($customer_id);
	        
	        //获取上级id
	        $parent_id = $customer_detaile['parent_id']; 
	        
	        //查询需要分成的百分比
	        $ratio = $this->rebate_mdl->load("'$app_id'");
	        
	        if(!$ratio){
	            return true; //如果没有比率就不执行了。没设置分个毛阿
	        }
	        
	        if($total_price < '0.5'){ //订单小于0.5元不分成了
	            return true;
	        }
	        //购物分成比例-
// 	        $order_ration = $ratio['rate'];

	        //2016-09-20；改成读customer_corporation表的分成率;
	        $order_ration = $corp_detaile['commission_rate'];
	        
	        //可以分成的总额
	        $retio_price = $total_price*$order_ration/100;
	        
	        //处理可以分成的总额
	        $retio_price = is_float($retio_price) ? substr_replace($retio_price, '', strpos($retio_price, '.') + 3) : $retio_price;
	        
	        if($cash < $retio_price){ //店主不足以扣除
	            return 2;
	        }
            
	        //扣店主分成现金的金额
	        $update_cash = $this->pay_account_mdl->update_cash($pay_id, $retio_price);
	        
	        //上一次现金交易的日志中的信息
	        $last_cash_log = $this->customer_money_log->load_create_desc($pay_relation_id);//现金日志
	        
	        //上一次平台现金交易的日志中的信息
	        $to_last_cash_log = $this->customer_money_log->load_create_desc('-1');
	        
	        //检测现金是否异常
	        if( isset($last_cash_log['ending_balance']) &&  $last_cash_log['ending_balance'] == $cash){
	            $cash_data['status'] = '1';
	        }else if(!$last_cash_log && $cash =='0'){
	            $cash_data['status'] = '1';
	        }else{
	            $cash_data['status'] = '2';
	        }
	        //现金支出日志
	        $cash_data['relation_id'] = $pay_relation_id;
	        $cash_data['id_event'] = '76';
	        $cash_data['type'] = '2';
	        $cash_data['remark'] = '手续费扣款';
	        $cash_data['cash'] = $retio_price;
	        $cash_data['charge_no'] = $order_detaile['order_sn'];
	        $cash_data['beginning_balance'] = $cash;
	        $cash_data['ending_balance'] = $cash-$retio_price;
	        $cash_data['customer_id'] = '-1';
	        //写入现金日志
	        $cash_log = $this->customer_money_log->add_log($cash_data);
	        
	        
	        //平台现金收入日志
	        $cash_data['relation_id'] = '-1';
	        $cash_data['type'] = '1';
	        $cash_data['status'] = '1';
	        $cash_data['remark'] = '平台收入-手续费扣款';
	        $cash_data['beginning_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] : '0.00';
	        $cash_data['ending_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance']+$retio_price:$retio_price;
	        $cash_data['customer_id'] = $customer_id;
	        //写入现金日志
	        $to_cash_log = $this->customer_money_log->add_log($cash_data);
	        
	        
	        //如果有上级单独处理
	        if($parent_id){
    	        
    	        $parent = $ratio['rebate4'] ;
    	        //计算上级分成
    	        $parent_price = is_float($retio_price*$parent/100) ? substr_replace($retio_price*$parent/100, '', strpos($retio_price*$parent/100, '.') + 3) : $retio_price*$parent/100;
    	        
    	           //执行上级的插入金额事件 //目前只有一级
    	            $parent_data = array(
    	                'orderid' => $order_id,
    	                'rebate'  => $parent_price,
    	                'parent_id' => $parent_id,
    	                'total_price' => $retio_price,
    	                'rebaterate' => $parent/100,
    	                'customerid' => $customer_id
    	            );
    	            
    	            $order_rebate_id = $this->order_rebate_mdl->add($parent_data);//上级的分成
    	            $retio_price = $retio_price - $parent_price;//上级分完了剩下的总额
    	            
    	            if(!$order_rebate_id)
    	                return false;
    	        
	        }
	        //rebate1 = 51易货网分成比例; rebate2 = //分站点分成比例 rebate3 = //合伙人分成比例 rebate4 = //上级分成比例
	        $data = array( 
	           'rebate2' =>array(
	               'rebate' => $ratio['rebate2'],
	               'obj_type' => 2,
	               'obj_id' => $app_id
	           ),
	           'rebate3' =>array(
	               'rebate' => $ratio['rebate3'],
	               'obj_type' =>  3,
	               'obj_id'  => $agent_id
	           ),
	        );

	        //处理合伙人 分站点
	        $result = $this->order_ratio($data,$retio_price);
	        
	        //2个人分成多少钱。
	        $total_retio_price = '';
	        
	        foreach ($result as $v){
	            $total_retio_price += $v['rebate']; //统计2个人合伙人 分站点分成多少钱。
	        }
	        
	        $result['rebate1'] =array( //剩余全给易货网
	            'rebate' => $retio_price-$total_retio_price,
	            'rebate_rate' => $ratio['rebate1']/100,
	            'obj_type' => 1,
	            'obj_id' => '0',
	        );

	        foreach ($result as $v){
	            
	            //执行除了上级的插入金额事件
	            $is_ok[] = $this->platform_rebate_mdl->add($v,$retio_price,$order_id,$corp_id,2); //执行插入每个人的分成金额
	             
	        }
	        
	        //判断是否成功的执行了插入数据条数
	        if(count($is_ok) >= count($result) && $update_cash && $cash_log && $to_cash_log){ 
	            return 1;
	        }else{ 
	            return false;
	        }
	    }
	}
	
	/**
	 * 处理分成的方法
	 * @$data = 需要分成的比例 次数
	 * @$retio_price 分成总金额 /
	 * @
	 */
	public function order_ratio( $data=array(), $retio_price ){ 
	    
	    foreach ($data as $k => $v){ 
	        $array[$k]['rebate'] = is_float($retio_price*$v['rebate']/100) ? substr_replace($retio_price*$v['rebate']/100, '', strpos($retio_price*$v['rebate']/100, '.') + 3) : $retio_price*$v['rebate']/100;
	        $array[$k]['rebate_rate']   = $data[$k]['rebate']/100;  
	        $array[$k]['obj_type'] = $data[$k]['obj_type']; 
	        $array[$k]['obj_id']  = $data[$k]['obj_id'];
	    }
	    return $array;
	}
	
	/**
	 * 店主执行订单分成使用
	 */
	public function carry_rebate( ){ 
	    $order_id = $this->input->post('order_id');
	    $pass = $this->input->post('pass');
	    
	    $this->load->model('order_mdl');
	    $corporation_id = $this->session->userdata['corporation_id'];
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $order = $this->order_mdl->is_corp_order($order_id,7,$corporation_id); //如果是未提取的状态才执行
	    
	    if($order){ 
	        $this->load->model ( 'pay_account_mdl' );
            $customer_pay = $this->pay_account_mdl->load( $customer_id );

            if($customer_pay['pay_passwd'] != md5($pass) ){ 
                echo json_encode(4);//密码错误
                return ;
            }
            $this->db->trans_begin(); //事物执行方法中的MODEL。
            //执行分成
            $this->load->model('customer_corporation_mdl');
            $order_rebate = $this->order_rebate($order,$customer_pay);
            
            if($order_rebate === 2){ 
                echo json_encode(2);//钱还是不够分
                return ;
            }
            
            $pay_relation_id = $customer_pay['r_id']; //店主支付账户关联ID
            
            $pay_id = $customer_pay['id']; //店主账户ID
            
            //执行-改状态
	        $row = $this->order_mdl->update_order_status($order_id, 9);
	        $this->load->model("customer_currency_log_mdl",'customer_currency_log');
	        
	        //上一次店主M券交易的日志中的信息
	        $last_m_log = $this->customer_currency_log->load_last($pay_relation_id);
	        
	        //店主账号+M券
	        $up_row = $this->pay_account_mdl->charge_M_credit($pay_id, $order['total_price'] );
	        
	        //上一次平台的M券交易日志
	        $to_last_m_log    = $this->customer_currency_log->load_last('-1');
	        
	        //平台支出M券日志
	        $M_credit_data['relation_id'] = '-1';
	        $M_credit_data['id_event'] = '62';
	        $M_credit_data['remark'] = '平台支出';
	        $M_credit_data['type'] = '2';
	        $M_credit_data['amount'] = $order['total_price'];
	        $M_credit_data['order_no'] = $order['order_sn'];
	        $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';;
	        $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance']-$order['total_price']: -$order['total_price'] ;
	        $M_credit_data['customer_id'] = $customer_id;
	        $M_credit_data['status'] = '1';
	        //支出方M券日志
	        $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
	        
	        
	        //收入检测M券是否异常
	        if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $customer_pay['M_credit']){
	            $M_credit_data['status'] = '1';
	        }else if(!$last_m_log && $customer_pay['M_credit'] =='0'){
	            $M_credit_data['status'] = '1';
	        }else{
	            $M_credit_data['status'] = '2';
	        }
	        
	        //店主收入M券日志
	        $M_credit_data['relation_id'] = $pay_relation_id;
	        $M_credit_data['id_event'] = '62';
	        $M_credit_data['remark'] = '销售收入';
	        $M_credit_data['type'] = '1';
	        $M_credit_data['amount'] = $order['total_price'];
	        $M_credit_data['order_no'] = $order['order_sn'];
	        $M_credit_data['beginning_balance'] = $customer_pay['M_credit'];
	        $M_credit_data['ending_balance'] = $customer_pay['M_credit']+$order['total_price'];
	        $M_credit_data['customer_id'] = $order['customer_id'];
	         
	         
	        //写入M券日志
	        $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
	        
	        if($row && $up_row && $M_credit_log && $to_M_credit_log && $order_rebate  ){
	            $this->db->trans_commit(); //提交事物
	            $status = 1;
	        }else {
	            $this->db->trans_rollback(); //事物回滚
	            $status = false;
	        }
	  
	    }else{ 
	        $status = 3;//订单错误
	    }
	    echo json_encode($status);
	}
	
	/**
	 * 提取M券订单的信息
	 */
	public function load_pay_order(){ 
	    $order_id = $this->input->post('order_id');
	    $this->load->model('order_mdl');
	    $this->load->model('rebate_mdl');
	    $this->load->model ( 'pay_account_mdl' );
	    $corporation_id = $this->session->userdata['corporation_id'];
	    $app_id = $this->session->userdata('app_info')['id'];
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $order = $this->order_mdl->is_corp_order($order_id,7,$corporation_id); //如果是未提取的状态才执行
	    if($order){ 
	        //查询需要分成的百分比
	        $ratio = $this->rebate_mdl->load("'$app_id'");
	         
	         
	        //购物分成比例
// 	        $order_ration = $ratio['rate'];

	        //2016-09-20；改成读customer_corporation表的分成率;
	        $order_ration = $corp_detaile['commission_rate'];
	        
	        //可以分成的总额
	        $retio_price = $order['total_price']*$order_ration/100;
	         
	        //处理可以分成的总额
	        $retio_price = is_float($retio_price) ? substr_replace($retio_price, '', strpos($retio_price, '.') + 3) : $retio_price;
	        
	        //支付账号
	        $corp_customer_pay = $this->pay_account_mdl->load( $customer_id );
	        
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
	    $item = $this->input->post('item');
	    $customer_remark = $this->input->post('customer_remark');
	    $status = $this->input->post('status');
	    $address_id = $this->input->post ( 'address_id' );
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $this->load->model("product_mdl");
	    $this->load->library ( 'cart' );
	    $product_id_array = array();
	    $result['stock'] = array();
	    $result['special_end'] = array();
        $a = 0;//此订单存在下架商品即改变1
        
	    if($item!=null&&$address_id!=null){
	        $itemarray = array();
	        $product_fee = 0;
	        $ok = true;
	        foreach ( $this->cart->contents () as $items ) {
	            foreach($item as $i)
	            {
	                $del = 0;//判断当前商品有没有下架使用
	                if($items["rowid"] == $i)
	                {
	                    
// 	                    echo '<pre>';
// 	                    var_Dump($items);
	                    $product_id = explode('_',$items["id"])[0];//获取商品id
	                    
	                    //查询商品信息
	                    $product = $this->product_mdl->product_info($product_id);
	                    $items['is_freight'] = $product['is_freight']; //商品是否设置了运费
	                    
	                    $array[] = $items; //选择的商品
	                    //商品下架或者删除执行
	                    if(!$product){
	                        $this->load->model ( 'cart_mdl' );
	                        //删除购物车
	                        $data = array (
	                            'rowid' => $items['rowid'],
	                            'qty' => 0
	                        );
	                        $del = $this->cart_mdl->deleteCart($items['cid'],$customer_id);
	                        $this->cart->update ( $data );
	                        
                            $a = 1;
// 	                        array_push($result['stock'],$rows);//超过库存
	                    }
	                    //如果此商品是下架不执行
	                    if(empty($del)){
	                     
	                    //如果是sku商品执行
	                    if($items["sku_id"] > 0){
	                        $this->load->model("product_sku_mdl");

	                        $p_array = $this->product_sku_mdl->getSKUValue($items["sku_id"]);//sku
	                        $p_array['is_special_price'] = $product['is_special_price'];//商品是否特价-写进SKU
	                        $p_array['special_price_start_at'] = $product['special_price_start_at'];
	                        $p_array['special_price_end_at'] = $product['special_price_end_at'];
	                        

	                    }else{//普通商品执行
	                        
	                        $p_array = $this->product_mdl->product_info($product_id);//商品
	                    }
	                    //实时检查库存
	                    if($items['qty']>$p_array['stock']){
	                        //更新session购物车价格，数量
	                        $data = array(
	                            'rowid'  => $items['rowid'],
	                            'qty'    => $p_array['stock'],
	                        );
	                        $this->cart->update($data);
	                        
	                        
	                        $result = array(
	                            'type' => 'stock',
	                            'p_name' => $items["name"]
	                        );
	                        echo json_encode($result);
	                        exit;
// 	                        array_push($result['stock'],$rows);//超过库存
	                    }

	                    
	                        
	                        //实时检查特价是否过期
	                        if( $p_array['special_price_end_at'] < date("Y-m-d H:i:s") && !$status && isset($items['is_special_price']) ){
                                
 
				                //更新数据库购物车价格
                                $this->load->model ( 'cart_mdl' );
                                
                                $items["sku_id"] > 0 ? $data = array ( 'price' => $p_array['m_price'] ) :  $data = array ( 'price' => $p_array['vip_price'] );
                                
    			                $this->cart_mdl->updateCart($items['cid'],$customer_id,$data);
    			                

    			                //更新session购物车价格，数量
                                $cart = $this->session->userdata('cart_contents');
                                $cart["{$items['rowid']}"]['price'] = $items["sku_id"] > 0 ? $p_array['m_price'] : $p_array['vip_price'];
                                $cart["{$items['rowid']}"]['stock'] = $p_array['stock'];
                                $this->session->set_userdata('cart_contents',$cart);

                                $rows = array(
                                    'type' => 'stale',
                                    'p_name' => $items["name"],
                                    
                                );
                                array_push($product_id_array,$product_id);
//                                 var_dump($items["sku_id"]);
                                $rows['price'] = $items["sku_id"]  > 0 ? $p_array['m_price'] : $p_array['vip_price'];
//                                 echo json_encode($result); exit;//特价过期
                                array_push($result['special_end'],$rows);
                                
	                        }
	                         
	                        //实时检查是否有特价 - 有特价执行
	                        if( $p_array['special_price_end_at'] > date("Y-m-d H:i:s") && $p_array['special_price_start_at'] < date("Y-m-d H:i:s") ){
	                            
	                            if($items['price'] !=  ($items["sku_id"]  > 0 ? $p_array['special_offer'] : $p_array['special_price']) ){
                
    	                            //更新数据库购物车价格
    	                            $this->load->model ( 'cart_mdl' );
    	                            $items["sku_id"]  > 0 ? $data = array ('price' => $p_array['special_offer'] ) : $data = array ('price' => $p_array['special_price'] );
    	                            
    	                            $this->cart_mdl->updateCart($items['cid'],$customer_id,$data);
                        
    	                            //更新session购物车价格，数量
    	                            $cart = $this->session->userdata('cart_contents');
    	                            $cart["{$items['rowid']}"]['price'] = $items["sku_id"]  > 0 ? $p_array['special_offer'] : $p_array['special_price'];
    	                            $cart["{$items['rowid']}"]['stock'] = $p_array['stock'];
    	                            $this->session->set_userdata('cart_contents',$cart);
    	                            
    	                            $items["price"] = $items["sku_id"]  > 0 ? $p_array['special_offer'] : $p_array['special_price'];
	                           }
	                        }
	                    
	                   
	                    array_push($itemarray,array("product_id"=>explode("_",$items ['id'])[0],"product_name"=>$items ['name'],"qty"=>$items["qty"],"price"=>$items["price"],"sky_id"=>$items ['sku_id'],"rowid"=>$items["rowid"],"cid"=>$items['cid'],"corporation_id"=>$items['corporation_id']));
	                    $product_fee = $product_fee+$items["price"]*$items["qty"];
	                    }
	                    
	                }
	            }
	        }
	            
	           //运费处理----
	            $freight = 0;
	           
    	        $product_item = array();
    	        foreach($array as $k=>$v){ //处理相同商品ID就叠加数量
    	            if(!isset($product_item[$v['product_id']])){
    	                $product_item[$v['product_id']]= $v;
    	            }else{
    	                $product_item[$v['product_id']]['qty']+=$v['qty'];
    	            }
    	        }

    	        
    	        foreach ($product_item as $v){ //统计每个商品的运费
    	            if($v['is_freight'] == 1){ //如果有设置运费的才计算
        	            $product = $this->product_mdl->product_info($v['product_id']);
        	            $freight += $this->freight_count($product,$v['qty']);
    	            }
    	        }
              //运费处理结束----
    	        
    	        
                if(count($result['special_end']) > 0){//更改特价状态
                    $this->product_mdl->is_special_price = 0;
                    foreach ($product_id_array as $v){
                        $this->product_mdl->update_special_statu($v);
                    }
                }
                
                if($a){
                    $result = array(
                        'type' => 'removed',
                    );
                    echo json_encode($result);
                    exit;
                }
                
                if(count($result['special_end']) > 0){
                    echo json_encode(array('type'=>'stale'));
                    exit;
                }
                //后台逻辑已经修改SKU特价问题。前台提示处理;
            
	        if($ok){
	            $this->load->model ( 'customer_corporation_mdl' );
	            $this->load->model ( 'order_mdl' );
	            $this->load->model ( 'order_item_mdl' );
	            $this->load->model ( 'cart_mdl' );
	            

	            $shipping_fee = 0;//运费
	            /* 插入新订单信息 */
	            $this->order_mdl->customer_id = $customer_id;
	            $this->order_mdl->payment_id = $this->input->post ( 'payment_id' ) == NULL ? 2 : $this->input->post ( 'payment_id' ); // 支付方式
	            $this->order_mdl->shipping_id = 0; // 物流
	            $this->order_mdl->total_product_price = $product_fee;//产品总价
	            $this->order_mdl->auto_freight_fee = $freight;//运费
	            $this->order_mdl->total_price = $product_fee + $freight;//总价格（包含运费）
	            if(stristr($_SERVER['HTTP_USER_AGENT'],"Android") || stristr($_SERVER['HTTP_USER_AGENT'],"iPhone") || stristr($_SERVER['HTTP_USER_AGENT'],"wp")){
	                $this->order_mdl->order_source = 2; // 订单来源
	            }
	           
                //查询店铺信息
	            $_corporation = $this->customer_corporation_mdl->corp_load($items['corporation_id']);

	            if($_corporation['auto_order_amount'] >= $product_fee){
	                $status = 2;
	            }else{
	                $status = 1;
	            }
	            $this->order_mdl->status = $status;
	            	
	            if(isset($customer_remark) && $customer_remark!='请输入备注信息')
	                $this->order_mdl->customer_remark = $customer_remark;
	            $corporation_id = 0;
	            foreach ($itemarray as $ii){
	                $corporation_id = $ii['corporation_id'];
	            }

	            $this->order_mdl->corporation_id = $corporation_id;
	    
	            
	           
	            do {
	                $order_sn = get_order_sn ();//生成订单号
	                if ($this->order_mdl->check_order_sn ( $order_sn )) {
	                    $order_exist = true;
	                } else {
	                    $this->order_mdl->order_sn = $order_sn;
	                    $new_order_id = $this->order_mdl->create ();
	                    $order_exist = false;
	                }
	            } while ( $order_exist ); // 如果是订单号重复则重新提交数据
	    
               //订单生成成功执行
	           if($new_order_id){
    	            /* 插入订单商品 */
    	            foreach ( $itemarray as $items ) {
    	    
    	                $this->order_item_mdl->order_id = $new_order_id;
    	                $this->order_item_mdl->product_id = $items ['product_id'];
    	                $this->order_item_mdl->product_name = $items ['product_name'];
    	                $this->order_item_mdl->quantity = $items ['qty'];
    	                $this->order_item_mdl->price = $items ['price'];
    	                $this->order_item_mdl->sku_id = $items ['sky_id']==null || $items ['sky_id']==''?0:$items ['sky_id'];
    	                $this->order_item_mdl->weight = 0; // $items['options']['weight'];
    	                
    	                $res = $this->order_item_mdl->create ();

    	                //删除购物车
    	                $data = array (
    	                    'rowid' => $items['rowid'],
    	                    'qty' => 0
    	                );
    	                $this->cart_mdl->deleteCart($items['cid'],$customer_id);
    	                $this->cart->update ( $data );

    	                //更改商品库存
    	                if($res){
    	                    if($items['sky_id']!=null)
    	                    {
    	                        $this->load->model('product_sku_mdl');
    	                        $condition = array("id"=>$items["sky_id"],"qty"=>$items["qty"]);
    	                        $this->product_sku_mdl->update_value_stock($condition);
    	                        $this->load->model('product_mdl');
    	                        $this->product_mdl->update_stock($items['product_id'],$items['qty']);
    	                    }
    	                    else
    	                    {
    	                        $this->load->model('product_mdl');
    	                        $this->product_mdl->update_stock($items['product_id'],$items['qty']);
    	                    }
    	                }
    	    
    	            }
	           }else{
                   $result = array(
                       'type' => 'fail'
                   );
                   echo json_encode($result);exit;//生成订单失败
	           }
	            /* 插入收货人信息 */
	            $this->load->model ( 'customer_address_mdl' );
	            $address = $this->customer_address_mdl->load_by_customer ( $address_id, $customer_id );
	    
	            $this->load->model ( 'order_delivery_mdl' );
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
	            
	            //成功返回
	            if($row){
	                $result = array(
	                'type' => 'ok',
	                'new_order_id' => $new_order_id,
	                'order_sn' => $order_sn,
	                'status' => $status
	                );
	            echo json_encode($result);
	            exit;
	            }
	        }else{
	            $data['url'] = site_url('cart');
	            $this->load->view("redirect_view", $data);
	            return;
	        }
	    }else{
	        $result = array(
	            'type' => 'not_found_address'
	        );
	        echo json_encode($result);
	        exit;
	    }
	    
	    /* 清空购物车 */
	    //$this->cart->destroy ();
	    
	    // 跳转至选择支付方式
	    //redirect ( 'order/order_pay/' . $new_order_id );
	    
	}
	
	//计算运费
	//$product 商品信息
	//$qty 数量
	function freight_count($product,$qty){
	     
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
	
	    return $freight;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */