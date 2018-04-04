<?php

/**
 * 部落货包
 *
 *
 */
class Tribe_package_mdl extends CI_Model
{
    function __construct()
    {
        parent::__construct ();
    }
    
    
    /**
     * 获取用户存在授权分享权限下的货包
     * @param int $user_id 用户id  
     * @param int $package_id  卡包id
     */
    public function get_tribe_package($user_id,$package_id = 0,$surplus_num = 100){
        $CURRENT_TIME =  date('Y-m-d H:i:s');// 当前时间
        $this->db->from("tribe_package");
        $this->db->where("FIND_IN_SET($user_id,(customer_ids))<>0");
        if($package_id){
            $this->db->where("id",$package_id);
        }
        if($surplus_num == 0){
            $this->db->where("surplus_num >",0);
        }
        //生效
        $this->db->where("status",1);
        //在货包允许发放期间
        $this->db->where("grant_start_at <= ",$CURRENT_TIME);
        $this->db->where("grant_end_at >= ",$CURRENT_TIME);
       
        return  $this->db->get()->result_array();
    }
    /**
     * 获取后台设置的货包
     * @param int $id 货包id
     */
    public  function get_tribe_packageById($id,$surplus_num = 0){
        $this->db->from("tribe_package");
        $this->db->where("id",$id);
        $this->db->where("status",1);
        if(!$surplus_num){
            $this->db->where("surplus_num >",0);
        }
        return  $this->db->get()->row_array();
    }
    //------货包退回---------
    
    
    
