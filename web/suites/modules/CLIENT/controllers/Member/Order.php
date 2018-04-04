<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Order extends Front_Controller {
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		
		$get_url = '/?';
		if(!empty($_SERVER["QUERY_STRING"] ) ){ 
		    $get_url .= $_SERVER["QUERY_STRING"];
		}
		
	    $this->session->set_userdata ( 'ref_from_url', current_url ().$get_url ); // 统一使用ref_from_url
		if (! $this->session->userdata ( 'user_in' )) {
		    $this->session->set_userdata ( 'ref_from_url', current_url ().$get_url ); // 待废除，与关键字重复
			redirect ( 'customer/login' );
			exit ();
		}
		// 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && !$this->session->userdata("mobile_exist") ) {
            $customer_id = $this->session->userdata("user_id");
            $this->load->model("customer_mdl");
            $customer = $this->customer_mdl->load($customer_id);
            
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
	}
	
	// 我的订单列表
	public function index($status='') {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('order_mdl');
        
        $config['per_page'] = 5;
        $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
        
        $this->load->library('pagination');
        if (0 == $current_page) {
            $current_page = 1;
        }
        $offset = ($current_page - 1) * $config['per_page'];
        
        if (empty($status)) {
            $config['base_url'] = site_url('member/order/index/?');
        } else {
            $config['base_url'] = site_url('member/order/index/' . $status . '/?');
        }
        
        $offset = ($current_page - 1) * $config['per_page'];
        
        switch ($status) {
            case 1: // 待付款
                $status_array = array(
                    'status' => array(
                        1,
                        2
                    )
                );
                break;
            case 2: // 待发货
                $status_array = array(
                    'status' => array(
                        3,
                        4
                    )
                );
                break;
            case 3: // 待收货
                $status_array = array(
                    'status' => array(
                        6
                    )
                );
                break;
            case 4: // 评价
                $status_array = array(
                    'status' => array(
                        7,
                        9,
                        14
                    )
                );
                break;
            case 5: // 已取消
                $status_array = array(
                    'status' => array(
                        10
                    )
                );
                break;
            case 6: // 待发货+待收货
                $status_array = array(
                    'status' => array(
                        3,
                        4,
                        6
                    )
                );
                break;
            default:
                $status_array['status'] = null;
                break;
        }
        $status_array['type'] = 'PC';
        if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) 
        {
            $status_array['type']= 'H5';
        }
        $data['orders'] = $this->order_mdl->find_customer_orders_with_goods($user_id, ($status_array?$status_array:array()), $config['per_page'], $offset);
        
        $config['total_rows'] = $this->order_mdl->find_customer_orders_with_goods($user_id,$status_array);
        
        $config['per_page'] = $config['per_page'];
        $config['curr_page'] = $current_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 3; // 可以看到当前页后面的3页a连接
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $data['title'] = '我的订单列表';
        $data['back'] = 'member/info';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        $data['total'] = $this->order_mdl->count_orders($user_id);
        $data['unfinish'] = $this->order_mdl->count_wait_pay_orders($user_id,array('1','2'));
        $data['finished'] = $this->order_mdl->count_dispatch_orders($user_id);
        $data['cancel'] = $this->order_mdl->count_receive_orders($user_id);
        $data['allorder'] = $config['total_rows'];
        $data['per_page'] = $config['per_page'];
        $data['curr_page'] = $config['curr_page'];
        $data['statu'] = $status;
        
        $data['sta'] = $status;
