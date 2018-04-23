
<div class="Box member_Box clearfix">
	<div class="kehu_Left">
		<ul class="kehu_Left_ul">
			<li class="kehu_title"><a>个人中心</a></li>
			<li><a href="<?php echo site_url('member/info')?>">个人信息</a></li>
			<li><a href="<?php echo site_url('member/property/get_list')?>">我的资产</a></li>
			<!-- <li><a href="<?php echo site_url('corporate/card_package/my_package')?>">我的优惠劵</a></li> -->
			<li><a href="<?php echo site_url('member/address')?>">收货地址</a></li>
			<li class="kehu_current"><a
				href="<?php echo site_url('member/save_set') ?>">安全设置</a></li>
		</ul>
		<ul>
			<li class="kehu_title"><a>订单中心 </a></li>
			<li><a href="<?php echo site_url('member/order')?>">我的订单</a></li>
			<li><a href="<?php echo site_url('member/fav')?>">我的收藏</a></li>
			<li><a href="<?php echo site_url('member/my_comment/get_list/')?>">我的评价</a></li>
		</ul>
		<ul>
			<li class="kehu_title"><a>客户中心</a></li>
			<li><a href="<?php echo site_url('customer/invite')?>">邀请客户</a></li>
			<li><a href="<?php echo site_url('customer/customerdata')?>">我的客户</a></li>
		</ul>
		<ul>
			<li class="kehu_title"><a>客户服务</a></li>
			<li><a href="<?php echo site_url('Member/Message')?>">消息提醒</a></li>
			<li><a href="<?php echo site_url('member/complain')?>">投诉维权</a></li>
		</ul>
	    <ul>
		<li class="kehu_title"><a>需求管理</a></li>
		<li ><a href="<?php echo site_url("member/demand/add_list");?>">我要发布</a></li>
		<li ><a href="<?php echo site_url("member/demand");?>">我的需求</a></li>
		<!-- <li><a href="javascript:void(0);">我的报价</a></li> -->
	    </ul>
	</div>

	<div class="huankuan_cmRight">
		<div class="huankuan_rTop">安全设置</div>
		<!--首次修改支付密码 开始-->
		<div class="saveSet">
			<p>
			    <i class="icon-yirenzheng"></i>
				<span class="saveSet_n">登录密码</span> <span class="saveSet_t">＊登录51账号时需要输入的密码</span>
				<a href="<?php echo site_url('member/info/pwd_edit') ?>"
					class="saveSet_m saveSet_a">修改</a>
			</p>
			<p> 
			   <?php if(count($pay_account)>0&&isset($pay_account['pay_passwd'])&&$pay_account['pay_passwd']!=null): ?>
			    <i class="icon-yirenzheng"></i>
			     <?php else: ?>
			     <i class="icon-weirenzheng"></i>
			     <?php endif; ?>
				<span class="saveSet_n">支付密码</span> <span class="saveSet_t">＊在账户资金变动及更改账户信息时需要输入的密码</span>
                <?php if(count($pay_account)>0&&isset($pay_account['pay_passwd'])&&$pay_account['pay_passwd']!=null): ?>
                <a
					href="<?php echo site_url('member/save_set/paypwd_update') ?>"
					class="saveSet_m saveSet_a">修改</a>
                <?php else: ?>
                <a
					href="<?php echo site_url('member/save_set/paypwd_set') ?>"
					class="saveSet_m saveSet_b">立即启用</a>
                <?php endif; ?>
            </p>
			<p>
			    <i class="icon-yirenzheng"></i>
				<span class="saveSet_n">绑定手机号</span> <span class="saveSet_t"
					style="color: #999;"><?php echo isset($customer['mobile'])&&$customer['mobile']!=null?"＊您绑定的手机号为".substr_replace($customer['mobile'],'* * * *',3,4):"您暂未绑定手机，请绑定" ?></span>
               <?php if(isset($customer['mobile'])&&$customer['mobile']!=null): ?>
                <a
					href="<?php echo site_url('member/save_set/change_mobile') ?>"
					class="saveSet_m saveSet_a">修改</a>
               <?php else: $this->session->set_userdata('mobile',1); $this->session->set_userdata('binding_mobile',1);?>
                <a
					href="<?php echo site_url('member/save_set/set_mobile') ?>"
					class="saveSet_m saveSet_a">绑定手机</a>
               <?php endif; ?>
            </p>
            <!--
            <p class="saveSet_p">
                <i class="<?php echo  $idcard ? "icon-yirenzheng":"icon-weirenzheng";?>"></i>
				<span class="saveSet_n">实名认证</span> <span class="saveSet_t">实名认证后，可通过实名信息找回支付密码，修改手机号等，提高账户安全性</span>
				<a href="<?php echo site_url("Member/info/AuthenticationView");?>"class="<?php echo  $idcard ? "saveSet_m saveSet_a":"saveSet_m saveSet_b";?>"><?php echo  $idcard ? "查看":"立即认证";?></a>
			</p>-->
		</div>
		<!--首次修改支付密码 结束-->
	</div>



</div>

