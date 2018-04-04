<?php

/**
 * 订单
 *
 *
 */
class Order_mdl extends CI_Model
{

    public $id;
    
    public $order_sn;

    public $customer_id;

    public $payment_id;

    public $shipping_id;

    public $total_product_price = 0;

    public $total_weight = 0;

    public $auto_freight_fee = 0;

    public $actual_freight_fee = 0;

    public $payment_fee = 0;

    public $total_cost = 0;

    public $total_price = 0;

    public $need_pay = '';

    public $already_pay = '';

    public $is_need_invoice = '';

    public $customer_remark = '';

    public $status;

    public $is_delete = 0;

    public $place_at;

    public $sendmethod = 0;

    public $order_type = 0;

    public $status_yugou = 0;

    public $parent_id = 0;

    public $activity_id = 0;

    public $activity_type = 0;
    
    public $order_source = 1;

    public $corporation_id;
    
    public $pay_time;
    
    public $verify_number;
    
    public $verify_time;
    
    public $verify_by;
    
    public $commission = 0;
    
    public $corporation_branch_id;
    // --------------------------------------------------------------------

    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * load by id
     */
    function load($id)
    {
        if (! $id) {
            return array();
        }
        $this->db->select('o.*,oi.product_name,oi.quantity,oi.price,p.name as pay_name,cb.branch_name');
        $this->db->from('order as o');
        $this->db->join('corporation_branch as cb','cb.id= o.corporation_branch_id','left');
        $this->db->join('order_item as oi', 'o.id = oi.order_id', 'left');
        $this->db->join('payment as p','o.payment_id = p.id','left');
        $query = $this->db->where('o.id', $id)->get();

        if ($row = $query->row_array()) {
            return $row;
        }

        return array();
    }

    /**
     * 订单详情。
     */
    public function Order_Detaile( $sift = array() )
    { 
        if( empty( $sift['where']['id'] ) )
        { 
            return array();
        }
        
        $this->db->select('scc.card_amount,scc.savings_card_name,o.*,cb.branch_name,cc.corporation_name,oi.product_name,oi.quantity,oi.price,p.name as pay_name');
        $this->db->from('order as o');
        $this->db->join('order_item as oi', 'o.id = oi.order_id', 'left');
        $this->db->join('payment as p','o.payment_id = p.id','left');
        $this->db->join('corporation_branch as cb','cb.id = o.corporation_branch_id','left');
        $this->db->join('customer_corporation as cc','cc.id=o.corporation_id','left');
        $this->db->join('savings_card_consumption as scc','scc.order_id = o.id','left');
        $this->db->where('o.id', $sift['where']['id'] );
        $query =  $this->db->get();
//         echo $this->db->last_query();
        return  $query->row_array();
         
    }
    
    
    /**
     * 更新订单
     */
    public function Update( $sift = array() )
    { 
        if( empty( $sift['where']['id'] ) )
        {
            return false;
        }
        
        if( isset( $sift['set']['status'] ) )
        { 
            $this->db->set('status', $sift['set']['status'] );
            
            if( $sift['set']['status'] == 4 )
            {
                $this->db->set('pay_time', date('Y-m-d H:i:s') );
            } 
        }
        
        if( !empty( $sift['set']['order_type'] ) )
        {
            $this->db->set('order_type', $sift['set']['order_type'] );
        }
        
        if( isset( $sift['where']['status'] ) )
        { 
            $this->db->where('status', $sift['where']['status']);
        }
        
        $this->db->where('id', $sift['where']['id'] );
        $this->db->update('order');
        $order = $this->db->affected_rows();
       
        if ( $order ) {
            
            // 写LOG
            $data = array(
                "orderid" => $sift['where']['id'],
                "status" => $sift['set']['status'],
                "log_date" => date('Y-m-d H:i:s')
            );
            $this->db->insert('order_log', $data);
        }
        return $order;
    }
    // --------------------------------------------------------------------
    /**
     * 根据订单号获取订单
     *
     * @param unknown $order_sn
     * @return multitype:|unknown
     */
    function load_by_sn($order_sn) 
    {
        if (! $order_sn) {
            return array();
        }
        $this->db->select('o.*,oi.product_name,oi.quantity,oi.price,p.name as pay_name,cb.branch_name');
        $this->db->from('order as o');
        $this->db->join('corporation_branch as cb','cb.id= o.corporation_branch_id','left');
        $this->db->join('order_item as oi', 'o.id = oi.order_id', 'left');
        $this->db->join('payment as p','o.payment_id = p.id','left');
        $query = $this->db->where('o.order_sn', $order_sn)->get();
        
        if ($row = $query->row_array()) {
            return $row;
        }
        
        return array();
    }

    // --------------------------------------------------------------------
    /**
     * 根据核销单号获取订单
     *
     * @param unknown $verify_number
     * @return multitype:|unknown
     */
    function load_by_verify_number($verify_number){
        if (! $verify_number) {
            return array();
        }
        $query = $this->db->get_where('order', array(
            'verify_number' => $verify_number
        ));
    
        if ($row = $query->row_array()) {
            return $row;
        }
    
        return array();
    }
   
    
    // --------------------------------------------------------------------
    /**
     *
     * @param unknown $id
     * @param unknown $userid
     * @return multitype:|unknown
     */
    function load_with_userid($id, $userid)
    {
        if (! $id) {
            return array();
        }

        $query = $this->db->get_where('order', array(
            'id' => $id,
            "customer_id" => $userid
        ));

        if ($row = $query->row_array()) {
            return $row;
        }

        return array();
    }

    // --------------------------------------------------------------------

