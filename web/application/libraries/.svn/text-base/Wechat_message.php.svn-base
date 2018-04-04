<?php

/**
 * 
 * @author js-php-01 ming
 * date:2016-10-31
 * 微信模板发送消息类。
 * 说明：openid用户必须关注推送的公众号
 */
class Wechat_message  {
    
    public  $app_id;
    public  $appsecret;
    public  $access_token;
    public  $template_id;
    public  $openid;
    public  $status;
    public  $web_url;
    
    public function __construct() {
       
       
    }
  
    //传输
    public function http_request($url,$data=array() ){
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
        
        if(!empty($data)){
            // 我们在POST数据哦！
            curl_setopt($ch,CURLOPT_POST, 1);
            // 把post的变量加上
            curl_setopt($ch,CURLOPT_POSTFIELDS ,$data);
        }
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output,true);
    }
    
    //发送
    public function sendtpl_msg( $detail_url,$data ){
        $json_token = $this->http_request("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->app_id."&secret=".$this->appsecret,array() );
      
        //获得access_token
        $this->access_token = $json_token['access_token'];
        
        $this->choose_template(); //选择模板
        
        //模板消息
        $template = array(
            'touser'=>$this->openid, //openid om5sywNxVRv-04R1g2Jsgowf0x_U   om5sywPYcwBS4h-3n2D1ZAS8A9e0
            'template_id'=>$this->template_id, //模板id
            'url'=>$detail_url,
            'topcolor'=>"#7B68EE",
            'data' => $data,
            
        );
        
        $json_template =json_encode($template);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->access_token;
        $res = $this->http_request( $url,urldecode($json_template) );
        return $res;
        
//         if ($res['errcode'] == 0) // 0成功
//             return true;
    }
    
    //选择模板
    private function choose_template(){ 
        
        $urls = array(
            'http://test51ehw.9-leaf.com/',
            'https://test51ehw.9-leaf.com/',
            'http://www.test51ehw.com/',
            'https://www.test51ehw.com/',
        );
        if( in_array($this->web_url,$urls)) //测试服务器
            $status = true;
        
        switch ( $this->status ){
        
            case 1:
                $this->template_id = isset($status) ? 'bIylaC_x8VgdWigZllEeDHjzbdkMmTbg8SIfeGcvtaI' : 'JvFCMbr0qirAmofpCDobgzoX7wzpQnUH8R-GPUp_-qs';//充值模板
                break;
            case 2:
                $this->template_id = isset($status) ? '3V0rupKz03bppnEICjsF48OOFhuafsh2Y4WEPisH6jc' : 'XRms-OYUNdjn9EmdmLO7fsOyDhKt2RvfKamGK2_I0ac';//消费模板
                break;
            case 3:
                $this->template_id = isset($status) ? '88sdckUM3cPQvMCEQCOhVfKrDo3SdPIw5bEIH73qo9c' : 'TwrWDN4RFUKLZDV9Y8kIM7NCQCPxXNEEWVBTHN7Ae7o';//收入提醒
                break;
            case 4:
                $this->template_id = isset($status) ? 'UfjzZly7A8Nv9PEygpAM_-xfOq4NwxzcMwV3riwMqIc' : '4GFjETjI9QhntY0kr5QRKq6VU0hnyRq_zFQ4BYVNS_g';// 当绑定上线,后者正式
        }
    }
    
    /**
     * 消费模板ID = 3V0rupKz03bppnEICjsF48OOFhuafsh2Y4WEPisH6jc
     *
     * 数据样式
     * 
     * 	   $data = array(
            'first'=>array('value'=>urlencode("尊敬的客户：您的五一易货网账户发生了一笔消费支出，请确认是否是您本人消费。"),'color'=>"#000000"),
            'keyword1'=>array('value'=>urlencode("66666"),'color'=>'#000000'),
            'keyword2'=>array('value'=>urlencode('100 M券'),'color'=>'#000000'),
            'keyword3'=>array('value'=>urlencode('五一易货网'),'color'=>'#000000'),
            'keyword4'=>array('value'=>urlencode('13556631620'),'color'=>'#000000'),
            'keyword5'=>array('value'=>urlencode(date('Y-m-d H:i:s') ),'color'=>'#000000'),
            'remark' => array('value'=>urlencode('M券余额：123\n亲，如您在购物体验中遇到疑问请联系客服。'),'color'=>'#000000')
         );
    
    */
    
    /**
     * 充值到账模板ID = bIylaC_x8VgdWigZllEeDHjzbdkMmTbg8SIfeGcvtaI
     *
     * 数据样式
     *
     * $data = array(
         'first'=>array('value'=>urlencode("您好，M券已成功充值到账。"),'color'=>"#000000"),
         'keyword1'=>array('value'=>urlencode("13556631620"),'color'=>'#000000'),
         'keyword2'=>array('value'=>urlencode('100 M券'),'color'=>'#000000'),
         'keyword3'=>array('value'=>urlencode('五一易货网现金余额'),'color'=>'#000000'),
         'keyword4'=>array('value'=>urlencode( date('Y-m-d H:i:s') ),'color'=>'#000000'),
         'remark' => array('value'=>urlencode('M券余额：123\n感谢你的使用。'),'color'=>'#000000')
     );
    
     */
    
    /**
     * 收入模板ID = 88sdckUM3cPQvMCEQCOhVfKrDo3SdPIw5bEIH73qo9c
     *
     * 数据样式
     *
        {{first.DATA}}
        收入金额：{{keyword1.DATA}}
        收入类型：{{keyword2.DATA}}
        交易号：{{keyword3.DATA}}
        到帐时间：{{keyword4.DATA}}
        {{remark.DATA}}
    
     */
}

?>