//         echo '<pre>';
//         print_r($data);exit;
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
        $this->load->view('customer/order_list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
	
	// 订单详情
	public function detail($order_id = 0) 
	{
        if (! $order_id) {
            // 跳转404页面
            redirect('member/order');
        }
        
        $user_id = $this->session->userdata('user_id');
        // 加载订单信息
        $this->load->model('order_mdl');
        $sift['where']['id']= $order_id;
        $data['order'] = $this->order_mdl->Order_Detaile($sift);
//         echo $this->db->last_query();
        if ( empty( $data['order'] )  || $data['order']['customer_id'] != $user_id) {
            // 不是该用户的订单
            // 跳转404页面
            redirect('member/order');
        }
        // 加载订单商品信息
        $data['order_items'] = $this->order_mdl->find_order_items($order_id);
       
        
        // 加载团信息
        if (isset($data['order']['activity_type']) && $data['order']['activity_type'] == 1) {
            $this->load->model("groupbuy_mdl");
            $data['group_info'] = $this->groupbuy_mdl->load_by_buy_num($data['order']['activity_id']);
            if(!isset($data['group_info']['status'])){
                $data['order']['status'] = 16;
            }else{
                $data['order']['status'] = $data['group_info']['status'] != 2 ? ($data['group_info']['status'] == 0 ? 15 : $data['order']['status']) : 16;
            }
        }
        
        foreach ($data['order_items'] as $key => $v) {
//             if ($v['sku_id'] != 0) {
//                 $this->load->model('product_sku_mdl');
//                 $sku = $this->product_sku_mdl->getSKUByValID($v['sku_id']);
//                 foreach ($sku as $k => $s) {
//                     $sku_name[$k] = $s['attr_name'] . "：" . $s['sku_name'];
//                 }
//                 $data['order_items'][$key]['sku_name'] = $sku_name;

                
//             }
            if( !empty($v['sku_value']) )
            {  
                $data['order_items'][$key]['sku_name'] = explode(',',$v['sku_value']);
            }
           
        }
        
        
        // 加载送货地址信息
        $this->load->model('order_delivery_mdl');
        $data['order_delivery'] = $this->order_delivery_mdl->load($order_id);
        
        if (count($data['order_delivery']) != 0) {
            $this->load->model('region_mdl');
            $data['order_delivery']['province'] = $this->region_mdl->get_name($data['order_delivery']['province_id']);
            $data['order_delivery']['city'] = $this->region_mdl->get_name($data['order_delivery']['city_id']);
            $data['order_delivery']['district'] = $this->region_mdl->get_name($data['order_delivery']['district_id']);
        }
        
        // 顾客
        $this->load->model('customer_mdl');
//         $data['customer'] = $this->customer_mdl->load($this->session->userdata('user_id'));
        // 店铺
        $this->load->model("corporation_mdl");
//         $data['corporation'] = $this->corporation_mdl->load_id($data['order']['corporation_id']);
        
        $data['title'] = '订单详细';
        $data['back'] = 'member/order';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
//        echo '<pre>';
//        print_r($data);exit;
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
        $this->load->view('customer/order_detail', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
	
	//------------------------------------------------------------------------------------------------------------------------------------------------
	
	/**
	 * 删除模块
	 * @param number $order_id
	 */
	public function delete($order_id = 0) {
        if (! $order_id) {
            redirect('member/order');
            exit();
        }
        
        $this->load->model('order_mdl');
        
        $order = $this->order_mdl->load($order_id);
        
        // 检查订单是否属于该用户
        if ($order['customer_id'] != $this->session->userdata('user_id')) {
            redirect('member/order');
            exit();
        }
        
        if ($this->order_mdl->delete($order_id)) {
            redirect('member/order');
        }
    }
	
	/**
	 * 订单作废
	 */
	public function isExpired($id){
        $this->load->model('order_mdl');
        $res = $this->order_mdl->isExpired($id);
    }
    
    
    //验证支付信息
    private function verify_order( $order_id = 0){ 
        if (! $order_id) {
            return $data['status'] = 0;
        }
        
        $this->load->model ( 'order_mdl' );
        $user_id = $this->session->userdata ( 'user_id' );
        $relation_id = $this->session->userdata ('pay_relation');
        $order = $this->order_mdl->load_with_userid ( $order_id, $user_id );
        
      
        //查询账户余额
        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
        $pay_info = json_decode($this->curl_get_result($url),true);
        $time = date('Y-m-d H:i:s');
       
        if( $pay_info ){
            if(! ($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time) ){
                $pay_info['credit'] = '0.00';
            }
        }
        
        if( $order && $pay_info ){
            $data['status'] = true;
            $data['order'] = $order;
            $data['pay_info'] = $pay_info;
            return $data;
        }
        
         return $data['status'] = 0;
    }
    
    /**
     * 订单支付页面
     */
    public function order_pay($order_id = 0) {
        $data = $this->verify_order($order_id);
        if( $data['status'] ){
            
            $order = $data['order']; //订单信息
            $pay_info = $data['pay_info']; //支付账户信息
            $available_amount = $pay_info['credit']+$pay_info['M_credit']; //剩余可用余额
            
            if($available_amount >= $order['total_price']){ 
                //货豆余额足以支付
                $data['show_m_pay'] = true;
            }else{ 
                //余额不足以支付
                $data['show_m_pay'] = false;
            }
            
            if(empty($pay_info['pay_passwd']) ){
                $data['not_password'] = true;
            }
            
            $data['user_total_price'] = $available_amount;
            $data['order_id'] = $order['id'];
            $data['total_price'] = $order['total_price'];
            $data['type'] = 1;//订单类型
            $data ['title'] = '订单支付';
            $data['back'] = 'member/order';
            $data['head_set'] = 2;
            $this->load->view ( 'head', $data );
    		$this->load->view ( '_header' );
            $this->load->view ( 'order/order_pay', $data );
            $this->load->view ( '_footer', $data );
            $this->load->view ( 'foot', $data );
            
        }else{ 
            
            redirect('member/order');
        }
    }
    
    
    /**
     * 拼团活动支付页面
     */
    public function groupbuy_pay(){
        $data['address_id'] = $this->input->get('address_id');
        $data['buy_num'] = $this->input->get('buy_num');
        $data['product_id'] = $this->input->get('product_id');
        $data['customer_remark'] = $this->input->get('customer_remark');
        $data['buy_amount'] = $this->input->get('buy_amount');
        $user_id = $this->session->userdata ( 'user_id' );
        $relation_id = $this->session->userdata ('pay_relation');
        
        
        $this->load->model('goods_mdl');
        $product = $this->goods_mdl->get_by_id($data['product_id'], null, null, 1);
        $total_price = $product['groupbuy_price'] * $data['buy_amount']; //需要支付的货豆
        
        //查询账户余额
        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
        $pay_info = json_decode($this->curl_get_result($url),true);
        
        $time = date('Y-m-d H:i:s');
        if( $pay_info ){
            if(! ($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time) ){
                $pay_info['credit'] = '0.00';
            }
        }
        $available_amount = $pay_info['credit']+$pay_info['M_credit']; //剩余可用余额
        
        if($available_amount >= $total_price ){
            //货豆余额足以支付
            $data['show_m_pay'] = true;
        }else{
            //余额不足以支付
            $data['show_m_pay'] = false;
        }
        
        if(empty($pay_info['pay_passwd']) ){
            $data['not_password'] = true;
        }
        
        $data['type'] = 2;//活动支付类型 
        $data['user_total_price'] = $available_amount;
        $data['total_price'] = $total_price;
        $data['head_set'] = 2;
        $data ['title'] = '订单支付';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header' );
        $this->load->view ( 'order/order_pay', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
        
    }
    
    
    /**
     * 面对面支付页面--！
     */
    
    public function code_pay( $product_id = 0, $corp_id = 0)
    {
         
        $price = $this->input->get('price');
        $relation_id = $this->session->userdata ('pay_relation');
        if(!empty($product_id) && !empty($corp_id) && $price >= 0.01){
    
    
            //判断该店铺&&商品是否存在，是否二维码商品
            $options["type"] = 'sale';
            $options['corporation_id'] = $corp_id;
            $options['conditions'] = array(
                "p.is_mc" => '1',
                "p.id" => $product_id
            );
    
            $options['row'] = true;
            $this->load->model('product_mdl');
            $product_info = $this->product_mdl->find_products($options,false);
    
            if($product_info){
    
                //查询账户余额
                $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
                $pay_info = json_decode($this->curl_get_result($url),true);
                $time = date('Y-m-d H:i:s');
                if( $pay_info ){
    
                    if(! ($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time) ){
                        $pay_info['credit'] = '0.00';
                    }
    
                    $available_amount = $pay_info['credit']+$pay_info['M_credit']; //剩余可用余额
    
                    if($available_amount >= $price )
                    {
                        //货豆余额足以支付
                        $data['show_m_pay'] = true;
                    }else{
                        //余额不足以支付
                        $data['show_m_pay'] = false;
                    }
    
    
                }else{
    
                    $message = '支付账户不存在，无法进行交易';
                }
                 
            }else{
                //无此商品
                $message = '商品错误，请联系店主';
            }
        }
        
        if(empty($pay_info['pay_passwd']) ){
            $data['not_password'] = true;
        }
        
    
        if( !empty($message) )
        {
    
            echo '<meta charset="utf-8">
	        <script type="text/javascript">
                alert("'.$message.'");
            </script>';
            exit;
        }
    
    
        $data['type'] = 3;//面对面类型
        $data['user_total_price'] = $available_amount;
        $data['corp_id'] = $product_info['corporation_id'];
        $data['product_id'] = $product_info['id'];
        $data['total_price'] = $price;
        $data['head_set'] = 4;
        $data ['title'] = '订单支付';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header' );
        $this->load->view ( 'order/order_pay', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    
    }
    
    
    /**
     * 批量支付订单页面
     */
    public function all_order_pay()
    { 
        $order_id = $this->input->get('order_id');
        $order_id_array = explode(',',$order_id );
        $relation_id = $this->session->userdata ('pay_relation');
        
        if( $order_id_array )
        { 
            $this->load->model('order_mdl');
            $this->order_mdl->customer_id = $this->session->userdata("user_id");
            $this->order_mdl->status = 2;
            $order_info = $this->order_mdl->all_order_price( $order_id_array );
            
            if( $order_info['id_num'] == count($order_id_array) )
            { 
                
                //查询账户余额
                $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
                $pay_info = json_decode($this->curl_get_result($url),true);
                $time = date('Y-m-d H:i:s');
                
                if( $pay_info ){
                
                    if(! ($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time) ){
                        $pay_info['credit'] = '0.00';
                    }
                    
                    $available_amount = $pay_info['credit']+$pay_info['M_credit']; //剩余可用余额
                    
                    if($available_amount >= $order_info['total_price']){
                        //货豆余额足以支付
                        $data['show_m_pay'] = true;
                    }else{
                        //余额不足以支付
                        $data['show_m_pay'] = false;
                    }
                    
                    if(empty($pay_info['pay_passwd']) ){
                        $data['not_password'] = true;
                    }
                    
                    $data['user_total_price'] = $available_amount;
                    
                    $data['order_id'] = $order_id;
                    $data['total_price'] = $order_info['total_price'];
                    $data['type'] = 4;//订单类型
                    $data ['title'] = '订单支付';
                    $data['back'] = 'member/order';
                    $data['head_set'] = 2;
                    $this->load->view ( 'head', $data );
                    $this->load->view ( '_header' );
                    $this->load->view ( 'order/order_pay', $data );
                    $this->load->view ( '_footer', $data );
                    $this->load->view ( 'foot', $data );
                    
                }else{ 
                    //支付账户不存在
                    $message = '支付账户不存在，无法进行交易';
                } 
                
            }else{ 
                
                $message = '订单或已支付，请勿重复提交';
            }
        
        }
        

        if( !empty($message) )
        {
        
            echo '<meta charset="utf-8">
	        <script type="text/javascript">
                alert("'.$message.'");
                location.href = "'.site_url('Member/order').'";
            </script>';
            exit;
        }
        
    }
    /**
     * 微信支付订单(拼团&&普通订单)
     */
    public function wechat_pay(){
         
        $this->load->helper('order');
        $order_id = $this->input->post('id');
        $status = $this->input->post('status');
        $no_pwd = $this->input->post('no_pwd');//验证货豆金额是否为零，零则不进行对支付密码验证
        $data = $this->verify_order($order_id);
        
        if( $data['status'] ){
            
            $order = $data['order'];
            
            if( !in_array($order['status'], array(4,7,9,14) ) ){
                
               
                $pay_info = $data['pay_info'];
                $is_pass = true; 
                //可用余额
                $available_amount = $data['pay_info']['credit']+$data['pay_info']['M_credit'];
                
                //判断应该发起的支付金额是多少
                if( !empty($status) ){ //全额微信支付
                   
                     $charge_data['amount'] = $order['total_price'];
                     
                }else{ 
                    
                     //货豆+微信支付。
                     $charge_data["amount"] = round($order['total_price'] - $available_amount,2);
                     
                     $password = md5($this->input->post('pass') );
                     if(empty($no_pwd)){
                         //验证支付密码是否正确
                         if( $password != $pay_info['pay_passwd'] ){
                             $is_pass = false;
                         }
                     }
                }
                
                if( $is_pass ){ //支付密码验证成功
                    
                    $charge_data["payment_id"] = 2;//微信支付
                    $charge_data['order_source'] = 2; //H5支付
                    $charge_data['order_sn'] = $order['order_sn'];
                    $charge_data['customer_id'] = $this->session->userdata("user_id");
                    $this->load->model("charge_mdl", "charge");
                    do {
                        $charge_data['chargeno'] = get_order_sn();
                    
                        if ($this->charge->load_byChangeNum( $charge_data['chargeno']) ) {
                            $order_exist = true;
                        } else {
                            $new_charge_id = $this->charge->create($charge_data);
                            $order_exist = false;
                        }
                    } while ($order_exist); // 如果是订单号重复则重新提交数据
                    
                    
                    if( $new_charge_id ){ 
                        //转跳开始支付
            
                        $error['status'] = 1;
                        $error['charge_id'] = $new_charge_id;
                    }else{ 
                        //支付失败，请重试
                        $error['status'] = 5;//支付失败
                    }
                }else{ 
                    //支付密码错误
                    $error['status'] = 3;
                }
            }else{ 
                $error['status'] = 6; //或已完成支付
                $error['id'] = $order['id'];
            }
        }else{ 
            $error['status'] = 2;//错误订单
        }
        
        echo json_encode($error);
    }
    
    
    /**
     * 面对面全款货豆支付方法
     */
    public function pay_code_order()
    {
        $price = $this->input->post('total_price');
        $password = $this->input->post('pass');
        $product_id = $this->input->post('product_id');
        $corp_id = $this->input->post('corp_id');
        $relation_id = $this->session->userdata ('pay_relation');
        $data['status'] = false;
        
        if( !empty($price)  && !empty($password) && !empty($product_id) && !empty($corp_id) )
        { 

            
            //判断该店铺&&商品是否存在，是否二维码商品
            $options["type"] = 'sale';
            $options['corporation_id'] = $corp_id;
            $options['conditions'] = array(
                "p.is_mc" => '1',
                "p.id" => $product_id
            );
            
            $options['row'] = true;
            $this->load->model('product_mdl');
            $product_info = $this->product_mdl->find_products($options,false);
            
            
            $this->db->trans_begin(); // 事物执行方法中的MODEL.
            $process = true; //进入事物的标志
            if($product_info)
            {
            
                //查询账户余额
                $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
                $pay_info = json_decode($this->curl_get_result($url),true);
                $time = date('Y-m-d H:i:s');
                
                if( $pay_info )
                {
                    
                    if($pay_info['pay_passwd'] == md5($password) )
                    {
                        
                        if(! ($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time) ){
                            $pay_info['credit'] = '0.00';
                        }
                    
                        $available_amount = $pay_info['credit']+$pay_info['M_credit']; //剩余可用余额
                    
                        if($available_amount >= $price )
                        {
                            
                            $customer_id = $this->session->userdata('user_id');
                            /* 插入新订单信息 */
                            $this->load->helper ( 'order' );
                            $this->load->model ( 'order_mdl' );
                            $this->load->model ( 'product_cat_mdl' );
                            //查询比率
                            $result = $this->product_cat_mdl->Load_Leve_One_Two($product_info['cat_id']);
                            $rebate =  !empty($result) ? $result[0]['poundage'] : 0;
                            
                            $this->order_mdl->customer_id = $customer_id;
                            $this->order_mdl->payment_id = 5; //扫码支付
                            $this->order_mdl->shipping_id = 0; // $shipping_id;
                            $this->order_mdl->total_product_price = $price;
                            $this->order_mdl->total_price = $price;
                            $this->order_mdl->corporation_id = $corp_id;
                            $this->order_mdl->pay_time = date('Y-m-d H:i:s');
                            $this->order_mdl->status = 14; //订单默认是支付成功，待付款后改变状态
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
                        
                        
                            if($new_order_id)
                            {
                        
                                /* 插入消费表 */
                                $this->load->model ( 'order_item_mdl' );
                                $this->order_item_mdl->order_id = $new_order_id;
                                $this->order_item_mdl->product_id = $product_id;
                                $this->order_item_mdl->product_name = $product_info['name'];
                                $this->order_item_mdl->quantity = 1;
                                $this->order_item_mdl->price = $price;
                                $this->order_item_mdl->sku_id = 0;
                                $this->order_item_mdl->weight = 0; // $items['options']['weight'];
                                $res = $this->order_item_mdl->create ();
                        
                                if($res)
                                {
                                    //分成
                                    $order_info['total_price'] = $price;
                                    $order_info['id'] = $new_order_id;//订单ID
                                    $order_info['order_sn'] = $order_sn;//订单号码
                                    $order_info['corporation_id']  = $corp_id;//店铺ID
                                    $order_info['commission'] = $this->order_mdl->commission;
                                    $order_info['customer_id'] = $customer_id;
                                    
                                    $this->load->model ( 'order_rebate_mdl' );
                                    
                                    if( $this->order_rebate_mdl->order_rebate($order_info) ){
                                    
                                        //调用接口处理     
                                        $url = $this->url_prefix.'Order/code_order';
                                        
                                        $data_post['relation_id'] = $relation_id;
    //                                     $data_post['pass'] = $password;
                                        $data_post['corp_customer_id'] = $product_info['customer_id'];
                                        $data_post['total_price'] = $price;
                                        $data_post['order_sn'] = $order_sn;
                                        $data_post['app_id'] =  $this->session->userdata('app_info')['id'];
                                        $data_post['C_commission'] = $this->order_mdl->commission;
                                        $data['status'] =  ( int ) $this->curl_post_result( $url,$data_post );
                                        
                                        if($data['status'] == 1)
                                        { 
                                            $this->db->trans_commit();
                                            $is_ok = true;
                                            $data['id'] = $new_order_id;
                                            
                                            //修改为不是第一次购买了。
                                            $this->load->model('Customer_mdl');
                                            $this->Customer_mdl->active_account( $customer_id );
                                        }
                                    }
                                }
                            }
                        }else{ 
                            //余额不足
                            $data['status'] = 4;
                        }
                    }else{ 
                        //密码错误
                        $data['status'] =3;
                    }
                }else{ 
                    $data['status'] = 5;
                    //无支付账户
                }
            }else{
                //无此商品
                $data['status'] = 2;
            }
            
        }else{ 
            $data['status'] = 255;//缺少参数
        }
        
        if(empty( $is_ok ) && $process)
        { 
            $this->db->trans_rollback();
        }
        
        echo json_encode($data);
    }
    
    
    /**
     * 面对面支付-微信支付。
     */
    public function wechat_code_pay(){ 
        $price = $this->input->post('total_price');
        $password = $this->input->post('pass');
        $product_id = $this->input->post('product_id');
        $corp_id = $this->input->post('corp_id');
        $relation_id = $this->session->userdata ('pay_relation');
        $status = $this->input->post('status');
        
        //判断该店铺&&商品是否存在，是否二维码商品
        $options["type"] = 'sale';
        $options['corporation_id'] = $corp_id;
        $options['conditions'] = array(
            "p.is_mc" => '1',
            "p.id" => $product_id
        );
        
        $options['row'] = true;
        $this->load->model('product_mdl');
        $product_info = $this->product_mdl->find_products($options,false);
        
        if( $product_info ){
            
            $this->load->helper('order');
            
            //查询账户余额
            $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
            $pay_info = json_decode($this->curl_get_result($url),true);
            $time = date('Y-m-d H:i:s');
            
            if(! ($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time) ){
                $pay_info['credit'] = '0.00';
            }
            
            $is_pass = true;
            
            //可用余额
            $available_amount = $pay_info['credit']+$pay_info['M_credit'];
    
            //判断应该发起的支付金额是多少
            if( !empty($status) ){ //全额微信支付
                 
                $charge_data['amount'] = $price;
                 
            }else{
    
                //货豆+微信支付。
                $charge_data["amount"] = round($price - $available_amount,2);
                $password = md5($password);
    
                //验证支付密码是否正确
                if( $password != $pay_info['pay_passwd'] ){
                    $is_pass = false;
                }
                 
            }
    
            if( $is_pass )
            { //支付密码验证成功
    
                
                //生成订单
                $customer_id = $this->session->userdata('user_id');
                /* 插入新订单信息 */
                
                $this->load->model ( 'product_cat_mdl' );
                //查询比率
                $result = $this->product_cat_mdl->Load_Leve_One_Two($product_info['cat_id']);
                $rebate =  !empty($result) ? $result[0]['poundage'] : 0;
                
                $this->load->helper ( 'order' );
                $this->load->model ( 'order_mdl' );
                $this->order_mdl->customer_id = $customer_id;
                $this->order_mdl->payment_id = 5; //扫码支付
                $this->order_mdl->shipping_id = 0; // $shipping_id;
                $this->order_mdl->total_product_price = $price;
                $this->order_mdl->total_price = $price;
                $this->order_mdl->corporation_id = $corp_id;
                $this->order_mdl->status = 10; //订单默认是支付成功，待付款后改变状态
                $this->order_mdl->commission = $price*$rebate;
                
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
                
                if( $new_order_id )
                { 
                    //生成消费数据
                    $this->load->model ( 'order_item_mdl' );
                    $this->order_item_mdl->order_id = $new_order_id;
                    $this->order_item_mdl->product_id = $product_id;
                    $this->order_item_mdl->product_name = $product_info['name'];
                    $this->order_item_mdl->quantity = 1;
                    $this->order_item_mdl->price = $price;
                    $this->order_item_mdl->sku_id = 0;
                    $this->order_item_mdl->weight = 0; // $items['options']['weight'];
                    $res = $this->order_item_mdl->create ();
                    
                    if( $res )
                    { 
                        //生成充值记录
                        $charge_data["payment_id"] = 2;//微信支付
                        $charge_data['order_source'] = 2; //H5支付
                        $charge_data['order_sn'] = $order_sn;
                        $charge_data['customer_id'] = $this->session->userdata("user_id");
                        $this->load->model("charge_mdl", "charge");
                        do {
                            $charge_data['chargeno'] = get_order_sn();
                        
                            if ($this->charge->load_byChangeNum( $charge_data['chargeno'] ) ) {
                                $order_exist = true;
                            } else {
                                $new_charge_id = $this->charge->create($charge_data);
                                $order_exist = false;
                            }
                        } while ($order_exist); // 如果是订单号重复则重新提交数据
                        
                        
                        if( $new_charge_id ){
                            //转跳开始支付
                        
                            $error['status'] = 1;
                            $error['charge_id'] = $new_charge_id;
                        }else{
                            //支付失败，请重试
                            $error['status'] = 5;//支付失败
                        }
                    }
                }
                
            }else{
                //支付密码错误
                $error['status'] = 3;
            }
        }else{ 
            //无商品
            $error['status'] = 2;
        }
        echo json_encode($error);
        
    }
    
    /**
     * 批量微信支付订单
     */
    public function wechat_allorder_pay()
    { 
        $order = $this->input->post('order');
        $status = $this->input->post('status');
        $relation_id = $this->session->userdata ('pay_relation');
        $no_pwd = $this->input->post('no_pwd');//验证货豆金额是否为零，零则不进行对支付密码验证
        
        
        //存储订单ID的数据
        $order_id_array = array();
        //处理成数组
        $order_id_array = explode(',',$order);
        
        //判断是否有ID
        if( $order_id_array )
        { 
            //批量查询订单
            $this->load->model('order_mdl');
            $order_all_info = $this->order_mdl->load_orderall( $order_id_array );
            
            //如果订单查询出来数量一致。
            if( count($order_id_array) == count($order_all_info ) )
            { 
                $order_total = 0;
                //统计订单总额
                foreach ( $order_all_info as $val )
                { 
                    $order_total += $val['total_price'];
                }
                
                //查询账户余额
                $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
                $pay_info = json_decode($this->curl_get_result($url),true);
                $time = date('Y-m-d H:i:s');
                
                if(! ($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time) ){
                    $pay_info['credit'] = '0.00';
                }
                
                //可用余额
                $available_amount = $pay_info['credit']+$pay_info['M_credit'];
                //默认验证密码成功
                $is_pass = true; 
                
                //判断应该发起的支付金额是多少
                if( !empty($status) ){ //全额微信支付
                     
                    $charge_data['amount'] = $order_total;
                     
                }else{
                
                    //货豆+微信支付。
                    $charge_data["amount"] = round($order_total - $available_amount,2);
                     
                    $password = md5( $this->input->post('pass') );
                
                    if(empty($no_pwd)){
                        //验证支付密码是否正确
                        if( $password != $pay_info['pay_passwd'] ){
                            $is_pass = false;
                        }
                    }
                }
                
                if( $is_pass ){ //支付密码验证成功
                
                    $charge_data["payment_id"] = 2;//微信支付
                    $charge_data['order_source'] = 2; //H5支付
                    $charge_data['order_ids'] = $order;
                    $charge_data['customer_id'] = $this->session->userdata("user_id");
                    
                    $this->load->helper ( 'order' );
                    $this->load->model("charge_mdl", "charge");
                    do {
                        $charge_data['chargeno'] = get_order_sn();
                
                        if ($this->charge->load_byChangeNum( $charge_data['chargeno']) ) {
                            $order_exist = true;
                        } else {
                            $new_charge_id = $this->charge->create($charge_data);
                            $order_exist = false;
                        }
                    } while ($order_exist); // 如果是订单号重复则重新提交数据
                
                
                    if( $new_charge_id ){
                        //转跳开始支付
                
                        $error['status'] = 'success';
                        $error['charge_id'] = $new_charge_id;
                    }else{
                        //支付失败，请重试
                        $error['status'] = 'fail';
                    }
                }else{
                    //支付密码错误
                    $error['status'] = 'wrong';
                }
                
            }else{ 
                $error['status'] = 'recur';
            } 
            
        }else{
             
           $error['status'] = 'recur';
        }
        
        echo json_encode($error);
        
    }
    /**
     * 支付返回-同步页面
     *
     * @param number $chargeno 充值号。
     * @param number $status 状态
     */
    public function after_pay($chargeno = 0, $status = 2) {
        $user_id   = $this->session->userdata ( 'user_id' );
        $this->load->model ( "charge_mdl" );
        $this->load->model ('order_mdl');
        // 查询该支付订单。
        $charge = $this->charge_mdl->load_byChangeNum($chargeno, $user_id);
        
        if ($charge && $charge['order_sn'] ) { 
            //订单信息
            $order = $this->order_mdl->load_by_sn($charge['order_sn']);
            
            if ($status == 1) {
                //支付成功
                
                if( in_array($order['status'],array(4,14)  ) ) {
                    
                    //返回页面
                    redirect("order/payfinish?new_order_id=".$order['id']);
                    
                }else{
                    $url = site_url('member/order/detail/'.$order['id'])
                    ?>
                        <meta charset="utf-8">
                        <script>alert("订单尚未完成请等待1~2分钟，或资金不足以扣除此次交易，已将充值金额转至现金账户，请查收！")
                             window.location.href="<?php echo $url ?>";
                             
                        </script>
                    <?php 
                    return;
                }
                
            }else{ 
                
                $this->charge_mdl->update_charge_status($chargeno, $user_id); // 将该单改为作废充值订单
                $data ['status'] = $status;
                $data ['order']['order_sn'] = $charge['order_sn'];
                $data ['order']['id'] = $order['id'];
                $data ['head_set'] = 2;
                $data ['foot_set'] = 1;
                $this->load->view ( 'head', $data );
                $this->load->view ( '_header', $data );
                $this->load->view ( 'payment/afterpay_status_view', $data );
                $this->load->view ( '_footer', $data );
                $this->load->view ( 'foot', $data );
            }
            
        }else if ($charge && $charge['order_ids']){ 
            
            $order_id_array = array();
            
            $order_id_array = explode(',',$charge['order_ids'] );
            
            //订单信息
            $this->order_mdl->status = 4;
            $this->order_mdl->customer_id = $charge['customer_id'];
            $order = $this->order_mdl->all_order_price( $order_id_array );
            
            if ($status == 1) {
                //支付成功
            
                if( $order ) {
            
                    //返回页面
                    redirect("order/payfinish?total_price=".$order['total_price'] );
            
                }else{
                    $url = site_url('Member/order/');
                    ?>
                        <meta charset="utf-8">
                        <script>alert("订单尚未完成请等待1~2分钟，或资金不足以扣除此次交易，已将充值金额转至现金账户，请查收！")
                             window.location.href="<?php echo $url ?>";
                             
                        </script>
                    <?php 
                return;
                }
                            
            }else{ 
                
                $this->charge_mdl->update_charge_status($chargeno, $user_id); // 将该单改为作废充值订单
                $data ['status'] = $status;
                $data ['head_set'] = 2;
                $data ['foot_set'] = 1;
                $this->load->view ( 'head', $data );
                $this->load->view ( '_header', $data );
                $this->load->view ( 'payment/afterpay_status_view', $data );
                $this->load->view ( '_footer', $data );
                $this->load->view ( 'foot', $data );
            }
            
        }else{ 
            
            echo '<meta charset="utf-8">
		        <script type="text/javascript">
                    history.back(-2);
                </script>';
            exit();
        }
       
    }
    
    
    
    
    
    
    /**
     * news 分店面对面支付页面--！
     */
    public function branch_pay_view( $branch_id = 0 )
    {
        
        if( !is_numeric( $branch_id )  || strpos( $branch_id ,".") !== false )
        {
            echo '<meta charset="utf-8">
	        <script type="text/javascript">
                alert("参数错误");history.back(-1);
            </script>';
            exit;
        }
        
       
        $sift['where']['id'] = $branch_id;
        $this->load->model('Corporation_branch_mdl');
        $corp_info = $this->Corporation_branch_mdl->Corp_Branch_Detaile( $sift );
        
        //查询是否有可用的储值卡。
        $sift['where']['customer_id'] = $this->session->userdata('user_id');
	    $sift['where']['corporation_id'] = $corp_info['corp_id'];

	    
	    $this->load->model('Savings_card_mdl');
	    $cart_list = $this->Savings_card_mdl->Load_Customer_Card( $sift );
        

	    $this->load->helper('time');
	    $data['branch_id'] = $branch_id;
        $data['type'] = 3;//面对面类型
        $data['head_set'] = 2;
        $data ['foot_set'] = 1;
        $data['title'] = '订单支付';
        $data['corp_info'] = $corp_info;
        $data['card_list'] = $cart_list;
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header' );
        $this->load->view ( 'miandui/stored_card', $data );
        $this->load->view ( 'miandui/stored_value',$data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    
    }

    


    /**
     * news 分店扫码支付。
     */
    public function branch_code_pay()
    { 
//         return;
        //下单。
        $return['status'] = false;
        $return['message'] = '支付失败';
        
        $card_buy_id = $this->input->post('card_buy_id');//卡ID。
        $card_pay_amount = $this->input->post('card_pay_amount');//储蓄卡。
        $branch_id  = $this->input->post('branch_id');//分店ID。
        $price = $this->input->post('price'); //需要支付的总额。
        $pay_password = $this->input->post('pay_password');//支付密码。
        
        $sift['where']['id'] = $branch_id;
        $this->load->model('Corporation_branch_mdl');
        $corp_info = $this->Corporation_branch_mdl->Corp_Branch_Detaile( $sift );
        $relation_id = $this->session->userdata ('pay_relation');
        
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
                        $this->order_mdl->order_source = 2;
                        
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
                                        $return['status'] =  ( int ) $this->curl_post_result( $url,$data_post );
                                        if( $return['status'] == 1 )
                                        {
                                            $return['message'] = '支付成功';
                                            $return['data']['order_id'] = $new_order_id;
                                        }
                                        
                                    }else{ 
                                        
                                        $return['status'] = 1;
                                        $return['message'] = '支付成功';
                                        $return['data']['order_id'] = $new_order_id;
                                    }
                                }
                            }
                        }
                        
                        
                    }else{ 
                        
                        //货豆余额不足。
                        $return['status'] = 2;
                        $return['message'] = '货豆余额不足';
                    }
                    
                   
                }else{ 
                    
                    //密码错误。
                    $return['status'] = 3;
                    $return['message'] = '密码错误';
                }
                
            }else{ 
                
                //分店不存在。
                $return['status'] = 4;
                $return['message'] = '分店不存在';
            }
        }
        
        if( $return['status'] == 1 )
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
        }
            
        echo json_encode($return);
    }
    
    
    
    
    
    
    
}