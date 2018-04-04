<?php
/**
 * 会员背书模块
 *
 *
 */
class Resource_mdl extends CI_Model {
    var $title;
    var $recommend_img;
    var $recommend_content;
    var $recommend_name;
    var $recommend_honor;
    var $recommend_language;
	var $recommend_company;
	var $logo;
	var $certificate;
	var $company_brief;
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}

	/**
	 * 查询记录
	 * @param 店铺id
	 * @param 状态
	 * @param 统计
	 * @param 背书id
	 */
	function log($corporation_id,$status=null,$type=NULL,$resource_id=NULL,$page=NULL,$offset=NULL) {
        if($status==null && $status !==0){}else{
            $this->db->where('approve_status',$status);
        }
	    !empty($resource_id)?$this->db->where('id',$resource_id):'';
	    !empty($page)?$this->db->limit($page,$offset):"";
	    $query = $this->db->order_by('updated_at','desc')->get_where('corporation_resource',array('id_corporation'=>$corporation_id));
	    if($resource_id){
	        return $query->row_array();
	    }else if($type){
	        return $query->num_rows();
	    }else{
	        return $query->result_array();
	    }
	}
	
	//----------------------------------------------------------------
	
	/**
	 * 添加会员背书申请
	 */
	function add($corporation_id,$status,$id=null) {
	    $this->db->set('recommend_language',$this->recommend_language);
        $this->db->set('recommend_company',$this->recommend_company);
        $this->db->set('company_brief',$this->company_brief);
        $this->db->set('recommend_name',$this->recommend_name);
        $this->db->set('recommend_img',$this->recommend_img);
        $this->db->set('logo',$this->logo);
        $this->db->set('certificate',$this->certificate);
        $this->db->set('updated_at',date('Y-m-d H:i:s'));
        $this->db->set('approve_status',0);
        $this->db->set('id_corporation',$corporation_id);
        $this->db->set('title',$this->title);
        $this->db->set('recommend_content',$this->recommend_content);
        if($status==1){
            $this->db->insert('corporation_resource');
            return $this->db->insert_id();
        }else{
            $this->db->where('id',$id);
            $this->db->update('corporation_resource');
            return $this->db->affected_rows();
        }
        
	}
	
	//----------------------------------------------------------------
	
	/**
	 * 修改背书状态
	 * @param $approve_status 审核状态 0审核中1通过2未通过3上架4下架
	 * @param $corporation_id 店铺id
	 * @param $resource_id 会员背书id
	 */
	function operate($corporation_id,$resource_id,$approve_status) {
	    $this->db->set('approve_status',$approve_status);
	    $this->db->where('id',$resource_id);
	    $this->db->where('id_corporation',$corporation_id);
	    return $this->db->update('corporation_resource');
	}
	
	/**
	 * 删除背书
	 * @param array $resource_array 背书id
	 * @param $corporation_id 店铺id
	 */
	function delects($corporation_id,$resource_array){
	    $this->db->where_in('id',$resource_array);
	    $this->db->where('id_corporation',$corporation_id);
	    return $this->db->delete ( 'corporation_resource' );
	}
	



	
}