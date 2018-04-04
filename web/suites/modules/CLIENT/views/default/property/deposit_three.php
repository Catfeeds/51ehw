
    <div class="gouwuche_box">
    	<div class="gouwuche_box_top">充值</div>
        <div class="gouwuche_box_top2">
        	<ul>
            	<li><a href="javascript:;">1. 选择支付方式</a></li>
                <li><span>></span></li>
                <li><a href="javascript:;">2. 核对支付信息</a></li>
                <li><span>></span></li>
                <li class="dingdan2_current dingdan2_li"><a href="javascript:;">3.支付结果信息</a></li>      
            </ul>
        </div>
        <div class="dingdan3_con chongzhi02_con">
        	<h4 class="chongzhi02_h4">您已申请账户余额充值，请立即在线支付！</h4>
            <span class="chongzhi02_span01">充值单号：<?php echo isset($detail['chargeno'])?$detail['chargeno']:'' ?></span>
            <span>应付金额：<?php echo isset($detail['amount'])?$detail['amount']:'' ?>元</span>
            <p class="chongzhi_03_p01">立即支付<?php echo isset($detail['amount'])?$detail['amount']:'' ?>元，即可完成订单。 请您在24小时内完成支付，否则订单会被自动取消。</p>
        </div>
		
        <!--内容-->
      <div class="chongzhi_03_con01">
        	<span>您已选择的支付方式：    储蓄卡</span>
            <span class="chongzhi_03_con01_span"><a href="<?php echo site_url('member/property/deposit_two/'.$detail['id']) ?>">重新选择</a></span>
            <div class="chongzhi_03_con01_img"><img src="images/dingdan4_2_04.jpg" width="173" height="38" alt=""/></div>
            <div class="chongzhi_03_con01_con">
            	<div class="chongzhi_03_con01_con1">
                	<ul>
                    	<li>单笔限额</li>
                        <li>每日限额</li>
                        <li style="width:312px">需满足条件</li>
                        <li style="width:596px">备注</li>
                    </ul>
                </div>
                <div class="chongzhi_03_con01_con2">
                	<ul>
                    	<li style="border-bottom: 1px solid #e1e1e1;">500</li>
                        <li style="border-bottom: 1px solid #e1e1e1;">1000</li>
                        <li style="width:311px;border-bottom: 1px solid #e1e1e1;">电子口令卡-未开通手机验证</li>
                        <li style="width:596px; border-right:0"></li>
                    </ul>
                </div>
                
                <div class="chongzhi_03_con01_con2">
                	<ul>
                    	<li style="border-bottom: 1px solid #e1e1e1;">500</li>
                        <li style="border-bottom: 1px solid #e1e1e1;">1000</li>
                        <li style="width:311px;border-bottom: 1px solid #e1e1e1;">电子口令卡-开通手机验证</li>
                        <li style="width:596px; border-right:0">实际支付限额以在银行设置为准，工行热线95588</li>
                    </ul>
                </div>
                
                <div class="chongzhi_03_con01_con2">
                	<ul>
                    	<li>无限额</li>
                        <li>无限额</li>
                        <li style="width:311px">U盾用户</li>
                        <li style="width:596px; border-right:0"></li>
                    </ul>
                </div>
            </div>
        </div>
            
            <div class="dingdan3_btn"><a href="<?php echo site_url('member/property/deposit_four/'.$detail['id'])?>">立即充值</a></div>
            <div class="chongzhi_03_2_con">
            	<p>温馨提示：</p>
                <p>1.网银银行页面打不开，怎么办？</p>
                <p>-建议使用IE核心的浏览器，点击IE的菜单“工具”－“Internet选项”－“安全”，将安全中的各项设置恢复到默认级别。</p><br>
                <p>2.我的银行卡未开通网上支付功能，怎么办？</p>
                <p>-登录该银行卡的网上银行主页，在线开通网上支付功能，有些银行开通需要到银行柜台，您最好致电该银行客服咨询。</p><br>
                <p>3.我的订单金额超过该银行支付限额怎么办？</p>
                <p>-如您使用的是京东支持快捷支付的银行卡，建议您使用快捷支付，快捷支付信用卡的支付限额是信用卡额度本身。</p>
                <p>-如暂不支持您的银行卡开通快捷支付，您可以使用银联在线支付平台，银联在线的认证支付对支付限额限制较少，支持</p>
            </div>
       
           
        </div>
	<!--弹窗开始-->
	<!--<div class="dingdan4_3_tanchuang" style="display:block">
      <div class="dingdan4_3_tanchuang_con">
          <div class="dingdan4_3_tanchuang_top">请您在新打开的网上银行页面完成付款</div>
          <div class="dingdan4_3_tanchuang_top2">
              <p>付款完成前请不要关闭此窗口</p>
              <p>请您在新打开的网上银行页面进行支付，支付完成前请不要关闭该窗口</p>
              <p><a href="#">返回重新选择银行</a></p>
          </div>
          <div class="dingdan4_3_tanchuang_btn">
              <div class="dingdan4_3_btn01"><a href="#">已完成支付</a></div>
              <div class="dingdan4_3_btn02"><a href="#">支付遇到问题</a></div>
          </div>
          
      </div>
	</div>-->
     <!--弹窗结束-->

