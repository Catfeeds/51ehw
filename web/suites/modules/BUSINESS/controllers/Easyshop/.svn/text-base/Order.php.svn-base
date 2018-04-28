<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

include_once dirname(__FILE__).'/../Common/Uri.php';

class Order extends Front_Controller {
    
    /**
	 * 构造函数
	 */
	public function __construct() {
        /**
         * 构造函数
         */
        parent::__construct();
        
        if( empty( $_SERVER['HTTP_REQUEST_TYPE'] ) )
        {
            $this->session->set_userdata('ref_from_url', current_url());
        }
        
        //如果是AJAX请求前端请求加上
//         beforeSend:function (XMLHttpRequest) 
//         {
//                     XMLHttpRequest.setRequestHeader("request_type","ajax");
//         },

        if( !$this->session->userdata("user_in") )
        {
            if( !empty( $_SERVER['HTTP_REQUEST_TYPE'] ) && $_SERVER['HTTP_REQUEST_TYPE'] == 'ajax')
            {
                $return['status'] = 255;
                $return['message'] = '登录信息过期，重新登录';
                $return['redirect_url'] = 'javascript:history.go(0)';//返回给页面自动刷新。
                echo json_encode($return);
                exit();
        
            }else {
        
                //转跳验证。
                redirect('customer/login');
                exit();
            }
        }

        $this->load->model('easyshop_order_mdl');
        // print_r($this->session->userdata());exit;
    }

	// -----------------------------------------------------------------------------

    public function p(){
        redirect('easyshop/order/index/6?pid=17&qty=11');
    }
    public function t(){
    }

	/**
     *  确认订单页
     */
	public function index($tribe_id=0){

        $customer_id = $this->session->userdata('user_id');

        $this->load->model('easyshop_address_mdl','address_mdl');
        
        $product_id = (int)$this->input->get_post('pid');   // 购买的商品id
        $quantity = (int)$this->input->get_post('qty');     // 购买的商品数量

        $product_id = $product_id?$product_id:$this->session->userdata('easy_pid');
        $quantity = $quantity?$quantity:$this->session->userdata('easy_qty');

        if( $tribe_id && $product_id && $quantity )
        {
            if($address_id = $this->input->get('address_id'))
            {
                $address = $this->address_mdl->load_by_id($address_id);
            }
            else
            {
                $address = $this->address_mdl->load($customer_id);
            }

            // 验证数据
            $result = $this->firm_order($tribe_id,$product_id,$quantity);

            // var_dump($result);exit;
            if($result['status'])
            {
                echo "<script>alert('",$result['errorMessage'],"');history.back();</script>";
                exit;
            }

            if(empty($result['easy_corp_id']))
            {
                echo "<script>alert('商品所属简易店不存在');history.back();</script>";
                exit;
            }
            else
            {
                $sell_customer_id = $this->easyshop_order_mdl->get_where('easy_corporation',['id'=>$result['easy_corp_id']],'customer_id');
                $where = [
                    'customer_id'   =>  $sell_customer_id['customer_id'],
                    'tribe_id'      =>  $tribe_id,
                ];
                // 店铺名(卖家姓名+手机号)
                $sell_info = $this->easyshop_order_mdl->get_where('tribe_staff',$where,'member_name,mobile');
                if(!$sell_info)
                {
                    echo "<script>alert('卖家信息错误');history.back();</script>";
                    exit;                    
                }
            }

            $this->session->set_userdata('easy_pid',$product_id);
            $this->session->set_userdata('easy_qty',$quantity);

            $data['address'] = $address;
            $data['items'] = $result;

            $data['title'] = "确认订单";
            $data['head_set'] = 2;

            $data['pid'] = $product_id;
            $data['qty'] = $quantity;
            $data['tribe_id'] = $tribe_id;
            $data['sell_info'] = $sell_info;

            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('easyshop/order/firm_order', $data);
            // $this->load->view('_footer', $data);
            // $this->load->view('foot', $data);
        }
        else
        {
            redirect('home');
            exit;
        }
    }