    /**
     * 添加订单
     */
    function create()
    {
        $datetime = date('Y-m-d H:i:s');

        if ($this->order_sn)
            $this->db->set('order_sn', $this->order_sn);
        if ($this->customer_id)
            $this->db->set('customer_id', $this->customer_id);
            $this->db->set('payment_id', $this->payment_id);
        if ($this->shipping_id)
            $this->db->set('shipping_id', $this->shipping_id);
        if ($this->total_product_price)
            $this->db->set('total_product_price', $this->total_product_price);
        if ($this->total_weight)
            $this->db->set('total_weight', $this->total_weight);
        if ($this->auto_freight_fee)
            $this->db->set('auto_freight_fee', $this->auto_freight_fee);
        if ($this->actual_freight_fee)
            $this->db->set('actual_freight_fee', $this->actual_freight_fee);
        if ($this->payment_fee)
            $this->db->set('payment_fee', $this->payment_fee);
        if ($this->total_cost)
            $this->db->set('total_cost', $this->total_cost);
        if ($this->total_price !=-1)
            $this->db->set('total_price', $this->total_price);
        if ($this->already_pay)
            $this->db->set('already_pay', $this->already_pay);
        if ($this->need_pay)
            $this->db->set('need_pay', $this->need_pay);
        if ($this->is_need_invoice)
            $this->db->set('is_need_invoice', $this->is_need_invoice);
        if ($this->customer_remark)
            $this->db->set('customer_remark', $this->customer_remark);
        if ($this->status)
            $this->db->set('status', $this->status);
        if ($this->is_delete)
            $this->db->set('is_delete', $this->is_delete);
        $this->db->set('place_at', $datetime);
        if ($this->sendmethod)
            $this->db->set('sendmethod', $this->sendmethod);
        if ($this->order_type)
            $this->db->set('order_type', $this->order_type);
        if ($this->status_yugou)
            $this->db->set('status_yugou', $this->status_yugou);
        if ($this->corporation_id)
            $this->db->set('corporation_id', $this->corporation_id);
        if ($this->activity_id)
            $this->db->set('activity_id', $this->activity_id);
        if ($this->activity_type)
            $this->db->set('activity_type', $this->activity_type);
        if ($this->order_source)
            $this->db->set('order_source', $this->order_source);
        if ($this->pay_time)
            $this->db->set('pay_time', $this->pay_time);
        if($this->commission)
            $this->db->set('commission', $this->commission);
        if( !empty( $this->session->userdata('app_info')['id']) )
            $this->db->set('app_id');
        if( !empty( $this->corporation_branch_id ) )
            $this->db->set('corporation_branch_id',$this->corporation_branch_id );
            
        $this->db->insert('order');
        
        return $this->db->insert_id();
    }

    // --------------------------------------------------------------------

