<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Order extends Api_Controller
{
    var $order_ration;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('order');
        $this->load->model('order_mdl');
    }

    public function index()
    {
        echo 'Order API';
    }
    // 获取订单列表
    public function getOrderList()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        
        // 检验参数
        // $this->_check_prams($prams,array('userid'));
        $user_id = $this->session->userdata('user_id');
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $app_id = $this->session->userdata("userdata")["id"];
        $options = array();
        if (isset($prams['status'])) {
            switch ($prams['status']) {
                case 1: // 待付款
                    $options['status'] = array(
                        1,
                        2
                    );
                    break;
                case 2: // 待收货
                    $options['status'] = array(
                        3,
                        4,
                        6
                    );
                    break;
                case 3: // 已完成
                    $options['status'] = array(
                        7,
                        9,
                        14
                    );
                    break;
            }
        }
        
        $options['order'] = $page['orderBy'];
        
        $totalcount = $this->order_mdl->count_orders($user_id, $options); // 获取总记录数
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        $listdate = array();
      
        foreach ($this->order_mdl->find_customer_orders_with_goods($user_id, $options, $perPage, $offset) as $k => $v) {
            $listdate[$k]['id'] = $v['id'];
            $listdate[$k]['order_sn'] = $v['order_sn'];
            $listdate[$k]['total_price'] = $v['total_price'];
            $listdate[$k]['status'] = $this->_order_status($v['status']);
            $listdate[$k]['statusid'] = $v['status'];
            $listdate[$k]['corporation_branch_id'] = $v['corporation_branch_id'];
            if(!$v['corporation_branch_id']){
                $listdate[$k]['corporation_branch_id'] = "0";
            }
            $listdate[$k]['corporation_name'] = $v['corporation_name'];
            $listdate[$k]['place_at'] = $v['place_at'];
            $listdate[$k]['goods_thumb'] = '';
            $listdate[$k]['goods_name'] = '';
            $listdate[$k]['goods_information'] = array();
            $listdate[$k]['total_count'] = 0;
            if (isset($v['items']) && count($v['items']) > 0) {
                foreach ($v['items'] as $items_k => $items_v) {
                    $listdate[$k]['goods_information'][$items_k]['goods_name'] = $items_v['product_name'];
                    $listdate[$k]['goods_information'][$items_k]['goods_thumb'] = $items_v['goods_thumb'];
                    $listdate[$k]['goods_information'][$items_k]['quantity'] = $items_v['quantity'];
                    $listdate[$k]['total_count'] += $items_v['quantity'];
                }
            }
        }
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $listdate;
        
        print_r(json_encode($return));
    }
    public function check_order(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
    
        $verify_number =  $prams['verify_number'];
    
        // 加载订单信息
        $order = $this->order_mdl->load_by_sn($verify_number);
    
        if(!$order){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '15',
                'errorMessage' => '无效的订单号！'
            );
             
        }else{
            $user_id = $this->session->userdata('user_id');
            //通过店铺ID判断用户是否有权限核销
            $this->load->model('Customer_corporation_mdl');
            //店铺信息
            $_corporation = $this->Customer_corporation_mdl->corp_load($order['corporation_id']);//店铺管理员ID
            
            if($user_id != $_corporation['customer_id']){//判断用户是否是店铺管理员
            
            $this->load->model('Corporation_staff_mdl');
            //判断是否是企业员工
            $staff = $this->Corporation_staff_mdl->get_corp_staff($user_id,$order['corporation_id']);
            
            if(!$staff){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '11',
                    'errorMessage' => '您还不是该店铺员工哦！'
                );
                print_r(json_encode($return));
                exit();
            }
            
            //获取用户在店铺的管理权限
            $authority = $this->Corporation_staff_mdl->get_staff_authority($order['corporation_id'],$user_id);
             
            if(!$authority){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '12',
                    'errorMessage' => '您还没有分配到任何权限，请跟店铺管理员联系'
                );
                print_r(json_encode($return));
                exit();
            }
            
            //将获取出来的权限字符串进行处理成数组
            foreach ($authority as $key => $val){
                $authority_arr[$key] = $val['url'];
            }
            
            //判断用户是否是店铺管理员
            //或者是判断用户是否拥有处理订单的权限  根据9thleaf_corporation_module表确定权限url
            $authority_str = '/Corporate/order/get_list';
            
            //判断用户是否拥有处理订单的权限  corporation_module表    订单的权限的权限为3
            if(!in_array($authority_str, $authority_arr)){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '8',
                    'errorMessage' => '没有权限操作订单'
                );
                print_r(json_encode($return));
                exit();
            }
         }
            
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
        }
    
        print_r(json_encode($return));
        exit();
    
    }
    
    // 获取订单详细
    public function getOrderDetailsById()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $this->load->model('customer_corporation_mdl');
        
        // 检验参数
