<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orderservice extends Api_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('order_service_mdl');
// 		$this->load->model('category_mdl');
	}
	
	
	public function index()
	{
		echo 'OrderService API';
	}
	//获取订单列表
	public function getOrderServiceList()
	{
		//获取参数
		$prams = $this->p;
		$return = $this->return;
		$page = $this->n;
		$return['data'] = array('perpage'=>0,'currentpage'=>0,'totalpage'=>0,'totalcount'=>0,'listdate'=>array());
		
		//检验参数
		//$this->_check_prams($prams,array('userid'));
		
		//$user_id = $prams['userid'];

		$user_id = $this->session->userdata('user_id');
		if($user_id == null || $user_id=="")
		{
			//$return['responseMessage'] = array('messageType'=>'error','errorType'=>'5','errorMessage'=>'用户未登录');
				//print_r(json_encode($return));
				//exit();
				$user_id = 340;
		}

		$options = array();
		if(isset($prams['status']))
			$options['status'] = $prams['status'];
		
		$options['order'] = $page['orderBy'];
		
		$totalcount = $this->order_service_mdl->count_orders($user_id,$options);	//获取总记录数
		$perPage = $page['perPage'];										//每页记录数
		$currPage = $page['currPage'];										//当前页
		$offset = ($currPage-1)*$perPage;									//偏移量
		$totalpage = $perPage?ceil($totalcount/$perPage):1;					//总页数
		
		$listdate = $this->order_service_mdl->findOrderServices($user_id, $options, $perPage,$offset);

		foreach ($listdate as $k=>$v)
		{

			$listdate[$k]['statusname'] = $this->_status($v['status']);
			//echo "44444";
			$listdate[$k]['skunmae'] = $this->order_service_mdl->getSkuName($v["sku_id"]);
			$listdate[$k]['senddate'] = $this->order_service_mdl->getSendDate($v["product_id"],$v["sku_id"]);

		}

		
		
		//返回数据
		$return['data']['perpage'] = $perPage;
		$return['data']['currentpage'] = $currPage;
		$return['data']['totalcount'] = $totalcount;
		$return['data']['totalpage'] = $totalpage;
		$return['data']['listdate'] = $listdate;
		
// 		print_r($return);
		print_r(json_encode($return));
	}


	private function _status($status)
	{
		switch ((int)$status){
			case 1 : return '正在进行';break;
			case 2 : return '已暂停';break;
			case 3 : return '已完成';break;

			default : return ''; 
		}
	}


		/**
	*修改订单状态
	*/
	public function updateServiceStatus()
	{
		$prams = $this->p;
		$return = $this->return;
		//检验参数
		$this->_check_prams($prams,array('serviceid','status'));

		$user_id = $this->session->userdata('user_id');
		if($user_id == null || $user_id=="")
		{
			//$return['responseMessage'] = array('messageType'=>'error','errorType'=>'5','errorMessage'=>'用户未登录');
			//print_r(json_encode($return));
			//exit();
				$user_id = 340;
		}

		$serviceid = $prams['serviceid'];
		$status = $prams['status'];

		if($status == '1' || $status == '2')
		{
			if($this->order_service_mdl->updateStatus($user_id,$serviceid,$status))
			{
				$return['responseMessage'] = array('messageType'=>'success','errorType'=>'0','errorMessage'=>'状态修改成功！');
			}else
			{
				 $return['responseMessage'] = array('messageType'=>'error','errorType'=>'8','errorMessage'=>'状态修改失败！');
			}



		}
		else
		{
			$return['responseMessage'] = array('messageType'=>'error','errorType'=>'7','errorMessage'=>'状态格式不正确');
			
		}
		




		print_r(json_encode($return));


	}


	public function getServiceDetail()
	{
	
		//获取参数
		$prams = $this->p;
		$return = $this->return;
		
		//检验参数
		$this->_check_prams($prams,array('serviceid'));
		$serviceid = $prams["serviceid"];


		//查询出订单的状态
		$service = $this->order_service_mdl->load($serviceid);
		//查询套餐列表
		//print_r($service);
		$temp_skuList = $this->order_service_mdl->getSKUList($service["product_id"]);
		$skuList = array();
		$sku_id = 0;
		$skuname = "";
		foreach($temp_skuList as $sku)
		{
			if($sku_id == 0)
			{
				$sku_id = $sku["val_id"];
			}
			if($sku_id !=0 && $sku_id != $sku["val_id"])
			{
				array_push($skuList,array("sku_name"=>$skuname,"sku_id"=>$sku_id));
				$sku_id = $sku["val_id"];
				$skuname = $sku["sku_name"];
			}else
			{
				$skuname = $skuname ."	".$sku["sku_name"];
			}
		}
		if(count($temp_skuList)>0)
		{
			array_push($skuList,array("sku_name"=>$skuname,"sku_id"=>$sku_id));
		}




		//需要处理重复
		$serviceskuList = $this->order_service_mdl->getServiceSKU($service["product_id"]);

		$sku_id = 0;
		$serviceLists = array();
		foreach($serviceskuList as $ss)
		{
			if($sku_id == 0)
			{
				$sku_id = $ss["sku_id"];
			}
			if($sku_id !=0 && $sku_id != $ss["sku_id"])
			{

				foreach($skuList as $key=>$s)
				{
					if($s["sku_id"]== $sku_id)
					{
						$skuList[$key]["serviceList"] = $serviceLists;
						break;
					}
				}

				$serviceLists = array();
				$sku_id = $ss["sku_id"];
				$serviceLists[0] = $ss;

			}else
			{

				array_push($serviceLists,$ss);
			}
		}

		if(count($serviceskuList)>0)
		{

			foreach($skuList as $key=>$s)
			{
				if($s["sku_id"]== $sku_id)
				{
					$skuList[$key]["serviceList"] = $serviceLists;
					break;
				}
			}
		}

		$return['data']["serviceInfo"] = $service;
		$return['data']["serviceListInfo"] = $skuList;
		
		print_r(json_encode($return));

		////查询最后一次送货
		//$lastsend = $this->order_service_mdl->getLastDetail($serviceid);
		//if($lastsend)
		//{
		
		//}

	
	}


	//修改服务套餐
	public function updateServiceSKU()
	{
		//获取参数
		$prams = $this->p;
		$return = $this->return;
		
		//检验参数
		$this->_check_prams($prams,array('serviceid',"oldsku_id","newsku_id","product_id"));
		$serviceid = $prams["serviceid"];
		$sku_id = $prams["oldsku_id"];
		$newsku_id = $prams["newsku_id"];
		$product_id = $prams["product_id"];


		//判断是否可以改
		$result = $this->order_service_mdl->getServiceSKU($product_id,$sku_id,1);

		if(count($result)>0){
			//echo strtotime($result[0]["saledate"])."*****".time()."^^^^".(strtotime($result[0]["saledate"])-time());
			if(strtotime($result[0]["saledate"])-time()>86400)
			{
				//update
				$this->order_service_mdl->updateServiceSku($serviceid,$newsku_id);
				 $return['responseMessage'] = array('messageType'=>'success','errorType'=>'0','errorMessage'=>'修改完成！');
			}
			else
			{
				 $return['responseMessage'] = array('messageType'=>'error','errorType'=>'9','errorMessage'=>'已在配货中，不能修改！');
			}
		}
		else
		{
			//error
			 $return['responseMessage'] = array('messageType'=>'error','errorType'=>'10','errorMessage'=>'新套餐没有完成，不能修改！');
		}
		print_r(json_encode($return));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */