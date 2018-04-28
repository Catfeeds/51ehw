<?php

/**
 * 订单
 *
 *
 */
class Easyshop_order_mdl extends CI_Model
{

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 简易店商品信息
     */
    public function product_info($id=0){
        $res = $this->db
        ->select('p.id,p.product_name,p.price,p.stock,p.is_on_sale,p.tribe_id,p.easy_corp_id,pi.path')
        ->from('easy_product p')
        ->join('easy_product_img pi','pi.product_id = p.id','left')
        ->where('p.id',$id)
        ->get();
        return $res->row_array();
    }

    /**
     * 简易店信息
     */
    public function corporation_info($id){
        $res = $this->db->select('id,customer_id')
        ->from('easy_corporation')
        ->where('id',$id)
        ->get();
        return $res->row_array();
    }

    /**
     * 查询订单号是否存在，存在返回true
     */
    function check_order_sn($order_sn)
    {
        $this->db->select('id');
        $query = $this->db->get_where('easy_order', array(
            'order_sn' => $order_sn
        ));
        if ($query->row_array()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 创建
     */
    public function create($table,$data){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    /**
     * 更新
     */
    public function update($table,$data=[],$where=[]){
        if($where)
        {
            return $this->db->update($table, $data, $where);
        }
        else
        {
            return false;
        }
    }

    /**
     * 查找
     */
    public function get_where($table,$where,$field='*',$all=false){
        $res = $this->db
        ->select($field)
        ->get_where($table,$where);

        if($all)
        {
            return $res->result_array();
        }
        else
        {
            return $res->row_array();
        }
    }

    /**
     * 订单详情
     */
    public function order_info($tribe_id,$order_id){
        $res = $this->db
        ->select('o.id,o.order_sn,o.quantity,o.product_id,o.product_img,o.total_price,o.customer_id,o.status,o.product_name,o.easy_corp_id,t.member_name name,t.mobile')
        ->from('easy_order o')
        ->join('easy_corporation c','c.id = o.easy_corp_id','left')
        ->join('tribe_staff t','t.customer_id = c.customer_id AND t.tribe_id = '.$tribe_id,'left')
        ->where('o.id',$order_id)
        ->where('o.is_delete',0)
        ->get()
        ->row_array();
        return $res;
    }

    /**
     * 订单列表
     * @param $is_sell true:订单(卖) false:订单(买)
     */
    public function order_list($customer_id,$easy_corp_id,$tribe_id,$status,$limit=0,$offset=0,$is_sell=false){

        $this->db->select('o.id,o.customer_id,o.product_name,o.product_img,o.quantity,o.product_id,o.status,o.total_price,t.member_name name,t.mobile');
        $this->db->from('easy_order o');

        if($is_sell)
        {
            $this->db->join('tribe_staff t','t.customer_id = o.customer_id','left');
            $this->db->where('o.easy_corp_id',$easy_corp_id);
        }
        else
        {
            $this->db->join('easy_corporation c','c.id = o.easy_corp_id','left');
            $this->db->join('tribe_staff t','t.customer_id = c.customer_id','left');
            $this->db->where('o.customer_id',$customer_id);
        }

        $this->db->where('o.tribe_id',$tribe_id);
        $this->db->where('t.tribe_id',$tribe_id);
        $this->db->where('o.is_delete',0);
        $this->db->order_by('o.created_at','DESC');

        if (array_key_exists('status', $status))
        {
            $this->db->where_in('o.status', $status['status']);
        }

        if($limit)
        {
            $this->db->limit( $limit, $offset );
            $res = $this->db->get()->result_array();
            return $res;
        }
        else
        {
            $res = $this->db->get()->num_rows();
            return $res;
        }
    }

    /**
     *  更改订单状态
     * @@param id       easy_order表的id
     * @@param status   状态 2:完成支付 4:确认收货
     */
    public function AfterEasyOrder($id,$status=2){
        //修改订单状态
        $data = ['status'=>$status];
        $where = ['id'=>$id];
        $res = $this->db->update('easy_order',$data,$where);

        if(!$res)
        {
            $result = ['status'=>0,'message'=>'修改订单状态失败'];
            return $result;
        }

        //添加订单日志
        $data = [
            'order_id'  =>  $id,
            'status'    =>  $status,
            'created_at'=>  date('Y-m-d H:i:s'),
        ];
        $res = $this->db->insert('easy_order_log',$data);
        if(!$res)
        {
            $result = ['status'=>0,'message'=>'添加订单日志失败'];
            return $result;
        }

        // 订单信息
        $where = ['id'=>$id];
        $field = 'order_sn,total_price,easy_corp_id';
        $order = $this->get_where('easy_order',$where,$field);

        // 收款方customer_id
        $where = ['id'=>$order['easy_corp_id']];
        $corp_cusotmer_id = $this->get_where('easy_corporation',$where,'customer_id');

        // 添加A端日志
        switch($status){
            case 2:
                $url = $this->url_prefix.'easy_order/pay_order';
                break;
            case 4:
                $url = $this->url_prefix.'easy_order/receive';
                break;
            default:
                $url = '';
                break;
        }
        
        $data_post['total_price'] = $order['total_price'];
        $data_post['order_sn'] = $order['order_sn'];
        $data_post['app_id'] = $this->session->userdata('app_info')['id'];
        $data_post['corp_customer_id'] = $corp_cusotmer_id['customer_id'];
        $data_post['customer_id'] = $this->session->userdata('user_id');
        if($status==4)
        {
            $data_post['order_list'][] = $data_post;
        }
        $error = json_decode($this->curl_post_result($url,$data_post),true);
        if($error['status'])
        {
            $result = ['status'=>1,'message'=>'成功'];
        }
        else
        {
            $result = ['status'=>0,'message'=>'失败'];
        }
        return $result;

    }

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

    /**
     * 扣除商品库存
     * @param int $id 产品id
     * @param number $qty 扣除的库存数
     */
    public function update_stock($id,$qty){
        $this->db->set('stock','stock-'.$qty,false);
        $this->db->where('id',$id);
        $this->db->where("(stock - $qty) >=",0,false);
        $this->db->update('easy_product');
        return $this->db->affected_rows();  
    }

    /**
     * 取消订单后 该订单中的商品库存加回去
     */
    public function stock_goods( $id= null, $qty = null ){
        $this->db->set('stock','stock + '.$qty,FALSE);
        $this->db->where( 'id',$id );
        $this->db->update('easy_product');
        return $this->db->affected_rows();
    }

    
    /**
     * @author JF
     * 2018年3月30日
     * 查询卖家最后订单
     * @param number $easy_corp_id 简易店id
     * @param number $tribe_id 部落id
     */
    function LastOrder($easy_corp_id,$tribe_id){
        if(!$easy_corp_id){
            return array();
        }
        $this->db->from("easy_order");
        $this->db->where("easy_corp_id",$easy_corp_id);
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("is_delete",0);
        $this->db->order_by("id","desc");
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
    * @author JF
    * 2018年4月2日
    * 查询买家最后订单
    * @param number $customer_id 用户id
    * @param number $tribe_id 部落id
    */
    function BuyersLastOrder($customer_id,$tribe_id){
        if(!$customer_id){
            return array();
        }
        $this->db->from("easy_order");
        $this->db->where("customer_id",$customer_id);
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("is_delete",0);
        $this->db->order_by("id","desc");
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
    * @author JF
    * 2018年4月2日
    * 根据简易店ID查询卖出的订单
    * @param number $easy_corp_id 简易店id
    * @param number $tribe_id 部落id
    */
    function SalesOrder($easy_corp_id,$tribe_id,$limit=0,$offset=0){
        if(!$easy_corp_id){
            return array();
        }
        $this->db->from("easy_order");
        $this->db->where("easy_corp_id",$easy_corp_id);
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("is_delete",0);
        if($limit){
            $this->db->limit($limit,$offset);
        }
        $query = $this->db->get();
        if($limit){
            return $query->result_array();
        }else{
            return $query->num_rows();
        }
    }
    
    /**
    * @author JF
    * 2018年4月2日
    * 根据用户ID查询购买的订单
    * @param number $customer_id 用户id
    * @param number $tribe_id 部落id
    */
    function BuyersOrder($customer_id,$tribe_id,$limit=0,$offset=0){
        if(!$customer_id){
            return array();
        }
        $this->db->from("easy_order");
        $this->db->where("customer_id",$customer_id);
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("is_delete",0);
        if($limit){
            $this->db->limit($limit,$offset);
        }
        $query = $this->db->get();
        if($limit){
            return $query->result_array();
        }else{
            return $query->num_rows();
        }
    }
}