    /**
     * 确认订单数据验证
     */
	private function firm_order($tribe_id=0,$product_id=0,$quantity=0,$stock=true){

        if(!$tribe_id || !$product_id || !$quantity)
        {
            $result = [
                'status' => 1,
                'errorMessage' => '参数错误'
            ];
            return $result;
        }

        $customer_id = $this->session->userdata('user_id');

        // 商品信息
        $product_info = $this->easyshop_order_mdl->product_info($product_id);

        if(!$product_info)
        {
            $result = [
                'status' => 1,
                'errorMessage' => '商品不存在'
            ];
            return $result;
        }
        elseif($product_info['is_on_sale']==0)
        {
            $result = [
                'status' => 1,
                'errorMessage' => '商品已下架'
            ];
            return $result;
        }
        elseif($product_info['tribe_id'] != $tribe_id)
        {
            $result = [
                'status' => 2,
                'errorMessage' => '商品信息错误'
            ];
            return $result;
        }
        elseif( $stock && ( $product_info['stock']<1 || $product_info['stock']<$quantity ) )
        {
            $result = [
                'status' => 1,
                'errorMessage' => '商品库存不足'
            ];
            return $result;
        }

        // 用户在部落状态是否正常
        $where = [
            'customer_id'   =>  $customer_id,
            'tribe_id'      =>  $tribe_id,
            'status'        =>  2
        ];
        $tribe_res = $this->easyshop_order_mdl->get_where('tribe_staff',$where,'id');

        if($tribe_res)
        {
            $result = [
                'product_id'    => $product_info['id'],
                'quantity'      => $quantity,
                'product_name'  => $product_info['product_name'],
                'product_pic'   => $product_info['path'],
                'price'         => $product_info['price'],
                'stock'         => $product_info['stock'],
                'easy_corp_id'  => $product_info['easy_corp_id'],
            ];
            $result['total_price'] = $quantity * $product_info['price'];
            $result['status'] = 0;
        }
        else
        {
            $result = [
                'status' => 2,
                'errorMessage' => '用户状态错误'
            ];
        }
        return $result;
    }


    /**
     * 保存订单
     */
    public function save(){
        // echo json_encode(['status'=>0,'errorMessage'=>'test']);exit;
        $product_id = (int)$this->input->post('product_id');
        $quantity = (int)$this->input->post('quantity');
        $address_id = (int)$this->input->post('address_id');
        $tribe_id = $this->input->post('tribe_id');
        $customer_id = $this->session->userdata('user_id');

        if(!$tribe_id || !$product_id || !$quantity || !$address_id)
        {
            $result = [
                'status' => 2,
                'errorMessage' => '订单错误'
            ];
            echo json_encode($result);
            exit;
        }

        $this->load->model('easyshop_address_mdl','address_mdl');
        $address = $this->address_mdl->load_by_id($address_id);

        if(!$address || $address['customer_id'] != $customer_id)
        {
            $result = [
                'status' => 'address',
                'errorMessage' => '收货地址错误'
            ];
            echo json_encode($result);
            exit;
        }

        // 验证订单数据
        $result = $this->firm_order($tribe_id,$product_id,$quantity,false);

        if($result['status'])
        {
            echo json_encode($result);
            exit;
        }

        $this->load->helper('order');

        $create_at = date('Y-m-d H:i:s');

        // 生成订单号
        do{
            $order_sn = get_order_sn();
            if( $this->easyshop_order_mdl->check_order_sn($order_sn) )
            {
                $order_exist = true;
            }
            else
            {
                $order_exist = false;
            }
        }while($order_exist);

        $product_info = $this->easyshop_order_mdl->product_info($product_id);

        $total_price = $product_info['price'] * $quantity;
        $total_price = number_format($total_price,2);

        $this->db->trans_begin();

        // 减库存
        $stock_res = $this->easyshop_order_mdl->update_stock($product_id,$quantity);

        // 生成订单
        $order_data = [
            'order_sn'      => $order_sn,
            'product_name'  => $product_info['product_name'],
            'product_price' => $product_info['price'],
            'product_img'   => $product_info['path'],
            'quantity'      => $quantity,
            'product_id'    => $product_info['id'],
            'tribe_id'      => $product_info['tribe_id'],
            'customer_id'   => $customer_id,
            'status'        => 1,
            'total_price'   => $total_price,
            'created_at'    => $create_at,
            'update_at'     => $create_at,
            'easy_corp_id'  => $product_info['easy_corp_id'],
        ];
        $order_res = $this->easyshop_order_mdl->create('easy_order',$order_data);

        // 添加收货地址
        $order_delivery_data = [
            'order_id'        => $order_res,
            'consignee'       => $address['consignee'],
            'contact_mobile'  => $address['mobile'],
            'contact_phone'   => $address['phone'],
            'address'         => $address['address'],
            'province_id'     => $address['province_id'],
            'city_id'         => $address['city_id'],
            'district_id'     => $address['district_id'],
            'postcode'        => $address['postcode'],
        ];
        $order_delivery_res = $this->easyshop_order_mdl->create('easy_order_delivery',$order_delivery_data);

        // 添加订单日志
        $order_log_data = [
            'order_id'      => $order_res,
            'status'        => 1,
            'created_at'    => $create_at,
        ];
        $order_log_res = $this->easyshop_order_mdl->create('easy_order_log',$order_log_data);

        if( $stock_res && $order_res && $order_delivery_res && $order_log_res )
        {
            $result = [
                'status'            => 0,
                'errorMessage'      => '成功',
                'order_id'          => $order_res,
                'order_sn'          => $order_sn,
                'order_delivery'    => $order_delivery_res,
                'order_log'         => $order_log_res,
            ];
            $this->db->trans_commit();
        }
        else
        {
            $result = [
                'status'        => 1,
                'errorMessage'  => '提交失败，请重新提交订单',
            ];  
            $this->db->trans_rollback();   
        }
        echo json_encode($result);
        exit;
    }


