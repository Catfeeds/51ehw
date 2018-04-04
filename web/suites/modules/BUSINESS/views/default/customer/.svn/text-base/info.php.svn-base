<style>
  .gerenzhongxin_01_con{ width:670px ;}
  .gerenzhongxin_01_con_right{ width:auto;}
  .gerenzhongixn_01_btn{ width:172px;}
</style>
<div class="Box member_Box clearfix">
	<div class="kehu_Left">
		<ul class="kehu_Left_ul">
			<li class="kehu_title"><a>个人中心</a></li>
			<li class="kehu_current"><a
				href="<?php echo site_url('member/info')?>">个人信息</a></li>
			<li><a href="<?php echo site_url('member/property/get_list');?>">我的资产</a></li>
			<!-- <li><a href="<?php echo site_url('corporate/card_package/my_package')?>">我的优惠劵</a></li> -->
			<li><a href="<?php echo site_url('member/address')?>">收货地址</a></li>
           <li><a href="<?php echo site_url('member/save_set') ?>">安全设置</a></li>
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
			<!--<li><a href="javascript:;">分红结算</a></li>-->
		</ul>
		<ul>
			<li class="kehu_title"><a>客户服务</a></li>
			<li><a href="<?php echo site_url('Member/Message')?>">消息提醒</a></li>
			<li><a href="<?php echo site_url('member/complain')?>">投诉维权</a></li>
			<!-- <li><a href="<?php echo site_url('member/faq')?>">常见问题</a></li>-->
			<!--<li><a href="javascript:;">在线客服</a></li>-->
			<!-- <li><a href="<?php echo site_url('member/return_repair')?>">返修退换货</a></li>-->
		</ul>
	    <ul>
		<li class="kehu_title"><a>需求管理</a></li>
		<li ><a href="<?php echo site_url("member/demand/add_list");?>">我要发布</a></li>
		<li ><a href="<?php echo site_url("member/demand");?>">我的需求</a></li>
		<!-- <li><a href="javascript:void(0);">我的报价</a></li> -->
	    </ul>
	</div>

	<div class="huankuan_cmRight">
		<div class="huankuan_rTop">个人信息</div>
		<div class="gerenzhongxin_01_con clearfix">
			<div class="gerenzhongxin_01_con_left">
				<ul>
					<li>用户等级：</li>
					<li>会员账号：</li>
					<li>昵称：</li>
					<li>性别：</li>
					<li>生日：</li>
					<li>职业：</li>
					<li>电子邮件：</li>
					<li>真实姓名：</li>
					<li><span>*</span>手机号码：</li>
					<li>固定电话：</li>
				</ul>
			</div>

			<div class="gerenzhongxin_01_con_right">
				<ul>
					<li><?php echo $customer['is_vip']?'VIP用户':'普通用户';?></li>
					<li><?php echo $customer['name'];?></li>
					<li><?php echo $customer['nick_name'];?></li>
					<li><?php
    if ($customer['sex'] === NULL) {
        echo '未选择';
    } else {
        switch ((int) $customer['sex']) {
            case 0:
                echo '女';
                break;
            case 1:
                echo '男';
                break;
            default:
                echo '未选择';
                break;
        }
    }
    ?></li>
					<li><?php echo substr($customer['birthday'],0,11);?></li>
					<li><?php echo $customer['job'];?></li>
					<li><?php echo $customer['email'];?></li>
					<li><?php echo $customer['real_name'];?></li>
					<li><?php echo $customer['mobile'];?><?php echo $customer['mobile']!=null?'<a href="'.site_url('member/save_set/change_mobile') .'" class="saveSet_m">更换手机</a>':'<a href="'.site_url('member/save_set/set_mobile').'" class="saveSet_m">绑定手机</a>' ?></li>
					<li><?php echo $customer['phone'];?></li>
				</ul>
			</div>
		</div>
		<div class="gerenzhongixn_01_btn">

			<div class="gerenzhongxin_01_btn01" style="margin-right: 0">
				<a href="<?php echo site_url('member/info/info_edit');?>">修改个人资料</a>
			</div>
		</div>

	</div>



</div>


