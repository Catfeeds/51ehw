<?php 
header ( 'Content-type:text/html;charset=utf-8' );
include_once dirname(__FILE__).'/sdk/acp_service.php';
/**
 * 银联支付
 * 交易金额，单位分
 *
 */
class Notify_url extends Front_Controller {
    var $merId;
    public function __construct()
    {
        parent::__construct();
        //商户号
        $this->merId = '821610148167412';
//         $this->merId = '777290058149512';
    }
    
    function index() {
        echo '银联支付';
        exit;
    }
    
    /**
     * PC支付提交
     */
    public function charge_pay($chargeID = null){
        
     
        if (!$this->session->userdata('user_in')){
            redirect('customer/login');
            exit();
        }
        $this->load->model ( 'charge_mdl', 'charge' );
        $charge_info = $this->charge->load ( $chargeID );
        
        $user_id = $this->session->userdata ( 'user_id' );
        //更改成银联支付
        $this->charge->update_payment( $chargeID, 3 );
       
        //纯充值
        $chargeno = $charge_info['chargeno'];
        
        if(!empty($charge_info['order_sn'])){
            //普通订单POR
            $this->load->model('order_mdl');
            $this->order_mdl->update_order_payment($charge_info['order_sn'],3);
            $chargeno = 'POR'.$charge_info['chargeno'];
        }
        //把时间稍微转换下如20170720110712
        $pay_date = str_replace(array("-",":"," "),"",$charge_info['pay_date']);
        //平台以元味基础单位，因银联以分为基础单位，也要转换下
        $amount = $charge_info['amount']*100;
        $this->FrontConsume($chargeno,$pay_date,$amount);
    }
    
    
    
    /**
     * 重要：联调测试时请仔细阅读注释！
     *
     * 产品：跳转网关支付产品<br>
     * 交易：消费：前台跳转，有前台通知应答和后台通知应答<br>
     * 日期： 2015-09<br>
     * 版本： 1.0.0
     * 版权： 中国银联<br>
     * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
     * 提示：该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》，<br>
     *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表)<br>
     *              《全渠道平台接入接口规范 第3部分 文件接口》（对账文件格式说明）<br>
     * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
     * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
     *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
     *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
     * 交易说明:1）以后台通知或交易状态查询交易确定交易成功,前台通知不能作为判断成功的标准.
     *       2）交易状态查询交易（Form_6_5_Query）建议调用机制：前台类交易建议间隔（5分、10分、30分、60分、120分）发起交易查询，如果查询到结果成功，则不用再查询。（失败，处理中，查询不到订单均可能为中间状态）。也可以建议商户使用payTimeout（支付超时时间），过了这个时间点查询，得到的结果为最终结果。
     */
    private function FrontConsume($orderId,$txnTime,$txnAmt){
       
        $params = array(
            //以下信息非特殊情况不需要改动
            'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,                 //版本号
            'encoding' => 'utf-8',				  //编码方式
            'txnType' => '01',				      //交易类型
            'txnSubType' => '01',				  //交易子类
            'bizType' => '000201',				  //业务类型
            'frontUrl' =>  com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->frontUrl,  //前台通知地址
            'backUrl' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl,	  //后台通知地址
            'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,	              //签名方法
            'channelType' => '08',	              //渠道类型，07-PC，08-手机
            'accessType' => '0',		          //接入类型
            'currencyCode' => '156',	          //交易币种，境内商户固定156
        
            //TODO 以下信息需要填写
            'merId' => $this->merId,//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
            'orderId' => $orderId,	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
            'txnTime' => $txnTime,	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
            'txnAmt' => $txnAmt,	//交易金额，单位分，此处默认取demo演示页面传递的参数
        
            // 订单超时时间。
            // 超过此时间后，除网银交易外，其他交易银联系统会拒绝受理，提示超时。 跳转银行网银交易如果超时后交易成功，会自动退款，大约5个工作日金额返还到持卡人账户。
            // 此时间建议取支付时的北京时间加15分钟。
            // 超过超时时间调查询接口应答origRespCode不是A6或者00的就可以判断为失败。
            'payTimeout' => date('YmdHis', strtotime('+15 minutes')),
        
            // 请求方保留域，
            // 透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据。
            // 出现部分特殊字符时可能影响解析，请按下面建议的方式填写：
            // 1. 如果能确定内容不会出现&={}[]"'等符号时，可以直接填写数据，建议的方法如下。
            //    'reqReserved' =>'透传信息1|透传信息2|透传信息3',
            // 2. 内容可能出现&={}[]"'符号时：
            // 1) 如果需要对账文件里能显示，可将字符替换成全角＆＝｛｝【】“‘字符（自己写代码，此处不演示）；
            // 2) 如果对账文件没有显示要求，可做一下base64（如下）。
            //    注意控制数据长度，实际传输的数据长度不能超过1024位。
        //    查询、通知等接口解析时使用base64_decode解base64后再对数据做后续解析。
        //    'reqReserved' => base64_encode('任意格式的信息都可以'),
        
        //TODO 其他特殊用法请查看 special_use_purchase.php
        );
        com\unionpay\acp\sdk\AcpService::sign ( $params );
        $uri = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->frontTransUrl;
        $html_form = com\unionpay\acp\sdk\AcpService::createAutoFormHtml( $params, $uri );
        echo $html_form;
    }
    
