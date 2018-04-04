<?php 
header ( 'Content-type:text/html;charset=utf-8' );
// include_once dirname(__FILE__).'/sdk/acp_service.php';
include_once FCPATH.'application/libraries/Acppay/sdk/acp_service.php';
/**
 * 银联支付
 * 交易金额，单位分
 *
 */
class Notify extends Front_Controller {
    var $merId;
    public function __construct()
    {
        parent::__construct();
        
        //商户号 // 测试  777290058149512 //正式'821610148167412'; 
        $this->merId = '821610148167412';
    }
    
  
     /**
      * 重要：联调测试时请仔细阅读注释！
      *
      * 产品：跳转网关支付产品<br>
      * 交易：交易状态查询交易：只有同步应答 <br>
      * 日期： 2015-09<br>
      * 版本： 1.0.0
      * 版权： 中国银联<br>
      * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能及规范性等方面的保障<br>
      * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》，<br>
      *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表）<br>
      * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
      *                                     调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
      *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
      *                           2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
      * 交易说明： 1）对前台交易发起交易状态查询：前台类交易建议间隔（5分、10分、30分、60分、120分）发起交易查询，如果查询到结果成功，则不用再查询。（失败，处理中，查询不到订单均可能为中间状态）。也可以建议商户使用payTimeout（支付超时时间），过了这个时间点查询，得到的结果为最终结果。
      *        2）对后台交易发起交易状态查询：后台类资金类交易同步返回00，成功银联有后台通知，商户也可以发起 查询交易，可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）。
      *                                  后台类资金类同步返03 04 05响应码及未得到银联响应（读超时）需发起查询交易，可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）。
      */
     public function Query($orderId,$txnTime)
     {
         if(!$orderId || !$txnTime){
             show_404();
             exit;
         }
         
         $params = array(
             //以下信息非特殊情况不需要改动
             'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,        //版本号
             'encoding' => 'utf-8',       //编码方式
             'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,          //签名方法
             'txnType' => '00',           //交易类型
             'txnSubType' => '00',        //交易子类
             'bizType' => '000000',       //业务类型
             'accessType' => '0',         //接入类型
             'channelType' => '07',       //渠道类型
         
             //TODO 以下信息需要填写
             'orderId' => $orderId, //请修改被查询的交易的订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数
             'merId' => $this->merId,       //商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
             'txnTime' => $txnTime, //请修改被查询的交易的订单发送时间，格式为YYYYMMDDhhmmss，此处默认取demo演示页面传递的参数
         );
         
         com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
         $url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->singleQueryUrl;
         
         $result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);
        
         //没收到200应答的情况
         if(count($result_arr)<=0) 
         { 
             error_log('查询交易状态请求失败');
             $data['status'] = 2;
             return json_encode($data);
         }
        
         if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
             error_log('应答报文验签失败');
             $data['status'] = 3;
             return json_encode($data);
         }
      
         if ( $result_arr["respCode"] == "00" )
         {
             if ($result_arr["origRespCode"] == "00")
             {
                 //交易成功
                 error_log('银联支付交易成功');
                 $data['status'] = 1;
                 $data['txnAmt'] = $result_arr['txnAmt'];
                 return json_encode($data);
                 
             } else if ($result_arr["origRespCode"] == "03" || $result_arr["origRespCode"] == "04"  || $result_arr["origRespCode"] == "05"){
                     //后续需发起交易状态查询交易确定交易状态
                     //TODO
                     error_log('银联支付处理超时，请稍后查询');
                     $data['status'] = 4;
                     return json_encode($data);
             } else {
                 //其他应答码做以失败处理
                 //TODO
                  error_log('银联支付失败'.$result_arr["respMsg"]);
                  $data['status'] = 5;
                  return json_encode($data);
             }
         } else if ($result_arr["respCode"] == "03" || $result_arr["respCode"] == "04" || $result_arr["respCode"] == "05" ){
                 //后续需发起交易状态查询交易确定交易状态
                 //TODO
                 error_log('银联支付处理超时，请稍后查询');
                 $data['status'] = 6;
                 return json_encode($data);
         } else {
             //其他应答码做以失败处理
             //TODO
             error_log('银联支付失败'.$result_arr["respMsg"]);
             $data['status'] = 7;
             return json_encode($data);
         }
     }
    
    
    //----------------------------支付回调--------------------------------------------
    
    /**
     * 前端同步回调
     * 交易说明：    前台类交易成功才会发送后台通知。后台类交易（有后台通知的接口）交易结束之后成功失败都会发通知。
     *              为保证安全，涉及资金类的交易，收到通知后请再发起查询接口确认交易成功。不涉及资金的交易可以以通知接口respCode=00判断成功。
     *              未收到通知时，查询接口调用时间点请参照此FAQ：https://open.unionpay.com/ajweb/help/faq/list?id=77&level=0&from=0
     */
    public function FrontReceive()
    {
        
        $logger = com\unionpay\acp\sdk\LogUtil::getLogger();
        $logger->LogInfo("receive back notify: " . com\unionpay\acp\sdk\createLinkString ( $_POST, false, true ) );
      
        if ( isset ( $_POST ['signature'] ) ) 
        {
            //echo com\unionpay\acp\sdk\AcpService::validate ( $_POST ) ? '验签成功' : '验签失败';
            if( com\unionpay\acp\sdk\AcpService::validate ( $_POST ) ) 
            {
                    $orderNo = $orderId = $_POST ['orderId']; //其他字段也可用类似方式获取
                    $respCode = $_POST ['respCode'];
                    $pay_date = $_POST ['txnTime'];
                    
                    //网银交易号
                    $trade_no = $_POST['traceNo'];
                    $pay_type = substr ( $orderId, 0, 3 );
                    //判断respCode=00、A6后，对涉及资金类的交易，请再发起查询接口查询，确定交易成功后更新数据库。
                    
                    $this->load->helper('pay_return_config');
                    $return_info = select_return_info($pay_type);
                    
                    if( $return_info['status'] != 1 )
                    {
                        error_log('未定义转跳路径');
                        exit();
                    }
                    
                    do{ 
                       
                        $orderId = substr ( $orderId, 3, strlen ( $orderId ) );
                        $this->load->model ( 'charge_mdl', 'charge' );
                        $charge = $this->charge->load_byChangeNum ( $orderId );
                        
                        $data = json_decode($this->Query($orderNo,$pay_date),true);
                       
                        if ( $data['status'] != 1 || !$charge )
                        {
                            error_log('支付失败：状态：'.$data['status']);
                            break;
                        }
                        
                        $amount = $charge['amount']*100;//单位分
                        
                        if( $amount != $data['txnAmt']  )
                        {
                            error_log('订单金额错误,充值交易失败！');
                            $this->charge_mdl->update_status($orderId,5);
                            break;
                        }
                        
                        //开店处理方法。
                        $model = $return_info['model']; //MODEL。
                        $function = $return_info['function'];//MODEL中处理逻辑的方法
                        $this->load->model($model);//实例化。
                        $is_ok = $this->$model->$function( $charge, $trade_no,'银联支付' );
                        
                    }while(0);
                    
                    $code = !empty( $is_ok ) ? 1 : 0;
                    $url = $return_info['return_url'].$code;
                    redirect($url);
                    
            }else{
                
                error_log('验签失败');
            }
            
            
        } else {
            error_log('签名为空');
        }
    
    }
    
    
    
    /**
     * 后台异步回调
     * 交易说明：    前台类交易成功才会发送后台通知。后台类交易（有后台通知的接口）交易结束之后成功失败都会发通知。
     *              为保证安全，涉及资金类的交易，收到通知后请再发起查询接口确认交易成功。不涉及资金的交易可以以通知接口respCode=00判断成功。
     *              未收到通知时，查询接口调用时间点请参照此FAQ：https://open.unionpay.com/ajweb/help/faq/list?id=77&level=0&from=0
     */
    public function BackReceive(){
        $logger = com\unionpay\acp\sdk\LogUtil::getLogger();
        $logger->LogInfo("receive front notify: " . com\unionpay\acp\sdk\createLinkString ( $_POST, false, true ));
        
        if (isset ( $_POST ['signature'] ) ) 
        {
            //echo com\unionpay\acp\sdk\AcpService::validate ( $_POST ) ? '验签成功' : '验签失败';
            if( com\unionpay\acp\sdk\AcpService::validate ( $_POST ) ) 
            {
                $orderNo = $orderId = $_POST ['orderId']; //其他字段也可用类似方式获取
                $respCode = $_POST ['respCode'];
                $pay_date = $_POST ['txnTime'];
                
                //网银交易号
                $trade_no = $_POST['traceNo'];
                $pay_type = substr ( $orderId, 0, 3 );
                
                //读取配置的对应返回参数。
                $this->load->helper('pay_return_config');
                $return_info = select_return_info($pay_type);
                
                if( $return_info['status'] != 1 )
                {
                    error_log('未定义前缀调用方法');
                    exit();
                }
                
                do{
                     
                    $orderId = substr ( $orderId, 3, strlen ( $orderId ) );
                    $this->load->model ( 'charge_mdl', 'charge' );
                    $charge = $this->charge->load_byChangeNum ( $orderId );
                    $data = json_decode($this->Query($orderNo,$pay_date),true);
                
                    if ( $data['status'] != 1 || !$charge )
                    {
                        error_log( '支付失败：状态：'.$data['status'] );
                        break;
                    }
                
                    $amount = $charge['amount']*100;//单位分
                
                    if( $amount != $data['txnAmt']  )
                    {
                        error_log('订单金额错误,充值交易失败！');
                        $this->charge_mdl->update_status($orderId,5);
                        break;
                    }
                
                    //开店处理方法。
                    $model = $return_info['model']; //MODEL。
                    $function = $return_info['function'];//MODEL中处理逻辑的方法
                    $this->load->model($model);//实例化。
                    $is_ok = $this->$model->$function( $charge, $trade_no ,'银联支付');
                
                }while(0);
                
                echo !empty( $is_ok ) ? 'success' : 'fail';
                
            }else{
                
                error_log('验签失败');
            }
            
        } else {
            
            error_log('签名为空');
        }
       
    }
    
   
    
}