//         $this->_check_prams($prams, array(
//             'orderid'
//         ));
        
        $return['data'] = array(
            'order_customer' => null,
            'order_info' => null,
            'order_delivery' => null,
            'order_item' => array()
        );
        $orderid = isset($prams['orderid'])? $prams['orderid']:'';
        
        $user_id = $this->session->userdata('user_id');
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        if(empty($orderid)){
            $verify_number =  $prams['verify_number'];
            if(empty($verify_number)){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '10',
                    'errorMessage' => '请输入核销编号'
                );
                print_r(json_encode($return));
                exit();
            }
             
            // 加载订单信息
            $order = $this->order_mdl->load_by_sn($verify_number);
        
        }else{
            // 加载订单信息
            $order = $this->order_mdl->load($orderid);
        }
      
        if ($order) {
            $return['data']['order_info'] = array(
                'id' => $order['id'],
                'order_sn' => $order['order_sn'],
                'total_product_price' => $order['total_product_price'],
                'total_price' => $order['total_price'],
                'corporation_name' => "",
                'already_pay' => empty($order['already_pay']) ? "0" : $order['already_pay'],
                'actual_freight_fee' => empty($order['actual_freight_fee']) ? "0" : $order['actual_freight_fee'],
                'place_at' => $order['place_at'],
                'statusid' => $order['status'],
                'corporation_id' => empty($order['corporation_id']) ? "" : $order['corporation_id'],
                'customer_remark' => empty($order['customer_remark']) ? "" : $order['customer_remark'],
                'status' => $this->_order_status($order['status']),
                'payment' => $this->_order_payment($order['payment_id']),
                'auto_freight_fee' => isset($order['auto_freight_fee']) && $order['auto_freight_fee'] != null ? $order['auto_freight_fee'] : 0 ,
                'order_type' => $order['order_type'],
                'branch_name' => $order['branch_name']
//                 'verify_by' => $order['verify_by'] ,
//                 'verify_number' => $order['verify_number'] ,
//                 'verify_time' => $order['verify_time']
            );
          
           if($order['order_type'] != 1){
               $sift['where']['id']= $order['id'];
               $card = $this->order_mdl->Order_Detaile($sift);
               $return['data']['order_info']['card_amount'] = $card['card_amount'];
               $return['data']['order_info']['card_name'] = $card['savings_card_name'];
           }else{
               $return['data']['order_info']['card_amount'] = 0;
               $return['data']['order_info']['card_name'] = '';
           }            
            if($order['corporation_branch_id']){
                $return['data']['order_info']['corporation_branch_id'] = $order['corporation_branch_id'];
            }else{
                $return['data']['order_info']['corporation_branch_id'] = "0";
            }
            $this->load->model('order_verify_mdl');
            $verification = $this->order_verify_mdl->get_order($order['id']);
            
            if($verification){
                //已核销，不显示二维码
                $return['data']['order_info']['verify_by'] = $verification['verify_by'];
                $return['data']['order_info']['verify_number'] = site_url('Member/order/sure_verification').'/'.$order['order_sn'];
                $return['data']['order_info']['verify_time'] = $verification['verify_time'];
                if(empty($orderid)){
                    //用核销码
                    $return['data']['order_info']['verify_code'] = false;//ios标识
                }else{
                    //用订单ID
                    $return['data']['order_info']['verify_code'] = true;//ios标识
                     
            
                }
            }else{
                $return['data']['order_info']['verify_by'] = NULL;
                $return['data']['order_info']['verify_number'] = site_url('Member/order/sure_verification').'/'.$order['order_sn'];
                $return['data']['order_info']['verify_time'] = NULL;
                if(empty($orderid)){
                    //核销码核销，不显示二维码
                    $return['data']['order_info']['verify_code'] = false;//ios标识
                }else{
                    //订单ID获取订单详情,显示二维码
                    $return['data']['order_info']['verify_code'] = true;//ios标识
            
                     
                }
            }
            
            if (! empty($return['data']['order_info']['corporation_id'])) {
                $corporation = $this->customer_corporation_mdl->corp_load($order['corporation_id']);
                if (count($corporation) > 0 && isset($corporation['corporation_name']))
                    $return['data']['order_info']['corporation_name'] = $corporation['corporation_name'];
            }
            
            // 加载购买用户信息
            $this->load->model('customer_mdl');
            $order_custom = $this->customer_mdl->load($order['customer_id']);
            if ($order_custom) {
                $return['data']['order_customer'] = array(
                    'id' => $order_custom['id'],
                    'name' => $order_custom['name'],
                    'email' => $order_custom['email'],
                    'parent_id' => $order_custom['parent_id'],
                    'is_vip' => $order_custom['is_vip'],
                    'is_mc' => $order_custom['is_mc']
                );
            }
            
            // 加载送货信息
            $this->load->model('order_delivery_mdl');
            $this->load->model('region_mdl');
            $order_delivery = $this->order_delivery_mdl->load($order['id']);
            if ($order_delivery) {
                $return['data']['order_delivery'] = array(
                    'consignee' => $order_delivery['consignee'],
                    'contact_mobile' => $order_delivery['contact_mobile'],
                    'contact_phone' => $order_delivery['contact_phone'],
                    'province_id' => $order_delivery['province_id'],
                    'city_id' => $order_delivery['city_id'],
                    'district_id' => $order_delivery['district_id'],
                    'address' => $order_delivery['address'],
                    'postcode' => $order_delivery['postcode'],
                    'fulladdress' => $this->region_mdl->get_name($order_delivery['province_id']) . '省' . $this->region_mdl->get_name($order_delivery['city_id']) . '市' . $this->region_mdl->get_name($order_delivery['district_id']) . ' ' . $order_delivery['address']
                );
            }
            $this->load->model('attribute_mdl');
            $this->load->model('product_sku_mdl');
            // 加载订单商品信息
            $order_item = $this->order_mdl->find_order_items($order['id']);
            //sku信息不再查询product_sku表，而直接调用订单sku_value
            foreach ($order_item as $ks =>$vs){
            
                if(!empty($order_item[$ks]['sku_value'])){
                    $sku_info = explode(',',$order_item[$ks]['sku_value']);
                    foreach ($sku_info as $key => $v) {
                        $sku_item[$key] = explode(':',$v);
                    }
                    $sku_data =array();
                    foreach ($sku_item as $key => $v) {
                        $order_item[$ks]['sku_item'][$key]['attr_value'] = $v[0];
                        $order_item[$ks]['sku_item'][$key]['sku_name'] = $v[1];
                    }
                }
            }
        }
        
        //获取用户资产
        $url = $this->url_prefix.'Customer/fortune/?customer_id='.$user_id;
        $credit = json_decode($this->curl_get_result($url),true);
        //用户现金余额
        $return['data']['cash'] = $credit['cash'];
        //用户货豆余额
        $return['data']['M_credit'] = $credit['M_credit'];
        //用户授信余额
        $return['data']['credit'] = $credit['credit'];
        
        $return['data']['order_item'] = $order_item;
        print_r(json_encode($return));
    }
    
    // 获取订单数量
    public function getOrderCounts()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
    
        // 验证登录
        $user_id = $this->session->userdata("user_id");
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $return['data'] = array(
            'tba' => 0,
            'tbc' => 0
        );
        
        $return['data']['tba'] = $this->order_mdl->count_orders($user_id, array(
            'status' => 1
        ));
        $return['data']['tbc'] = $this->order_mdl->count_orders($user_id, array(
            'status' => 6
        ));
        
        print_r(json_encode($return));
    }
    
    // 生成订单
    public function createOrder()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'order_item',
            'isbuy',
            'address_id',
            'order_source'
        ));
        
        $return['data'] = array(
            'order_sn' => null,
            'total_price' => null
        );
        
        $this->load->helper('order');
        $this->load->model('cart_mdl');
        $this->load->model('goods_mdl');
        $this->load->model('product_mdl');
        $this->load->model('product_sku_mdl');
        $this->load->model('order_item_mdl');
        $this->load->model('order_delivery_mdl');
        $this->load->model('customer_corporation_mdl');
        $this->load->model('customer_address_mdl', 'address');
        
        $user_id = $this->session->userdata('user_id');
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $items = array(); // 插入order_item数组
        $itemArray = $prams['order_item']; // 接收订单信息数组
        $isbuy = $prams["isbuy"]; // 1:购物车，2：立即购买
        $total_price = 0;
        $date = date("Y-m-d H:i:s");
        $addressid = $prams['address_id'];
        $customer_remark = $prams['customer_remark'];
        $payment_id = isset($prams["payment_id"]) ? $prams["payment_id"] : 0;
        
        $address = $this->address->load_by_id($addressid);
        if (count($address) == 0) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '收货地址不存在'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $result = array();
        $product_id_array = array();
        $result['down_sale'] = array();
        $result['stock_lack'] = array();
        $result['special_end'] = array();
        $commission = 0;//C端手续费
        foreach ($itemArray as $k => $item) {
            
            $item['cart_id'] = isset($item['cart_id']) ? $item['cart_id'] : 0;
            $goods = $this->product_mdl->product_info($item["pid"], $this->session->userdata('app_info')['id']);
            
            // 下架检测
            if (count($goods) == 0) {
                if ($item['cart_id']) {
                    $del = $this->cart_mdl->deleteCart($item['cart_id'], $user_id);
                }
                array_push($result['down_sale'], $item["pid"]);
                continue;
            }
            
            // 库存检测
            if ($item["val_id"] != "" && $item["val_id"] != 0) {
                // sku商品
                $sku = $this->product_sku_mdl->getSKUValue($item["val_id"]);
                if ($sku == null || $sku['stock'] < $item["qty"]) {
                    if ($item['cart_id']) {
                        $del = $this->cart_mdl->deleteCart($item['cart_id'], $user_id);
                    }
                    array_push($result['stock_lack'], $goods['id']);
                    continue;
                }
                $price = $sku['m_price'];
            } else {
                // 非sku商品
                if ($goods['stock'] < $item["qty"]) {
                    if ($item['cart_id']) {
                        $del = $this->cart_mdl->deleteCart($item['cart_id'], $user_id);
                    }
                    array_push($result['stock_lack'], $goods['id']);
                    continue;
                }
                $price = $goods['vip_price'];
            }
            
            // 特价检测
            if ($goods['special_price_end_at'] < $date && isset($goods['is_special_price']) && $goods['is_special_price'] == "1") {
                // 更新数据库购物车价格
                if ($item['cart_id']) {
                    $data = ($item["val_id"] > 0 ? array(
                        'price' => $goods['m_price']
                    ) : array(
                        'price' => $goods['vip_price']
                    ));
                    $this->cart_mdl->updateCart($item['cart_id'], $user_id, $data);
                }
                array_push($result['special_end'], $goods['id']);
                continue;
            }
            
            // 实时检查是否有特价 - 有特价执行
            if ($goods['special_price_end_at'] > $date && $goods['special_price_start_at'] < $date && isset($goods['is_special_price'])) {
                if ($price != ($item["val_id"] > 0 ? $sku['special_offer'] : $goods['special_price'])) {
                    $price = $item["val_id"] > 0 ? $sku['special_offer'] : $goods['special_price'];
                    if ($item['cart_id']) {
                        // 更新数据库购物车价格
                        $data = ($item["val_id"] > 0 ? array(
                            'price' => $sku['special_offer']
                        ) : array(
                            'price' => $goods['special_price']
                        ));
                        $this->cart_mdl->updateCart($item['cart_id'], $user_id, $data);
                    }
                }
            }
            
            $corporation_id = $item['corporation_id'];
            
            array_push($items, array(
                "id" => $goods['id'],
                "name" => $goods["name"],
                "qty" => $item["qty"],
                "price" => $price,
                "sku_id" => $item['val_id'],
                "cid" => $item['cart_id'],
                "corporation_id" => $item['corporation_id']
            ));
            $total_price += $price * (int) $item["qty"];
            
           
            $this->load->model ( 'product_cat_mdl' );
            //查询比率
            $result_rebate = $this->product_cat_mdl->Load_Leve_One_Two($goods['cat_id']);
          
            $rebate =  !empty($result_rebate) ? $result_rebate[0]['poundage'] : 0;
            $commission = $commission +$item["qty"]*$price*$rebate;//一种商品的手续费 数量*单价*比率
        }
        $this->order_mdl->commission = $commission;
      
        // 下架提示
        if (count($result['down_sale']) > 0) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '商品已下架'
            );
            print_r(json_encode($return));
            exit();
        }
        
        // 库存提示
        if (count($result['stock_lack']) > 0) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '商品库存不足'
            );
            print_r(json_encode($return));
            exit();
        }
        
        // 特价提示
        if (count($result['special_end']) > 0) {
            $this->product_mdl->is_special_price = 0;
            foreach ($result['special_end'] as $item) {
                $this->product_mdl->update_special_statu($item);
            }
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '特价商品已下架'
            );
            print_r(json_encode($return));
            exit();
        }
        
        // 货运信息
        $shipping_id = 0;
        $shipping_fee = $this->freight_count($goods, $item["qty"]);
        
       
        // 插入新订单信息
        $this->order_mdl->order_source = $prams['order_source'] == "ios" ? 4 : 3; // 订单来源
        $this->order_mdl->customer_id = $user_id; // 用户id
        $this->order_mdl->payment_id = $payment_id; // 支付方式
        $this->order_mdl->shipping_id = $shipping_id; // 物流id
        $this->order_mdl->total_product_price = $total_price; // 产品总价
        $this->order_mdl->auto_freight_fee = $shipping_fee; // 运费
        $this->order_mdl->total_price = $total_price + $shipping_fee; // 总价格（包含运费）
                                                                      
        // 订单金额小于最低自动接单金额状态改为商家已接单
