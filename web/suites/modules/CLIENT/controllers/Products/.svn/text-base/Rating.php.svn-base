<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rating extends Front_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 点赞
	 * @param unknown $product_id
	 */
	public function add_rating($product_id){
		$customer_id = $this->session->userdata('user_id');
		$this->load->model('product_rating_mdl');
		
		$rating = array(
				'customer_id' => $customer_id,
				'product_id' => $product_id,
				'rating_date' => date('y-m-d')
		);
		
		if($this->product_rating_mdl->add_rating($rating)){
			echo "点赞成功！";
		}else{
			echo "点赞失败！";
		}
	}
}
?>