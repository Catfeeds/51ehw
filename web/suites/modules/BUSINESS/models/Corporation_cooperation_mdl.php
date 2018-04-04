<?php
/**
 *
 *
 *
 */
class Corporation_cooperation_mdl extends CI_Model {
    
	var $id;

	var $customer_id = 0;

	var $corporation_name = "";

	var $corporation_type = 0;

	var $applicant_name = "";

	var $applicant_duty = "";

	var $coo_direction = "";

	var $mobile;

	var $remarks;

	var $status = 0;

	var $created_at;
	

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}

	// --------------------------------------------------------------------

	/**
	 * load by id
	 * @param unknown $id
	 */
    public function load($id){
        $this->db->select("*");
        $this->db->from("corporation_cooperation");
        $this->db->where("id",$id);
        $query = $this->db->get();
        return $query->row_array();
    }

	// --------------------------------------------------------------------

    /**
     * 插入新商务合作申请纪录
     */
    public function create(){
        
        $datetime = date('Y-m-d H:i:s');
        $app_id = $this->session->userdata("app_info")["id"];
		$this->db->set ( 'customer_id', $this->customer_id );
		$this->db->set ( 'corporation_name', $this->corporation_name );
		$this->db->set ( 'corporation_type', $this->corporation_type );
		$this->db->set ( 'mobile', $this->mobile );
		$this->db->set ( 'applicant_name', $this->applicant_name );
		$this->db->set ( 'applicant_duty', $this->applicant_duty );
		$this->db->set ( 'coo_direction', $this->coo_direction );
		$this->db->set ( 'remarks', $this->remarks );
		$this->db->set ( 'status', $this->status );
		$this->db->set ( 'created_at', $datetime );
		$this->db->set ( 'app_id', $app_id );
        $this->db->insert("corporation_cooperation");
        
        error_log($this->db->last_query());
        
        return $this->db->insert_id();
    }
    
	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------



	// --------------------------------------------------------------------


}