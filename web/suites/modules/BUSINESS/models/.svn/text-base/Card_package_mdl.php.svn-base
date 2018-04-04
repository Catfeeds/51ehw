<?php
/**
 * 
 * 卡包模型
 *
 */

class  Card_package_mdl extends CI_Model {

var $package_sn;
var $name;
var $specified_type;
var $discount_type;
var $overtop_price;
var $deduction_price;
var $discount;
var $number;
var $grant_start_at;
var $grant_end_at;
var $coupon_start_at;
var $coupon_end_at;
var $describe;
var $coupon_image;
var $ad_image;
var $donation;
var $give_type;
var $status;
var $is_show;
var $is_activity;
    

	function __construct() {
		parent::__construct ();
	}

	/**
	 * 企业查询卡包
	 * @param int $id 货包id
	 * @param int $status 状态：1未开始，2活动中，3已过期，4审核中，5审核失败
	 * @param $search 搜索参数
	 */
	public function get_package($id=0,$status=0,$search=null,$offset=null,$limit=null){
        $this->db->from("package as a");
        if($id){
            $this->db->where("a.id",$id);
        }
        switch ($status){
        case "1":
            $this->db->where("a.coupon_start_at >",date("Y-m-d"));
            $this->db->where("a.status",3);
            break;
        case "2":
            $this->db->where("a.coupon_start_at <=",date("Y-m-d"));
            $this->db->where("a.coupon_end_at >=",date("Y-m-d"));
            $this->db->where("a.status",3);
            break;
        case "3":
            $this->db->where("a.coupon_end_at <",date("Y-m-d"));
            $this->db->where("a.status",3);
            break;
        case "4":
            $this->db->where("a.status",1);
            break;
        case "5":
            $this->db->where("a.status",2);
            break;
        case "6":
            $this->db->where("a.status",0);
            break;
        }
        if($limit){//分页
            $this->db->limit($limit,$offset);
            $this->db->order_by("created_at",'desc');
        }
        if($search){
        $this->db->like("a.name",$search);
        }
        $this->db->where("a.status !=",4);
        $this->db->where("a.corporation_id",$this->session->userdata("corporation_id"));
        $query = $this->db->get();
        if($id){
            $result = $query->row_array();
        }else{
            $result = $query->result_array();
        }
        return $result;
	}
	

	
	/**
	 * 根据流水号查询卡包
	 */
	public function get_package_sn($package_sn){
	    $this->db->from("package");
	    $this->db->where("package_sn",$package_sn);
	    $query = $this->db->get();
	    $result = $query->row_array();
	    return $result;
	}
	
	/**
	 * 添加货包信息
	 */
	public function add(){
	    $this->db->set("package_sn",$this->package_sn);
	    $this->db->set("name",$this->name);
	    $this->db->set("specified_type",$this->specified_type);
	    $this->db->set("discount_type",$this->discount_type);
	    $this->db->set("overtop_price",$this->overtop_price);
	    $this->db->set("deduction_price",$this->deduction_price);
	    $this->db->set("discount",$this->discount);
	    $this->db->set("number",$this->number);
	    $this->db->set("grant_start_at",$this->grant_start_at);
	    $this->db->set("grant_end_at",$this->grant_end_at);
	    $this->db->set("coupon_start_at",$this->coupon_start_at);
	    $this->db->set("coupon_end_at",$this->coupon_end_at);
	    $this->db->set("describe",$this->describe);
	    $this->db->set("coupon_image",$this->coupon_image);
	    $this->db->set("ad_image",$this->ad_image);
	    $this->db->set("donation",$this->donation);
	    $this->db->set("is_show",$this->is_show);
// 	    $this->db->set("is_activity",$this->is_activity);
	    $this->db->set("corporation_id",$this->session->userdata("corporation_id"));
	    $this->db->set("created_at",date("Y-m-d H:i:s"));
	    $this->db->set("status",1);
	    $this->db->set("give_type",$this->give_type);
	    $this->db->set("customer_id",$this->session->userdata("user_id"));
	    $this->db->insert("package");
	    return $this->db->insert_id();
	}
	