    /**
     * 查询订单号是否存在，存在返回true
     */
    function check_order_sn($order_sn)
    {
        $this->db->select('id');
        $query = $this->db->get_where('order', array(
            'order_sn' => $order_sn
        ));
        if ($query->row_array()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 查询第三方订单号是否存在，存在返回true
     */
    function check_external_order_sn($external_number)
    {
        $this->db->select('id');
        $query = $this->db->get_where('external_order', array(
            'external_number' => $external_number
        ));
        if ($query->row_array()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 查询核销编号是否存在，存在返回true
     */
    function check_verify_number($verify_number)
    {
        $this->db->select('id');
        $query = $this->db->get_where('order', array(
            'verify_number' => $verify_number
        ));
        if ($query->row_array()) {
            return true;
        } else {
            return false;
        }
    }
    
    
    // --------------------------------------------------------------------

    /**
     * 修改订单为已支付状态
     *
     * @access public
     * @param string $order_sn
     *            订单号
     * @return void
     */
    function order_paid($order_sn)
    {
        // 修改支付状态
        $this->db->set('status', 3);
        $this->db->where('order_sn', $order_sn);
        $this->db->update('order');

        $order = $this->load_by_sn($order_sn);

        $orderid = $order["id"];

        // 写LOG
        $data = array(
            "orderid" => $orderid,
            "status" => 3,
            "log_date" => $datetime = date('Y-m-d H:i:s')
        );
        $this->db->insert('order_log', $data);
    }

    // --------------------------------------------------------------------

    /**
     * 修改订单为确认支付状态
     *
     * @access public
     * @param string $order_sn
     *            订单号
     * @return void
     */
    function order_confirm_paid($order_sn,$status=null,$pay_time = null)
    {
        $status = !empty($status) ? $status : 4; 
        // 修改支付状态
        if( $status == 4 || $pay_time)
        {
            $this->db->set('pay_time', date('Y-m-d H:i:s') );
        }
        $this->db->set('status', $status);
        $this->db->where('order_sn', $order_sn);
        $is_ok = $this->db->update('order');

        $order = $this->load_by_sn($order_sn);

        $orderid = $order["id"];
        
        if($is_ok){
        // 写LOG
        $data = array(
            "orderid" => $orderid,
            "status" => 4,
            "log_date" => $datetime = date('Y-m-d H:i:s')
        );
            return $this->db->insert('order_log', $data);
        }
    }

    // --------------------------------------------------------------------

    /**
     * 修改订单为确认支付状态
     *
     * @access public
     * @param string $order_sn
     *            订单号
     * @return void
     */
    function order_confirm_address($order_sn)
    {
        // 修改支付状态
        $this->db->set('status', 5);
        $this->db->where('order_sn', $order_sn);
        $this->db->update('order');

        $order = $this->load_by_sn($order_sn);

        $orderid = $order["id"];

        // 写LOG
        $data = array(
            "orderid" => $orderid,
            "status" => 5,
            "log_date" => $datetime = date('Y-m-d H:i:s')
        );
        $this->db->insert('order_log', $data);
    }

    // --------------------------------------------------------------------

    /**
     * 检查支付的金额是否与订单相符
     *
     * @access public
     * @param string $order_sn
     *            订单号
     * @param float $money
     *            支付接口返回的金额
     * @return true
     */
    function check_money($order_sn, $money)
    {
        $this->db->select('total_price');
        $query = $this->db->get_where('order', array(
            'order_sn' => $order_sn
        ));

        if ($row = $query->row_array()) {
            if ($row['total_price'] == $money) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    // --------------------------------------------------------------------

    /**
     * 查询某用户的订单
     */
    function find_customer_orders($customer_id, $options = array(), $count = 5, $offset = 0)
    {
        if ($count) {
            $this->db->limit((int) $count, (int) $offset);
        }

        // 按状态查询
        if (array_key_exists('order', $options)) {
            switch ($options['order']) {
                case 'status':
                    $this->db->order_by('status', 'desc');
                    break;
            }
        }
        $this->db->order_by('place_at', 'desc');
        $query = $this->_query_orders($customer_id, $options);

        $rows = array();
        foreach ($query->result_array() as $row) {
            $rows[] = $row;
        }

        return $rows;
    }

    // --------------------------------------------------------------------

    // 查询用户下的订单（含商品）
    public function find_customer_orders_with_goods($customer_id, $options = array(), $count = '', $offset = '')
    {
        
        
//         $orders = $this->find_customer_orders($customer_id, $options, $count, $offset);
//         $orders_with_goods = array();

//         foreach ($orders as $k => $v) {
//             $orders_with_goods[$k] = $v;
//             $orders_with_goods[$k]['items'] = $this->find_order_items($v['id']);
            
//             $orders_with_goods[$k]['corporation_name'] = $this->load_corporation_name_by_id($v['corporation_id'])['corporation_name'];
//             //判断当订单完成后用户是否有评论商品
//             if(in_array($v['status'],array(7,9))){
//                 $comment = $this->find_order_comments($v['id']);
//                 if($comment['id']){
//                     //订单完成，用户有评论商品
//                     $orders_with_goods[$k]['comment'] =1;
//                 }else{
//                     //订单完成，用户没有评论商品
//                     $orders_with_goods[$k]['comment'] =2;
//                 }
//             }
            
            
//         }

//         return $orders_with_goods;

        if (array_key_exists('status', $options)) 
        {
            $this->db->where_in('o.status', $options['status']);
        }

        $this->db->select('cc.`corporation_name`,any_value(p.goods_thumb) as goods_thumb,any_value(oi.product_name) as product_name,any_value(oi.price) as price,count(oc.id) as comment_num,count(oi.id) as item_id_num ,sum(oi.quantity) as total_quantity,o.*,cb.branch_name');
        $this->db->from('order as o');
        $this->db->join('order_item as oi','oi.order_id= o.id','left');
        $this->db->join('order_comments as oc','oi.id = oc.orderitem_id','left');
        $this->db->join('product as p','p.id = oi.product_id','left');
        $this->db->join('customer_corporation as cc','o.corporation_id = cc.id','left');
        $this->db->join('corporation_branch as cb','cb.id = o.corporation_branch_id','left');
        $this->db->where('o.customer_id',$customer_id);
        $this->db->where('o.is_delete',0);
        $this->db->group_by('o.id');
        $this->db->order_by('o.id','desc');
        if(!empty($count) )
        {
            $this->db->limit((int) $count, (int) $offset);
        }
        $query = $this->db->get();
        
        if( !empty($count ) )
        {
            $result = $query->result_array();
            foreach ($result as $k => $v) {
                $result[$k]['items'] = $this->find_order_items($v['id']);
            }
        }else{
            $result = $query->num_rows();
        }
      
        return $result;
        
        
    }
    
    // 查询订单完成后用户是否有评论商品
    function find_order_comments($order_id){
        if (! $order_id) {
            return array();
        }
        $this->db->select('oc.*');
        $this->db->from('order_item as oit');
        $this->db->join('order_comments as oc','oit.id=oc.orderitem_id', 'left');
        $this->db->where('oit.order_id',$order_id);
        $query = $this->db->get();
    
        return  $query->row_array();
    }
    
    // --------------------------------------------------------------------

    // 查询订单下商品信息
    function find_order_items($order_id, $count = '', $offset = '')
    {
        if (! $order_id) {
            return array();
        }

        if ($count) {
            $this->db->limit((int) $count, $offset);
        }
        $this->db->select('oc.id as oc_id,a.*,b.goods_thumb,b.productnum,b.menber_num,b.groupbuy_price');
        $this->db->where(array(
            'order_id' => $order_id
        ));
        $this->db->from('order_item as a');
        $this->db->join('product as b', 'b.id=a.product_id', 'left');
        $this->db->join('order_comments as oc','oc.orderitem_id = a.id','left');
        $query = $this->db->get();
        
        
        $result = $query->result_array();

        return $result;
    }

    // --------------------------------------------------------------------

    /**
     * 私有函数
     */
    function _query_orders($customer_id, $options = array())
    {
        $this->db->from('order');

        // status
        if (array_key_exists('status', $options)) {
            $this->db->where_in('status', $options['status']);
        }

        $this->db->where('customer_id', $customer_id);
        $this->db->where('is_delete', 0); // 不在回收站的

        return $this->db->get();
    }

    // --------------------------------------------------------------------

    /**
     * 总数
     */
    function count_orders($customer_id, $options = array())
    {
        $this->db->select('COUNT(DISTINCT(id)) as total');
        $query = $this->_query_orders($customer_id, $options);
        $total = 0;

        if ($row = $query->row_array()) {
            $total = (int) $row['total'];
        }
        return $total;
    }

    // --------------------------------------------------------------------

    /**
     * 待付款订单
     */
    function count_wait_pay_orders($customer_id,$status=null)
    {

        $this->db->select('COUNT(DISTINCT(id)) as total');

        $this->db->from('order');
        if($status){
            $this->db->where_in('status', $status);
        }

        $this->db->where('customer_id', $customer_id);

        $query = $this->db->get();

        $total = 0;
        if ($row = $query->row_array()) {
            $total = (int) $row['total'];
        }
        return $total;
    }

    // --------------------------------------------------------------------

    /**
     * 待发货订单
     */
    function count_dispatch_orders($customer_id)
    {
        $status = array(
            4
        );

        $this->db->select('COUNT(DISTINCT(id)) as total');

        $this->db->from('order');

        $this->db->where_in('status', $status);

        $this->db->where('customer_id', $customer_id);

        $query = $this->db->get();

        $total = 0;
        if ($row = $query->row_array()) {
            $total = (int) $row['total'];
        }
        return $total;
    }

    // --------------------------------------------------------------------

    /**
     * 待收货货订单
     */
    function count_receive_orders($customer_id)
    {
        $status = array(
            6
        );

        $this->db->select('COUNT(DISTINCT(id)) as total');

        $this->db->from('order');

        $this->db->where_in('status', $status);

        $this->db->where('customer_id', $customer_id);

        $query = $this->db->get();

        $total = 0;
        if ($row = $query->row_array()) {
            $total = (int) $row['total'];
        }
        return $total;
    }

    // --------------------------------------------------------------------

   

    // --------------------------------------------------------------------


    // --------------------------------------------------------------------

  

    /**
     *
     * @param unknown $customer_id
     * @param unknown $select
     * @param unknown $options
     * @param number $count
     * @param number $offset
     * @return unknown|multitype:
     */
    public function get_customer_orders($customer_id, $select, $options = array(), $count = 5, $offset = 0)
    {
        if ($select) {
            $this->db->select($select);
        }

        $this->db->from("order as a ");
        $this->db->join("order_item as b", "a.id = b.order_id");
        $this->db->join("product as c", "b.product_id = c.id");
        $this->db->where("a.customer_id", $customer_id);

        if ($options) {
            $this->db->where($options);
        }

        $this->db->order_by("a.id", "desc");

        if ($count) {
            $this->db->limit((int) $count, (int) $offset);
        }

        $query = $this->db->get();

        if ($row = $query->result_array()) {
            return $row;
        }

        return array();
    }

    // --------------------------------------------------------------------
    /**
     *
     * @param unknown $orderid
     */
    function order_send($orderid)
    {
        $this->db->set('status', 3);
        $this->db->where('id', $orderid);
        return $this->db->update('order');
        // $this->db->last_query();
    }

    // --------------------------------------------------------------------
    /**
     *
     * @param unknown $orderid
     */
    function order_save($orderid)
    {
        $this->db->set('status', 13);
        $this->db->where('id', $orderid);
        return $this->db->update('order');
        // echo $this->db->last_query();
    }

    // --------------------------------------------------------------------
    /**
     * 确认状态
     *
     * @param unknown $orderid
     */
    function order_pay($orderid)
    {
        // 写LOG
        $data = array(
            "order_id" => $orderid,
            "status" => 2,
            "log_date" => $datetime = date('Y-m-d H:i:s')
        );
        $this->db->insert('order_log', $data);

        $this->db->set('status', 2);
        $this->db->set('already_pay', 'total_price');
        $this->db->where('id', $orderid);
        return $this->db->update('order');
        // echo $this->db->last_query();
    }

    // --------------------------------------------------------------------
    function order_payyugou($orderid)
    {
        // 写LOG
        $order = $this->db->get_where('order', array(
            'id' => $orderid
        ))->row_array();

        if ($order && $order["order_type"] == 1) {
            if ($order["status_yugou"] < 2) {
                $data = array(
                    "order_id" => $orderid,
                    "status" => 1,
                    "status_yugou" => 2,
                    "log_date" => $datetime = date('Y-m-d H:i:s'),
                    "ordertype" => 1
                );
                $this->db->insert('order_log', $data);

                $this->db->set('status_yugou', 2);
                $this->db->set('already_pay', '`total_price`*0.1', false);
                $this->db->where('id', $orderid);
                $this->db->update('order');
            } else
                if ($order["status_yugou"] == 3) {
                    $data = array(
                        "order_id" => $orderid,
                        "status" => 2,
                        "status_yugou" => 4,
                        "log_date" => $datetime = date('Y-m-d H:i:s'),
                        "ordertype" => 0,
                        "remark" => "user pay remain,order type change to normal"
                    );
                    $this->db->insert('order_log', $data);

                    $this->db->set('status', 2);
                    $this->db->set('status_yugou', 4);
                    $this->db->set('order_type', 0);
                    $this->db->set('already_pay', 'total_price', false);
                    $this->db->where('id', $orderid);
                    $this->db->update('order');
                }
        }

        // echo $this->db->last_query();
    }

    // --------------------------------------------------------------------
    function order_cancel($orderid, $userid)
    {
        $data = array(
            "order_id" => $orderid,
            "status" => 12,
            "log_date" => $datetime = date('Y-m-d H:i:s')
        );
        $this->db->insert('order_log', $data);

        $this->db->set('status', 12);
        $this->db->where(array(
            'id' => $orderid,
            "customer_id" => $userid,
            "status <" => 2
        ));
        $this->db->update('order');

        return $this->db->affected_rows();
        // echo $this->db->last_query();
    }

    // --------------------------------------------------------------------
    function order_received($orderid, $userid)
    {
        $data = array(
            "order_id" => $orderid,
            "status" => 7,
            "log_date" => $datetime = date('Y-m-d H:i:s')
        );
        $this->db->insert('order_log', $data);

        $this->db->set('status', 7);
        $this->db->where(array(
            'id' => $orderid,
            "customer_id" => $userid,
            "status" => 4
        ));
        return $this->db->update('order');
        // echo $this->db->last_query();
    }

    // --------------------------------------------------------------------
    function order_return($orderid, $userid, $remark)
    {
        $data = array(
            "order_id" => $orderid,
            "status" => 11,
            "remark" => $remark,
            "log_date" => $datetime = date('Y-m-d H:i:s')
        );
        $this->db->insert('order_log', $data);

        $this->db->set('status', 11);
        $this->db->where(array(
            'id' => $orderid,
            "customer_id" => $userid,
            "status" => 4
        ));
        $this->db->update('order');
        return $this->db->affected_rows();
        // echo $this->db->last_query();
    }

    // --------------------------------------------------------------------
    function order_delete($orderid, $userid)
    {
        $this->db->set('is_delete', 1);
        $this->db->where(array(
            'id' => $orderid,
            "customer_id" => $userid
        ));
        $this->db->update('order');
        return $this->db->affected_rows();
        // echo $this->db->last_query();
    }

    function order_comfirmAddress($orderid)
    {
        $data = array(
            "orderid" => $orderid,
            "status" => 4,
            "log_date" => $datetime = date('Y-m-d H:i:s')
        );
        $this->db->insert('order_log', $data);

        $this->db->set('status', 4);
        $this->db->where('id', $orderid);
        return $this->db->update('order');
        // echo $this->db->last_query();
    }
    // --------------------------------------------------------------------
    /**
     * 修改回扣
     *
     * @param
     *            orderid 订单ID
     * @param
     *            userid 用户ID
     */
    function addRebate($orderid, $userid)
    {
        // 找出订单ID并删除
        $this->db->where('orderid', $orderid);
        $this->db->delete('order_rebate');

        $order = $this->load($orderid);

        $this->db->select('sum(profits*quantity) as profits', false);
        $this->db->where("order_id", $orderid);
        $this->db->from("order_item");
        $o = $this->db->get()->row_array();
        $total_price = $o["profits"];

        // 先查询是否有CUSTOMER设的值

        $this->db->where("id", $userid);
        $this->db->from("customer");
        $customer = $this->db->get()->row_array();

        $this->db->where(array(
            "id" => $customer["parent_id"],
            "is_valid" => 1
        ));
        $count = $this->db->count_all_results("customer");

        $cus_parent_id = $customer['parent_id'];

        $parent = array();

        // 假设有父ID
        if ($cus_parent_id > 0) {

            $this->db->where("id", $customer['parent_id']);
            $this->db->from("customer");
            $parent = $this->db->get()->row_array();
        }

        $rebaterate = 0;
        $grandrate = 0;
        $returnrate = 0;
        $returnrate2 = 0;
        if ($parent && $parent["parent_shared"] != - 1) {
            // if($count>=5)
            // {
            // }
            $rebaterate = $parent["parent_shared"];

            $this->db->where("id", $parent['parent_id']);
            $this->db->from("customer");
            $grand = $this->db->get()->row_array();

            if (isset($grand["is_fix"]) && $grand["is_fix"] == 1 && $grand["parent_shared"] > $parent["parent_shared"]) {
                $grandrate = $grand["parent_shared"] - $parent["parent_shared"];
            }
        } else {
            $this->db->where("childnumber <", $count);
            $this->db->order_by("childnumber desc");
            $this->db->from("rebate");
            $rebate = $this->db->get()->result_array();
            if ($rebate && count($rebate) > 0) {
                $rebaterate = $rebate[0]["rebate"];
            }
        }

        if ($rebaterate > 0) {

            $datetime = date('Y-m-d H:i:s');
            $this->db->set('orderid', $orderid);
            $this->db->set('create_date', $datetime);
            $this->db->set('total_price', $total_price);
            $this->db->set('rebaterate', $rebaterate);
            $this->db->set('customerid', $customer["id"]);
            $this->db->set('agentid', $customer["parent_id"]);
            $this->db->set('rebate_1', $total_price * $rebaterate / 100);
            $returnrate = $this->db->insert('order_rebate');

            if ($grandrate > 0) {

                $datetime = date('Y-m-d H:i:s');
                $this->db->set('orderid', $orderid);
                $this->db->set('create_date', $datetime);
                $this->db->set('total_price', $total_price);
                $this->db->set('rebaterate', $grandrate);
                $this->db->set('customerid', $customer["id"]);
                $this->db->set('agentid', $parent["parent_id"]);
                $this->db->set('rebate_1', $total_price * $grandrate / 100);
                $returnrate2 = $this->db->insert('order_rebate');
            }
        }

        return $returnrate;
    }

    // --------------------------------------------------------------

    /**
     * 获得分红列表
     *
     * @param unknown $cond
     * @return unknown
     */
    function get_cutomer_rebate_list($cond)
    {
        $this->db->select_sum("rebate_1");
        $this->db->select("agentid");
        $this->db->group_by("agentid");
        $this->db->where($cond);
        $this->db->from("order_rebate");
        $list = $this->db->get()->result_array();

        return $list;
    }

    function sum_cutomer_rebate_list($agent_id)
    {
        $this->db->select_sum("rebate_1");
        $this->db->where('agentid', $agent_id);
        $this->db->from("order_rebate");
        $list = $this->db->get()->row_array();
        return $list['rebate_1'];
    }

    // --------------------------------------------------------------------
    function changeOrderPaymentID($orderid, $payment_id)
    {
        $this->db->set('payment_id', $payment_id);
        $this->db->where('id', $orderid);
        return $this->db->update('order');
        // echo $this->db->last_query();
    }

    // --------------------------------------------------------------------
    function setOrderLog($data)
    {
        return $this->db->insert('order_log', $data);
    }

    function getCutomerRebateList($cond)
    {
        $this->db->select_sum("rebate_1");
        $this->db->select("agentid");
        $this->db->group_by("agentid");
        $this->db->where($cond);
        $this->db->from("order_rebate");
        $list = $this->db->get()->result_array();

        return $list;
    }

    // ---------------------------------------------------------------------
    /**
     * 获取订单状态日志
     *
     * @param unknown $order_id
     * @param unknown $status
     */
    public function get_order_log($order_id, $status)
    {
        $query = $this->db->get_where("order_log", array(
            "orderid" => $order_id,
            "status" => $status
        ));
        return $query->row_array();
    }

    // ---------------------------------------------------------------------
    /**
     * 查询企业订单
     *
     * @param unknown $order_id
     * @param unknown $status
     *
     * @return array 分页后的结果集 //2016.3.29 -- 弃用
     *
     *         public function find_corporate_order_list($corporation_id, $options, $status='',$offset, $num, $search ) {
     *
     *         $this->db->limit ( ( int ) $num, ( int ) $offset );
     *         $this->db->select('*,oi.price as price,oi.id as oi_id');
     *         $query = $this->_query_corporate_orders ( $corporation_id, $options, $status, $search );
     *
     *         $rows = array ();
     *         foreach ( $query->result_array () as $row ) {
     *         $rows [] = $row;
     *         }
     *
     *         return $rows;
     *         }
     */
    function corporate_order_list($corporation_id, $status, $offset, $num, $search)
    {
        $this->db->limit((int) $num, (int) $offset);

        $this->db->select('distinct(o.id),od.*,o.*,sum(oi.`quantity`) as num,g.enddate, g.status as g_status,cb.branch_name');
        $this->db->group_by('o .id');

        $query = $this->_corporate_order_list($corporation_id, $status, $search);

        return $query->result_array();
    }


	// --------------------------------------------------------------------
	public function _corporate_order_list( $corporation_id, $status, $search, $options=''){
	    $this->db->from('order as o ');
	    $this->db->join('order_item as oi','o.id = oi.order_id','left');
	    $this->db->join ('order_delivery as od', 'od.order_id= o.id','left' );
        $this->db->join('groupbuy as g','o.activity_id = g.buy_num','left');
        //门店
        $this->db->join ('corporation_branch as cb', 'cb.id= o.corporation_branch_id','left' );
	    $this->db->where('o.corporation_id',$corporation_id);

	    if ( $status ){

	        switch ( $status ){
	            case 'wait':
	                $status = array(1,2);
	                $this->db->where_in('o.status', $status );
	                break;
	            case 'wait_dispatch':
	                $status = array(4);
	                $this->db->where_in('o.status', $status );
	                break;
	            case 'dispatch':
	                $status = 6;
	                $this->db->where('o.status', $status );
	                break;
	            case 'receive':
	                $status = array(7,8);
	                $this->db->where_in('o.status', $status );
	                break;
	            case 'accomplish':
	                $status = array(9,14);
	                $this->db->where_in('o.status', $status );
	                break;
	            case 'shut':
	                $status = array(10,11,12);
	                $this->db->where_in('o.status', $status );
	                break;
	            case 'cancel':
	                $status = 10;
	                $this->db->where('o.status', $status );
	                break;
	            case 'refund':
	                $status = 11;
	                $this->db->where('o.status' , $status );
	                break;
	            case 'return':
	                $status = 12;
	                $this->db->where('o.status' , $status );
	                break;
                case 'card':
                    $this->db->where_in('o.order_type ',array(2,3));
//                     $status = 12;
//                     $this->db->where('o.status' , $status );
                    break;
	        }
	    }

	    if(! empty( $search ) ){
	        foreach ($search as $k => $v){
	            if($v){
                    switch ( $k ){
                        case 'or_number':
                            $this->db->like('order_sn',$v);
                            break;
                        case 'name':
                                $this->db->like('consignee',$v);
                            break;
                        case 'phone':
                                $this->db->like('contact_mobile', $v);
                            break;
                        case 'branch_id':
                            $this->db->where("o.corporation_branch_id",$v);
                            break;
	                }
	            }
	        }
	    }

	    if (! empty ( $options  )) {
	       
	        foreach ( $options ['conditions'] as $key => $value ) :
	        switch ($key) {
	            case 'o.order_sn' :
	                $this->db->like ( $key, $value );
	                break;
	            case 'ca.consignee' :
	                $this->db->like ( $key, $value );
	                break;
	            case 'o.order_type':
	                $this->db->where_in('o.order_type ',array(2,3));
	                break;
	            default :
	                $this->db->where ( $key, $value );
	                break;
	        }
	        endforeach
	        ;
	    }

	   $this->db->order_by('o.id','desc');
	   return $this->db->get ();

	}
	
    // --------------------------------------------------------------------

    /**
     * 总数
     *
     * @param $corporation_id 企业ID
     * @param $options 条件
     *
     * @return int 总数
     */
    function count_corporate_orders($corporation_id, $options = array())
    {
        
        $this->db->select('COUNT(DISTINCT(o.id)) as total');
        $query = $this->_corporate_order_list($corporation_id, '', '', $options);
        $total = 0;
        if ($row = $query->row_array()) {
            $total = (int) $row['total'];
        }
        // error_log( $this->db->last_query());
        return $total;
    }

    // ---------------------------------------------------------------------
    /**
     *
     * @param unknown $corporation_id
     * @param unknown $options
     * @return number
     *
     */
    function count_page_orders($corporation_id, $status = '', $search = '')
    {
        $this->db->select('COUNT(DISTINCT(o.id)) as total');
        $query = $this->_corporate_order_list($corporation_id, $status, $search);

        $total = 0;
        if ($row = $query->row_array()) {
            $total = (int) $row['total'];
        }
        // error_log( $this->db->last_query());
        // echo $this->db->last_query();

        return $total;
        ;
    }

    /**
     * 订单作废
     */
    public function isExpired($id)
    {
        $this->db->set('status', 10);
        $this->db->where('id', $id);

        return $res = $this->db->update('order');
    }


    /**
     * 订单详细
     *
     * @param unknown $order_id
     */
    public function details($order_id, $corp_id)
    {
        $this->db->select('scc.card_amount,scc.savings_card_name,o.*, p.name as pay_name,o.place_at, g.enddate, g.status as g_status,cb.branch_name');
        $this->db->from('order as o');
        $this->db->join('payment as p', 'o.payment_id = p.id', 'left');
        $this->db->join('groupbuy as g','o.activity_id = g.buy_num','left');
        //门店
        $this->db->join ('corporation_branch as cb', 'cb.id= o.corporation_branch_id','left' );
        
        //储蓄卡使用记录。
        $this->db->join('savings_card_consumption as scc','scc.order_id = o.id','left');
        $this->db->where('o.id', $order_id);
        $this->db->where('o.corporation_id', $corp_id); // 只能查看自己店铺的订单

        $query = $this->db->get();

        return $result = $query->row_array();
    }

    /**
     * 查询该订单是否是该商家并且是对的状态
     */
    public function is_corp_order($order_id, $status, $corp_id)
    {
        $this->db->where(array(
            'id' => $order_id,
            'status' => $status,
            'corporation_id' => $corp_id
        ))->from('order');
        $query = $this->db->get();
        return $result = $query->row_array();
    }

    /**
     * 查询该订单是否属于客户并且是对的状态
     */
    public function is_customer_order($order_id, $status = '', $customer_id)
    {
        $this->db->select('o.*,g.enddate, g.status as g_status');
        $this->db->from('order as o');
        $this->db->join('groupbuy as g','o.activity_id = g.buy_num','left');
        if (! empty($status) && ! is_array($status))
            $this->db->where(array(
                'o.status' => $status
            ));
        
            if (is_array($status))
                $this->db->where_in('o.status', $status);
        
            $this->db->where(array(
                'o.id' => $order_id,
                'o.customer_id' => $customer_id
            ));
        
        $query = $this->db->get();
        return $result = $query->row_array();
    }

    /**
     *
     * @param unknown $order_id
     *            //订单id
     *            公共修改状态方法
     */
    public function update_order_status($order_id, $status)
    {
        // 修改支付状态
        if( $status == 4)
        { 
            $this->db->set('pay_time', date('Y-m-d H:i:s') );
        }
        $this->db->set('status', $status);
        $this->db->where('id', $order_id);
        $this->db->update('order');
        $order = $this->db->affected_rows();
       
        if ($order) {
            $orderid = $order["id"];
            // 写LOG
            $data = array(
                "orderid" => $order_id,
                "status" => $status,
                "log_date" => date('Y-m-d H:i:s')
            );
            $this->db->insert('order_log', $data);
        }
        return $order;
    }
    
    //修改订单支付类型
    public function update_order_payment($order_sn,$payment_id){
        $this->db->where('order_sn', $order_sn);
        $this->db->set('payment_id', $payment_id);
        $this->db->update('order');
    }
    

    /**
     * 根据订单ID查询单条订单信息
     */
    public function order_message($order_id)
    {
        return $this->db->get_where('order', array(
            'id' => $order_id
        ))->row_array();
    }
    

    /**
     * 用户修改订单备注使用
     */
    public function update_remark($order_id, $remark)
    {
        $this->db->set('customer_remark', $remark);
        $this->db->where('id', $order_id);
        $this->db->update('order');
        $order = $this->db->affected_rows();
        return $order;
    }

    /**
     * 修改用户订单总价格
     */
    public function update_price_total($order_id, $total_product_price,$total_price)
    {
        $this->db->set('total_product_price', $total_product_price);
        $this->db->set('total_price', $total_price);
        $this->db->where('id', $order_id);
        $this->db->update('order');
        $order = $this->db->affected_rows();
        return $order;
    }

    /**
     * 事物执行修改单价&总价格
     */
    public function update_price($data,$order)
    {
        $this->db->trans_begin();
        $this->load->model('order_item_mdl');

        // 修改单价
        $row = $this->order_item_mdl->up_price($data);

        if ($row) {
            $price_total = $this->order_item_mdl->item_goods_total($data['o_id']); // 修改过统计总价格
            
            $up_price = $this->update_price_total($data['o_id'], $price_total['total_price'],$price_total['total_price']+$order['auto_freight_fee']); // 修改总价格
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false; // 失败
        } else {
            $this->db->trans_commit();
            return $price_total; // 成功
        }
    }

    /**
     * 执行事务取消订单的一系列操作 。改状态+回库存
     */
    public function cancel_order( $order_id, $status, $data = array() ){
        $this->db->trans_begin();
        $this->update_order_status( $order_id, $status );
        foreach ($data as $v){
            
            if(!empty($v['sku_id']) ) 
            {//如果有SKU + 库存
                $this->sku_stock_goods($v['sku_id'],$v['quantity']);
            }
            
            $this->stock_goods($v['product_id'],$v['quantity']); //+总库存
            
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false; // 失败
        } else {
            $this->db->trans_commit();
            return true; // 成功
        }
    }

    /**
     * 取消订单后 该订单中的商品库存加回去
     */
    public function stock_goods( $id= null, $num = null ){
        $this->db->set('stock','stock + '.$num,FALSE);
        $this->db->where( 'id',$id );
        $this->db->update('product');
        return $this->db->affected_rows();

    }
    
    /**
     * 取消订订单后将SKU的库存-去 
     */
    public function sku_stock_goods($id = null, $num = null){
        $this->db->set('stock','stock + '.$num,FALSE);
        $this->db->where( 'id',$id );
        $this->db->update('product_sku_value');
        return $this->db->affected_rows();
        
    }
    
    /**
     * 写orde_log 日志
     */
    public function add_order_log($order_id , $status){ 
        $this->db->set('orderid',$order_id);
        $this->db->set('status',$status);
        $this->db->set('log_date',date('Y-m-d H:i:s') );
        $this->db->insert('order_log');
        return $this->db->insert_id();
    }
    
    /**
     * 写cash_log
     */
    public function add_customer_currency_log( $id_from, $pirce, $order_sn,$id_to){
        $this->db->set('id_from', $id_from);
        $this->db->set('id_to', $id_to);
        $this->db->set('id_event', '60');
        $this->db->set('created_at', date('Y-m-d H:i:s') );
        $this->db->set('remark', '订单号:' . $order_sn );
        $this->db->set('app_id',  $this->session->userdata('app_info')['id']);
        $this->db->set('amount', $pirce);
        $this->db->insert('customer_currency_log');
        return $this->db->insert_id();
    }
    
    // ---------------------------------------------------------------------
    
    /**
     * 根据订单企业id查询公司名称
     * @param unknown $id
     */
    public function load_corporation_name_by_id($id){
        //针对旧订单数据无企业id问题
        $row = array('corporation_name'=>'');
        if (! $id) {
            return $row;
        }
        $query = $this->db->select('corporation_name')->get_where ( 'customer_corporation', array (
            'id' => $id
        ) );
        if ($row = $query->row_array ()) {
            return $row;
        }
    }
    
    /**
     * 修改活动号
     */
    public function activity_id($order_id,$activity_id){ 
        $this->db->set('activity_id',$activity_id);
        $this->db->where( 'id',$order_id );
        $this->db->update('order');
        return $this->db->affected_rows();
        
    }
    
    /**
     * 修改订单的运费
     * 未付款状态前才可以
     */
    public function update_order_freight(){ 
        $this->db->set('auto_freight_fee',$this->auto_freight_fee);
        $this->db->where('id',$this->id);
        $this->db->where_in('status',array(1,2));
        $this->db->where('corporation_id',$this->corporation_id);
        return $this->db->update('order');
        
    }
    
    /**
     * 修改订单总价
     * 未付款状态前才可以
     */
    public function update_oreder_total_price(){ 
        $this->db->set('total_price',$this->total_price);
        $this->db->where('id',$this->id);
        $this->db->where_in('status',array(1,2));
        $this->db->where('corporation_id',$this->corporation_id);
        return $this->db->update('order');
     }
     
     
     /**
      * 用户消费排行榜
      * $status 1 = 月， 2=周， NULL=累计
      * 
      */
     public function user_convert_list($status, $limit = null, $per_page = null){ 
         
         $date = date("Y-m-d"); //当前日期
         
         if( isset($this->corporation_id) ){ 
             
             //商家售出
             $this->db->select('c.id, c.corporation_name, sum(o.total_price) as total_price, c.img_url');
             $this->db->from('order as o');
             $this->db->join ('customer_corporation as c','o.corporation_id = c.id');
             
         }else{
             //用户消费
             $this->db->select('c.id,c.name, c.nick_name, c.wechat_avatar,sum(o.total_price) as total_price');
             $this->db->from('order as o');
             $this->db->join ('customer as c','o.customer_id = c.id');
         }
         
         $this->db->where_in('o.status',array(4,6,7,9,14) );
         $this->db->group_by('c.id');
         $this->db->order_by('total_price','desc');
         
         //本月
         if($status == 1){
             
             $this->db->where("date_format(o.place_at,'%Y-%m')", "date_format(now(),'%Y-%m')",false);//本月
             
         //本周
         }else if($status == 2){
             $first= 1; //$first =1 表示每周星期一为开始时间 0表示每周日为开始时间
             $w = date("w", strtotime($date)); //获取当前周的第几天 周日是 0 周一 到周六是 1 -6
             $d = $w ? $w - $first : 6; //如果是周日 -6天
             
             $now_start = date("Y-m-d H:i:s", strtotime("$date -".$d." days")); //本周开始时间
             $now_end = date("Y-m-d", strtotime("$now_start +6 days")).' 23:59:59';; //本周结束时间
             
             $this->db->where('o.place_at >=',$now_start);
             $this->db->where('o.place_at <=',$now_end);
         }   
         
         if($limit)
             $this->db->limit($limit, $per_page);
         
         $query = $this->db->get();
        
         if($limit){
             return $query->result_array();
         }else{ 
             return $query->num_rows();
         }
     }
     
     /**
      * 用户消费了什么-商品-分类-
      * 按时间排序
      */
     public function customer_convert_info( $limit ){ 
         $this->db->select('c.name,p.name as product_name,pc.name as category,o.place_at');
         $this->db->from('order as o');
         $this->db->join('order_item as oi','oi.order_id = o.id');
         $this->db->join('product as p','p.id = oi.product_id');
         $this->db->join('customer as c','c.id = o.customer_id');
         $this->db->join('product_cat as pc','pc.id = p.cat_id');
         $this->db->where_in('o.status',array(4,6,7,9,14) );
         $this->db->order_by('o.id','desc');
         $this->db->limit($limit);
         $query = $this->db->get();
         
         return $query->result_array();
     }
     
     /**
      * 根据用户消费记录导出订单
      */
     public function order_info_excel( $corporation_id )
     { 
         $this->db->select(
             "(oi.price*oi.quantity) as price_total,
        (case o.status when 1 then '等待商家确认' when 2 then '等待付款' when 4 then '等待发货' when 6 then '已发货' when 7 then '订单完成（商家手续费不足无法提取货豆）' when 9 then '订单完成' when 14 then ' 订单完成' when 10 then'订单取消' when 11 then'已退款' end) as status,
        o.customer_remark,od.consignee,CONCAT(r.region_name,'省', city.region_name,'市',district.region_name,od.address) as address,od.contact_phone,od.contact_mobile,o.place_at,o.pay_time,oi.product_name,oi.quantity,o.corporation_id,cc.corporation_name,
        (case o.order_source when 1 then 'PC' when 2 then 'H5' when 3 then'安卓' when 4 then'ios' else '其它' end) as order_source, o.order_sn"
             );
         $this->db->from('order_item as oi');
         $this->db->join('order as o','oi.order_id = o.id','left');
         $this->db->join('order_delivery as od','od.order_id = o.id','left');
         $this->db->join('customer_corporation as cc','cc.id = o.corporation_id','left');
         $this->db->join('region as r','r.region_id = od.province_id','left');
         $this->db->join('region as city', 'city.region_id = od.city_id','left');
         $this->db->join('region as district','district.region_id = od.district_id','left');
         $this->db->where('o.corporation_id',$corporation_id);
         $this->db->order_by('o.id','desc');
         $query = $this->db->get();
         return $query->result_array();
     }
     
     /**
      * 统计多张订单金额
      */
     public function all_order_price($order_id_array = array() )
     { 
         $this->db->select('sum(o.total_price) as total_price, count(o.id) id_num ');
         $this->db->from('order as o');
         $this->db->where_in('id',$order_id_array );
         $this->db->where('o.customer_id',$this->customer_id);
         $this->db->where('status',$this->status);
         $query = $this->db->get();
         
         return $query->row_array();
     }
     
     
     // --------------------------------------------------------------------
     /**
      * 根据订单ID获取多张订单
      *
      */
      function load_orderall( $order_array_id = array(), $status = 2 )
      {
          if (! $order_array_id) {
              return array();
          }
          $this->db->select('cc.customer_id as corp_customer_id, o.*');
          $this->db->from('order as o');
          $this->db->join('customer_corporation as cc','cc.id = o.corporation_id','left');
          $this->db->where_in('o.id',$order_array_id);
          $this->db->where('o.status',$status);
          $query = $this->db->get();
          $result = $query->result_array();
          return $result;
      }
      
      function updates_order_status( $id_array, $status )
      { 
          $this->db->set('status',$status);
          $this->db->where_in( 'id', $id_array );
          $this->db->update('order');
          return $this->db->affected_rows();
          
      }
     
      // --------------------------------------------------------------------
      
      /**
       * 统计各个状态的条数
       */
      public function count_status_num( $customer_id_array )
      { 
          $this->db->select('count(status=2 or null) as stay_pay_num,count(status=4 or status = 6 or null) as receiving_num,count(status=9 or status=14 or null) as ok_num');
          $this->db->from('order');
          $this->db->where_in('customer_id',$customer_id_array,false);
          $query = $this->db->get();
          return $query->row_array();
      }
      
}