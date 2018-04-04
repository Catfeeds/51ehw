<?php

/**
 * 订单核销
 *
 *
 */
class Order_verify_mdl extends CI_Model
{
    public $order_id;
    
    public $verify_number;
    
    public $verify_time;
    
    public $verify_by;
    
    
    // --------------------------------------------------------------------
    
    function create($order_id){
        $this->db->set('order_id',$order_id);
        $this->db->set('verify_number',  $this->verify_number);
        $this->db->set('verify_time',  $this->verify_time);
        $this->db->set('verify_by',  $this->verify_by);
      
        
        $this->db->insert('order_verify');
        return $this->db->insert_id();
    }
    
    
    
    /**
     * 获取订单的核销信息
     */
    function get_order($orderid){
        $this->db->select("*");
        $this->db->from("order_verify");
        $this->db->where("order_id",$orderid);
        $query =$this->db->get()->row_array();
        return $query;
    }
    
 
    
    /**
     * 根据核销单号获取订单
     *
     * @param unknown $verify_number
     * @return multitype:|unknown
     */
    function load_byVerify($verify_number){
        if (! $verify_number) {
            return array();
        }
        $this->db->select("o.*,ov.order_id,ov.verify_number,ov.verify_by,ov.verify_time");
        $this->db->from('order_verify as ov');
        $this->db->join("order as o","o.id = ov.order_id ","left");
        $this->db->where('ov.verify_number',$verify_number);
        $query = $this->db->get();
        if ($row = $query->row_array()) {
            return $row;
        }
    
        return array();
    }
    /**
     * 员工核销记录
     * 控制器传参 $time为默认days 保证 $time不为空
     */
    function get_verifyLog($userid,$time,$limit=0,$offset=0){
        $this->db->select('o.id,o.order_sn,o.total_price,ov.verify_time,DATE_FORMAT( ov.verify_time, "%Y-%m-%d" ) as days');
        $this->db->from('order as o');
        if ($time && $time != 'days') {
            //查询一天内核销记录
            //格式为 年-月-日
            $time = strtotime($time);
            $time = date("Y-m-d",$time);
            $this->db->where('DATE_FORMAT( `ov`.`verify_time`, "%Y-%m-%d" ) =', $time);
        }
        //核销记录表
        $this->db->join("order_verify as ov","o.id = ov.order_id","left");
        
        //店铺员工表
        $this->db->join("corporation_staff as cs","o.corporation_id =  cs.corporation_id","left");
        $this->db->where('cs.customer_id',$userid);
        //核销员工在职状态
        $this->db->where('cs.status',2);
        
        //核销员工在职状态
        $this->db->where('ov.verify_by',$userid);
        //已核销
        $this->db->where('ov.verify_time is not null');
        //并且订单是已完成的
        $this->db->where_in('o.status',array(6,7,8,9,11,12,14));
        $this->db->order_by('ov.verify_time','DESC');
    
        if ($offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }
        $query =  $this->db->get()->result_array();
        return $query;
    }
    
    /**
     * 店主核销记录
     */
    function get_OwnerVerifyLog($userid,$time,$limit=0,$offset=0){
        $this->db->select('o.id,o.order_sn,o.total_price,ov.verify_time,DATE_FORMAT( ov.verify_time, "%Y-%m-%d" ) as days');
        $this->db->from('order as o');
        if ($time && $time != 'days') {
            //查询一天内核销记录
            //格式为 年-月-日
            $time = strtotime($time);
            $time = date("Y-m-d",$time);
            $this->db->where('DATE_FORMAT( `ov`.`verify_time`, "%Y-%m-%d" ) =', $time);
        }
        //核销记录表
        $this->db->join("order_verify as ov","o.id = ov.order_id","left");
    
        //核销员工在职状态
        $this->db->where('ov.verify_by',$userid);
        //已核销
        $this->db->where('ov.verify_time is not null');
        //并且订单是已完成的
        $this->db->where_in('o.status',array(6,7,8,9,11,12,14));
        $this->db->order_by('ov.verify_time','DESC');
    
        if ($offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }
        $query =  $this->db->get()->result_array();
        return $query;
    }
    
    
    
    /**
     * 查询核销编号是否存在，存在返回true
     */
    function check_verify_number($verify_number)
    {
        $this->db->select('id');
        $query = $this->db->get_where('order_verify', array(
            'verify_number' => $verify_number
        ));
        if ($query->row_array()) {
            return true;
        } else {
            return false;
        }
    }
    // --------------------------------------------------------------------
    
    
}