    /**
     * 订单列表
     * @is_sell true:卖 false:买
     */
    public function order_list($tribe_id=0,$is_sell=false) {

        if(!$tribe_id)
        {
            echo "<script>history.back();</script>";
            exit;
        }
        
        $data['title'] = '我的订单列表';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        $data['tribe_id'] = $tribe_id;
        $data['is_sell'] = $is_sell;

        if($is_sell)
        {
            $where = ['customer_id'=>$this->session->userdata('user_id')];
            $easy_corp = $this->easyshop_order_mdl->get_where('easy_corporation',$where,'id');
            if(!$easy_corp)
            {
                echo "<script>history.back();</script>";
                exit;
            }            
        }

        // 取消超时未支付的订单
        $this->load->helper('easy_autoscript');
        AutoOrderCancel($this->session->userdata('user_id'));
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);

        // H5弹窗
        if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
            //调用接口获取支付账户信息
            $url  = $this->url_prefix.'Customer/load_pay_account';
            $post['customer_id'] = $this->session->userdata('user_id');
            $customer = json_decode($this->curl_post_result($url,$post),true);
            if (empty($customer['pay_passwd']) || !$customer['pay_passwd']) {
            
                $data['bullet_set'] = '1';
                $this->load->view('widget/bullet', $data);
            } else {
                $data['bullet_set'] = '3';
                $this->load->view('widget/bullet', $data);
            }
        }

        $this->load->view('easyshop/order/order_list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }


    /**
     * ajax加载订单列表
     */
    public function  ajax_order_list(){
        $customer_id = $this->session->userdata('user_id');
        $type = $this->input->post('type');
        $page = $this->input->post('page');
        $tribe_id = $this->input->post('tribe_id');
        $is_sell = $this->input->post('is_sell');

        if(0 == $page)
        {
            $page = 1;
        }
        $limit = 5;//每页显示的数量
        $offset = ($page-1)*$limit;//偏移量
        
        switch ($type) {
            case 1:
                $status_array = array(
                    'status' => array(1)
                );
                break;
            case 2: 
                $status_array = array(
                    'status' => $is_sell?array(2):array(2,3)
                );
                break;
            case 3: 
                $status_array = array(
                    'status' => array(3)
                );
                break;
            case 4: 
                $status_array = array(
                'status' => array(4,5)
                );
                break;
            default:
                $status_array = [];
                break;
        }

        $easy_corp_id = 0;
        if($is_sell)
        {
            $where = ['customer_id'=>$customer_id];
            $easy_corp = $this->easyshop_order_mdl->get_where('easy_corporation',$where,'id');
            $easy_corp_id = $easy_corp['id'];
        }

        $data['List'] = $this->easyshop_order_mdl->order_list($customer_id, $easy_corp_id, $tribe_id, $status_array, $limit, $offset,$is_sell);

        echo json_encode($data);
    }


    /**
     * 订单详情
     * @param $is_sell  true:卖 false:买
     */
    public function detail($tribe_id=0,$order_id=0,$is_sell=false){

        if($this->input->is_ajax_request())
        {
            $tribe_id = $this->input->get_post('tribe_id')?$this->input->get_post('tribe_id'):0;
            $order_id = $this->input->get_post('order_id')?$this->input->get_post('order_id'):0;
            $order = $this->easyshop_order_mdl->order_info($tribe_id,$order_id);
            echo json_encode($order);
            exit;
        }

        if(!$tribe_id || !$order_id)
        {
            redirect('home');
            exit;
        }

        $customer_id = $this->session->userdata('user_id');

        // 订单详情
        $order = $this->easyshop_order_mdl->order_info($tribe_id,$order_id);

        if($is_sell)
        {
            $where = ['customer_id'=>$customer_id];
            $easy_corp = $this->easyshop_order_mdl->get_where('easy_corporation',$where,'id');
            if( !$easy_corp || ( $easy_corp['id'] != $order['easy_corp_id'] ) )
            {
                echo "<script>history.back();</script>";
                exit;
            }
        }

        if( !$order || ( !$is_sell && $order['customer_id']!=$customer_id ) )
        {
            redirect('home');
            exit;
        }

        // 送货地址
        $order_delivery = $this->easyshop_order_mdl->get_where('easy_order_delivery',['order_id'=>$order['id']]);
        if($order_delivery)
        {
            $order_delivery['province'] = $this->easyshop_order_mdl->get_where('region',['region_id'=>$order_delivery['province_id']],'region_name')['region_name'];
            $order_delivery['city'] = $this->easyshop_order_mdl->get_where('region',['region_id'=>$order_delivery['city_id']],'region_name')['region_name'];
            $order_delivery['district'] = $this->easyshop_order_mdl->get_where('region',['region_id'=>$order_delivery['district_id']],'region_name')['region_name'];
        }

        // 订单日志
        $order_log = $this->easyshop_order_mdl->get_where('easy_order_log',['order_id'=>$order['id']],'*',true);

        // 是否支付过
        $is_pay = false;
        foreach($order_log as $v){
            if($v['status']==2)
                $is_pay = true;
        }

        $data['order'] = $order;
        $data['order_delivery'] = $order_delivery;
        $data['order_log'] = $order_log;
        $data['is_pay'] = $is_pay;

        $data['order_log_status'] = [
            1=>'下单时间',
            2=>'支付时间',
            3=>'发货时间',
            4=>'完成时间',
            5=>'完成时间',
            6=>'订单取消原因',
            7=>'订单取消原因',
            8=>'退款订单',
            9=>'订单异常',
        ];

        $data['title'] = '订单详细';
        $data['back'] = 'member/order';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        $data['tribe_id'] = $tribe_id;
        $data['is_sell'] = $is_sell;
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);

        // H5弹窗
        if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
            //调用接口获取支付账户信息
            $url  = $this->url_prefix.'Customer/load_pay_account';
            $post['customer_id'] = $this->session->userdata('user_id');
            $customer = json_decode($this->curl_post_result($url,$post),true);
            if (empty($customer['pay_passwd']) || !$customer['pay_passwd']) {
            
                $data['bullet_set'] = '1';
                $this->load->view('widget/bullet', $data);
            } else {
                $data['bullet_set'] = '3';
                $this->load->view('widget/bullet', $data);
            }
        }

        $this->load->view('easyshop/order/detail', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }


    /**
     * ajax确认收货
     */
    public function confirm_order(){

        $order_id = $this->input->post('id');
        $tribe_id = $this->input->post('tribe_id');
        $order = $this->easyshop_order_mdl->order_info($tribe_id,$order_id);
        $customer_id = $this->session->userdata('user_id');
        
        if( !$order || $order['customer_id'] != $customer_id || $order['status']!=3 )
        {
            $result = [
                'status' => 1,
                'errorMessage' => '订单错误'
            ];
            echo json_encode($result);
            exit;
        }

        $pass = md5( $this->input->post('pass') );
        $relation_id = $this->session->userdata ('pay_relation');

        //接口-验证支付密码
        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
        $pay_info = json_decode($this->curl_get_result($url),true);

        if( $pay_info['pay_passwd'] == $pass )
        {
            $this->db->trans_begin();

            // 修改状态、添加日志
            $res = $this->easyshop_order_mdl->AfterEasyOrder($order_id,4);

            if($res['status'])
            {
                $this->db->trans_commit();
                $result = [
                    'status' => 0,
                    'errorMessage' => '成功'
                ];
            }
            else
            {
                $this->db->trans_rollback();
                $result = [
                    'status' => 2,
                    'errorMessage' => '失败'
                ];
            }           
        }
        else
        {
            $result = [
                'status'    =>  3,
                'errorMessage'  =>  '密码错误',
            ];
        }


        echo json_encode($result);
        exit;
    }


    /**
     * ajax取消订单
     */
    public function cancel_order(){

        $order_id = $this->input->post('id');
        $is_sell = $this->input->post('is_sell');
        $tribe_id = $this->input->post('tribe_id');
        $order = $this->easyshop_order_mdl->order_info($tribe_id,$order_id);
        $customer_id = $this->session->userdata('user_id');

        if( !$order || (!$is_sell && $order['customer_id'] != $customer_id) || !in_array($order['status'],[1,2]) )
        {
            $result = [
                'status' => 1,
                'errorMessage' => '订单错误(买)'
            ];
            echo json_encode($result);
            exit;
        }

        if($is_sell)
        {
            $where = ['id'=>$order['easy_corp_id']];
            $easy_corp = $this->easyshop_order_mdl->get_where('easy_corporation',$where,'customer_id');
            if(!$easy_corp || $easy_corp['customer_id']!=$customer_id)
            {
                $result = [
                    'status' => 3,
                    'errorMessage' => '订单错误(卖)'
                ];
                echo json_encode($result);
                exit;                
            }
        }

        // 是否支付过
        $data = ['order_id'=>$order_id,'status'=>2];
        $is_pay = $this->easyshop_order_mdl->get_where('easy_order_log',$data,'id');
        $status = $is_pay?7:6;

        $this->db->trans_begin();

        // 修改订单状态为取消 （支付过的:7,未支付:6）
        $data = [ 'status'=>$status ];
        $where = [ 'id'=>$order['id'] ];
        $order_res = $this->easyshop_order_mdl->update('easy_order',$data,$where);

        // 加回库存
        $stock = $order['quantity'];
        $stock_res = $this->easyshop_order_mdl->stock_goods($order['product_id'],$stock);

        // 添加订单日志
        $remark = $is_sell?'卖家取消':'买家取消';
        $data = [
            'status'    =>  6,
            'order_id'  =>  $order_id,
            'created_at'=>  date('Y-m-d H:i:s'),
            'remark'    =>  $remark,
        ];
        $order_log_res = $this->easyshop_order_mdl->create('easy_order_log',$data);

        if($order_res && $stock_res && $order_log_res)
        {
            $this->db->trans_commit();
            $result = [
                'status' => 0,
                'errorMessage' => '成功'
            ];
            echo json_encode($result);
            exit;
        }
        else
        {
            $this->db->trans_rollback();
            $result = [
                'status' => 2,
                'errorMessage' => '失败'
            ];            
            echo json_encode($result);
            exit;
        }
    }

    /**
     * 投诉
     */
    public function complain($tribe_id,$order_id){

        if(!$tribe_id || !$order_id)
        {
            echo "<script>history.back();</script>";
            exit;
        }

        $customer_id = $this->session->userdata('user_id');
        $order = $this->easyshop_order_mdl->order_info($tribe_id,$order_id);

        if( !$order || $order['customer_id']!=$customer_id )
        {
            echo "<script>history.back();</script>";
            exit;
        }

        // 支付过的订单才能投诉
        $where = [
            'order_id'=>$order_id,
            'status'=>2,
        ];
        $order_log_pay = $this->easyshop_order_mdl->get_where('easy_order_log',$where,'id',true);
        if( !$order_log_pay )
        {
            echo "<script>history.back();</script>";
            exit;
        }

        $data['title'] = '投诉';
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        $data['tribe_id'] = $tribe_id;
        $data['order_id'] = $order_id;

        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('easyshop/order/complain', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 提交投诉
     */
    public function save_complain(){

        $data_post = $this->input->post();print_r($data_post);exit;

        $files =  $data_post['file'];
        if($files)
        {
            $customer_id = $this->session->userdata('user_id');
            $order_id = $data_post['order_id'];

            // 是否本人订单
            $where = [
                'id'            => $order_id,
                'customer_id'   => $customer_id,
            ];
            $order = $this->easyshop_order_mdl->get_where('easy_order',$where,'product_id');
            if(!$order)
            {
                $result = ['status'=>1];
                echo json_encode($result);
                exit;
            }

            // 支付过的订单才能投诉
            $where = [
                'order_id'  => $order_id,
                'status'    => 2
            ];
            $order_pay = $this->easyshop_order_mdl->get_where('easy_order_log',$where,'id');
            if(!$order_pay)
            {
                $result = ['status'=>1];
                echo json_encode($result);
                exit;
            }

            // 订单用户姓名
            $where = [
                'customer_id'   =>  $customer_id,
                'tribe_id'      =>  $tribe_id,
            ];
            $name = $this->easyshop_order_mdl->get_where('tribe_staff',$where,'id,member_name');
            
            $moblie = $data_post['moblie'];
            $email = $data_post['email'];
            $complain_reason = $data_post['complain_reason'];
            $complain_other = $data_post['complain_other'];
            $complain_desc = $data_post['complain_desc'];

            $created_at = date("Y-m-d H:i:s",time());

            //上传图片名
            $img_add = explode(',', trim($data_post['add_img'],',') );

            $save_path = 'uploads/easy_complain/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
            $path = FCPATH .UPLOAD_PATH.$save_path;

            if ( !file_exists( $path ) )
            {
                mkdir($path,0777,true);
            }

            $multip = array();//记录该上传的图片  避免重复上传
            //处理要上传的图片写入文件夹  不需要的的则不处理
            foreach ($img_add as $key => $val){
                foreach ($files as $k => $v){
                    if($val == $v['pic_sign']){
                        if(!in_array($key, $multip)){
                            $pic = $v['pic'];
                            $temp = explode('.',$v['pic_name'])[1];
                            //处理64位
                            $base64    = substr(strstr($pic, ","), 1);
                            $image_res = base64_decode($base64);
                            $pic_path = $save_path.date("YmdHis").rand(0,999999).'.'.$temp;
                            $res = file_put_contents(FCPATH.UPLOAD_PATH.$pic_path ,$image_res);
                            if($res){
                                $images[] = $pic_path;
                                $multip[] = $key;
                            }
                        }
                    }
                }
            }
            $images = implode(',',$images);

            $complain_data = [
                'customer_id' => $customer_id,
                'order_id' => $order_id,
                'contact' => $moblie,
                'email' => $email,
                'complain_reason' => $complain_reason,
                'complain_reason_other' => $complain_other,
                'complain_desc' => $complain_desc,
                'image' => $images,
                'updated_at' => $created_at,
                'created_at' => $created_at,
                'customer_name' => $name['real_name'],
            ];
            
            // 生成投诉
            $complain = $this->easyshop_order_mdl->create('easy_complain',$complain_data);

            // 修改订单状态为异常
            $data = [ 'status'=>9 ];
            $where = [ 'id'=>$order_id ];
            $order_res = $this->easyshop_order_mdl->update('easy_order',$data,$where);

            if($complain)
            {
                $result = ['status'=>0];
                echo json_encode($result);
                exit;
            }
            else
            {
                $result = ['status'=>1];
                echo json_encode($result);
                exit;
            }
        }
        else
        {
            $result = ['status'=>1];
            echo json_encode($result);
            exit;
        }
    }


    /**
     * 去支付
     */
    public function order_pay(){
        $order_id = $this->input->post('id');
        $customer_id = $this->session->userdata('user_id');

        $where = ['id'=>$order_id,'status'=>1];
        $order = $this->easyshop_order_mdl->get_where('easy_order',$where);

        if(!$order || $order['customer_id']!=$customer_id)
        {
            $result = [
                'status'        =>  1,
                'errorMessage'  =>  '订单错误',
            ];
            echo json_encode($result);
            exit;
        }

        $result = [
            'status'        =>  0,
            'errorMessage'  =>  '成功',
        ];
        echo json_encode($result);
        exit;
    }
    

}