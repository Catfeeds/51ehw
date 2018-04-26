<?php
/**
 *
 * 部落模型
 *
 */

class  Tribe_mdl extends CI_Model {
    
    
    function __construct() {
        parent::__construct ();
    }
    
    
    
    /**
     * 根据用户ID，获取义工委权限
     * @param number $user_id 用户id
     * @param int tribe_id 部落id
     */
    public function get_MyTribe($user_id,$tribe_id = 0){
        $this->db->select("t.*");
        $this->db->from("tribe_staff as ts");
        $this->db->join("tribe as t","ts.tribe_id = t.id");
        $this->db->where("ts.customer_id",$user_id);
        $this->db->where("ts.is_host",1);//义工委
        
        if($tribe_id){
            $this->db->where_in("t.id",$tribe_id);//某个部落
            return $this->db->get()->row_array();
        }
        return $this->db->get()->result_array();
        
    }
    
    
    /**
     *获取管理员列表
     * @param unknown $id  部落ID
     * @param number $limit
     * @param number $offset
     */
    public function get_ManagerList($id,$manager_id = 0,$limit = 0 ,$offset = 0){
        $this->db->select("ts.*");
        $this->db->where("ts.tribe_id",$id);
        $this->db->from("tribe_staff as ts");
        $this->db->where("ts.is_host",0);//不是义工委
        $this->db->where("ts.tribe_manager_id",$manager_id);//管理
        $this->db->where("ts.customer_id !=",NULL);//状态
        $this->db->where("ts.status",2);//状态
        $this->db->order_by('ts.created_at','ASC');
        
        if($offset){
            $this->db->limit($limit,$offset);
        }else if($limit){
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }
    
    
    /**
     * 查询部落列表
     * $keyword 关键词
     * $time  时间
     * $status 状态
     * $order 排序
     */
    public function Tribe_list($keyword = 0 ,$time_str = '', $status = 0 , $limit = 0, $offset = 0,$type = ''){
        $keyword_str = '';
        $stauts_str = '';
        
        if($keyword){
            if(!$time_str){
                $keyword_str = "where a.name like '%$keyword%' ";//模糊搜索部落ID 部落名称
            }else{
                $keyword_str = "and ( a.name like '%$keyword%') ";//模糊搜索部落ID 部落名称
            }
            
        }
        $tribe_id = $this->session->userdata("tribe_id");
        
        $keyword_str = "where b.id = $tribe_id";
        if($status){//1待审核2通过3不通过
            if($keyword || $time_str){
                $stauts_str = "and  a.status = $status ";
            }else{
                $stauts_str = "where a.status = $status ";
            }
        }
        $limitstr = '';
        if($offset){
            $limitstr = "limit $offset,$limit" ;
        }else{
            
            $limitstr = "limit ".$limit ;
        }
        
        if($type != 'list'){//获取总数量
            $query = $this->db->query("
                select b.name,b.provice,b.city,b.industry,b.status,b.created_at,count(cc.id) as corp_total,count(b.ts_id) as all_total from (
                select a.*, ts.customer_id as ts_customer_id, ts.id as ts_id from 9thleaf_tribe as a
                join 9thleaf_tribe_staff ts on ts.tribe_id = a.id
                ) as b left join 9thleaf_customer_corporation as cc on cc.customer_id = b.ts_customer_id $keyword_str group by b.id
                ");
            //         select a.* ,count(ts.grade = 1) as gener_total,count(ts.grade = 2) as corp_total from 9thleaf_tribe as a left join 9thleaf_tribe_staff ts on ts.tribe_id = a.id $time_str $keyword_str $stauts_str  group by a.id
        }else{
            
            $this->db->query("set sql_mode ='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
                ");
            $query = $this->db->query("
                select b.name,b.m_name,b.m_id,b.is_host,b.module_id,b.provice,b.city,b.industry,b.status,b.staff_status,b.created_at,count(cc.id) as corp_total,count(b.ts_id) as all_total,any_value(b.mobile) as mobile,b.logo ,b.bg_img ,b.content, b.content_img,b.shop_img,b.customer_id as created_customer from (
                select a.*, ts.customer_id as ts_customer_id,ts.is_host, ts.id as ts_id,ts.mobile,tm.id as m_id, tm.name as m_name,tm.module_id from 9thleaf_tribe as a
                left join 9thleaf_tribe_staff ts on ts.tribe_id = a.id
                left join  9thleaf_tribe_manager tm on tm.id = ts.tribe_manager_id where ts.is_host=1
                ) as b left join 9thleaf_customer_corporation as cc on cc.customer_id = b.ts_customer_id $keyword_str group by b.id
                ");
            //              select a.* ,count(ts.grade = 1) as gener_total,count(ts.grade = 2) as corp_total from 9thleaf_tribe as a left join 9thleaf_tribe_staff ts on ts.tribe_id = a.id $time_str $keyword_str $stauts_str  group by a.id
            //              ORDER BY created_at DESC $limitstr
        }
        
        return $query->result_array();
    }
    
    
    
    /**
     * 获取部落商品
     * @param int $tribe_id 部落id
     * @param string $keyword 搜索关键词
     * @param string $time_str 时间条件
     * @param int $product_id 商品id
     * @param int $status 状态1上架2下架
     */
    public function Tribe_product_list($tribe_id,$keyword = null ,$time_str = null, $product_id = null,$status = '' ,$limit = 0, $offset = 0){
        // $this->db->select("d.id as product_id,d.name,d.vip_price,d.tribe_price,f.name as cat_name,c.corporation_name,e.id,e.status,e.sort,d.on_sale_at");
        $this->db->select("d.id as product_id,d.name,d.vip_price,d.tribe_price,f.name as cat_name,c.corporation_name,e.id,d.is_on_sale as status,e.sort,d.on_sale_at");
        $this->db->from("tribe as a");
        $this->db->join("tribe_staff as b","a.id = b.tribe_id");
        $this->db->join("customer_corporation as c","c.customer_id = b.customer_id");
        $this->db->join("product as d","d.corporation_id = c.id");
        $this->db->join("product_tribe as e","e.product_id = d.id and e.tribe_id = $tribe_id");
        $this->db->join("product_cat as f","f.id = d.cat_id");
        if($time_str){
            $this->db->where("$time_str");
        }
        if($keyword){
            $keyword = $this->db->escape_like_str($keyword);
            $this->db->where("(d.name like '%{$keyword}%' or c.corporation_name like '%{$keyword}%') ");
        }
        /*if($status){
         $this->db->where("e.status",$status);
         }*/
        if(is_numeric($status)){
            $this->db->where('d.is_on_sale',$status);
        }
        if($product_id){
            $this->db->where("d.id",$product_id);
        }
        $this->db->where("a.id",$tribe_id);
        $this->db->where("a.status",2);
        $this->db->where("b.status",2);
        $this->db->where("c.approval_status",2);
        $this->db->where("c.status",1);
        $this->db->where("d.is_mc",0);
        $this->db->where("d.is_delete",0);
        // $this->db->where("d.is_on_sale",1);
        $this->db->order_by("d.id","desc");
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
     * 编辑商品上下架
     * @param int $id  9thleaf_product_tribe表id
     * @param int $tribe_id 部落id
     * @param int $type 状态1上架2下架
     */
    public function edit_product($id,$tribe_id,$type){
        $query = $this->db->query("update 9thleaf_product_tribe as a join 9thleaf_product as b on a.product_id = b.id set a.status = {$type} where a.id = {$id} and find_in_set({$tribe_id},a.tribe_id)");
        return $this->db->affected_rows();
    }
    
    /**
     * 排序商品
     */
    public function sort_product($id,$sort){
        //      $date = date('Y-m-d H:i:s');// 当前时间
        //      $this->db->set("update_at",$date);
        $this->db->set("sort",$sort);
        $this->db->where("id",$id);
        $affect = $this->db->update('product_tribe');
        return $affect;
    }
    
    
    
    /**
     * 检查申请部落
     */
    public function  check_My_apply($tribe_id,$customer_id){
        $this->db->select("a.staff_status,a.id,a.content_img,a.name,a.logo,a.bg_img,b.id as tribe_staff_id,b.status,b.member_name,b.corporation_name,b.mobile,b.bg_img as ts_bg_img,b.tribe_role_id,a.shop_img");
        $this->db->from("tribe as a");
        $this->db->join("tribe_staff as b","a.id=b.tribe_id and b.customer_id='$customer_id'","left");
        $this->db->where("a.id",$tribe_id);
        return $this->db->get()->row_array();
    }
    
    /**
     * 获取部落下的所有成员(待审核,通过,不通过)
     * $id 部落ID
     */
    public function tribe_member_list($id,$keyword = '',$time_str = '',$status ='',$userid ='',$mobile ='',$reg_status='',$limit = 0, $offset = 0,$type = '',$non_members_id = array()){
        if( empty( $id ) )
            return array();
            $this->db->select("ts.*,t.name as tribe_name,c.id as user_id,c.brief_avatar,c.wechat_avatar,c.name,c.real_name,tr.role_name,c.mobile as customer_mobile,cc.id as crop_id,c.credit_ceiling,cc.corporation_name as corp_name");
            
            $this->db->from("tribe_staff as ts");
            $this->db->where("ts.tribe_id",$id);
            $this->db->join("tribe as t","t.id = ts.tribe_id ");
            $this->db->join("tribe_role as tr","ts.tribe_role_id = tr.id","left");
            $this->db->join("customer as c","c.id = ts.customer_id ","left");//必须用mobile关联
            $this->db->join("customer_corporation as cc","cc.customer_id = ts.customer_id","left");
            $this->db->where("ts.status !=",4);//把逻辑删除的成员排除
            
            
            if($userid || $mobile){//精确搜索
                if($userid){//如果存在同时搜索用户ID和手机号码 则优先搜索用户ID
                    $this->db->where("ts.customer_id",$userid);
                }else{
                    $this->db->where("ts.mobile",$mobile);
                }
            }else{
                if($keyword){
                    $this->db->where("(cc.corporation_name like '%$keyword%' or ts.member_name like '%$keyword%' or c.real_name like '%$keyword%') ");//部落名称，公司名称，部落成员名称
                }
                
                if($time_str){
                    $this->db->where("$time_str");
                }
                
                switch($status){
                    case '未审核';
                    $this->db->where("ts.status",1);
                    break;
                    case '审核通过':
                        $this->db->where("ts.status",2);
                        break;
                    case '审核不通过':
                        $this->db->where("ts.status",3);
                        break;
                }
                
                switch($reg_status){
                    case '已注册';
                    $this->db->where("ts.customer_id !=",NULL);
                    break;
                    case '未注册':
                        $this->db->where("ts.customer_id",NULL);
                        break;
                }
                
            }
            if($non_members_id){
                $this->db->where_not_in("ts.customer_id",$non_members_id);
            }
            $this->db->order_by("update_at","desc");
            $this->db->order_by("id","desc");
            
            if($type != 'list'){//获取总数量
                $rows = $this->db->count_all_results();
                return $rows;
            }else{
                if($offset){
                    $this->db->limit($limit, $offset);
                }else{
                    $this->db->limit($limit);
                }
                $query = $this->db->get()->result_array();
                
                return $query;
            }
    }
    
    /**
     * 查询加入部落未审核的总人数
     */
    function count_unaudited_tribe($customer_id)
    {
        $info = array_column($this->ManagementTribe_apply($customer_id),'id');
        if( !$info )
            return 0;
            
            $this->db->select("COUNT(ts.id) as total");
            $this->db->from("tribe_staff as ts");
            $this->db->join("tribe as t","t.id = ts.tribe_id");
            $this->db->where_in("ts.tribe_id",$info);
            $this->db->where("ts.status",1);
            $this->db->where("t.status",2);
            $query = $this->db->get();
            $total = 0;
            
            if ($row = $query->row_array()) {
                $total = (int) $row['total'];
            }
            return $total;
    }
    
    /**
     * 查询一个部落加入未审核的人数
     */
    function count_unaudited_tribe_num($tribe_id)
    {
        $this->db->select('COUNT(id) as total');
        $this->db->from("tribe_staff");
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("status",1);
        $query = $this->db->get();
        $total = 0;
        
        if ($row = $query->row_array()) {
            $total = (int) $row['total'];
        }
        return $total;
    }
    
    
    /**
     * 查询一个部落加入未审核的人数
     */
    function count_unaudited_tribe_list_num($tribe_id)
    {
        $this->db->select('tribe_id,COUNT(tribe_id) as total');
        $this->db->from("tribe_staff");
        $this->db->where_in("tribe_id",$tribe_id);
        $this->db->where("status",1);
        $this->db->group_by('tribe_id');
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }
    
    
    /**
     * 获取部落角色
     * $tribe_id
     */
    public function get_tribe_role($tribe_id){
        $this->db->select("*");
        $this->db->where("tribe_id",$tribe_id);
        $this->db->from("tribe_role");
        $this->db->order_by("sort");
        $query = $this->db->get()->result_array();
        
        return $query;
    }
    public function check_mobile($mobile,$tribe_id,$type = 0){
        $this->db->select('*');
        $this->db->from("tribe_staff");
        $this->db->where("mobile",$mobile);
        if($type){//已删除的
            $this->db->where("status !=",4);
        }
        $this->db->where("tribe_id",$tribe_id);
        $quer = $this->db->get()->row_array();
        return $quer;
    }
    
    
    //部落成员预录入用户个人主页用到
    /**
     * 获取预录入用户信息
     * @param number $staff_id
     * @return unknown
     */
    public  function load_by_staff_id($staff_id = 0){
        if(!$staff_id){
            echo false;
        }
        $this->db->select('*');
        $this->db->from("tribe_staff");
        $this->db->where("id",$staff_id);
        $quer = $this->db->get()->row_array();
        return $quer;
    }
    
    /**
     * 获取预录入用户预录入的身份信息
     * @param unknown $mobile  预录入的手机
     */
    public  function  load_staff_idenity($mobile){
        if(!$mobile){
            echo false;
        }
        $this->db->from("tribe_staff_identity");
        $this->db->where("mobile",$mobile);
        $query = $this->db->get()->result_array();
        return $query;
        
    }
    /**
     * 删除预录入的身份信息
     */
    public function del_staff_idenity($id){
        $this->db->where("id",$id);
        $this->db->delete("tribe_staff_identity");
        return $this->db->affected_rows();
    }
    
    
    /**
     * 获取部员信息
     * $id 部落用户
     */
    function get_tribe_customet_info($id){
        $this->db->select('*');
        $this->db->from("tribe_staff");
        $this->db->where("id",$id);
        $quer = $this->db->get()->row_array();
        return $quer;
    }
    /**
     * 根据用户id查询用户的部落
     * @param int $customer_id 用户id
     * @param int $sort  排序
     */
    public function MyTribe($customer_id,$sort = 0, $tribe_ids = array() ){
        if(!$customer_id){
            return array();
        }
        $this->db->select("a.id,a.name,a.content,a.logo,count(c.id) as total");
        $this->db->from("tribe as a");
        $this->db->join("tribe_staff as b","a.id=b.tribe_id");
        $this->db->join("tribe_staff as c","a.id=c.tribe_id");
        $this->db->where("a.status","2");
        $this->db->where("b.status","2");
        $this->db->where("b.customer_id <>", null);
        $this->db->where("c.customer_id <>", null);
        $this->db->where("c.status","2");
        
        if( $tribe_ids )
        {
            $this->db->where_in('a.id',$tribe_ids);
        }
        
        if(!$sort){
            $this->db->where("b.customer_id",$customer_id);
            //部落的活跃度
            $this->db->order_by("a.liveness","desc");
        }else{
            $this->db->select("any_value(ss.sort) as sort,any_value(ss.sort_at) as sort_at,any_value(ss.updated_at) as updated_at,any_value(c.created_at) as created_at");
            //用户对应部落的活跃度以及用户对部落是否置顶排序
            $this->db->join("tribe_staff_sort as ss","a.id=ss.tribe_id AND ss.customer_id = $customer_id","LEFT");
            $this->db->where("c.customer_id",$customer_id);
            //优先排序用户置顶  置顶间的时间  最新浏览记录的时间  最新加入的部落
            $this->db->order_by("sort,sort_at,updated_at,created_at","desc");
            $this->db->group_by("ss.id");
            
        }
        $this->db->group_by("a.id");
        return $this->db->get()->result_array();
    }
    
    //--------------------------------------------------------------
    
    /**
     * 根据部落id查询部落
     * @param int $id 部落id
     * @param int $customer_id 用户id
     * @parma int $status
     */
    public function load($id,$customer_id){
        $this->db->select("a.id,b.is_host,a.content_img,a.name,a.logo,a.bg_img,b.id as tribe_staff_id,b.status,b.mobile,b.member_name,b.corporation_name,b.mobile,b.show_mobile,b.bg_img as ts_bg_img,b.tribe_role_id,a.shop_img,b.tribe_manager_id,c.real_name,cc.corporation_name as real_corp_name");
        $this->db->from("tribe as a");
        $this->db->join("tribe_staff as b","a.id=b.tribe_id and b.customer_id='$customer_id'","left");
        $this->db->join("customer as c","c.id=b.customer_id and b.customer_id='$customer_id'","left");
        $this->db->join("customer_corporation as cc","cc.customer_id=b.customer_id","left");
        $this->db->where("a.id",$id);
        $this->db->where("a.status","2");
        return $this->db->get()->row_array();
    }
    
    
    //--------------------------------------------------------------
    /**
     * 获取部落信息
     * @param str/array $ids
     * @param  $
     * @param str $keyword  搜索内容
     */
    public function get_tribe_list( $ids,$keyword=0,$limit=0,$offset=0){
        
        $this->db->select("id,name,logo,content");
        $this->db->from("tribe");
        $this->db->where("status",2);//审核通过的
        if( is_array( $ids ) )
        {
            $this->db->where_in("id",$ids);
        }
        
        if($keyword){
            $this->db->like("name",$keyword);
        }
        if($offset){
            $this->db->limit($limit,$offset);
        }else if($limit){
            $this->db->limit($limit);
        }
        
        if( is_array( $ids ) )
        {
            $id_str = implode(",",$ids);
            $this->db->order_by("field(id,{$id_str})");
        }
        
        $query = $this->db->get()->result_array();
        
        return $query;
        
        
    }
    
    /**
     * 查出商会加入的部落与用户加入的部落之间的交集
     * @param array $app_tribe_ids   商会加入的部落
     */
    public function identical_tribe($app_tribe_ids){
        $user_id = $this->session->userdata("user_id");//用户id
        $this->db->select("t.id,t.name,t.logo,t.content");
        $this->db->from("tribe as t");
        $this->db->join("tribe_staff as ts","ts.tribe_id = t.id");
        $this->db->select("any_value(ss.sort) as sort,any_value(ss.sort_at) as sort_at,any_value(ss.updated_at) as updated_at,any_value(ts.created_at) as created_at");
        //用户对应部落的活跃度以及用户对部落是否置顶排序
        $this->db->join("tribe_staff_sort as ss","t.id=ss.tribe_id AND ss.customer_id = $user_id","left");
        $this->db->where("ts.status",2);
        $this->db->where("t.status",2);
        $this->db->where("ts.customer_id",$user_id);
        $this->db->where_in("ts.tribe_id",$app_tribe_ids);
        
        //优先排序用户置顶  置顶间的时间  最新浏览记录的时间  最新加入的部落
        $this->db->order_by("sort,sort_at,updated_at,created_at","desc");
        //         $this->db->group_by("ss.id");
        return $this->db->get()->result_array();
    }
    
    
    /**
     *
     * 获取部落信息
     * @param id
     */
    
    public function  get_tribe( $id = 0 )
    {
        
        $this->db->where_in("id",$id);
        
        $this->db->from("tribe");
        
        if( is_array( $id ) )
        {
            return $this->db->get()->result_array();
        }else{
            return $this->db->get()->row_array();
        }
        
    }
    /**
     * 获取货包绑定的部落信息
     * @param string $tribe_ids 部落id
     */
    public function get_share_package_tribe($tribe_id){
        $this->db->from('tribe');
        $this->db->where("id",$tribe_id);
        return  $this->db->get()->row_array();
    }
    //--------------------------------------------------------------
    
    /**
     * 查询未加入的推荐部落
     * 产品荣哥要求不显示31，37，40的部落
     */
    public function hot_tribe( $customer_id = 0)
    {
        $query = $this->db->query('
            
            select t.* from 9thleaf_tribe as t where t.id not in
            (select t.id from 9thleaf_tribe as t  join 9thleaf_tribe_staff as ts on t.id = ts.tribe_id where ts.customer_id = '.$customer_id.' group by t.id)
             and t.id not in(31,37,40) and t.status = 2  order by t.liveness desc ');
        
        return $query->result_array();
    }
    
    //--------------------------------------------------------------
    
    /**
     * 根据部落id查询最新商品
     * @param int $id 部落id
     * @param int $appid 分站点is_new
     */
    public function hot_goods($id,$appid){
        $this->db->select("b.id,b.vip_price,b.name,b.goods_thumb,b.tribe_price");
        $this->db->from("product_tribe as a");
        $this->db->join("product as b","a.product_id = b.id");
        $this->db->where("a.status",1);
        $this->db->where("a.tribe_id",$id);
        $this->db->where("b.is_on_sale",1);
        $this->db->where("b.is_mc",0);
        $this->db->where("b.is_new",1);
        $this->db->where("b.is_delete",0);
        if($appid){
            $this->db->where_in('b.app_id',array(0,$appid));
        }
        $this->db->order_by("sort");
        $this->db->limit(10);
        return $this->db->get()->result_array();
    }
    
    
    /**
     * 根据用户ID-部落ID-查询部落成员列表
     * 注：如果customer不存在则不满足查询条件（未注册的不再结果之中）
     * @is_corp = true; 条件是企业用户
     */
    public function tribe_customer_info( $id, $is_corp = false )
    {
        if( empty( $id ) )
            return array();
            
            $date = date('Y-m-d');
            $this->db->select('t.id as t_id,t.name as tr_name,ts.member_name, ts.corporation_name,ts.customer_id,tr.role_name,ts.guarantee_ceiling,
             ts.guarantee_from_ceiling,sum(gd.guarantee_money) as total_guarantee_money,ts.logo
                
                
            ');
            $this->db->from('tribe as t');
            $this->db->join('tribe_staff as ts','t.id = ts.tribe_id','left');
            $this->db->join('tribe_role as tr','ts.tribe_role_id = tr.id','left');
            if( $is_corp ){
                $this->db->join('customer_corporation as cc','ts.customer_id = cc.customer_id');
                $this->db->where('cc.status',1);
                $this->db->where('cc.approval_status',2);
            }
            $this->db->join("guarantee as g","g.tribe_id = t.id and g.is_effective = 1 and g.end_time >= '{$date}' ",'left');
            $this->db->join('guarantee_detail as gd','gd.customer_id = ts.customer_id and g.id = gd.guarantee_id','left');
            $this->db->where('t.id',$id);
            $this->db->where('t.status',2);
            $this->db->where('ts.status',2);
            $this->db->group_by('ts.id');
            $query = $this->db->get();
            return $query->result_array();
    }
    
    
    /**
     * 根据用户ID-部落ID-验证是否存在
     */
    public function is_tribe_customer( $id, $customer_id )
    {
        if( empty( $id ) || empty( $customer_id ) )
            return array();
            
            $this->db->select('t.id,ts.guarantee_to_ceiling,t.name,t.logo');
            $this->db->from('tribe as t');
            $this->db->join('tribe_staff as ts','t.id = ts.tribe_id','left');
            $this->db->where('t.id',$id);
            $this->db->where('ts.customer_id',$customer_id);
            $this->db->where('t.status',2);
            $this->db->where('ts.status',2);
            $query = $this->db->get();
            return $query->row_array();
    }
    
    
    /**
     * 查询部落成员已经担保成功出去多少金额
     */
    public function member_guarantee( $customer_id_array, $tribe_id)
    {
        $date = date('Y-m-d');
        $this->db->select('ts.*,sum(gd.guarantee_money) as total_guarantee_money');
        $this->db->from('tribe_staff as ts');
        $this->db->join("guarantee as g","g.tribe_id = ts.tribe_id AND g.is_effective = 1 AND g.end_time >= '{$date}' ",'left');
        $this->db->join('guarantee_detail as gd','gd.`customer_id` = ts.customer_id and g.id = gd.guarantee_id ','left');
        $this->db->where_in('ts.customer_id',$customer_id_array);
        $this->db->where('ts.status',2);
        $this->db->where('ts.tribe_id',$tribe_id);
        $this->db->group_by('ts.id');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * 查询族员信息和被成功担保的记录
     */
    public function be_secured( $customer_id , $tribe_id )
    {
        $date = date('Y-m-d');
        $this->db->select('ts.*,t.name as tribe_name,tr.role_name,count(g.id) as total');
        $this->db->from('tribe_staff as ts');
        $this->db->join('guarantee as g'," ts.customer_id = g.customer_id AND g.is_effective = 1 AND g.end_time >= '{$date}' ",'left');
        $this->db->join('tribe as t','t.id = ts.tribe_id','left');
        $this->db->join('tribe_role as tr','tr.id = ts.tribe_role_id','left');
        $this->db->where('ts.customer_id',$customer_id);
        $this->db->where('ts.status',2);
        $this->db->where('t.status',2);
        $this->db->where('ts.tribe_id', $tribe_id );
        $this->db->group_by('ts.id');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    
    
    
    //--------------------------------------------------------------
    
    /**
     * 根据部落id查询部落相关的商品
     * @param int $tribe_id 部落id
     * @param 分站点id $appid
     * @param unknown $limit
     * @param unknown $offset
     * @param int $type 类型：1全部商品价格desc2最新3共享服务4全部商品价格asc
     * @param int $status 状态
     */
    public function loading_goods($tribe_id,$appid,$limit=0,$offset=0,$type,$status=0){
        $this->db->select("a.id,a.name,a.goods_thumb,a.tribe_price");
        $this->db->from("product as a");
        $this->db->join("product_tribe as b","a.id = b.product_id");
        if($type!=1 && $type!=4){
            $this->db->join("product_sales_view as c","c.id=a.id");
        }
        
        $this->db->where("b.tribe_id",$tribe_id);
        // $this->db->where("b.status",1);
        $this->db->where("a.is_on_sale",1);
        $this->db->where("a.is_mc",0);
        $this->db->where("a.is_delete",0);
        if($appid){
            $this->db->where_in('a.app_id',array(0,$appid));
        }
        if($type == 1 || $type == 4){
            if($type == 1){
                $this->db->order_by("a.tribe_price","DESC");
                // $this->db->where("b.status",1);
                $this->db->where("a.is_mc",0);
            }else{
                // $this->db->where("b.status",1);
                $this->db->where("a.is_mc",0);
                $this->db->order_by("a.tribe_price","ASC");
            }
        }
        
        if($type == 2){
            $this->db->where("a.cat_id !=",104164);#共享服务分类104164
            $this->db->order_by("a.id","desc");
        }
        
        if($type == 3){
            $this->db->where("a.cat_id",104164);#共享服务分类104164
            $this->db->order_by("a.id","desc");
        }
        if($offset){
            $this->db->limit($limit,$offset);
        }else if($limit){
            $this->db->limit($limit);
        }
        
        if($status){
            return $this->db->get()->num_rows();
        }else{
            return $this->db->get()->result_array();
        }
    }
    
    
    //--------------------------------------------------------------
    
    /**
     * 申请加入部落
     * @param array $data 数据包
     */
    public function add_staff($data){
        
        if(isset($data["customer_id"])){
            $this->db->set("customer_id",$data["customer_id"]);
        }
        if(isset($data["tribe_id"])){
            $this->db->set("tribe_id",$data["tribe_id"]);
        }
        if(isset($data["member_name"])){
            $this->db->set("member_name",$data["member_name"]);
        }
        if(isset($data["corporation_name"])){
            $this->db->set("corporation_name",$data["corporation_name"]);
        }
        if(isset($data["provice"])){
            $this->db->set("provice",$data["provice"]);
        }
        if(isset($data["duties"])){
            $this->db->set("duties",$data["duties"]);
        }
        if(isset($data["city"])){
            $this->db->set("city",$data["city"]);
        }
        if(isset($data["scope"])){
            $this->db->set("scope",$data["scope"]);
        }
        if(isset($data["tribe_role_id"])){
            $this->db->set("tribe_role_id",$data["tribe_role_id"]);
        }
        if(isset($data["is_host"])){
            $this->db->set("is_host",$data["is_host"]);
        }
        if(isset($data["mobile"])){
            $this->db->set("mobile",$data["mobile"]);
        }
        if(isset($data["hope_offer"])){
            $this->db->set("hope_offer",$data["hope_offer"]);
        }
        if(isset($data["guarantee_ceiling"])){
            $this->db->set("guarantee_ceiling",$data["guarantee_ceiling"]);
        }
        if(isset($data["guarantee_to_ceiling"])){
            $this->db->set("guarantee_to_ceiling",$data["guarantee_to_ceiling"]);
        }
        if(isset($data["guarantee_from_ceiling"])){
            $this->db->set("guarantee_from_ceiling",$data["guarantee_from_ceiling"]);
        }
        if(isset($data["remain_guarantee_price"])){
            $this->db->set("remain_guarantee_price",$data["remain_guarantee_price"]);
        }
        
        if( !empty($data['own_goods']) ){
            $this->db->set('own_goods',$data['own_goods']);
        }
        
        if( !empty($data['replacement_intention']) ){
            $this->db->set('replacement_intention',$data['replacement_intention']);
        }
        
        if( !empty($data['industry']) ){
            $this->db->set('industry',$data['industry']);
        }
        
        if(isset($data["status"])){
            $this->db->set("status",$data["status"]);
        }
        if(isset($data["replacement_intention"])){
            $this->db->set("replacement_intention",$data["replacement_intention"]);
        }
        if(isset($data["industry"])){
            $this->db->set("industry",$data["industry"]);
        }
        if(isset($data["own_goods"])){
            $this->db->set("own_goods",$data["own_goods"]);
        }
        
        if(isset($data["is_host"])){
            $this->db->set("is_host",$data["is_host"]);
        }
        
        
        
        // $data["show_mobile"] = 1;
        // if(isset($data["show_mobile"])){
        //     $this->db->set("show_mobile",$data["show_mobile"]);
        // }
        
        if(isset($data['member_type']) && $data['member_type'] == 'prepare'){
            $data["show_mobile"] = 2;
            $this->db->set("show_mobile",$data["show_mobile"]);
            $this->db->set("is_pre_record",$data["is_pre_record"]);
        }else{
            if(isset($data["show_mobile"]) && $data["show_mobile"] == 2){
                $data["show_mobile"] == 2;
            }else{
                $data["show_mobile"] = 1; // 不是预录入部落成员写死显示手机号码
            }
            $this->db->set("show_mobile",$data["show_mobile"]);
          
        }
        
        $this->db->set("created_at",date("Y-m-d H:i:s"));
        $this->db->insert("tribe_staff");
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    
    
    /**
     * 部落内的收益分成收益排行榜
     */
    public function Rebate_Ranking_list( $tribe_id,$customer_id=null,$limit=null, $offset=null, $time=null )
    {
        $sql = '';
        $where1 = $where = "";
        
        if( !empty($time['start_at']) && !empty($time['ent_at']) )
        {
            $where = " and o_r.create_date  >= '{$time['start_at']}' and o_r.create_date  <= '{$time['ent_at']}' ";
            $where1 = " and gr.create_date  >= '{$time['start_at']}' and gr.create_date  <= '{$time['ent_at']}' ";
        }
        
        if( $customer_id )
        {
            $sql .= " select * from ( ";
            $sql .= " select  (@b := @b + 1) as position,b.*  from (";
        }
        
        $sql .= " select a.customer_id,any_value(a.mobile) as mobile,any_value(a.real_name) as real_name, any_value(a.member_name) as member_name,any_value(a.corporation_name) as corporation_name ,";
        $sql .= " sum(a.total)+sum(a.g_rebate) as total from ( ";
        $sql .= " select  ts.customer_id,ts.member_name,cc.corporation_name,c.real_name,c.mobile,";
        $sql .= " IFNULL( sum( CASE o_r.rebate_1_id when ts.customer_id then o_r.rebate_1 end ) ,0)+";
        $sql .= " IFNULL( sum( CASE o_r.rebate_2_id when ts.customer_id then o_r.rebate_2 end ), 0) as total, ";
        $sql .= " 0 as g_rebate";
        $sql .= " from 9thleaf_tribe_staff as ts ";
        $sql .= " join 9thleaf_order_rebate  as o_r on  (ts.customer_id = o_r.rebtae_1_id or ts.customer_id = o_r.rebate_2_id )";
        $sql .= " left join 9thleaf_customer_corporation as cc on cc.customer_id = ts.customer_id";
        $sql .= " left join 9thleaf_customer as c on c.id = ts.customer_id";
        $sql .= " where ts.tribe_id = {$tribe_id} and ts.status = 2 {$where} group by ts.id,cc.id";
        $sql .= " union ";
        $sql .= " select ts.customer_id,ts.member_name,cc.corporation_name, c.real_name,c.mobile,0 as rebate,sum(gr.rebate)";
        $sql .= " from 9thleaf_tribe_staff as ts ";
        $sql .= " join 9thleaf_guarantee_rebate as gr on ts.customer_id = gr.customer_id";
        $sql .= " left join 9thleaf_customer_corporation as cc on cc.customer_id = ts.customer_id";
        $sql .= " left join 9thleaf_customer as c on c.id = ts.customer_id";
        $sql .= " where ts.tribe_id = {$tribe_id} {$where1} group by ts.id,cc.id";
        $sql .= " ) as a group by a.customer_id order by total desc";
        
        
        if ($limit)
            $sql .= " limit $limit ";
            
            if ($offset)
                $sql .= " offset $offset";
                
                if( $customer_id )
                {
                    $sql .= " ) as b ,(select @b := 0) as d ";
                    $sql .= " ) as c where c.customer_id = {$customer_id} ";
                }
                
                
                $query = $this->db->query($sql);
                
                if( $customer_id )
                {
                    return $query->row_array();
                }
                
                return $query->result_array();
    }
    
    
    
    //--------------------------------------------------------------
    
    /**
     * 搜索部落
     * @param array $keywords 搜索关键词
     */
    public function tribe_search($keywords){
        $user_id = $this->session->userdata("user_id");//用户id
        $this->db->select("a.id,a.name,a.content,a.logo,count(b.id) as total");
        $this->db->from("tribe as a");
        $this->db->join("tribe_staff as b","b.tribe_id = a.id and b.status=2");
        $this->db->where("a.status","2");
        $this->db->where("b.customer_id",$user_id);
        foreach ($keywords as $k => $v){
            if($k==0){
                $this->db->like("a.name",$v);
            }else{
                $this->db->or_like("a.name",$v);
            }
        }
        $this->db->group_by("a.id");
        $this->db->order_by("a.liveness","desc");
        return $this->db->get()->result_array();
    }
    
    
    
    //--------------------------------------------------------------
    
    /**
     * 根据商品id查询商品是否属于我的部落
     * @param int $product_id 商品id
     * @param array $tribe_id 我的部落id
     */
    public function Whether_my_tribe($product_id,$tribe_id){
        $app_id = $this->session->userdata("app_info")['id'];
        
        $this->db->select("a.*");
        $this->db->from("product as a");
        $this->db->join("product_tribe as b","b.product_id = a.id");
        $this->db->where("a.id",$product_id);
        $this->db->where('a.is_mc', 0); // 不是二维码商品
        if( $app_id ){
            $this->db->where_in('a.app_id',array(0,$app_id));
        }
        $this->db->where_in("b.tribe_id",$tribe_id);
        return $this->db->get()->row_array();
    }
    
    
    /**
     * 根据手机号码&&部落ID判断是否是录入的用户
     */
    public function verify_tribe_user( $tribe_id , $moblie )
    {
        $this->db->select('*')->from('tribe_staff')->where(array('tribe_id'=> $tribe_id,'mobile'=>$moblie) );
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * 更新操作
     * 条件 update by mobile
     */
    public function update_tribe_staff( $data )
    {
        //         $this->db->set('update_at',date("Y-m-d H:i:s"));
        if( !empty($data['customer_id']) )
            $this->db->set('customer_id',$data['customer_id']);
//             $data['show_mobile'] = 1;
//             $this->db->set('show_mobile',$data['show_mobile']);
            // if(isset($data['is_pre_record'])){
            //     $this->db->set('is_pre_record',$data['is_pre_record']);
            // }
            
            if( !empty($data['status']) )
                $this->db->set('status',$data['status']);
                if( !empty( $data['tribe_id'] ) )
                    if(is_array($data['tribe_id'])){
                        $this->db->where_in('tribe_id',$data['tribe_id']);
                }else{
                    $this->db->where('tribe_id',$data['tribe_id']);
                }
                $this->db->where('mobile',$data['mobile']);
                $this->db->update('tribe_staff');
                return $this->db->affected_rows();
                
    }
    /**
     * 更新操作
     * 条件 update by id
     * @param array $data 数据集合
     * @param number $tribe_id 部落id
     */
    public function update_member($data,$tribe_id = 0){
        if( !empty($data['corporation_name']) )
            $this->db->set('corporation_name',$data['corporation_name']);
            if (! empty($data['member_name']))
                $this->db->set('member_name', $data['member_name']);
                if (! empty($data['provice']))
                    $this->db->set('provice', $data['provice']);
                    if (! empty($data['city']))
                        $this->db->set('city', $data['city']);
                        if (! empty($data['scope']))
                            $this->db->set('scope', $data['scope']);
                            if (! empty($data['duties']))
                                $this->db->set('duties', $data['duties']);
                                if (! empty($data['tribe_id']))
                                    $this->db->set('tribe_id', $data['tribe_id']);
                                    if (! empty($data['tribe_role_id']))
                                        $this->db->set('tribe_role_id', $data['tribe_role_id']);
                                        if (! empty($data['mobile']))
                                            $this->db->set('mobile', $data['mobile']);
                                            if (! empty($data['hope_offer']))
                                                $this->db->set('hope_offer', $data['hope_offer']);
                                                if (! empty($data['guarantee_ceiling']))
                                                    $this->db->set('guarantee_ceiling', $data['guarantee_ceiling']);
                                                    if (! empty($data['guarantee_to_ceiling']))
                                                        $this->db->set('guarantee_to_ceiling', $data['guarantee_to_ceiling']);
                                                        if (! empty($data['guarantee_from_ceiling']))
                                                            $this->db->set('guarantee_from_ceiling', $data['guarantee_from_ceiling']);
                                                            if (! empty($data['remain_guarantee_price']))
                                                                $this->db->set('remain_guarantee_price', $data['remain_guarantee_price']);
                                                                if (! empty($data['own_goods']))
                                                                    $this->db->set('own_goods', $data['own_goods']);
                                                                    if (! empty($data['replacement_intention']))
                                                                        $this->db->set('replacement_intention', $data['replacement_intention']);
                                                                        if (! empty($data['industry']))
                                                                            $this->db->set('industry', $data['industry']);
                                                                            if (! empty($data['status']))
                                                                                $this->db->set('status', $data['status']);
                                                                                if (! empty($data['bg_img']))
                                                                                    $this->db->set('bg_img', $data['bg_img']);
                                                                                    if (! empty($data['update_at']))
                                                                                        $this->db->set('update_at', $data['update_at']);
                                                                                        if (! empty($data['show_mobile'])) {
                                                                                            $this->db->set('show_mobile', $data['show_mobile']);
                                                                                        }
                                                                                        if (!empty($data['is_pre_record'])) {
                                                                                            $this->db->set('is_pre_record', $data['is_pre_record']);
                                                                                        }
                                                                                        if ( isset( $data['add'] ) ) {
                                                                                            $this->db->set('customer_id', $data['customer_id']);
                                                                                        }
                                                                                        
                                                                                        if ($tribe_id) {
                                                                                            $this->db->where("tribe_id", $tribe_id);
                                                                                        }
                                                                                        $this->db->where('id', $data['id']);
                                                                                        $this->db->update('tribe_staff');
                                                                                        return $this->db->affected_rows();
    }
    /**
     * 族员列表
     * @param $type 查询管理员所使用的参数(manager)
     */
    public function load_members_list( $tribe_id, $customer_id=0,$like = array(),$type = '')
    {
        if($type == 'manager'){
            $this->db->select('cc.status as corp_status,cc.approval_status,c.brief_avatar,cc.id as corp_id,cc.status as corp_status,t.name as t_name,t.content,c.real_name, c.wechat_avatar,ts.*,tm.id as m_id, tm.name as m_name,tm.module_id as m_module');
        }else{
            $this->db->select('cc.status as corp_status,cc.approval_status,c.brief_avatar,cc.id as corp_id,cc.status as corp_status,tr.role_name,t.name as t_name,c.real_name, c.wechat_avatar,ts.*');
        }
        $this->db->from('tribe as t');
        $this->db->join('tribe_staff as ts','t.id = ts.tribe_id');
        $this->db->join('tribe_role as tr','tr.id = ts.tribe_role_id','left');
        if($type == 'manager'){
            $this->db->join('tribe_manager as tm', 'ts.tribe_manager_id = tm.id', 'left');
            
        }
        $this->db->join('customer_corporation as cc' ,'ts.customer_id = cc.customer_id','left');
        $this->db->join('customer as c','c.id = ts.customer_id','left');
        $this->db->where(array('t.id'=>$tribe_id,'t.status'=>2,'ts.status'=>2) );
        
        if( $customer_id )
        {
            $this->db->where('ts.customer_id',$customer_id);
        }
        
        if( !empty( $like['member_name'] ) )
        {
            $this->db->where(" (c.real_name like '%{$like['member_name']}%' or ts.member_name like '%{$like['member_name']}%' or cc.corporation_name like '%{$like['member_name']}%') ");
        }
        $this->db->order_by('ts.status','desc');
        $this->db->order_by('c.id','desc');
        $query = $this->db->get();
        
        if( $customer_id )
            return $query->row_array();
            
            
            return $query->result_array();
    }
    
    
    
    
    /**
     * 查询部落存在的职位
     */
    public function load_members_duties( $tribe_id,$like=array() )
    {
        $this->db->select('tr.id,count(tr.id) as total,tr.role_name ');
        $this->db->from('tribe_role as tr ');
        $this->db->join('tribe_staff as ts','ts.tribe_role_id = tr.id');
        $this->db->where( array('ts.tribe_id'=>$tribe_id,'ts.status'=>2) );
        $this->db->order_by('sort');
        if( !empty( $like['member_name'] ) )
        {
            $this->db->like('ts.member_name',$like['member_name'] );
        }
        $this->db->group_by('tr.id');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     *
     * @param  $id 成员ID
     * @param  $tribe_id 部落ID
     * 查询成员信息
     */
    public function load_tribe_staff( $tribe_id,$id )
    {
        $this->db->select('t.name,tr.role_name,ts.*,c.brief_avatar,c.wechat_avatar,c.job,c.sex,c.nick_name,c.real_name,cc.id as corp_id,cc.corporation_name as corp_name');
        $this->db->from('tribe as t');
        $this->db->join('tribe_staff as ts','t.id = ts.tribe_id');
        $this->db->join('customer as c','c.id = ts.customer_id','left');
        $this->db->join('tribe_role as tr','tr.id = ts.tribe_role_id','left');
        $this->db->join('customer_corporation as cc','cc.customer_id = ts.customer_id','left');
        $this->db->where(array('ts.id'=>$id,'t.id'=>$tribe_id,'t.status'=>2) );
        $query = $this->db->get();
        return $query->row_array();
        
    }
    
    /**
     * 我的真实获得授信&获得担保的值
     */
    public function credit_guarantee_info( $tribe_id,$customer_id )
    {
        $date = date('Y-m-d');
        $this->db->select('t.id as t_id,tr.role_name,sum(g.guarantee_total) as guarantee_total,
            c.credit_ceiling,sum(cr.actual_credit) as actual_credit , ts.*');
        
        $this->db->from('tribe as t');
        $this->db->join('tribe_staff as ts','t.id = ts.tribe_id');
        $this->db->join('tribe_role as tr','ts.tribe_role_id = tr.id','left');
        $this->db->join('customer as c','ts.customer_id = c.id','left');
        $this->db->join('guarantee` as g',"g.tribe_id = t.id and g.is_effective = 1 and g.end_time >= '{$date}' and g.customer_id = ts.customer_id",'left');
        $this->db->join('credit as cr','cr.customer_id = c.id and cr.status = 2 and cr.is_effective = 2 ','left');
        $this->db->where(array('t.id'=>$tribe_id,'t.status'=>2,'ts.status'=>2,'ts.customer_id'=>$customer_id) );
        $this->db->group_by('ts.id,c.id');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * 查询用户是否在这个部落里。
     *
     */
    public function verify_tribe_customer($tribe_id,$customer_id,$status = 2 )
    {
        
        $this->db->from("tribe_staff");
        $this->db->where("tribe_id",$tribe_id);
        if($status){
            $this->db->where("status",$status);
        }
        $this->db->where("customer_id",$customer_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    /**
     * 更新族员权限
     * @param array $data 数组
     * @param int $flag 识别
     */
    public function update_manager_role($data,$flag = 0){
        if(isset($data['tribe_manager_id'])){
            $this->db->set("tribe_manager_id",$data['tribe_manager_id']);
        }
        if(!empty($data['tribe_id'])){
            $this->db->where("tribe_id",$data['tribe_id']);
        }
        if(!empty($data['customer_id'])){
            $this->db->where_in("customer_id",$data['customer_id']);
        }
        if(!empty($data['tribe_staff_id'])){
            $this->db->where("id",$data['tribe_staff_id']);
        }
        
        $result = $this->db->update("tribe_staff");
        if($flag){
            return $result;
        }
        return $this->db->affected_rows();
        
    }
    
    /**
     *获取管理成员列表
     *@param int $tribe_id  部落ID
     *@param str $type   列表类型  默认获取管理员列表
     */
    public function get_manager_list($tribe_id,$type = 'manager', $limit = 0,$offset = 0){
        $this->db->select("ts.id,ts.customer_id,ts.duties,ts.corporation_name as staff_corporation_name,cc.corporation_name,c.real_name,c.brief_avatar,c.wechat_avatar,ts.logo");
        $customer_id = $this->session->userdata("user_id"); //能进入到这里  该用户必然是义工委
        
        $this->db->where("ts.customer_id !=",$customer_id);//不能让自己出现在列表上
        $this->db->where("ts.tribe_id",$tribe_id);
        $this->db->where("ts.customer_id is not null");//必须是已注册用户
        $this->db->where("ts.status",2);//必须是审核通过的用户
        $this->db->from('tribe_staff as ts');
        $this->db->join("customer as c","ts.customer_id = c.id");
        $this->db->join("customer_corporation as cc","cc.customer_id = c.id and cc.status = 2 and cc.approval_status = 2 ","LEFT");
        
        if($type == 'manager'){
            $this->db->where("ts.is_host",0);//不是义工委
            $this->db->where("ts.tribe_manager_id",1);//是管理员
        }else{//普通成员
            $this->db->where("ts.is_host",0);//不是义工委
            $this->db->where("ts.tribe_manager_id",0);//也不是管理员
            
        }
        if($offset){
            $this->db->limit($limit,$offset);
        }else if($limit){
            $this->db->limit($limit);
        }
        
        $query = $this->db->get()->result_array();
        
        return $query ;
    }
    
    /**
     * 删除成员记录 退出操作
     */
    public function del_staff($staff_id){
        //删除族员信息
        $date = date("Y-m-d H:i:s");
        $this->db->set("status",4);
        $this->db->set("tribe_manager_id",0);
        $this->db->set("is_host",0);
        $this->db->set("delete_at",$date);
        $this->db->where("id",$staff_id);
        $this->db->update("tribe_staff");
        $row  = $this->db->affected_rows();
        return $row;
    }
    
    /**
     * 删除部落
     */
    public function del_tribe($id){
        $this->db->where("id",$id);
        $this->db->delete("tribe");
        return $this->db->affected_rows();
    }
    /**
     * 更新义工委
     */
    public function set_host($tribe_id,$customer_id){
        $this->db->set("is_host",1);
        $this->db->set("tribe_manager_id",0);
        $this->db->where("customer_id",$customer_id);
        $this->db->where("tribe_id",$tribe_id);
        $this->db->update('tribe_staff');
        return $this->db->affected_rows();
    }
    
    /**
     * 查询有关部落的
     */
    public function Load_Tribe_Message( $customer_id ,$tribe_id = 0 , $type = "return_row",$is_read = 1)
    {
        $this->db->select('cm.*,t.id as tribe_id, t.name, t.logo');
        $this->db->from('customer_message as cm');
        $this->db->join('tribe as t','cm.obj_id = t.id','left');
        $this->db->where(array('cm.type'=>4, 'cm.customer_id'=>$customer_id) );
        if($tribe_id){
            $this->db->join("message_template as mt","mt.template_id = cm.template_id");
            $this->db->where("mt.type",4);
            $this->db->where_in("cm.obj_id",$tribe_id);
        }
        
        if(!$is_read){
            $this->db->where("cm.is_read",$is_read);
        }
        
        $this->db->order_by('cm.id','desc');
        $query = $this->db->get();
        if($type == "return_row"){
            return $query->row_array();
        }else{
            return $query->result_array();
        }
    }
    
    
    // --------------------------------------------------------------------
    
    /**
     * 根据名称查询部落
     */
    public function check_name($name){
        
        $this->db->select("a.id,a.name,b.customer_id,a.status");
        $this->db->from("tribe as a");
        $this->db->join("tribe_staff as b","a.id = b.tribe_id");
        $this->db->where("a.name",$name);
        //         $this->db->where("b.is_host",1);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    // ---------------用户部落排序-----------------------------------------------------
    
    /**
     * 获取排序记录
     * @param  int $customer_id 用户id
     * @param  int  $tribe_id 部落id
     */
    public function load_tribe_sort($customer_id,$tribe_id = 0){
        $this->db->where("customer_id",$customer_id);
        if($tribe_id){
            $this->db->where("tribe_id",$tribe_id);
            $this->db->from("tribe_staff_sort");
            $row = $this->db->get()->row_array();
            return $row;
        }else{
            $this->db->from("tribe_staff_sort");
            $result = $this->db->get()->result_array();
            return $result;
        }
    }
    
    /**
     * 添加用户部落的排序
     * @param  int $customer_id 用户id
     * @param  int  $tribe_id 部落id
     */
    public function add_tribe_sort($customer_id,$tribe_id){
        $date = date('Y-m-d H:i:s');// 当前时间
        $this->db->set("customer_id",$customer_id);
        $this->db->set("created_at",$date);
        $this->db->set("tribe_id",$tribe_id);
        $this->db->insert("tribe_staff_sort");
        return $this->db->insert_id();
    }
    
    /**
     *记录用户浏览部落的最新时间
     * @param  int $customer_id 用户id
     * @param  int  $tribe_id 部落id
     */
    public function  record_tribe_time($customer_id,$tribe_id){
        $date = date('Y-m-d H:i:s');// 当前时间
        $this->db->set("updated_at",$date);
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("customer_id",$customer_id);
        $this->db->set("tribe_id",$tribe_id);
        $this->db->update("tribe_staff_sort");
        return $this->db->affected_rows();
    }
    
    /**
     * 置顶部落
     * @param  sort  1 置顶 0 取消置顶
     * @param  int $customer_id 用户id
     * @param  int  $tribe_id 部落id
     */
    
    public  function sort_tribe($sort,$customer_id,$tribe_id){
        if($sort){
            $date = date('Y-m-d H:i:s');// 当前时间
            $this->db->set("sort",1);
            $this->db->set("sort_at",$date);
        }else{
            $this->db->set("sort",0);
            $this->db->set("sort_at",NULL);//不能删  对排序很有用
        }
        $this->db->where('tribe_id',$tribe_id);
        $this->db->where('customer_id',$customer_id);
        $this->db->update("tribe_staff_sort");
        return $this->db->affected_rows();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 创建部落
     * @param array $parameter 数据包
     */
    public function create($parameter){
        $this->db->set($parameter);
        $this->db->insert("tribe");
        return $this->db->insert_id();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 更新部落信息
     * @param number $tribe_id 部落id
     * @param array $parameter 数据包
     */
    public function save($tribe_id,$parameter){
        $this->db->set($parameter);
        $this->db->where("id",$tribe_id);
        $this->db->update("tribe");
        return $this->db->affected_rows();
    }
    
    
    /**
     * 查询用户加入的部落列表+角色。
     */
    public function Customer_Tribe_List( $customer_id = 0)
    {
        $this->db->select('t.id,t.name,t.logo,tr.role_name');
        $this->db->from('tribe_staff as ts');
        $this->db->join('tribe as t','ts.tribe_id = t.id');
        $this->db->join('tribe_role as tr','tr.id = ts.tribe_role_id','left');
        $this->db->where('ts.customer_id',$customer_id);
        $this->db->where('ts.status',2);
        $this->db->where('t.status',2);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     *
     * @param unknown $param
     * 以用户信息为主。
     * 查询用户信息+该用户所属部落中的成员信息。
     */
    public function Customer_Ts_Info( $customer_id = 0, $tribe_id = 0 )
    {
        if( !$customer_id || !$tribe_id )
        {
            return array();
        }
        
        $this->db->select('c.*,ts.member_name,ts.show_mobile,ts.grade,ts.tribe_id,ts.id as staff_id');
        $this->db->from('customer as c');
        $this->db->join('tribe_staff as ts','ts.customer_id = c.id','left');
        $this->db->where('ts.tribe_id',$tribe_id);
        $this->db->where('c.id',$customer_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    
    /**
     * 设置部落手机显示隐藏
     * @param number $tribe_id 部落id
     * @param number $show_mobile 手机显示状态：1显示,2不显示
     */
    public function  update_tribe_show_mobile($tribe_id,$show_mobile){
        if(!$tribe_id){
            echo false;
        }
        if($show_mobile == 1){
            $this->db->set("show_mobile",1);
        }else{
            $this->db->set("show_mobile",2);
        }
        $this->db->where("tribe_id",$tribe_id);
        return $this->db->update("tribe_staff");
    }
    
    /**
     * 更新操作
     * 条件 update by mobile
     * @param number $customer_id 用户id
     * @param number $member_name 成员名称
     *
     */
    public function update_tribe_member_name( $member_name = null, $customer_id = 0 )
    {
        if( $member_name && $customer_id )
        {
            $this->db->set('member_name',$member_name);
            $this->db->where('customer_id',$customer_id);
            return $this->db->update("tribe_staff");
            
        }
    }
    
    
    
    /**
     * 更新手机显示按钮
     * @param number $show_mobile 手机号码显示状态：1显示，2隐藏
     * @param number $staff_id 部落成员id
     * @param $customer_id 用户id
     */
    public function update_show_mobile_status($show_mobile,$staff_id,$customer_id){
        
        if(isset($customer_id) && isset($show_mobile) && isset($staff_id)){
            if(isset($customer_id)){
                $this->db->where("customer_id",$customer_id);
            }
            
            if(isset($staff_id)){
                $this->db->where("id",$staff_id);
            }
            
            if(isset($staff_id)){
                $this->db->set("show_mobile",$show_mobile);
            }
            
            $this->db->update('tribe_staff');
            
            return $this->db->affected_rows();
        }
        
        
    }
    
    
    /**
     * @author JF
     * 2017年12月27日
     * 根据用户id查询管理的部落
     * @param number $customer_id 用户id
     * @param number $id 部落id
     * @param number $status 部落状态
     * @param array $module_id 权限id
     */
    function ManagementTribe($customer_id,$id = 0,$status = 0,$module_id = array() ){
        $this->db->select("a.*,b.is_host,b.tribe_manager_id");
        $this->db->from("tribe as a");
        $this->db->join("tribe_staff as b","a.id = b.tribe_id");
        $where = "";
        if($module_id){
            $this->db->join('tribe_manager c','c.id=b.tribe_manager_id',"left");
            foreach ($module_id as $key=>$v){
                if(!$key){
                    $where .= " and (FIND_IN_SET({$v},c.module_id)<>0 ";
                }else{
                    $where .= " or FIND_IN_SET({$v},c.module_id)<>0";
                }
            }
            $where .= ")";
        }
        $this->db->where("b.customer_id",$customer_id);
        $this->db->where("b.status",2);
        
        if( $status )
        {
            $this->db->where("a.status",$status);
        }
        if($where){
            $this->db->where("((b.is_host = 1) or (a.status = 2 and b.tribe_manager_id >0) {$where} )");
        }else{
            $this->db->where("((b.is_host = 1) or (a.status = 2 and b.tribe_manager_id >0))");
        }
        
        if($id){
            $this->db->where_in("a.id",$id);
        }
        $query = $this->db->get();
        if(!is_array($id) && $id > 0){
            return $query->row_array();
        }
        return $query->result_array();
    }
    
    
    
    
    /**
     * 根据用户id查询拥有族员管理权限的部落
     * @param number $customer_id 用户id
     * @param number $id 部落id
     */
    function ManagementTribe_apply($customer_id,$id = 0,$status = 0 ){
        $this->db->select("a.*,b.is_host,b.tribe_manager_id,tm.id as manager_id");
        $this->db->from("tribe as a");
        $this->db->join("tribe_staff as b","a.id = b.tribe_id");
        $this->db->join("tribe_manager as tm","b.tribe_manager_id = tm.id and FIND_IN_SET(2,tm.module_id)","left");
        $this->db->where("b.customer_id",$customer_id);
        $this->db->where("a.status",2);
        $this->db->where("b.status",2);
        
        if( $status )
        {
            $this->db->where("a.status",$status);
        }
        $this->db->where("((b.is_host = 1) or (a.status = 2 and b.tribe_manager_id >0 and tm.module_id is not null))");
        
        if($id){
            $this->db->where_in("a.id",$id);
        }
        $query = $this->db->get();
        if(!is_array($id) && $id > 0){
            return $query->row_array();
        }
        return $query->result_array();
    }
    
    /**
     * @author JF
     * 2017年12月28日
     * 根据部落id查询部落义工委
     * @param number $tribe_id 部落id
     */
    function TribeMaster($tribe_id){
        if(!$tribe_id){
            return array();
        }
        $this->db->from("tribe_staff");
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("is_host",1);
        return $this->db->get()->row_array();
    }
    
    
    /**
     * 添加/删除管理员
     * @param $staff_id array 部落成员id
     * @param $type 0删除管理员，1添加管理员
     * @param $tribe_manage_id 角色id
     * return result affect_row
     */
    function update_manage($staff_id,$type=0,$tribe_manager_id=0)
    {
        
        $this->db->where_in('id', $staff_id);
        
        if($type == 'add' && $tribe_manager_id){
            
            $this->db->set('tribe_manager_id', $tribe_manager_id);
            
        }else{
            
            $this->db->set('tribe_manager_id', 0);
        }
        
        $this->db->update('tribe_staff');
        return $this->db->affected_rows();
    }
    
    
    
    /**
     * 按族员id查找族员信息
     * @param $tribe_id       部落id
     * @param $tribe_manager_id 0,   普通族员，大于0，管理员
     * @return array
     */
    public function load_staff_by_id( $tribe_id,$tribe_manager_id=0)
    {
        if($tribe_manager_id){
            $this->db->select('cc.status as corp_status,cc.approval_status,c.brief_avatar,cc.id as corp_id,cc.status as corp_status,t.name as t_name,c.real_name, c.wechat_avatar,c.is_valid,ts.*,,m.id as m_id,m.name as m_name');
        }else{
            $this->db->select('cc.status as corp_status,cc.approval_status,c.brief_avatar,cc.id as corp_id,cc.status as corp_status,t.name as t_name,c.real_name, c.wechat_avatar,c.is_valid,ts.*');
        }
        
        $this->db->from('tribe as t');
        $this->db->join('tribe_staff as ts','t.id = ts.tribe_id');
        $this->db->join('customer_corporation as cc' ,'ts.customer_id = cc.customer_id','left');
        $this->db->join('customer as c','ts.customer_id = c.id','right');
        $this->db->where(array('t.id'=>$tribe_id,'t.status'=>2,'ts.status'=>2) );
        if($tribe_manager_id){
            $this->db->where('tribe_manager_id  > ', 0);
            $this->db->join('tribe_manager as m','m.id = ts.tribe_manager_id','left');
        }else{
            $this->db->where('tribe_manager_id', $tribe_manager_id);
        }
        
        $this->db->order_by('ts.status','desc');
        $this->db->order_by('c.id','desc');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    
    /**
     * 查找正式族员
     * @param  $tribe_id 部落id
     * @param  $type 非正式族员not
     * @return array
     */
    public function query_nor_tribe_members($tribe_id,$type=''){
        $this->db->where("tribe_id", $tribe_id);
        if($type == 'not'){
            $this->db->where("customer_id ", NUll);
        }else{
            $this->db->where("customer_id >", 0);
            $this->db->where("status", 2);
        }
        
        $query = $this->db->get('tribe_staff');
        return $query->result_array();
        
    }
    
    
    /**
     * 更新部落信息
     * @param $data 更新信息
     * @return @$return
     */
    public function update_tribe($data)
    {
        // if(isset($data['name'])){
        //     $this->db->set('name', $data['name']);
        // }
        
        if(isset($data['provice'])){
            $this->db->set('provice', $data['provice']);
        }
        
        if(isset($data['city'])){
            $this->db->set('city', $data['city']);
        }
        
        if(isset($data['industry'])){
            $this->db->set('industry', $data['industry']);
        }
        
        if(isset($data['staff_status'])){
            $this->db->set('staff_status', $data['staff_status']);
        }
        
        if(isset($data['shop_img'])){
            $this->db->set('shop_img', $data['shop_img']);
        }
        
        if(isset($data['logo'])){
            $this->db->set('logo', $data['logo']);
        }
        
        if(isset($data['bg_img'])){
            $this->db->set('bg_img', $data['bg_img']);
        }
        
        if(isset($data['content_img'])){
            $this->db->set('content_img', $data['content_img']);
        }
        
        if(isset($data['content'])){
            $this->db->set('content', $data['content']);
        }
        
        $this->db->where('id', $data['tribe_id']);
        $this->db->update('tribe');
        return $this->db->affected_rows();
        
    }
    
    /**
     * 查找所有管理员角色
     *
     */
    public function load_all_manager_role($role_id='')
    {   if($role_id){
        $this->db->where_not_in('id', $role_id);
    }
    $query = $this->db->get('tribe_manager');
    return $query->result_array();
    }
    
    /**
     * 查找一个部落下的不同角色的管理员
     * @param $tribe_id
     * @
     */
    public function load_tribe_manager_by_id($tribe_id,$role='')
    {
        $this->db->query("set sql_mode ='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
                ");
        $this->db->select("a.*,b.id as tribe_id,c.id as staff_id, c.member_name,c.tribe_manager_id");
        $this->db->from("tribe_manager as a");
        $this->db->join('tribe_staff as c', 'a.id=c.tribe_manager_id', 'left');
        $this->db->join("tribe as b", 'b.id=c.tribe_id', 'left');
        $this->db->where('b.id', $tribe_id);
        if($role){
            $this->db->group_by("c.tribe_manager_id");
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * 根据id查询管理员权限
     * @param $id sting 权限ID
     * @return $return array
     */
    public function load_auth_by_id($id)
    {
        $id = explode(',', $id);
        $this->db->select('id,module_name,url');
        $this->db->where_in('id', $id);
        $query = $this->db->get('tribe_module');
        return $query->result_array();
    }
    
    
    /**
     * 查询所有部落并统计每个部落下的正式族员数量
     * @param $tribe 部落id
     * @return array
     */
    public function load_tribe_staff_list($tribe_id)
    {
        // $this->db->query("set sql_mode ='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
        //         ");
        $query = $this->db->query(
            "select a.id,a.name,a.logo,a.status,any_value(b.status) as b_status,any_value(b.customer_id),any_value(b.tribe_id),any_value(b.member_name),count(any_value(b.tribe_id)) as sub_satff_member from 9thleaf_tribe as a left join 9thleaf_tribe_staff as b ON a.id = b.tribe_id   where a.id in ( {$tribe_id} ) and a.status = 2 and b.status=2 and b.customer_id is not null  group by b.tribe_id order by a.id desc"
        );
        return $query->result_array();
    }
    
    
    /**
     * 保存部落邀请相关信息
     * @param $data 邀请部落相关信息
     * @return $id
     */
    public function save_customer_tribe($data)
    {
        $this->db->set('customer_id', $data['customer_id']);
        $this->db->set('tribe_id', $data['tribe_id']);
        $this->db->insert('customer_tribe');
        $id = $this->db->insert_id();
        return $id;
    }
    
    /**
     * 按手机号码查询trie_id
     * @param mobile 手机号码
     * @return array
     */
    public function load_tribe_by_mobile($mobile)
    {
        $this->db->select('tribe_id');
        $this->db->from('tribe_staff');
        $this->db->where('mobile', $mobile);
        $this->db->where('status', 2);
        $this->db->where('is_pre_record ', 1);
        $this->db->where("customer_id", null);
        $this->db->group_by('tribe_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    
    /**
     * 更新弹出次数
     * @param $num,弹出次数
     * @param $mobile 用户手机号码
     * @param $reset num置0
     * @return array
     */
    public function update_tips($num=0,$mobile,$reset='')
    {
        
        $res = $this->load_tribe_tips($mobile);
        if(empty($res)){
            $this->db->set('tip_num', $num);
            $this->db->set('mobile', $mobile);
            $this->db->insert('tribe_tips');
            $id = $this->db->insert_id();
            return $id;
        }else{
            if($reset == 'reset'){
                $this->db->set('tip_num', $num);
                $this->db->set('status', 1);
                $this->db->where('mobile', $mobile);
                $this->db->update('tribe_tips');
            }else{
                $rnum = $res['tip_num'];
                $num = $rnum + $num;
                $this->db->query("update 9thleaf_tribe_tips set tip_num= $num where mobile= $mobile ");
                return $this->db->affected_rows();
            }
        }
    }
    
    /**
     * 查询弹出次数
     */
    public function load_tribe_tips($mobile){
        if(empty($mobile)){
            return false;
        }
        $this->db->where('mobile', $mobile);
        $query = $this->db->get('tribe_tips');
        $res = $query->row_array();
        return $res;
    }
    
    /**
     * 根据mobile，tribe_manager_id  查找管理员
     * @param $data数据包
     */
    public function select_manager($data)
    {
        $this->db->select('id');
        $this->db->from("tribe_staff");
        $this->db->where('tribe_manager_id', $data['tribe_manager_id']);
        $this->db->where('tribe_id', $data['tribe_id']);
        $this->db->where('status', 2);
        $query = $this->db->get();
        
        return $query->result_array();
        
       
    }
    
    /**
     * 关闭状态不再显示
     * @param $mobile 手机号码
     * @param $status 状态
     * @return affected_rows
     */
    public function  show_page($mobile,$status)
    {
        $this->db->set('status', $status);
        $this->db->where('mobile', $mobile);
        $this->db->update('tribe_tips');
        return $this->db->affected_rows();
    }
    
    /**
     * 获取管理员角色
     */
    public function get_role()
    {
        $this->db->select("id,name");
        $this->db->from("tribe_manager");
        $res=$this->db->get();
        return $res->result_array();
    }
    
    /**
     * 根据角色获取成员
     * @param $id 部落id
     * @param 管理员角色id
     * @return array
     */
    public function get_staff_by_role($id,$tribe_manager_id){
        $this->db->select("ts.id,ts.member_name,c.real_name");
        $this->db->from("tribe_staff as ts");
        $this->db->join("customer as c","c.id=ts.customer_id","left");
        $this->db->where("ts.tribe_id",$id);
        $this->db->where("ts.tribe_manager_id",$tribe_manager_id);
        $res=$this->db->get();
        //        var_dump($this->db->last_query());die();
        return $res->result_array();
    }
    
    
    /**
     * 根据手机号查询部落成员
     * @param $mobile
     * @return array
     */
    public function get_staff_by_mobile($mobile,$tribe_id)
    {
        $this->db->select("member_name");
        $this->db->from('tribe_staff');
        $this->db->like('mobile', $mobile);
        $this->db->where('tribe_manager_id', 0);
        $this->db->where('is_pre_record', 0);
        $this->db->where('tribe_id', $tribe_id);
        $this->db->where('is_host <>', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    

    public function getQSmemberList($tribe_id){
        $this->db->from("tribe_staff");
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("customer_id !=",NULL);
        $this->db->where("status",2);
        $query = $this->db->get();
        return $query->num_rows();
    }


    
    
    /**
     * @author JF
     * 2018年4月3日
     * 更新部落用户真实姓名
     * @param number $customer_id 用户id
     */
    function ChangeStaffName($customer_id,$data){
        if(!$customer_id){
            return false;
        }
        $this->db->set($data);
        $this->db->where("customer_id",$customer_id);
        return $this->db->update("tribe_staff");
    }
}
