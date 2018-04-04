<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Charge extends Api_Controller {
    public function __construct()
    {
        parent::__construct();
		$this->load->helper ( 'order' );
		$this->load->model ( "charge_mdl", "charge" );
        $this->load->model("pay_account_mdl", "pay_account");
        $this->load->model("customer_money_log_mdl",'customer_money_log');
        $this->load->model("customer_currency_log_mdl",'customer_currency_log');
    }
    
//现金余额充值货豆
    public function purchase_M()
    {
        //获取参数
        $prams = $this->p;
        $return = $this->return;
    
        //检验参数
        $this->_check_prams($prams,array('m_credit','user_id','pay_passwd'));
    
        $M_credit = $prams['m_credit'];
        $customer_id = $prams['user_id'];
        $pay_passwd = $prams['pay_passwd'];
        
        //检查充值账户与登录账户是否一致
        $user_id = $this->session->userdata('user_id');
        if($user_id != $customer_id)
        {
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'2','errorMessage'=>'充值账户与登录账户不一致');
            print_r(json_encode($return));
            exit;
        }
        
        $url = $this->url_prefix.'Customer/load_pay_account?';
        $info['customer_id'] =$user_id;
        $pay_info =  json_decode($this->curl_do_result($url,$info),true);
       
        //现金余额充值货豆
        $data= array();
        $data['m_credit'] =$M_credit;
        $data['pass'] =$pay_passwd;
        $data['relation_id'] =$pay_info['r_id'];
        $data['port'] = 'C';
        $data['app_id'] =$this->session->userdata("app_info")["id"];
        $url = $this->url_prefix.'Charge/purchase_M?';
        $status =  json_decode($this->curl_do_result($url,$data),true);
       
        
        if($status == 3) { //没有充值账号
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'3','errorMessage'=>'没有充值账号');
            print_r(json_encode($return));
            exit;
        }else if($status == 4){
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'3','errorMessage'=>'充值密码错误');
            print_r(json_encode($return));
            exit;
        }
    
        if($status == 2){
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'2','errorMessage'=>'现金余额不足');
            print_r(json_encode($return));
            exit;
        }
        if($status ==1){
            $return['responseMessage'] = array('messageType'=>'success','errorType'=>'0','errorMessage'=>'');
        }
        print_r(json_encode($return));
    }
    
    /**
     * 生成现金充值订单
     */
    public function chargeSubmit() 
    {
        //获取参数
        $prams = $this->p;
        $return = $this->return;
    
        //检验参数
        $this->_check_prams($prams,array('amount','userid','source'));
        
        $data ['customer_id'] = $prams['userid'];
        $data ["amount"] = $prams['amount'];
        $data ["order_source"] = $prams['source']=="ios"?4:3;//1、PC；2、微信；3、安卓；4、ios
        $data ["payment_id"] = isset($prams['payment_id'])?$prams['payment_id']:2;//1、支付宝；2、微信支付；3、网银在线
        
        do 
        {
            $data ['chargeno'] = get_order_sn ();
            if ($this->charge->load_byChangeNum( $data['chargeno'] ) ) {
                $order_exist = true;
            } else {
                $new_charge_id = $this->charge->create ( $data );
                $order_exist = false;
            }
        } while ( $order_exist ); // 如果是订单号重复则重新提交数据
        //根据获取id取行数据
        $row = $this->charge->load($new_charge_id);
        if(!$row){
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'6','errorMessage'=>'订单生成失败');
            print_r(json_encode($return));
            exit;
        }else{
            if($data["payment_id"]==3){//网银在线，银联支付
            
                foreach ( $row as $key =>$value){
                    $pay_date = str_replace(array("-",":"," "),"",$row['create_date']);
                    $result = $this->unionPay($row['chargeno'],$pay_date,$row['amount']);
                    switch($result['status']){
                        case 0:
                            $return['responseMessage'] = array('messageType'=>'success','errorType'=>'','errorMessage'=>'');
                            $return['data']['txn_time'] = $result['txn_time'];
                            $return['data']['tn'] = $result['tn'];
                            break;
                        case 200:
                            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'200','errorMessage'=>'没收到200应答');
                            break;
                        case 300:
                            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'300','errorMessage'=>'应答报文验签失败');
                            break;
                        case 400:
                            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'400','errorMessage'=>'订单生成失败');
                            break;
                        default:
                            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'500','errorMessage'=>'');
                            break;
                    }
                }
                print_r(json_encode($return));
                exit;
            }
            $return['responseMessage'] = array('messageType'=>'success','errorType'=>'','errorMessage'=>'');
            foreach ( $row as $key =>$value){
                $return['data']['customer_id'] = $row['customer_id'];
                $return['data']['id'] = $row['id'];
                $return['data']['chargeno'] = $row['chargeno'];
                $return['data']['create_date'] = $row['create_date'];
                $return['data']['amount'] = $row['amount'];
            }
            print_r(json_encode($return));
        }
    }
    /**
     * 银联推送订单
     */
    private function unionPay($order_no,$time,$amount){
        header ( 'Content-type:text/html;charset=utf-8' );
        include_once dirname(dirname(__FILE__)).'/Acppay/sdk/acp_service.php';
         
        $params = array(
    
            //以下信息非特殊情况不需要改动
            'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,                   //版本号
            'encoding' => 'utf-8',				  //编码方式
            'txnType' => '01',				      //交易类型
            'txnSubType' => '01',				  //交易子类
            'bizType' => '000201',				  //业务类型
            'frontUrl' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->frontUrl,  //前台通知地址
            'backUrl' =>  com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl,	  //后台通知地址
            'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,	              //签名方法
            'channelType' => '08',	              //渠道类型，07-PC，08-手机
            'accessType' => '0',		          //接入类型
            'currencyCode' => '156',	          //交易币种，境内商户固定156
    
            //TODO 以下信息需要填写
            'merId' => '821610148167412',		//商户代码，请改自己的测试商户号
            'orderId' => $order_no,	//商户订单号，8-32位数字字母，不能含“-”或“_”
            'txnTime' => $time,	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间
            'txnAmt' => $amount * 100,	//交易金额，单位分
        );
        com\unionpay\acp\sdk\AcpService::sign ( $params );
        $url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->appTransUrl;//APP推送订单接口
    
        $result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);
         
        if(count($result_arr)<=0) {
            //没收到200应答的情况
            return array("status"=>200);
        }
    
        if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
            //应答报文验签失败
            return array("status"=>300);
        }
        if ($result_arr["respCode"] == "00"){
            return array('status'=>00,'txn_time'=>$time, 'tn'=>$result_arr["tn"]);
        }else {
            return array('status'=>400,'txn_time'=>$time, 'tn'=>0);
        }
    }
    
    
    /**
     * 生成支付订单
     */
    public function after_Pay() {
    
        //获取参数
        $prams = $this->p;
        $return = $this->return;
    
        //检验参数
        $this->_check_prams($prams,array('charge_id','key'));
        
        $key = $prams['key'];
        $charge_id = $prams['charge_id'];
        
        $user_id = $this->session->userdata('user_id');
		
        $charge = $this->charge->load($charge_id);
        //查询该支付订单是否已经完成的，防止用户刷新重新调用方法
        //如果是已经支付过的 或者取消支付的订单 或者不存在 就返回。
        if(!$charge){
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'8','errorMessage'=>'支付订单不存在');
            print_r(json_encode($return));
            exit;
        }else if($charge['status'] == 1){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '',
                'errorMessage' => ''
            );
