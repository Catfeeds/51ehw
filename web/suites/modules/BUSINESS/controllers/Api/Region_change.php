<?php
/**
 * 地区三级联动
 *
 *
 */
class Region_change extends Api_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->model("region_mdl");
    }
    
	// --------------------------------------------------------------------
	
    
	/**
	 * 查询全部二级联动
	 */
	function second_level(){
		$return = $this->return;
	    $return["data"]["AddressList"]  = $this->region_mdl->second_level(array(1,2));
	    echo json_encode($return);
	}

}