//         $_corporation = $this->customer_corporation_mdl->corp_load($goods['corporation_id']);
//         if (isset($_corporation['auto_order_amount']) && $_corporation['auto_order_amount'] >= $total_price) {
//             $status = 2;
//             $this->order_mdl->status = 2;
//         } else {
//             $status = 1;
//         }
        $status = 2;
        $this->order_mdl->status = $status;
        $this->order_mdl->customer_remark = $customer_remark;
        $this->order_mdl->corporation_id = $corporation_id;
        $this->order_mdl->place_at = date('Y-m-d H:i:s');
        
        
        
        // 生成订单号
        $order_exist = false;
        do {
            $order_sn = get_order_sn();
            if ($this->order_mdl->check_order_sn($order_sn)) {
                $order_exist = true;
            } else {
                $this->order_mdl->order_sn = $order_sn;
                $this->order_mdl->create();
                $new_order_id = $this->db->insert_id();
                $order_exist = false;
            }
        } while ($order_exist);
        
        // 插入订单商品
        foreach ($items as $items) {
            $this->order_item_mdl->order_id = $new_order_id;
            $this->order_item_mdl->product_id = $items['id'];
            $this->order_item_mdl->product_name = $items['name'];
            $this->order_item_mdl->quantity = $items['qty'];
            $this->order_item_mdl->price = $items['price'];
            $this->order_item_mdl->sku_id = $items['sku_id'];
            $this->order_item_mdl->weight = 0;
            $skuinfo = $this->product_sku_mdl->load_sku($items['sku_id'],$items['id']);
            $this->order_item_mdl->sku_value = $skuinfo['sku_name'];
            $res = $this->order_item_mdl->create();
            if ($res) {
                 if($items['sku_id'] != 0 )
                {
                    $condition = array("id"=>$items["sku_id"],"qty"=>$items["qty"]);
                    $this->product_sku_mdl->update_value_stock($condition);
                }
               
                    $this->load->model('product_mdl');
                    $this->product_mdl->update_stock($items['id'],$items['qty']);
               
            }
        }
        
        // 插入收货人信息
        $this->order_delivery_mdl->order_id = $new_order_id;
        $this->order_delivery_mdl->consignee = $address['consignee'];
        $this->order_delivery_mdl->address = $address['address'];
        $this->order_delivery_mdl->province_id = $address['province_id'];
        $this->order_delivery_mdl->city_id = $address['city_id'];
        $this->order_delivery_mdl->district_id = $address['district_id'];
        $this->order_delivery_mdl->contact_phone = $address['phone'];
        $this->order_delivery_mdl->contact_mobile = $address['mobile'];
        $this->order_delivery_mdl->postcode = $address['postcode'];
        $deliveryid = $this->order_delivery_mdl->create();
        
        $return['data']['order_sn'] = $order_sn;
        $return['data']['total_price'] = $total_price;
        $return['data']['id'] = $new_order_id;
        $return['data']['place_at'] = $this->order_mdl->place_at;
        
        // 删除购物车
        if ($isbuy == 1) {
            $this->cart_mdl->deleteCartByOrder($user_id, $new_order_id);
        }
        print_r(json_encode($return));
    }

    public function addOrderAddress()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'orderid',
            'addressid'
        ));
        $addressid = $prams['addressid'];
        
        $this->load->model('customer_address_mdl', 'address');
        $address = $this->address->load_by_id($addressid);
        
        if ($address != null && $address != "") {
            
            /* 插入收货人信息 */
            $this->load->model('order_delivery_mdl');
            if ($this->order_delivery_mdl->load($prams['orderid'])) {
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '6',
                    'errorMessage' => '收货地址已存在'
                );
                print_r(json_encode($return));
                exit();
            }
            $this->order_delivery_mdl->order_id = $prams['orderid'];
            $this->order_delivery_mdl->consignee = $address['consignee'];
            $this->order_delivery_mdl->address = $address['address'];
            $this->order_delivery_mdl->province_id = $address['province_id'];
            $this->order_delivery_mdl->city_id = $address['city_id'];
            $this->order_delivery_mdl->district_id = $address['district_id'];
            $this->order_delivery_mdl->contact_phone = $address['phone'];
            $this->order_delivery_mdl->contact_mobile = $address['mobile'];
            $this->order_delivery_mdl->postcode = $address['postcode'];
            $deliveryid = $this->order_delivery_mdl->create();
            
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '收货地址修改完成！'
            );
            
            // 修改订单状态
            $this->load->model("order_mdl");
            $this->order_mdl->order_comfirmAddress($prams['orderid']);
            
            // 写入服务
            $this->load->model("order_service_mdl");
            $this->load->model("order_item_mdl");
            // $order = $this->order_mdl->load ( $prams['orderid']);
            $orderitem = $this->order_item_mdl->find_order_items($prams['orderid']);
            if ($orderitem) {
                foreach ($orderitem as $oi) {
                    $servicedata = array(
                        "customer_id" => $this->session->userdata('user_id'),
                        "order_itemid" => $oi["id"],
                        
                        "product_id" => $oi["product_id"],
                        "sku_id" => $oi["sku_id"],
                        "status" => 1,
                        "address_id" => $deliveryid,
                        "times" => $oi["times"]
                    );
                    $this->order_service_mdl->create($servicedata);
                }
            }
            
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '收货地址不存在'
            );
        }
        
        print_r(json_encode($return));
    }
    
    // ///////////////////////////////////////////////
    private function _order_status($status)
    {
        switch ((int) $status) {
            
            case 1:
                return '商家未确认';
                break;
            case 2:
                return '商家已确认';
                break;
            case 3:
                return '确认客户付款';
                break; // 微信或支付宝支付返回收款，暂时用不到
            case 4:
                return '已付款';
                break;
            case 5:
                return '货到付款';
                break; // 暂时用不到
            case 6:
                return '已发货';
                break;
            case 7:
                return '已完成';// 收货并确认：商家余额不足以扣除手续费的订单 下一步：评论
                break;
            case 8:
                return '收货并付款';
                break; // 暂时用不到
            case 9:
                return '已完成';// 下一步：评论
                break;
            case 10:
                return '已取消';
                break;
            case 11:
                return '已退款';
                break;
            case 12:
                return '已退货';
                break;
            case 13:
                return '已存货';
                break;
            case 14:
                return '已完成';
                break;
        }
    }

    private function _order_payment($payment)
    {
        switch ((int) $payment) {
            case 0:
                return '货到付款';
            case 4:
                return '微信APP支付';
            case 2:
                return '支付宝支付';
            case 3:
                return '信用额度支付';
        }
    }

    /**
     * 计算运费
     * @param unknown $product
     * @param unknown $qty
     * @return number|unknown
     */
    private function freight_count($product,$qty){
      
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

    /**
     * 订单支付接口
     */
    public function orderPay()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'order_id',
            'key',
            'pay_passwd'
        ));
        
        $key = $prams["key"];
        $order_id = $prams["order_id"];
        $paypassword = $prams["pay_passwd"];
        $user_id = $this->session->userdata('user_id');

        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
      
        $pay_relation = $this->session->userdata ( 'pay_relation' );
        $relation_id = isset($pay_relation['id'])? $pay_relation['id']:NULL;
       
        $this->load->model('order_mdl');
        $order = $this->order_mdl->load($order_id);
        
        
        //判断订单是否正确
        $is_order = $this->order_mdl->is_customer_order($order_id,array(2),$user_id);
        if($is_order){//因为面对面支付，没有支付订单默认是取消状态
            
            //获取该店主信息
            $this->load->model('customer_corporation_mdl');
            $corp_customer = $this->customer_corporation_mdl->corp_load($is_order['corporation_id']);
            $corp_customer_id = $corp_customer['customer_id'];//店主的用户ID
            
            //改状态
            $change_status = 4;
            $this->db->trans_begin(); //事物执行方法中的MODEL。
            $process = true;//事物标志
            $up_status = $this->order_mdl->update_order_status($order_id, $change_status);
           
            //如果更新成功才调用
            if( $up_status ){
                //修改is_active
                $this->load->model('Customer_mdl');
                $this->Customer_mdl->active_account( $user_id );
                
                $url = $this->url_prefix.'Order/pay_order';
            
                $data_post['relation_id'] = $relation_id;
                $data_post['pass'] = $paypassword;
                $data_post['corp_customer_id'] = $corp_customer_id;
                $data_post['total_price'] = $is_order['total_price'];
                $data_post['order_sn'] = $is_order['order_sn'];
                $data_post['app_id'] =  $is_order['app_id'];
              
                $error  =  json_decode($this->curl_post_result( $url,$data_post ),true);
            
                $data['status'] =  $error['status'];
               
                if($data['status'] == 1){
                    $is_ok = true;
                    $this->db->trans_commit();
                }
            }
            
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '没有权限操作订单'
            );
            print_r(json_encode($return));
            exit();
        }
       
       switch ($data['status']){
           case 1 :
               $return['responseMessage'] = array(
                   'messageType' => 'success',
                   'errorType' => '0',
                   'errorMessage' => '支付完成！'
               );
               print_r(json_encode($return));
               exit();
               break;
           case 3:
               $return['responseMessage'] = array(
                   'messageType' => 'error',
                   'errorType' => '8',
                   'errorMessage' => '支付密码错误，请输入正确密码！'
               );
               print_r(json_encode($return));
               exit();
               break;
           case 4:
               $return['responseMessage'] = array(
                   'messageType' => 'error',
                   'errorType' => '11',
                   'errorMessage' => '支付失败,用户余额不足！'
               );
               print_r(json_encode($return));
               exit();
              break; 
           case 5:
               $return['responseMessage'] = array(
                   'messageType' => 'error',
                   'errorType' => '5',
                   'errorMessage' => '手续费不足！'
               );
               print_r(json_encode($return));
               exit();
               break;
       }
       if( empty($is_ok) && !empty($process) ){
           $this->db->trans_rollback();
           $return['responseMessage'] = array(
               'messageType' => 'error',
               'errorType' => '12',
               'errorMessage' => '支付失败！'
           );
           print_r(json_encode($return));
           exit();
       }
    }

    public function getBalanceInfo()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'userid'
        ));
        
        $userid = $prams['userid'];
        
        $this->load->model("order_mdl");
        $this->load->model("balance_mdl");
        
        $totallist = $this->order_mdl->getCutomerRebateList(array(
            "agentid" => $userid
        ));
        $hadpay = $this->balance_mdl->getBalanceByCustomer($userid);
        
        $data["totalcount"] = "0";
        if ($totallist && count($totallist) > 0) {
            $data["totalcount"] = $totallist[0]["rebate_1"];
        }
        
        if ($hadpay != 0) {
            $data["hadpay"] = $hadpay["balancetotal"] == null ? "0" : $hadpay["balancetotal"];
        } else {
            $data["hadpay"] = "0";
        }
        
        $data["nopay"] = $data["totalcount"] - $data["hadpay"];
        
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        $return['data'] = $data;
        print_r(json_encode($return));
    }

    public function customerBalance()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'userid',
            'total',
            'bankname',
            'bankaccount',
            'realname'
        ));
        $data['customerid'] = $prams['userid'];
        $data['balancetotal'] = $prams['total'];
        $data['bankname'] = $prams['bankname'];
        $data['banksubname'] = $prams['banksubname'];
        $data['bankaccount'] = $prams['bankaccount'];
        $data['realname'] = $prams['realname'];
        
        // $data["create_time"] = time();
        $this->load->model("balance_mdl");
        $this->load->model("order_mdl");
        
        $totallist = $this->order_mdl->getCutomerRebateList(array(
            "agentid" => $data['customerid']
        ));
        $hadpay = $this->balance_mdl->getBalanceByCustomer($data['customerid']);
        $totalcount = 0;
        if ($totallist && count($totallist) > 0) {
            $totalcount = $totallist[0]["rebate_1"];
        }
        
        if ($hadpay != 0) {
            $hadpay = $hadpay["balancetotal"] == null ? 0 : $hadpay["balancetotal"];
        } else {
            $hadpay = 0;
        }
        
        if ($totalcount - $hadpay > 0 && $totalcount - $hadpay > $data['balancetotal']) {
            $id = $this->balance_mdl->create($data);
            if ($id) {
                $return['responseMessage'] = array(
                    'messageType' => 'success',
                    'errorType' => '0',
                    'errorMessage' => ''
                );
                $return['data'] = $data;
                print_r(json_encode($return));
            } else {
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '2',
                    'errorMessage' => '结算申请提交失败！'
                );
                print_r(json_encode($return));
            }
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '不需要结算或结算金额太多！'
            );
            print_r(json_encode($return));
        }
    }

    public function OrderComment()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'items'
        ));
        
        $this->load->model('order_comments_mdl', 'comment');
        
        $item = $prams['items'];
        $orderid = $prams['orderid'];
        $user_id = $this->session->userdata('user_id');
        if ($user_id == null || $user_id == '') {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        foreach ($item as $v) {
            
            if ($this->comment->check_iscomment($v['orderitemid'])) {
                
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '2',
                    'errorMessage' => '已评论过该订单了'
                );
            } else {
                
                $this->comment->orderitem_id = $v['orderitemid'];
                $this->comment->product_score = $v['product_score'];
                $this->comment->content = $v['content'];
                $this->comment->create_by = $user_id;
                
                if ($this->comment->create()) {
                    $return['responseMessage'] = array(
                        'messageType' => 'success',
                        'errorMessage' => null
                    );
                } else {
                    $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '3',
                        'errorMessage' => '评论失败'
                    );
                    print_r(json_encode($return));
                    exit;
                }
            }
        }
        $this->load->model('order_mdl');
        $this->order_mdl->update_order_status($orderid, 14);
        print_r(json_encode($return));
    }

    public function orderConfirmGoods()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $this->_check_prams($prams, array(
            'orderid',
            'pay_password'
        ));
        
        $orderid = $prams['orderid'];
        $paypassword = md5($prams['pay_password']);
        $user_id = $this->session->userdata('user_id');
        $relation_id = $this->session->userdata ('pay_relation')['id'];
        $this->load->model('order_mdl');
        $this->load->model('pay_account_mdl');
        $this->load->model("customer_corporation_mdl");
        $this->load->model("customer_currency_log_mdl", 'customer_currency_log');
        $this->load->model('order_rebate_mdl');
        $status = false;
        if ($user_id == null || $user_id == '') {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $order = $this->order_mdl->is_customer_order($orderid, 6, $user_id);
        if ($order == null || $order == '') {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '订单错误'
            );
            print_r(json_encode($return));
            exit();
        }
        //接口-验证支付密码
        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
        $pay_info = json_decode($this->curl_get_result($url),true);
         
       
        if (! isset($pay_info['pay_passwd']) || $pay_info['pay_passwd'] == null) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '用户未设置支付密码'
            );
            print_r(json_encode($return));
            exit();
        }
        
        if ($paypassword == $pay_info['pay_passwd']) {
            
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
                $row = $this->order_mdl->update_order_status($orderid, 9);
                	
                if($row)
                {
                    //通过接口调用收货流程接口
                    $url = $this->url_prefix.'Order/order_receive';
                    $data_post['corp_customer_id'] = $corp_customer_id;
                    $data_post['relation_id'] = $relation_id;
                    $data_post['password'] = $paypassword;
                    $data_post['order_sn'] = $order['order_sn'];
                    $data_post['total_price'] = $order['total_price'];
                    $data_post['app_id'] = $order['app_id'];
                    $data_post['C_commission'] = $order['commission'];
                    $C_error = json_decode($this->curl_post_result($url,$data_post),true);
                    
                    if( $C_error['status'] )
                    {
                        $this->db->trans_commit(); //提交事物
                        $status = 1;
                    }
                 
                }
            }
           } else {
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '8',
                    'errorMessage' => '支付出错，支付密码不正确！'
                );
                print_r(json_encode($return));
                exit();
            }
            if($status){
                $return['responseMessage'] = array(
                    'messageType' => 'success',
                    'errorType' => null,
                    'errorMessage' => '确认收货成功'
                );
            
            }else{
                $this->db->trans_rollback(); //事物回滚
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => 6,
                    'errorMessage' => '确认收货不成功'
                );
            }
            print_r(json_encode($return));
    }

    /**
     * 核销订单
     *  verify_number  订单的核销编号
     */
    public function verify_order(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
         
        $this->_check_prams($prams, array(
            'verify_number'
        ));
    
        $verify_number = $prams['verify_number'];
        $user_id = $this->session->userdata('user_id');
    
        if ($user_id == null || $user_id == '') {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
       
        $this->load->model('order_mdl');
        //通过核销单号查找该订单
        $order = $this->order_mdl->load_by_sn($verify_number);
     
        if(!$order){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '9',
                'errorMessage' => '订单不存在'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $this->load->model('order_verify_mdl');
        //通过核销单号查找该订单核销数据
        $verify_order = $this->order_verify_mdl->load_byVerify($verify_number);
     
        //判断是订单是否已被核销
        if($verify_order){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '10',
                'errorMessage' => '订单已核销'
            );
            print_r(json_encode($return));
            exit();
        }
        
        //判断该订单状态是否为已付款 为4
        if($order['status'] !=4){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '没有权限操作订单'
            );
            print_r(json_encode($return));
            exit();
        }
    
        //通过店铺ID判断用户是否有权限核销
        $this->load->model('Customer_corporation_mdl');
        //店铺信息
        $_corporation = $this->Customer_corporation_mdl->corp_load($order['corporation_id']);//店铺管理员ID
      
        if($user_id != $_corporation['customer_id']){//判断用户是否是店铺管理员  
            
            $this->load->model('Corporation_staff_mdl');
            //判断是否是企业员工
            $staff = $this->Corporation_staff_mdl->get_corp_staff($user_id,$order['corporation_id']);
    
                if(!$staff){
                    $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '11',
                        'errorMessage' => '您还不是该店铺员工哦！'
                    );
                    print_r(json_encode($return));
                    exit();
                }
        
            //获取用户在店铺的管理权限
            $authority = $this->Corporation_staff_mdl->get_staff_authority($order['corporation_id'],$user_id);
           
            if(!$authority){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '12',
                    'errorMessage' => '您还没有分配到任何权限，请跟店铺管理员联系'
                );
                print_r(json_encode($return));
                exit();
            }
        
           //将获取出来的权限字符串进行处理成数组
            foreach ($authority as $key => $val){
                $authority_arr[$key] = $val['url'];
            }
            
            //判断用户是否是店铺管理员
            //或者是判断用户是否拥有处理订单的权限  根据9thleaf_corporation_module表确定权限url
            $authority_str = '/Corporate/order/get_list';
            
            //判断用户是否拥有处理订单的权限  corporation_module表    订单的权限的权限为3
            if(!in_array($authority_str, $authority_arr)){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '8',
                    'errorMessage' => '没有权限操作订单'
                );
                print_r(json_encode($return));
                exit();
            }
        }
    
        //执行事务
        $this->db->trans_begin();
        $process = true; //进入事物的标志
    
        //扫码后修改订单状态为已发货为6
        $row = $this->order_mdl->update_order_status($order['id'], 6);
        $verify_time = date('Y-m-d H:i:s');
        if($row){
            $this->load->model('order_verify_mdl');
            //新建核销记录
            //生成核销编号
            //以及写入核销时间和人员id
            $this->order_verify_mdl->verify_number = $order['order_sn'];
            $this->order_verify_mdl->verify_time = $verify_time;
            $this->order_verify_mdl->verify_by = $user_id;
            $rows = $this->order_verify_mdl->create($order['id']);
            if($rows){
                $this->db->trans_commit(); //提交事物
                $is_ok = true;
            }
        }
        if(!empty($is_ok) && $process){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '核销成功!'
            );
    
            $this->load->model('customer_mdl');
            $customer = $this->customer_mdl->load($user_id);
            $order_sn  = $order['order_sn'];
            $total_price  = $order['total_price'];
            $real_name = trim($customer['real_name']);
            $verify_by = $real_name ? $real_name:$customer['id'];
            $verify_time =date('Y年m月d日H时i分s秒',strtotime($verify_time));
            //发送客户短信
            $_customer = $this->customer_mdl->load($order['customer_id']);
            $content = "尊敬的客人，您的订单".$order_sn."已发货，请确认收货。订单金额：".$total_price."，核销员：".$verify_by."，核销时间：".$verify_time;
            $this->_send_verify_message($_customer['mobile'],$content);
    
            //发送核销员短信
            $content = "可爱的核销员，您已对订单".$order_sn."核销成功。订单金额：".$total_price."，核销员：".$verify_by."，核销时间：".$verify_time;
            $this->_send_verify_message($customer['mobile'],$content);
    
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '核销失败'
            );
        }
        print_r(json_encode($return));
    }
    
    
    
    /**
     * 发送核销成功短信
     */
    private  function _send_verify_message($mobile,$content){
    
        $this->load->model("shortmsg_log_mdl");
        //发送发货成功信息提示买家和核销员
        $this->load->library('Short_Message_Factory', '', 'message');
    
        // 读取默认短信提供商
        $this->load->model("sms_supplier_mdl");
        $supplier = $this->sms_supplier_mdl->get_in_use();
        $sms = $this->message->get_message($supplier);
    
        $id = $this->shortmsg_log_mdl->create(array(
            'mobile' => $mobile,
            'content' => $content
        ));
    
        $msgs = $sms->send($mobile, $content); // 'sms&stat=100&message=发送成功';//
        $msg = explode("&", $msgs);
        $type = $msg[0];
        $status = $msg[1]; // substr($msg[1], strpos($msg[1], "=") + 1);
        $return_msg = $msg[2]; // substr($msg[2], strpos($msg[2], "=") + 1);
        $log = array(
            'id' => $id,
            'msg_type' => $type,
            'status' => $status,
            'return_msg' => $return_msg
        );
        $this->shortmsg_log_mdl->update($log);
    }
    
    
    /**
     *  获取核销订单记录
     *  time  核销时间
     */
    public function get_verify_log(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        
        $time = isset($prams['time']) ? $prams['time']:NULL;
    
        $user_id = $this->session->userdata('user_id');
    
        if ($user_id == null || $user_id == '') {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $this->load->model('order_verify_mdl');
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        
        $log= array();
        $this->load->model('Customer_corporation_mdl');
        $corp_detail = $this->Customer_corporation_mdl->load( $user_id );
        if($corp_detail){//判断用户是否是店铺管理员
             $log = $this->order_verify_mdl->get_OwnerVerifyLog($user_id,$time,$perPage,$offset);
             $logs = $this->order_verify_mdl->get_OwnerVerifyLog($user_id,$time);
        }else{
             $log = $this->order_verify_mdl->get_verifyLog($user_id,$time,$perPage,$offset);
             $logs = $this->order_verify_mdl->get_OwnerVerifyLog($user_id,$time);
        }
         
        if($log){
            $total_amount = 0;
              if(!empty($time)){//查询一天的核销记录
                if($corp_detail){
                    $price_list = $this->order_verify_mdl->get_OwnerVerifyLog($user_id,$time);//获取某一天的
                }else{
                    $price_list = $this->order_verify_mdl->get_verifyLog($user_id,$time);//获取某一天的
                }
                foreach ($price_list as $key => $val){
                    $total_amount += $val['total_price'];
                }
                $return['data']['total_amount'] = $total_amount;  //一天核销订单总金额
                if($price_list){
                    $return['data']['days_count'] = count($price_list);  //一天核销订单总数量
                }else {
                    $return['data']['days_count'] = 0;  //一天核销订单总数量
                }
                
                }
                
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
            
            $totalcount  = count($logs);   //分页核销订单总数量
            $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
            $return['data']['totalpage'] = $totalpage;
            
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '没有核销记录！'
            );
            $total_amount = 0;
            $totalcount = 0;
        }
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['listdate'] = $log;
        
        print_r(json_encode($return));
    }
    
   

    /**
     * 取消订单
     */
    public function cancel_order()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'order_id'
        ));
        
        $user_id = $this->session->userdata('user_id');
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $this->load->model('order_item_mdl', 'order_item');
        $order_id = $prams['order_id'];
        $status = array(
            1,
            2
        );
        $up_status = 10; // 修改取消订单的状态
        $is_order = $this->order_mdl->is_customer_order($order_id, $status, $user_id);
        if ($is_order == null || $is_order == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '13',
                'errorMessage' => '订单状态不可取消'
            );
            print_r(json_encode($return));
            exit();
        }
        $goods = $this->order_item->order_item_goods($order_id);
        // 取消订单修改商品库存
        $is_ok = $this->order_mdl->cancel_order($order_id, $up_status, $goods);
        
        if ($is_ok) {
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '订单取消成功！'
            );
            print_r(json_encode($return));
        }
    }
    
    /**
     * 扫描二维码支付 - 支付前验证商品、企业信息
     */
    public function check_sweep_product()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'product_id','corporation_id'
        ));

        $product_id = $prams['product_id'];
        $corporation_id = $prams['corporation_id'];
        
        $user_id = $this->session->userdata('user_id');
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        // 判断该店铺是否存在
        $this->load->model('corporation_mdl');
        $corp_message = $this->corporation_mdl->load_id($corporation_id);
        if (!$corp_message)
        {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '二维码错误（店铺信息错误）'
            );
            print_r(json_encode($return));
            exit();
        }
        
        // 判断店铺是否有二维码商品
        $options["type"] = 'sale';
        $options['customer_id'] = $corp_message['customer_id'];
        $options['corporation_id'] = $corporation_id;
        $options['conditions'] = array(
//             "p.app_id" => $this->session->userdata('app_info')['id'],
            "p.is_mc" => '1',
            "p.id" => $product_id
        );
        
        $options['row'] = true;
        $this->load->model('product_mdl');
        $data['product_list'] = $this->product_mdl->find_products($options, false);
        
        if (! $data['product_list']) 
        {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '二维码错误（商品信息错误）'
            );
            print_r(json_encode($return));
            exit();
        }

        $corporation['corporation_name'] = $corp_message['corporation_name'];
        $product['name'] = $data['product_list']['name'];
        $product['vip_price'] = $data['product_list']['vip_price'];
        
        $return['data']['prodcut'] = $product;
        $return['data']['corporation'] = $corporation;

        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => '商品信息正确'
        );
        print_r(json_encode($return));
    }
    
    /**
     * 用户分店列表
     */
    public function branch_list(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $user_id = $this->session->userdata("user_id");
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $this->load->model('corporation_branch_mdl','branch');
        if(isset($prams['branch_id'])){
            //获取用户指定分店详细信息
               $branch_id = $prams['branch_id'];
        }else{
            //获取用户分店列表
            $branch_id = 0;
        }
     
        $branch = $this->branch->get_user_branch($user_id,$branch_id);
        if(!$branch){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '该用户并不是这家分店的负责人哦'
            );
            print_r(json_encode($return));
            exit();
        }
        if(!$branch_id){
            foreach ($branch as $key =>$val){
                $branch[$key]['created_at'] =substr ( $val['created_at'], 0,10);
            }
        }else{
            $branch['created_at'] =substr ( $branch['created_at'], 0,10);
        }
        
        $return['data'] =$branch;
        print_r(json_encode($return));
    }
    
    
    
    /**
     * 扫描二维码接口
     */
    public function check_code(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        if(!isset($prams['corporation_id']) &&  !isset($prams['branch_id'])){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '1',
                'errorMessage' => '缺少参数'
            );
            print_r(json_encode($return));
            exit();
        }
        $user_id = $this->session->userdata("user_id");
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
       
        $corporation_id = isset($prams['corporation_id'])? $prams['corporation_id']:0;
        $branch_id = isset($prams['branch_id'])? $prams['branch_id']:0;
        if($corporation_id){
            //店铺
            $this->load->model('corporation_mdl');
            $corp = $this->corporation_mdl->load_id($corporation_id);
            if(!$corp){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '7',
                    'errorMessage' => '暂无该企业'
                );
                print_r(json_encode($return));
                exit();
            }
            
            if(isset($prams['product_id']) && $prams['product_id']){
                // 判断店铺是否有二维码商品
                $options["type"] = 'sale';
                $options['customer_id'] = $corp['customer_id'];
                $options['corporation_id'] = $corporation_id;
                $options['conditions'] = array(
                //             "p.app_id" => $this->session->userdata('app_info')['id'],
                    "p.is_mc" => '1',
                    "p.id" => $prams['product_id']
                );
                
                $options['row'] = true;
                $this->load->model('product_mdl');
                $info= $this->product_mdl->find_products($options, false);
                
                if (! $info)
                {
                    $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '3',
                        'errorMessage' => '二维码错误（商品信息错误）'
                    );
                    print_r(json_encode($return));
                    exit();
                }
                $product['name'] = $info['name'];
                $product['vip_price'] = $info['vip_price'];

                $return['data']['product'] = $product;
            }
            $corp_info['id'] = $corp['id'];
            $corp_info['corporation_name'] = $corp['corporation_name'];
            $corp_info['corp_customer_id'] = $corp['customer_id'];
            $corp_info['img_url'] = $corp['img_url'];
            
        }else{
            //分店
            $sift['where']['id'] =$branch_id;
            $this->load->model('corporation_branch_mdl','branch');
            $corp_info = $this->branch->Corp_Branch_Detaile( $sift );
            if(!$corp_info){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '7',
                    'errorMessage' => '暂无该分店'
                );
                print_r(json_encode($return));
                exit();
            } 
        }
       
        $return['data']['corp_info'] = $corp_info;
        print_r(json_encode($return));
    }
    
    /**
     * 查询用户是否有可用的储值卡。
     */
    public function branch_card_list(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'branch_id',
        ));
        $branch_id = $prams['branch_id'];
        if(!$branch_id){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '1',
                'errorMessage' => '缺少参数'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $user_id = $this->session->userdata("user_id");
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $sift['where']['id'] =$branch_id;
        $this->load->model('corporation_branch_mdl','branch');
        $corp_info = $this->branch->Corp_Branch_Detaile( $sift );
        
        //查询是否有可用的储值卡。
        $sift['where']['customer_id'] = $user_id;
        $sift['where']['corporation_id'] = $corp_info['corp_id'];
        
        $this->load->model('Savings_card_mdl');
        $card_info = $this->Savings_card_mdl->Load_Customer_Card( $sift );
        if(empty($card_info)){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '3',
                'errorMessage' => '没有可用的储蓄卡'
            );
            print_r(json_encode($return));
            exit;
        }
        $card = array();
        foreach ($card_info as $key =>$val ){
            //储蓄卡余额不为0            
            if($val['remaining_card_amount'] > 0){
                $info['id'] = $val['id'];
                $info['corporation_id'] = $val['corporation_id'];
                $info['card_name'] = $val['card_name'];
                $info['customer_id'] = $val['customer_id'];
                $info['remaining_card_amount'] = $val['remaining_card_amount'];
                $info['start_time'] = $val['start_time'];
                $info['end_time'] = $val['end_time'];
                $info['remarks'] = $val['remarks'];
                if($val['level_two_show_card_amount'] < $val['remaining_card_amount'] && $val['level'] == 2 )
                {
                    $info['remaining_card_amount'] = $val['level_two_show_card_amount'];
                }
                array_push($card, $info);
            }
        }    
        if(empty($card)){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '3',
                'errorMessage' => '没有可用的储蓄卡'
            );
            print_r(json_encode($return));
            exit;
        }
        
        $return['data'] =$card;
        print_r(json_encode($return));
    }
    
    
    /**
     * 分店订单
     */
    public function  branch_order_list(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'branch_id',
            'type',
        ));
        $option['branch_id'] = $prams['branch_id'];
        if(!$option['branch_id']){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '1',
                'errorMessage' => '缺少参数'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        
        $option['type'] =$prams['type']; //全部订单 all 货豆订单 credit  储蓄卡订单 card
        if(isset($prams['start_at'])){
            $option['grant_start_at'] =$prams['start_at'];
            if($option['grant_start_at']){
                if(!isset($prams['end_at']) && !$prams['end_at'] ){
                    $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '6',
                        'errorMessage' => '请选择结束时间'
                    );
                    print_r(json_encode($return));
                    exit();
                }else{
                    $option['grant_end_at'] =$prams['end_at'];
                }
            }
        }
       
       
        $user_id = $this->session->userdata("user_id");
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
       
        $this->load->model('corporation_branch_mdl','branch');
        $branch_detail = $this->branch->get_user_branch($user_id,$option['branch_id']);
        if(!$branch_detail){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '分店不存在'
            );
            print_r(json_encode($return));
            exit();
        }
        
        
        $option['list_type'] = 'load_list';//分店订单下拉加载类型
        $total_price = 0;
        $all_orders = $this->branch->get_branch_order(0,$option);
        foreach ($all_orders as $key =>$val){
            $total_price += $val['total_price'];
        }
        
        $totalcount = count( $all_orders); // 获取总记录数
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        
        $listdate = $this->branch->get_branch_order(0,$option,$perPage,$offset);
        
      
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $listdate;
        $return['data']['total_price'] = $total_price;
        
        print_r(json_encode($return));
    }
    
    
    /**
     * 分店 扫描二维码支付
     */
    public function branch_code_pay(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        
        // 检验参数
        $this->_check_prams($prams, array(
            'card_buy_id',
            'card_pay_amount',
            'branch_id',
            'price',
            'pay_password'
             )
        );
        $card_buy_id = $prams['card_buy_id'];//卡ID。
        $remaining = $prams['card_pay_amount'];//储蓄卡余额。
        $branch_id  = $prams['branch_id'];//分店ID。
        $price = $prams['price']; //需要支付的总额。
        $pay_password = $prams['pay_password'];//支付密码。
        
        $sift['where']['id'] = $branch_id;
        $this->load->model('Corporation_branch_mdl');
        $corp_info = $this->Corporation_branch_mdl->Corp_Branch_Detaile( $sift );
        $relation_id = $this->session->userdata ('pay_relation')['id'];
      
        if($remaining == 0){//纯货豆
            $card_pay_amount = $remaining;
        }else if($remaining - $price >= 0){//余额大于消费总额  纯储蓄卡
            $card_pay_amount = $price;
        }else if($remaining - $price < 0){//余额小于消费总额  货豆+储蓄卡
            $card_pay_amount = $remaining;
        }
        
        if( $card_pay_amount <= $price )
        {
            if( $corp_info )
            {
                //查询账户余额
                $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
                $pay_info = json_decode($this->curl_get_result($url),true);
                $time = date('Y-m-d H:i:s');
        
                if( md5($pay_password) == $pay_info['pay_passwd'] )
                {
                    if(! ($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time) )
                    {
                        $pay_info['credit'] = '0.00';
                    }
        
                    //可用余额
                    $available_amount = $pay_info['credit']+$pay_info['M_credit'];
        
                    //需要支付的货豆。
                    $pay_m = $price-$card_pay_amount;
        
                    if( $available_amount >= $pay_m )
                    {
                        $this->db->trans_begin(); // 事物执行方法中的MODEL.
                        $process = true; //进入事物的标志。
                        $card_row = true;//初始化。
        
                        $customer_id = $this->session->userdata('user_id');
        
                        /* 插入新订单信息 */
                        $this->load->helper ( 'order' );
                        $this->load->model ( 'order_mdl' );
                         
                        if( $card_buy_id && $card_pay_amount > 0 )
                        {
                            $this->order_mdl->order_type = $card_pay_amount == $price ? 2 : 3;
                        }
                        $this->order_mdl->corporation_branch_id = $branch_id;
                        $this->order_mdl->customer_id = $customer_id;
                        $this->order_mdl->payment_id = 5; //扫码支付
                        $this->order_mdl->shipping_id = 0; // $shipping_id;
                        $this->order_mdl->total_product_price = $price;
                        $this->order_mdl->total_price = $price;
                        $this->order_mdl->corporation_id = $corp_info['corp_id'];
                        $this->order_mdl->pay_time = date('Y-m-d H:i:s');
                        $this->order_mdl->status = 14; //订单默认是支付成功，待付款后改变状态
                        $this->order_mdl->commission = 0;
        
                        do {
        
                            $order_sn = get_order_sn ();
        
                            if ($this->order_mdl->check_order_sn ( $order_sn ) )
                            {
                                $order_exist = true;
                            } else {
                                $order_exist = false;
                                $this->order_mdl->order_sn = $order_sn;
                                $new_order_id = $this->order_mdl->create ();
                            }
        
                        } while ( $order_exist ); // 如果是订单号重复则重新提交数据
        
        
                        if($new_order_id)
                        {
        
                            /* 插入消费表 */
                            $this->load->model ( 'order_item_mdl' );
                            $this->order_item_mdl->order_id = $new_order_id;
                            $this->order_item_mdl->product_id = 0;
                            $this->order_item_mdl->product_name = '面对面支付';
                            $this->order_item_mdl->quantity = 1;
                            $this->order_item_mdl->price = $price;
                            $this->order_item_mdl->sku_id = 0;
                            $this->order_item_mdl->weight = 0; // $items['options']['weight'];
                            $res = $this->order_item_mdl->create ();
        
                            if($res)
                            {
                                //判断是否使用了储值卡。
                                if( !empty( $this->order_mdl->order_type ) )
                                {
                                    $this->load->model('Savings_card_mdl');
                                    $order_info['corp_customer_id'] = $corp_info['corp_customer_id'];
                                    $order_info['savings_card_buy_id'] = $card_buy_id;
                                    $order_info['card_pay_amount'] = $card_pay_amount;
                                    $order_info['customer_id'] = $customer_id;
                                    $order_info['id'] = $new_order_id;
                                    $order_info['order_sn'] = $order_sn;
                                    $order_info['status'] =  $this->order_mdl->status;
                                    
                                    //卡消费逻辑。
                                    $card_row = $this->Savings_card_mdl->Card_Pay_Order( $order_info );
                                }
        
                                if( $card_row )
                                {
                                    if( empty( $this->order_mdl->order_type ) || $this->order_mdl->order_type == 3 )
                                    {
        
                                        //调用接口处理
                                        $url = $this->url_prefix.'Order/code_order';
        
                                        $data_post['relation_id'] = $relation_id;
                                        $data_post['corp_customer_id'] = $corp_info['corp_customer_id'];
                                        $data_post['total_price'] = $pay_m;
                                        $data_post['order_sn'] = $order_sn;
                                        $data_post['app_id'] =  $this->session->userdata('app_info')['id'];
                                        $status =  ( int ) $this->curl_post_result( $url,$data_post );
                                        if( $status == 1 )
                                        {
                                           $return['responseMessage'] = array(
                                            'messageType' => 'success',
                                            'errorType' => '0',
                                            'errorMessage' => '支付成功'
                                            );
                                            $return['data']['order_id'] = $new_order_id;
                                            $return['data']['order_sn'] = $order_sn;
                                            $return['data']['price'] = $price;
                                        }
        
                                    }else{
                                        $status = 1;
                                        $return['responseMessage'] = array(
                                            'messageType' => 'success',
                                            'errorType' => '0',
                                            'errorMessage' => '支付成功'
                                        );
                                        $return['data']['order_id'] = $new_order_id;
                                        $return['data']['price'] = $price;
                                        $return['data']['order_sn'] = $order_sn;
                                    }
                                }else if($card_pay_amount){//使用了储蓄卡
                                    $this->db->trans_rollback();
                                    //储蓄卡余额不足
                                    $return['responseMessage'] = array(
                                        'messageType' => 'error',
                                        'errorType' => '9',
                                        'errorMessage' => '储蓄卡有变动,请重新选择'
                                    );
                                    print_r(json_encode($return));
                                    exit;
                                }
                            }
                        }
        
        
                    }else{
        
                        //货豆余额不足。
                        $return['responseMessage'] = array(
                            'messageType' => 'error',
                            'errorType' => '2',
                            'errorMessage' => '货豆余额不足'
                        );
                    }
        
                     
                }else{
                    //密码错误。
                    $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '3',
                        'errorMessage' => '支付密码错误'
                    );
                }
        
            }else{
                //分店不存在。
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '4',
                    'errorMessage' => '分店不存在'
                );
            }
        }
        
        if( isset($status) && $status == 1 )
        {
            $this->db->trans_commit();
            $is_ok = true;
        
            //修改为不是第一次购买了。
            $this->load->model('Customer_mdl');
            $this->Customer_mdl->active_account( $customer_id );
        }
        
        if( empty( $is_ok ) && !empty( $process ) )
        {
            $this->db->trans_rollback();
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '支付失败'
            );
        }
        print_r(json_encode($return));
    }
    
    /**
     * 扫描二维码支付 - 支付货豆，生成订单
     */
    public function sweep_pay()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array('corporation_id','product_id','price','passwd'));
        
        $data = array();
        $price = $prams['price']; //支付金额
        $pay_passwd = md5( $prams['passwd'] ); //支付密码
        $product_id  =  $prams['product_id']; //穿过来的商品id
        $corporation_id =  $prams['corporation_id']; //传过来的店铺ID
        $user_id = $this->session->userdata ( 'user_id' ); //购买人登录id
        
        $pay_relation = $this->session->userdata ( 'pay_relation' );
        $relation_id = isset($pay_relation['id'])? $pay_relation['id']:NULL;
       
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
         
        // 判断该店铺是否存在
        $this->load->model('corporation_mdl');
        $corp_message = $this->corporation_mdl->load_id($corporation_id);
        if (!$corp_message)
        {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '二维码错误（店铺信息错误）'
            );
            print_r(json_encode($return));
            exit();
        }
        
        //店铺存在
        $data['corporation_name'] = $corp_message['corporation_name'];

        // 判断店铺是否有二维码商品
        $options["type"] = 'sale';
        $options['customer_id'] = $corp_message['customer_id'];
        $options['corporation_id'] = $corporation_id;
        $options['conditions'] = array(
//             "p.app_id" => $this->session->userdata('app_info')['id'],
            "p.is_mc" => '1',
            "p.id" => $product_id
        );
        
        
        $options['row'] = true;
        $this->load->model('product_mdl');
        $product = $this->product_mdl->find_products($options,false);
        
        
        $this->db->trans_begin(); // 事物执行方法中的MODEL.
        $process = true; //进入事物的标志
        if($product)
        {
            
            //返回商品名称和消费金额
            $data['name'] = $product['name'];
            $data['price'] = $price;
            //查询账户余额
            $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
            $pay_info = json_decode($this->curl_get_result($url),true);
            $time = date('Y-m-d H:i:s');
            
            if($pay_info){
                if( empty( $pay_info['pay_passwd']) ){
                    $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '4',
                        'errorMessage' => '未设置支付密码'
                    );
                    print_r(json_encode($return));
                    exit();
                }
                if($pay_info['pay_passwd'] == $pay_passwd ){

                    if(! ($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time) ){
                        $pay_info['credit'] = '0.00';
                    }
                    
                    $available_amount = $pay_info['credit']+$pay_info['M_credit']; //剩余可用余额

                    if($available_amount >= $price)
                    {
                    
                        $customer_id = $this->session->userdata('user_id');
                       /* 插入新订单信息 */
                        $this->load->helper ( 'order' );
                        $this->load->model ( 'order_mdl' );
                        $this->order_mdl->customer_id = $customer_id;
                        $this->order_mdl->payment_id = 5; //扫码支付
                        $this->order_mdl->shipping_id = 0; // $shipping_id;
                        $this->order_mdl->total_product_price = $price;
                        $this->order_mdl->total_price = $price;
                        $this->order_mdl->corporation_id = $corporation_id;
                        $this->order_mdl->pay_time = date('Y-m-d H:i:s');
                        $this->order_mdl->status = 14; //订单默认是支付成功，待付款后改变状态
                    
                        
                        $this->load->model ( 'product_cat_mdl' );
                        //查询比率
                        $result = $this->product_cat_mdl->Load_Leve_One_Two($product['cat_id']);
                        $rebate =  !empty($result) ? $result[0]['poundage'] : 0;
                        $this->order_mdl->commission = $price*$rebate;
                    
                        do {
                            $order_sn = get_order_sn ();
                            if ($this->order_mdl->check_order_sn ( $order_sn ))
                            {
                                $order_exist = true;
                            } else {
                                $order_exist = false;
                                $this->order_mdl->order_sn = $order_sn;
                                $new_order_id = $this->order_mdl->create ();
                            }
                        } while ( $order_exist ); // 如果是订单号重复则重新提交数据
                    
                        //返回订单号
                        $data['order_sn'] = $order_sn;
                        
                        if($new_order_id)
                        {
                    
                            /* 插入消费表 */
                            $this->load->model ( 'order_item_mdl' );
                            $this->order_item_mdl->order_id = $new_order_id;
                            $this->order_item_mdl->product_id = $product_id;
                            $this->order_item_mdl->product_name = $product['name'];
                            $this->order_item_mdl->quantity = 1;
                            $this->order_item_mdl->price = $price;
                            $this->order_item_mdl->sku_id = 0;
                            $this->order_item_mdl->weight = 0; // $items['options']['weight'];
                            $res = $this->order_item_mdl->create ();
                    
                            if($res)
                            {
                                
                                //修改is_active
                                $this->load->model('Customer_mdl');
                                $this->Customer_mdl->active_account( $user_id );
                    
                                //调用接口处理
                                $url = $this->url_prefix.'Order/code_order';
                    
                                $data_post['relation_id'] = $relation_id;
                                //                                     $data_post['pass'] = $password;
                                $data_post['corp_customer_id'] = $product['customer_id'];
                                $data_post['total_price'] = $price;
                                $data_post['order_sn'] = $order_sn;
                                $data_post['app_id'] =  $this->session->userdata('app_info')['id'];
                                $data['status'] =  ( int ) $this->curl_post_result( $url,$data_post );
                    
                                if($data['status'] == 1)
                                {
                                        $this->db->trans_commit();
                                        $is_ok = true;
                                }
                    
                            }
                        }
                    }else{
                        //余额不足
                        $return['responseMessage'] = array(
                            'messageType' => 'error',
                            'errorType' => '7',
                            'errorMessage' => '支付帐号货豆余额不足，无法支付错误'
                        );
                        print_r(json_encode($return));
                        exit();
                    }
                    
                }else{
                    $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '6',
                        'errorMessage' => '支付密码错误'
                    );
                    print_r(json_encode($return));
                    exit();
                }
            }else{
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '5',
                    'errorMessage' => '没有支付账户'
                );
                print_r(json_encode($return));
                exit();
            }
            
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '二维码错误（商品信息错误）'
            );
            print_r(json_encode($return));
            exit();
            
        }

        if(empty( $is_ok ) && $process)
        {
            $this->db->trans_rollback();
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '8',
                'errorMessage' => '交易失败,请重试！'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => '交易成功！'
        );
        $return['data'] = $data;
        print_r(json_encode($return));
        
    }

    /**
     * 处理分成的方法
     * @$data = 需要分成的比例 次数
     * @$retio_price 分成总金额 /
     * @
     */
	public function order_ratio( $data=array(), $retio_price )
	{
        foreach ($data as $k => $v) {
            $array[$k]['rebate'] = strpos($retio_price * $data[$k]['rebate'] / 100,'.') ? substr_replace($retio_price * $data[$k]['rebate'] / 100, '', strpos($retio_price * $data[$k]['rebate'] / 100, '.') + 3) : $retio_price * $data[$k]['rebate'] / 100;
            $array[$k]['rebate_rate'] = $data[$k]['rebate'] / 100;
            $array[$k]['obj_type'] = $data[$k]['obj_type'];
            $array[$k]['obj_id'] = $data[$k]['obj_id'];
        }
        return $array;
    }
    
    public function curl_get_result( $url ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url.'&key=jiami&port_source='.strtoupper(SUITE) );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return($result);
    }
    
    //curl_post
    public function curl_post_result( $url, $data ){
        $data['key'] = 'jiami';
        $data['port_source'] = strtoupper(SUITE);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
    
        return($result);
    
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */