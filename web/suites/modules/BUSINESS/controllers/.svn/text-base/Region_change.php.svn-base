<?php
/**
 * 地区三级联动
 *
 *
 */
class Region_change extends Front_Controller
{
	function __construct()
    {
        parent::__construct();
    }
    
	// --------------------------------------------------------------------

    /**
	 * 根据ajax反馈的父id，返回所有子集 （json格式）
	 *
	 *  
	 */	
	function select_children()
	{
	    $parent_id = $this->input->post("parent_id");
		$this->load->model('region_mdl');
		$data['children']   = $this->region_mdl->children_of($parent_id);
		echo json_encode($data['children']);		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 查询全部二级联动
	 */
	function second_level(){
	    $this->load->model('region_mdl');
	    $address  = $this->region_mdl->second_level(array(1,2));
	    echo json_encode($address);
	}

}