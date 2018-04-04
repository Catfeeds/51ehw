<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');


    class Test extends Front_Controller{
	/**
	* @author JF
	* 2017年11月9日
	* 执行sql
	*/
	function sql(){
		$sql = $this->input->get_post("sql");
		$type = $this->input->get_post("type");
		$query = $this->db->query($sql);
		if($type == "list"){
			$result = $query->result_array();
		}else if($type == "num"){
			$result = $query->num_rows();
		}else if($type == "row"){
			$result = $query->row_array();
		}else if($type == "affected"){
			$result = $this->db->affected_rows();
		}
		echo "<pre>";
		print_r($result);exit;
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */