<?php
/**
 * 活动控制器
 *
 *
 */
class Groupbuy extends Front_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('groupbuy_mdl');
        $this->load->helper('order');
        if (! stristr($_SERVER['HTTP_USER_AGENT'], "Android") && ! stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") && ! stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
            echo "<script>alert('此链接为微信端活动，请在微信打开');history.back(-1);</script>";
            exit();
        }
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 团购首页
     */
    function index()
    {
//         echo $this->session->userdata('app_info')['id'];
        $this->load->model('groupbuy_mdl');
        
        $app = $this->session->userdata('app_info');
        $app_id = $this->session->userdata('app_id');
        $select = 'p.id,p.name,p.vip_price,r.groupbuy_price,r.end_time as groupbuy_end_at,r.menber_num,i.image_name,i.file';
        $data['groupbuy_list'] = $this->groupbuy_mdl->load($select);
        
        $data['title'] = $app["app_name"];
        $data['head_set'] = 5;
        $data['foot_icon'] = 1;
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('groupbuy/groupbuy_home.php', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------

    /**
     * 玩法详情
     */
    function group_rules()
    {
        $data['title'] = '玩法详情';
        $data['head_set'] = 3;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('groupbuy/group_rules', $data);
        $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------

    /**
     * 已经参团就显示自身团信息，没有参团显示当前团信息
     * 拼团详情
     */
    function group_detail()
    {
        $id = $this->input->get('buy_num'); // 团id
        $head_menber = $this->input->get('head_menber'); // 团长id
        $productid = $this->input->get('productid'); // 商品id
                                                     
        // 判断登陆
        if (! $this->session->userdata('user_in')) {
            $url = site_url('activity/groupbuy/group_detail?buy_num=' . $id . '&head_menber=' . $head_menber . '&productid=' . $productid);
            $this->session->set_userdata('ref_from_url', $url);
            redirect('customer/login');
            exit();
        }
        
        // 判断是否已参团
        $order_state = array(
            '4',
            '6',
            '7',
            '9',
            '11',
            '14'
        ); 
        // 订单状态
        $row = $this->groupbuy_mdl->check_group($productid, $order_state);
        if ($row) {
            $id = $row['buy_num'];
            $head_menber = $row['head_menber'];
            $productid = $row['productid'];
        }
        
        // 获取团信息
        $data['product'] = $this->groupbuy_mdl->detail($id, $head_menber, $productid);
        if ($data['product']) {
            // 团存在
            $order_state = array(
                '4',
                '6',
                '7',
                '9',
                '11',
                '14'
            ); // 订单状态
            $data['member'] = $this->groupbuy_mdl->group_member($id, $order_state);
            $data['qty'] = $this->groupbuy_mdl->get_qty_byActivityId($id);
           
        } else {
            // 团不存在
            echo "<script>alert('此团不存在');history.back(-1);</script>";
            exit();
        }
        
        $data['title'] = '拼团详情';
        $data['head_set'] = 2;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('groupbuy/groupbuy_details', $data);
        $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------

    /**
     * 活动时间到期没成团退款 -- 所有
     */
    function refund()
    {
        echo "<meta charset='utf-8'>";
        // 查询出没有成团的订单，已经付款的就退款写log，没有付款的就修改订单状态
        $this->load->model('order_mdl');
        $this->load->model("customer_currency_log_mdl", 'customer_currency_log');
        $this->load->model('pay_account_mdl');
        $order_list = $this->groupbuy_mdl->load_not_group();
        
        $count = '';
        $count_up_order = '';
        $count_up_row = '';
        $count_M_log = '';
        $count_up_order_status = '';
        
        // 开启事物
        $this->db->trans_begin(); // 事物执行方法中的MODEL。
        if (count($order_list) > 0) {
            foreach ($order_list as $v) {
                if ($v['status'] == 4) { // 处理已经付款过的订单
                    
                    $customer_pay = $this->pay_account_mdl->load($v['customer_id']); // 获取订单用户的支付账号信息
                    
                    $up_row = $this->pay_account_mdl->charge_M_credit($customer_pay['id'], $v['total_price']); // 退款给用户
                    
                    $count ++; // 有多少付款订单需要退款
                    
                    if ($up_row)
                        $count_up_row ++; // 执行成功次数
                                             
                    // 上一次平台的提货权交易日志
                    $to_last_m_log = $this->customer_currency_log->load_last('-1');
                    
                    // 平台支出提货权日志
                    $M_credit_data['relation_id'] = '-1';
                    $M_credit_data['id_event'] = '64';
                    $M_credit_data['remark'] = '平台支出-退款';
                    $M_credit_data['type'] = '2';
                    $M_credit_data['amount'] = $v['total_price'];
                    $M_credit_data['order_no'] = $v['order_sn'];
                    $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';
                    $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] - $v['total_price'] : - $v['total_price'];
                    $M_credit_data['customer_id'] = $v['customer_id'];
                    $M_credit_data['status'] = '1';
                    $M_credit_data['app_id'] = $this->session->userdata('app_info')['id'];
                    $M_credit_data['created_at'] = date('Y-m-d H:i:s');
                    
                    $data_to_M_credit_log[] = $M_credit_data;
                    
                    // 支出方提货权日志
                    $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
                    if ($to_M_credit_log){
                        $count_M_log ++;
                    }
                        
                    // 上一次客户提货权交易的日志中的信息
                    $last_m_log = $this->customer_currency_log->load_last($customer_pay['r_id']);
                    
                    // 店主接收退款提货权日志
                    $customer_credit_data['relation_id'] = $customer_pay['r_id'];
                    $customer_credit_data['id_event'] = '63';
                    $customer_credit_data['remark'] = '接收退款';
                    $customer_credit_data['type'] = '1';
                    $customer_credit_data['amount'] = $v['total_price'];
                    $customer_credit_data['order_no'] = $v['order_sn'];
                    $customer_credit_data['beginning_balance'] = $customer_pay['M_credit'];
                    $customer_credit_data['ending_balance'] = $customer_pay['M_credit'] + $v['total_price'];
                    $customer_credit_data['customer_id'] = $v['customer_id'];
                    $customer_credit_data['created_at'] = date('Y-m-d H:i:s');
                    $customer_credit_data['app_id'] = $this->session->userdata('app_info')['id'];
                    $customer_credit_data['state'] = '1'; // 批量插入无法验证是否异常，只能用正常表示
                    $data_customer_M_credit_log[] = $customer_credit_data;
                }
                
                if ($v['status'] == 2 || $v['status'] == 4) { // 下单了，但是到期没有付款的就直接改取消状态。
                    $count_up_order ++;
                    // 处理未付款的订单
                    $status = $v['status'] == 2 ? '10' : '11';
                    $up_order_status = $this->order_mdl->update_order_status($v['id'], $status);
                    if ($up_order_status)
                        $count_up_order_status ++;
                }
                
                // 无效的团订单信息
                $update_groupbuy_status['buy_num'] = $v['activity_id'];
                $update_groupbuy_status['status'] = 2;
                $data_update_groupbuy_status[] = $update_groupbuy_status;
            }
            
            // 修改为无效的团订单
            $data_update_groupbuy_status = $this->array_unique_fb($data_update_groupbuy_status);
            $is_ok_status = $this->groupbuy_mdl->update_status($data_update_groupbuy_status);
            
            if ($count) { // 如果有需要退款的订单才执行
                        // 客户退款日志 -- 批量插入
                
                $data_customer_log = $this->customer_currency_log->bath_add_log($data_customer_M_credit_log);
                
                // 判断各项SQL操作是否执行次数 和 循环一样。
                if (($count == $count_up_row) && $data_customer_log && ($count_M_log == $count) && ($count_up_order == $count_up_order_status) && (count($data_update_groupbuy_status) == $is_ok_status)) {
                    $this->db->trans_commit(); // 提交事物
                    $ok = true;
                    echo 'OK1';
                } else {
                    $this->db->trans_rollback(); // 事物回滚
                    echo 'NO1';
                }
            } else 
                if ($count_up_order) { // 只有取消订单才执行
                                           
                    // 判断各项SQL操作是否执行次数 和 循环一样。
                    if ($count_up_order == $count_up_order_status && (count($data_update_groupbuy_status) == $is_ok_status)) {
                        $this->db->trans_commit(); // 提交事物
                        $ok = true;
                        echo 'OK2';
                    } else {
                        $this->db->trans_rollback(); // 事物回滚
                        echo 'NO3';
                    }
                }
            if ($ok) {
                echo '退款订单数量:' . ($count ? $count : '0') . '<br/>';
                echo '取消订单数量:' . ($count_up_order - $count) . '<br/>';
                echo '总修改数量订单:' . ($count_up_order ? $count_up_order : '0');
            }
        } else {
            echo '无订单可操作';
        }
    }
    
    // --------------------------------------------------------------------

    /**
     * 团购订单页面
     */
    public function groupbuy_confirm($product_id = 0, $buy_num = 0, $buy_amount = 1)
    {
        
        $this->load->model('groupbuy_mdl');
        $user_id = $this->session->userdata("user_id");
        $this->session->set_userdata('ref_from_url', current_url());
        
        // 判断用户是否登录
        if (! $user_id) {
            redirect('customer/login');
            exit();
        }
        
        // 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && ! $this->session->userdata("mobile_exist")) {
            $this->load->model('customer_mdl');
            $customer = $this->customer_mdl->get_customer_info();
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
        
        // 获取团信息
        if ($buy_num) {
            $data['group_info'] = $this->groupbuy_mdl->load_by_buy_num($buy_num);
        }
        
        // 购买数量
        $data['buy_amount'] = $buy_amount;
        
        $check_group_order = $this->groupbuy_mdl->load_grouporder_by_status_num($user_id, $buy_num, $product_id);
        
        if (count($check_group_order) > 0) {
            redirect("activity/groupbuy/group_detail?buy_num=" . $check_group_order[0]['buy_num'] . "&head_menber=" . $check_group_order[0]['head_menber'] . "&productid=" . $product_id);
            exit();
        }
        
        // 收货地址
        $this->load->model('customer_address_mdl');
        $data["address_id"] = $this->input->get_post("address_id");
        $data["address_id"] = isset($data["address_id"]) ? $data["address_id"] : 0;
        
        if ($data["address_id"] == 0) {
            $data['address'] = $this->customer_address_mdl->load_all($user_id);
        } else {
            $data['address']['0'] = $this->customer_address_mdl->load_by_customer($data["address_id"], $user_id);
        }
        $data['product_id'] = $product_id;
        
        // 团购商品信息
        $this->load->model("goods_mdl");
        $this->load->model("corporation_mdl");
        $select = "p.name,p.stock,a.set_limit,a.least_purchase,a.most_purchase,";
        $data['groupbuy_product'] = $this->goods_mdl->get_by_id($product_id, $select, null, true);
        
        $data['groupbuy_product']['corporation_name'] = $this->corporation_mdl->load_id($data['groupbuy_product']['corporation_id'])['corporation_name'];
        
        $data['buy_num'] = $buy_num;
        $data['activity'] = 'groupbuy';
        $data['title'] = "确认订单";
        $data['head_set'] = 2;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        // H5弹窗
        if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
            //调用接口获取支付账户信息
            $url  = $this->url_prefix.'Customer/load_pay_account';
            $post['customer_id'] = $user_id;
            $customer = json_decode($this->curl_post_result($url,$post),true);
            if (empty($customer['pay_passwd']) || !$customer['pay_passwd']) {
            
                $data['bullet_set'] = '1';
                $this->load->view('widget/bullet', $data);
            } else {
                $data['bullet_set'] = '3';
                $this->load->view('widget/bullet', $data);
            }
        }
        $commission = 0;
        
        //如果是企业买家才算手续费--
        $this->load->model('Customer_corporation_mdl');
        $corp_detaile = $this->Customer_corporation_mdl->load( $user_id );
        
        if( !empty($corp_detaile) && $corp_detaile['approval_status'] == 2){
            
            
            //手续费比例
            if( !empty( $corp_detaile['commission_rate'] ) )
            {
                $total_price = $data['groupbuy_product']['groupbuy_price'] * $buy_amount;
                
                $commission = ($corp_detaile['commission_rate']/100) * $total_price;
                
                //比例
                $rebate = $corp_detaile['commission_rate']/100;
                
                $commission = strpos($commission,'.') ? substr_replace($commission, '', strpos($commission, '.') + 3) : $commission;
        
                if($commission < 0.01)
                {
                    $commission = 0;
                }
            }
        
        }
        
        $data['rebate'] = !empty($rebate) ? $rebate : 0;
        $data['commission'] = $commission;
        $this->load->view('order', $data);
//         $this->load->view('_footer', $data);
//         $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------
    
    // 直接付款－》拼团是否满了－》满了开新团，未满验证是否够提货权－》不够提货权转充值页面，够支付－》支付成功验证活动时间内拼团成功否－》是则修改同一团单为成功，商家发货，否标记拼团过期，商家退款
    /**
     * 拼团订单支付、生成订单
     * 
     * @param number $product_id            
     * @param string $buy_num            
     * @param number $address_id            
     */
    public function groupbuy_save_order()
    {
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            $this->session->set_userdata('ref_from_url', current_url());
            redirect('customer/login');
            exit();
        }
        $buy_num = $this->input->post('buy_num'); // 团购单号
        $product_id = $this->input->post('product_id'); // 商品id
        $address_id = $this->input->post('address_id'); // 地址id
        $payment_id = $this->input->post('payment_id'); // 支付账户
        $buy_amount = $this->input->post('buy_amount'); // 购买数量
        $pay_passwd = md5($this->input->post('pay_passwd')); // 密码
        $shipping_fee = $this->input->post('shipping_fee'); // 运费
        $customer_remark = $this->input->post('customer_remark'); // 备注
        $user_id = $this->session->userdata("user_id");
        $relation_id = $this->session->userdata ('pay_relation');
        if (! $product_id || ! $address_id || ! $pay_passwd || ! $buy_amount) {
            $data = array(
                'status' => 62
            ); // 生成订单失败,参数缺失
            echo json_encode($data);
            exit();
        }
        
//         $this->load->model('pay_account_mdl');
        $this->load->model('goods_mdl');
        $this->load->model('groupbuy_mdl');
        $this->load->model('customer_corporation_mdl');
        
        // 商品信息
        $select = "a.set_limit,a.least_purchase,a.most_purchase,";
        $product = $this->goods_mdl->get_by_id($product_id, $select, null, 1);
        $total_groupbuy_price = $product['groupbuy_price'] * $buy_amount; //总价
        // 验证限购信息
        if ($product['set_limit']) {
            if ($buy_amount > $product['most_purchase'] || $buy_amount < $product['least_purchase']) {
                $data = array(
                    'status' => 12
                ); // 购买数量不符合限制要求
                echo json_encode($data);
                exit();
            }
        }
        // 验证库存
        if ($buy_amount > $product['stock']) {
            $data = array(
                'status' => 13
            ); // 库存不足
            echo json_encode($data);
            exit();
        }
        
        // 用户信息
        //接口-验证支付密码
        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
        $customer_pay = json_decode($this->curl_get_result($url),true);
        $pay_account_id = $customer_pay['id']; // 支付账号ID
        $pay_relation_id = $customer_pay['r_id']; // 关联表的ID
        $surplus_m = $customer_pay['M_credit']; // 支付前的提货权余额
        $credit = '0.00'; // 授信
        $time = date('Y-m-d H:i:s');
        if ($customer_pay['credit_start_time'] <= $time && $customer_pay['credit_end_time'] >= $time) {
            $credit = $customer_pay['credit'];
        }
        // 验证支付信息
        if (! $customer_pay || empty($customer_pay['pay_passwd'])) {
            $data = array(
                'status' => 10
            ); // 无密码
            echo json_encode($data);
            exit();
        }
        
        // 团购信息
        $group = $this->groupbuy_mdl->load_by_buy_num($buy_num);
        $group_status = isset($group['status']) ? $group['status'] : 0;
        $group_menber_num = isset($group['menber_num']) ? $group['menber_num'] : 0;
        
        $check_group_order = $this->groupbuy_mdl->load_grouporder_by_status_num($user_id, $buy_num, $product_id);
        
        if (! isset($check_group_order) || count($check_group_order) == 0) {} else {
            $data = array(
                'status' => 1,
                'head_menber' => $check_group_order['0']['head_menber'],
                'buy_num' => $check_group_order['0']['buy_num']
            ); // '已经参加团购'
            echo json_encode($data);
            exit();
        }
        
        if (count($product) > 0 && $product['is_groupbuy'] == 1 && (count($group) > 0 || $buy_num == 0)) {} else {
            $data = array(
                'status' => 2
            ); // '错误订单'
            echo json_encode($data);
            exit();
        }
        
        // 验证团人数是否已经满足
        if ($group_status == 0 || $buy_num == 0) {} else {
            $data = array(
                'status' => 3
            ); // '人数已满'
            echo json_encode($data);
            exit();
        }
        
        // 验证支付密码是否正确
        if ($customer_pay['pay_passwd'] != null && $customer_pay['pay_passwd'] == $pay_passwd) {} else {
            $data = array(
                'status' => 4
            ); // '支付密码错误'
            echo json_encode($data);
            exit();
        }
        
        // 验证余额是否足够
        if ($customer_pay != null && ($customer_pay["M_credit"] + $credit) >= $total_groupbuy_price) {} else {
            $data = array(
                'status' => 10
            ); // '余额不足'
            echo json_encode($data);
            exit();
        }
        
        // 验证团购时间是否过期
        if ($product['groupbuy_end_at'] < $time) {
            $data = array(
                'status' => 11
            ); // '团购过期'
            echo json_encode($data);
            exit();
        }
        
        $this->db->trans_begin(); // 事物执行方法中的MODEL.-----------------------------------------------------
        
        // 开始生成groupbuy订单--------------------------------------
                                  
        // 如果$buy_num为空，一人成团长
        if (empty($buy_num) || $buy_num == 0) {
            $this->groupbuy_mdl->enddate = $product['groupbuy_end_at'];
            $this->groupbuy_mdl->menber_num = 1;
            $this->groupbuy_mdl->productid = $product['id'];
            $this->groupbuy_mdl->head_menber = $user_id;
            $this->groupbuy_mdl->activity_num = $product['activity_num'];
            $this->groupbuy_mdl->status = ($product['menber_num'] == 1) ? 1 : 0;
            
            $buy_num = $this->groupbuy_mdl->create();
            $head_menber = $user_id;
        } else {
            // 修改group表status
            if ($group_menber_num < $product['menber_num'] - 1) {
                $this->groupbuy_mdl->menber_num = $group_menber_num + 1;
            } else {
                $this->groupbuy_mdl->menber_num = $group_menber_num + 1;
                $this->groupbuy_mdl->status = 1;
            }
            $groupbuy_updatenum = $this->groupbuy_mdl->update($buy_num);
            
            $head_menber = $group['head_menber'];
        }
        
        // 结束生成groupbuy订单--------------------------------------
        
        // 开始生成订单--------------------------------------
        
        if (!empty($groupbuy_updatenum) || !empty($buy_num)) {
            $this->load->model('order_mdl');
            $this->load->model('order_item_mdl');
            
            $shipping_fee = 0; // 运费
            /* 插入新订单信息 */
            $this->order_mdl->status = 1; // 支付时修改状态
            $this->order_mdl->customer_id = $user_id;
            $this->order_mdl->payment_id = $this->input->post('payment_id') == NULL ? 2 : $this->input->post('payment_id'); // 支付方式
            $this->order_mdl->shipping_id = 0; // 物流
            $this->order_mdl->total_product_price = $total_groupbuy_price; // 产品总价
            $this->order_mdl->auto_freight_fee = $shipping_fee; // 运费
            $this->order_mdl->total_price = $total_groupbuy_price + $shipping_fee; // 总价格（包含运费）
            $this->order_mdl->corporation_id = $product['corporation_id'];
            $this->order_mdl->customer_remark = $customer_remark;
            $this->order_mdl->activity_type = 1;
            if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
                $this->order_mdl->order_source = 2; // 订单来源
            }
            
            $this->order_mdl->activity_id = $buy_num;
            do {
                $order_sn = get_order_sn(); // 生成订单号
                if ($this->order_mdl->check_order_sn($order_sn)) {
                    $order_exist = true;
                } else {
                    $this->order_mdl->order_sn = $order_sn;
                    $new_order_id = $this->order_mdl->create();
                    $order_exist = false;
                }
            } while ($order_exist); // 如果是订单号重复则重新提交数据
                                    // 订单生成成功执行
            
            if ($new_order_id) {
                /* 插入订单商品 */
                $this->order_item_mdl->order_id = $new_order_id;
                $this->order_item_mdl->product_id = $product['id'];
                $this->order_item_mdl->product_name = $product['name'];
                $this->order_item_mdl->quantity = $buy_amount;
                $this->order_item_mdl->price = $product['groupbuy_price'];
                $this->order_item_mdl->sku_id = 0;
                $this->order_item_mdl->weight = 0;
                $res = $this->order_item_mdl->create();
                if ($res) {
                    // 更改商品库存
                    $this->load->model('product_mdl');
                    $this->product_mdl->update_stock($product['id'], $buy_amount);
                    
                    /* 插入收货人信息 */
                    $this->load->model('customer_address_mdl');
                    $address = $this->customer_address_mdl->load_by_customer($address_id, $user_id);
                    
                    $this->load->model('order_delivery_mdl');
                    $this->order_delivery_mdl->order_id = $new_order_id;
                    $this->order_delivery_mdl->consignee = isset($address['consignee']) ? $address['consignee'] : $this->session->userdata('nick_name');
                    $this->order_delivery_mdl->address = isset($address['address']) ? $address['address'] : "";
                    $this->order_delivery_mdl->province_id = isset($address['province_id']) ? $address['province_id'] : 0;
                    $this->order_delivery_mdl->city_id = isset($address['city_id']) ? $address['city_id'] : 0;
                    $this->order_delivery_mdl->district_id = isset($address['district_id']) ? $address['district_id'] : 0;
                    $this->order_delivery_mdl->contact_phone = isset($address['phone']) ? $address['phone'] : "";
                    $this->order_delivery_mdl->contact_mobile = isset($address['mobile']) ? $address['mobile'] : "";
                    $this->order_delivery_mdl->postcode = isset($address['postcode']) ? $address['postcode'] : "";
                    $row = $this->order_delivery_mdl->create();
                    
                    // 开始支付--------------------------------------
                    
                    if ($row) {
                    
                        // 获取当前交易店主信息
                        $corp_customer = $this->customer_corporation_mdl->corp_load($product['corporation_id']);
                        // 店主的用户ID
                        $corp_customer_id = $corp_customer['customer_id'];
                        
                        // 改状态
                        $up_status = $this->order_mdl->update_order_status($new_order_id, 4);
                        
                        if( $up_status ){ 
                            
                            //通过接口调用扣钱->写日志流程接口
                            $url = $this->url_prefix.'Order/groupbuy_save_order';
                            $data_post['total_groupbuy_price'] = $total_groupbuy_price;
                            $data_post['corp_customer_id'] = $corp_customer_id;
                            $data_post['relation_id'] = $relation_id;
                            $data_post['order_sn'] = $order_sn;
                            $data_post['customer_id'] = $user_id;
                            $data_post['app_id'] = $this->session->userdata('app_info')['id'];
                            $error = json_decode($this->curl_post_result($url,$data_post),true);
                            
                            if ( $error['status'] ) {
                                
                                $this->db->trans_commit(); // 事务结束-----------------------------------------------------
                            
                                $data = array(
                                    'status' => 0,
                                    'head_menber' => $head_menber,
                                    'buy_num' => $buy_num
                                ); // 支付成功
                            
                                 //$this->customer_currency_log_mdl->openid = $this->session->userdata('openid');
                                 //$this->customer_currency_log_mdl->result_message( $M_credit_expend_data ); //消费-微信推送
                                // 发送短信
                        
                                echo json_encode($data);
                                exit();
                            } else {
                                $this->db->trans_rollback();
                                $data = array(
                                    'status' => 7
                                ); // 支付失败
                                echo json_encode($data);
                                exit();
                            }
                            
                        }else { 
                            
                            $data = array(
                                'status' => 6
                            ); // '订单生成失败'
                            $this->db->trans_rollback();
                            echo json_encode($data);
                            exit();
                        }
                       
                    } else {
                        $data = array(
                            'status' => 6
                        ); // '订单生成失败'
                        $this->db->trans_rollback();
                        echo json_encode($data);
                        exit();
                    }
                   
                } else {
                    $data = array(
                        'status' => 64
                    ); // 生成订单失败，订单详情插入失败
                    echo json_encode($data);
                    $this->db->trans_rollback();
                    exit();
                }
            } else {
                $data = array(
                    'status' => 63
                ); // 生成订单失败，订单插入失败
                $this->db->trans_rollback();
                echo json_encode($data);
                exit();
            }
        } else {
            $data = array(
                'status' => 62
            ); // 生成订单失败，groupbuy订单数据插入失败
            $this->db->trans_rollback();
            echo json_encode($data);
            exit();
        }
        
        echo json_encode($data);
        exit();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 二维数组去掉重复值,并保留键值
     * @param unknown $array2D
     * @return mixed
     */
    function array_unique_fb($array2D)
    {
        foreach ($array2D as $k => $v) {
            $v = join(',', $v); // 降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[$k] = $v;
        }
        $temp = array_unique($temp); // 去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v) {
            $array = explode(',', $v); // 再将拆开的数组重新组装
                                    // 下面的索引根据自己的情况进行修改即可
            $temp2[$k]['buy_num'] = $array[0];
            $temp2[$k]['status'] = $array[1];
        }
        return $temp2;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 活动使用微信支付
     */
    function groupbuy_charge()
    {
        
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            $this->session->set_userdata('ref_from_url', current_url());
            redirect('customer/login');
            exit();
        }
        $buy_num = $this->input->post('buy_num'); // 团购单号
        $product_id = $this->input->post('product_id'); // 商品id
        $address_id = $this->input->post('address_id'); // 地址id
        $payment_id = 2; // 支付方式
        $shipping_fee = $this->input->post('shipping_fee'); // 运费
        $customer_remark = $this->input->post('customer_remark'); // 备注
        $buy_amount = $this->input->post('buy_amount'); // 购买数量
        $status = $this->input->post('status');
        $user_id = $this->session->userdata("user_id");
        
        if (! $product_id || ! $address_id || ! $buy_amount) {
            
            $data = array(
                'status' => 6
            ); // '订单提交失败'
            echo json_encode($data);
            exit();
        }
        
        
        $this->load->model('goods_mdl');
        $this->load->model('groupbuy_mdl');
        $this->load->model('customer_currency_log_mdl');
        $this->load->model('customer_corporation_mdl');
        
        // 商品信息
        $select = "a.set_limit,a.least_purchase,a.most_purchase,";
        $product = $this->goods_mdl->get_by_id($product_id, $select, null, 1);
        $total_groupbuy_price = $product['groupbuy_price'] * $buy_amount;
        // 验证限购信息
        if ($product['set_limit']) {
            if ($buy_amount > $product['most_purchase'] || $buy_amount < $product['least_purchase']) {
                
                $data = array(
                    'status' => 12
                ); // 团购失败，购买数量不符合团购限制
                echo json_encode($data);
                exit();
            }
        }
        // 验证库存
        if ($buy_amount > $product['stock']) {
            
            $data = array(
                'status' => 13
            ); //团购失败，库存不足
            echo json_encode($data);
            exit();
            
        }
        
        
        //查询账户余额
        $relation_id = $this->session->userdata ('pay_relation');
        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
        $customer_pay = json_decode($this->curl_get_result($url),true);
        
        $pay_account_id = $customer_pay['id']; // 支付账号ID
        $pay_relation_id = $customer_pay['r_id']; // 关联表的ID
        $surplus_m = $customer_pay['M_credit']; // 支付前的提货权余额
        
        $time = date('Y-m-d H:i:s');
        if( $customer_pay ){
            if(! ($customer_pay['credit_start_time'] <= $time && $customer_pay['credit_end_time'] >= $time) ){
                $customer_pay['credit'] = '0.00'; //如果授信过期
            }
        }
        $available_amount = $surplus_m+$customer_pay['credit']; //可用提货权
        // 团购信息
        $group = $this->groupbuy_mdl->load_by_buy_num($buy_num);
        
        $check_group_order = $this->groupbuy_mdl->load_grouporder_by_status_num($user_id, $buy_num, $product_id);
        if (! isset($check_group_order) || count($check_group_order) == 0) {
            if (count($product) > 0 && $product['is_groupbuy'] == 1 && (count($group) > 0 || $buy_num == '0')) {
                $group_status = isset($group['status']) ? $group['status'] : 0;
                $group_menber_num = isset($group['menber_num']) ? $group['menber_num'] : 0;
                // 验证团人数是否已经满足
                if ($group_status == 0 || $buy_num == 0) {
                    
                    $this->db->trans_begin(); // 事物执行方法中的MODEL.-----------------------------------------------------
                    
                    /**
                     * 计算手续费开始
                     */
                    //店铺信息--
                    $this->load->model('Corporation_mdl');
                    $corp_detaile = $this->Corporation_mdl->load_corp_info( $product['corporation_id'] );
                    $commission = 0;
                    //手续费比例
                    
                    if( !empty( $corp_detaile['commission_rate'] ) )
                    {
                        $commission = ($corp_detaile['commission_rate']/100) * $total_groupbuy_price;
                    
                        $commission = strpos($commission,'.') ? substr_replace($commission, '', strpos($commission, '.') + 3) : $commission;
                    
                        if($commission < 0.01)
                        {
                            $commission = 0;
                        }
                    }
                    /**
                     * 计算手续费结束
                     */
                    // 开始生成订单--------------------------------------
                    
                    $this->load->model('order_mdl');
                    $this->load->model('order_item_mdl');
                    
                    $shipping_fee = 0; // 运费
                    /* 插入新订单信息 */
                    $this->order_mdl->status = 10; // 支付时修改状态
                    $this->order_mdl->customer_id = $user_id;
                    $this->order_mdl->payment_id = $this->input->post('payment_id') == NULL ? 2 : $this->input->post('payment_id'); // 支付方式
                    $this->order_mdl->shipping_id = 0; // 物流
                    $this->order_mdl->total_product_price = $total_groupbuy_price; // 产品总价
                    $this->order_mdl->auto_freight_fee = $shipping_fee; // 运费
                    $this->order_mdl->total_price = $total_groupbuy_price + $shipping_fee; // 总价格（包含运费）
                    $this->order_mdl->corporation_id = $product['corporation_id'];
                    $this->order_mdl->customer_remark = $customer_remark;
                    $this->order_mdl->activity_type = 1;
                    $this->order_mdl->commission = $commission;
                    if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
                        $this->order_mdl->order_source = 2; // 订单来源
                    }
                    
                    $this->order_mdl->activity_id = $buy_num;
                    do {
                        $order_sn = get_order_sn(); // 生成订单号
                        if ($this->order_mdl->check_order_sn($order_sn)) {
                            $order_exist = true;
                        } else {
                            $this->order_mdl->order_sn = $order_sn;
                            $new_order_id = $this->order_mdl->create();
                            $order_exist = false;
                        }
                    } while ($order_exist); // 如果是订单号重复则重新提交数据
                                            // 订单生成成功执行
                    
                    if ($new_order_id) {
                        /* 插入订单商品 */
                        $this->order_item_mdl->order_id = $new_order_id;
                        $this->order_item_mdl->product_id = $product['id'];
                        $this->order_item_mdl->product_name = $product['name'];
                        $this->order_item_mdl->quantity = $buy_amount;
                        $this->order_item_mdl->price = $product['groupbuy_price'];
                        $this->order_item_mdl->sku_id = 0;
                        $this->order_item_mdl->weight = 0;
                        $res = $this->order_item_mdl->create();
                        if ($res) {
                            // 更改商品库存
                            $this->load->model('product_mdl');
                            $this->product_mdl->update_stock($product['id'], $buy_amount);
                            
                            /* 插入收货人信息 */
                            $this->load->model('customer_address_mdl');
                            $address = $this->customer_address_mdl->load_by_customer($address_id, $user_id);
                            
                            $this->load->model('order_delivery_mdl');
                            $this->order_delivery_mdl->order_id = $new_order_id;
                            $this->order_delivery_mdl->consignee = isset($address['consignee']) ? $address['consignee'] : $this->session->userdata('nick_name');
                            $this->order_delivery_mdl->address = isset($address['address']) ? $address['address'] : "";
                            $this->order_delivery_mdl->province_id = isset($address['province_id']) ? $address['province_id'] : 0;
                            $this->order_delivery_mdl->city_id = isset($address['city_id']) ? $address['city_id'] : 0;
                            $this->order_delivery_mdl->district_id = isset($address['district_id']) ? $address['district_id'] : 0;
                            $this->order_delivery_mdl->contact_phone = isset($address['phone']) ? $address['phone'] : "";
                            $this->order_delivery_mdl->contact_mobile = isset($address['mobile']) ? $address['mobile'] : "";
                            $this->order_delivery_mdl->postcode = isset($address['postcode']) ? $address['postcode'] : "";
                            $row = $this->order_delivery_mdl->create();
                            
                            if ($row) {
                                
                                $is_pass = true;
                                if( !empty($status) ){ //全额微信支付
                                    
                                    $data['amount'] = $total_groupbuy_price + $commission;
                                    $pay_commission = $order['commission'];
                                
                                }else{
                                    //扣除现金账户以外->还需支付的手续费
                                    $pay_commission = empty($commission) ? 0.00 :  $customer_pay['cash'] >= $commission ? 0.00 :  $commission - $customer_pay['cash'];
                                    
                                    //提货权+微信支付。
                                    if( $available_amount >= $total_groupbuy_price)
                                    {
                                        $data["amount"] = $pay_commission;
                                    }else{
                                        $data["amount"] = round($total_groupbuy_price - $available_amount,2) + $pay_commission;
                                    }
                                    
                                    $password = md5($this->input->post('pay_passwd') );
                                    //验证支付密码是否正确
                                    if( $password != $customer_pay['pay_passwd'] ){
                                        $is_pass = false;
                                    }
                                }
                                
                                if(!$is_pass){
                                    $this->db->trans_rollback();
                                    $data = array(
                                        'status' => 4
                                    ); //支付密码错误
                                    echo json_encode($data);
                                    exit();
                                }
                                //生成订单，前端转跳微信
                                $data['commission']= $pay_commission;
                                $data["payment_id"] = $payment_id;
                                $data['customer_id'] = $user_id;
                                $data['order_sn'] = $order_sn;
                                $data['order_source'] = 2;
                                $this->load->model("charge_mdl", "charge");
                            
                                do {
                                    $data['chargeno'] = get_order_sn();
                            
                                    if ($this->charge->load_byChangeNum($data['chargeno'])) {
                                        $order_exist = true;
                                    } else {
                                        $new_charge_id = $this->charge->create($data);
                                        $order_exist = false;
                                    }
                                } while ($order_exist); // 如果是订单号重复则重新提交数据
                                
                                if ( $new_charge_id ) {
                                    $this->db->trans_commit();
                                    $is_ok = true;
                                    // 微信调用支付--------------------------------------
                                     
                                    //                         redirect('wechatpay/js_api_call/pay/' . $new_charge_id);
                                    $data = array(
                                        'status' => 0,
                                        'charge_id' => $new_charge_id
                                    ); //生成订单成功
                                    echo json_encode($data);
                                    exit();
                                    return;
                                }
                            }
                        }
                    }
                    
                    if( empty($is_ok) ){ 
                        
                        $this->db->trans_rollback();
                        $data = array(
                            'status' => 8
                        ); //交易失败,请重试
                        echo json_encode($data);
                        exit();
                    }
                        
                } else {
                    $data = array(
                        'status' => 3
                    ); //人数已满
                    echo json_encode($data);
                    exit();
                }
            } else {
                $data = array(
                    'status' => 2
                ); //错误订单
                echo json_encode($data);
                exit();
            }
        } else {
            $data = array(
                'status' => 1,
                'head_menber' => $check_group_order['0']['head_menber'],
                'buy_num' => $check_group_order['0']['buy_num']
            ); // 已经参加本商品团购
            echo json_encode($data);
            exit();
        }
    }
}
