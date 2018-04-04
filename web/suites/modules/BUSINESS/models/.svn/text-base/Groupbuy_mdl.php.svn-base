<?php
/**
 * 
 *
 *
 */
class Groupbuy_mdl extends CI_Model
{

    public $buy_num;

    public $create_date;

    public $enddate;

    public $menber_num;

    public $status;

    public $productid;

    public $activity_num;
    
    public $activity_type;

    public $head_menber;


    
	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------
	
    //订单和团购的信息。--没有成团的
    function load_not_group() 
    {
        //查询出没有成团的订单，已经付款的就退款写log，没有付款的就修改订单状态
        
        $this->db->select('o.*');
        $this->db->from('order as o');
        $this->db->join('groupbuy as g','o.activity_id = g.buy_num');
        $this->db->where('g.enddate <', date('Y-m-d H:i:s'));
        $this->db->where_in('o.status',array(4));
        $this->db->where('g.status','0');
        $query = $this->db->get();
        $result =$query->result_array();
       
        return $result;
    }

    // --------------------------------------------------------------------
    
    /**
     * 根据buy_num查询order订单
     * @param number $buy_num
     * @return unknown
     */
    function load_order_by_buy_num($buy_num = 0)
    {
        $this->db->select('o.*');
        $this->db->from('order as o');
        $this->db->join('groupbuy as g', 'o.activity_id = g.buy_num');
        $this->db->where('g.buy_num',$buy_num);
        $query = $this->db->get();
        
        $result = $query->result_array();
        return $result;
    }

    // --------------------------------------------------------------------
    