    public function refund_package(){
        $current_time = date('Y-m-d H:i:s');// 当前时间
        $this->db->from("tribe_package");
        $this->db->where("grant_start_at <= ",$current_time);
        $this->db->where("grant_end_at >= ",$current_time);
        return  $this->db->get()->result_array();
    }
    /**
     *  @param tribe_package_id
     * @param unknown $total
     */
    public function update_refund_package($tribe_package_id,$total){
         $query = $this->db->query( "update 9thleaf_tribe_package_log as a 
         JOIN 9thleaf_tribe_package as b  on b.id = a.`tribe_package_id` 
         JOIN 9thleaf_tribe_package_share as c on c.`tribe_package_id` =  b.id
         SET a.type = 3 ,b.surplus_num = $total
         WHERE   a.type = 0  
         and b.id= $tribe_package_id
         and UNIX_TIMESTAMP(c.`place_at`) + b.`coupon_at` *3600  <  UNIX_TIMESTAMP() ");
         return  $this->db->affected_rows();
    }
    //------货包退回---------
    /**
     * 货包ID
     * tribe_package_id
     */
    public function  get_refund_package_count($tribe_package_id){
        $query = $this->db->query("
             SELECT COUNT(DISTINCT(a.id)) as total FROM 9thleaf_tribe_package_log as a
             JOIN 9thleaf_tribe_package as b  on b.id = a.`tribe_package_id`
             JOIN 9thleaf_tribe_package_share as c on c.`tribe_package_id` =  b.id
             WHERE   a.type = 0
             and b.id=  $tribe_package_id
             and UNIX_TIMESTAMP(c.`place_at`) + b.`coupon_at` *3600  <  UNIX_TIMESTAMP()
            ");
        return $query->row_array();
    }
    
    
    /**
     * 获取用户历史分享货包
     * @param int $user_id 用户id
     */
    public function get_share_list($user_id,$limit = 0,$offset = 0){
        $this->db->select("a.*,b.image");
        $this->db->from("tribe_package_share as a");
        $this->db->join("tribe_package as b","a.tribe_package_id = b.id");
        $this->db->where("a.customer_id",$user_id);
        if($offset){
            $this->db->limit($limit,$offset);
        }else{
            $this->db->limit($limit);
        }
        $this->db->order_by("id","DESC");
        return  $this->db->get()->result_array();
    }
    
    /**
     * 获取领取的货包详情
     * @param int $user_id 用户id  
     * @param int  $tribe_package_id 货包id
     */
    public function load($user_id,$tribe_package_id){
        $this->db->select("a.*");
        $this->db->from("tribe_package_log as a");
        $this->db->join("tribe_package as b","a.tribe_package_id = b.id");
        $this->db->where("a.customer_id",$user_id);
        $this->db->where("a.tribe_package_id",$tribe_package_id);
        return  $this->db->get()->row_array();
    }
    /**
     * 获取领取的货包列表
     *  @param int $share_id  分享id
     */
    public function get_gain_package_list($share_id){
        $this->db->select("a.place_at,b.wechat_avatar,b.wechat_nickname,cc.id as crop_id");
        $this->db->from("tribe_package_log as a");
        $this->db->join("customer as b","a.customer_id = b.id");
        $this->db->join("customer_corporation as cc","cc.customer_id = b.id","LEFT");
        $this->db->where("a.package_share_id",$share_id);
        $this->db->where_in("a.type",array(1,2));
        return  $this->db->get()->result_array();
    }
    
    /**
     * 获取货包详情
     * @param int $share_id 分享id
     */
    public function get_share_detail($share_id){
        $this->db->select("a.*,b.tribe_id,b.name as tribe_package_name,b.desc as tribe_package_desc,b.grant_start_at,b.grant_end_at,b.image,b.coupon_at,b.status,b.gift_name");
        $this->db->from("tribe_package_share as a");
        $this->db->join("tribe_package as b","a.tribe_package_id = b.id");
        $this->db->where("a.id",$share_id);
        return  $this->db->get()->row_array();
    }

    // --------------------------------------------------------------------------------
    
   /**
    * 扣除库存
    * @param int 卡包id
    * @param int $num 数量 
    */ 
    public function update_stock($package_id,$num){
        $this->db->set("surplus_num","(surplus_num - $num)",false);
        $this->db->where("(surplus_num - $num) >= ",0,false);
        $this->db->where("id",$package_id);
        $this->db->update("tribe_package");
        return $this->db->affected_rows();
    }
   
    
    // --------------------------------------------------------------------------------
    
    /**
     * 创建分享货包
     * @param array $data 数据集合
     */
    public function AddSharePackage($data){
        $this->db->set($data);
        $this->db->insert("tribe_package_share");
        return $this->db->insert_id();
    }
    
    // --------------------------------------------------------------------------------
    
    /**
     * 创建分享货包log
     * @param array $data 数据集合
     */
    public function AddSharePackage_log($data){
        return $this->db->insert_batch("tribe_package_log",$data);
    }
    
    // --------------------------------------------------------------------------------
    
    /**
     * 更新分享货包
     * @param int $share_id 分享id
     * @param int $customer_id 用户id
     * @param array 数据集合
     */
    public function save($share_id,$customer_id,$data){
        $this->db->set($data);
        $this->db->where("id",$share_id);
        $this->db->where("customer_id",$customer_id);
        return $this->db->update("tribe_package_share");
    } 
    
    // --------------------------------------------------------------------------------
    
    /**
     * 更新tribe_package_log表
     * @param int $share_id 分享id
     * @param int $customer_id 用户id
     * @param array 数据集合
     */
    public function update_package_log($share_id,$customer_id,$data){
        $this->db->set($data);
        $this->db->where("type !=",1);
        $this->db->where("package_share_id",$share_id);
        $this->db->where("customer_id",$customer_id);
        $this->db->update("tribe_package_log");
        return $this->db->affected_rows();
    }
    
    
    /**
     * 获取发放余数
     *  @param int  package_share_id
     */
    public  function get_share_count($package_share_id){
        $this->db->from("tribe_package_log");
        $this->db->where("type",0);
        $this->db->where("package_share_id",$package_share_id);
        return $this->db->get()->result_array();
    }
    // --------------------------------------------------------------------------------
    
    /**
     * 领取货包
     * @param int $customer_id 用户id
     * @param int $package_id 货包id
     * @param int $share_id 分享货包id
     */
    public function Packet_receipt($customer_id,$package_id,$share_id){
        $this->db->set("place_at",date('Y-m-d H:i:s'));// 当前时间
        $this->db->set("type",2);
        $this->db->set("customer_id",$customer_id);
        $this->db->where("package_share_id",$share_id);
        $this->db->where("tribe_package_id",$package_id);
        $this->db->where("(customer_id is null or customer_id='')");
        $this->db->where("type",0);
        $this->db->limit(1);
        $this->db->update("tribe_package_log");
        return $this->db->affected_rows();
    }
    
    // --------------------------------------------------------------------------------
    
    /**
     * 检查货包是否被我已经领取
     * @param int $customer_id 用户id
     * @param int $package_id 货包id
     */
    public function check($customer_id,$package_id){
        if(!$package_id){
            return false;
        }
        $query = $this->db->get_where("tribe_package_log",array("customer_id"=>$customer_id,"tribe_package_id"=>$package_id));
        return $query->num_rows();
    }

    
}