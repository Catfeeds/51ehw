<?php
/**
 * 
 *
 *
 */ 
class Customer_shop_mdl extends CI_Model {
    
   
    var $name ;
    var $logo ;
    var $app_id ;
    var $updated_at ;
    var $check_at ;
    var $shop_no ;
    var $remark ;
    
    function __construct() {
        parent::__construct ();
    }
    
    function create($data){
        $datetime = date('Y-m-d H:i:s');
        $this->db->set('registry_at',$datetime);
        $this->db->set('customer_id',$data['customer_id']);
        $this->db->set('name',$data['name']);
        $this->db->set('logo',$data['logo']);
        $this->db->set('app_id',$data['app_id']);
        
        $this->db->insert ( 'customer_shop' );
        return $this->db->insert_id ();
    }
    
    /**
     * 编辑更新互助店
     * @param 用户ID $id
     */
    
    function update($id){
        $datetime = date('Y-m-d H:i:s');
        
        if($this->name !=NULL){
            $this->db->set('name', $this->name);
        }
        $this->db->set('updated_at', $datetime);
        $this->db->where('customer_id',$id);
        
        $this->db->update ( 'customer_shop' );
        
        return $this->db->affected_rows();
    }
    
    
    
    /** 获取互助店信息
     * 
     * @param 用户ID $user_id
     */
    function load($user_id){
        $this->db->select("*");
        $this->db->from('customer_shop');
        $this->db->where("customer_id",$user_id);
        $query = $this->db->get()->row_array ();
        return $query;
    }
    
    /** 获取互助店信息
     *
     * @param 互助店ID $id
     */
    function shop_load($id){
        $this->db->select("*");
        $this->db->from('customer_shop');
        $this->db->where("id",$id);
        $query = $this->db->get()->row_array ();
        return $query;
    }
    
    //--------------------------------------------
    /**
     * 获取商品
     * $status 发布状态
     */
    function get_product($status = 0,$shop_id = NULL,$limit =0 ,$offset = 0){
        $this->db->select("sp.id,p.id as product_id,p.name,p.vip_price,p.goods_thumb,sp.status");
        $this->db->from('product as p');
        $this->db->join('shop_product as sp','p.id = sp.product_id', 'left' );
    
        $this->db->join ( 'product_brand as b', 'b.id = p.brand_id', 'left outer' );
        $this->db->join ( 'product_cat as c', 'c.id = p.cat_id', 'left outer' );
        $this->db->join ( 'product_image as i', 'p.id = i.product_id and i.is_base = 1', 'left outer' );
        $this->db->join ( 'app_info as a', 'p.app_id = a.id', 'left outer' );
    
    
//         $this->db->where('p.stock != 0');//库存不为O
        $this->db->where ( 'p.is_on_sale', 1 );//上架
        $this->db->where ( 'p.is_delete', 0 );//没删除
        $this->db->where('sp.shop_id',$shop_id);//互助店
    
        if($status == 0){
            $this->db->where ( 'sp.status', $status );//商品在互助店的状态
        }else{
            $this->db->where_in( 'sp.status', array(1,2));//商品在互助店的状态
        }
       
        $this->db->order_by ( 'sp.sequence , sp.add_at','DESC' );
    
        if($offset){
            $this->db->limit($limit,$offset);
        }else{
            $this->db->limit($limit);
        }
        $query = $this->db->get()->result_array ();
      
        return $query;
    }
    //--------------------------------------------
    /**
     * 手机号绑定微信,将微信之前的数据同步到手机号上
     * @param parent_id
     * @param weiixn_id 微信账户ID
     * @param mobile_id 手机账户ID
     * (主要更新 9thleaf_shop_share和9thleaf_shop_read)
     */
    public function update_share_log($weiixn_id,$mobile_id,$parent_id){
        $this->db->set('customer_id',$mobile_id);
        $this->db->where('customer_id',$weiixn_id);
        $this->db->where('parent_id',$parent_id);
        $aff =  $this->db->update('shop_share');
        return $aff;
    }
    public function update_read_log($weiixn_id,$mobile_id,$parent_id){
        $this->db->set('customer_id',$mobile_id);
        $this->db->where('customer_id',$weiixn_id);
        $this->db->where('parent_id',$parent_id);
        $aff =  $this->db->update('shop_read');
        return $aff;
    }
    //--------------------------------------------
    
