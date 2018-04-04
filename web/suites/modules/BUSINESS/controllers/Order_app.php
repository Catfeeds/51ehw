<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_app extends Front_Controller {

	public function __construct()
	{
		parent::__construct();
		//判断用户是否登录
		
// 		//判断购物车是否有商品
// 		$this->load->library('cart');
// 		if (!$this->cart->total_items()){
// 			redirect('home');
// 			exit();
// 		}
		$this->load->helper('order');
	}
	

	
	public function consignee()
	{
		$data =array();
		$this->load->view('order/consignee_edit',$data);
	}
	
	/**
	 * 完成所有订单操作，提交到数据库
	 *
	 *
	 */

	
	//订单支付页面
	public function order_pay($order_id=0,$user_id=0)
	{
		
		if(!$order_id)
		{
			redirect('customer');
		}

		$this->load->model('order_mdl');
		//$user_id = $this->session->userdata('user_id');
		$order = $this->order_mdl->load($order_id);
		
		
		//不是自己的订单
		if($order['customer_id']!=$user_id)
		{
			redirect('customer');
		}
		

		$this->load->model('order_delivery_mdl');
		$this->load->model('region_mdl');
		$order_delivery = $this->order_delivery_mdl->load($order_id);
		
// 		print_r($order_delivery);
// 		exit();

		$data['order_sn'] = $order['order_sn'];
		$data['total_price'] = $order['total_price'];
		$data['order_id'] = $order['id'];//$new_order_id;
		$data['consignee'] =$order_delivery['consignee'];
		$data['contact_mobile'] =$order_delivery['contact_mobile'];
		$data['contact_phone'] =$order_delivery['contact_phone'];
		
		$province = $this->region_mdl->get_name($order_delivery['province_id']);
		$city = $this->region_mdl->get_name($order_delivery['city_id']);
		$district = $this->region_mdl->get_name($order_delivery['district_id']);
		
		$data['address'] =$province.'省'.$city.'市'.$district.' '. $order_delivery['address'];
		
		$data['is_app'] = "app";
		
		$this->load->view('order/pay',$data);
	}
	
	
	
	//保存支付方式并跳至支付页面
	public function save_pay()
	{
		/*$order_id = $this->input->post('order_id');//获取订单
		$payment_id = $this->input->post('payment_id');//获取支付方式

		
		$this->load->model('order_mdl');
		$user_id = $this->session->userdata('user_id');
		//获取订单信息
		$order = $this->order_mdl->load($order_id);
		//检验订单，检验支付方式
		if($order['customer_id']!=$user_id)
		{
			redirect('customer');
		}
		
		//获取用户资料
		$this->load->model('customer_mdl');
		$customer = $this->customer_mdl->load($this->session->userdata('user_id'));
		
		/*获取订单商品 * /
		$this->load->model('order_item_mdl');
		$order_item = array_shift($this->order_item_mdl->find_order_items($order['id'],1));
		
		//获取订单信息
// 		print_r(array_shift($order_items));
// 		echo date("YmdHis",$order['place_at']);
// 		exit();
		
		//获取支付接口信息
		$pay = array();
		$pay['bgUrl'] = "httpL//103.14.146.146/";//"http://219.233.173.50:8802/futao/rmb_demo/recieve.php";
		$pay['orderTime'] = $order['place_at']; 
		$pay['orderId'] = $order['order_sn'];
		$pay['orderAmount'] = $this->_convert_yuan_to_fen($order['total_price']);
		$pay['payerName'] =$customer['name'];
		
		$pay['productName'] = $order_item['product_name'];
		$pay['productNum'] = $order_item['quantity'];
		$pay['productId'] = $order_item['id'];
		
		$pay['payerContactType'] = '1';
		$pay['payerContact'] = $customer['email'];
		
		
		//跳转支付页面
// 		redirect('payment/bill');
		$this->send($pay);*/
		
		
		#商户编号p1_MerId,以及密钥Key
		$merchant_id = "80140311172356932106";
		$key = "433a63646a514606a9d25f01971fe330";
		$req_url = "http://bank.kuaiyinpay.com/Payment";
		$refund_url = "http://payment.kuaiyinpay.com/kuaiyinAPI/refundOrder/kuaiYinOrderId/";
		$query_url  = "http://payment.kuaiyinpay.com/kuaiyinAPI/inquiryOrder/merchantOrderId/";
		$refundquery_url = "http://payment.kuaiyinpay.com/kuaiyinAPI/inquiryRefundOrder/kuaiYinOrderId/";
		
		$kypay = array();
		#目前网关版本固定为1.0.0
		$kypay['version']      = '1.0.0';
		#银行代码 招商银行CMB
		$kypay['bank_code']    = $_REQUEST['bank_code'];
		#支付金额 精确到小数点后两位，如0.10,10.00
		$kypay['amount']       = $_REQUEST['amount'];
		#商户ID
		$kypay['merchant_id']  = $merchant_id;
		#订单时间 格式为：yyyyMMddHHmmss
		$kypay['order_time']   = date('YmdHis');
		#商户生成该订单号并上送快银，唯一标识该笔订单
		$kypay['order_id']     = $_REQUEST['order_id'];
		#商户用于接收支付结果通知的一个URL地址
		$kypay['merchant_url'] = $_REQUEST['merchant_url'];//交易结果回调页面（推荐使用IP形式）
		
		#自定义字段
		$kypay['cust_param']   = $_REQUEST['cust_param'];

		#去除数组中值为空的数据(参数为空时，不参与签名。)
		$sign_kypay = array_diff($kypay, array(''));
		ksort($sign_kypay);
		$str_sign = '';
		foreach($sign_kypay as $k=>$v){
			$str_sign .=$k.'='.$v.'&';
		}
		
		$sign_msg  = md5(urlencode($str_sign.'key='.$key)); 
		
		#拼接要传送的数据
		$ky_str = '';
		foreach($kypay as $k=>$v){
			$ky_str .=$k.'='.$v.'&';
		}
		$ky_pay_str  = $ky_str.'sign_msg='.$sign_msg;

 		#打开连接 ,需开启curl服务插件
		$ch = curl_init() ;  
		#设置url,post的数据类型，post的值
		curl_setopt($ch, CURLOPT_URL,$req_url) ;  
		#启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_POST,count($ky_pay_str));
		curl_setopt($ch, CURLOPT_AUTOREFERER,1);
		#在HTTP中的"POST"操作。如果要传送一个文件，需要一个@开头的文件名  
		curl_setopt($ch, CURLOPT_POSTFIELDS,$ky_pay_str); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_exec($ch);
		curl_close($ch); 
		exit();
	}
	
	//支付返回
	public function afterpay($order_sn = 0){
		
		#商户编号p1_MerId,以及密钥Key
		$merchant_id = "80140311172356932106";
		$key = "433a63646a514606a9d25f01971fe330";
		$req_url = "http://bank.kuaiyinpay.com/Payment";
		$refund_url = "http://payment.kuaiyinpay.com/kuaiyinAPI/refundOrder/kuaiYinOrderId/";
		$query_url  = "http://payment.kuaiyinpay.com/kuaiyinAPI/inquiryOrder/merchantOrderId/";
		$refundquery_url = "http://payment.kuaiyinpay.com/kuaiyinAPI/inquiryRefundOrder/kuaiYinOrderId/";
		
		#订单金额
		$ky_back['order_amount']     = $_REQUEST['order_amount'];
		#商户订单号
		$ky_back['order_id']         = $_REQUEST['order_id'];
		#快银订单号
		$ky_back['kuaiyin_order_id'] = $_REQUEST['kuaiyin_order_id'];
		#订单提交时间
		$ky_back['order_time']       = $_REQUEST['order_time'];
		#实际支付金额
		$ky_back['paid_amount']      = $_REQUEST['paid_amount'];
		#交易流水号
		$ky_back['deal_id']          = $_REQUEST['deal_id'];
		#订单的结账日期
		$ky_back['account_date']     = $_REQUEST['account_date'];
		#快银交易处理时间
		$ky_back['deal_time']        = $_REQUEST['deal_time'];
		#支付结果
		$ky_back['result']           = $_REQUEST['result'];
		#返回错误代码
		$ky_back['code']             = $_REQUEST['code'];
		#银行订单号
		$ky_back['bank_order_id']    = $_REQUEST['bank_order_id'];
		#自定义字段
		$ky_back['cust_param']       = $_REQUEST['cust_param'];
		#商户编号
		$ky_back['merchant_id']      = $merchant_id;
		#版本号
		$ky_back['version']          = '1.0.0';
		#返回验证签名
		$signMsg         = $_REQUEST['signMsg'];
	
		#md5加密
		#快银网络密钥
		$sign_kypay = array_diff($ky_back, array(''));
		ksort($sign_kypay);
		$str_sign = '';
		foreach($sign_kypay as $k=>$v){
			$str_sign .=$k.'='.$v.'&';
		}
		
		$back_signMsg  = strtoupper(md5(urlencode($str_sign.'key='.$key))); 

		#	签名正确.
		if($back_signMsg == $signMsg){	
			if($ky_back['result']=="Y"){//只有result=Y时才进行数据的处理
			#	需要比较返回的金额与商家数据库中订单的金额是否相等，只有相等的情况下才认为是交易成功.
			#	并且需要对返回的处理进行事务控制，进行记录的排它性处理，在接收到支付结果通知后，判断是否进行过业务逻辑处理，不要重复进行业务逻辑处理，防止对同一条交易重复发货的情况发生.
			#   判断您平台的数据是否已经处理过了，已处理则无需再处理，以免造成重复处理。
				#成功处理完您的平台数据后，向快银支付输出如下内容，把www.kuaiyinpay.com改成您平台的支付结果url
				
				$this->load->model('order_mdl');
				
				$this->order_mdl->order_paid($order_sn);
				
				echo '0000|http://www.wjhgw.com/index.php/order/afterpay/'.$order_sn;
			}
			
		}else{
			#失败处理完后，向快银支付输出如下内容，把www.kuaiyinpay.com改成您平台的支付结果url
			echo "9999|http://www.wjhgw.com/index.php/order/afterpay/".$order_sn;
		}	
	}
	
	private function send(array $order)
	{
		if( ! is_array($order) OR count($order) == 0)
		{
			redirect(site_url("home"));
		}
		
		//人民币网关账号，该账号为11位人民币网关商户编号+01,该参数必填。
		$merchantAcctId = "1001213884201";
		//编码方式，1代表 UTF-8; 2 代表 GBK; 3代表 GB2312 默认为1,该参数必填。
		$inputCharset = "1";
		//接收支付结果的页面地址，该参数一般置为空即可。
		$pageUrl = "";
		//服务器接收支付结果的后台地址，该参数务必填写，不能为空。
		$bgUrl = $order['bgUrl'];//"http://219.233.173.50:8802/futao/rmb_demo/recieve.php";
		//网关版本，固定值：v2.0,该参数必填。
		$version =  "v2.0";
		//语言种类，1代表中文显示，2代表英文显示。默认为1,该参数必填。
		$language =  "1";
		//签名类型,该值为4，代表PKI加密方式,该参数必填。
		$signType =  "4";
		//支付人姓名,可以为空。
		$payerName= $order['payerName'];
		//支付人联系类型，1 代表电子邮件方式；2 代表手机联系方式。可以为空。
		$payerContactType =  $order['payerContactType'];
		//支付人联系方式，与payerContactType设置对应，payerContactType为1，则填写邮箱地址；payerContactType为2，则填写手机号码。可以为空。
		$payerContact =  $order['payerContact'];
		//商户订单号，以下采用时间来定义订单号，商户可以根据自己订单号的定义规则来定义该值，不能为空。
		$orderId = $order['orderId'];
		//订单金额，金额以“分”为单位，商户测试以1分测试即可，切勿以大金额测试。该参数必填。
		$orderAmount = $order['orderAmount'];
		//订单提交时间，格式：yyyyMMddHHmmss，如：20071117020101，不能为空。
		$orderTime = date("YmdHis",strtotime($order['orderTime']));//date("YmdHis");
		//商品名称，可以为空。
		$productName= $order['productName'];
		//商品数量，可以为空。
		$productNum = $order['productNum'];
		//商品代码，可以为空。
		$productId = $order['productId'];
		//商品描述，可以为空。
		$productDesc = "";
		//扩展字段1，商户可以传递自己需要的参数，支付完快钱会原值返回，可以为空。
		$ext1 = "";
		//扩展自段2，商户可以传递自己需要的参数，支付完快钱会原值返回，可以为空。
		$ext2 = "";
		//支付方式，一般为00，代表所有的支付方式。如果是银行直连商户，该值为10，必填。
		$payType = "00";
		//银行代码，如果payType为00，该值可以为空；如果payType为10，该值必须填写，具体请参考银行列表。
		$bankId = "";
		//同一订单禁止重复提交标志，实物购物车填1，虚拟产品用0。1代表只能提交一次，0代表在支付不成功情况下可以再提交。可为空。
		$redoFlag = "";
		//快钱合作伙伴的帐户号，即商户编号，可为空。
		$pid = "";
		// signMsg 签名字符串 不可空，生成加密签名串
	
		function kq_ck_null($kq_va,$kq_na){if($kq_va == ""){$kq_va="";}else{return $kq_va=$kq_na.'='.$kq_va.'&';}}
	
	
		$kq_all_para=kq_ck_null($inputCharset,'inputCharset');
		$kq_all_para.=kq_ck_null($pageUrl,"pageUrl");
		$kq_all_para.=kq_ck_null($bgUrl,'bgUrl');
		$kq_all_para.=kq_ck_null($version,'version');
		$kq_all_para.=kq_ck_null($language,'language');
		$kq_all_para.=kq_ck_null($signType,'signType');
		$kq_all_para.=kq_ck_null($merchantAcctId,'merchantAcctId');
		$kq_all_para.=kq_ck_null($payerName,'payerName');
		$kq_all_para.=kq_ck_null($payerContactType,'payerContactType');
		$kq_all_para.=kq_ck_null($payerContact,'payerContact');
		$kq_all_para.=kq_ck_null($orderId,'orderId');
		$kq_all_para.=kq_ck_null($orderAmount,'orderAmount');
		$kq_all_para.=kq_ck_null($orderTime,'orderTime');
		$kq_all_para.=kq_ck_null($productName,'productName');
		$kq_all_para.=kq_ck_null($productNum,'productNum');
		$kq_all_para.=kq_ck_null($productId,'productId');
		$kq_all_para.=kq_ck_null($productDesc,'productDesc');
		$kq_all_para.=kq_ck_null($ext1,'ext1');
		$kq_all_para.=kq_ck_null($ext2,'ext2');
		$kq_all_para.=kq_ck_null($payType,'payType');
		$kq_all_para.=kq_ck_null($bankId,'bankId');
		$kq_all_para.=kq_ck_null($redoFlag,'redoFlag');
		$kq_all_para.=kq_ck_null($pid,'pid');
	
	
		$kq_all_para=substr($kq_all_para,0,strlen($kq_all_para)-1);
	
		/////////////  RSA 签名计算 ///////// 开始 //
	
		// 		echo MYSHOP_SHARE_PATH.'libraries/payment/99bill/pcarduser.pem';
		/*$fp = fopen(MYSHOP_SHARE_PATH.'libraries/payment/99bill/pcarduser.pem', "r");
		$priv_key = fread($fp, 123456);
		fclose($fp);
		$pkeyid = openssl_get_privatekey($priv_key);
	
		// compute signature
		openssl_sign($kq_all_para, $signMsg, $pkeyid,OPENSSL_ALGO_SHA1);
	
		// free the key from memory
		openssl_free_key($pkeyid);
	
		$signMsg = base64_encode($signMsg);*/
		/////////////  RSA 签名计算 ///////// 结束 //
	
	
		$this->load->library('request');
		$request_url = 'http://bank.kuaiyinpay.com';
		$post_string = array(
				'inputCharset'=>$inputCharset,
				'pageUrl'=>$pageUrl,
				'bgUrl'=>$bgUrl,
				'version'=>$version,
				'language'=>$language,
				'signType'=>$signType,
				'signMsg'=>$signMsg,
				'merchantAcctId'=>$merchantAcctId,
				'payerName'=>$payerName,
				'payerContactType'=>$payerContactType,
				'payerContact'=>$payerContact,
				'orderId'=>$orderId,
				'orderAmount'=>$orderAmount,
				'orderTime'=>$orderTime,
				'productName'=>$productName,
				'productNum'=>$productNum,
				'productId'=>$productId,
				'productDesc'=>$productDesc,
				'ext1'=>$ext1,
				'ext2'=>$ext2,
				'payType'=>$payType,
				'bankId'=>$bankId,
				'redoFlag'=>$redoFlag,
				'pid'=>$pid
		);
	
		$this->request->request_by_jsfrom($request_url,$post_string);
	
	}
	
	private function _convert_yuan_to_fen($price)
	{
	
		$intTmp = intval(round($price * 100));
	
		return $intTmp;
	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */