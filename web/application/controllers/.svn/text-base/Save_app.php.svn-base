<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class save_app extends Front_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('save_mdl');
		$this->load->helper('cookie');
	}
	
	
	public function index()
	{
		redirect(site_url('save_app/getSaveList'));
	}
	
	//存酒列表
	public function getSaveList($userid =0,$sessionid,$app_type='android')
	{
		if($sessionid)
		{
			$list = $this->save_mdl->getSaveList($userid);

			$data["list"] = $list;
			
			$data["count"] = $this->save_mdl->getTotal($userid);
			$data["userid"] = $userid;
			$data["sessionid"] = $sessionid;
			$data["app_type"] = $app_type;
			$this->load->view('app/winestorage',$data);
			
			//echo "55555";
		}
		
	}
	
	//消费列表
	public function getUseList($userid=0,$sessionid,$app_type='android')
	{
		
		if($sessionid)
		{
			$list = $this->save_mdl->getUserList($userid);
			$data["list"] = $list;
			$data["count"] = $this->save_mdl->getTotal($userid);
			$data["userid"] = $userid;
			$data["sessionid"] = $sessionid;
			$data["app_type"] = $app_type;
			$this->load->view('app/consumerrecords',$data);
		}
	}

	
	//赠送列表
	public function getGiftList($userid=0,$sessionid,$app_type='android')
	{
		
		if($sessionid)
		{
			$list = $this->save_mdl->getGiftList($userid);
			$data["list"] = $list;
			$data["count"] = $this->save_mdl->getTotal($userid);
			$data["userid"] = $userid;
			$data["sessionid"] = $sessionid;
			$data["app_type"] = $app_type;
			$this->load->view('app/getrecords',$data);
		}
	}
	
	//客户资料
	public function  customerdataforapp($userid,$session)
 	{
		echo('bbbb');
 		exit();
		if($userid)
		{
			$like = array();
			$condition = array();
			$username = $this->input->get_post("username");
			if($username && $username!= "")
			{
				$like["name"] = $username;
			}

			$this->load->model('customer_mdl');
			$data["userid"] = $userid;
			$data["session"] = $session;
			$data["username"] = $username;
			$data["result"] = $this->customer_mdl->getChildList(1,$userid,$condition,$like);
			
			$this->load->view('app/customerdata',$data);
		}
		
 	}
 	
 	public function updateCustomerRebate()
	{

		$userid = $this->input->get_post('fuserid');
		if($userid)
		{
					
			//$data["id"] = $this->input->get_post('userid');
			$data["parent_shared"] = $this->input->get_post('rebate');
			
			$maxrate = $this->customer_mdl->getUserRebate($userid);
			//echo $maxrate;
			
			if($data["parent_shared"]>$maxrate)
			{
				echo json_encode("false_".$maxrate);
				return;
			}
			
			$i = $this->customer_mdl->updateByCondition($data,array("parent_id"=>$userid,"id"=>$this->input->get_post('userid')));

			$msg = "success";
		}else
		{
			$msg = "false";
			
			 //redirect('customer/login');
		}
		echo json_encode($msg);
		
	}
}