//             $return['responseMessage'] = array('messageType'=>'error','errorType'=>'9','errorMessage'=>'订单已支付');
            print_r(json_encode($return));
            exit;
        }else if($charge['status'] == 3 || !$charge){
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'10','errorMessage'=>'订单已取消');
            print_r(json_encode($return));
            exit;
        }

		//等調整後需要修改回來
		if($user_id == 0)
		{
			$user_id = $charge["customer_id"];
		}
        
        //查询该用户的支付账号
        $pay_detailed = $this->pay_account->load($user_id);
        if(!$pay_detailed){
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'11','errorMessage'=>'无支付帐号');
            print_r(json_encode($return));
            exit;
        }

        $chargeno = $charge['chargeno'];
        //订单号解密
        $form = substr($key,0,1);
        $to = substr($key,1,1);
        $keyword = substr($key,2);
        $str = $charge["customer_id"].$charge["id"].$charge["chargeno"].$charge["create_date"];//."9leaf";
        $keystr = substr($str,$form);
        $keystr = substr($keystr,0,strlen($keystr)-$to);
        if($keyword != md5($keystr)){
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'12','errorMessage'=>'key验证码错误');
            print_r(json_encode($return));
            exit;
        }
        //事物执行方法中的MODEL。
        $this->db->trans_begin();
        // 修改订单状态为已支付
        $charge_row = $this->charge->update_pay ( $charge ["id"],'现金充值到账' );
        //该充值订单的金额
        $charge_cash = $charge['amount']; 
        //该用户的支付账号的ID
        $pay_id = $pay_detailed['id']; 
        //关联表的ID
        $pay_relation_id = $pay_detailed['r_id']; 
        //充值前的现金余额
        $cash = $pay_detailed['cash']; 
        //充值成功后帮用户添加现金余额;
        $charge_cash_row = $this->pay_account->charge_cash ($pay_id,$charge_cash);
           
        //上一次用户交易的日志
        $last_cash_log = $this->customer_money_log->load_create_desc($pay_relation_id);
        //上一次平台交易的日志
        $to_last_cash_log = $this->customer_money_log->load_create_desc('-1');
        //平台支出现金日志
        $cash_data['relation_id'] = '-1';
        $cash_data['id_event'] = '68';
        $cash_data['remark'] = '平台支出-现金充值';
        $cash_data['cash'] = $charge_cash;
        $cash_data['charge_no'] = $chargeno;
        $cash_data['beginning_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] : '0.00';
        $cash_data['ending_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] - $charge_cash : - $charge_cash;
        $cash_data['type'] = '2';
        $cash_data['customer_id'] = $user_id;
        $cash_data['status'] = '1';
        
        // 写入现金日志
        $to_cash_log = $this->customer_money_log->add_log($cash_data);
        
        // 检测是否异常
        if (isset($last_cash_log['ending_balance']) && $last_cash_log['ending_balance'] == $cash) {
            $cash_data['status'] = '1';
        } else 
            if (! $last_cash_log && $cash == '0') {
                $cash_data['status'] = '1';
            } else {
                $cash_data['status'] = '2';
            }
        
        // 写入现金日志
        $cash_data['relation_id'] = $pay_relation_id;
        $cash_data['type'] = '1';
        $cash_data['remark'] = '现金充值到账';
        $cash_data['beginning_balance'] = $cash;
        $cash_data['ending_balance'] = $cash + $charge_cash;
        $cash_data['customer_id'] = '-1';
        $cash_log = $this->customer_money_log->add_log($cash_data);
        
        // 事物结束
        if ($charge_row && $charge_cash_row && $cash_log) {
            $this->db->trans_commit();
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '',
                'errorMessage' => ''
            );
        } else {
            $this->db->trans_rollback();
            $status = 3;
        }
        print_r(json_encode($return));
    }
    
    
    
    
    /**
     * 订单现金充值混合支付
     * @param unknown $order_id
     * @param unknown $pay_passwd
     * @param unknown $source
     */
    public function charge_pay(){
        //获取参数
        $prams = $this->p;
        $return = $this->return;
    
        //检验参数
        $this->_check_prams($prams,array('order_id','pay_passwd','source','type'));
    
        $order_id = $prams["order_id"];
        $paypassword = $prams["pay_passwd"];
        $user_id = $this->session->userdata('user_id');
        $type = $prams["type"];
         
        $typeinfo = array(
            'CHR',// 充值支付
            'POR',//POR 普通订单充值支付
            'ODR' //ODR 团购订单充值支付
        );
        if (in_array($type, $typeinfo)){
            ///订单类型符合
        }else{
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'3','errorMessage'=>'订单错误');
            print_r(json_encode($return));
            exit;
        }
    
        //获取用户支付账号
        $url = $this->url_prefix.'Customer/load_pay_account?';
        $info['customer_id'] = $user_id;
        $pay_account = json_decode($this->curl_post_result($url,$info),true);
    
        if(!$pay_account){
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'5','errorMessage'=>'没有充值账号账号');
            print_r(json_encode($return));
            exit;
        }
         
        if($pay_account['pay_passwd'] != md5($paypassword)){
            $return['responseMessage'] = array('messageType'=>'error','errorType'=>'4','errorMessage'=>'支付密码错误');
            print_r(json_encode($return));
            exit;
        }
    
        //获取用户资产 现金cash，授信credit，货豆M_credit
        $url = $this->url_prefix.'Customer/fortune/?customer_id='.$user_id;
        $credit = json_decode($this->curl_get_result($url),true);
    
        //判断订单是否正确和订单信息
        $this->load->model ("order_mdl");
        //正常的订单需要支付的订单状态是2   面对面的订单需要支付的订单状态是10
        $is_order = $this->order_mdl->is_customer_order($order_id,array(2,10),$user_id);
        if($is_order){
            //计算订单支付金额与当前用户余额差值
    
            //用户可用余额 授信+货豆
            $available_amount = $credit['credit']+$credit['M_credit'];
            $amount =round($is_order['total_price'] - $available_amount,2);
    
            //生成充值订单
            $data ['customer_id'] = $user_id;
            $data ["amount"] = $amount;
            $data ["order_sn"] = $is_order['order_sn'];
            $data ["order_source"] = $prams['source']=="ios"?4:3;//1、PC；2、微信；3、安卓；4、ios
            $data ["payment_id"] = isset($prams['payment_id'])?$prams['payment_id']:2;//1、支付宝；2、微信支付；3、网银在线
    
            do
            {
                $data ['chargeno'] = get_order_sn ();
                if ($this->charge->load_byChangeNum( $data['chargeno'] ) ) {
                    $order_exist = true;
                } else {
                    $new_charge_id = $this->charge->create ( $data );
                    $order_exist = false;
                }
            } while ( $order_exist ); // 如果是订单号重复则重新提交数据
            //根据获取id取行数据
            $row = $this->charge->load($new_charge_id);
            //生成充值订单失败
            if(!$row){
                $return['responseMessage'] = array('messageType'=>'error','errorType'=>'6','errorMessage'=>'充值订单生成失败');
                print_r(json_encode($return));
                exit;
            }
             
            if( $data ["payment_id"] == 3){//银联支付
                $pay_date = str_replace(array("-",":"," "),"",$row['pay_date']);
                $result = $this->unionPay($type.$row['chargeno'],$pay_date,$row['amount']);
                switch($result['status']){
                    case 0:
                        $return['responseMessage'] = array('messageType'=>'success','errorType'=>'','errorMessage'=>'');
                        $return['data']['chargeno'] = $type.$row['chargeno'];
                        $return['data']['txn_time'] = $result['txn_time'];
                        $return['data']['tn'] = $result['tn'];
                        break;
                    case 200:
                        $return['responseMessage'] = array('messageType'=>'error','errorType'=>'200','errorMessage'=>'没收到200应答');
                        break;
                    case 300:
                        $return['responseMessage'] = array('messageType'=>'error','errorType'=>'300','errorMessage'=>'应答报文验签失败');
                        break;
                    case 400:
                        $return['responseMessage'] = array('messageType'=>'error','errorType'=>'400','errorMessage'=>'订单生成失败');
                        break;
                    default:
                        $return['responseMessage'] = array('messageType'=>'error','errorType'=>'500','errorMessage'=>'');
                        break;
                }
                print_r(json_encode($return));
                exit;
            }
            //生成充值订单成功，返回订单数据
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
    
            $return['data']['customer_id'] = $row['customer_id'];
            $return['data']['id'] = $row['id'];
            $return['data']['chargeno'] = $type.$row['chargeno'];
            $return['data']['create_date'] = $row['create_date'];
            $return['data']['amount'] = $row['amount'];
            print_r(json_encode($return));
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '没有权限操作订单'
            );
            print_r(json_encode($return));
            exit();
        }
    
    }
    //----------------------------------------------
    
    /**
     * 提取现金
     */
    function Withdrawals(){
        
        // 获取参数
        $return = $this->return;
        $prams = $this->p;
        // 检验参数
        $this->_check_prams($prams, array('password','cash',"source"));
        
        $customer_id = $this->session->userdata("user_id");//用户id
        $password = $prams["password"];//密码
        $cash = $prams["cash"];//金额
        
        //数据验证
        if(!$customer_id){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        if(!preg_match("/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/",$cash)){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '请输入正确的金额'
            );
            print_r(json_encode($return));
            exit();
        }
        
        if(!$password){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '请输入密码'
            );
            print_r(json_encode($return));
            exit();
        }
        
        //接口-提现 (返回状态1银行卡审核中or被冻结2请绑定银行卡3成功4余额不足5提现失败6没有账户7密码错误)
        $data['app_id'] = $this->session->userdata("app_info")["id"];
        $data['customer_id'] = $customer_id;
        $data["cash"] = $cash;
        $data["password"] = $password;
        $data["source"] = $prams["source"];//1:PC 2:微信 3:安卓 4:ios 5:其它'
        $data["port_source"] = "CLIENT";
        $url = $this->url_prefix.'Charge/Withdrawals?';

        $result = json_decode($this->curl_do_result($url,$data),true);

        switch($result["status"]){
            case 1:
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '8',
                    'errorMessage' => '银行卡审核中or被冻结'
                );
                break;
            case 2:
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '9',
                    'errorMessage' => '请绑定银行卡'
                );
                break;
            case 3:
                //成功
                $return['responseMessage'] = array(
                    'messageType' => 'success',
                    'errorType' => '',
                    'errorMessage' => ''
                );
                $return['data'] = $result;
                break;
            case 4:
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '10',
                    'errorMessage' => '金额不足'
                );
                break;
            case 5:
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '11',
                    'errorMessage' => '提现失败'
                );
                break;
            case 6:
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '12',
                    'errorMessage' => '没有支付账户'
                );
                break;
            case 7:
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '13',
                    'errorMessage' => '密码错误'
                );
                break;
        }
        print_r(json_encode($return));
    }
    
    
    private function curl_do_result($url,$data){
        $data['key'] = 'jiami';
        $data['port_source'] = strtoupper(SUITE);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($curl);
        curl_close($curl);
        return  $result;
    }
}