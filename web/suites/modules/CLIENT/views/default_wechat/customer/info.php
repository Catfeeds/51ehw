

<div class="page clearfix">

	<div class="member_box">
		<div class="member_head">
			<img src="<?php echo !$this->session->userdata('img_avatar')?$customer['img_avatar']:$this->session->userdata('img_avatar'); ?>" width="57" height="57" onerror="this.src='images/default_img_s.jpg'">
			<div class="right_note">
				<p class="notice_word_big align_left">
					<?php echo !$this->session->userdata('nick_name')?$this->session->userdata('user_name'):$this->session->userdata('nick_name');?>
				</p>
				<p class="notice_word_mid">
					货豆: <span class="red_font"><?php echo number_format( (isset($customer['M_credit']) ? $customer['M_credit'] : '0') + (isset($customer['credit']) ? $customer['credit'] : '0'),2 )?>货豆</span>
				</p>
				<p class="notice_word_mid">
					现金: <span class="red_font"><?php echo $customer['cash'] !== NULL?number_format($customer['cash'],2):'0.00';?>元</span>
				</p>
			</div>
		</div>

		<div class="member_head_list01" style="text-align:center;">
			<ul>
			    <li style="width:45%;"><a href="<?php echo site_url('member/fav')?>" style="font-size: 18px;">
			    	<span class="fn-left" style="padding-right: 10px;"><em class="icon-favor"></em></span></span>我的收藏</a>
			    </li>
				<li style="width:45%;"><a href="<?php echo site_url('member/browsing_history/getList')?>" style="font-size: 18px;">
					<span class="fn-left" style="padding-right: 10px;"><em class="icon-liulan"></em></span></span>浏览记录</a>
				</li>
		    </ul>
		</div>


		<ul class="member_head_list clearfix" style="margin-bottom: 50px;">
			<?php if($branch){?>
			      <li><a href="<?php echo site_url('corporate/branch/branch_list');?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-wenzhang"></em></span>
						<span class="fn-right red"><em class="icon-right c9"></em></span>我的分店</a></li>
			<?php } ?>
			<li><a href="<?php echo site_url('member/order')?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-form"></em></span>
			<span class="fn-right red"><?php echo $count_unfinished_orders;?><em class="icon-right c9"></em></span>我的订单</a></li>
			<li><a href="<?php echo site_url('customer/fortune')?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-recharge"></em></span>
			<span class="fn-right"><em class="icon-right c9"></em></span>我的资产</a></li>
			<?php if($shop){ ?>
		    <li><a href="<?php echo site_url('article')?>"><span class="fn-left " style="padding-right: 10px;font-size: 18px;"><em class="icon-wenzhang"></em></span>
		    <span class="fn-right"><em class="icon-right c9"></em></span>互助店好文分享</a></li>
			<?php }?>
			<!--<li><a href="<?php echo site_url('customer/invite')?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-qrcode"></em></span>
			<span class="fn-right"><em class="icon-right c9"></em></span>我的二维码</a></li>-->
			<li><a href="<?php echo site_url('member/address')?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-dingwei1"></em></span>
			<span class="fn-right"><em class="icon-right c9"></em></span>收货地址</a></li>
			<li><a href="<?php echo site_url("corporate/card_package/my_package");?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-qianbao"></em></span>
			<span class="fn-right"><em class="icon-right c9"></em></span>我的货包</a></li>
			<li><a href="<?php echo site_url('corporate/card_package/package')?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-shouhuo"></em></span>
			<span class="fn-right"><em class="icon-right c9"></em></span>领取货包</a></li>
			<li><a href="<?php echo site_url('corporate/card_package/accredit')?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-fahuo"></em></span>
			<span class="fn-right"><em class="icon-right c9"></em></span>发送货包</a></li>
			<li><a href="<?php echo site_url('customer/safety_setting');?>"><span class="fn-left " style="padding-right: 10px;font-size: 18px;"><em class="icon-settings"></em></span>
			<span class="fn-right"><em class="icon-right c9"></em></span>设置</a></li>
			<!--<li><a href="<?php echo site_url('verification/verification_service');?>"><span class="fn-left " style="padding-right: 10px;font-size: 18px;"><em class="icon-my_hexiao_service"></em></span>
			<span class="fn-right"><em class="icon-right c9"></em></span>核销服务</a></li>-->
			<!-- <li><a href="<?php echo site_url('member/requirement/needs_manage')?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-dingdanyiwancheng3"></em></span>
			<span class="fn-right"><em class="icon-right c9"></em></span>需求管理</a></li> -->
			<!--<li class="hehuoren-i5" style="border-top: 10px solid #f2f2f2;height: 50px;"><a href="<?php echo site_url('Agent/home/login')?>"><span class="fn-left "style="padding-right: 10px;font-size: 18px;"><em class="icon-people"></em></span>
			</span>合伙人登录</a></li>-->
		</ul>
	</div>
	<!-- 底部版本说明 -->
	<div class="member_footer">
		<!-- <span style="padding-top: 15px;display: inline-block;">当前版本号：v2.0.1</span><br> -->
		<span style="padding-top: 30px;display: inline-block;">客服热线：400-0029-777</span>
	</div>
	<!--member-box end-->
	
</div>


<style type="text/css">
.member_footer {
	height: 55px;
}

.container {
	background-color: #f2f2f2;
}

@media screen and (max-width:320px) {
	.member_footer {
		height: 35px !important;
	}
	.member_footer span {
		padding-top: 9px !important;
	}
	.hehuoren-i5 {
		border-bottom: 66px solid #f2f2f2 !important;
		padding-bottom: 40px;
	}
}
</style>