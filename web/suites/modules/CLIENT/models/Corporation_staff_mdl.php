<?php
/**
 *
 * 店铺权限
 *
 */
class Corporation_staff_mdl extends CI_Model {

    var $status;
    var $corp_role_id;
    var $remark;
    var $corporation_id;

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}

	/**
	 * 获取员工信息
	 * @param  int $customer_id 用户id
	 * @param  int $corp_id 店铺id
	 * @param  array $status 状态：0待邀请1邀请中2在职3冻结
	 */

	function get_corp_staff($customer_id,$corp_id=NULL,$status=NULL) {
	    $this->db->from("corporation_staff as a");
	    $this->db->where("a.customer_id",$customer_id);
	    $this->db->where("a.corporation_id",$corp_id);
	    if($status){
	       $this->db->where_in("status",$status);
	    }
	    $query = $this->db->get();
	    return $query->row_array();
	}
	
	
	/**
	 * 获取员工信息
	 * @param  int $customer_id 用户id
	 * by   $customer_id
	 */
	function get_staff($customer_id,$status=NULL){
	    $this->db->select("*");
	    $this->db->where('cs.customer_id',$customer_id);
	    if($status){
	    $this->db->where('cs.status',$status);
	    }
	    $this->db->from("corporation_staff as cs");
	    $this->db->join("customer_corporation as cc","cs.corporation_id = cc.id","left");
	    $this->db->where('cc.approval_status',2);
	    $this->db->where('cc.status',1);
	    $query = $this->db->get()->result_array();
	    return $query;
	}
	
	//-------------------------------------------------------
	
	/**
	 * 添加员工
	 * @param int $customer_id
	 * @param int $role_id
	 * @param int $corp_id
	 */
	function add_staff($customer_id,$role_id,$corp_id){
	    $this->db->set('customer_id',$customer_id);
	    $this->db->set('corp_role_id',$role_id);
	    $this->db->set('corporation_id',$corp_id);
	    $this->db->set("created_at",date("Y-m-d H:i:s"));
	    $this->db->insert('corporation_staff');
	    return  $this->db->insert_id();
	}
	
	//-------------------------------------------------------
	
	
	/**
	 * 根据id查询职位
	 * @param int $role_id 职位id
	 */
	function load_role($role_id=null){
	    $this->db->from("corporation_role");
	    if($role_id){
	       $this->db->where("id",$role_id);
	    }
	    $query = $this->db->get();
	    if($role_id){
	        return $query->row_array();
	    }else{
	        return $query->result_array();
	    }
	}
	
	//-------------------------------------------------------
	
	/**
	 * 修改员工状态
	 * @param int $id
	 * @param int $corp_id 店铺id
	 * @param int $status 状态
	 */
	function save_status($id,$corp_id,$status){
	    $this->db->set("status",$status);
	    $this->db->where("id",$id);
	    $this->db->where("corporation_id",$corp_id);
	    $this->db->update("corporation_staff");
	    return $this->db->affected_rows();
	    
	}
	
	//-------------------------------------------------------
    
    /**
     * 获取企业员工名单
     * @param int $corporation_id 企业ID
     * @param int $type 返回结果状态
     * @param int $id 
     */
    function get_corporation_staff_list($corporation_id,$type=NULL,$limit=NULL,$offset=NULL,$id=NULL,$status=NULL){
        $this->db->select("a.id,a.status,a.created_at,a.customer_id,a.remark,b.real_name,b.nick_name,b.wechat_nickname,b.name as c_name,b.mobile,c.id as role_id,c.name as role_name");
        $this->db->from('corporation_staff as a');
        $this->db->join("customer as b","a.customer_id=b.id");
        $this->db->join("corporation_role as c","a.corp_role_id=c.id");
        $this->db->where('a.corporation_id',$corporation_id);
        if($status > -1){
            $this->db->where("a.status",$status);
        }
        if($id){
            $this->db->where("a.id",$id);
        }
        if($limit){
            $this->db->limit($limit,$offset);
        }
        $this->db->order_by("a.id","desc");
        $query = $this->db->get();
        
        if($type){
            return $query->num_rows();
        }else{
            if($id){
                return $query->row_array();
            }else{
                return $query->result_array();
            }
        }
    }
    
    //-------------------------------------------------------
    
    
    /**
     * 获取企业员工管理权限
     *  $corporation_id 企业ID
     *  $customer_id 员工ID
     */
    function get_staff_authority($corporation_id,$customer_id){
        $this->db->select('`cm`.* 
        FROM `9thleaf_corporation_staff` as `cs`
        JOIN `9thleaf_corporation_role` as `cr` ON `cr`.`id` = `cs`.`corp_role_id`
        JOIN `9thleaf_corporation_module` as `cm` on find_in_set(`cm`.`id`,`cr`.`module_id`)
        WHERE `cs`.`customer_id` = '.$customer_id.'
        AND `cs`.`corporation_id` = '.$corporation_id.'
        AND `cs`.`status` = 2');
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    //-------------------------------------------------------
    
    /**
     * 更新
     * @param int $id
     */
    function save($id){
        $this->db->set("corp_role_id",$this->corp_role_id);
        $this->db->set("status",$this->status);
        $this->db->set("remark",$this->remark);
        $this->db->set("updated_at",date("Y-m-d H:i:s"));
        $this->db->where("id",$id);
        $this->db->update("corporation_staff");
        return $this->db->affected_rows();
    }
    
    //-------------------------------------------------------
    
    
    /**
     * 删除
     * @param int $id 
     * @param int $corporation_id 店铺id
     * @param int $customer_id 用户id
     */
    function del($id,$corporation_id,$customer_id){
        $this->db->where("corporation_id",$corporation_id);
        $this->db->where_in("id",$id);
        $this->db->where("customer_id !=",$customer_id);
        $this->db->delete("corporation_staff");
        return $this->db->affected_rows();
    }
    
    //-------------------------------------------------------
    
    /**
     * 根据用户id查询管理的企业
     * @param unknown $customer_id
     */
    public function corp_manage($customer_id){
        $this->db->select("b.id,a.status,b.corporation_name");
        $this->db->from("corporation_staff as a");
        $this->db->join("customer_corporation as b","a.corporation_id = b.id");
        $this->db->where("a.customer_id",$customer_id);
        $this->db->where("(a.status=2 or a.status=3)");
        $this->db->where("b.status",1);
        return $this->db->get()->result_array();
    }
    
    //-------------------------------------------------------
    
    /**
     * 根据员工表id查询用户手机和店铺
     * @param int $id 员工表id
     */
    public function get_info($id){
        $this->db->select("b.name,c.corporation_name");
        $this->db->from("corporation_staff as a");
        $this->db->join("customer as b","a.customer_id = b.id");
        $this->db->join("customer_corporation as c","a.corporation_id = c.id");
        $this->db->where("a.id",$id);
        $query = $this->db->get();
        return $query->row_array();
    }
    

}