    /**
     * 凭团首页列表查询
     * @param string $select
     * @param number $app_id
     */
    public function load($select = '*',$app_id = 0)
    {
        $result = array();
        
        $date = date('Y-m-d H:i:s');// 当前时间
        $limit_date = date('Y-m-d H:i:s', strtotime("-7 days"));// 筛除时间段：7天
        
        $date_arr = array(
            "r.start_time < " => $date,
            "r.end_time > " => $limit_date
        );
    
        $this->db->select($select);
        $this->db->from("activity_record r");
        $this->db->join("product p","r.product_id = p.id","left");
        $this->db->join("product_image i","r.product_id = i.product_id and i.is_base = 1","left");
    
        $this->db->where($date_arr);
        $this->db->where("r.status", "1");
        $this->db->where('p.is_on_sale', 1); // 上架的
        $this->db->where('p.is_delete', 0); // 不在回收站的
        if($app_id){
            $_app_id = array(
                0,
                $app_id
            );
            $this->db->where_in("p.app_id", $_app_id);
        }
    
        $this->db->order_by("r.end_time", "desc");
    
        $query = $this->db->get();
        $result = $query->result_array();
        
        return $result;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 根据buy_num查询groupbuy数据
     * @param unknown $buy_num
     */
    public function load_by_buy_num($buy_num)
    {
        $this->db->from("groupbuy");
        $this->db->where("buy_num", $buy_num);
        
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    // --------------------------------------------------------------------
    
    /**
     * 修改groupbuy状态
     * @param unknown $data
     */
    function update_status($data){ 
        @$this->db->update_batch('groupbuy', $data, 'buy_num');
        return $this->db->affected_rows();
    }

    /**
     * 条件是活动编号
     * @param unknown $data
     */
    function bath_update_groupbuy($data){
        @$this->db->update_batch('groupbuy', $data, 'activity_num');
        return $this->db->affected_rows();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 插入groupbuy数据
     */
    function create()
    {
        $datetime = date('Y-m-d H:i:s');
        
        if ($this->buy_num) {
            $this->db->set('buy_num', $this->buy_num);
        }
        if ($this->create_date) {
            $this->db->set('create_date', $datetime);
        }
        if ($this->enddate) {
            $this->db->set('enddate', $this->enddate);
        }
        if ($this->menber_num) {
            $this->db->set('menber_num', $this->menber_num);
        }
        if ($this->status) {
            $this->db->set('status', $this->status);
        }
        if ($this->productid) {
            $this->db->set('productid', $this->productid);
        }
        if ($this->activity_num) {
            $this->db->set('activity_num', $this->activity_num);
        }
        if ($this->activity_type) {
            $this->db->set('activity_type', $this->activity_type);
        }
        if ($this->head_menber) {
            $this->db->set('head_menber', $this->head_menber);
        }
        $this->db->set('create_date', $datetime);
        $this->db->insert('groupbuy');
        return $this->db->insert_id();
    }

    // --------------------------------------------------------------------

    /**
     * 修改groupbuy表数据
     * @param unknown $id
     */
    function update($id){ 
        $datetime = date('Y-m-d H:i:s');
        
        if ($this->buy_num) {
            $this->db->set('buy_num', $this->buy_num);
        }
        if ($this->create_date) {
            $this->db->set('create_date', $datetime);
        }
        if ($this->enddate) {
            $this->db->set('enddate', $this->enddate);
        }
        if ($this->menber_num) {
            $this->db->set('menber_num', $this->menber_num);
        }
        if ($this->status) {
            $this->db->set('status', $this->status);
        }
        if ($this->productid) {
            $this->db->set('productid', $this->productid);
        }
        if ($this->activity_num) {
            $this->db->set('activity_num', $this->activity_num);
        }
        if ($this->head_menber) {
            $this->db->set('head_menber', $this->head_menber);
        }
        if ($this->activity_type) {
            $this->db->set('activity_type', $this->activity_type);
        }
        $this->db->where('buy_num', $id);
        $this->db->update('groupbuy');
        return $this->db->affected_rows();
    }

    // --------------------------------------------------------------------
    
    /**
     * 拼团商品
     * @param $id 团id
     * @param $head_menber 团长id
     */
    public function detail($id,$head_menber,$productid){
        $this->db->select('a.buy_num,a.head_menber,b.id,b.name,b.goods_thumb,b.menber_num,b.groupbuy_start_at,b.groupbuy_end_at,b.groupbuy_price');
        $this->db->from('groupbuy a');
        $this->db->join('product b','b.id=a.productid','left');
        $this->db->where('a.buy_num',$id);
        $this->db->where('a.head_menber',$head_menber);
        $this->db->where('a.productid',$productid);
//         $this->db->where('b.is_groupbuy',1);//团购的
        $this->db->where('b.is_on_sale', 1); // 上架的
        $this->db->where('b.is_delete', 0); // 不在回收站的
        $this->db->where('b.is_mc',0); //不是二维码商品
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * 拼团成员
     * @param $id 团id
     * @param $order_state 订单状态
     */
    public function group_member($id,$order_state){
        $this->db->select('a.*,b.place_at,b.customer_id,c.name,c.wechat_nickname,c.wechat_avatar');
        $this->db->from('groupbuy a');
        $this->db->join('order b','b.activity_id = a.buy_num','left');
        $this->db->join('customer c','c.id = b.customer_id','left');
        $this->db->where('a.buy_num',$id);
        $this->db->where_in('b.status',$order_state);
        $query = $this->db->get();
//         echo $this->db->last_query();exit;
        return $query->result_array();
    }
    
    //查询是否开团成功
    public function is_ok_status( $buy_num ){ 
        $this->db->select('buy_num');
        $this->db->where('buy_num',$buy_num);
        $this->db->where('status',1);
        $this->db->from('groupbuy');
        $query = $this->db->get();
        
        return $query->row_array();
    }
    
    //根据订单号查询
    public function groupbuy_info($order_sn){ 
        $this->db->select('g.*,o.status as o_status');
        $this->db->from('groupbuy as g');
        $this->db->join('order as o','o.activity_id = g.buy_num');
        $this->db->where('o.order_sn',$order_sn);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * 查询有无参团记录
     * @param $productid 商品id
     * @param $order_state 订单状态
     */

    public function check_group($productid,$order_state){
        $this->db->select('a.buy_num,a.head_menber,a.productid');
        $this->db->from('groupbuy a');
        $this->db->join('order b','a.buy_num = b.activity_id');
        $this->db->join('product c','c.id = a.productid');
        $this->db->where('c.groupbuy_start_at < b.place_at');
        $this->db->where('c.id',$productid);
        $this->db->where('b.customer_id',$this->session->userdata('user_id'));
        $this->db->where_in('b.status',$order_state);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * 
     * @param number $user_id
     * @param number $buy_num
     * @param number $product_id
     * @return unknown
     */
    function load_grouporder_by_status_num($user_id=0,$buy_num = 0,$product_id = 0)
    {
        $this->db->select('o.id,g.head_menber,g.buy_num');
        $this->db->from('order as o');
        $this->db->join('groupbuy as g','g.buy_num = o.activity_id');
        $this->db->where('g.productid',$product_id);
        if($buy_num)
            $this->db->where('o.activity_id',$buy_num);
        $this->db->where('o.customer_id',$user_id);
        $this->db->where_in('o.status',array('9','14','7'));
        $query = $this->db->get();
           
        $result = $query->result_array();
        return $result;
    }
    
    /**
     * @param unknown $activity_id
     * @return unknown qty
     */
    function get_qty_byActivityId($activity_id){
        $this->db->select('g.quantity');
        $this->db->from('order as o');
        $this->db->join('order_item as g','g.order_id = o.id');
        $this->db->where('o.activity_id',$activity_id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
    function updates_groupbuy_status( $buy_num_array, $status )
    {
        $this->db->set('status',$status);
        $this->db->where_in( 'buy_num', $buy_num_array );
        $this->db->update('groupbuy');
        return $this->db->affected_rows();
    
    }

}