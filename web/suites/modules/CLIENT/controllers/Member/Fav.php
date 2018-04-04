<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fav extends Front_Controller {
	
	public function __construct()
	{
		parent::__construct();
		// 判断用户是否登录
		if (!$this->session->userdata('user_in')){
			$this->session->set_userdata ( 'redirect', current_url () );
			redirect ( 'customer/login' );
			exit ();
		}
		// 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && !$this->session->userdata("mobile_exist")) {
            $customer_id = $this->session->userdata("user_id");
            $this->load->model("customer_mdl");
            $customer = $this->customer_mdl->load($customer_id);
            
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
		$this->load->model('favourites_mdl');
		
	}
	
	
	public function index()
	{
		//商品详情
		$data['lists'] = $this->favourites_mdl->fav_product_list($this->session->userdata('user_id'));
		
		$data['corporation'] = $this->favourites_mdl->fav_corp_list($this->session->userdata('user_id'));
		
		$data['title'] = '我的收藏';
		$data['back'] = "member/info";
		$data['foot_set'] = 1;
		
		if(count($data['corporation']) ==0 && count($data['lists']) ==0){
		    $data['head_set'] = 2;
		}else{
		    $data['head_set'] = 9;
		}
		$data['submit_type'] = "fav";
		
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view('customer/myfav',$data);
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	} 
	
	//ajax 收藏
	public function ajax_add()
	{
		$pid = $this->input->post('pid');
		$this->load->model('goods_mdl');
		$product = $this->goods_mdl->get_by_id($pid);
		$user_id = $this->session->userdata('user_id');
		if (empty($product)){
			echo 'fail';
			exit();
		}
		
		if($this->favourites_mdl->_check_fav($pid))
		{
		    //取消收藏
			if($this->favourites_mdl->deletefav($product['id'],$user_id)){
		          echo 'del_ok';
		    }else{
		          echo 'del_fail';
		    }
		}else{
		        $data = array();
			    $data[] = array(
    	        'customer_id'=>$user_id,
    	        'product_id'=>$product['id'],
    	        'product_name'=>$product['name'],
    	        'price'=>$product['vip_price'],
    	        'goods_thumb'=>$product['goods_thumb']
                );
			
			if($this->favourites_mdl->add_fav($data,$user_id))
			{
				echo 'add_ok';
			}else{
				echo 'add_fail'; 
			}
		}
		
	}
	
	/**
	 * 取消收藏
	 * @param $pid 商品id
	 */
	public function delete($pid=0)
	{ 
		if(!$pid)
		{
			redirect('member/fav');
			exit();
		}

		$this->favourites_mdl->deletefav($pid,$this->session->userdata('user_id'));
		redirect('member/fav');

	}
	
	/**
	 * Ajax删除收藏夹商品
	 */
	public function ajax_delete()
	{
        $id = $this->input->post('id');
        
        $msg = array(
            'Result' => false
        );
        
        if (! $id) {
            echo json_encode($msg);
        }
        
        if ($this->favourites_mdl->deletefav($id, $this->session->userdata('user_id'))) {
            $msg = array(
                'Result' => true
            );
        } else {
            $msg = array(
                'Result' => false
            );
        }
        
        echo json_encode($msg);
    }
	
	/**
	 * Ajax移除收藏夹店铺
	 */
	public function ajax_delete_corp()
	{
	    $id = $this->input->post('id');
	
	    $msg = array(
	        'Result' => false
	    );
	
	    if(!$id)
	    {
	        echo json_encode($msg);
	    }
	
	    if($this->favourites_mdl->del_fav_corp($id,$this->session->userdata('user_id')))
	    {
	        $msg = array(
	            'Result' => true
	        );
	    }else{
	        $msg = array(
	            'Result' => false
	        );
	    }
	
	    echo json_encode($msg);
	}
	
	
	
	/**
	 * Ajax检查收藏
	 */
	public function ajax_check()
	{
        $id = $this->input->post('id');
        if (! $id) {
            echo 'false';
            exit();
        }
        if($this->favourites_mdl->_check_fav($id))
        {
			echo 'true';
        }else{
            echo 'false';
        }
    }
	
	/**
	 * 收藏店铺
	 */
	public function store_corporation()
    {
        $corp_id = $this->input->post('pid');
        if (! $corp_id) {
            echo "收藏失败";
            exit();
        }
        $user_id = $this->session->userdata('user_id');
        $this->load->model('goods_mdl');
        if ($this->goods_mdl->check($user_id, $corp_id)) {
            echo '该店铺您已经收藏了';
        } else {
            if ($this->goods_mdl->add_corporation($user_id, $corp_id)) {
                echo "收藏成功";
            } else {
                echo "收藏失败";
            }
        }
    }
	
	/**
	 * Ajax取消收藏店铺
	 */
	public function unfavorite_corporation()
    {
        $msg = array(
            'Result' => true,
            'message' => "取消收藏失败"
        );
        $corporation_id = $this->input->post('corporation_id');
        if (! $corporation_id) {
            echo json_encode($msg);
            exit();
        }
        $customer_id = $this->session->userdata('user_id');
        $this->load->model('goods_mdl');
        $this->load->model('favourites_mdl');
        
        if ($this->goods_mdl->check($customer_id, $corporation_id)) {
            if ($this->favourites_mdl->del_fav_corp_id($corporation_id)) {
                $msg = array(
                    'Result' => true,
                    'message' => "取消收藏成功"
                );
            } else {
                $msg = array(
                    'Result' => true,
                    'message' => "取消收藏失败"
                );
            }
        } else {
            $msg = array(
                'Result' => true,
                'message' => "取消收藏成功"
            );
        }
        echo json_encode($msg);
    }
	
	/**
	 * 取消收藏店铺
	 * @param string $id
	 */
	public function del_store_corporation($id='')
	{
        if (! $id) {
            redirect('member/fav');
            exit();
        }
        $res = $this->favourites_mdl->del_fav_corp($id);
        if ($res) {
            echo true;
        } else {
            redirect('member/fav');
            echo false;
        }
    }
    
	/**
	 * ajax批量收藏商品
	 */
    public function batch_add (){
        $user_id = $this->session->userdata('user_id');
        $pid = $this->input->post('id');
        
        //查询是否收藏过
        $fav_exists = $this->favourites_mdl->_check_fav($pid);
        //去除收藏过的商品
        foreach ($fav_exists as $v){
            unset($pid[array_search($v['product_id'],$pid)]);
        }
        //添加收藏

        if($pid){
            $this->load->model('goods_mdl');
            //查询商品
            $product = $this->goods_mdl->get_by_id($pid,null,1);
            $data = array();
            foreach ($product as $k => $v){
    	        $data[] = array(
    	        'customer_id'=>$user_id,
    	        'product_id'=>$v['id'],
    	        'product_name'=>$v['name'],
    	        'price'=>$v['vip_price'],
    	        'goods_thumb'=>$v['goods_thumb']
                );
            }
            $row = $this->favourites_mdl->add_fav($data,$user_id);
            if($row){
                echo 'ok';
            }else{
                echo 'fail';
            }
        }else{
            echo 'exists';
        }
        
    }
	
}