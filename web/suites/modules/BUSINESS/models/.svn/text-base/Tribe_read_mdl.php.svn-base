<?php
/**
 * 部落阅读模型
 */

class  Tribe_read_mdl extends CI_Model {


	function __construct() {
		parent::__construct ();
	}
	
	/**
	* @author JF
	* 2017年11月24日
	* 检查是否已经阅读
	* @param number $customer_id 用户Id
	* @param number $id 对象id
	* @param number $type 类型1公告2活动
	*/
	function check_read($customer_id,$id,$type){
	   $this->db->from("tribe_read");
	   $this->db->where("customer_id",$customer_id);
	   $this->db->where("obj_id",$id);
	   $this->db->where("type",$type);
	   $query = $this->db->get();
	   return $query->num_rows();
	}
	
	/**
	* @author JF
	* 2017年11月24日
	* 添加阅读记录
	* @param array $data 数据集合
	*/
	function create($data = null){
	    if(!$data){
	        return false;
	    }
        $this->db->set($data);
        $this->db->insert("tribe_read");
        return $this->db->insert_id();
	}
	
// 	/**
// 	 * @author JF
// 	 * 2017年11月27日
// 	 * 查询已阅读公告or活动
// 	 * @param number $id 公告id
// 	 * @param number $type 类型1公告2活动
// 	 */
// 	function load_read_notice($id,$type){
// 	    $this->db->from("tribe_read");
// 	    $this->db->where("obj_id",$id);
// 	    $this->db->where("type",$type);
// 	    return $this->db->get()->result_array();
// 	}
	
   
	
	/**
	 * @author tan
	 * 2017年11月27日
	 * 查询用户在某个商会下的阅读记录
	 * @param array $ids 商会加入的部落与用户加入的部落之间的交集
	 * @param number $customer_id 用户Id
	 * @param number $type 类型1公告2活动
	 */
	public function read_list($ids,$customer_id,$type = 1){
	    $this->db->from("tribe_read as r");
	    if($type == 1){
	        $this->db->join("tribe_content as tc","r.obj_id = tc.id");
	        $this->db->where_in("tc.tribe_id",$ids);
	    }else{
	        $this->db->join("tribe_activity as ta","r.obj_id = ta.id");
	        $this->db->where_in("ta.tribe_id",$ids);
	    }
	    $this->db->where("r.customer_id",$customer_id);
	    $this->db->where("r.type",$type);
	    $query = $this->db->get()->result_array();
	    return $query;
	}
	

}
 