    /**
     * 重要：联调测试时请仔细阅读注释！
     *
     * 产品：跳转网关支付产品<br>
     * 交易：消费撤销类交易：后台消费撤销交易，有同步应答和后台通知应答<br>
     * 日期： 2015-09<br>
     * 版权： 中国银联<br>
     * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
     * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》<br>
     *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表）<br>
     * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
     * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
     *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
     *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
     * 交易说明:1）以后台通知或交易状态查询交易确定交易成功
     *       2）消费撤销仅能对当清算日的消费做，必须为全额，一般当日或第二日到账。
     */
    function ConsumeUndo(){
        $params = array(
        
            //以下信息非特殊情况不需要改动
            'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,		      //版本号
            'encoding' => 'utf-8',		      //编码方式
            'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,		      //签名方法
            'txnType' => '31',		          //交易类型
            'txnSubType' => '00',		      //交易子类
            'bizType' => '000201',		      //业务类型
            'accessType' => '0',		      //接入类型
            'channelType' => '07',		      //渠道类型
            'backUrl' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl, //后台通知地址
        
            //TODO 以下信息需要填写
            'orderId' => $_POST["orderId"],	    //商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
            'merId' => $this->merId,			//商户代码，请改成自己的测试商户号，此处默认取demo演示页面传递的参数
            'origQryId' => $_POST["origQryId"], //原消费的queryId，可以从查询接口或者通知接口中获取，此处默认取demo演示页面传递的参数
            'txnTime' => $_POST["txnTime"],	    //订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
            'txnAmt' => $_POST["txnAmt"],       //交易金额，消费撤销时需和原消费一致，此处默认取demo演示页面传递的参数
        
            // 请求方保留域，
            // 透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据。
            // 出现部分特殊字符时可能影响解析，请按下面建议的方式填写：
            // 1. 如果能确定内容不会出现&={}[]"'等符号时，可以直接填写数据，建议的方法如下。
            //    'reqReserved' =>'透传信息1|透传信息2|透传信息3',
            // 2. 内容可能出现&={}[]"'符号时：
            // 1) 如果需要对账文件里能显示，可将字符替换成全角＆＝｛｝【】“‘字符（自己写代码，此处不演示）；
            // 2) 如果对账文件没有显示要求，可做一下base64（如下）。
            //    注意控制数据长度，实际传输的数据长度不能超过1024位。
        //    查询、通知等接口解析时使用base64_decode解base64后再对数据做后续解析。
        //    'reqReserved' => base64_encode('任意格式的信息都可以'),
        );
        
        com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
        $url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backTransUrl;
        
        $result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);
        if(count($result_arr)<=0) { //没收到200应答的情况
            echo "POST请求失败：" . $errMsg;
            return;
        }
        
