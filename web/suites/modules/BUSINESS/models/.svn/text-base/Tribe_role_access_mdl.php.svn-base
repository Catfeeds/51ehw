<?php
/**
 *
 * 部落管理员权限
 *
 */
class  Tribe_role_access_mdl extends CI_Model {

    function __construct() {
        parent::__construct ();
    }
    
    
    /**
     * 获取部落管理员角色
     *@param int tribe_id  部落ID
     */
    public function  get_tribe_role_access($tribe_id){
        $this->db->where("tribe_id",$tribe_id);
        $this->db->from("tribe_role_access");
        return $this->db->get()->result_array();
    }
    
    /**
     * 获取部落管理员
     *@param int tribe_id  部落ID
     *@param str times
     *@param str keyword
     */
    public function  get_tribe_staff_access($tribe_id,$keyword = '',$times = '',$limit = 0, $offset = 0){
        $this->db->select("tsa.id,tsa.created_at,tsa.remark,tra.name as role_name,ts.member_name,ts.mobile,c.id as customer_id,c.name as customer_name");
        $this->db->from("tribe_staff_access as tsa");
        $this->db->join("tribe_role_access as tra","tsa.tribe_role_access_id =tra.id");
        $this->db->join("tribe_staff as ts","ts.id =tsa.tribe_staff_id");
        $this->db->join("customer as c","c.id = ts.customer_id");
        $this->db->where("tsa.tribe_id",$tribe_id);
        
        //关键词搜索
        if($keyword){
            $this->db->like("tra.name",$keyword);
            $this->db->or_like("ts.member_name",$keyword);
            $this->db->or_like("c.name",$keyword);
        }
        
        //时间筛选
        if($times){
            $is_ok = false;
            switch ($times){
                case '显示全部':
                    break;
                case '近7天内':
                    $is_ok = true;
                    $limit_date = date('Y-m-d ', strtotime("-7 days"));// 筛除时间段：7天
                    break;
                case '近一个月内':
                    $is_ok = true;
                    $limit_date = date('Y-m-d ', strtotime("-30 days"));// 筛除时间段：30天
                    break;
                case '3个月内':
                    $is_ok = true;
                    $limit_date = date('Y-m-d ', strtotime("-90 days"));// 筛除时间段：90天
                    break;
                case '半年内':
                    $is_ok = true;
                    $limit_date = date('Y-m-d ', strtotime("-182 days"));// 筛除时间段：半年
                    break;
                case '1年内':
                    $is_ok = true;
                    $limit_date = date('Y-m-d ', strtotime("-365 days"));// 筛除时间段：一年
                    break;
                default:
                    break;
            }
            if( $is_ok ){
                $date = date('Y-m-d H:i:s');// 当前时间
                $this->db->where("tsa.created_at >=",$limit_date);
                $this->db->where("tsa.created_at <=",$date);
            }
        }
        
        if($offset){
            $this->db->limit($limit, $offset);
        }else{
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }
    
    /**
     * 获取管理员信息
     *@param int tribe_id  部落ID
     *@param int  id    管理员ID
     */
    public function check_staff_access($tribe_id,$id){
        $this->db->select("tsa.id,ts.member_name,tsa.tribe_role_access_id,tra.name as role_name");
        $this->db->from("tribe_staff_access as tsa");
        $this->db->join("tribe_staff as ts","ts.id = tsa.tribe_staff_id");
        $this->db->join("tribe_role_access as tra","tra.id = tsa.tribe_role_access_id");
        $this->db->where("tsa.tribe_id",$tribe_id);
        $this->db->where("tsa.id",$id);
        return $this->db->get()->row_array();
    }
    
    /**
     *获取部落成员信息 
     *@param int tribe_id  部落ID
     */
    public function tribe_staff_list($tribe_id){
        $this->db->select("ts.id,ts.member_name");
        $this->db->where("ts.tribe_id",$tribe_id);
        $this->db->where("ts.status",2);
        $this->db->from("tribe_staff as ts");
        $this->db->join("customer as c","c.id = ts.customer_id ");
        return $this->db->get()->result_array();
    }
    
    /**
     * 删除管理员
     *@param int tribe_id  部落ID
     *@param int  id    管理员ID
     */
    
    public function del_admin($tribe_id,$id){
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("id",$id);
        $this->db->delete("tribe_staff_access");
        return  $this->db->affected_rows();
    }
    
    /**
     * 删除权限
     *@param int tribe_id  部落ID
     *@param int  id    管理员权限ID
     */
    public function del_role($tribe_id,$id){
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("id",$id);
        $this->db->delete("tribe_role_access");
        return  $this->db->affected_rows();
    }
    
    /**
     * 获取顶级权限列表
     * @param pid  父级ID  默认顶级
     */
    public function get_role($pid = 0){
        $this->db->select("id,pid,module_name");
        $this->db->from("tribe_module_access");
        $this->db->where("pid",$pid);//父级]
        return $this->db->get()->result_array();
    }
    
    /**
     * 获取权限
     *@param int tribe_id  部落ID
     * @param int id  权限ID
     * @param str name  权限名称
     * @param float type  是否检查当前账户权限名称  
     */
    public function get_role_detail($tribe_id,$name = 0,$type = false,$id=0){
        $this->db->from("tribe_role_access");
        $this->db->where("tribe_id",$tribe_id);
        if($name){
            $this->db->where("name",$name);
        }
        if($type){
            if($id){
                $this->db->where("id !=",$id);
            }
        }else{
            if($id){
                $this->db->where("id",$id);
            }
        }
        
        return $this->db->get()->row_array();
    }
    
    
    /**
     * 某个角色权限下管理员
     *@param int tribe_id  部落ID
     * *@param int  tribe_role_access_id 部落角色权限表ID
     */
    public function  get_role_staff_by_Role($tribe_id,$tribe_role_access_id){
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("tribe_role_access_id",$tribe_role_access_id);
        $this->db->from("tribe_staff_access");
        return $this->db->get()->result_array();
    }
    
    
    /**
     * 保存管理员角色
     */
    public function  save_role($data){
        $this->db->set("tribe_id",$data['tribe_id']);
        $this->db->set("name",$data['name']);
        $this->db->set("module_id",$data['module_id']);
        $this->db->insert("tribe_role_access");
        return $this->db->insert_id();
    }
    
   /**
    *更新 管理员角色  
    */
    public function update_role($data){
       
        $this->db->set("name",$data['name']);
        $this->db->set("module_id",$data['module_id']);
        $this->db->where("tribe_id",$data['tribe_id']);
        $this->db->where("id",$data['id']);
        $this->db->update("tribe_role_access");
        return  $this->db->affected_rows();
    }
    /**
     * 保存管理员
     */
    public  function  save_staff_role($data){
        $this->db->set("tribe_id",$data['tribe_id']);
        $this->db->set("tribe_staff_id",$data['tribe_staff_id']);
        $this->db->set("tribe_role_access_id",$data['tribe_role_access_id']);
        $this->db->set("remark",$data['remark']);
        $this->db->insert("tribe_staff_access");
        return $this->db->insert_id();
    }
    /**
     * 更新管理员
     */
    public function update_staff_role($data){
        $this->db->set("tribe_role_access_id",$data['tribe_role_access_id']);
        $this->db->set("remark",$data['remark']);
        
        $this->db->where("tribe_id",$data['tribe_id']);
        $this->db->where("id",$data['tribe_staff_id']);
      
        $this->db->update("tribe_staff_access");
        return  $this->db->affected_rows();
    }
}