    /**
     * 我的收入---feng
     * @param int $customer_id 用户id
     * @param string $created_at 今天开始时间
     * @param string $ent_at 今天结束时间
     */
    public function my_income($customer_id,$created_at=NULL,$ent_at=NULL){

        $where = "";
        if($created_at && $ent_at){
            $where = "and create_date>='$created_at' and create_date<='$ent_at'";
        }
        
        $query = $this->db->query("select sum(total) as total from
            (select rebate_1 as total from 9thleaf_order_rebate
            where rebate_1_id = '$customer_id' $where
            union all
            select rebate_2 as total from 9thleaf_order_rebate
            where rebate_2_id = '$customer_id' $where
            union all
            select rebate_3 as total from 9thleaf_order_rebate
            where rebate_3_id = '$customer_id' $where) as a ");
        return $query->row_array();
        

    }
    
    //--------------------------------------------
    

   

    /**
     * 下线分享统计
     * @param int $customer_id 用户id
     * @param string $start_at 开始时间
     * @param string $ent_at 结束时间
     */
    public function share_total($customer_id,$start_at=NULL,$ent_at=NULL,$limit=NULL,$offset=NULL){
        $where1 = '';
        $where2 = '';
        if($start_at && $ent_at){
            $where1 = " where created_at >= '$start_at' and created_at <= '$ent_at'";
            $where2 = " and b.read_at >= '$start_at' and b.read_at <= '$ent_at'";
        }
   
        
        $query = $this->db->query("
            select c.customer_id ,sum(c.a_id) as share_total,sum(c.b_id) as read_total,d.name,d.wechat_nickname,d.nick_name,d.wechat_avatar,d.mobile, d.is_active as status ,any_value(e.id) as is_vip from (
            select a.customer_id,count(distinct(a.id)) as a_id,count(b.id) as b_id from (select * from 9thleaf_shop_share $where1) as a 
            left join 9thleaf_shop_read as b on b.parent_id = a.customer_id and b.share_at = a.created_at $where2
            where a.parent_id = '$customer_id'
            group by a.customer_id,b.parent_id ) as c 
            join 9thleaf_customer as d on d.id = c.customer_id
            left join 9thleaf_customer_shop as e on c.customer_id = e.customer_id and e.status = 1
            group by c.customer_id order by read_total desc limit $offset,$limit");
        
        return $query->result_array(); 
    }
    
    
    
    //--------------------------------------------
    

    /**
     * 添加互助店商品
     */
    
    function add_product($data){
        $datetime = date('Y-m-d H:i:s');
        $data['add_at'] = $datetime;
        $this->db->insert('shop_product',$data);
        return $this->db->insert_id();
    }
    
    /**
     * 检查互助店是否有该商品
     * @param unknown $shop_id
     * @param unknown $product_id
     */
    function check_product($shop_id,$product_id){
        $this->db->select('*');
        $this->db->from("shop_product");
        $this->db->where("shop_id",$shop_id);
        $this->db->where("product_id",$product_id);
        $query = $this->db->get()->row_array();
        return $query;
    }
    /**
     * 检查互助店是否有该商品
     * @param unknown $shop_id
     * @param unknown $communal_id
     */
    function check_product_ById($shop_id,$communal_id){
        $this->db->select('*');
        $this->db->from("shop_product");
        $this->db->where("shop_id",$shop_id);
        $this->db->where("product_id",$communal_id);
        $query = $this->db->get()->row_array();
        return $query;
    }
   
    /**
     * 编辑商品排序/发布/下架/删除
     */
    
    function update_product($data){
        $aff = $this->db->update_batch('shop_product',$data,'id');
        return  $aff;
    }
    
    function del_product($id){
        $this->db->where('id',$id);
        $aff = $this->db->delete('shop_product');
        return  $aff;
    }

    /**
     * 分享排行榜统计
     * @param string $start_at 开始时间
     * @param string $ent_at 结束时间
     * @param int $limit  
     * @param int $offset  
     */
    public function share_list($start_at=NULL,$ent_at=NULL,$limit,$offset){

        $where1 = "";
        $where2 = "";
        if($start_at && $ent_at){
            $where1 = "and `b`.`created_at` >= '$start_at' AND `b`.`created_at` <= '$ent_at'" ; 
            $where2 = "and `c`.`read_at` >= '$start_at' AND `c`.`read_at` <= '$ent_at'" ;
        }
        $query = $this->db->query("
            select * from 
            (select  a.*,@rank:=@rank+1 as ranking from (
            SELECT `a`.`id`, `a`.`name`, `a`.`nick_name`, `a`.`wechat_nickname`, count(distinct(b.id)) as share_total, count(distinct(c.id)) as read_total
            FROM `9thleaf_customer` as `a`
            LEFT JOIN `9thleaf_shop_share` as `b` ON `a`.`id`= `b`.`customer_id` $where1
            LEFT JOIN `9thleaf_shop_read` as `c` ON `a`.`id`= `c`.`customer_id` $where2
            GROUP BY `a`.`id`
            ORDER BY `read_total` desc) as a,(SELECT @rank:=0) b) as d where read_total>0 limit $offset,$limit
            ");
        return $query->result_array();
    }
    
    //--------------------------------------------
    
    /**
     * 分享自身排行榜
     * @param int $customer_id 用户id
     * @param string $start_at 开始时间
     * @param string $ent_at 结束时间
     */
    public function my_share($customer_id,$start_at=NULL,$ent_at=NULL){
        $where1 = "";
        $where2 = "";
        if($start_at && $ent_at){
            $where1 = "and `b`.`created_at` >= '$start_at' AND `b`.`created_at` <= '$ent_at'" ; 
            $where2 = "and `c`.`read_at` >= '$start_at' AND `c`.`read_at` <= '$ent_at'" ;
        }
        $query = $this->db->query("
            select * from (
            select  a.*,@rank:=@rank+1 as ranking from (
            SELECT `a`.`id`, `a`.`name`, `a`.`nick_name`, `a`.`wechat_nickname`, count(distinct(b.id)) as share_total, count(distinct(c.id)) as read_total
            FROM `9thleaf_customer` as `a`
            LEFT JOIN `9thleaf_shop_share` as `b` ON `a`.`id`= `b`.`customer_id` $where1
            LEFT JOIN `9thleaf_shop_read` as `c` ON `a`.`id`= `c`.`customer_id` $where2
            GROUP BY `a`.`id`
            ORDER BY `read_total` desc) as a,(SELECT @rank:=0) b
            ) as c where id = '$customer_id'
            ");
        return $query->row_array();
    }
    
    //------------------------------------------------
    

    
    /**
     * 推广统计
     * @param int $customer_id 用户id
     * @param number $status 1已读2已注册3已消费4店主
     * @param number $type 
     * @param string $limit
     * @param string $offset
     */
    public function spread($customer_id,$status=0,$type=0,$limit=NULL,$offset=NULL){
        $this->db->select("distinct(a.customer_id),b.name,b.wechat_avatar,b.wechat_nickname,b.mobile");
        $this->db->from("shop_read as a");
        $this->db->join("customer as b","a.customer_id = b.id");
       
        switch($status){
        case 1://已读
            break;
        case 2://已注册
            $this->db->where("b.mobile !=",null);
            $this->db->where("b.mobile !=","");
            break;
        case 3://已消费
            $this->db->where("b.is_active",1);
            break;
        case 4://店主
            $this->db->join("customer_shop as c","c.customer_id = a.customer_id");
            $this->db->where("c.status",1);
            break;
        }
        $this->db->where("a.parent_id",$customer_id);
//         $this->db->group_by("a.customer_id");
        if(!$type){
            $this->db->limit($limit,$offset);
        }
        
        $query = $this->db->get();
        if($type){
            return $query->num_rows();
        }else{
            return $query->result_array();
        }
    }
    
    
    

}