        if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
            echo "应答报文验签失败<br>\n";
            return;
        }
        
        echo "应答报文验签成功<br>\n";
        if ($result_arr["respCode"] == "00"){
            //交易已受理，等待接收后台通知更新订单状态，如果通知长时间未收到也可发起交易状态查询
            //TODO
            echo "受理成功。<br>\n";
        } else if ($result_arr["respCode"] == "03"
            || $result_arr["respCode"] == "04"
            || $result_arr["respCode"] == "05" ){
                //后续需发起交易状态查询交易确定交易状态
                //TODO
                echo "处理超时，请稍微查询。<br>\n";
        } else {
            //其他应答码做以失败处理
            //TODO
            echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
        }
    }
    
    
    
    
    /**
     * 重要：联调测试时请仔细阅读注释！
     *
     * 产品：跳转网关支付产品<br>
     * 交易：预授权：前台跳转，有前台通知应答和后台通知应答<br>
     * 日期： 2015-09<br>
     * 版本： 1.0.0
     * 版权： 中国银联<br>
     * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
     * 提示：该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》，<br>
     *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表)<br>
     *              《全渠道平台接入接口规范 第3部分 文件接口》（对账文件格式说明）<br>
     * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
     * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
     *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
     *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
     * 交易说明:1）以后台通知或交易状态查询交易确定交易成功,前台通知不能作为判断成功的标准.
     *       2）交易状态查询交易（Form_6_5_Query）建议调用机制：前台类交易间隔（5分、10分、30分、60分、120分）发起交易查询，如果查询到结果成功，则不用再查询。（失败，处理中，查询不到订单均可能为中间状态）。也可以建议商户使用payTimeout（支付超时时间），过了这个时间点查询，得到的结果为最终结果。
     */
    function FrontPreauth(){
        $params = array(
        
            //以下信息非特殊情况不需要改动
            'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,                 //版本号
            'encoding' => 'utf-8',				  //编码方式
            'txnType' => '02',				      //交易类型
            'txnSubType' => '01',				  //交易子类
            'bizType' => '000201',				  //业务类型
            'frontUrl' =>  com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->frontUrl,  //前台通知地址
            'backUrl' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl,	  //后台通知地址
            'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,	              //签名方法
            'channelType' => '08',	              //渠道类型，07-PC，08-手机
            'accessType' => '0',		          //接入类型
            'currencyCode' => '156',	          //交易币种，境内商户固定156
        
            //TODO 以下信息需要填写
            'merId' => $this->merId,		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
            'orderId' => $_POST["orderId"],	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
            'txnTime' => $_POST["txnTime"],	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
            'txnAmt' => $_POST["txnAmt"],	//交易金额，单位分，此处默认取demo演示页面传递的参数
        
            'payTimeout' => date('YmdHis', strtotime('+15 minutes')), //订单超时时间。超过超时时间调查询接口应答origRespCode不是A6或者00的就可以判断为失败。
        
            // 请求方保留域，
            // 透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据。
            // 出现部分特殊字符时可能影响解析，请按下面建议的方式填写：
            // 1. 如果能确定内容不会出现&={}[]"'等符号时，可以直接填写数据，建议的方法如下。
            //    'reqReserved' =>'透传信息1|透传信息2|透传信息3',
            // 2. 内容可能出现&={}[]"'符号时：
            // 1) 如果需要对账文件里能显示，可将字符替换成全角＆＝｛｝【】“‘字符（自己写代码，此处不演示）；
            // 2) 如果对账文件没有显示要求，可做一下base64（如下）。
            //    注意控制数据长度，实际传输的数据长度不能超过1024位。
        //    查询、通知等接口解析时使用base64_decode解base64后再对数据做后续解析。
        //    'reqReserved' => base64_encode('任意格式的信息都可以'),
        
        //TODO 其他特殊用法请查看 special_use_preauth.php
        );
        
        com\unionpay\acp\sdk\AcpService::sign ( $params );
        $uri = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->frontTransUrl;
        $html_form = com\unionpay\acp\sdk\AcpService::createAutoFormHtml( $params, $uri );
        echo $html_form;
    }
     
    
    
    /**
     * 重要：联调测试时请仔细阅读注释！
     *
     * 产品：跳转网关支付产品<br>
     * 交易：预授权完成：后台交易，有同步应答和后台通知应答<br>
     * 日期： 2015-09<br>
     * 版本： 1.0.0
     * 版权： 中国银联<br>
     * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
     * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》<br>
     *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表）<br>
     * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
     * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
     *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
     *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
     * 交易说明:1）以后台通知或交易状态查询交易（Form_6_5_Query）确定交易成功。建议发起查询交易的机制：可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）
     *       2）预授权完成交易必须在预授权交易30日内发起，否则预授权交易自动解冻。预授权完成金额可以是预授权金额的(0-115%]（大于0小于等于115）
     */
    function  PreauthFinish(){
        $params = array(
        
            //以下信息非特殊情况不需要改动
            'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,		      //版本号
            'encoding' => 'utf-8',		      //编码方式
            'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,		      //签名方法
            'txnType' => '03',		          //交易类型
            'txnSubType' => '00',		      //交易子类
            'bizType' => '000201',		      //业务类型
            'accessType' => '0',		      //接入类型
            'channelType' => '07',		      //渠道类型
            'backUrl' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl, //后台通知地址
        
            //TODO 以下信息需要填写
            'orderId' => $_POST["orderId"],	    //商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原交易，此处默认取demo演示页面传递的参数
            'merId' => $this->merId,	        //商户代码，请改成自己的测试商户号，此处默认取demo演示页面传递的参数
            'origQryId' => $_POST["origQryId"], //原预授权的queryId，可以从预授权的查询接口或者通知接口中获取，此处默认取demo演示页面传递的参数
            'txnTime' => $_POST["txnTime"],	    //订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原交易，此处默认取demo演示页面传递的参数
            'txnAmt' => $_POST["txnAmt"],       //交易金额，范围为预授权金额的0-115%
        
            // 请求方保留域，
            // 透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据。
            // 出现部分特殊字符时可能影响解析，请按下面建议的方式填写：
            // 1. 如果能确定内容不会出现&={}[]"'等符号时，可以直接填写数据，建议的方法如下。
            //    'reqReserved' =>'透传信息1|透传信息2|透传信息3',
            // 2. 内容可能出现&={}[]"'符号时：
            // 1) 如果需要对账文件里能显示，可将字符替换成全角＆＝｛｝【】“‘字符（自己写代码，此处不演示）；
            // 2) 如果对账文件没有显示要求，可做一下base64（如下）。
            //    注意控制数据长度，实际传输的数据长度不能超过1024位。
        //    查询、通知等接口解析时使用base64_decode解base64后再对数据做后续解析。
        //    'reqReserved' => base64_encode('任意格式的信息都可以'),
        );
        com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
        $url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backTransUrl;
        
        $result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);
        if(count($result_arr)<=0) { //没收到200应答的情况
           
            return;
        }
        
        
        if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
            echo "应答报文验签失败<br>\n";
            return;
        }
        
        echo "应答报文验签成功<br>\n";
        if ($result_arr["respCode"] == "00"){
            //交易已受理，等待接收后台通知更新订单状态，如果通知长时间未收到也可发起交易状态查询
            //TODO
            echo "受理成功。<br>\n";
        } else if ($result_arr["respCode"] == "03"
            || $result_arr["respCode"] == "04"
            || $result_arr["respCode"] == "05" ){
                //后续需发起交易状态查询交易确定交易状态
                //TODO
                echo "处理超时，请稍微查询。<br>\n";
        } else {
            //其他应答码做以失败处理
            //TODO
            echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
        }
    }
    
    
    /**
     * 重要：联调测试时请仔细阅读注释！
     *
     * 产品：跳转网关支付产品<br>
     * 交易：预授权完成撤销：后台交易，有同步应答和后台通知应答<br>
     * 日期： 2015-09<br>
     * 版本： 1.0.0
     * 版权： 中国银联<br>
     * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
     * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》<br>
     *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表）<br>
     * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
     * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
     *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
     *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
     * 交易说明:1）以后台通知或交易状态查询交易（Form_6_5_Query）确定交易成功。建议发起查询交易的机制：可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）
     *       2）预授权完成撤销交易仅能对当清算日的预授权做，必须为预授权完成金额全额撤销。
     */
     function PreauthFinishUndo(){
         $params = array(
         
             //以下信息非特殊情况不需要改动
             'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,		      //版本号
             'encoding' => 'utf-8',		      //编码方式
             'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,		      //签名方法
             'txnType' => '33',		          //交易类型
             'txnSubType' => '00',		      //交易子类
             'bizType' => '000201',		      //业务类型
             'accessType' => '0',		      //接入类型
             'channelType' => '07',		      //渠道类型
             'backUrl' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl, //后台通知地址
         
             //TODO 以下信息需要填写
             'orderId' => $_POST["orderId"],	    //商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原交易，此处默认取demo演示页面传递的参数
             'merId' => $this->merId,	        //商户代码，请改成自己的测试商户号，此处默认取demo演示页面传递的参数
             'origQryId' => $_POST["origQryId"], //原预授权完成的queryId，可以从预授权完成的查询接口或者通知接口中获取，此处默认取demo演示页面传递的参数
             'txnTime' => $_POST["txnTime"],	    //订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原交易，此处默认取demo演示页面传递的参数
             'txnAmt' => $_POST["txnAmt"],       //交易金额，同原预授权完成的金额
         
             // 请求方保留域，
             // 透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据。
             // 出现部分特殊字符时可能影响解析，请按下面建议的方式填写：
             // 1. 如果能确定内容不会出现&={}[]"'等符号时，可以直接填写数据，建议的方法如下。
             //    'reqReserved' =>'透传信息1|透传信息2|透传信息3',
             // 2. 内容可能出现&={}[]"'符号时：
             // 1) 如果需要对账文件里能显示，可将字符替换成全角＆＝｛｝【】“‘字符（自己写代码，此处不演示）；
             // 2) 如果对账文件没有显示要求，可做一下base64（如下）。
             //    注意控制数据长度，实际传输的数据长度不能超过1024位。
         //    查询、通知等接口解析时使用base64_decode解base64后再对数据做后续解析。
         //    'reqReserved' => base64_encode('任意格式的信息都可以'),
         );
         
         com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
         $url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backTransUrl;
         
         $result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);
         if(count($result_arr)<=0) { //没收到200应答的情况
             
             return;
         }
         
         
         if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
             echo "应答报文验签失败<br>\n";
             return;
         }
         
         echo "应答报文验签成功<br>\n";
         if ($result_arr["respCode"] == "00"){
             //交易已受理，等待接收后台通知更新订单状态，如果通知长时间未收到也可发起交易状态查询
             //TODO
             echo "受理成功。<br>\n";
         } else if ($result_arr["respCode"] == "03"
             || $result_arr["respCode"] == "04"
             || $result_arr["respCode"] == "05" ){
                 //后续需发起交易状态查询交易确定交易状态
                 //TODO
                 echo "处理超时，请稍微查询。<br>\n";
         } else {
             //其他应答码做以失败处理
             //TODO
             echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
         }
     }
     
     /**
      * 重要：联调测试时请仔细阅读注释！
      *
      * 产品：跳转网关支付产品<br>
      * 交易：预授权撤销：后台交易，有同步应答和后台通知应答<br>
      * 日期： 2015-09<br>
      * 版本： 1.0.0
      * 版权： 中国银联<br>
      * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
      * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》<br>
      *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表）<br>
      * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
      * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
      *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
      *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
      * 交易说明:1）以后台通知或交易状态查询交易（Form_6_5_Query）确定交易成功。建议发起查询交易的机制：可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）
      *       2）预授权撤销对清算日30天之内（包括第30天）的预授权做，必须为预授权金额全额撤销。
      */
     function PreauthUndo(){
         $params = array(
         
             //以下信息非特殊情况不需要改动
             'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,		      //版本号
             'encoding' => 'utf-8',		      //编码方式
             'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,		      //签名方法
             'txnType' => '32',		          //交易类型
             'txnSubType' => '00',		      //交易子类
             'bizType' => '000201',		      //业务类型
             'accessType' => '0',		      //接入类型
             'channelType' => '07',		      //渠道类型
             'backUrl' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl, //后台通知地址
         
             //TODO 以下信息需要填写
             'orderId' => $_POST["orderId"],	    //商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原预授权，此处默认取demo演示页面传递的参数
             'merId' => $this->merId,	        //商户代码，请改成自己的测试商户号，此处默认取demo演示页面传递的参数
             'origQryId' => $_POST["origQryId"], //原预授权的queryId，可以从预授权的查询接口或者通知接口中获取，此处默认取demo演示页面传递的参数
             'txnTime' => $_POST["txnTime"],	    //订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原预授权，此处默认取demo演示页面传递的参数
             'txnAmt' => $_POST["txnAmt"],       //交易金额，需要等于原预授权
         
             // 请求方保留域，
             // 透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据。
             // 出现部分特殊字符时可能影响解析，请按下面建议的方式填写：
             // 1. 如果能确定内容不会出现&={}[]"'等符号时，可以直接填写数据，建议的方法如下。
             //    'reqReserved' =>'透传信息1|透传信息2|透传信息3',
             // 2. 内容可能出现&={}[]"'符号时：
             // 1) 如果需要对账文件里能显示，可将字符替换成全角＆＝｛｝【】“‘字符（自己写代码，此处不演示）；
             // 2) 如果对账文件没有显示要求，可做一下base64（如下）。
             //    注意控制数据长度，实际传输的数据长度不能超过1024位。
         //    查询、通知等接口解析时使用base64_decode解base64后再对数据做后续解析。
         //    'reqReserved' => base64_encode('任意格式的信息都可以'),
         );
         com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
         $url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backTransUrl;
         
         $result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);
         if(count($result_arr)<=0) { //没收到200应答的情况
             return;
         }
         
         if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
             echo "应答报文验签失败<br>\n";
             return;
         }
         
         echo "应答报文验签成功<br>\n";
         if ($result_arr["respCode"] == "00"){
             //交易已受理，等待接收后台通知更新订单状态，如果通知长时间未收到也可发起交易状态查询
             //TODO
             echo "受理成功。<br>\n";
         } else if ($result_arr["respCode"] == "03"
             || $result_arr["respCode"] == "04"
             || $result_arr["respCode"] == "05" ){
                 //后续需发起交易状态查询交易确定交易状态
                 //TODO
                 echo "处理超时，请稍微查询。<br>\n";
         } else {
             //其他应答码做以失败处理
             //TODO
             echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
         }
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
      * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
      *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
      *                           2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
      * 交易说明： 1）对前台交易发起交易状态查询：前台类交易建议间隔（5分、10分、30分、60分、120分）发起交易查询，如果查询到结果成功，则不用再查询。（失败，处理中，查询不到订单均可能为中间状态）。也可以建议商户使用payTimeout（支付超时时间），过了这个时间点查询，得到的结果为最终结果。
      *        2）对后台交易发起交易状态查询：后台类资金类交易同步返回00，成功银联有后台通知，商户也可以发起 查询交易，可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）。
      *        					         后台类资金类同步返03 04 05响应码及未得到银联响应（读超时）需发起查询交易，可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）。
      */
     public function Query($orderId = '' ,$txnTime = ''){
         if(!$orderId || !$txnTime){
             show_404();
             exit;
         }
         $params = array(
             //以下信息非特殊情况不需要改动
             'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,		  //版本号
             'encoding' => 'utf-8',		  //编码方式
             'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,		  //签名方法
             'txnType' => '00',		      //交易类型
             'txnSubType' => '00',		  //交易子类
             'bizType' => '000000',		  //业务类型
             'accessType' => '0',		  //接入类型
             'channelType' => '07',		  //渠道类型
         
             //TODO 以下信息需要填写
             'orderId' => $orderId,	//请修改被查询的交易的订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数
             'merId' => $this->merId,	    //商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
             'txnTime' => $txnTime,	//请修改被查询的交易的订单发送时间，格式为YYYYMMDDhhmmss，此处默认取demo演示页面传递的参数
         );
         
         com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
         $url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->singleQueryUrl;
         
         $result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);
     
         if(count($result_arr)<=0) { //没收到200应答的情况
             error_log('查询交易状态请求失败');
             $data['status'] = 2;
             return json_encode($data);
         }
        
         if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
             error_log('应答报文验签失败');
             $data['status'] = 2;
             return json_encode($data);
         }
      
         if ($result_arr["respCode"] == "00"){
             if ($result_arr["origRespCode"] == "00"){
                 //交易成功
                 //TODO
                 error_log('银联支付交易成功');
                 $data['status'] = 0;
                 $data['txnAmt'] = $result_arr['txnAmt'];
                 $data['queryId'] = $result_arr['queryId'];
             } else if ($result_arr["origRespCode"] == "03"
                 || $result_arr["origRespCode"] == "04"
                 || $result_arr["origRespCode"] == "05"){
                     //后续需发起交易状态查询交易确定交易状态
                     //TODO
                     error_log('银联支付处理超时，请稍后查询');
                     $data['status'] = 1;
             } else {
                 //其他应答码做以失败处理
                 //TODO
                  error_log('银联支付失败'.$result_arr["respMsg"]);
                  $data['status'] = 2;
             }
         } else if ($result_arr["respCode"] == "03"
             || $result_arr["respCode"] == "04"
             || $result_arr["respCode"] == "05" ){
                 //后续需发起交易状态查询交易确定交易状态
                 //TODO
                 error_log('银联支付处理超时，请稍后查询');
                 $data['status'] = 1;
         } else {
             //其他应答码做以失败处理
             //TODO
             error_log('银联支付失败'.$result_arr["respMsg"]);
             $data['status'] = 2;
         }
         return json_encode($data);
         
     }
     /**
      * 重要：联调测试时请仔细阅读注释！
      *
      * 产品：跳转网关支付产品<br>
      * 交易：退货交易：后台资金类交易，有同步应答和后台通知应答<br>
      * 日期： 2015-09<br>
      * 版本： 1.0.0
      * 版权： 中国银联<br>
      * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
      * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》<br>
      *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表）<br>
      * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
      * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
      *                             测试过程中产生的7位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
      *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
      * 交易说明： 1）以后台通知或交易状态查询交易（Form_6_5_Query）确定交易成功，建议发起查询交易的机制：可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）
      *        2）退货金额不超过总金额，可以进行多次退货
      *        3）退货能对11个月内的消费做（包括当清算日），支持部分退货或全额退货，到账时间较长，一般1-10个清算日（多数发卡行5天内，但工行可能会10天），所有银行都支持
      */
     function Refund(){
         $params = array(
         
             //以下信息非特殊情况不需要改动
             'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,		      //版本号
             'encoding' => 'utf-8',		      //编码方式
             'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,		      //签名方法
             'txnType' => '04',		          //交易类型
             'txnSubType' => '00',		      //交易子类
             'bizType' => '000201',		      //业务类型
             'accessType' => '0',		      //接入类型
             'channelType' => '07',		      //渠道类型
             'backUrl' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl, //后台通知地址
                          
         
             //TODO 以下信息需要填写
             'orderId' => $_POST["orderId"],	    //商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
             'merId' => $this->merId,	        //商户代码，请改成自己的测试商户号，此处默认取demo演示页面传递的参数
             'origQryId' => $_POST["origQryId"], //原消费的queryId，可以从查询接口或者通知接口中获取，此处默认取demo演示页面传递的参数
             'txnTime' => $_POST["txnTime"],	    //订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
             'txnAmt' => $_POST["txnAmt"],       //交易金额，退货总金额需要小于等于原消费
         
             // 请求方保留域，
             // 透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据。
             // 出现部分特殊字符时可能影响解析，请按下面建议的方式填写：
             // 1. 如果能确定内容不会出现&={}[]"'等符号时，可以直接填写数据，建议的方法如下。
             //    'reqReserved' =>'透传信息1|透传信息2|透传信息3',
             // 2. 内容可能出现&={}[]"'符号时：
             // 1) 如果需要对账文件里能显示，可将字符替换成全角＆＝｛｝【】“‘字符（自己写代码，此处不演示）；
             // 2) 如果对账文件没有显示要求，可做一下base64（如下）。
             //    注意控制数据长度，实际传输的数据长度不能超过1024位。
         //    查询、通知等接口解析时使用base64_decode解base64后再对数据做后续解析。
         //    'reqReserved' => base64_encode('任意格式的信息都可以'),
         );
         
         com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
         $url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backTransUrl;
         
         $result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url);
         if(count($result_arr)<=0) { //没收到200应答的情况
             
             return;
         }
         
         if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
             echo "应答报文验签失败<br>\n";
             return;
         }
         
         echo "应答报文验签成功<br>\n";
         if ($result_arr["respCode"] == "00"){
             //交易已受理，等待接收后台通知更新订单状态，如果通知长时间未收到也可发起交易状态查询
             //TODO
             echo "受理成功。<br>\n";
         } else if ($result_arr["respCode"] == "03"
             || $result_arr["respCode"] == "04"
             || $result_arr["respCode"] == "05" ){
                 //后续需发起交易状态查询交易确定交易状态
                 //TODO
                 echo "处理超时，请稍微查询。<br>\n";
         } else {
             //其他应答码做以失败处理
             //TODO
             echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
         }
     } 
    
    
    //----------------------------支付回调--------------------------------------------
    
    /**
     * 前端同步回调
     * 交易说明：	前台类交易成功才会发送后台通知。后台类交易（有后台通知的接口）交易结束之后成功失败都会发通知。
     *              为保证安全，涉及资金类的交易，收到通知后请再发起查询接口确认交易成功。不涉及资金的交易可以以通知接口respCode=00判断成功。
     *              未收到通知时，查询接口调用时间点请参照此FAQ：https://open.unionpay.com/ajweb/help/faq/list?id=77&level=0&from=0
     */
    public function FrontReceive(){
        $logger = com\unionpay\acp\sdk\LogUtil::getLogger();
        $logger->LogInfo("receive back notify: " . com\unionpay\acp\sdk\createLinkString ( $_POST, false, true ));
      
        if (isset ( $_POST ['signature'] )) {
            //echo com\unionpay\acp\sdk\AcpService::validate ( $_POST ) ? '验签成功' : '验签失败';
            if(com\unionpay\acp\sdk\AcpService::validate ( $_POST )){
                    $orderNo = $orderId = $_POST ['orderId']; //其他字段也可用类似方式获取
                    $respCode = $_POST ['respCode'];
                    //网银交易号
                    $trade_no = $_POST['traceNo'];
                    $pay_type = substr ( $orderId, 0, 3 );
                    //判断respCode=00、A6后，对涉及资金类的交易，请再发起查询接口查询，确定交易成功后更新数据库。
                    $this->load->model ( 'charge_mdl', 'charge' );
                    if(in_array($pay_type,array("CHR","ODR","COR","POR"))){
                       $orderId = substr ( $orderId, 3, strlen ( $orderId ) );
                       $charge = $this->charge->load_byChangeNum ( $orderId );
                       $pay_date = str_replace(array("-",":"," "),"",$charge['pay_date']);
                       $data = json_decode($this->Query($orderNo,$pay_date),true);
                    }else{
                        $charge = $this->charge->load_byChangeNum ( $orderId );
                        $pay_date = str_replace(array("-",":"," "),"",$charge['pay_date']);
                        $data = json_decode($this->Query($orderId,$pay_date),true);
                    }
                if(empty( $charge['order_sn'])){//纯充值
                    //status 0交易成功 1交易正在处理或查询超时  2交易失败
                    switch($data['status']){
                        case 0:
                            $data["message"] = "支付成功！";
                            $data["code"] = 1;
                            $data["orderid"] = $charge['id'];
                            break;
                        case 1:
                            $data["message"] = "订单正在处理,请稍后查询！";
                            $data["code"] = 1;
                            $data["orderid"] = $charge['id'];
                            break;
                        case 2:
                            $data["message"] = "支付失败！请与客服联系：400-0029-777";
                            $data["code"] = 0;
                            $data["orderid"] = $charge['id'];
                            break;
                    }
                }else{//订单支付
                    $this->load->model("Order_mdl");
                    switch($data['status']){
                        case 0:
                            $order_info = $this->Order_mdl->load_by_sn( $charge['order_sn']);
                            $data["message"] = "支付成功！";
                            $data["code"] = 1;
                            $data["orderid"] = $order_info['id'];
                            break;
                        case 1:
                            $data["message"] = "订单正在处理,请稍后查询！";
                            $data["code"] = 1;
                            $data["orderid"] = 0;
                            break;
                        case 2:
                            $data["message"] = "支付失败！请与客服联系：400-0029-777";
                            $data["code"] = 0;
                            $data["orderid"] = 0;
                            break;
                    }
                }
                
            
            }else{
                error_log('验签失败');
            }
            $data['title'] = '充值通知';
            $data['foot_set'] = 1;
            $this->load->view ( 'head', $data );
            if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {//h5
                if(empty( $charge['order_sn'])){//纯充值
                    $data ['head_set'] = 3;
                    $this->load->view ( '_header', $data );
                    $this->load->view('property/pay_notify',$data);
                }else{
                    $this->load->model ('order_mdl');
                    $order_info = $this->order_mdl->load_by_sn( $charge['order_sn']);
                    $data['head_set'] = 2;
                    $this->load->view ( '_header', $data );
                    $data['pay_account'] = $order_info['total_price'];
                    $data['order_sn'] = $charge['order_sn'];
                    $data['order_id'] = $order_info['id'];
                    $this->load->view('order/orderfinish', $data);
                }
            }else{
                $data['head_set'] = 3;
                $this->load->view ( '_header', $data );
                if(empty( $charge['order_sn'])){//纯充值
                    $this->load->view('property/pay_notify',$data);
                }else{
                    $this->load->view('property/order_notify',$data);
                }
            }
            $this->load->view ( '_footer', $data );
            $this->load->view ( 'foot', $data );
            
        } else {
            error_log('签名为空');
        }
        
        
       
    }
    
    
    /**
     * 后台异步回调
     * 交易说明：	前台类交易成功才会发送后台通知。后台类交易（有后台通知的接口）交易结束之后成功失败都会发通知。
     *              为保证安全，涉及资金类的交易，收到通知后请再发起查询接口确认交易成功。不涉及资金的交易可以以通知接口respCode=00判断成功。
     *              未收到通知时，查询接口调用时间点请参照此FAQ：https://open.unionpay.com/ajweb/help/faq/list?id=77&level=0&from=0
     */
    public function BackReceive(){
        $logger = com\unionpay\acp\sdk\LogUtil::getLogger();
        $logger->LogInfo("receive front notify: " . com\unionpay\acp\sdk\createLinkString ( $_POST, false, true ));
        
        if (isset ( $_POST ['signature'] )) {
            
                //echo com\unionpay\acp\sdk\AcpService::validate ( $_POST ) ? '验签成功' : '验签失败';
                if(com\unionpay\acp\sdk\AcpService::validate ( $_POST )){
                    $orderNo = $orderId = $_POST ['orderId']; //其他字段也可用类似方式获取
                    $respCode = $_POST ['respCode'];
                    //网银交易号
                    $trade_no = $_POST['traceNo'];
                    $pay_type = substr ( $orderId, 0, 3 );
                    //判断respCode=00、A6后，对涉及资金类的交易，请再发起查询接口查询，确定交易成功后更新数据库。
                    $this->load->model ( 'charge_mdl', 'charge' );
                    if(in_array($pay_type,array("CHR","ODR","COR","POR"))){
                       $orderId = substr ( $orderId, 3, strlen ( $orderId ) );
                       $charge = $this->charge->load_byChangeNum ( $orderId );
                       $pay_date = str_replace(array("-",":"," "),"",$charge['pay_date']);
                       $data = json_decode($this->Query($orderNo,$pay_date),true);
                    }else{
                        $charge = $this->charge->load_byChangeNum ( $orderId );
                        $pay_date = str_replace(array("-",":"," "),"",$charge['pay_date']);
                        $data = json_decode($this->Query($orderId,$pay_date),true);
                    }
                    
                    //status 0交易成功 1交易正在处理或查询超时  2交易失败
                    if($data['status'] == 0 ){
                        $amount = $charge['amount']*100;//单位分
                        if($amount == $data['txnAmt']){
                            if ($pay_type == "ODR") { //拼团订单的
                                $this->after_groupbuy($orderId,$trade_no,$data['queryId']);
                            }else if ($pay_type == "CHR"){ //现金充值 
                                $is_ok = $this->after_pay($orderId,$trade_no,$data['queryId']);
    				        }else if($pay_type =='COR'){ //微信二维码方式的充值
                                $is_ok = $this->after_pay($orderId,$trade_no,$data['queryId']);
                            }else if($pay_type == 'POR'){ //普通订单的 
    				            $is_ok = $this->after_order($orderId,$trade_no,$data['queryId']);
    				        }else{
    				            $is_ok = $this->after_pay($orderId,$trade_no,$data['queryId']);
    				        }
				        }else{
				            error_log('订单金额错误,充值交易失败！');
				            $this->charge_mdl->update_status($orderId,5);
				        }    
                    }
                }else{
                    error_log('验签失败');
                }
                
            } else {
                error_log('签名为空');
            }
       
    }
    
    
    //充值支付成功返回逻辑代码
    private function after_pay($out_trade_no,$trade_no,$queryId){
        $this->load->model("charge_mdl");
        $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
        $user_id = $charge['customer_id'];
        $charge_id = $charge['id'];
        
        //如果该订单状态是未支付的 才执行
        if($charge && $trade_no ){
             
            if($charge['status'] == 1){
                return true; //已经充值过
            }
        
            $this->db->trans_begin(); //事物执行方法中的MODEL。
            	
            // 修改订单状态为已支付
            $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'银联订单号:'.$trade_no ,$queryId);
            $charge_cash = $charge['amount']; //该充值订单的金额
            	
            if( $charge_row )
            {
                //调用接口处理
                $url = $this->url_prefix.'Notify_url/after_pay_charge';
                 
                $data_post['customer_id'] = $user_id;
                $data_post['charge_cash'] = $charge['amount'];
                $data_post['chargeno'] = $charge['chargeno'];
                $data_post['app_id'] =  $this->session->userdata('app_info')['id'];
                $is_ok = $this->curl_post_result($url,$data_post);
                 
                if ($is_ok )
                {
                    $this->db->trans_commit();
                    return true;
                } else {
                    $this->db->trans_rollback();
                    return false;
                }
                 
            }else{
                //该订单可能已支付过
                $this->db->trans_rollback();
                return false;
            }
             
        }else{
            return false;
        }
    }
    //拼团支付返回逻辑
    private function after_groupbuy($out_trade_no, $trade_no,$queryId){
        $this->load->model("charge_mdl");
        //充值订单信息
        $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
        
        $user_id = $charge['customer_id'];
         
        $this->db->trans_begin();
         
        // 修改订单状态为已支付
        $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'银联订单号:'.$trade_no ,$queryId);
         
         
        if($charge_row)
        {
             
            //购物订单信息
            $this->load->model("order_mdl");
            $order_info = $this->order_mdl->load_by_sn($charge['order_sn']);
        
            //改订单状态
            $up_status = $this->order_mdl->order_confirm_paid($order_info['order_sn'], 4);
             
            if($up_status)
            {
                //商品信息
                $this->load->model("product_mdl");
                $product = $this->product_mdl->item_product($order_info['id']);
                 
                //获取该店主信息
                $this->load->model("customer_corporation_mdl");
                $corp_customer = $this->customer_corporation_mdl->corp_load($order_info['corporation_id']);
                $corp_customer_id = $corp_customer['customer_id'];//店主的用户ID
                 
                 
                //插入团
                $this->load->model('groupbuy_mdl');
                 
                // 如果$buy_num为空，一人成团长  给了钱才要的逻辑1/-----
                if (empty($order_info['activity_id']) || $order_info['activity_id'] == 0)
                {
                    $this->groupbuy_mdl->enddate = $product['groupbuy_end_at'];
                    $this->groupbuy_mdl->menber_num = 1;
                    $this->groupbuy_mdl->productid = $product['id'];
                    $this->groupbuy_mdl->head_menber = $user_id;
                    $this->groupbuy_mdl->activity_num = $product['activity_num'];
                    $this->groupbuy_mdl->status = ($product['menber_num'] == 1)?1:0;
                    $buy_num = $this->groupbuy_mdl->create();
                    $is_ok_activity_id = $this->order_mdl->activity_id($order_info['id'],$buy_num);
                    $head_menber = $user_id;
        
                } else {
                    $group = $this->groupbuy_mdl->load_by_buy_num($order_info['activity_id']);
        
                    $group_menber_num = isset($group['menber_num']) ? $group['menber_num'] : 0;
                    // 修改group表status 2  3
                    if ($group_menber_num < $product['menber_num']-1)
                    {
                        $this->groupbuy_mdl->menber_num = $group_menber_num + 1;
                    } else {
                        $this->groupbuy_mdl->menber_num = $group_menber_num + 1;
                        $this->groupbuy_mdl->status = 1;
                    }
                    $buy_num = $this->groupbuy_mdl->update($order_info['activity_id']);
                    $is_ok_activity_id = true;
                    $head_menber = $group['head_menber'];
                }
                 
                 
                if( $buy_num )
                {
                    //调用接口
                    $data_post['user_id'] = $charge['customer_id'];
                    $data_post['order_sn'] = $order_info['order_sn'];
                    $data_post['total_price'] = $order_info['total_price'];
                    $data_post['charge_cash'] = $charge['amount']; //该充值订单的金额
                    $data_post['chargeno'] = $charge['chargeno'];
                    $data_post['corp_customer_id'] = $corp_customer_id;
                    $data_post['app_id'] = $order_info['app_id'];
                    $url = $this->url_prefix.'Notify_url/after_pay_groupby';
                     
                    $error = json_decode($this->curl_post_result($url,$data_post),true);
                     
                    if($error['status'] == 1)
                    {
                        $this->db->trans_commit();
                        echo 'success';
                        $is_ok = true;
        
                        //支付成功,插入支付成功信息
                        $this->load->model('Customer_message_mdl',"Message");
                        $this->load->model('Customer_mdl');
                        $customer_info = $this->Customer_mdl->load( $charge['customer_id'] );
                        //模板
                        $Msg_info['template_id']= 6;
                        //标题
                        $Msg_info['customer_id']= $charge['customer_id'];
                        $Msg_info['obj_id'] = $order_info['id'];
                        $Msg_info['type'] = 2;
                        $Msg_info['parameter']['name'] = !empty($customer_info['nick_name']) ? $customer_info['nick_name'] : $customer_info['name'];
                        $Msg_info['parameter']['number'] = $order_info['order_sn'];
                        $this->Message->Create_Message($Msg_info);
        
                         
                    }else if( $error['status'] == 2)
                    {
                         
                        $this->db->trans_rollback();
                        //调用充值方法。
                        $this->after_pay($out_trade_no,$trade_no,$charge['amount']);
                        return ;
                    }
                }
            }
        }else{
            //该订单可能已支付过
            $this->db->trans_rollback();
            return false;
        }
         
        if( empty($is_ok) )
        {
            $this->db->trans_rollback();
        }
    }
    private function after_order( $out_trade_no, $trade_no,$queryId){
        $this->load->model("charge_mdl");
        $this->load->helper ( 'order' );
        $is_ok =  false;//成功与否标示
        //充值订单信息
        $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
     
        $this->db->trans_begin(); //事物执行方法中的MODEL。
        
        // 修改充值订单状态为已支付
        $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'银联订单号:'.$trade_no,$queryId );
        
        //如果该订单状态修改成功 才执行
        if($charge_row)
        {
            //订单信息
            $this->load->model('order_mdl');
            $order_info = $this->order_mdl->load_by_sn($charge['order_sn']);
           
            if( $order_info )
            {
                //商家信息
                $this->load->model('customer_corporation_mdl');
                $corp_customer = $this->customer_corporation_mdl->corp_load($order_info['corporation_id']);
                 
                if( $corp_customer )
                {
                     
                    //修改订单状态
                    $change_status = $order_info['status']  == 10 ? 14 : 4;
                    //是否修改支付时间
                    $pay_time = $order_info['status']  == 10 ? true : null;
                     
                    $up_status = $this->order_mdl->order_confirm_paid( $order_info['order_sn'], $change_status,$pay_time );
                     
                    if($up_status)
                    {
                        //构造数据调用接口处理
                        $data_post['customer_id'] = $charge['customer_id'];
                        $data_post['charge_cash'] = $charge['amount'];
                        $data_post['app_id'] =  0;
                        $data_post['chargeno'] = $charge['chargeno'];
                        $data_post['order_total_price'] =  $order_info['total_price'];
                        $data_post['corp_customer_id'] =  $corp_customer['customer_id'];
                        $data_post['order_sn'] = $order_info['order_sn'];
                        $data_post['commission'] = $order_info['commission'];
                        $data_post['app_id'] = $order_info['app_id'];
                        $data_post['charge_commission'] = $charge['commission'];
                         
                         
                        if( $change_status == 14 )
                        {
                            $url = $this->url_prefix.'Notify_url/code_pay_order';
                            $this->load->model('order_rebate_mdl');
                            $rebate = $this->order_rebate_mdl->order_rebate( $order_info );
                        }else{
                            $url = $this->url_prefix.'Notify_url/after_pay_order';
                            $rebate = true;
                        }
                         
        
                        if( $rebate )
                        {
                            $error = json_decode($this->curl_post_result($url,$data_post),true);
                            //调用接口处理吧，骚年。
                             
                            if($error['status'] == 1)
                            {
                                $this->db->trans_commit();
                                echo 'success';
                                $is_ok = true;
                                 
                                //支付成功,插入支付成功信息
                                $this->load->model('Customer_message_mdl',"Message");
                                $this->load->model('Customer_mdl');
                                $customer_info = $this->Customer_mdl->load( $charge['customer_id'] );
                                //模板
                                $Msg_info['template_id']= 6;
                                //标题
                                $Msg_info['customer_id']= $charge['customer_id'];
                                $Msg_info['obj_id'] = $order_info['id'];
                                $Msg_info['type'] = 2;
                                $Msg_info['parameter']['name'] = !empty($customer_info['nick_name']) ? $customer_info['nick_name'] : $customer_info['name'];
                                $Msg_info['parameter']['number'] = $order_info['order_sn'];
                                $this->Message->Create_Message($Msg_info);
                                 
                                 
                            }else if( $error['status'] == 2)
                            {
                                 
                                $this->db->trans_rollback();
                                //调用充值方法。
                                $this->after_pay($out_trade_no,$trade_no,$charge['amount']);
                                return;
                            }
                        }
                    }
                }
            }
        }else{
            //该订单可能已支付过
            $this->db->trans_rollback();
            return false;
        }
        
        //判断流程是否完成
        if(empty($is_ok) )
        {
            $this->db->trans_rollback();
             
        }
         
         
    }
}