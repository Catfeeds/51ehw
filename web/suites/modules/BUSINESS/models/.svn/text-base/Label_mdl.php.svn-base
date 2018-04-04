<?php 


/**
	标签模型
*/
	
class Label_mdl extends CI_Model
{

	// 获取标签
	public function get_label($like='')
	{
		$this->db->select('name');
		$this->db->select('id');
		if($like){
			$this->db->like('name', $like);	
		}
		$this->db->from('label');
		$result = $this->db->get();
		return $result->result_array();
	}


	// 获取用户关注的标签
	public function get_customer_label($customer_id)
	{
		$this->db->select('l.id');
		$this->db->select('l.name');
		$this->db->from('label as l');
		$this->db->join('customer_label as cl', 'cl.label_id=l.id');
		$this->db->where('cl.customer_id', $customer_id);
		$result = $this->db->get();
		// echo $this->db->last_query();
		return $result->result_array();

	}

	 // 添加关注标签
	// public function add_customer_label($data,$customer_id=null)
	// {	

		//查询$customer_id所有关注的标签id
		// $this->db->select('label_id');
		// $this->db->where('customer_id',$customer_id);
		// $customer_label_ids = $this->db->get('customer_label')->result_array();

		// $customer_label_id = [];
		// foreach($customer_label_ids as $val){
		// 	$customer_label_id[] = $val['label_id'];
		// }
		// $one_label_count = count($customer_label_id);

		// $current_label_id = [];
		// foreach($data as $val){
		// 	$current_label_id[] = $val['label_id'];
		// }


		// //添加
		// $array_label1 = array_diff($current_label_id,$customer_label_id);
		// if($array_label1){
		// 		$array_insert = [];
		// 		foreach($array_label1 as $val){
		// 			$array_insert[] = ['customer_id'=> $customer_id,'label_id'=>$val];
		// 		}
		// 		$this->db->insert_batch('customer_label',$array_insert);
		// 		$affected_rows = $this->db->affected_rows();
		// }

		// // 删除
		// $array_label2 = array_diff($customer_label_id,$current_label_id);

		// if($array_label2){
		// 	$array_insert = [];
		// 	foreach($array_label2 as $val){
		// 		$array_insert[] = $val;
		// 	}
		// 	$this->db->where('customer_id',$customer_id);
		// 	$this->db->where_in('label_id',$array_insert);
		// 	$this->db->delete('customer_label');
		// 	$affected_rows = $this->db->affected_rows();
		// }
	/**
	* 获取需求标签id
	*/
	public function get_demand_label($id)
	{
		$this->db->where("requirement_id", $id);
		return $this->db->get("requirement_label")->result_array();
	}

	

	//批量删除标签  
	public function del_batch_label($data){
	    $customer_id = $this->session->userdata('user_id');
	    $this->db->where('customer_id',$customer_id);
	    $this->db->where_in('label_id',$data);
	    $this->db->delete('customer_label');
	    $affected_rows = $this->db->affected_rows();
	}
	

	//批量添加标签
	public function  insert_batch_label($data){
	    $this->db->insert_batch('customer_label',$data);
	    $affected_rows = $this->db->affected_rows();
	}


	// 获取用户关注标签
	public function follow_customer_label($customer_id){
		$this->db->select('label_id');
		$this->db->where('customer_id', $customer_id);
		$this->db->from('customer_label');
		$result = $this->db->get()->result_array();
		
		return $result;

	}
}	
