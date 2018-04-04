<?php
/**
 *
 * 店铺分店
 *
 */
class Corporation_branch_mdl extends CI_Model {
    var $corporation_id;
    var $branch_name;
    var $owner_id;
    var $code_url;
    var $address;
    var $is_host;
    var $created_at;
    var $updated_at;
    var $id;
    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct ();
    }
    
    
    /**
     * 查询总店
     * 根据店铺id查询店铺信息
     * @param int $corp_id 店铺id
     */
    public function load_corp_info($corp_id){
        if (! $corp_id) {
            return array ();
        }
        $query = $this->db->get_where("customer_corporation",array(
            "id" => $corp_id
        ));
    
        if( $row = $query->row_array()){
            return $row;
        }
    
        return array ();
    }
    
    /**
     * 查询分店列表
     *  @param int $corp_id 店铺id
     */
    public function get_corp_branch($corp_id,$limit = 0, $offset = 0){
        if (! $corp_id) {
            return array ();
        }
       
        $this->db->select("DISTINCT(a.id),a.*,c.mobile ");
        $this->db->from("corporation_branch as a");
        $this->db->join("customer as c","a.owner_id = c.id");
        $this->db->join("customer_corporation as b","a.corporation_id = $corp_id");
        $this->db->where("a.corporation_id",$corp_id);
        //判断总店状态
        $this->db->where("b.status",1);
        $this->db->where("b.approval_status",2);
       
        if($offset){
            $this->db->limit($limit,$offset);
        }else{
            $this->db->limit($limit);
        }

        $this->db->order_by("a.is_host,a.id","DESC");
        $query = $this->db->get()->result_array();
        return $query;
    }
    /**
     * 查询用户分店列表
     * user_id branch_id
     */ 
    public function get_user_branch($user_id,$branch_id = 0){
        $this->db->select("cb.*");
        $this->db->from('corporation_branch as cb');
        $this->db->where("owner_id",$user_id);
        if($branch_id){
            $this->db->where("cb.id",$branch_id);
        }
        $this->db->join("customer_corporation as b","b.id = cb.corporation_id");
        //判断总店状态
        $this->db->where("b.status",1);
        $this->db->where("b.approval_status",2);
//         $this->db->get();
//         echo $this->db->last_query();exit;
        if($branch_id){
            $query = $this->db->get()->row_array();
        }else{
            $query = $this->db->get()->result_array();
        }
        return $query;
        
    }
  
    /**
     * 查询分店详情
     * $type  false查询分店  true检查是否存在总店 
     */
    public function get_branch_detail($id,$corp_id = 0,$type = 0){
        if($type){
            $this->db->where("is_host",1);
            $this->db->where("corporation_id",$corp_id);
            $this->db->from("corporation_branch");
        }else{
            if($corp_id){
                $this->db->where("b.corporation_id",$corp_id);
            }
            $this->db->select("b.*,c.mobile");
            $this->db->where("b.id",$id);
            $this->db->from("corporation_branch as b");
            $this->db->join("customer as c","b.owner_id = c.id");
        }
        
        $query = $this->db->get()->row_array();
        return $query;
    }
    
    public function edit_branch(){
        if($this->corporation_id)
            $this->db->set('corporation_id',$this->corporation_id);
        if($this->branch_name)
            $this->db->set('branch_name',$this->branch_name);
        if($this->owner_id)
            $this->db->set('owner_id',$this->owner_id);
        if($this->code_url)
            $this->db->set('code_url',$this->code_url);
        if($this->owner_name)
            $this->db->set('owner_name',$this->owner_name);
        if($this->address)
            $this->db->set('address',$this->address);
        if($this->is_host)
            $this->db->set('is_host',$this->is_host);
        if(!$this->id){//新增
            $this->db->insert("corporation_branch");
            return $this->db->insert_id();
        }else{//编辑
            $this->db->where('id',$this->id);
            $aff = $this->db->update('corporation_branch');
            return $aff;
        }
      
    }
    /**
     * 获取分享销售总额
     * @param branch_id
     */
    
    public function branch_saleroom($branch_id){
        $this->db->select("sum(total_price) as order_total_price");
        $this->db->where("corporation_branch_id",$branch_id);
        $this->db->where_in("status",array(7,9,14));
        $this->db->from("order");
        $query = $this->db->get()->row_array();
        return $query;
    }
    
    /**
     * 查询销售报表
     * $option =>  branch_id 分店ID grant_start_at  grant_end_at  交易时间段
     */
    public function get_branch_order($corporation_id = 0,$option = array(),$limit = 0, $offset = 0){
        $this->db->from("corporation_branch as b");
        $this->db->join("order as o","o.corporation_branch_id = b.id","left");
        if(isset($option['list_type']) && $option['list_type']){//H5加载订单列表
            $this->db->select("o.order_sn,o.pay_time,o.total_price,o.order_type,c.name,c.nick_name,b.branch_name,card.savings_card_name");
            $this->db->join("savings_card_consumption as card","o.id = card.order_id","left");
        }else{//报表查询参数，与导出excel参数对应  不能随便修改
            $this->db->select("o.pay_time,o.total_price,c.name,c.nick_name,b.branch_name");
        }
       
        $this->db->join("customer as c","c.id = o.customer_id","left");
        if($corporation_id){
            $this->db->where("b.corporation_id",$corporation_id);
        }
        if(isset($option['branch_id']) && $option['branch_id']){
            $this->db->where("b.id",$option['branch_id']);
        }
        
        if(isset($option['type']) && $option['type']){
            switch($option['type']){
                case 'all':
                    break;
                case 'credit':
                    $this->db->where("o.order_type",1);
                    break;
                case 'card';
                    $this->db->where("o.order_type !=",1);
                    break;
                default:
                    break;                
            }
        }
        if(isset($option['grant_start_at']) && $option['grant_start_at'] &&  isset($option['grant_end_at']) && $option['grant_end_at']){
            if($option['grant_start_at'] == $option['grant_end_at']){
                $day = $option['grant_start_at'];
                $this->db->where("o.pay_time >= ",$option['grant_start_at']);
                $this->db->where("o.pay_time <",date("Y-m-d",strtotime("$day +1 day")));
            }else{
                $day = $option['grant_end_at'];
                $this->db->where("o.pay_time >=",$option['grant_start_at']);
                $this->db->where("o.pay_time <",date("Y-m-d",strtotime("$day +1 day")));
            }
           
        }
        $this->db->where_in("o.status",array(7,9,14));
        if($offset){
            $this->db->limit($limit,$offset);
        }else{
            $this->db->limit($limit);
        }
        $this->db->order_by("o.pay_time","DESC");
//         $query = $this->db->get();
//         echo '<pre>';
//         echo $this->db->last_query();exit;
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    /**
     * 删除分店
     * @param int id 分店ID
     * @param int id 企业ID
     */
    public function del_branch($id,$corporation_id){
        $this->db->where("id",$id);
        $this->db->where("corporation_id",$corporation_id);
        $this->db->delete("corporation_branch");
        return $this->db->affected_rows();
    }
    
    /**
     * 查询企业信息-分店信息。
     */
    
    public function Corp_Branch_Detaile( $sift = array() ) 
    {
        if( empty($sift['where']['id']) )
            return array();
        
        $this->db->select('cc.customer_id as corp_customer_id, cc.id as corp_id,cc.corporation_name,cc.img_url,cb.id');
        $this->db->from('customer_corporation as cc');
        $this->db->join('corporation_branch as cb','cb.corporation_id = cc.id');
        $this->db->where('cb.id',$sift['where']['id']);
        $query = $this->db->get();
        return $query->row_array();
    }
}