	/**
	 * 添加货包关联信息
	 */
	public function increase($data){
	    $this->db->insert_batch('package_item', $data);
	    return $this->db->insert_id();
	}
	
	
	/**
	 * 更新货包信息
	 * @param int $id
	 */
	public function save($id){

	    $this->name?$this->db->set("name",$this->name):null;
	    $this->specified_type?$this->db->set("specified_type",$this->specified_type):null;
	    $this->discount_type?$this->db->set("discount_type",$this->discount_type):null;
	    $this->overtop_price?$this->db->set("overtop_price",$this->overtop_price):null;
	    $this->deduction_price?$this->db->set("deduction_price",$this->deduction_price):null;
	    ($this->discount || $this->discount==="0")?$this->db->set("discount",$this->discount):null;
	    $this->number?$this->db->set("number",$this->number):null;
	    $this->grant_start_at?$this->db->set("grant_start_at",$this->grant_start_at):null;
	    $this->grant_end_at?$this->db->set("grant_end_at",$this->grant_end_at):null;
	    $this->coupon_start_at?$this->db->set("coupon_start_at",$this->coupon_start_at):null;
	    $this->coupon_end_at?$this->db->set("coupon_end_at",$this->coupon_end_at):null;
	    $this->describe?$this->db->set("describe",$this->describe):null;
	    $this->coupon_image?$this->db->set("coupon_image",$this->coupon_image):null;
	    $this->ad_image?$this->db->set("ad_image",$this->ad_image):null;
	    $this->donation?$this->db->set("donation",$this->donation):null;
	    if(!is_null($this->is_show)){
	       $this->db->set("is_show",$this->is_show);
	    }
// 	    $this->db->set("is_activity",$this->is_activity);
	    $this->db->set("corporation_id",$this->session->userdata("corporation_id"));
	    $this->db->set("created_at",date("Y-m-d H:i:s"));
	    $this->status || $this->status===0?$this->db->set("status",$this->status):null;
	    $this->give_type?$this->db->set("give_type",$this->give_type):null;
	    $this->db->where("id",$id);
	    $this->db->update("package");
        return $this->db->affected_rows();
	}
	
	
	
	/**
	 * 删除货包关联信息
	 * @param int $package_id
	 * @param array $sid 商品id或者分类id
	 */
	public function del($package_id,$sid=null){
	    $where = "";
	    $id = "";
	    if($sid){
            foreach ($sid as $v){
                if($id){
                    $id .= ",".$v;
                }else{
                    $id .= $v;
                }
            }
            $where = "(`product_id` IN('$id') OR `cate_id` IN('$id')) AND";
	    }
	    $query = $this->db->query("DELETE FROM `9thleaf_package_item` WHERE  $where `package_id` IN('$package_id')");
	    return $this->db->affected_rows();
	    
	}
	
	
	/**
	 * 查询货包选中分类or商品
	 * @param int 货包id
	 * @param int 1商品2品类
	 */
	public function Selected($id,$type){
	    $this->db->select("c.id,c.name");
	    $this->db->from("package_item as a");
	    $this->db->join("package as b","a.package_id = b.id");
	    switch ($type){
	        case "1":
                $this->db->join("product as c","c.id = a.product_id");
                $this->db->where("c.is_delete",0);
	           break;
	        case "2":
	            $this->db->join("product_cat as c","c.id = a.cate_id");
	            break;
	    }
	    $this->db->where("b.corporation_id",$this->session->userdata("corporation_id"));
	    $this->db->where("b.status !=",4);
	    $this->db->where("a.package_id",$id);
	    $query = $this->db->get();
	    $result = $query->result_array();
	    return $result;
	}
	
	
	/**
	 * 统计领取
	 * @param int $id 卡包id
	 * @param array $status 领取状态
	 */
	public function receive_total($id,$status=0){
	    $this->db->from("package_detail");
	    $this->db->where("p_id",$id);
	    if($status){
	        $this->db->where_in('status',$status);
	    }
	    $query = $this->db->get();
	    return $query->num_rows();
	}
	

	/**
	 * 检查授权
	 * @param string $customer_id 用户id
	 * @param int $p_id 货包id
	 */
	public function check_authorize($p_id,$customer_id){
	    $this->db->select('b.*');
	    $this->db->from("package as a");
	    $this->db->join("package_accredit as b",'a.id = b.p_id','left');
	    $this->db->where('a.id',$p_id);
	    $this->db->where('corporation_id',$this->session->userdata('corporation_id'));
	    $this->db->where('b.customer_id',$customer_id);
	    $query = $this->db->get();
	    $result = $query->row_array();
	    return $result;
	}
	
	/**
	 * 更新授权状态
	 * @param int $id 授权表id
	 * @param int $status 状态：1授权2取消授权
	 */
	public function edit($id,$status){
	    $this->db->set('status',$status);
	    $this->db->where('id',$id);
	    $this->db->update("package_accredit");
        return $this->db->affected_rows();
	}
	
	
	/**
	 * 添加授权人
	 * @param int $customer_id 用户id
	 * @param int $p_id 卡包id
	 */
	public function add_accredit($p_id,$customer_id){
	    $this->db->set('p_id',$p_id);
	    $this->db->set('customer_id',$customer_id);
	    $this->db->set('created_at',date("Y-m-d H:i:s"));
	    $this->db->set('status','1');
	    $this->db->insert('package_accredit');
	    return $this->db->insert_id();
	}
	
	/**
	 * 查询商家授权列表
	 * @param 货包id $id
	 * @param 状态 $status 授权＝1 取消授权＝2
	 * @return unknown
	 */
	public function get_authorize($id,$status){
	   $this->db->select("a.*,b.name,b.mobile");
	   $this->db->from("package_accredit a");
	   $this->db->join("customer b","a.customer_id = b.id");
	   $this->db->where("a.p_id","$id");
	   $this->db->where("status",$status);
	   $query = $this->db->get();
	   $result = $query->result_array();
	   return $result;    
	}
	
	// -------------------------------------------------------------
	
	/**
	 * 根据状态查询用户领取的卡包
	 * @param int $customer_id 用户id
	 * @param int $status 状态1=已使用，2未使用，3过期
	 * @param int $p_id 卡包id
	 */
    public function package($customer_id,$status,$p_id=0,$limit=0,$offset=0){
        $this->db->select('a.id as d_id,a.sender_id,a.created_at,b.id,b.name,b.describe,b.coupon_image,b.donation,b.coupon_start_at,b.coupon_end_at,b.discount_type');
        $this->db->from("package_detail a");
        $this->db->join('package b','b.id=a.p_id');
        $this->db->where("a.customer_id",$customer_id);
        switch ($status){
            case "1"://我已经使用的卡包
                $this->db->where("a.status",1);
                break;
            case "2"://我未使用的卡包
                $this->db->where("b.coupon_end_at >=",date("Y-m-d"));
                $this->db->where("a.status",2);
                break;
            case "3"://我过期的卡包
                $this->db->where_in("a.status",array(2));
                $this->db->where("b.coupon_end_at <",date("Y-m-d"));
                break;
//             case "4"://我的全部卡包
//                 $this->db->where("a.status",2);
//                 break;
        }
        if($p_id){
            $this->db->where("b.id",$p_id);
        }
        if ($offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        if($p_id){
            $result = $query->row_array();
        }else{
            $result = $query->result_array();
        }
        return $result;
    }
    
    // -------------------------------------------------------------
    /**
     * 查询用户是否领取货包
     * @param int $id 卡包id $type 1查详情 
     */
    public function  check_package($id,$type = 0){
        $user_id = $this->session->userdata("user_id");
        if(!$type){
            $this->db->select("pd.*,p.deduction_price,p.grant_end_at,p.coupon_start_at,p.coupon_end_at,p.coupon_image,p.ad_image,p.describe,p.name,p.discount_type,p.discount,p.donation");
            $this->db->from("package_detail as pd");
            $this->db->join("package as p","p.id = $id");
            $this->db->where("pd.customer_id",$user_id);
            $this->db->where("pd.p_id",$id);
          }else{
              $this->db->select("pd.*,p.corporation_id");
              $this->db->from("package_detail as pd");
              $this->db->join("package as p","p.id = pd.p_id");
              $this->db->where("pd.id",$id);
          }
        return $this->db->get()->row_array();
    }
    
    public function  check_packageBySn($package_sn){
        $user_id = $this->session->userdata("user_id");
        $this->db->select("pd.*,p.deduction_price,p.grant_end_at,p.coupon_start_at,p.coupon_end_at,p.coupon_image,p.ad_image,p.describe,p.name,p.discount_type,p.discount,p.donation");
        $this->db->from("package_detail as pd");
        $this->db->join("package as p","p.package_sn = $package_sn");
        $this->db->where("pd.customer_id",$user_id);
        $this->db->where("pd.p_id","p.id");
        return $this->db->get()->row_array();
    }
    
    
    
    // -------------------------------------------------------------
    
    /**
     * 根据id查询卡包
     * @param int $id 卡包id
     * @param int $status 状态
     */
    public function get_card_package($id,$status=0){
        $this->db->from('package');
        $this->db->where('id',$id);
        if($status){
        $this->db->where('status',3);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
    /**
     * 根据卡包ID查询已领取的卡包
     * @param int $p_id 卡包id
     * @param int $customer_id 用户id
     */
    public function receive($p_id,$customer_id,$status=0){
        if($status){
            $this->db->select("a.*,b.deduction_price,b.coupon_image,b.ad_image,b.describe,b.status,b.name,b.discount_type,b.discount,b.donation");
            $this->db->from("package_detail a");
            $this->db->join("package b","a.p_id = b.id","left");
        }else{
            $this->db->select("a.*");
            $this->db->from("package_detail a");
        }
        $this->db->where("a.customer_id",$customer_id);
        $this->db->where("a.p_id",$p_id);
        $this->db->where("a.status !=",3);
        if(!$status){
        $this->db->where_in("a.status",array(1,2));
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
    /**
     * 根据卡包ID查询已领取的卡包
     * @param number $package_sn 卡包单号
     * @param int $customer_id 用户id
     */
    public  function  loadByPackage_Sn($Package_Sn,$customer_id){
        $this->db->select("pd.*");
        $this->db->from("package as p");
        $this->db->join("package_detail as pd","pd.p_id = p.id");
        $this->db->where("pd.customer_id",$customer_id);
        $this->db->where("p.package_sn",$Package_Sn);
        return $this->db->get()->row_array();
    }
    
    // ------------------------------------------------------  
    
    
    /**
     * 领取卡包
     * @param array $data
     */
    public function aad_package($data){
        $this->db->insert_batch('package_detail', $data);
        return $this->db->insert_id();
    }
    
    
    // ------------------------------------------------------
    
    
    /**
     * 查询用户授权列表
     * @param int $customer_id
     * @param int $p_id 卡包id
     */
    public function accredit($customer_id,$p_id=0){
        $this->db->select("a.*");
        $this->db->from("package a");
        $this->db->join("package_accredit b","b.p_id = a.id");
        $this->db->where("b.customer_id",$customer_id);
        $this->db->where("a.status",3);
        $this->db->where("b.status",1);
        $p_id?$this->db->where("b.p_id",$p_id):null;
        $query = $this->db->get();
        if($p_id){
            $result = $query->row_array();
        }else{
            $result = $query -> result_array();
        }
        return $result;
    }
    
    
    
    /**
     * 扣除卡包数量
     */
    public function subduction($id,$number){
        $this->db->set("number","number - $number",false);
        $this->db->where("(number - $number) >=",0,false);
        $this->db->where("id",$id);
        $this->db->update('package');
        return $this->db->affected_rows();
    }
    
    /**
     * 抢卡包
     * @param int $customer_id 用户id
     * @param int $p_id 卡包id
     * @param int $sender_id 发送人id
     * @param string $created_at 卡包创建时间
     */
    public function obtain_package($customer_id,$p_id,$sender_id,$created_at){
        $this->db->limit(1);
        $this->db->set("customer_id",$customer_id);
        $this->db->set("status",2);
        $this->db->set('collection_at',date("Y-m-d H:i:s"));
        $this->db->where("p_id",$p_id);
        $this->db->where("sender_id",$sender_id);
        $this->db->where("(customer_id is null or customer_id='')");
        $this->db->where("status !=",3);
        $this->db->where("created_at",$created_at);
        $this->db->update("package_detail");
        return $this->db->affected_rows();
    }
    
    /**
     * 查询卡包领取情况
     * @param int 卡包id
     * @param int $sender_id 发送人id
     * @param string $created_at 卡包创建时间
     * @param int 状态
     */
    public function obtain_package_detail($id,$sender_id,$created_at,$status=0){
        $this->db->select("a.id,a.customer_id,a.status,a.collection_at,c.nick_name,c.wechat_nickname,c.wechat_avatar");
        $this->db->from("package_detail a");
        $this->db->join("customer c","a.customer_id=c.id");
        $this->db->where("a.p_id",$id);
        $this->db->where("a.sender_id",$sender_id);
        $this->db->where("a.created_at",$created_at);
        $this->db->where("status !=",3);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    /**
     * 查询卡包领取人数
     * @param unknown $id
     * @param unknown $sender_id
     * @param unknown $created_at
     * @param array $status 状态
     */
    public function Complete_progress($id,$sender_id,$created_at,$status){
        $this->db->from("package_detail a");
        $this->db->where("a.p_id",$id);
        $this->db->where("a.sender_id",$sender_id);
        $this->db->where("a.created_at",$created_at);
        $this->db->where_in("status",$status);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
     * 统计发送数量
     */
    public function send_num($p_id,$sender_id,$created_at){
        $this->db->from("package_detail");
        $this->db->where("p_id",$p_id);
        $this->db->where("sender_id",$sender_id);
        $this->db->where("created_at",$created_at);
        $this->db->where("status !=",3);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
     * 发放记录
     * @param int $customer_id 用户id
     */
    public function send_record($customer_id){
        $query = $this->db->query("
        select a.id,a.coupon_image,b.* from 9thleaf_package as a
        join (
        select p_id,count(p_id) as total,count(IFNULL(customer_id,NULL))  as obtain,created_at,sender_id from 9thleaf_package_detail 
        where sender_id = '$customer_id' and status != 3 group by p_id,created_at
        ) as b on a.id=b.p_id");
        $result = $query->result_array();
        return $result;
    }
    
    
    // ----------------------------------------------------------------
    
    
    /**
     * 转赠优惠券
     * @param int $id 
     * @param int $customer_id
     */
    public function update($id){
        $this->db->set("customer_id",NULL);
        $this->db->set("status",4);
        $this->db->where("id",$id);
        $this->db->update("package_detail");
        return $this->db->affected_rows();
        
    }
    
    
    // ----------------------------------------------------------------
    
    
    /**
     * 优惠卷相关商品
     * @param int $p_id 卡包id
     * @return int $customer_id 用户id
     * @param str $type  默认优惠券(领取时间最新)
     */
    public function  discount_goods($p_id,$customer_id,$limit=0,$offset=0,$type = ''){
        $this->db->select("a.id,a.vip_price,a.name,a.goods_thumb,a.sales_count,a.longitude,a.latitude,c.id as package_id,c.discount_type,c.overtop_price,c.deduction_price,c.discount,c.coupon_end_at");
        $this->db->from("product as a");
        $this->db->join("package_item as b","a.id = b.product_id or a.cat_id = b.cate_id");
        $this->db->join("package as c","c.id = b.package_id");
        $this->db->join("package_detail as d","d.p_id=c.id");
        $this->db->where_in("b.package_id",$p_id);
        $this->db->where("c.corporation_id = a.corporation_id");
        $this->db->where("c.coupon_end_at >=",date("Y-m-d"));
        $this->db->where("c.coupon_start_at <=",date("Y-m-d"));
        $this->db->where('a.is_on_sale',1);
        $this->db->where('a.is_delete',0);
        $this->db->where('a.is_mc',0);
        $this->db->where("d.customer_id",$customer_id);
        $this->db->where("d.status",2);
        if ($offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }
        if($type && $type == 'default'){//默认选择优惠券  取获取到的一张优惠券
            $this->db->order_by("d.collection_at","desc");//领取时间最新
        }else{
            $this->db->order_by("sales_count","desc");//默认销量最高
        }
        
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    
    // -------------------------------------------------------------
    
    
    /**
     * 商品可以使用的优惠卷
     * @param array $product_id 商品id
     * @param int $customer_id  用户id
     * @param array $p_id 卡包id
     */
    public function goods_coupons($product_id,$customer_id,$p_id=0,$limit=0,$offset=0){
        $this->db->select("any_value(c.id) as product_id ,a.id,a.coupon_image,a.discount_type,a.discount,a.overtop_price,a.deduction_price,a.corporation_id,a.name");
        $this->db->from("package as a");
        $this->db->join("package_item as b","a.id = b.package_id or a.specified_type = 3");
        $this->db->join("product as c","b.product_id = c.id or c.cat_id = b.cate_id");
        $this->db->join("package_detail as d","d.p_id=a.id");
        $this->db->where("a.coupon_end_at >=",date("Y-m-d"));
        $this->db->where("a.coupon_start_at <=",date("Y-m-d"));
        $this->db->where_in("c.id",$product_id);
        $this->db->where("c.is_on_sale",1);
        $this->db->where("c.is_delete",0);
        $this->db->where("c.is_mc",0);
        $this->db->where("d.customer_id",$customer_id);
        $this->db->where("d.status",2);
        $this->db->where("a.corporation_id = c.corporation_id");
        if ($offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }
        if($p_id){
            $this->db->where_in("a.id",$p_id);
            $this->db->group_by("d.p_id");
        }
        
        $query = $this->db->get();

        return $query->result_array();
    }
    
    
    // -------------------------------------------------------------
    
    
    /**
     * 查询不可使用的优惠卷
     * @param array $p_id 卡包id
     * @param int $customer_id  
     */
    public function not_goods_coupons($p_id,$customer_id){
        $this->db->select("b.id,b.coupon_image");
        $this->db->from("package_detail as a");
        $this->db->join("package as b","a.p_id = b.id");
        if($p_id){
            $this->db->where_not_in("a.p_id",$p_id);
        }
        $this->db->where("a.customer_id",$customer_id);
        $this->db->where("a.status",2);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    // -------------------------------------------------------------
    

    /**
     * 使用优惠券
     * @param int 卡包id
     * @param int 用户
     * @param string 订单号
     */
    public function Clip_coupons($p_id,$customer_id,$order_sn){
        $this->db->set("order_sn",$order_sn);
        $this->db->set("use_at",date("Y-m-d H:i:s"));
        $this->db->set("status",1);
        $this->db->where("customer_id",$customer_id);
        $this->db->where_in("p_id",$p_id);
        $this->db->update("package_detail");
        return $this->db->affected_rows();
    }
    
    /**
     * 确定核销
     * @param $id 卡包id
     */
    function sure_verification($id){
        $this->db->set("status",1);
        $this->db->where("id",$id);
        $this->db->update("package_detail");
        return $this->db->affected_rows();
    }
    
    /**
     * 卡包领取情况
     * @param $id 卡包id
     */
    function situation($id){
        $this->db->select("a.id,a.status,b.wechat_nickname,b.nick_name,b.mobile");
        $this->db->from("package_detail a");
        $this->db->join("customer b","a.customer_id = b.id");
        $this->db->where("a.p_id",$id);
        $this->db->where_in("a.status",array(1,2));
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * 根据卡包id统计卡包剩余数量
     * @param int $p_id 卡包id
     * @param int $status 状态
     */
    function SurplusPackage($p_id,$status){
        $this->db->select("a.number+count(b.id) as not_number");
        $this->db->from("package a");
        $this->db->join("package_detail b","a.id=b.p_id","left");
        $this->db->where("b.status",$status);
        $this->db->where("a.id",$p_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    // -------------------------------------------------------------
    
    /**
     * 根据用户id和状态获取优惠券
     * @param int $customer_id 用户id
     * @param array $status 状态
     */
    public function my_package_all($customer_id,$status){
        $this->db->from("package_detail");
        $this->db->where("customer_id",$customer_id);
        $this->db->where_in("status",$status);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // --------------------------------------------------------------
    
    /**
     * 获取未领取的优惠券列表
     * @param array $p_array 未使用的优惠券id
     */
    public function not_obtained($p_array){
        $this->db->from("package");
        if($p_array){
            $this->db->where_not_in("id",$p_array);
        }
        $this->db->where("status",3);
        $this->db->where("grant_start_at <= curdate()");
        $this->db->where("grant_end_at >= curdate()");
        $this->db->where("is_show",1);
        $this->db->where("give_type",2);
        $this->db->where("number >",0);
        $query = $this->db->get();
        return $query->result_array();
    } 
    
    
    // --------------------------------------------------------------
    
    /**
     * 获取发送所有人未领取的优惠券
     * @param int $p_array 已经领取的优惠券id
     */
    public function not_obtained_package($p_array){
        $this->db->from("package");
        if($p_array){
        $this->db->where_not_in("id",$p_array);
        }
        $this->db->where("status",3);
        $this->db->where("grant_start_at <= curdate()");
        $this->db->where("grant_end_at >= curdate()");
        $this->db->where("give_type",1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // ---优惠券活动模板-----------------------------------------------------------
    /**
     * 活动详情
     * @param int $activity_id 发布的活动ID  $activity_id
     */
    public function load_activity($activity_id){
        $this->db->from("activity");
        $this->db->where("id",$activity_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * 获取多个优惠券信息的开始时间
     * @param array $package_sn 优惠券单号
     */
    public function  load_byPackage_Sn($package_sn){
        $this->db->from('package');
        $this->db->where_in('package_sn',$package_sn);
        $query = $this->db->get();
        return $query->result_array();
    }
    
   /**
    * 活动绑定的优惠券信息
    * @param int $activity_id 发布的活动ID  
    */
    public function load_activity_package($activity_id){
        $this->db->from("activity_details");
        $this->db->where("activity_id",$activity_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    // --------------------------------------------------------------
}
 